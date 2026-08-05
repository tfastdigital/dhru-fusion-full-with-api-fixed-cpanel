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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$news = preg_replace("/[^0-9]/i", "", $news);
installclient($pagetitle, $pageicon, $breadcrumbnav);
$date = date("Y-m-d");
$sql = dquery("select * from tbl_blogposts where status='published'\nand IF(showblog=0,1=1, IF (showblog=2,'" . $date . "'>=startdate,IF(showblog=3,'" . $date . "'<=enddate,'" . $date . "' between startdate and enddate)))\n ORDER BY id DESC limit " . $news);
while ($row = mysqli_fetch_assoc($sql)) {
    $arr[$row["id"]] = $row;
}
$smarty->assign("news", $arr);
echo processSingleTemplate("client_news");

?>