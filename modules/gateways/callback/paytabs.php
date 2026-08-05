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
$GATEWAY = loadGatewayModule("paytabs");
$ReturnBody = file_get_contents("php://input");
logTransaction("paytabs", $ReturnBody, "Received", "", "", $_POST[custom]);
$serverKey = $GATEWAY["profileserverkey"];
$Return = (array) json_decode($ReturnBody, true);
if (trim($Return["payment_result"]["response_message"]) == "Authorised") {
    logTransaction("paytabs", $Return, "Authorized", "", "", "");
    $txnid = $Return["tran_ref"];
    $amount = $Return["tran_total"];
    $data["profile_id"] = $GATEWAY["profile_id"];
    $data["tran_ref"] = $txnid;
    $CurlPost["HEADER"] = ["authorization: " . $GATEWAY["profileserverkey"], "content-type: application/json"];
    $ch = initCurl("https://secure.paytabs.com/payment/query", "", $CurlPost, "", $data);
    $Res = (array) json_decode($ch, true);
    if ($Res["tran_type"] == "Sale" && $Res["cart_amount"] == $amount && trim($Res["payment_result"]["response_message"]) == "Authorised") {
        logTransaction("paytabs", $Return, "Verified", "", "", "");
        $invoiceid = $Return["cart_id"];
        $IsWallet = false;
        $aggregatordata = explode("_", $invoiceid);
        if ($aggregatordata[0] == "A" && 0 < $aggregatordata[1] && $aggregatordata[2]) {
            $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
            $aggretran = mysqli_fetch_assoc($aggretran);
            if ($aggretran["aggregatortransid"]) {
                $invoiceid = $aggregatordata[1];
                $IsAggregator = true;
            }
        }
        if ($aggregatordata[0] == "B" && 0 < $aggregatordata[1]) {
            $invoiceid = $aggregatordata[1];
            $IsWallet = true;
            logTransaction("paytabs", $Return, "Wallet Transact", "", "", "");
        }
        $cartcurrency = $Return["tran_currency"];
        if ($IsWallet) {
            $Gateway = loadGatewayModule("paytabs");
            $Wallet = mysqli_fetch_assoc(dquery("select fee,amount,userid from tblWalletTransaction \nwhere transid='" . $invoiceid . "'"));
            $currency = getCurrency("", $Wallet["userid"]);
            $curs = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='" . $cartcurrency . "'"));
            if ($curs["id"] != $currency["id"]) {
                $amount = convertCurrency($amount, $curs["id"], $currency["id"], "", "id");
                $amount = round($amount, 2);
            }
            $Fee = $Wallet["fee"];
            $PaidAmount = round($amount, 2);
            if ($Fee) {
                $PaidAmount = $PaidAmount - $Fee;
            }
            if ($Wallet["amount"] <= $PaidAmount) {
                walletTransaction($txnid, $invoiceid, $PaidAmount, $Fee, $Gateway["name"]);
                logTransaction("paytabs", $Wallet, "Wallet Paid", "invoice", $invoiceid);
            } else {
                dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $invoiceid . "'");
                include_once ROOTDIR . "/includes/mail.fun.php";
                $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $invoiceid . " <br />";
                $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                $adminmessage .= "Amount : " . $PaidAmount;
                sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
            }
        } else {
            $inv = mysqli_fetch_assoc(dquery("select \n       (select (select code from tbl_currencies where id=default_currency) from tblUsers\nwhere id=userid) as currency,\n (select default_currency from tblUsers\nwhere id=userid) as currencyid,total from tbl_invoices where id='" . $invoiceid . "'"));
            $mc_fee = 0;
            if ($inv["currency"] != $cartcurrency) {
                $amount = convertCurrency($amount, $cartcurrency, $inv["currency"], "", "code");
                if ($amount <= $inv["total"] + 0 && $inv["total"] - 0 <= $amount) {
                    $amount = $inv["total"];
                }
            }
            addPayment($invoiceid, $txnid, $amount, $mc_fee, "paytabs", 1, "", "", "");
        }
    } else {
        logTransaction("paytabs", $Return, "Error", "", "", "");
    }
} else {
    logTransaction("paytabs", $Return, "Error", "", "", "");
}

?>