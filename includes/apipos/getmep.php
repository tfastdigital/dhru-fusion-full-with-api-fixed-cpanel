<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "serviceid";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $serviceid = $parameters["serviceid"];
    $Service = mysqli_fetch_assoc(dquery("select API,API_ID from tbl_services_imei where id='" . $serviceid . "'"));
    $q = dquery("select id as ID,mep as Name from tbl_mep where api='" . $Service["API"] . "' ");
    while ($r = mysqli_fetch_assoc($q)) {
        $OUT[] = $r;
    }
    $apiresults["SUCCESS"][] = ["message" => "mep", "data" => $OUT];
}

?>