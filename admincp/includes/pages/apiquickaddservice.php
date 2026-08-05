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
echo "<div id=\"tabcontent\">\r\n<ul id=\"tabmenu\">\r\n    <li class=\"tabmenu-header\"><span>Submenu</span></li>\r\n    <li><a ";
if ($defaultloadpage != "apisetting.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >APi Cron Setup</a></li>\r\n    <li><a\r\n    onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >Cron Settings</a></li>\r\n    <li><a\r\n     onclick=\"getContect('#tab3','main2.php?page=apiquickaddservice','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["add"];
echo " ";
echo $LNG["services"];
echo "</a></li>\r\n    <div style=\"clear: both;\"></div>\r\n</ul>\r\n\r\n<div id=\"notification\"></div>\r\n<form method=\"post\" id=\"frmnewapi\">\r\n<div  class=\"groupstabes\">\r\n<div class=\"groupstabescontant\">\r\n\r\n</div></div>\r\n</form>\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>