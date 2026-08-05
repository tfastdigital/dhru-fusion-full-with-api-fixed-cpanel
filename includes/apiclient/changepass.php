<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "CURRENT";
$checkParameter[] = "PASS";
$checkParameter[] = "COMFR";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$apiresults = checkParameters($checkParameter);
$parameters = $apiresults;
if ($parameters["ERROR"]) {
    $apiresults["ERROR"] = "Required field should not blank";
} else {
    $validator = NULL;
    $validator["current"] = $parameters["CURRENT"];
    $validator["password"] = $parameters["PASS"];
    $validator["confirmation"] = $parameters["COMFR"];
    if ($error = validatePassword($validator)) {
        $apiresults["ERROR"] = $error;
    }
    if (!$apiresults["ERROR"] && ($error = savePassword($validator, $_ClientsDetails["id"]))) {
        $apiresults["ERROR"] = $error;
    }
    if (!$apiresults["ERROR"]) {
        $apiresults["SUCCESS"] = "Password changed successfully";
    } else {
        $apiresults["ERROR"] = str_replace("<li>", "", $apiresults["ERROR"]);
        $apiresults["ERROR"] = str_replace("</li>", "", $apiresults["ERROR"]);
    }
}
echo " ";

?>