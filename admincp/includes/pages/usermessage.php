<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 294;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">User Message</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\">\n\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">Status </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable',labelOff: 'Disable'}\"\nname=\"user_msg\" id=\"em\" value=\"1\"\n";
if ($config["user_msg"]) {
    echo "checked";
}
echo " /><label for=\"em\" ></label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["show"];
echo " ";
echo $LNG["on"];
echo "</td>\n    <td class=\"fieldarea\">\n<input type=\"radio\" name=\"msgshowon\" ";
if (!$config["msgshowon"] || $config["msgshowon"] == 1) {
    echo "checked";
}
echo " value=\"1\"\n id=\"sb\" /><label for=\"sb\">";
echo $LNG["invoicesbefore"];
echo " ";
echo $LNG["login"];
echo "</label>\n<input type=\"radio\" name=\"msgshowon\" ";
if ($config["msgshowon"] == 2) {
    echo "checked";
}
echo " value=\"2\" id=\"sa\" />\n<label for=\"sa\">";
echo $LNG["after"];
echo " ";
echo $LNG["login"];
echo "</label>\n<input type=\"radio\" name=\"msgshowon\" ";
if ($config["msgshowon"] == 3) {
    echo "checked";
}
echo " value=\"3\" id=\"sl\" />\n<label for=\"sl\">";
echo $LNG["all"];
echo " ";
echo $LNG["time"];
echo "</label>\n    </td>\n</tr>\n<input type=\"hidden\" id=\"usermessage\" name=\"usermessage\"\nvalue='";
echo html_entity_decode($config["usermessage"]);
echo "' />\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["message"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea cols=\"80\" rows=\"5\" id=\"tinymc\"\n    name=\"tinymc\">";
echo $config["usermessage"];
echo "</textarea>\n   </td>\n</tr>\n\n\n</tbody>\n</table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\" name=\"save\"\nonclick=\"\nSubmitForm('#btnaddgroup','usermessage','#frm','#notification','true','#main_loader');\"/></p>\n\n</form>\n</div></div></div></div>\n";
$fileverioncheck = "6.1.0";

?>