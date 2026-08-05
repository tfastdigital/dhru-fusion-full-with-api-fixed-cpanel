<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
if ($_SESSION["ACCESS_API"]) {
    $apiresults["STATUS"] = "SUCCESS";
    $apiresults["MESSAGE"] = "Connection successfull";
    $apiresults["VERSION"] = $api_version;
}

?>