<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "FIRST";
$checkParameter[] = "LAST";
$checkParameter[] = "ADDRESS1";
$checkParameter[] = "ADDRESS2";
$checkParameter[] = "COUNTRY";
$checkParameter[] = "PHONE";
$checkParameter[] = "STATE";
$checkParameter[] = "CITY";
$checkParameter[] = "ZIP";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$apiresults = checkParameters($checkParameter);
$parameters = $apiresults;
if ($parameters["ERROR"]) {
    $apiresults["ERROR"] = "Required field should not blank";
} else {
    $validator = NULL;
    $validator["phonenumber"] = [nl2br($parameters["PHONE"]), true];
    $validator["first_name"] = [nl2br($parameters["FIRST"]), true];
    $validator["last_name"] = [nl2br($parameters["LAST"]), true];
    $validator["address1"] = [htmlspecialchars(strip_tags($parameters["ADDRESS1"])), true];
    $validator["address2"] = [htmlspecialchars(strip_tags($parameters["ADDRESS2"])), false];
    $validator["city"] = [nl2br($parameters["CITY"]), true];
    $validator["state"] = [nl2br($parameters["STATE"]), true];
    $validator["zip"] = [nl2br($parameters["ZIP"]), true];
    if ($config["loginsecurity_country"]) {
        $validator["country"] = [nl2br($parameters["COUNTRY"]), true];
    }
    if ($error = validateProfiles($validator)) {
        $apiresults["ERROR"] = $error;
    }
    if (!$apiresults["ERROR"]) {
        $validator["username"] = [nl2br($_ClientsDetails["username"]), false];
        $validator["email"] = [nl2br($_ClientsDetails["email"]), false];
        if ($error = saveProfiles($validator, $_ClientsDetails["id"])) {
            $apiresults["ERROR"] = $error;
        }
    }
    if (!$apiresults["ERROR"]) {
        $apiresults["SUCCESS"] = "Profile save successfully";
    } else {
        $apiresults["ERROR"] = str_replace("<li>", "", $apiresults["ERROR"]);
        $apiresults["ERROR"] = str_replace("</li>", "", $apiresults["ERROR"]);
    }
}
echo " ";

?>