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
include "includes/rss.fun.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$pagetitle = "RSS";
$pageicon = "1";
if ($parentbreadcrumb == NULL) {
    $_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / <a href=\"cms.php?page=" . $urlname . "\">" . $breadcrumb . "</a>";
} else {
    $_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / <a href=\"cms.php?page=" . $parenturlname . "\">" . $parentbreadcrumb . "</a> / <a href=\"cms.php?page=" . $urlname . "\">" . $breadcrumb . "</a>";
}
installclient($pagetitle, $pageicon, $_nav);
$TestFeed = new \FeedWriter(RSS2);
$TestFeed->setTitle($config["config_site_name"]);
$STRING = $_SERVER["PHP_SELF"];
$s = explode("/", $STRING);
foreach ($s as $d) {
}
$att = str_replace($d, "", $STRING);
$http = "http://";
if ($config["config_ssl_allow"]) {
    $http = "https://";
}
$TestFeed->setLink($http . $_SERVER["SERVER_NAME"] . $att . "blogs.php");
$TestFeed->setDescription($config["site_description"]);
$TestFeed->setChannelElement("language", "en-us");
$TestFeed->setChannelElement("pubDate", date(DATE_RSS, time()));
$strSQL = "SELECT * FROM `tbl_blogposts`";
$objRS = dquery($strSQL);
while ($row = mysqli_fetch_assoc($objRS)) {
    $newItem = $TestFeed->createNewItem();
    $newItem->setTitle($row["title"]);
    $newItem->setLink($http . $_SERVER["SERVER_NAME"] . $att . "blog.php?postid=" . $row["id"]);
    $newItem->setDate(time());
    $newItem->setDescription($row["post"]);
    $TestFeed->addItem($newItem);
}
$TestFeed->genarateFeed();
class no
{
}

?>