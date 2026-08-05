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
require "../comm.php";
if (!isset($_SESSION["adminid"])) {
    exit;
}
$pid = preg_replace("/[^0-9]/i", "", $pid);
if ($type == "imei" || $type == "server" || $type == "remote") {
    dquery("UPDATE tbl_services_imei set show_onhome='0' where id='" . $pid . "'");
} else {
    if ($type == "product") {
        dquery("UPDATE tbl_products set show_onhome='0' where id='" . $pid . "'");
    }
}
echo "OK";

?>