<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["codname"] = "cod";
$GATEWAYMODULE["codvisiblename"] = "cod";
$GATEWAYMODULE["codtype"] = "Invoices";
function cod_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "COD"], "info" => ["Name" => "Information", "Type" => "textarea", "Cols" => "5", "Rows" => "10"], "POS (Point of sales)" => ["Name" => "POS (Point of sales)", "Type" => "yesno", "Value" => "1"]];
    return $configarray;
}
function cod_link($params)
{
    global $config;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $code .= "<form action=\"" . _url("masspay/pay/cod") . "\" method=\"post\">";
    $code .= "\r\n    <input type=\"hidden\" name=\"invoiceid\" value=\"" . $invoiceid . "\" />\r\n    <input type=\"submit\" value=\"Confirm Order\"  name=\"btncod\"\r\n     class=\"button btn btn-success btn-primary paymentbtn\"  />\r\n    </form>";
    return $code;
}

?>