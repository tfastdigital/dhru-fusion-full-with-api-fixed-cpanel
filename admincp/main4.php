<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace main4;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
require "../includes/fun.inc.php";
require "includes/fun.inc.php";
require "includes/comm.inc.php";
global $lite;
global $WhiteLabel;
global $liteplus;
global $versioncatch;
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $licinfo ="asd";
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
unset($_SESSION["admin_afterlogin_re"]);
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
include ROOTDIR . "/includes/mobiledevice.inc.php";
$mobilebrowser = mobile_device_detect();
$time = time();
if (!isset($page)) {
    $page = "home2";
}
$laoddefaultpage = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $laoddefaultpage);
echo "<!doctype html>\n<html lang=en>\n<head>\n    <title>Dhru Fusion ";
echo $lite ? "lite" : "";
echo "</title>\n    <meta http-equiv=\"content-type\"\tcontent=\"text/html; charset=";
echo $config["admincharset"];
echo "\" />\n    <meta name=\"viewport\" content=\"width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1\">\n    <link rel=\"stylesheet\" href=\"templates/mobile2/css/style.css\" />\n    <script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/main2.fun.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/validation.js\" type=\"text/javascript\"></script>\n    <script src=\"includes/js/tablefilter.js\" type=\"text/javascript\"></script>\n    <script src=\"templates/mobile2/js/custom.js\" type=\"text/javascript\"></script>\n</head>\n\n<body >\n          <h1><a href=\"main.php\" style=\"text-decoration: none;color:#888\"><img src=\"templates/mobile2/images2/home_w.png\" style=\"vertical-align: middle;margin-top:-10px\"/>  Dhru Fusion </a> </h1>\n\n";
include "includes/pages/m." . $page . ".php";
echo "\n\n        <ul class=\"footermenu\">\n<li><a href=\"main4.php?page=myaccount\" >My Account</a></li>\n<li><a href=\"main4.php?page=note\" >Note</a></li>\n<li><a href=\"logout.php\">Logout</a></li>\n<li><a href=\"main.php?switch=true\">Full View</a></li>\n<div style=\"clear:both\"></div>\n        </ul>\n\n</body>\n</html>\n";
class main4
{
}

?>