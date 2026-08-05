<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function moneybookers_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Moneybookers"], "merchantemail" => ["Name" => "Login Email", "Type" => "text", "Size" => "40"], "SecretWord" => ["Name" => "Secret Word", "Type" => "text", "Size" => "40"]];
    return $configarray;
}
function moneybookers_link($params)
{
    global $config;
    $code = "<form action=\"https://www.moneybookers.com/app/payment.pl\">\n    <input type=\"hidden\" name=\"pay_to_email\" value=\"" . $params["merchantemail"] . "\">\n    <input type=\"hidden\" name=\"pay_from_email\" value=\"" . $params["clientdetails"]["email"] . "\">\n    <input type=\"hidden\" name=\"language\" value=\"EN\">\n    <input type=\"hidden\" name=\"amount\" value=\"" . $params["amount"] . "\">\n    <input type=\"hidden\" name=\"currency\" value=\"" . $params["currency"] . "\">\n    <input type=\"hidden\" name=\"recipient_description\" value=\"" . $CONFIG["CompanyName"] . "\">\n    <input type=\"hidden\" name=\"detail1_description\" value=\"" . $params["description"] . "\">\n    <input type=\"hidden\" name=\"detail1_text\" value=\"" . $params["invoiceid"] . "\">\n    <input type=\"hidden\" name=\"return_url\" value=\"" . $params["returnurl"] . "&paymentsuccess=true\">\n    <input type=\"hidden\" name=\"cancel_url\" value=\"" . $params["returnurl"] . "&paymentfailed=true\">\n    <input type=\"hidden\" name=\"status_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/moneybookers.php\">\n    <input type=\"hidden\" name=\"transaction_id\" value=\"" . $params["invoiceid"] . "\">\n    <input type=\"hidden\" name=\"firstname\" value=\"" . $params["clientdetails"]["firstname"] . "\">\n    <input type=\"hidden\" name=\"lastname\" value=\"" . $params["clientdetails"]["lastname"] . "\">\n    <input type=\"hidden\" name=\"address\" value=\"" . $params["clientdetails"]["address1"] . "\">\n    <input type=\"hidden\" name=\"city\" value=\"" . $params["clientdetails"]["city"] . "\">\n    <input type=\"hidden\" name=\"state\" value=\"" . $params["clientdetails"]["state"] . "\">\n    <input type=\"hidden\" name=\"postal_code\" value=\"" . $params["clientdetails"]["postcode"] . "\">\n    <input type=\"submit\" class=\"btn btn-success  btn-primary paymentbtn\" value=\"" . $params["langpaynow"] . "\">\n    </form>";
    return $code;
}

?>