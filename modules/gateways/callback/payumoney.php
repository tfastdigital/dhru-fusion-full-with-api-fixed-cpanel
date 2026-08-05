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
$GATEWAY = loadGatewayModule("payumoney");
$postdata = $_POST;
if (isset($postdata["key"])) {
    $key = $postdata["key"];
    $salt = $GATEWAY["salt"];
    $txnid = $postdata["txnid"];
    $amount = $postdata["amount"];
    $productInfo = $postdata["productinfo"];
    $firstname = $postdata["firstname"];
    $email = $postdata["email"];
    $udf5 = $postdata["udf5"];
    $mihpayid = $postdata["mihpayid"];
    $status = $postdata["status"];
    $resphash = $postdata["hash"];
    $keyString = $key . "|" . $txnid . "|" . $amount . "|" . $productInfo . "|" . $firstname . "|" . $email . "|||||" . $udf5 . "|||||";
    $keyArray = explode("|", $keyString);
    $reverseKeyArray = array_reverse($keyArray);
    $reverseKeyString = implode("|", $reverseKeyArray);
    $CalcHashString = strtolower(hash("sha512", $salt . "|" . $status . "|" . $reverseKeyString));
    if ($status == "success" && $resphash == $CalcHashString) {
        $msg = "Transaction Successful and Hash Verified...";
        logTransaction("payumoney", $postdata, "Success");
        addPayment($txnid, $postdata["payuMoneyId"], $amount, 0, "payumoney", 1, "", "", $postdata["email"]);
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        header("Location: " . $SiteAddress . "/" . _url("viewinvoice/id/" . md5($txnid)));
    } else {
        $msg = "Payment failed for Hasn not verified...";
        logTransaction("payumoney", $postdata, "Error");
    }
}

?>