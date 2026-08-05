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
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    require ROOTDIR . "/includes/imeiservices.fun.php";
    $parameters["ID"] = ($parameters["ID"] - 5) / 9;
    if ($parameters["ID"]) {
        $ServiceDetails = getIMEIServices("", md5($parameters["ID"]), $UserDetails["id"], true, false, "");
    }
}
if ($ServiceDetails["reqredfield"]["mep"] == "1") {
    if ($ServiceDetails["reqredfield"]["assigned_mep"]) {
        $WHERE = " WHERE`api`='" . $ServiceDetails["listing"] . "' AND `ID` IN (" . $ServiceDetails["reqredfield"]["assigned_mep"] . ")";
    }
    $result = dquery("SELECT `id`,`mep` FROM `tbl_mep` " . $WHERE);
    while ($data = mysqli_fetch_assoc($result)) {
    }
    if ($ServiceDetails["id"]) {
        if ($ServiceDetails["reqredfield"]["mep"] == "1") {
            $apiresults["SUCCESS"][] = ["MESSAGE" => "Mep List", "LIST" => $Brands];
        } else {
            $apiresults["ERROR"][] = ["MESSAGE" => "No MEP Required"];
        }
    } else {
        $apiresults["SUCCESS"][] = ["MESSAGE" => "Mep List", "LIST" => $Brands];
    }
    unset($NewServiceDetails);
    unset($ServiceDetails);
}
$Brands[$data["id"]]["NAME"] = $data["mep"];
$Brands[$data["id"]]["ID"] = $data["id"];

?>