<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace logout;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include "../comm.php";
include "../includes/fun.inc.php";
include "includes/fun.inc.php";
if ($config["online_status"] == "online" && $_SESSION["adminid"] == "1") {
    saveSettings("online_status", "offline");
}
dquery("UPDATE `tbl_admin` SET `online` = '0' WHERE `id` ='" . $_SESSION["adminid"] . "'");
$_SESSION["adminid"] = NULL;
session_destroy();
unset($_SESSION["adminid"]);
unset($_SESSION["adminname"]);
unset($_SESSION["livechat_username"]);
unset($_SESSION["a_logintime_enc_key"]);
unset($_SESSION["department"]);
unset($_SESSION["ADprotect"]);
header("Location:index.php");
class logout
{
}

?>