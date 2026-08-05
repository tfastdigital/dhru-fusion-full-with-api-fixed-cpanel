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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "export";
$pagetitle = $lng_languag["export"];
$_nav = "<a href='" . _url("index") . "'>" . $lng_languag["home"] . " </a> / ";
$_nav .= "<a href='" . _url("cart") . "' >" . $lng_languag["export"] . "</a> / ";
$templatefile = "client_export";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$tempalte_ver["serverservice"] = $serverservice;
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
$tempalte_ver["advanceexportlink"] = _url("downloadfiles/action/exports/id/1");
if ($standalone) {
    $tempalte_ver["standalone"] = true;
    echo processSingleTemplate($templatefile);
    exit;
}
DisplayOutput($templatefile);
class no
{
}

?>