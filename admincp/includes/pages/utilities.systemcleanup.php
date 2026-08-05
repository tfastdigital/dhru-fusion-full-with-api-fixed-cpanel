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
echo "<ul id=\"tabmenu\"> \n    <li><a ";
if ($page == "systemcleanup") {
    echo "class='tabmenu_active'";
}
echo "     onclick=\"getContect('#tab','main2.php?page=systemcleanup','','','#tabcontent',true,'#main_loader');\" \n     id=\"tab\" >";
echo $LNG["systemcleanup"];
echo "</a></li> \n    <li><a ";
if ($page == "cleardata" || $loaddefaultpage == "cleardata.php") {
    echo "class='tabmenu_active'";
}
echo " \n    onclick=\"getContect('#tab12','main2.php?page=cleardata','','','#tabcontent',true,'#main_loader');\" \n    id=\"tab12\" >";
echo $LNG["clear"];
echo " ";
echo $LNG["data"];
echo "</a></li>\n <div style=\"clear: both;\"></div>\n</ul> \n<div id=\"tabcontent\"> ";
if ($loaddefaultpage) {
    include $loaddefaultpage;
} else {
    include "systemcleanup.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>