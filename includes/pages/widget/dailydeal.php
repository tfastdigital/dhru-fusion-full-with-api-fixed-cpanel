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
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/products.fun.php";
if ($config["shoppingcart"]) {
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $dailydeals = getProducts("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true, "RI");
    $tempalte_ver["dailydeals"] = $dailydeals;
    echo processSingleTemplate("cart_dailydeal");
}

?>