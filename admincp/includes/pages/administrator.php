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
include "admin.head.php";
echo " <div id=\"tabcontent\"> ";
if ($page == "adminroles") {
    include "adminroles.php";
} else {
    if ($loaddefault) {
        include $loaddefault;
    } else {
        include "adminlist.php";
    }
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>