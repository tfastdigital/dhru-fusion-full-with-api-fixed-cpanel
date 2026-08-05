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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$type = preg_replace("/[^0-9a-zA-Z]/i", "", $type);
$OUT = [];
if ($type == "imei") {
    $q = dquery("select id,group_name from tbl_imei_group where active=1 \nand server='0' order by display_order asc");
    while ($r = mysqli_fetch_assoc($q)) {
        $OUT[$r["id"]] = $r["group_name"];
    }
} else {
    if ($type == "server") {
        $q = dquery("select id,group_name from tbl_imei_group where active=1 \nand server='1' order by display_order asc");
        while ($r = mysqli_fetch_assoc($q)) {
            $OUT[$r["id"]] = $r["group_name"];
        }
    } else {
        if ($type == "remote") {
            $q = dquery("select id,group_name from tbl_imei_group where active=1 \nand server='2' order by display_order asc");
            while ($r = mysqli_fetch_assoc($q)) {
                $OUT[$r["id"]] = $r["group_name"];
            }
        } else {
            $q = dquery("select id,group_name from tbl_file_group where active=1 \n order by display_order asc");
            while ($r = mysqli_fetch_assoc($q)) {
                $OUT[$r["id"]] = $r["group_name"];
            }
        }
    }
}
$smarty->assign("group", $OUT);
echo processSingleTemplate("servicegroup");

?>