<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace main3;

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
    $page = "home";
}
$laoddefaultpage = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $laoddefaultpage);
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\"\tcontent=\"text/html; charset=";
echo $config["admincharset"];
echo "\" />\n<title>Dhru Fusion ";
echo $lite ? "lite" : "";
echo "</title>\n<link rel=\"stylesheet\" href=\"templates/";
echo $admin_template;
echo "/css/style.css\" />\n<script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/iframe.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/main2.fun.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/validation.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/tablefilter.js\" type=\"text/javascript\"></script>\n</head>\n\n<body class=\"mbBody\">\n  <div id=\"mainContent\">\n\n<div id=\"main_loader\" style=\"display: none;\">\n<div class=\"aProgress\"><div class=\"aBar slow\"></div><div class=\"aSpinner\"><div class=\"spinner-icon\"></div></div></div>\n</div>\n\n\n";
include "includes/pages/m." . $page . ".php";
echo "</div>\n\n</body>\n</html>\n";
class main3
{
}

?>