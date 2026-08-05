<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "../../../dbconnect.php";
include ROOTDIR . "/includes/functions.php";
include ROOTDIR . "/includes/gatewayfunctions.php";
include ROOTDIR . "/includes/invoicefunctions.php";
require_once "../bit-pay/bp_lib.php";
bpLog(file_get_contents("php://input"));
$gatewaymodule = "bitpay";
$GATEWAY = getGatewayVariables($gatewaymodule);
if (!$GATEWAY["type"]) {
    logTransaction($GATEWAY["name"], $_POST, "Not activated");
    bpLog("bitpay module not activated");
    exit("Bitpay module not activated");
}
$response = bpVerifyNotification($GATEWAY["apiKey"]);
if (is_string($response)) {
    logTransaction($GATEWAY["name"], $_POST, $response);
    exit($response);
}
if ($response["status"] == "confirmed" || $response["status"] == "complete") {
    $invoiceid = $response["posData"];
    $IsAggregator = false;
    $IsWallet = false;
    $aggregatordata = explode("_", $invoiceid);
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
    if ($IsWallet) {
        $INv = mysqli_fetch_assoc(dquery("select total from tbl_invoices where id='" . $idnumber . "'"));
        walletTransaction($response["id"], $idnumber, $INv["total"]);
    } else {
        $invoiceid = checkCbInvoiceID($invoiceid, $GATEWAY["name"]);
        $transid = $response["id"];
        checkCbTransID($transid);
        $fee = 0;
        $amount = "";
        addInvoicePayment($invoiceid, $transid, $amount, $fee, $gatewaymodule);
        logTransaction($GATEWAY["name"], $response, "Successful");
        bpLog("invoice " . $invoiceid . " credited");
    }
}

?>