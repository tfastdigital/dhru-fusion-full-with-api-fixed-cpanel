<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
$checkParameter[] = "FILENAME";
$checkParameter[] = "FILEDATA";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    require_once ROOTDIR . "/includes/fileservices.fun.php";
    $id = md5(($parameters["ID"] - 5) / 9);
    global $erroring;
    if ($serviceDetails = getFileServices("", $id, $UserDetails["id"], true)) {
        global $erroring;
        $_FILES =& $_FILES;
        global $BYAPI;
        global $tempalte_ver;
        $BYAPI = true;
        $_FILES["ask"]["name"] = trim($parameters["FILENAME"]);
        $_FILES["ask"]["filedata"] = $parameters["FILEDATA"];
        $_FILES["bulk"]["error"] = NULL;
        if (!placeOrderFilevalidation($serviceDetails)) {
            $apiresults["ERROR"][] = ["MESSAGE" => "ValidationError", "FULL_DESCRIPTION" => $erroring];
        } else {
            $tempalte_ver["notification"]["error"] = NULL;
            creditProcessFile($serviceDetails);
            if ($tempalte_ver["notification"]["error"]) {
                $apiresults["ERROR"][] = ["MESSAGE" => "CreditprocessError", "FULL_DESCRIPTION" => $tempalte_ver["notification"]["error"]];
            } else {
                $_status = explode(":", $tempalte_ver["notification"]["success"]);
                $apiresults["SUCCESS"][] = ["MESSAGE" => "Order received", "REFERENCEID" => $_status[1]];
            }
        }
        unset($NewServiceDetails);
        unset($ServiceDetails);
    } else {
        $apiresults["ERROR"][] = ["MESSAGE" => "Invalid service id"];
    }
}
echo " ";

?>