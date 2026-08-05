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
echo "<ul id=\"tabmenu\"> \n<li class=\"tabmenu-header\"><span>Submenu</span></li>\n<span class=\"toggle-tabmenu\"><span>::</span><span style=\"margin-top:-5px;\">::</span></span>\n<li><a ";
if (!$pages && !$delete) {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab','main2.php?page=viewblog&p2=true','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["view"];
echo " ";
echo $LNG["post"];
echo "</a></li> \n<li><a ";
if ($pages == "newblog.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  href=\"main2.php?page=viewblog&pages=newblog.php\" id=\"tab12\" >";
echo $LNG["new"];
echo " ";
echo $LNG["post"];
echo "</a></li>\n<li><a ";
if ($pages == "blogcategorylist.php" || $delete) {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab3','main2.php?page=blogcategorylist','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["blog"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n";
$fileverioncheck = "6.1.0";

?>