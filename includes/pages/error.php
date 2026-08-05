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
require "../../comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "error";
$_nav = "<a href=\"main.php\">" . $lng_languag["home"] . "</a> / " . "<a href=\"#\">" . $lng_languag["error"] . "-" . $error . "</a>";
$error = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $error);
$pagetitle = $lng_languag["error"] . " - " . $error;
$templatefile = "error";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$tempalte_ver["errorno"] = $error;
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>