<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function dhrumerchant_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Payment Merchant"], "merchanturl" => ["Name" => "Merchant URL", "Type" => "text", "Size" => "50"], "merchantkey" => ["Name" => "Merchant Key", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function dhrumerchant_link($params)
{
    global $config;
    $merchanturl = $params["merchanturl"];
    $merchantkey = $params["merchantkey"];
    $curcode = $params["currency"];
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $invoiceid = $params["invoiceid"];
    $cancelurl = $siteaddress . "/viewinvoice.php?id=" . md5($invoiceid);
    $successurl = $siteaddress . "/viewinvoice.php?id=" . md5($invoiceid);
    $callbackurl = $params["callbackurl"];
    $invoicetotal = $params["amount"];
    $paypalinfo = $params["description"];
    $code .= "<form  action='" . $merchanturl . "' method='post'>\n            <input type='hidden' name='cancelurl' value='" . $cancelurl . "' />\n            <input type='hidden' name='successurl' value='" . $successurl . "' />\n            <input type='hidden' name='merchantkey' value='" . $merchantkey . "' />\n            <input type='hidden' name='callbackurl' value='" . $callbackurl . "' />\n            <input type='hidden' name='currency' value='" . $curcode . "' />\n            <input type='hidden' name='item' value='" . $paypalinfo . "' />\n            <input type='hidden' name='customid' value='" . $invoiceid . "' />\n            <input type='hidden' name='amount' value='" . $invoicetotal . "' />\n            <input type='submit' class='btn btn-primary paymentbtn' name='paynow' value='Pay Now' />\n            </form> ";
    return $code;
}

?>