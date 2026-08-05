<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../comm.php";
require "../../includes/fun.inc.php";
require "fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"../index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
checkDemoMode();
$allwarr = ["configtest", "admintheme_bg", "admintheme_color", "admintheme_opacity", "admintheme_menu", "keyboard_shortcuts"];

    if (1==1) {
        saveSettings($key, $v);
    }

echo "success:" . $LNG["datasavesuccessfully"];

?>