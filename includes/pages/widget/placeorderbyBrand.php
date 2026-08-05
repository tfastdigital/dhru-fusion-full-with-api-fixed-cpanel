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
require_once ROOTDIR . "/includes/clients.fun.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$uniquebrand = "";
$sql = dquery("select id,assigned_brand from tbl_services_imei where retail='1'");
while ($row = mysqli_fetch_assoc($sql)) {
    if ($row["assigned_brand"] != "") {
        $brandarr = explode(",", $row["assigned_brand"]);
        foreach ($brandarr as $b) {
            $br = mysqli_fetch_assoc(dquery("select Name from tbl_model_brand where ID='" . $b . "'"));
            $uniquebrand[$b] = $br["Name"];
        }
    } else {
        if ($row["assigned_brand"] == "") {
            $br = dquery("select ID,Name from tbl_model_brand");
            while ($brand = mysqli_fetch_assoc($br)) {
                $uniquebrand[$brand["ID"]] = $brand["Name"];
            }
        }
    }
}
$smarty->assign("brandarr", $uniquebrand);
echo processSingleTemplate("brand_list");

?>