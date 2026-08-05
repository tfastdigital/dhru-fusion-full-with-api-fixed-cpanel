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
$GATEWAY = loadGatewayModule("futuelink");
logTransaction("futuelink", json_encode($_REQUEST), "Received", "", "", "TeT");
logTransaction("futuelink", json_encode($_POST), "Received 3", "", "", "234");
$paymentId = isset($_POST["invId"]) ? $_POST["invId"] : "0";
$status = isset($_POST["status"]) ? $_POST["status"] : "0";
$transactionId = isset($_POST["transactionId"]) ? $_POST["transactionId"] : "";
$transactionToken = isset($_POST["token"]) ? $_POST["token"] : "";
$futueLinkInvId = isset($_POST["ecomInvId"]) ? $_POST["ecomInvId"] : "";
$amount = isset($_POST["amount"]) ? $_POST["amount"] : "";
$credits = isset($_POST["credits"]) ? $_POST["credits"] : "";
if (checkTransID($transactionId)) {
    exit;
}
$result = select_query("tbl_invoices", "", ["id" => $paymentId]);
$invoiceData = mysqli_fetch_assoc($result);
if (!$invoiceData["id"]) {
    logTransaction("futuelink", json_encode($_REQUEST), "Inovice NOt Found", "", "", "TeT");
    exit;
}
$tokenSentWithTransaction = substr(md5($paymentId . $invoiceData["userid"]), 0, 20);
$amountYouSent = $invoiceData["total"];
if ($status == "success" && $transactionToken == $tokenSentWithTransaction && $amountYouSent == $credits) {
    addPayment($paymentId, $transactionId, $amountYouSent, 0, "futuelink", 1, "", "");
    logTransaction("futuelink", json_encode($invoiceData), "Success", "", "", "TeT");
} else {
    logTransaction("futuelink", json_encode($invoiceData), "Token or Amount Mismatch", "", "", "TeT");
}

?>