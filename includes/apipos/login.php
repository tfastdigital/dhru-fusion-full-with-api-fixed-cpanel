<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$AccoutInfo["credit"] = formatCurrency($UserDetails["credit"]["credit"], $UserDetails["currency"]);
$AccoutInfo["creditraw"] = round($UserDetails["credit"]["credit"], 3);
$AccoutInfo["mail"] = $UserDetails["email"];
$AccoutInfo["currency"] = $UserDetails["currency"]["code"];
$AccoutInfo["terminalid"] = $PosTermial["posterminalid"];
$AccoutInfo["clientgroup"] = $UserDetails["groupname"] ? $UserDetails["groupname"] : "Base";
$AccoutInfo["rewardpoint"] = $config["rewardpoint"];
$AccoutInfo["imei"] = $config["default_service_imei"];
$AccoutInfo["server"] = $config["default_service_server"];
$AccoutInfo["remote"] = $config["default_service_remote"];
$AccoutInfo["voucher"] = $config["voucher"];
if (!$UserDetails["access"]["imeiservice"]) {
    $AccoutInfo["imei"] = 0;
}
if (!$UserDetails["access"]["serverlogservice"]) {
    $AccoutInfo["server"] = 0;
}
if (!$UserDetails["access"]["remoteservice"]) {
    $AccoutInfo["remote"] = 0;
}
$apiresults["SUCCESS"][] = ["message" => "You are login sucessfully.", "data" => $AccoutInfo];

?>