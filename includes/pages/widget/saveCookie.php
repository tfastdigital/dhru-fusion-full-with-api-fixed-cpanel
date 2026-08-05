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
require_once "./comm.php";
$close = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $close);
$functional = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $functional);
$neccessary = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $neccessary);
$other = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $other);
if ($close) {
    setcookie("euClose", 1, time() + 2592000, "/", "." . $_SERVER["HTTP_HOST"], false, true);
}
if ($functional) {
    setcookie("euFunc", 1, time() + 31104000, "/", "." . $_SERVER["HTTP_HOST"], false, true);
}
if ($neccessary) {
    setcookie("euNec", 1, time() + 31104000, "/", "." . $_SERVER["HTTP_HOST"], false, true);
}
if ($other) {
    setcookie("euOther", 1, time() + 31104000, "/", "." . $_SERVER["HTTP_HOST"], false, true);
}

?>