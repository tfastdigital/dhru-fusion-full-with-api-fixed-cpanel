<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require ROOTDIR . "/includes/imeiservices.fun.php";
$AccoutInfo["credit"] = formatCurrency($UserDetails["credit"]["credit"], $UserDetails["currency"]);
$AccoutInfo["mail"] = $UserDetails["email"];
$AccoutInfo["currency"] = $UserDetails["currency"]["code"];
$AccoutInfo["firstname"] = $UserDetails["firstname"];
$AccoutInfo["lastname"] = $UserDetails["lastname"];
$AccoutInfo["addressone"] = $UserDetails["address1"];
$AccoutInfo["addresstwo"] = $UserDetails["address2"];
$AccoutInfo["city"] = $UserDetails["city"];
$AccoutInfo["state"] = $UserDetails["state"];
$AccoutInfo["zip"] = $UserDetails["zip"];
$AccoutInfo["country"] = $UserDetails["country"];
$AccoutInfo["phonenumber"] = $UserDetails["phonenumber"];
$apiresults["SUCCESS"][] = ["message" => "Your Accout Info", "AccoutInfo" => $AccoutInfo];

?>