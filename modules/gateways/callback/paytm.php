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
require "../../../includes/fun.inc.php";
include "../../../includes/gateway.fun.php";
include "../../../includes/invoice.fun.php";
require_once ROOTDIR . "/modules/gateways/paytm/encdec_paytm.php";
$gatewaymodule = "paytm";
$GATEWAY = loadGatewayModule($gatewaymodule);
$response = [];
$response = $_POST;
$siteurl = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
if (isset($response["ORDERID"]) && isset($response["STATUS"]) && isset($response["RESPCODE"]) && $response["RESPCODE"] != 325) {
    $txnid = str_replace("ORDER", "", $response["ORDERID"]);
    $banktxid = $response["BANKTXNID"];
    $txnid = checkInvoiceID($txnid, "paytm");
    $status = $response["STATUS"];
    $paytm_trans_id = $response["TXNID"];
    $checksum_recv = "";
    $amount = $response["TXNAMOUNT"];
    if (isset($response["CHECKSUMHASH"])) {
        $checksum_recv = $response["CHECKSUMHASH"];
    }
    checkTransID($paytm_trans_id);
    $checksum_status = verifychecksum_e($response, html_entity_decode($GATEWAY["merchant_key"]), $checksum_recv);
    $requestParamList = ["MID" => $GATEWAY["merchant_id"], "ORDERID" => $response["ORDERID"]];
    $check_status_url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/TXNSTATUS";
    if ($GATEWAY["environment"] == "LIVE") {
        $check_status_url = "https://secure.paytm.in/oltp/HANDLER_INTERNAL/TXNSTATUS";
    }
    logTransaction($GATEWAY["name"], $response, $response["RESPMSG"]);
    if ($status == "TXN_SUCCESS" && $checksum_status == "TRUE") {
        $responseParamList = callAPI($check_status_url, $requestParamList);
        $inv = mysqli_fetch_assoc(dquery("select (select (select code from tbl_currencies where id=default_currency) from tblUsers\nwhere id=userid) as currency,\n (select default_currency from tblUsers\nwhere id=userid) as currencyid from tbl_invoices where id='" . $txnid . "'"));
        $mc_fee = 0;
        if ($inv["currency"] != "INR") {
            $curinr = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='INR'"));
            $amount = convertCurrency($amount, $curinr["id"], $inv["currencyid"]);
        }
        if ($responseParamList["STATUS"] == "TXN_SUCCESS" && $responseParamList["TXNAMOUNT"] == round($amount, 2)) {
            $gatewayresult = "success";
            addPayment($txnid, $banktxid, $amount, $mc_fee, "paytm", 1, "", "", $payer_email);
            logTransaction($GATEWAY["name"], $response, $response["RESPMSG"]);
        } else {
            logTransaction($GATEWAY["name"], $response, "Suspected Fraud");
        }
    } else {
        if ($status == "TXN_SUCCESS" && $checksum_status != "TRUE") {
            logTransaction($GATEWAY["name"], $response, "Checksum Mismatch");
        } else {
            logTransaction($GATEWAY["name"], $response, $response["RESPMSG"]);
        }
    }
    $protocol = "http://";
    $host = "";
    if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == "1")) {
        $protocol = "https://";
    }
    if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
        $host = $_SERVER["HTTP_HOST"];
    }
    $filename = $siteurl . _url("viewinvoice/id/" . md5($txnid));
    header("Location: " . $filename);
} else {
    $protocol = "http://";
    $host = "";
    if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == "1")) {
        $protocol = "https://";
    }
    if (isset($_SERVER["HTTP_HOST"]) && !empty($_SERVER["HTTP_HOST"])) {
        $host = $_SERVER["HTTP_HOST"];
    }
    $location = $siteurl;
    header("Location: " . $location);
}

?>