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
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
global $lite;
global $WhiteLabel;
global $liteplus;
global $versioncatch;
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $licinfo = "asd";
    if ($debug_output) {
        echo "<textarea cols=100 rows=20>";
        print_r($licinfo);
        echo "</textarea>";
    }
    if ($licinfo["status"] === "Active") {
        if (!in_array($_SERVER["SERVER_NAME"], $licinfo["valid_domains"])) {
            throw new \Exception("This License not authorize for this domain name " . $_SERVER["SERVER_NAME"]);
        }
        $_server_ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
        if (!in_array($_server_ip, $licinfo["valid_ips"])) {
        }
        if ($licinfo["item_id"] === "06d2db89-494c-463b-9e21-289991a74952") {
            $lite = true;
        } else {
            if ($licinfo["item_id"] === "3f81242a-7820-44eb-977d-ec68e8b4742b") {
                $liteplus = true;
            }
        }
        foreach ($licinfo["addons"] as $k => $addondetail) {
            if ($addondetail["name"] == "White Label" && $addondetail["status"] == "Active") {
                $WhiteLabel = true;
            }
        }
        if ($licinfo["addons"]) {
            $addons = $licinfo["addons"];
        }
        if ($devmode) {
            $versioncatch = md5(time());
        } else {
            $versioncatch = $licinfo["version"]["release"];
        }
        if ($config["release_candidate"] == "BETA") {
            $versioncatch = md5(time());
        }
    } else {
         $versioncatch = md5(time());
    }
} catch (\Exception $e) {
   $versioncatch = md5(time());
}
include ROOTDIR . "/includes/mobiledevice.inc.php";
$mobilebrowser = mobile_device_detect();
$laoddefaultpage = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $laoddefaultpage);
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
include "" . $page . ".php";
include_once "templates/" . $_SESSION["admin_template"] . $footer;
class main2
{
}

?>