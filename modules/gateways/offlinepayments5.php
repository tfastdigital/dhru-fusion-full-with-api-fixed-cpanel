<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["offlinepayments5name"] = "offlinepayments5";
$GATEWAYMODULE["offlinepayments5visiblename"] = "Custom Payment Gateway 5";
$GATEWAYMODULE["offlinepayments5type"] = "Invoices";
function offlinepayments5_activate()
{
    global $GATEWAYMODULE;
    GatewayField("offlinepayments5", "textarea", "instructions", "Bank Name:\nPayee Name:\nSort Code:\nAccount Number:", "Bank Transfer Instructions", "5", "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above");
    GatewayField("cash", "yesno", "POS (Point of sales)", 1, "", "", "");
    GatewayField("uploadimg", "yesno", "Client can upload screenshot", 1, "", "", "");
}
function offlinepayments5_link($params)
{
    global $_LANG;
    global $lng_languag;
    $code = "<p>" . nl2br($params["instructions"]) . "<br>" . $_LANG["invoicerefnum"] . $lng_languag["invoicerefnum"] . ": " . $params["invoiceid"] . "</p>";
    return html_entity_decode($code);
}

?>