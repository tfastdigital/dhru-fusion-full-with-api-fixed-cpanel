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
$AccoutInfo["creditraw"] = round($UserDetails["credit"]["credit"], 3);
$AccoutInfo["mail"] = $UserDetails["email"];
$AccoutInfo["currency"] = $UserDetails["currency"]["code"];
$apiresults["SUCCESS"][] = ["message" => "Your Accout Info", "AccoutInfo" => $AccoutInfo];

?>