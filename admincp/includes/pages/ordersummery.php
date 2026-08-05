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
include "ordersummery.head.php";
echo "\n";
if (!$OnlyEcommerce) {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "imeiorder.summery.php";
    }
    echo "</div>\n";
} else {
    if ($IsFileOnly) {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "fileorder.summery.php";
        }
        echo "</div>\n";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "productorder.summery.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>