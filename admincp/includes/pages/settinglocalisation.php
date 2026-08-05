<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 191;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($delete) {
    echo "<ul id=\"tabmenu\">\n    <li><a onclick=\"getContect('#tab','main2.php?page=settinggeneral','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["general"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab2','main2.php?page=settingregistration','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["registration"];
    echo " / " . $LNG["profile"];
    echo "</a></li>\n    <li><a class='tabmenu_active'  onclick=\"getContect('#tab3','main2.php?page=settinglocalisation','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["localisation"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab5','main2.php?page=settinginvoice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
    echo $LNG["tax"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab7','main2.php?page=settingorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >";
    echo $LNG["orders"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab9','main2.php?page=recentmenu','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab9\" >";
    echo $LNG["quick"];
    echo " ";
    echo $LNG["access"];
    echo " ";
    echo $LNG["menu"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab8','main2.php?page=settingappear','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab8\" >";
    echo $LNG["appearance"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab11','main2.php?page=settingother','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["other"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n<div>\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["localisation"];
echo " ";
echo $LNG["settings"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<table class=\"form\"  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["defaultcountry"];
echo " </td>\n    <td class=\"fieldarea\">\n    ";
echo getCountriesDropDown($config["DefaultCountry"], "DefaultCountry");
echo "    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["charset"];
echo " [";
echo $LNG["user"];
echo "]</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"charset\" class=\"txt medium\" value=\"";
echo $config["charset"];
echo "\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["charset"];
echo " [";
echo $LNG["admin"];
echo "]</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"admincharset\" class=\"txt medium\" value=\"";
echo $config["admincharset"];
echo "\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["dateformat"];
echo " </td>\n    <td class=\"fieldarea\">\n        <select name=\"dateformat\">\n        <option value=\"DD/MM/YYYY\" ";
if ($config["dateformat"] == "DD/MM/YYYY") {
    echo "selected";
}
echo "  >DD/MM/YYYY</option>\n        <option value=\"DD.MM.YYYY\" ";
if ($config["dateformat"] == "DD.MM.YYYY") {
    echo "selected";
}
echo "  >DD.MM.YYYY</option>\n        <option value=\"MM/DD/YYYY\" ";
if ($config["dateformat"] == "MM/DD/YYYY") {
    echo "selected";
}
echo "  >MM/DD/YYYY</option>\n        <option value=\"YYYY/MM/DD\" ";
if ($config["dateformat"] == "YYYY/MM/DD") {
    echo "selected";
}
echo "  >YYYY/MM/DD</option>\n        <option value=\"DD-MM-YYYY\" ";
if ($config["dateformat"] == "DD-MM-YYYY") {
    echo "selected";
}
echo "  >DD-MM-YYYY</option>\n        </select>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["userlanguage"];
echo " </td>\n    <td class=\"fieldarea\">\n     ";
echo getLanguageDropdown2($config["language"]);
echo "     </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allowlanguagechange"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Allow', labelOff: 'Not allow'}\" name=\"language_chnage\" value=\"1\" id=\"ena\" ";
if ($config["language_chnage"]) {
    echo "checked";
}
echo " />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["timezone"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"time_zone\" class=\"chosen\">\n";
$sql = dquery("SELECT * FROM `tbl_timezone_1`");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <option value=\"";
    echo $row["Time_zone_id"];
    echo "\" ";
    if ($row["Time_zone_id"] == $config["time_zone"]) {
        echo "selected";
    }
    echo " >";
    echo $row["Name"];
    echo "</option>\n    ";
}
echo "    </select>\n  </td>\n</tr>\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settinglocalisation','#frm','#notification','true','#main_loader');\"/></p>\n</form>\n\n</div></div>\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["auto"];
echo " ";
echo $LNG["detect"];
echo " ";
echo $LNG["language"];
echo " ";
echo $LNG["country"];
echo " Wise</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frmcountrylanguage\" name=\"\" method=\"post\">\n";
if ($delete && isset($id)) {
    dquery("DELETE FROM tbl_country_language WHERE `country_id`='" . $id . "'");
}
echo "\n<table id=\"main_tbl\"><thead><tr><th style=\"width: 320px\">";
echo $LNG["country"];
echo "</th><th >";
echo $LNG["language"];
echo "</th><th align=\"right\" style=\"width: 100px\">";
echo $LNG["action"];
echo "</th></tr></thead>\n\n<tr class=\"adddatarow\"><td><span>";
echo getCountriesDropDown();
echo "</span></td><td><span>";
echo getLanguageDropdown2();
echo "</span> </td><td><span><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"countylanguage\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#countylanguage','countrylanguage','#frmcountrylanguage','#notification','true','#main_loader','main2.php?page=settinglocalisation');\"/></span></td></tr>\n\n";
require ROOTDIR . "/includes/countries.php";
$result = dquery("select * from tbl_country_language");
while ($row = mysqli_fetch_assoc($result)) {
    echo "\t<tr><td>";
    echo $countries[$row["country_id"]];
    echo " <img src=\"../images/flags/";
    echo strtolower($row["country_id"]);
    echo ".png\" style=\"vertical-align: middle;\"/> </td>\n    <td>";
    echo $row["language"];
    echo "</td>\n    <td class=\"action\"><a href=\"javascript:load_subpage('main2.php?page=editcountrylanguage&id=";
    echo $row["country_id"];
    echo "&lid=";
    echo $row["language"];
    echo "','";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["detect"];
    echo " ";
    echo $LNG["language"];
    echo "')\" class=\"editdata\">";
    echo $LNG["edit"];
    echo "</a> <a  href=\"javascript: if(confirm('Are you sure want to remove ?')){  reloadcurrent('settinglocalisation','";
    echo $row["country_id"];
    echo "&delete=true'); }\" class=\"deletedata\">";
    echo $LNG["delete"];
    echo "</a></td></tr>\n";
}
echo "</table>\n\n</form>\n\n</div></div></div>\n ";
if ($delete) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>