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
require "fun.inc.php";
require "client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if ($debug) {
    echo "debug:";
}
require "imeiservices.fun.php";
$tempalte_ver["imeiservicelist"] = getIMEIServices("", "c81e728d9d4c2f636f067f89cc14862c");
$tempalte_ver["imeiservicegroup"] = getIMEIServiceGroup();

?>