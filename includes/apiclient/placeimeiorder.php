<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
$checkParameter[] = "IMEI";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    require ROOTDIR . "/includes/imeiservices.fun.php";
    $id = md5(($parameters["ID"] - 5) / 9);
    $serviceDetails = getIMEIServices("", $id, $UserDetails["id"], true, false, "");
    $imei_custom = $imei_bulk = $parameters["IMEI"];
    $model_id = $parameters["MODELID"];
    $provider_id = $parameters["PROVIDERID"];
    $network_id = $parameters["NETWORKID"];
    $mep = $parameters["MEP"];
    $PIN = $parameters["PIN"];
    $KBH = $parameters["KBH"];
    $PRD = $parameters["PRD"];
    $Type = $parameters["TYPE"];
    $Reference = $parameters["REFERENCE"];
    $Locks = $parameters["LOCKS"];
    if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true)) {
        $error = html_entity_decode($error);
        $error = str_replace("error:", "\n", $error);
        $error = str_replace("</li>", "\n", $error);
        $error = str_replace("<li>", "", $error);
        $apiresults["ERROR"][] = ["MESSAGE" => "ValidationError", "FULL_DESCRIPTION" => $error];
    } else {
        if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails)) {
            $_status = explode(":", $error);
            if ($_status[0] == "success") {
                $apiresults["SUCCESS"][] = ["MESSAGE" => "Order received", "REFERENCEID" => $_status[2]];
            } else {
                $error = html_entity_decode($error);
                $error = str_replace("error:", "\n", $error);
                $error = str_replace("</li>", "\n", $error);
                $error = str_replace("<li>", "", $error);
                $apiresults["ERROR"][] = ["MESSAGE" => "CreditprocessError", "FULL_DESCRIPTION" => $error];
            }
        }
    }
    unset($NewServiceDetails);
    unset($ServiceDetails);
}
echo " ";

?>