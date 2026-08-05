<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
require ROOTDIR . "/includes/features.fun.php";
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $cmslink;
$tempalte_ver["serviceid"] = $serviceid;
if ($action == "productinfo") {
    $sql = mysqli_fetch_assoc(dquery("select retail_info from tbl_products where id='" . $serviceid . "'"));
    $tempalte_ver["id"] = $serviceid;
    if ($sql["retail_info"]) {
        if ($cmslink["iteminfo"][$serviceid]) {
            $tempalte_ver["info"] = $sql["retail_info"] . "<span style='float: right;'>\n            <a target='_blank' href='" . $cmslink["iteminfo"][$serviceid] . "'>Edit Information</a></span> \n            <div style='clear:both;'>&nbsp;</div>";
        } else {
            $tempalte_ver["info"] = $sql["retail_info"];
        }
    }
    echo processSingleTemplate("cart_productinfo");
} else {
    if ($action == "imeiinfo") {
        $sql = mysqli_fetch_assoc(dquery("select retail_info,info from tbl_services_imei where id='" . $serviceid . "'"));
        if ($sql["retail_info"]) {
            $tempalte_ver["info"] = nl2br($sql["retail_info"]);
        } else {
            $tempalte_ver["info"] = $lng_languag["norecordsfound"];
        }
        echo processSingleTemplate("cart_productinfo");
    }
}

?>