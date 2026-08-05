<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function coinbase_MetaData()
{
    return ["DisplayName" => "Coinbase Commerce", "APIVersion" => "1.1", "DisableLocalCredtCardInput" => true, "TokenisedStorage" => false];
}
function coinbase_config()
{
    global $config;
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $callbackUrl = $siteaddress . "modules/gateways/callback/coinbase.php";
    if (strpos($config["site_address"], "https") !== false) {
        $flagur = true;
    }
    $webhookDescription = "<p>Please copy/paste <b>" . $callbackUrl . "</b> url in <a href=\"https://commerce.coinbase.com/dashboard/settings\" target=\"_blank\">Settings &gt; Webhook subscriptions &gt; Add an endpoint</a></p>";
    if (!$config["config_ssl_allow"] && !$flagur) {
        $webhookDescription .= "<p style=\"color:red;\">Please activate ssl for webhook notifications!!!</p>";
    }
    return ["name" => ["Type" => "System", "Value" => "Coinbase Commerce"], "apiKey" => ["FriendlyName" => "API Key", "Type" => "text", "Size" => "25", "Default" => "", "Description" => "Get API Key <a href=\"https://commerce.coinbase.com/dashboard/settings\" target=\"_blank\">Settings &gt; API keys &gt; Create an API key</a>"], "webhookSecret" => ["FriendlyName" => "Webhook Shared Secret", "Type" => "text", "Size" => "25", "Default" => "", "Description" => "Get the Shared Key <a href=\"https://commerce.coinbase.com/dashboard/settings\" target=\"_blank\">Settings &gt; Show Shared Secrets</a>"], "webhookUrl" => ["FriendlyName" => "Webhook subscription url", "Type" => "", "Value" => $callbackUrl, "Size" => "", "Default" => "", "Description" => $webhookDescription]];
}
function coinbase_link($params)
{
    global $lng_languag;
    $ccUrl = "https://api.commerce.coinbase.com/charges";
    $ccPricingType = "fixed_price";
    $ccApiVersion = "2018-03-22";
    $apiKey = $params["apiKey"];
    $invoiceId = $params["invoiceid"];
    $description = $params["description"];
    $amount = $params["amount"];
    $currencyCode = $params["currency"];
    $firstname = $params["clientdetails"]["firstname"];
    $lastname = $params["clientdetails"]["lastname"];
    $email = $params["clientdetails"]["email"];
    $returnUrl = $params["returnurl"];
    $postfields = [];
    $postfields["name"] = $description;
    $postfields["description"] = "Invoice - #" . $invoiceId;
    $postfields["local_price"] = ["amount" => $amount, "currency" => $currencyCode];
    $postfields["pricing_type"] = $ccPricingType;
    $postfields["metadata"] = ["customer_name" => $firstname . " " . $lastname, "customer_email" => $email, "invoice_id" => $params["otherinvoiceid"] ? $params["otherinvoiceid"] : $invoiceId, METADATA_INVOICE_PARAM => $invoiceId];
    $postfields["redirect_url"] = $returnUrl . "?paymentsuccess=true";
    $postfields["cancel_url"] = $returnUrl . "?paymentfailed=true";
    $payload = json_encode($postfields, JSON_UNESCAPED_SLASHES);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $ccUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type: application/json", "X-CC-Api-Key: " . $apiKey, "X-CC-Version: " . $ccApiVersion];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $payment_url = json_decode($server_output, true);
    $htmlOutput = "<form action=\"" . $payment_url["data"]["hosted_url"] . "\" method=\"GET\">";
    $htmlOutput .= "<input type=\"submit\" class=\"btn btn-success btn-primary  paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">";
    $htmlOutput .= "</form>";
    return $htmlOutput;
}

?>