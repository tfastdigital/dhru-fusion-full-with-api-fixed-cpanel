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
require_once "../../comm.php";
require_once "../../includes/fun.inc.php";
require_once "../includes/fun.inc.php";
$page = preg_replace("/[^0-9\\-a-zA-Z]\\./i", "", $page);
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "error:<b>Session expired. <br/> </b> Please relogin";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$save_token = sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2");
checkDemoMode();
if ($page) {
    require_once "pages/" . $page . ".php";
}
if ($closedialog) {
    saveSettings("disablestartup", true);
    echo "ok";
}

?>