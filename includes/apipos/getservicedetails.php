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
$checkParameter[] = "ID";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    $ServiceDetails = getIMEIServicesNew("", md5($parameters["ID"]), $UserDetails["id"], true);
    if ($ServiceDetails["useasserver"] == 0) {
        $OUT["imei"]["field"] = $ServiceDetails["imei_bulk"] ? "bulk" : "single";
        $OUT["imei"]["custom"] = $ServiceDetails["imei_custom"];
        $OUT["imei"]["customname"] = $ServiceDetails["imei_custom_name"];
        $OUT["imei"]["customlength"] = $ServiceDetails["imei_custom_len"];
        $OUT["imei"]["custominfo"] = $ServiceDetails["imei_custom_info"];
        $OUT["imei"]["isalpha"] = $ServiceDetails["isalpha"];
        $OUT["imei"]["maxlength"] = $ServiceDetails["maxlength"];
        $OUT["imei"]["model"] = $ServiceDetails["model"];
        $OUT["imei"]["provider"] = $ServiceDetails["provider"];
        $OUT["imei"]["PIN"] = $ServiceDetails["PIN"];
        $OUT["imei"]["KBH"] = $ServiceDetails["KBH"];
        $OUT["imei"]["mep"] = $ServiceDetails["mep"];
        $OUT["imei"]["PRD"] = $ServiceDetails["PRD"];
        $OUT["imei"]["SN"] = $ServiceDetails["SN"];
        $OUT["imei"]["reference"] = $ServiceDetails["Reference"];
        $OUT["imei"]["SecRO"] = $ServiceDetails["SecRO"];
        $OUT["imei"]["Type"] = $ServiceDetails["Type"];
    }
    $OUT["credit"] = $ServiceDetails["credit"];
    $OUT["point"] = $ServiceDetails["purchasepoint"];
    $OUT["id"] = $ServiceDetails["id"];
    $Fav = mysqli_fetch_assoc(dquery("select imeifrequent,client_group from tblUsers\nwhere id='" . $UserDetails["id"] . "'"));
    $freq = explode(",", $Fav["imeifrequent"]);
    if (in_array($ServiceDetails["id"], $freq)) {
        $OUT["favourite"] = true;
    }
    $OUT["allpricing"] = $ServiceDetails["allpricing"];
    $OUT["service_name"] = $ServiceDetails["service_name"];
    $OUT["qntoptions"] = $ServiceDetails["qntoptions"];
    $OUT["qnt"] = $ServiceDetails["qnt"];
    $OUT["minqnt"] = $ServiceDetails["minqnt"];
    $OUT["info"] = $ServiceDetails["info"];
    $OUT["time"] = $ServiceDetails["time"];
    $OUT["maxqnt"] = $ServiceDetails["maxqnt"];
    $OUT["qntrange"] = $ServiceDetails["qntrange"];
    $OUT["qntrangejson"] = $ServiceDetails["qntrangejson"];
    $OUT["customfield"] = getCustomFields("serviceimei", $ServiceDetails["id"], "");
    $OUT["ordernotes"] = $config["ordernotes"];
    $apiresults["SUCCESS"][] = ["message" => "Services Detail", "Service Details" => $OUT];
}

?>