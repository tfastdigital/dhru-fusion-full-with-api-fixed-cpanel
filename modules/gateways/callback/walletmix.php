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
$GATEWAY = loadGatewayModule("moncash");
$gatewayModuleName = basename(__FILE__, ".php");
logTransaction("walletmix", json_encode($_REQUEST), "Received", "", "", $_POST);
$merchant_id = $GATEWAY["merchant_id"];
$api_access_username = $GATEWAY["api_access_username"];
$api_access_password = $GATEWAY["api_access_password"];
$api_access_app_key = $GATEWAY["api_access_app_key"];
$WalletMixURL = "https://epay.walletmix.com/check-payment";
if ($GATEWAY["testmode"]) {
    $WalletMixURL = "https://sandbox.walletmix.com/check-payment";
}
$recheck_url = $WalletMixURL;
$encodeValue = base64_encode($api_access_username . ":" . $api_access_password);
$auth = "Basic " . $encodeValue;
$params = ["wmx_id" => $merchant_id, "authorization" => $auth, "access_app_key" => $api_access_app_key];
$previous_token = $_SESSION["wmx_token"];
if (isset($_POST["merchant_txn_data"])) {
    $jsonData = $_POST["merchant_txn_data"];
    $jsonData = stripslashes(html_entity_decode($jsonData));
    $merchant_txn_data = json_decode($jsonData, true);
    $token = $merchant_txn_data["token"];
    $txn_status = $merchant_txn_data["txn_status"];
    if ($token === $previous_token) {
        $params["token"] = $token;
        $response = json_decode(initCurl($recheck_url, $params));
        $merchat_currency = strtoupper($response->merchant_currency);
        $invoiceId = $response->merchant_order_id;
        $transactionId = $token;
        $paymentAmount = $response->merchant_req_amount;
        $paymentFee = $response->wmx_charge_bdt;
        if ($transactionId && checkTransID($transactionId)) {
            exit;
        }
        $result = select_query("tbl_invoices", "", ["id" => $invoiceId]);
        $invoiceData = mysqli_fetch_assoc($result);
        $invoiceid = $invoiceData["id"];
        $userid = $invoiceData["userid"];
        $amount = $invoiceData["total"];
        $result = dquery("select id,(select code from tbl_currencies where tbl_currencies.id=default_currency) as code,default_currency from tblUsers where id='" . $userid . "'");
        $userData = mysqli_fetch_assoc($result);
        $currency = $userData["code"];
        $currency = strtoupper($currency);
        $mc_gross = $response->merchant_req_amount;
        if ($response->wmx_id == $params["wmx_id"]) {
            if ($currency != $merchat_currency) {
                $mc_gross = convertCurrency($mc_gross, $merchat_currency, $currency, "", "code");
                $total = round($amount, 2);
                if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                    $mc_gross = $total;
                }
            }
            if ($response->txn_status == "1000" && $mc_gross <= $response->merchant_req_amount) {
                $success = true;
                addPayment($invoiceid, $transactionId, $mc_gross, 0, "walletmix", 1, "", "");
                logTransaction("walletmix", json_encode($_REQUEST), "Transaction Successful", "invoice", $invoiceid);
                header("Location: " . $GATEWAY["systemurl"] . _url("viewinvoice/id/" . md5($invoiceid)));
                exit;
            }
            $success = false;
            logTransaction("walletmix", json_encode($_REQUEST), "Transaction Failed", "invoice", $invoiceid);
            header("Location: " . $GATEWAY["systemurl"] . _url("viewinvoice/id/" . md5($invoiceid)));
            exit;
        }
        logTransaction("walletmix", json_encode($_REQUEST), "Merchant ID Mismatch", "invoice", $invoiceid);
        header("Location: " . $GATEWAY["systemurl"] . _url("viewinvoice/id/" . md5($invoiceid)));
        exit;
    }
    logTransaction("walletmix", json_encode($_REQUEST), "Token Mismatch", "invoice", $invoiceid);
    header("Location: " . $GATEWAY["systemurl"] . _url(""));
    exit;
}
logTransaction("walletmix", json_encode($_REQUEST), "Try to direct access", "invoice", $invoiceid);
header("Location: " . $GATEWAY["systemurl"] . _url(""));
exit;

?>