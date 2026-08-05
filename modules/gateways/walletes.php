<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function walletes_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Walletes.com"], "merchantkey" => ["Name" => "Merchant Key", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function walletes_link($params)
{
    global $config;
    $merchanturl = "https://walletes.com/merchant/index.php";
    $merchantkey = $params["merchantkey"];
    $curcode = $params["currency"];
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $invoiceid = $params["invoiceid"];
    $cancelurl = $siteaddress . _url("viewinvoice/id/" . md5($invoiceid));
    $successurl = $siteaddress . _url("viewinvoice/id/" . md5($invoiceid));
    $callbackurl = $params["callbackurl"];
    $invoicetotal = $params["amount"];
    $paypalinfo = $params["description"];
    $uuid = md5($invoiceid . "-" . $_SESSION["uid"]);
    $code .= "<form  action='" . $merchanturl . "' method='post'>\n            <input type='hidden' name='cancelurl' value='" . $cancelurl . "' />\n            <input type='hidden' name='walletes' value='1' />\n            <input type='hidden' name='successurl' value='" . $successurl . "' />\n            <input type='hidden' name='merchantkey' value='" . $merchantkey . "' />\n            <input type='hidden' name='callbackurl' value='" . $callbackurl . "' />\n            <input type='hidden' name='currency' value='" . $curcode . "' />\n            <input type='hidden' name='item' value='" . $paypalinfo . "' />\n            <input type='hidden' name='customid' value='" . $invoiceid . "' />\n            <input type='hidden' name='amount' value='" . $invoicetotal . "' />\n            <input type='submit' name='paynow' class='btn-primary paymentbtn btn' value='Pay Now' />\n            </form> \n            <br/>\n \n            ";
    return $code;
}

?>