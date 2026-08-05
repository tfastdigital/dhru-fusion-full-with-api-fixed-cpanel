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
$templatefile = "cart_more";
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $next;
if ($_SESSION["lastpid"] == 0) {
    $_SESSION["sessn"] = $config["cart_page_limit"];
} else {
    $_SESSION["sessn"] += $config["cart_page_limit"];
}
$next = $_SESSION["sessn"];
$_SESSION["lastpid"] = $config["cart_page_limit"];
if ($_SESSION["smtype"] == "imei") {
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    $tempalte_ver["type"] = "imei";
    $tempalte_ver["items"] = getIMEIServices($_SESSION["grp"], "", "", "", "", "", true, "", "", "", "", "", $_SESSION["lastpid"], $_SESSION["sortby"]);
} else {
    if ($_SESSION["smtype"] == "server") {
        require_once ROOTDIR . "/includes/imeiservices.fun.php";
        $tempalte_ver["type"] = "server";
        $tempalte_ver["items"] = getIMEIServices($_SESSION["grp"], "", "", "", "", "", true, "", "", "", "", "", $_SESSION["lastpid"], $_SESSION["sortby"], "", "", "", "", "", "", 2);
    } else {
        if ($_SESSION["smtype"] == "product") {
            require_once ROOTDIR . "/includes/products.fun.php";
            $tempalte_ver["items"] = getProducts($_SESSION["grp"], "", "", true, "", "", true, "", "", $searchkey, "", $_SESSION["lastpid"], "", "", true, "", $_SESSION["sortby"], true, "", "", "RI");
            $tempalte_ver["type"] = "product";
        }
    }
}
echo processSingleTemplate($templatefile);

?>