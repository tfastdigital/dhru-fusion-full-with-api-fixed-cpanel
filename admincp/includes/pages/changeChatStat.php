<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
include_once "includes/fun.inc.php";
if ($position) {
    $attribute = "config";
    global $config;
    $config["livehelp_position"] = $position;
    $serialise = serialize($config);
    dquery("update tbl_settings set value='" . $serialise . "' where attribute='" . $attribute . "'");
} else {
    dquery("update tbl_admin set onlinestatus='" . $_POST["stat"] . "' where id='" . $_SESSION["adminid"] . "'");
}
$fileverioncheck = "6.1.0";

?>