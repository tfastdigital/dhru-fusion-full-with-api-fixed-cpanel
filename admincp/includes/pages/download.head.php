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
if (!$loaddefaultpage) {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab','main2.php?page=downloadmain','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["download"];
echo " ";
echo $LNG["categories"];
echo "</a></li> \n    <li><a ";
if ($loaddefaultpage == "downloadfiles.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab12','main2.php?page=downloadfiles','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["download"];
echo "s</a></li>\n    <li><a ";
if ($loaddefaultpage == "addfile.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab13','main2.php?page=addfile','','','#tabcontent',true,'#main_loader');\" id=\"tab13\" > ";
echo $LNG["add"];
echo " ";
echo $LNG["files"];
echo "</a></li>\n  <div style=\"clear: both;\"></div>\n</ul> ";
$fileverioncheck = "6.1.0";

?>