<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$pagelimit = 1000;
require ROOTDIR . "/includes/imeiservices.fun.php";
$ServiceDetails = getIMEIServices("", "", $UserDetails["id"], true, false, "");
$NewServiceDetails = NULL;
foreach ($ServiceDetails as $Group => $Services) {
    $NewServiceDetails[$Group]["GROUPNAME"] = $Group;
    foreach ($Services as $Service) {
        $FullServiceDetails = getIMEIServices("", md5($Service["id"]), $UserDetails["id"], true);
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICEID"] = $Service["id"] * 9 + 5;
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICENAME"] = $Service["service_name"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["SERVICETYPE"] = $Service["useasserver"] ? "SERVER" : "IMEI";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["QNT"] = $FullServiceDetails["qnt"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CREDIT"] = $Service["credit"] == "" ? "-" : $Service["credit"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["TIME"] = $Service["time"] == "" ? "-" : $Service["time"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["INFO"] = $Service["info"] == "" ? "-" : utf8_encode($Service["info"]);
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["CUSTOM"] = $Service["CUSTOM"];
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Network"] = $FullServiceDetails["reqredfield"]["network"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Mobile"] = $FullServiceDetails["reqredfield"]["model"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Provider"] = $FullServiceDetails["reqredfield"]["provider"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.PIN"] = $FullServiceDetails["reqredfield"]["PIN"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.KBH"] = $FullServiceDetails["reqredfield"]["KBH"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.MEP"] = $FullServiceDetails["reqredfield"]["mep"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.PRD"] = $FullServiceDetails["reqredfield"]["PRD"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Type"] = $FullServiceDetails["reqredfield"]["type"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Locks"] = $FullServiceDetails["reqredfield"]["locks"] == "1" ? "Required" : "None";
        $NewServiceDetails[$Group]["SERVICES"][$Service["id"]]["Requires.Reference"] = $FullServiceDetails["reqredfield"]["reference"] == "1" ? "Required" : "None";
    }
}
$apiresults["SUCCESS"][] = ["MESSAGE" => "IMEI Service List", "LIST" => $NewServiceDetails];
unset($NewServiceDetails);
unset($ServiceDetails);

?>