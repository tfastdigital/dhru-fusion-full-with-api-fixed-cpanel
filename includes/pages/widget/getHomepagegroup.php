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
installclient($pagetitle, $pageicon, $breadcrumbnav);
require_once ROOTDIR . "/includes/products.fun.php";
$s = dquery("select * from tbl_homepagegroup ORDER BY sort");
$arr = [];
while ($r = mysqli_fetch_assoc($s)) {
    if ($r["pid"]) {
        if ($r["viewmore"]) {
            $row = mysqli_fetch_assoc(dquery("select id,group_name from tbl_product_group where id='" . $r["viewmore"] . "'"));
            $arr[$r["group"]]["viewmore"] = $config["cms_seofriendly"] ? $row["id"] . "/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $row["group_name"])) : "cart.php?group=" . $row["id"] . "&service=product";
        }
        $arr[$r["group"]]["items"] = getProducts("", "", "", true, "", "", true, "", "", "", "", "", $r["pid"], "", "", "", "", "", "", "", "RI");
    }
}
$tempalte_ver["homeitems"] = $arr;
echo processSingleTemplate("homepagegroup");

?>