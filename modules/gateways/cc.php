<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["ccname"] = "cc";
$GATEWAYMODULE["ccvisiblename"] = "Credit Card";
$GATEWAYMODULE["cctype"] = "Invoices";
function cc_activate()
{
    global $GATEWAYMODULE;
    GatewayField("cc", "textarea", "instructions", "", "5", "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above", "");
    GatewayField("cc", "yesno", "POS (Point of sales)", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Visa", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Americal Express", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Diners Club Carte Blanche", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Diners Club", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Discover", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Diners Club Enroute", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Japan Credit Bureau", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Maestro", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Solo", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Switch", 1, "", "", "", "");
    GatewayField("cc", "yesno", "VISA Electron", 1, "", "", "", "");
    GatewayField("cc", "yesno", "Laser Card", 1, "", "", "", "");
}
function cc_link($params)
{
    global $_LANG;
    global $lng_languag;
    global $config;
    $code = html_entity_decode("<p>" . nl2br($params["instructions"]) . "<br>" . $_LANG["invoicerefnum"] . $lng_languag["invoicerefnum"] . ": " . $config["invoiceprefix"] . $params["invoiceid"] . "</p>");
    return $code;
}

?>