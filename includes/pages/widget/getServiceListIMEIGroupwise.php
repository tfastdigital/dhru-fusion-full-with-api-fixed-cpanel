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
require_once ROOTDIR . "/includes/imeiservices.fun.php";
$templatefile = "client_getservice_groupwise";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$groupid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $groupid);
$servicelist = getIMEIServices($groupid, "", $_ClientsDetails["id"], true, "", "", "", "", "", "", "", "", 9999999);
$tempalte_ver["servicelistarray"] = $servicelist;
echo processSingleTemplate($templatefile);

?>