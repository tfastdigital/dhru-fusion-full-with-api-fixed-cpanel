<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
$checkParameter[] = "serviceid";
$checkParameter[] = "brandid";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $serviceid = $parameters["serviceid"];
    $brandid = $parameters["brandid"];
    $Service = mysqli_fetch_assoc(dquery("select API,API_ID from tbl_services_imei where id='" . $serviceid . "'"));
    $q = dquery("select ID,Name from tbl_mobile where B_ID='" . $brandid . "'\n   and api='" . $Service["API"] . "' ");
    while ($r = mysqli_fetch_assoc($q)) {
        $OUT[] = $r;
    }
    $apiresults["SUCCESS"][] = ["message" => "Mobile", "data" => $OUT];
}

?>