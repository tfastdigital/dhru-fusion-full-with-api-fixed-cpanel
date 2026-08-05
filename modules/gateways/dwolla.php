<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function dwolla_config()
{
    $config = ["name" => ["Type" => "System", "Value" => "Dwolla"], "consumerkey" => ["Name" => "Consumer key", "Type" => "text", "Size" => "30"], "dwollakey" => ["Name" => "Dwolla key", "Type" => "text", "Size" => "30"], "consumersecret" => ["Name" => "Consumer secret", "Type" => "text", "Size" => "30"]];
    return $config;
}
function dwolla_link($params)
{
    global $config;
    global $lng_languag;
    $key = $params["consumerkey"];
    $timestamp = time();
    $callback = $params["systemurl"] . "/modules/gateways/callback/dwolla.php";
    $redirect = $params["returnurl"];
    $orderID = $params["invoiceid"];
    $destinationID = $params["dwollakey"];
    $amount = $params["amount"];
    $testmode = $params["testmode"];
    $name = $params["orderid"];
    $description = $params["description"] == "" ? "Invoice #" . $params["invoiceid"] : $params["description"];
    $shipping = "0";
    $facilitatorAmount = "0";
    $tax = "0";
    $sig = $key . "&" . $timestamp . "&" . $orderID;
    $signature = hash_hmac("sha1", $sig, $params["consumersecret"]);
    $code = "<form method=\"post\" action=\"https://www.dwolla.com/payment/pay\">\r\n        <input type=\"hidden\" name=\"key\" value=\"" . $key . "\" />\r\n        <input type=\"hidden\" name=\"signature\" value=\"" . $signature . "\" />\r\n        <input type=\"hidden\" name=\"timestamp\" value=\"" . $timestamp . "\" />\r\n        <input type=\"hidden\" name=\"callback\" value=\"" . $callback . "\" />\r\n        <input type=\"hidden\" name=\"redirect\" value=\"" . $redirect . "\" />\r\n        <input type=\"hidden\" name=\"orderID\" value=\"" . $orderID . "\" />\r\n        <input type=\"hidden\" name=\"destinationID\" value=\"" . $destinationID . "\" />\r\n        <input type=\"hidden\" name=\"amount\" value=\"" . $amount . "\" />\r\n        <input type=\"hidden\" name=\"tax\" value=\"" . $tax . "\" />";
    if ($params["testmode"] == "on") {
        $code .= "<input type=\"hidden\" name=\"test\" value=\"" . $testmode . "\" />";
    }
    $code .= "\r\n        <input type=\"hidden\" name=\"shipping\" value=\"" . $shipping . "\" />\r\n        <input type=\"hidden\" name=\"facilitatorAmount\" value=\"" . $facilitatorAmount . "\" />\r\n        <input type=\"hidden\" name=\"name\" value=\"" . $name . "\" />\r\n        <input type=\"hidden\" name=\"description\" value=\"" . $description . "\" />\r\n        <input type=\"submit\" class=\"btn btn-success  btn-primary paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\" />\r\n    </form>\r\n        \r\n    ";
    return $code;
}

?>