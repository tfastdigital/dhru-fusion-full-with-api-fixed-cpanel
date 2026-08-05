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
echo "<div id=\"tabcontent\">\r\n    ";
if ($defaultloadpage != "cronsetting.php") {
    echo "        <ul id=\"tabmenu\">\r\n            <li class=\"tabmenu-header\"><span>Submenu</span></li>\r\n            <li><a  onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\"\r\n                     id=\"tab\"> APi</a></li>\r\n            <li><a onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\"\r\n                   id=\"tab22\">+Add APi</a></li>\r\n            <li><a\r\n                    onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\"\r\n                    id=\"tab2\">Cron Settings</a></li>\r\n\r\n <li><a class='tabmenu_active'\r\n onclick=\"getContect('#tab4','main2.php?page=croninstall','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Cron Auto Install</a></li>\r\n\r\n            <li><a onclick=\"getContect('#tab3','main2.php?page=apisynchistory','','','#tabcontent',true,'#main_loader');\"\r\n                   id=\"tab3\">APi Sync ";
    echo $LNG["history"];
    echo "</a></li>\r\n\r\n            <div style=\"clear: both;\"></div>\r\n        </ul>\r\n        ";
}
echo "\r\n    <div class=\"mt-2\">\r\n\r\n<div class=\"info\" id=\"notification1\">\r\nAuto Install Cron commands for cPanel hosting server. <br />\r\n    All existing cron will be removed and installed again.\r\n\r\n</div>\r\n<div id=\"notification\"></div>\r\n<form method=\"post\" id=\"frmautoinstall\">\r\n    <table id=\"main_tbl\">\r\n    <tr>\r\n        <td class=\"fieldlabel\">\r\n          cPanel  Hosting Username\r\n        </td>\r\n        <td class=\"fieldarea\">\r\n            <input type=\"text\" name=\"hostingunm\" autocomplete=\"off\" value=\"";
echo basename(dirname($_SERVER["DOCUMENT_ROOT"]));
echo "\" />\r\n        </td>\r\n    </tr>\r\n        <tr>\r\n            <td class=\"fieldlabel\">\r\n                cPanel   Hosting Password\r\n            </td>\r\n            <td class=\"fieldarea\">\r\n                <input type=\"text\" name=\"hostingpass\" autocomplete=\"off\" value=\"\" />\r\n<br />\r\n                <div style=\"clear: both\"><br/></div>\r\n                <span> <i>System will not store password for security reason</i></span>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class=\"fieldlabel\">\r\n\r\n            </td>\r\n            <td class=\"\" style=\"text-align: left !important;\" >\r\n\r\n               <label style=\"clear: both;\"><input type=\"checkbox\" name=\"cronsetupimei\" checked value=\"1\" />Cron for IMEI and Server services</label><br />\r\n               <label style=\"clear: both;\"><input type=\"checkbox\" name=\"cronsetupfile\" value=\"1\" />Cron for File services </label><br />\r\n               <label style=\"clear: both;\"><input type=\"checkbox\" name=\"cronsetupauto\" value=\"1\" />Cron for Auto Price Update </label>\r\n\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n           <td>\r\n\r\n           </td>\r\n            <td class=\"fieldarea\">\r\n                <input value=\"";
echo $LNG["save"];
echo "\"\r\n                       id=\"btnaddgroup\" class=\"btn\" type=\"button\" class=\"btn btn-success\"\r\n                       onclick=\"SubmitForm('#btnaddgroup','croninstall','#frmautoinstall','#notification','true','#main_loader');\"/>\r\n\r\n            </td>\r\n        </tr>\r\n    </table>\r\n</form>\r\n\r\n    </div>\r\n    ";
$fileverioncheck = "6.1.0";

?>