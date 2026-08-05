<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$Services = [];
$AllowedServices = [];
$Gq = dquery("select id,service_name,useasserver,icon_link,purchasepoint from tbl_services_imei where `purchasepoint`>0");
while ($r = mysqli_fetch_assoc($Gq)) {
    $Services[] = $r;
}
$apiresults["SUCCESS"][] = ["message" => "Services List", "data" => $Services];

?>