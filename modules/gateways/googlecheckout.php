<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$GATEWAYMODULE["googlecheckoutname"] = "googlecheckout";
$GATEWAYMODULE["googlecheckoutvisiblename"] = "Google Checkout";
$GATEWAYMODULE["googlecheckouttype"] = "Invoices";
$GATEWAYMODULE["googlecheckoutnotes"] = "In order to use Google Checkout in a live environment, you must have an SSL certificate. Inside your Google Checkout account you need to go to <i>Settings > Preferences > Order processing preferences</i> and select the option <i>Automatically authorize and charge the buyer's credit card.</i>  Also, in <i>Settings > Integration</i> you must enter the following callback url: " . $config["SystemSSLURL"] . "/modules/gateways/callback/googlecheckout.php";
function googlecheckout_activate()
{
    GatewayField("googlecheckout", "text", "merchantid", "", "Merchant ID", "30", "");
    GatewayField("googlecheckout", "text", "merchantkey", "", "Merchant Key", "40", "");
    GatewayField("googlecheckout", "yesno", "sandbox", "", "Sandbox Mode", "", "");
}
function googlecheckout_link($params, $quick = "")
{
    if ($params["sandbox"]) {
        $url = "https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/";
    } else {
        $url = "https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/";
    }
    $code = "<form action=\"" . $url . $params["merchantid"] . "\" id=\"BB_BuyButtonForm\" method=\"post\" name=\"BB_BuyButtonForm\">\n    <input name=\"item_name_1\" type=\"hidden\" value=\"Invoice Payment\"/>\n    <input name=\"item_description_1\" type=\"hidden\" value=\"" . $params["description"] . "\"/>\n    <input name=\"item_quantity_1\" type=\"hidden\" value=\"1\"/>\n    <input name=\"item_price_1\" type=\"hidden\" value=\"" . $params["amount"] . "\"/>\n    <input name=\"item_currency_1\" type=\"hidden\" value=\"" . $params["currency"] . "\"/>\n    <input type=\"hidden\" name=\"shopping-cart.items.item-1.digital-content.email-delivery\" value=\"true\" />\n    <input name=\"item_merchant_id_1\" type=\"hidden\" value=\"" . $params["invoiceid"] . "\"/>\n    <input name=\"continue_url\" type=\"hidden\" value=\"" . $params["systemurl"] . "/viewinvoice.php?id=" . md5($params["invoiceid"]) . "\"/>\n    <input name=\"_charset_\" type=\"hidden\" value=\"utf-8\"/>\n    <input type=\"image\" class=\"btn btn-primary paymentbtn\" name=\"Google Checkout\" alt=\"Fast checkout through Google\" src=\"https://checkout.google.com/buttons/checkout.gif?merchant_id=" . $params["merchantid"] . "&w=180&h=46&style=white&variant=text&loc=en_US\" height=\"46\" width=\"180\"/>\n</form>";
    return $code;
}
function googlequickcheckout_link($params, $quick = "")
{
    if ($params["sandbox"]) {
        $url = "https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/";
    } else {
        $url = "https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/";
    }
    $code = "<form action=\"" . $url . $params["merchantid"] . "\" \n    id=\"BB_BuyButtonForm\" method=\"post\" name=\"BB_BuyButtonForm\">\n    <input name=\"item_name_1\" type=\"hidden\" value=\"" . $params["description"] . "\"/>\n    <input name=\"item_description_1\" type=\"hidden\" value=\"" . $params["description"] . " [OID: #" . $params["id"] . "]\"/>\n    <input name=\"item_quantity_1\" type=\"hidden\" value=\"1\"/>";
    if (0 < $params["tax"]) {
        $code .= "<input type=\"hidden\" name=\"tax_rate\" value=\"" . round($params["tax"], 2) . "\"/>";
    }
    $code .= "<input name=\"item_price_1\" type=\"hidden\" value=\"" . $params["amount"] . "\"/>\n    <input name=\"item_currency_1\" type=\"hidden\" value=\"" . $params["currency"] . "\"/>\n    <input type=\"hidden\" name=\"shopping-cart.items.item-1.digital-content.email-delivery\" value=\"true\" />\n    <input name=\"item_merchant_id_1\" type=\"hidden\" value=\"QUICK-" . $params["orderid"] . "\"/>\n    <input name=\"continue_url\" type=\"hidden\" value=\"" . $params["systemurl"] . "/viewinvoice.php?id=" . md5($params["invoiceid"]) . "\"/>\n    <input name=\"_charset_\" type=\"hidden\" value=\"utf-8\"/>\n    <input type=\"image\" class=\"btn btn-primary paymentbtn\" name=\"Google Checkout\" alt=\"Fast checkout through Google\" src=\"https://checkout.google.com/buttons/checkout.gif?merchant_id=" . $params["merchantid"] . "&w=180&h=46&style=white&variant=text&loc=en_US\" height=\"46\" width=\"180\"/>\n</form>";
    return $code;
}

?>