<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function tco_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "2CheckOut"], "vendornumber" => ["FriendlyName" => "Vendor Account Number", "Type" => "text", "Size" => "10", "Description" => "The vendor account number you have with 2CheckOut"], "apiusername" => ["FriendlyName" => "API Username", "Type" => "text", "Size" => "10", "Description" => "The API username you have with 2CheckOut"], "apipassword" => ["FriendlyName" => "API Password", "Type" => "text", "Size" => "10", "Description" => "The API password you have with 2CheckOut"], "secretword" => ["FriendlyName" => "Secret Word", "Type" => "text", "Size" => "20", "Description" => "To verify callbacks come from the 2CheckOut server you can enter your secret word here"], "purchaseroutine" => ["FriendlyName" => "Purchase Routine", "Type" => "yesno", "Description" => "Tick to use 2CO Cart Checkout Routine (Shows PayPal Option)"], "demomode" => ["FriendlyName" => "Demo Mode", "Type" => "yesno"]];
    return $configarray;
}
function tco_link($params)
{
    if (!$params["purchaseroutine"]) {
        $purchaseroutine = "s";
    }
    $code .= "\n\n<form action=\"https://www.2checkout.com/checkout/spurchase\" method=\"post\">\n<input type=\"hidden\" name=\"sid\" value=\"" . $params["vendornumber"] . "\" >\n<input type=\"hidden\" name=\"mode\" value=\"2CO\" >\n<input type=\"hidden\" name=\"li_0_type\" value=\"product\" >\n<input type=\"hidden\" name=\"li_0_name\" value=\"" . $params["description"] . " - " . $params["orderid"] . "\" >\n<input type=\"hidden\" name=\"li_0_price\" value=\"" . $params["amount"] . "\" >\n<input type=\"hidden\" name=\"li_0_quantity\" value=\"1\" >\n<input type=\"hidden\" name=\"return_url\" value=\"" . $params["systemurl"] . _url("cart") . "\">\n<input type=\"hidden\" name=\"x_receipt_link_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/2checkout.php\">\n<input type=\"hidden\" name=\"li_0_tangible\" value=\"N\" >";
    if ($params["purchaseroutine"]) {
        $code .= "<input type=\"hidden\" name=\"pay_method\" value=\"PPI\"/>";
    }
    if ($params["demomode"] == "on") {
        $code .= "<input type=\"hidden\" name=\"demo\" value=\"Y\">";
    }
    $code .= "<input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $params["langpaynow"] . "\">\n              </form>";
    return $code;
}

?>