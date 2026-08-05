<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function directpaypal2_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Direct Add Paypal Transaction 2"], "payto" => ["Name" => "PayPal Email", "Type" => "text", "Size" => "50"], "apiusername" => ["Name" => "PayPal APi Username ", "Type" => "text", "Size" => "50"], "apipassword" => ["Name" => "PayPal APi Passwored", "Type" => "text", "Size" => "50"], "apisignature" => ["Name" => "PayPal APi signature", "Type" => "text", "Size" => "50"], "transactionvalidationdays" => ["Name" => "Transaction validation days", "Type" => "text", "Size" => "50"], "normalpayment" => ["Name" => "Accept Normal Payments", "Type" => "yesno"], "masspay" => ["Name" => "Accept Gift/Mass Payments", "Type" => "yesno"], "infor" => ["Name" => "Information", "Type" => "textarea"]];
    return $configarray;
}

?>