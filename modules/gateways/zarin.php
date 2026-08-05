<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function zarin_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Zarin Pay"], "merchantid" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function zarin_link($params)
{
    global $config;
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $merchantid = $params["merchantid"];
    $Amount = $params["amount"];
    $SiteAddress = $config["site_address"];
    if ($config["config_ssl_allow"]) {
        $SiteAddress = $config["config_ssl_allow"];
    }
    $callback = $SiteAddress . "/modules/gateways/callback/zarin.php";
    $data = ["MerchantID" => $merchantid, "Amount" => $Amount, "CallbackURL" => $callback, "Description" => $description];
    $jsonData = json_encode($data);
    $ch = curl_init("https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json");
    curl_setopt($ch, CURLOPT_USERAGENT, "ZarinPal Rest Api v1");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "Content-Length: " . strlen($jsonData)]);
    $result = curl_exec($ch);
    $err = curl_error($curl);
    $result = json_decode($result, true);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    }
    if ($result["Status"] == 100) {
        dquery("UPDATE tbl_invoices set businessid='" . $result["Authority"] . "'\nwhere id='" . $invoiceid . "'");
        $LInk = "https://www.zarinpal.com/pg/StartPay/" . $result["Authority"];
        $code = "<form method='post' action='" . $LInk . "'>\n<input type='submit' name='submit' class='btn btn-primary paymentbtn' value='Pay Now' />\n</form>";
        return $code;
    }
    return "ERR: " . $result["Status"];
}

?>