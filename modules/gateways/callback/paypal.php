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
$GATEWAY = loadGatewayModule("paypal");
$postipn = "cmd=_notify-validate";
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
    $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
}
logTransaction("paypal", $postipn, "Received", "", "", $_POST[custom]);
if (stripos($postipn, "sandbox") !== false) {
    logTransaction("paypal ebay", $orgipn, "Sandbox Not Allowed");
    exit;
}
if ($GATEWAY["SendBox"]) {
    $_paypal_link = "ssl://www.sandbox.paypal.com";
    $urlParsed = parse_url("https://www.sandbox.paypal.com/cgi-bin/webscr");
} else {
    $_paypal_link = "ssl://www.paypal.com";
    $urlParsed = parse_url("https://www.paypal.com/cgi-bin/webscr");
}
$port = fsockopen($_paypal_link, 443, $errno, $errstr, 30);
if (!$port && !$error) {
    logTransaction("paypal", "No::" . $errno . " Error::" . $errstr, "Error-1");
    exit;
}
fputs($port, "POST " . $urlParsed["path"] . " HTTP/1.1\r\n");
fputs($port, "Host: " . $urlParsed["host"] . "\r\n");
fputs($port, "Content-type: application/x-www-form-urlencoded\r\n");
fputs($port, "Content-length: " . strlen($postipn) . "\r\n");
fputs($port, "Connection: close\r\n\r\n");
fputs($port, $postipn . "\r\n\r\n");
while (!feof($port)) {
    $reply .= fgets($port, 1024);
}
fclose($port);
$TmpInvoiceNo = $_POST["custom"];
if (stripos($reply, "unauthorized") !== false) {
    if (mysqli_num_rows(dquery("select id from tbl_invoices where id='" . $_POST["custom"] . "'"))) {
        $ipndata = enc(json_encode($_POST), 1523);
        dquery("insert into tbl_fraud\n            (invoiceid,data) values ('" . $_POST["custom"] . "','" . $ipndata . "')");
        include_once ROOTDIR . "/includes/mail.fun.php";
        $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $_POST["custom"]) . "&title=" . base64_encode("View Invoice -" . $_POST["custom"]) . "'>here</a>";
        $adminmessage = "New PayPal dispute open as a Unauthorised transaction.\n            <br /> You can submit fraud details to Utilities->Fraud Cage to reduce fraud cases world wide.     \n            <br /><br /> Click " . $here . " to view invoice";
        sendNotification("account", "Paypal Unauthorised claim #" . $_POST["custom"], $adminmessage, "");
        if (!$config["autofraudclose"]) {
            $result = select_query("tbl_invoices", "", ["id" => $_POST["custom"]]);
            $data = mysqli_fetch_assoc($result);
            $userid = $data["userid"];
            dquery("update tblUsers set userstatus=1,\n                block_reason='Paypal Unauthorised Claim'\n                where id='" . $userid . "'");
        }
    }
    exit;
}
if (stripos($reply, "VERIFIED") !== false || stripos($reply, "verified") !== false) {
    logTransaction("paypal", $orgipn, "Verified", "invoice", $TmpInvoiceNo);
    $payment_status = $_POST["payment_status"];
    $subscr_id = $_POST["subscr_id"];
    $txn_type = $_POST["txn_type"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_fee"];
    $idnumber = $_POST["custom"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $business = $_POST["business"];
    $payer_email = $_POST["payer_email"];
    $IsAggregator = false;
    $IsWallet = false;
    $aggregatordata = explode("_", $idnumber);
    $aggregatordata[0] = 0 < $aggregatordata[1] && $aggregatordata[2];
    if ($aggregatordata[0]) {
        $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
        $aggretran = mysqli_fetch_assoc($aggretran);
        if ($aggretran["aggregatortransid"]) {
            $idnumber = $aggregatordata[1];
            $IsAggregator = true;
        }
    }
    $aggregatordata[0] = 0 < $aggregatordata[1];
    if ($aggregatordata[0]) {
        $idnumber = $aggregatordata[1];
        $IsWallet = true;
    }
    if (strtolower(trim($business)) != strtolower(trim($GATEWAY["email"]))) {
        logTransaction("paypal", $orgipn, "Wrong Business Email", "invoice", $TmpInvoiceNo);
        exit;
    }
    if ($payment_status == "Pending") {
        logTransaction("paypal", $orgipn, "Pending", "invoice", $TmpInvoiceNo);
        exit;
    }
    if ($txn_id && checkTransID($txn_id)) {
        exit;
    }
    if (!is_numeric($idnumber)) {
        $idnumber = "";
    }
    $result = select_query("tbl_currencies", "", ["code" => $paypalcurrency]);
    $data = mysqli_fetch_assoc($result);
    $paypalcurrencyid = $data["id"];
    $currencyconvrate = $data["rate"];
    if (!$paypalcurrencyid) {
        logTransaction("paypal", $orgipn, "Unrecognised Currency", "invoice", $TmpInvoiceNo);
        exit;
    }
    switch ($txn_type) {
        case "web_accept":
            if ($payment_status != "Completed") {
                logTransaction("paypal", $orgipn, $payment_status, "invoice", $TmpInvoiceNo);
                exit;
            }
            $result = select_query("tbl_invoices", "", ["id" => $idnumber]);
            $data = mysqli_fetch_assoc($result);
            $invoiceid = $data["id"];
            $userid = $data["userid"];
            break;
        default:
            if ($invoiceid) {
                logTransaction("paypal", $orgipn, "Successful", "invoice", $TmpInvoiceNo);
                $currency = getCurrency("", $userid);
                dquery("update tbl_invoices set businessid='" . $business . "'\n    where id='" . $invoiceid . "'");
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
                if ($IsWallet) {
                    dquery("update tblWalletTransaction set status='paid',transactionid='" . $txn_id . "' where transid='" . $idnumber . "'");
                } else {
                    if ($IsAggregator) {
                        dquery("update tblAggregatorTransaction set status='paid',transactionid='" . $txn_id . "' where aggregatortransid='" . $idnumber . "'");
                    } else {
                        addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "paypal", 1, "", "", $payer_email);
                    }
                }
                exit;
            }
            logTransaction("paypal", $orgipn, "Not Supported", "invoice", $TmpInvoiceNo);
    }
} else {
    $payment_status = $_POST["payment_status"];
    if (!$config["directunverified"] && stripos($payment_status, "Completed") !== false) {
        $txn_id = $_POST["txn_id"];
        $idnumber = $_POST["custom"];
        include_once ROOTDIR . "/includes/mail.fun.php";
        $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $idnumber) . "&title=" . base64_encode("View Invoice -" . $idnumber) . "'>here</a>";
        $adminmessage = "Payment received for invoice#" . $idnumber . " .\n                <br /> But this payer (" . $_POST["payer_email"] . ") is unverified so please review transaction (" . $txn_id . ") and Pay invoice Manualy .\n                <br /><br /> Click " . $here . " to view invoice";
        sendNotification("account", "Unverified transaction [" . $txn_id . "]", $adminmessage, "");
        exit;
    }
    if (stripos($reply, "INVALID") !== false) {
        logTransaction("paypal", $orgipn . ":" . $reply, "Invalid", "invoice", $TmpInvoiceNo);
        exit;
    }
    if (stripos($reply, "unverified") !== false) {
        logTransaction("paypal", $orgipn . ":" . $reply, "Unverified", "invoice", $TmpInvoiceNo);
        exit;
    }
    logTransaction("paypal", $orgipn . ":" . $reply, "Error-2", "invoice", $TmpInvoiceNo);
    exit;
}

?>