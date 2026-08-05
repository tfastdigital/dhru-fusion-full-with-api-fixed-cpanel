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
$rawBody = trim(file_get_contents("php://input"));
logTransaction("moncash", $rawBody, "rowbody", "", "", $_GET);
logTransaction("moncash", json_encode($_GET), "Received " . $transactionId, "", "", $_GET);
logTransaction("moncash", json_encode($_REQUEST), "Received" . $transactionId, "", "", $_POST);
if ($transactionId) {
    $clientid = $GATEWAY["clientid"];
    $clientsecret = $GATEWAY["clientsecret"];
    if ($GATEWAY["testmode"]) {
        $HOST_REST_API = "sandbox.moncashbutton.digicelgroup.com/Api";
        $Gateway_URL = "https://sandbox.moncashbutton.digicelgroup.com/Moncash-middleware";
    } else {
        $HOST_REST_API = "moncashbutton.digicelgroup.com/Api";
        $Gateway_URL = "https://moncashbutton.digicelgroup.com/Moncash-middleware";
    }
    $curl = curl_init();
    curl_setopt_array($curl, [CURLOPT_URL => "https://" . $clientid . ":" . $clientsecret . "@" . $HOST_REST_API . "/oauth/token", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => ["scope" => "read,write", "grant_type" => "client_credentials"]]);
    $response = curl_exec($curl);
    curl_close($curl);
    $RES = json_decode($response, true);
    $curl = curl_init();
    curl_setopt_array($curl, [CURLOPT_URL => "https://" . $HOST_REST_API . "/v1/RetrieveTransactionPayment", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => "{\n                        \"transactionId\": " . $transactionId . "}", CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Authorization: Bearer " . $RES["access_token"]]]);
    $response = curl_exec($curl);
    curl_close($curl);
    $Res = json_decode($response, true);
    logTransaction("moncash", json_encode($Res), "response" . $transactionId, "", "", $_POST);
    $Res["status"] = 200;
    if ($Res["status"]) {
        if ($Res["payment"]["message"] == "successful") {
            $invoiceid = $Res["payment"]["reference"];
            $inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices where id='" . $invoiceid . "'"));
            $txn_id = $Res["payment"]["transaction_id"];
            if ($txn_id && checkTransID($txn_id)) {
                exit;
            }
            $mc_gross = $inv["total"];
            $mc_fee = 0;
            addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "moncash", 1);
        }
        $siteurl = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
        $filename = $siteurl . _url("viewinvoice/id/" . md5($Res["payment"]["reference"]));
        header("Location: " . $filename);
    }
}

?>