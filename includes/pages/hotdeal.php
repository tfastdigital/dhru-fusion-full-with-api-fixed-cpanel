<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$pagetitle = $lng_languag["hotdeals"];
$currentpage = "hotdeal";
$templatefile = "hotdeal";
$_nav = "<a href='index.php'>" . $lng_languag["home"] . " </a> / ";
$_nav .= "<a href='cart.php' >" . $lng_languag["hotdeals"] . "</a> / ";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$tempalte_ver["items"] = NULL;
require_once "includes/products.fun.php";
$tempalte_ver["items"] = getProducts($group, "", "", "", "", "", "", "", true, "", "", 99999, "", "", "", "", "", "", "", "", "RI");
if (!$OnlyEcommerce) {
    require_once "includes/imeiservices.fun.php";
    $tempalte_ver["imeiitems"] = getIMEIServices($group, "", "", "", "", "", "", "", true, "", "", "", 99999);
}
if (!$OnlyEcommerce) {
    require_once "includes/serverservices.fun.php";
    $tempalte_ver["serveritems"] = getServerServices($group, "", "", "", "", "", "", "", "", "", true, "", 99999);
}
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
chkMd5sumsubpage();
class no
{
}

?>