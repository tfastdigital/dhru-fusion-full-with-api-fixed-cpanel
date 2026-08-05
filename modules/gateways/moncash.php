<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function moncash_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "MonCash"], "clientid" => ["Name" => "Client ID", "Type" => "text", "Size" => "80"], "clientsecret" => ["Name" => "Client Secret", "Type" => "text", "Size" => "120"], "testmode" => ["Type" => "yesno", "Name" => "Test Mode", "Description" => " "]];
    return $configarray;
}
function moncash_link($params)
{
    global $config;
    global $lng_languag;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $paypalinfo = $params["info"];
    $clientid = $params["clientid"];
    $clientsecret = $params["clientsecret"];
    if ($params["testmode"]) {
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
    if ($RES["access_token"]) {
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => "https://" . $HOST_REST_API . "/v1/CreatePayment", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => "{\n                        \"amount\": " . round($invoicetotal, 2) . ",\n                        \"orderId\": " . $invoiceid . " }", CURLOPT_HTTPHEADER => ["Content-Type: application/json", "Authorization: Bearer " . $RES["access_token"]]]);
        $response = curl_exec($curl);
        curl_close($curl);
        $Res = json_decode($response, true);
        $Res["status"] = 202;
        if ($Res["status"]) {
            $PaymentToken = $Res["payment_token"]["token"];
            $PaymentLink = $Gateway_URL . "/Payment/Redirect?token=" . $PaymentToken;
            header("Location:" . $PaymentLink);
            echo "                    <script>\n                        location.href='";
            echo $PaymentLink;
            echo "';\n                    </script>\n                    ";
        }
    }
    return $code;
}

?>