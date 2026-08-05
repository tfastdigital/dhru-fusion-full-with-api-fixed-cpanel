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
include "editsupplier.head.php";
echo "\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "editsupplier.overview.php";
}
echo "  </div>";
$fileverioncheck = "6.1.0";

?>