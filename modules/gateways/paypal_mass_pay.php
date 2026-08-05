<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function paypal_mass_pay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Paypal Mass Pay"], "payto" => ["Name" => "PayPal Email", "Type" => "text", "Size" => "50"], "apiusername" => ["Name" => "PayPal APi Username ", "Type" => "text", "Size" => "50"], "apipassword" => ["Name" => "PayPal APi Passwored", "Type" => "text", "Size" => "50"], "apisignature" => ["Name" => "PayPal APi signature", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function paypal_mass_pay_link($params)
{
    global $config;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $code .= "<form action=\"masspay.php\" method=\"post\">";
    $code .= "<input type=\"hidden\" name=\"payto\" value=\"" . $params["payto"] . "\" />\n    <input type=\"hidden\" name=\"invoiceid\" value=\"" . $invoiceid . "\" />\n    <input type=\"hidden\" name=\"amount\" value=\"" . $invoicetotal . "\" />\n    <input type=\"hidden\" name=\"currency\" value=\"" . $params["currency"] . "\" />\n    <input type=\"hidden\" name=\"companyname\" value=\"" . $params["companyname"] . "\" />\n    <input type=\"submit\" value=\"Create Paypal Mass Pay File\"  name=\"dlfile\" class=\"btn-primary paymentbtn button btn btn-success\"  />\n    </form>\n    \n    <br />\n    \n    ";
    if ($params["apiusername"] && $params["apipassword"] && $params["apisignature"]) {
        $code .= "\n        <form action=\"masspay.php\" method=\"post\">\n        \n        <input type=\"hidden\" name=\"invoiceid\" value=\"" . $invoiceid . "\" />\n        <input type=\"text\" name=\"txnid\" value=\"\" placeholder=\"Transaction id\" />\n    \n        <input type=\"submit\" value=\"Submit details\"  name=\"submitdetails\" class=\"btn-primary paymentbtn button btn btn-success\"  />\n        </form>\n        ";
    }
    return $code;
}

?>