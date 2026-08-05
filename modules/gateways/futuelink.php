<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function futuelink_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Futuelink"], "username" => ["Name" => "Email", "Type" => "text", "Size" => "80", "Description" => "Email"], "apikey" => ["Name" => "APi Key", "Type" => "text", "Size" => "100"]];
    return $configarray;
}
function futuelink_link($params)
{
    global $config;
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $paypalinfo = $params["info"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $USERNAME = $params["username"];
    $APIKEY = $params["apikey"];
    $currency = $params["currency"];
    $cancelurl = "";
    $successurl = "";
    $token = substr(md5($invoiceid . $_SESSION["uid"]), 0, 20);
    $email = $params["clientdetails"]["email"];
    $clientname = $params["clientdetails"]["firstname"];
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $successurl = $siteaddress . _url("modules/gateways/callback/futuelink.php");
    $cancelurl = $siteaddress . _url("viewinvoice/id/" . md5($invoiceid));
    $code = "";
    $code .= "<form name='frmMyOrder' id='frmMyOrder' action='https://shop.futuelink.com/shop-product-pv.php' method='post'>\n\t\t\t<input type='hidden' name='business' value='" . $USERNAME . "' />\n\t\t\t<input type='hidden' name='ak' value='" . $APIKEY . "' />\n\t\t\t<input type='hidden' name='invId' value='" . $invoiceid . "' />\n\t\t\t<input type='hidden' name='amount' value='" . $invoicetotal . "' />\n\t\t\t<input type='hidden' name='uEmail' value='" . $email . "' />\n\t\t\t<input type='hidden' name='uName' value='" . $clientname . "' />\n            <input type='hidden' name='currency' value='" . $currency . "' />\n            <input type='hidden' name='cancelurl' value='" . $cancelurl . "' />\n            <input type='hidden' name='successurl' value='" . $successurl . "' />\n            <input type='hidden' name='token' value='" . $token . "' />\n            <input type='hidden' name='futuelink' value='1' />\n            <input type='submit' class='btn btn-success  btn-primary paymentbtn paymentbtn'  value='Pay Now' />\n            </form>";
    return $code;
}

?>