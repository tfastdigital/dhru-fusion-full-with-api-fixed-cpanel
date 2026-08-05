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
echo "<ul id=\"tabmenu\"> \n    <li><a class='tabmenu_active'  onclick=\"getContect('#tab','main2.php?page=indexbanner','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["indexbanner"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab12','main2.php?page=indexcontent','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["indexcontent"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "indexbanner.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>