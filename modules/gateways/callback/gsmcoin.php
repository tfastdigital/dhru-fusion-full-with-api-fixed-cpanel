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
$gateway = "gsmcoin";
$GATEWAY = loadGatewayModule($gateway);
if (!$GATEWAY["name"]) {
    exit("Module Not Activated");
}
$rawBody = trim(file_get_contents("php://input"));
$decodedBody = json_decode($rawBody, true);
logTransaction($gateway, $rawBody, "Data Received");
$event = $decodedBody["event"]["type"];
$order_id = $decodedBody["event"]["data"]["order_id"];
if (!$order_id || $order_id == "" || strlen($order_id) < 30) {
    logTransaction($gateway, $rawBody, "Order ID not found");
    exit("Order ID not found");
}
if ($event != "charge:confirmed") {
    logTransaction($gateway, $rawBody, "Invalid Event");
    exit("Invalid Event");
}
$Header["HEADER"] = ["Content-Type: application/json", "Authorization: Bearer " . $GATEWAY["authorization_token"]];
$Resp = initCurl("https://api.gsmcoin.com/checkout/v1/orders?order_id=" . $order_id, [], $Header);
logTransaction($gateway, $Resp, "Order Details");
$Result = json_decode($Resp, true)["data"];
if ($Result["status"] === "Paid") {
    $custom_id = $Result["custom_id"];
    $txn_id = $Result["order_id"];
    $amount = $Result["amount"];
    $currency_code = $Result["currency_code"];
    $result = select_query("tbl_invoices", "", ["id" => $custom_id]);
    $invoice_dtl = mysqli_fetch_assoc($result);
    $invoice_id = $invoice_dtl["id"];
    $user_id = $invoice_dtl["userid"];
    if (!$invoice_id) {
        logTransaction($gateway, $rawBody, "Invoice Not Found", "invoice", $custom_id);
        exit("Invoice Not Found");
    }
    if ($txn_id && checkTransID($txn_id)) {
        logTransaction($gateway, $rawBody, "Transaction Id already", "invoice", $custom_id);
        exit("Transaction id already exists");
    }
    $currency = getCurrency("", $user_id);
    if ($currency_code != $currency["id"]) {
        $amount = convertCurrency($amount, $currency_code, $currency["id"]);
        $total = round($invoice_dtl["total"], 2);
        if ($total < $amount + 1 && $amount - 1 < $total) {
            $amount = $total;
        }
    }
    logTransaction($gateway, $rawBody, "Successful", "invoice", $custom_id);
    addPayment($invoice_id, $txn_id, $amount, 0, $gateway, 1, "", "", "");
    exit("Successful");
}

?>