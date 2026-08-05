<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n\n\n";
if (!isset($_SESSION[adminid])) {
    exit;
}
include "edituser.head.php";
echo "<div id=\"tabcontent\">  ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "edituser.overview.php";
}
echo " </div>  ";
$fileverioncheck = "6.1.0";
echo "\n\n";

?>