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
$GATEWAY = loadGatewayModule("coinbase");
if (!$GATEWAY["name"]) {
    exit("Module Not Activated");
}
$rawBody = trim(file_get_contents("php://input"));
if (!$rawBody) {
    exit("OK!");
}
$decodedBody = json_decode($rawBody, true);
$success = $decodedBody["event"]["type"];
$TmpInvoiceNo = $idnumber = $decodedBody["event"]["data"]["metadata"]["invoice_id"];
$txn_id = $decodedBody["event"]["data"]["payments"][0]["transaction_id"];
$paymentAmount = $decodedBody["event"]["data"]["payments"][0]["value"]["local"]["amount"];
$hash = $_SERVER["HTTP_X_CC_WEBHOOK_SIGNATURE"];
$transactionStatus = $success == "charge:confirmed" ? "Success" : "Failure";
$secretKey = trim($GATEWAY["webhookSecret"]);
if ($hash != hash_hmac("SHA256", $rawBody, $secretKey)) {
    $transactionStatus = "Hash Verification Failure";
    logTransaction("coinbase", $rawBody, "Hash Verification Failure", "invoice", $TmpInvoiceNo);
    $success = false;
}
if (!is_numeric($idnumber)) {
    $idnumber = "";
    logTransaction("coinbase", $rawBody, "Invalid invoice id", "invoice", $TmpInvoiceNo);
    http_response_code(500);
    exit;
}
$result = select_query("tbl_invoices", "", ["id" => $idnumber]);
$data = mysqli_fetch_assoc($result);
$invoiceid = $data["id"];
$userid = $data["userid"];
if ($txn_id && checkTransID($txn_id)) {
    http_response_code(500);
    exit;
}
logTransaction("coinbase", $rawBody, $transactionStatus, "invoice", $TmpInvoiceNo);
if ($invoiceid) {
    if ($txn_id && checkTransID($txn_id)) {
        exit;
    }
    if ($success == "charge:confirmed") {
        $currency = getCurrency("", $userid);
        $mc_gross = $paymentAmount;
        addPayment($invoiceid, $txn_id, $mc_gross, 0, "coinbase", 1, "", "", "");
        exit;
    }
} else {
    logTransaction("coinbase", $rawBody, "Invoice id not found", "invoice", $TmpInvoiceNo);
    http_response_code(500);
    exit;
}

?>