<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function networkaengenius_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Network.ae (ngenius-payments)"], "api_key" => ["Name" => "APi Key", "Type" => "text", "Size" => "50", "Info" => "Available in the N-Genius online Portal: Settings > Integrations > Service accounts"], "outlet_reference" => ["Name" => "Outlet ID/Reference", "Type" => "text", "Size" => "50"], "sendbox" => ["Name" => "Testing/SendBox", "Type" => "yesno", "Size" => "50"]];
    return $configarray;
}
function networkaengenius_link($params)
{
    global $lng_languag;
    if (!$params["clientdetails"]["firstname"] || !$params["clientdetails"]["lastname"] || !$params["clientdetails"]["address1"] || !$params["clientdetails"]["city"] || !$params["clientdetails"]["email"] || !$params["clientdetails"]["country"]) {
        return "<a href='" . _url("settings/profile") . "' style='color:red' ><br />Complete your profile to continue with this payment method</span></a>";
    }
    $apikey = trim($params["api_key"]);
    $ch = curl_init();
    if ($params["sendbox"]) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $apikey, "Content-Type: application/x-www-form-urlencoded"]);
        curl_setopt($ch, CURLOPT_URL, "https://identity-uat.ngenius-payments.com/auth/realms/ni/protocol/openid-connect/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(["grant_type" => "client_credentials"]));
    } else {
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $apikey, "Content-Type: application/vnd.ni-identity.v1+json", "Accept: application/vnd.ni-identity.v1+json"]);
        curl_setopt($ch, CURLOPT_URL, "https://api-gateway.ngenius-payments.com/identity/auth/access-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
    }
    $exec = curl_exec($ch);
    $output = json_decode($exec);
    $access_token = $output->access_token;
    if (isset($access_token) && $access_token != "") {
        $outlet = trim($params["outlet_reference"]);
        $token = $access_token;
        $postData = [];
        $postData["action"] = "SALE";
        $postData["amount"]["currencyCode"] = $params[currency];
        $postData["amount"]["value"] = (int) $params["amount"] * 100;
        $postData["emailAddress"] = $params["clientdetails"]["email"];
        $postData["merchantOrderReference"] = str_replace("_", "", (string) $params["invoiceid"]);
        $postData["merchantAttributes"]["redirectUrl"] = $params["returnurl"] . "?paymentsuccess=true";
        $postData["merchantAttributes"]["redirectUrl"] = str_replace("//viewinvoice", "/viewinvoice", $postData["merchantAttributes"]["redirectUrl"]);
        $postData["merchantAttributes"]["cancelUrl"] = $params["returnurl"] . "?paymentfailed=true";
        $postData["merchantAttributes"]["skipConfirmationPage"] = true;
        $postData["billingAddress"]["firstName"] = $params["clientdetails"]["firstname"];
        $postData["billingAddress"]["lastName"] = $params["clientdetails"]["lastname"];
        $postData["billingAddress"]["address1"] = $params["clientdetails"]["address1"];
        $postData["billingAddress"]["city"] = $params["clientdetails"]["city"];
        $postData["billingAddress"]["countryCode"] = $params["clientdetails"]["country"];
        $json = json_encode($postData);
        $ch = curl_init();
        if ($params["sendbox"]) {
            curl_setopt($ch, CURLOPT_URL, "https://api-gateway.sandbox.ngenius-payments.com/transactions/outlets/" . $outlet . "/orders");
        } else {
            curl_setopt($ch, CURLOPT_URL, "https://api-gateway.ngenius-payments.com/transactions/outlets/" . $outlet . "/orders");
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $token, "Content-Type: application/vnd.ni-payment.v2+json", "Accept: application/vnd.ni-payment.v2+json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $exec = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($exec);
        $order_reference = $output->reference;
        $order_paypage_url = $output->_links->payment->href;
        if (isset($order_paypage_url) && $order_paypage_url != "") {
            $code = "";
            $code .= "<a class=\"btn btn-success\" href=\"" . $order_paypage_url . "\"> " . $lng_languag["invoicespaynow"] . " </a>";
            return $code;
        }
        return "ERROR:#213453";
    }
    return "ERROR:#213442";
}
function invokeCurlRequest($type, $url, $headers, $post)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($type == "POST") {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $server_output = curl_exec($ch);
    curl_close($ch);
    return $server_output;
}

?>