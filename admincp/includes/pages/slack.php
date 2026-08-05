<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\reqaddon("Messenger Notification");
error_reporting(0);
$pageid = 551;
checkPagePermission($pageid);
if (!isset($_SESSION[adminid])) {
    exit;
}
echo "    <ul id=\"tabmenu\">\r\n    <li><a ";
if ($loaddefault != "slackuser.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=slackadmin','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Admin</a></li>\r\n    <li><a ";
if ($loaddefault == "slackuser.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab2','main2.php?page=slackuser','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >User</a></li>\r\n\r\n    <div style=\"clear: both;\"></div>\r\n    </ul>\r\n    <div id=\"tabcontent\">\r\n";
if ($loaddefault) {
    include $loaddefault;
} else {
    include "slackadmin.php";
}
echo "    </div>";
$fileverioncheck = "6.1.0";

?>