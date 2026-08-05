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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
global $config;
$code = rand(100000, 999999);
include ROOTDIR . "/includes/mail.fun.php";
$error = sendSMS($_ClientsDetails["phonenumber"], 3, "", ["CODE" => $code]);
dquery("UPDATE tblUsers SET mobverify='" . $code . "',verified='0' WHERE id='" . $_ClientsDetails["id"] . "'");
$error = explode(":", $error);
if (trim($error[0]) == "success") {
    echo "success: " . $lng_languag["condsentonmob"];
} else {
    echo "error: " . $lng_languag["msgsendingfail"];
}

?>