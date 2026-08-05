<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function paytm_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayTm"], "merchant_id" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "20"], "merchant_key" => ["Name" => "Merchant Key", "Type" => "text", "Size" => "16"], "environment" => ["Name" => "Environment", "Type" => "dropdown", "Options" => "TEST,LIVE", "Description" => "TEST or LIVE"], "website" => ["Name" => "Website name", "Type" => "text", "Size" => "20"], "industry_type" => ["Name" => "Industry Name", "Type" => "text", "Size" => "20"]];
    return $configarray;
}
function paytm_link($params)
{
    include_once dirname(__FILE__) . "/paytm/encdec_paytm.php";
    global $config;
    $merchant_id = $params["merchant_id"];
    $secret_key = $params["merchant_key"];
    $order_id = $params["invoiceid"];
    $website = $params["website"];
    $industry_type = $params["industry_type"];
    $channel_id = "WEB";
    $gateway_mode = $params["environment"];
    $amount = round($params["amount"], 2);
    $email = $params["clientdetails"]["email"];
    $phone = $params["clientdetails"]["phonenumber"];
    $post_variables = ["MID" => trim($merchant_id), "ORDER_ID" => "ORDER" . $order_id, "CUST_ID" => "CUST" . $_SESSION["uid"], "MOBILE_NO" => $phone, "EMAIL" => $email, "TXN_AMOUNT" => $amount, "CHANNEL_ID" => $channel_id, "INDUSTRY_TYPE_ID" => $industry_type, "CALLBACK_URL" => ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "/modules/gateways/callback/paytm.php", "WEBSITE" => $website];
    $checksum = getChecksumFromArray($post_variables, trim($secret_key));
    $companyname = "paytm";
    $pg_url = "https://securegw-stage.paytm.in/theia/processTransaction";
    if ($gateway_mode == "LIVE") {
        $pg_url = "https://securegw.paytm.in/theia/processTransaction";
    }
    $code = "\n              \n\t<form method=\"post\" action=" . $pg_url . ">\n\t\t<input type=\"hidden\" name=\"MID\" value=\"" . $merchant_id . "\"/>\n\t    <input type=\"hidden\" name=\"ORDER_ID\" value=\"ORDER" . $order_id . "\"/>\n\t    <input type=\"hidden\" name=\"WEBSITE\" value=\"" . $website . "\"/>\n\t    <input type=\"hidden\" name=\"INDUSTRY_TYPE_ID\" value=\"" . $industry_type . "\"/>\n\t    <input type=\"hidden\" name=\"CHANNEL_ID\" value=\"" . $channel_id . "\"/>\n\t    <input type=\"hidden\" name=\"MOBILE_NO\" value=\"" . $phone . "\">\n        <input type=\"hidden\" name=\"EMAIL\" value=\"" . $email . "\">\n\t    <input type=\"hidden\" name=\"TXN_AMOUNT\" value=\"" . $amount . "\"/>\n\t    <input type=\"hidden\" name=\"CUST_ID\" value=\"" . "CUST" . $_SESSION["uid"] . "\"/>\n\t    <input type=\"hidden\" name=\"CHECKSUMHASH\" value=\"" . $checksum . "\"/>\n\t    <input type=\"hidden\" name=\"CALLBACK_URL\" value=\"" . ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "/modules/gateways/callback/paytm.php\"/>\n\t\t<input type=\"submit\" class=\"btn-primary paymentbtn\" value=\"Pay with Paytm\" />\n\t</form>";
    return $code;
}

?>