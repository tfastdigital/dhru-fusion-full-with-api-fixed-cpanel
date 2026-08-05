<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace main2;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
$wikilink = "http://wiki.dhru.com/";
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
require "../includes/fun.inc.php";
require "includes/fun.inc.php";
define("DATAGRID_DIR", "includes/3rdparty/datagrid/");
define("PEAR_DIR", "includes/3rdparty/datagrid/pear/");
require "includes/comm.inc.php";
unset($_SESSION["admin_afterlogin_re"]);
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<a   href=\"index.php\" style=\"text-decoration:none;position: absolute;top:20%;left:50%;margin-left: -75px;text-align: center;font-family: arial;font-size:20px\" class=\"session-expired\"><span style=\"color:red\">Session expired <br/> <span style=\"color:#939393;font-size:16px\">Click here to login</span></span></a>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
include ROOTDIR . "/includes/mobiledevice.inc.php";
$mobilebrowser = mobile_device_detect();
global $lite;
$licinfo = "zxx";
if ($devmode) {
    $versioncatch = time();
} else {
    $versioncatch = $licinfo["releasecandidate"];
}
$laoddefaultpage = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $laoddefaultpage);
unset($data);
$_SESSION["fromail"] = false;
$time = time();
if ($config["online_status"] != "offline" && $config["live_chat_online_username"] == $_SESSION["adminname"]) {
    saveSettings("online_status", "online");
    saveSettings("live_chat_online_time", $time);
}
dquery("UPDATE `tbl_admin` SET `online` = '1',`online_time`='" . $time . "' WHERE `id` ='" . $_SESSION["adminid"] . "'");
$lite = $liteplus = false;
if ($licinfo["productid"] == "42") {
    $fusionlite = $lite = true;
} else {
    $fusionlite = $lite = false;
}
if ($licinfo["productid"] == "43") {
    $liteplus = true;
} else {
    $liteplus = false;
}
if ($results["addons"]) {
    $addons = $licinfo["addons"];
}
if ($mobilebrowser) {
    $header = "/header.main2.mobile.php";
    $footer = "/footer.main2.mobile.php";
    $dashboard = "/dashboard.mobile";
} else {
    $header = "/header.main2.php";
    $footer = "/footer.main2.php";
    $dashboard = "/dashboard";
}
if (!isset($page) || $page == "home") {
    $page = "../../templates/" . $_SESSION["admin_template"] . $dashboard;
}
include_once "templates/" . $_SESSION["admin_template"] . $header;
unset($fileverioncheck);
include "includes/pages/" . $page . ".php";
include_once "templates/" . $_SESSION["admin_template"] . $footer;
if ($fileverioncheck != "6.1.0") {
    if ($devmode) {
        echo "file version mismatch detected between <br /> " . $page;
    }
    exit;
}
class main2
{
}

?>