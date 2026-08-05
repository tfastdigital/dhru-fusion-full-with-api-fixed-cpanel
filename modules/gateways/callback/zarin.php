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
$GATEWAY = loadGatewayModule("zarin");
logTransaction("zarin", "Gateway Call" . $Authority, "Callback");
$Authority = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $Authority);
$SiteAddress = $config["site_address"];
if ($config["config_ssl_allow"]) {
    $SiteAddress = $config["config_ssl_allow"];
}
$ref_id = $refID;
if ($_GET["Status"] == "OK") {
    $invoice = mysqli_fetch_assoc(dquery("select * from tbl_invoices where \nbusinessid='" . $Authority . "'"));
    $amount = $invoice["total"];
    $Authority = $_GET["Authority"];
    $data = ["MerchantID" => $GATEWAY["merchantid"], "Authority" => $Authority, "Amount" => $amount];
    $jsonData = json_encode($data);
    $ch = curl_init("https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json");
    curl_setopt($ch, CURLOPT_USERAGENT, "ZarinPal Rest Api v1");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "Content-Length: " . strlen($jsonData)]);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    $result = json_decode($result, true);
    if ($invoice[status] == "Unpaid") {
        if ($result["Status"] == 100) {
            $transactionid = $result["RefID"];
            addPayment($invoice["id"], $transactionid, $invoice["total"], 0, "zarin", 1, "", "", "");
            logTransaction("zarin", $result, "Invoice Paid");
            header("Location: " . _url("viewinvoice/id/" . md5($invoice["id"]), true));
            exit;
        }
        logTransaction("zarin", $result, "Wrong Status");
        header("Location: " . _url("viewinvoice/id/" . md5($invoice["id"]), true));
        exit;
    }
    logTransaction("zarin", $result, "Invoice Already Paid");
    header("Location: " . _url("viewinvoice/id/" . md5($invoice["id"]), true));
    exit;
}
header("Location:" . _url("index", true));

?>