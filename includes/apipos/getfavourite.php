<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($UserDetails["id"]) {
    $Fav = mysqli_fetch_assoc(dquery("select imeifrequent,client_group from tblUsers\nwhere id='" . $UserDetails["id"] . "'"));
    $freq = explode(",", $Fav["imeifrequent"]);
    $Services = [];
    $Fav["imeifrequent"] = ltrim($Fav["imeifrequent"], ",");
    $Fav["imeifrequent"] = rtrim($Fav["imeifrequent"], ",");
    $Frequent = str_replace(",,", ",", $Fav["imeifrequent"]);
    $Sq = dquery("select id,service_name,`sort`,`useasserver`,icon_link \n        from tbl_services_imei  WHERE id in (" . $Frequent . ")");
    while ($rs = mysqli_fetch_assoc($Sq)) {
        $ServicePrice = new ServicePrice($rs["id"]);
        $rs["credit"] = $ServicePrice->getServicePricing($UserDetails["currency_id"], 1, $Fav["client_group"], $UserDetails["id"]);
        $rs["service_name"] = html_entity_decode($rs["service_name"]);
        $Services[] = $rs;
    }
    $apiresults["SUCCESS"][] = ["message" => "Favourite Service", "data" => $Services];
}

?>