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
echo "<ul id=\"tabmenu\"> \n<li><a  class='tabmenu_active'  onclick=\"getContect('#tab','main2.php?page=manufacturelist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["manufacture"];
echo " ";
echo $LNG["list"];
echo "</a></li> \n<li><a onclick=\"getContect('#tab12','main2.php?page=warehouselist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["warehouse"];
echo " ";
echo $LNG["list"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
include "manufacturelist.php";
echo "  </div>";
$fileverioncheck = "6.1.0";

?>