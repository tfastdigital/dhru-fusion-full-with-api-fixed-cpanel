<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "../../../dbconnect.php";
include "../../../includes/functions.php";
include "../../../includes/gatewayfunctions.php";
include "../../../includes/invoicefunctions.php";
require "bp_lib.php";
$gatewaymodule = "bitpay";
$GATEWAY = getGatewayVariables($gatewaymodule);
$invoiceId = (int) $_POST["invoiceId"];
$price = $currency = false;
$result = dquery("SELECT tblinvoices.total, tblinvoices.status, tblcurrencies.code FROM tblinvoices, tblclients, tblcurrencies where tblinvoices.userid = tblclients.id and tblclients.currency = tblcurrencies.id and tblinvoices.id=" . $invoiceId);
$data = mysqli_fetch_assoc($result);
if (!$data) {
    bpLog("no invoice found for invoice id" . $invoiceId);
    exit("Invalid invoice");
}
$price = $data["total"];
$currency = $data["code"];
$status = $data["status"];
if ($status != "Unpaid") {
    bpLog("Invoice status must be Unpaid.  Status: " . $status);
    exit("bad invoice status");
}
$convertTo = false;
$query = "SELECT value from tblpaymentgateways where `gateway` = '" . $gatewaymodule . "' and `setting` = 'convertto'";
$result = dquery($query);
$data = mysqli_fetch_assoc($result);
if ($data) {
    $convertTo = $data["value"];
}
if ($convertTo) {
    $query = "SELECT rate FROM tblcurrencies where `code` = '" . $currency . "'";
    $result = dquery($query);
    $currentCurrency = mysqli_fetch_assoc($result);
    if (!$currentCurrency) {
        bpLog("invalid invoice currency " . $currency);
        exit("Invalid invoice currency");
    }
    $result = dquery("SELECT code, rate FROM tblcurrencies where `id` = " . $convertTo);
    $convertToCurrency = mysqli_fetch_assoc($result);
    if (!$convertToCurrency) {
        bpLog("invalid convertTo currency " . $convertTo);
        exit("Invalid convertTo currency");
    }
    $currency = $convertToCurrency["code"];
    $price = $price / $currentCurrency["rate"] * $convertToCurrency["rate"];
}
$options = $_POST;
unset($options["invoiceId"]);
unset($options["systemURL"]);
$options["notificationURL"] = $_POST["systemURL"] . "/modules/gateways/callback/bitpay.php";
$options["redirectURL"] = $_POST["systemURL"];
$options["apiKey"] = $GATEWAY["apiKey"];
$options["transactionSpeed"] = $GATEWAY["transactionSpeed"];
$options["currency"] = $currency;
bpLog("creating bp invoice with whmcs invoice " . $invoiceId . " " . $price);
bpLog($options);
$invoice = bpCreateInvoice($invoiceId, $price, $invoiceId, $options);
if (isset($invoice["error"])) {
    bpLog($invoice["error"]);
    exit("bitpay invoice error");
}
header("Location: " . $invoice["url"]);

?>