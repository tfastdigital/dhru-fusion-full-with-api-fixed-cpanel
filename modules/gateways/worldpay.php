<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["worldpayname"] = "worldpay";
$GATEWAYMODULE["worldpayvisiblename"] = "WorldPay";
$GATEWAYMODULE["worldpaytype"] = "Invoices";
function worldpay_activate()
{
    GatewayField("worldpay", "text", "installationid", "", "Installation ID", "20", "Enter your WorldPay Installation ID");
    GatewayField("worldpay", "yesno", "testmode", "", "Test Mode", "", "");
}
function worldpay_link($params)
{
    $link = "https://secure.worldpay.com/wcc/purchase";
    if ($params["testmode"] == "on") {
        $link = "https://secure-test.worldpay.com/wcc/purchase";
    }
    $code = "\n        <form action=\"" . $link . "\" method=\"post\">\n        <input type=\"hidden\" name=\"instId\" value=\"" . $params["installationid"] . "\">\n        <input type=\"hidden\" name=\"cartId\" value=\"" . $params["invoiceid"] . "\">\n        <input type=\"hidden\" name=\"desc\" value=\"" . $params["description"] . "\">\n        <input type=\"hidden\" name=\"amount\" value=\"" . $params["amount"] . "\">\n        <input type=\"hidden\" name=\"currency\" value=\"" . $params["currency"] . "\">\n        <input type=\"hidden\" name=\"name\" value=\"" . $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"] . "\">\n        <input type=\"hidden\" name=\"email\" value=\"" . $params["clientdetails"]["email"] . "\">\n        <input type=\"hidden\" name=\"address\" value=\"" . $params["clientdetails"]["address1"] . "" . $params["clientdetails"]["city"] . "" . $params["clientdetails"]["state"] . "\">\n        <input type=\"hidden\" name=\"postcode\" value=\"" . $params["clientdetails"]["postcode"] . "\">\n        <input type=\"hidden\" name=\"country\" value=\"" . $params["clientdetails"]["country"] . "\">\n        <input type=\"hidden\" name=\"tel\" value=\"" . $params["clientdetails"]["phone"] . "\">";
    if ($params["testmode"] == "on") {
        $code .= "<input type=\"hidden\" name=\"testMode\" value=\"100\">";
    }
    if ($params["authmode"] == "on") {
        $code .= "<input type=\"hidden\" name=\"authMode\" value=\"E\">";
    }
    $code .= "\n        <INPUT TYPE=\"hidden\" NAME=\"MC_callback\" VALUE=\"" . $params["systemurl"] . "/modules/gateways/callback/worldpay.php\">\n        <input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $params["langpaynow"] . "\">\n        </form>\n        ";
    return $code;
}

?>