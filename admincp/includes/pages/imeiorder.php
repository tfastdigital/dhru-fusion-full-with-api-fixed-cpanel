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
include "imeiorder.head.php";
$qd = dquery("SHOW COLUMNS FROM `tbl_order_imei` LIKE 'ORDERAPI'");
if (!mysqli_num_rows($qd)) {
    dquery("ALTER TABLE `tbl_order_imei` ADD `ORDERAPI` VARCHAR(100) NOT NULL AFTER `placedfrom`, ADD `ORDERAPI_ID` VARCHAR(255) NOT NULL AFTER `ORDERAPI`; ");
}
echo "<div id=\"tabcontent\">";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "imeiorder.new.php";
}
echo "</div>\n";
$fileverioncheck = "6.1.0";

?>