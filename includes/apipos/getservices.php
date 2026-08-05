<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require_once ROOTDIR . "/includes/imeiservices.fun.php";
$Services = [];
$AllowedServices = [];
$ClientGorup = $UserDetails["client_group"];
if (!$ClientGorup) {
    $ClientGorup = "base";
}
$qA = dquery("select serviceid from tbl_service_status where groupid='" . $ClientGorup . "' and status='1'");
while ($rs = mysqli_fetch_assoc($qA)) {
    $AllowedServices[] = $rs["serviceid"];
}
if (count($AllowedServices)) {
    $Gq = dquery("select id,`server`,group_name,imagelink,display_order \nfrom tbl_imei_group where `active`=1");
    while ($r = mysqli_fetch_assoc($Gq)) {
        $ServiceType = $r["server"] == 2 ? "remote" : ($r["server"] == 1 ? "server" : "imei");
        $Services[$r["id"]][$ServiceType]["group"] = $r;
        $Sq = dquery("select id,service_name,`sort`,`useasserver`,icon_link \n        from tbl_services_imei  WHERE group_id='" . $r["id"] . "'\n        and id in (" . implode(",", $AllowedServices) . ")");
        while ($rs = mysqli_fetch_assoc($Sq)) {
            $ServicePrice = new ServicePrice($rs["id"]);
            $rs["credit"] = $ServicePrice->getServicePricing($UserDetails["currency_id"], 1, $ClientGorup, $UserDetails["id"]);
            $rs["service_name"] = html_entity_decode($rs["service_name"]);
            $Services[$r["id"]][$ServiceType]["service"][$rs["id"]] = $rs;
        }
        if (0 >= count($Services[$r["id"]][$ServiceType]["service"])) {
            unset($Services[$r["id"]]);
        }
    }
    $apiresults["SUCCESS"][] = ["message" => "Services List", "Services" => $Services];
} else {
    $apiresults["ERROR"][] = ["message" => "No service allocated"];
}

?>