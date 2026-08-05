<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
$Log = "paypal2";
if (isset($g)) {
    $GATEWAY = loadGatewayModule($g);
    $Log = $g;
} else {
    $GATEWAY = loadGatewayModule("paypal2");
}
$GATEWAY2 = loadGatewayModule("paypal");
if (!$GATEWAY["email"]) {
    $GATEWAY = loadGatewayModule("paypal");
}
$postipn = "cmd=_notify-validate";
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
    $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
}
if (!$GATEWAY["forceshippingadd"] && stripos($postipn, "sandbox") !== false) {
    logTransaction($Log, $orgipn, "Sandbox Not Allowed");
    exit;
}
logTransaction($Log, $postipn, "Received", "", "", $_POST[custom]);
if ($GATEWAY["forceshippingadd"]) {
    $_paypal_link = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
} else {
    $_paypal_link = "https://ipnpb.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($_paypal_link);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postipn);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Connection: Close"]);
$reply = curl_exec($ch);
curl_close($ch);
if ($reply) {
    $txn_id = $_POST["txn_id"];
    $idnumber = $_POST["custom"];
    $payment_status = $_POST["payment_status"];
    $payer_status = $_POST["payer_status"];
    $payer_email = $_POST["payer_email"];
    $IsAggregator = false;
    $IsWallet = false;
    $aggregatordata = explode("_", $idnumber);
    if ($aggregatordata[0] == "A" && 0 < $aggregatordata[1] && $aggregatordata[2]) {
        $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
        $aggretran = mysqli_fetch_assoc($aggretran);
        if ($aggretran["aggregatortransid"]) {
            $idnumber = $aggregatordata[1];
            $IsAggregator = true;
        }
    }
    logTransaction($Log, $orgipn, "Berore " . $aggregatordata[1]);
    if ($aggregatordata[0] == "B" && 0 < $aggregatordata[1]) {
        $idnumber = $aggregatordata[1];
        $IsWallet = true;
    }
    logTransaction($Log, $orgipn, "ID numb " . $idnumber);
    $txn_type = $_POST["txn_type"];
    $VerifiedEmail = [];
    $Inv = mysqli_fetch_assoc(dquery("select (paypalaccount from tblUsers where tblUsers.id=userid) as \r\npaypalac from tbl_invoices where id='" . $idnumber . "'"));
    if (trim($Inv["paypalac"])) {
        $VerifiedEmail = json_decode($Inv["paypalac"], true);
    }
    if (!in_array($payer_email, $VerifiedEmail)) {
        if (stripos($payment_status, "Completed") !== false) {
            if (!$config["directunverified"] && stripos($payer_status, "unverified") !== false) {
                include_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage = "Payment received #" . $idnumber . ".\r\n                <br /> But this payer (" . $_POST["payer_email"] . ") is unverified so please review transaction (" . $txn_id . ").";
                sendNotification("account", "Unverified transaction   [" . $txn_id . "]", $adminmessage, "");
                logTransaction($Log, $orgipn, "Payer Unverified ");
                exit;
            }
            if ($txn_type != "web_accept") {
                logTransaction($Log, $orgipn, "Wrong Transaction Type " . $txn_type);
                exit;
            }
        } else {
            logTransaction($Log, $orgipn, "Payment Status " . $payment_status);
        }
    } else {
        logTransaction($Log, $orgipn, "White List Email " . $payment_status);
    }
    $TmpInvoiceNo = $_POST["custom"];
    if (!$_POST["txn_id"]) {
        logTransaction($Log, $orgipn, "No txn found again");
        exit;
    }
    if (mysqli_num_rows(dquery("SELECT * FROM tbl_transaction WHERE  transid LIKE '%" . $_POST["txn_id"] . "%'"))) {
        logTransaction($Log, $orgipn, "txn found again");
        exit;
    }
    if ($_POST["parent_txn_id"] && mysqli_num_rows(dquery("SELECT * FROM tbl_transaction WHERE  transid LIKE '%" . $_POST["parent_txn_id"] . "%'"))) {
        logTransaction($Log, $orgipn, "txn found again");
        exit;
    }
    $payment_status = $_POST["payment_status"];
    $subscr_id = $_POST["subscr_id"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_fee"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $business = $_POST["business"];
    $payer_email = $_POST["payer_email"];
    if ($IsWallet) {
        $invoiceid = $idnumber;
    } else {
        if ($IsAggregator) {
            $invoiceid = $idnumber;
        } else {
            $idnumber = $_POST["custom"];
        }
    }
    if (strtolower(trim($business)) != strtolower(trim($GATEWAY["email"])) && strtolower(trim($business)) != strtolower(trim($GATEWAY2["email"]))) {
        logTransaction("paypal 2", $orgipn, "Wrong Business Email", "invoice", $TmpInvoiceNo);
        exit;
    }
    if (!is_numeric($idnumber)) {
        $idnumber = "";
    }
    if (!$IsAggregator && !$IsWallet && $idnumber) {
        $result = select_query("tbl_invoices", "", ["id" => $idnumber]);
        $data = mysqli_fetch_assoc($result);
        $invoiceid = $data["id"];
        $userid = $data["userid"];
    }
    if ($invoiceid) {
        $result = select_query("tbl_currencies", "", ["code" => $paypalcurrency]);
        $data = mysqli_fetch_assoc($result);
        $paypalcurrencyid = $data["id"];
        $currencyconvrate = $data["rate"];
        if (!$paypalcurrencyid) {
            logTransaction($Log, $orgipn, "Unrecognised Currency", "invoice", $TmpInvoiceNo);
            exit;
        }
        $currency = getCurrency("", $userid);
        dquery("update tbl_invoices set businessid='" . $business . "'\r\n    where id='" . $invoiceid . "'");
        if ($paypalcurrencyid != $currency["id"]) {
            $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
            $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
            $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
            $data = mysqli_fetch_assoc($result);
            $total = round($data["total"], 2);
            if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                $mc_gross = $total;
            }
        }
        $PaidAmount = $mc_gross;
        if ($IsWallet) {
            $INVOSI = explode("_", $invoiceid);
            $Gateway = loadGatewayModule("rakbankpay");
            $Wallet = mysqli_fetch_assoc(dquery("select fee,amount from tblWalletTransaction \r\nwhere transid='" . $INVOSI[1] . "'"));
            $Fee = $Wallet["fee"];
            $PaidAmount = round($PaidAmount, 2);
            if (0 < $Fee) {
                $PaidAmount = $PaidAmount - $Fee;
            }
            if ($Wallet["amount"] <= $PaidAmount) {
                walletTransaction($txn_id, $INVOSI[1], $PaidAmount, $Fee, $Gateway["name"]);
                logTransaction($Log, $orgipn, "Wallet Paid", "invoice", $TmpInvoiceNo);
            } else {
                dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $INVOSI[1] . "'");
                logTransaction("rakbankpay", $params, "Transaction Less Amount", "invoice", $invoiceid);
                include_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $INVOSI[1] . " <br />";
                $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                $adminmessage .= "Amount : " . $PaidAmount;
                sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
            }
        } else {
            if ($IsAggregator) {
                aggregatorTransaction($Log, $mc_gross, $paypalcurrency, $txn_id, $idnumber);
                logTransaction($Log, $orgipn, "Aggregator Transaction Paid", "invoice", $TmpInvoiceNo);
            } else {
                addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "paypal", 1, "", "", $payer_email);
                logTransaction($Log, $orgipn, "Successful", "invoice", $TmpInvoiceNo);
            }
        }
        exit;
    }
    logTransaction($Log, $orgipn, "Invalid Invoice ID =" . $invoiceid . "-" . $idnumber, "invoice", $TmpInvoiceNo);
} else {
    logTransaction($Log, $orgipn, "Unable to verify IPN", "invoice", $TmpInvoiceNo);
}

?>