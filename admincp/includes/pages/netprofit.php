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
include "profit.head.php";
if (!$OnlyEcommerce && !$IsFileOnly) {
    echo "<div id=\"tabcontent\"> ";
    if ($laoddefaultpage) {
        include $laoddefaultpage;
    } else {
        include "imeiprofit.php";
    }
    echo "</div>\n";
} else {
    if ($IsFileOnly) {
        echo "<div id=\"tabcontent\"> ";
        if ($laoddefaultpage) {
            include $laoddefaultpage;
        } else {
            include "fileprofit.php";
        }
        echo "</div> \n ";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($laoddefaultpage) {
            include $laoddefaultpage;
        } else {
            include "productprofit.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>