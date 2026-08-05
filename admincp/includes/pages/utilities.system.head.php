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
$pyear = date("Y") - 1;
echo "<ul id=\"tabmenu\">     \n    <li><a id=\"tab\" ";
if (!$loaddefaultpage) {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab','main2.php?page=utilities.systemsummary&year=";
echo date("Y");
echo "','','','#tabcontent',true,'#main_loader');\">System Summary - ";
echo date("Y");
echo "</a></li> \n    <li><a id=\"tab22\" ";
if ($loaddefaultpage) {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab22','main2.php?page=utilities.systemsummary2&year=";
echo $pyear;
echo "&loaddefaultpage=utilities.systemsummary2.php','','','#tabcontent',true,'#main_loader');\" >System Summary - ";
echo $pyear;
echo "</a></li>    \n    <div style=\"clear: both;\"></div>\n<div class=\"clear\"></div></ul>";
$fileverioncheck = "6.1.0";

?>