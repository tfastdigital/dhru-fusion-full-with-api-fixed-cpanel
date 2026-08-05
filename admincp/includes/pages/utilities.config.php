<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 501;
checkPagePermission($pageid);
error_reporting(0);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Backup Options</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["users"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"backup_users\" value=\"1\" id=\"me\" ";
if ($config["backup_users"]) {
    echo "checked";
}
echo " /><label for=\"me\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"backup_users\" value=\"0\" id=\"md\" ";
if (!$config["backup_users"]) {
    echo "checked";
}
echo " /><label for=\"md\">";
echo $LNG["no"];
echo "</label>\n   </td>\n</tr>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["list"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"backup_service\" value=\"1\" id=\"ute\" ";
if ($config["backup_service"]) {
    echo "checked";
}
echo " /><label for=\"ute\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"backup_service\" value=\"0\" id=\"utd\" ";
if (!$config["backup_service"]) {
    echo "checked";
}
echo " /><label for=\"utd\">";
echo $LNG["no"];
echo "</label>\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["system"];
echo " ";
echo $LNG["config"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"backup_config\" value=\"1\" id=\"bte\" ";
if ($config["backup_config"]) {
    echo "checked";
}
echo " /><label for=\"bte\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"backup_config\" value=\"0\" id=\"btd\" ";
if (!$config["backup_config"]) {
    echo "checked";
}
echo " /><label for=\"btd\">";
echo $LNG["no"];
echo "</label>\n   </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["orders"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"backup_order\" value=\"1\" id=\"ote\" ";
if ($config["backup_order"]) {
    echo "checked";
}
echo " /><label for=\"ote\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"backup_order\" value=\"0\" id=\"otd\" ";
if (!$config["backup_order"]) {
    echo "checked";
}
echo " /><label for=\"otd\">";
echo $LNG["no"];
echo "</label>\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo " ";
echo $LNG["template"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"backup_email\" value=\"1\" id=\"ete\" ";
if ($config["backup_email"]) {
    echo "checked";
}
echo " /><label for=\"ete\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"backup_email\" value=\"0\" id=\"etd\" ";
if (!$config["backup_email"]) {
    echo "checked";
}
echo " /><label for=\"etd\">";
echo $LNG["no"];
echo "</label>\n   </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["dailymailbackup"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"checkbox\" name=\"dailyemailbackup\" id=\"dailyemailbackup\" value=\"1\" ";
if ($config["dailyemailbackup"] == 1) {
    echo "checked";
}
echo " /><label for=\"dailyemailbackup\"></label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["backup"];
echo " ";
echo $LNG["email"];
echo " ";
echo $LNG["to"];
echo "</td>\n    <td class=\"fieldarea\">\n <input type=\"text\" name=\"backupmailto\" class=\"txt large\" value=\"";
echo $config["backupmailto"];
echo "\" />\n    </td>\n</tr>\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n      onclick=\"SubmitForm ('#btnaddgroup','settinglocalisation','#frm','#notification','true','#main_loader');\"/>   </p>\n</form>\n<br />\n<div id=\"notification1\" class=\"info\">Database base backup no longer supports, due to security reasons.\n    Please use hosting provider backup options.</div>\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>