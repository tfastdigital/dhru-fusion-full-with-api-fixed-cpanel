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
installclient($pagetitle, $pageicon, $breadcrumbnav);
$pagelimit = 1000;
$grouparr = [];
require_once ROOTDIR . "/includes/imeiservices.fun.php";
$useasserver = 0;
if ($server == 1) {
    $useasserver = 1;
} else {
    if ($server == 2) {
        $useasserver = 2;
    }
}
$q = dquery("select id,group_name from tbl_imei_group where active=1\r\nand id in (select distinct(group_id) from tbl_services_imei where active=1 and retail=1)\r\nand `server`='" . $useasserver . "' \r\norder by display_order asc");
while ($r = mysqli_fetch_assoc($q)) {
    $r["item"] = NULL;
    $q1 = dquery("select id,service_name from tbl_services_imei where active=1 and retail=1 and group_id='" . $r["id"] . "' order by sort asc");
    while ($r1 = mysqli_fetch_assoc($q1)) {
        $r["item"][$r1["id"]] = $r1["service_name"];
    }
    $grouparr[$r["id"]] = $r;
}
$tempalte_ver["itemlist"] = $grouparr;
echo processSingleTemplate("retailitem");

?>