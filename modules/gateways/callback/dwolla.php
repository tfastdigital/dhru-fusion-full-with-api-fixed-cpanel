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
$gatewaymodule = "dwolla";
$GATEWAY = loadGatewayModule($gatewaymodule);
if (!$GATEWAY) {
    exit("Module Not Activated");
}
$invoiceid = $_GET["OrderId"];
$status = $_GET["Status"];
$transid = $_GET["TransactionId"];
$amount = $_GET["Amount"];
$fee = 0;
if (checkTransID($transid)) {
    exit;
}
$sig = $transid . "&" . $amount;
$signature = hash_hmac("sha1", $sig, $GATEWAY["consumersecret"]);
if ($signature != $_GET["Signature"]) {
    logTransaction($gatewaymodule, json_encode($_GET), "Error");
    exit;
}
if (is_numeric($invoiceid)) {
    if ($status == "Completed") {
        logTransaction($gatewaymodule, json_encode($_GET), "Successful");
        addPayment($invoiceid, $transid, $amount, $fee, $gatewaymodule);
        exit;
    }
    logTransaction($gatewaymodule, json_encode($_GET), "Error");
}

?>