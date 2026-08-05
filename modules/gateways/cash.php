<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["cashname"] = "cash";
$GATEWAYMODULE["cashvisiblename"] = "Cash";
$GATEWAYMODULE["cashtype"] = "Invoices";
function cash_activate()
{
    global $GATEWAYMODULE;
    GatewayField("cash", "textarea", "instructions", "", "5", "The instructions you want displaying to customers who choose this payment method - the invoice number will be shown underneath the text entered above", "");
    GatewayField("cash", "yesno", "POS (Point of sales)", 1, "", "", "", "");
}
function cash_link($params)
{
    global $_LANG;
    global $lng_languag;
    global $config;
    $code = "<p>" . nl2br($params["instructions"]) . "<br>" . $_LANG["invoicerefnum"] . $lng_languag["invoicerefnum"] . ": " . $config["invoiceprefix"] . $params["mask"] . "</p>";
    return html_entity_decode($code);
}

?>