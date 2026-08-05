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
$ids = preg_replace("/[^0-9a-zA-Z]/i", "", $ids);
require_once ROOTDIR . "/includes/products.fun.php";
$arr = [];
$sql = dquery("select id,bundle_list from tbl_products where \n    bundle='1' and bundle_list!='' and id='" . $ids . "'");
while ($row = mysqli_fetch_assoc($sql)) {
    $bun = explode(",", $row["bundle_list"]);
    foreach ($bun as $b) {
        $arr[$row["id"]][$b] = getProducts("", md5($b));
    }
}
$pro = getProducts("", md5($ids));
$smarty->assign("price", $pro["credit"] - $pro["discount"]);
$smarty->assign("bundle", $arr);
echo processSingleTemplate("cart_bundle");

?>