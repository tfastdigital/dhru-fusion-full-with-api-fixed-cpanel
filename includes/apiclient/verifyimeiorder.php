<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
$apiresults = checkParameters($checkParameter);
$parameters = $apiresults;
require ROOTDIR . "/includes/imeiservices.fun.php";
$oid = descape($parameters["ID"]);
$cancelorderid = md5(trim($oid));
if (verifyOrderIMEI($cancelorderid)) {
    $apiresults["SUCCESS"] = "Order sent for verification";
} else {
    $apiresults["ERROR"] = "Order not sent for verification !";
}
echo " ";

?>