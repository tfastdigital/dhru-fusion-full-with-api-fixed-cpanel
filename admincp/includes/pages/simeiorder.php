<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
licince\chklite("IMEI");
include "imeiorder.head.php";
echo " \r\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "imeiorder.new.php";
}
echo "  </div>\r\n\r\n";
$fileverioncheck = "6.1.0";

?>