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
echo "<br />\n<div id=\"notification2\" class=\"alert\"> \n\n&nbsp;&nbsp; license update required<br />\n&nbsp;&nbsp; Go \"Help >> License information\" and Forcefull update license information\n</div>";
$fileverioncheck = "6.1.0";

?>