<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$pagelimit = 1000;
require ROOTDIR . "/includes/fileservices.fun.php";
$ServiceDetails = getFileServices("", "", $UserDetails["id"], true, "", "", "", "", "", 9898989);
$NewServiceDetails = NULL;
foreach ($ServiceDetails as $Group => $Services) {
    $NewServiceDetails[$Group]["GROUPNAME"] = $Group;
    foreach ($Services as $Service) {
        $FullServiceDetails = getFileServices("", md5($Service["id"]), $UserDetails["id"], true);
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICEID"] = $Service["id"] * 9 + 5;
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICENAME"] = $Service["service_name"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CREDIT"] = $Service["credit"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["TIME"] = $Service["time"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["ALLOW_EXTENSION"] = $Service["allow_extension"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["INFO"] = $Service["info"];
    }
}
if ($NewServiceDetails) {
    $apiresults["SUCCESS"][] = ["MESSAGE" => "File Service List", "LIST" => $NewServiceDetails];
} else {
    $apiresults["ERROR"][] = ["MESSAGE" => "No File Service Active in your account"];
}
unset($NewServiceDetails);
unset($ServiceDetails);

?>