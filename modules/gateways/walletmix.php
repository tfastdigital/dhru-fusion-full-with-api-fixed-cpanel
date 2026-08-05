<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function walletmix_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "WalletMix"], "merchant_id" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "50", "Description" => "Enter your walletmix merchant ID here"], "api_access_username" => ["Name" => "API Access Username", "Type" => "text", "Size" => "50", "Description" => "Enter your api access username here"], "api_access_password" => ["Name" => "API Access Password", "Type" => "text", "Size" => "50", "Description" => "Enter your api access password here"], "api_access_app_key" => ["Name" => "API Access App Key", "Type" => "text", "Size" => "100", "Description" => "Enter your api access app key here"], "api_app_name" => ["Name" => "API App Name", "Type" => "text", "Size" => "50", "Description" => "Enter your api app name here"], "testmode" => ["Name" => "Sandbox", "Type" => "yesno", "Description" => "Tick to enable Sandbox mode"]];
    return $configarray;
}
function walletmix_link($params)
{
    global $config;
    global $lng_languag;
    $WalletMixURL = "https://epay.walletmix.com/check-server";
    if ($params["testmode"]) {
        $WalletMixURL = "https://sandbox.walletmix.com/check-server";
    }
    $merchant_id = $params["merchant_id"];
    $api_access_username = $params["api_access_username"];
    $api_access_password = $params["api_access_password"];
    $api_access_app_key = $params["api_access_app_key"];
    $api_app_name = $params["api_app_name"];
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $amount = $params["amount"];
    $currency = $params["currency"];
    $firstname = $params["clientdetails"]["firstname"];
    $lastname = $params["clientdetails"]["lastname"];
    $email = $params["clientdetails"]["email"];
    $address1 = $params["clientdetails"]["address1"];
    $address2 = $params["clientdetails"]["address2"];
    $city = $params["clientdetails"]["city"];
    $state = $params["clientdetails"]["state"];
    $postcode = $params["clientdetails"]["postcode"];
    $country = $params["clientdetails"]["country"];
    $phone = $params["clientdetails"]["phonenumber"];
    $companyname = $config["companyname"];
    $system_url = rtrim($params["systemurl"], "/");
    $currency = $params["currency"];
    $cart_info = $merchant_id . "," . $system_url . "," . $invoiceid . ":" . $companyname . "," . $email . "," . $invoiceid;
    $option = base64_encode("s=" . $system_url . ",i=" . $_SERVER["SERVER_ADDR"]);
    $bankDescription = http_build_query($description);
    $getServerDetails = initCurl($WalletMixURL);
    $getServerDetails = json_decode($getServerDetails);
    $server = $getServerDetails->selectedServer;
    $_SESSION["server"] = $server;
    if ($server) {
        $encodeValue = base64_encode($api_access_username . ":" . $api_access_password);
        $auth = "Basic " . $encodeValue;
        $cart_info = $merchant_id . "," . $system_url . "," . $api_app_name;
        $params = ["wmx_id" => $merchant_id, "merchant_order_id" => $invoiceid, "merchant_ref_id" => uniqid(), "app_name" => $api_app_name, "cart_info" => $cart_info, "customer_name" => $firstname . " " . $lastname, "customer_email" => $email, "customer_add" => $address1, "customer_city" => $city, "customer_country" => $country, "customer_postcode" => $postcode, "customer_phone" => $phone, "shipping_name" => "", "shipping_add" => "", "shipping_city" => "", "shipping_country" => "", "shipping_postCode" => "", "product_desc" => $description, "amount" => $amount, "currency" => $currency, "extra_json" => "", "options" => $option, "callback_url" => $system_url . "/modules/gateways/callback/walletmix.php", "access_app_key" => $api_access_app_key, "authorization" => $auth];
        $response = initCurl($getServerDetails->url, $params);
        $response_d = json_decode($response);
        $status_code = $response_d->statusCode;
        if ($status_code === "1000") {
            $token = $response_d->token;
            $_SESSION["wmx_token"] = $token;
            $wmx_url = $getServerDetails->bank_payment_url . "/" . $token;
            $code = "";
            $code = "<form method=\"get\" action=\"" . $wmx_url . "\">";
            $code .= "<input class=\"btn btn-success  btn-primary paymentbtn paymentbtn\" type=\"submit\" value=\"Pay Now\" />";
            $code .= "</form>";
            return $code;
        }
    } else {
        echo "Server in Maintananec Mode. Please try after some time.";
        exit;
    }
}

?>