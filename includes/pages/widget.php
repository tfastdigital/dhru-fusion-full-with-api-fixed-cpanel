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
require_once "comm.php";
require_once "includes/fun.inc.php";
require_once "includes/client.area.inc.php";
$currentpage = "pendingorderimei";
$_nav = "<a href=\"main.php\">" . $lng_languag["dashboard"] . "</a> / ";
$templatefile = "widget";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>