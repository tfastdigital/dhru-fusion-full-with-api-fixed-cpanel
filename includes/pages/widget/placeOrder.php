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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$uniquebrand = "";
if ($config["quick_checkout"] == 5) {
    $q = dquery("select id,group_id,(select group_name from tbl_imei_group\nwhere id=group_id) as groupname,service_name,retail_name from tbl_services_imei\nwhere retail=1");
    while ($r = mysqli_fetch_assoc($q)) {
        $SERVICE[$r["groupname"]][$r["id"]] = $r["retail_name"] ? $r["retail_name"] : $r["service_name"];
    }
    $smarty->assign("servicearr", $SERVICE);
} else {
    $sql = dquery("select id,assigned_brand from tbl_services_imei\n     where retail='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($row["assigned_brand"] != "") {
            if (mysqli_num_rows(dquery("select Name from tbl_model_brand\n            where ID in (" . $row["assigned_brand"] . ")"))) {
                $q = dquery("select Name,ID from tbl_model_brand where ID IN \n                (" . $row["assigned_brand"] . ")");
                while ($r = mysqli_fetch_assoc($q)) {
                    $uniquebrand[$r["ID"]] = $r["Name"];
                }
            }
        } else {
            if ($row["assigned_brand"] == "") {
                $br = dquery("select ID,Name from tbl_model_brand ORDER BY Name ASC");
                while ($brand = mysqli_fetch_assoc($br)) {
                    $uniquebrand[$brand["ID"]] = $brand["Name"];
                }
            }
        }
    }
    $smarty->assign("brandarr", $uniquebrand);
}
if ($new) {
    $_SESSION["NEWTEMP"] = true;
} else {
    unset($_SESSION["NEWTEMP"]);
}
$smarty->assign("quickwidget", $_SESSION["quickwidget"]);
echo processSingleTemplate("client_retailorder");

?>