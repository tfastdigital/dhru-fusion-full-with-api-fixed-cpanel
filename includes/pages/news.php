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
$currentpage = "news";
$pagetitle = $lng_languag["news"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"news.php\">" . $lng_languag["news"] . "</a>";
$templatefile = "client_news";
$item = preg_replace("/[^0-9a-zA-Z]/i", "", $item);
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$sql = dquery("select * from tbl_blogposts where status='published' ORDER BY id DESC");
while ($row = mysqli_fetch_assoc($sql)) {
    $arr[$row["id"]] = $row;
}
$smarty->assign("news", $arr);
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>