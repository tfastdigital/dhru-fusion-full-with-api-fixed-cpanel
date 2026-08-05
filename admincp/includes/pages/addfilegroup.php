<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 122;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add Service Group</span>\n    &nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"\" type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"active\" value=\"1\"\n    type=\"checkbox\" class=\"onoff {labelOn: 'active', labelOff: 'inactive'}\"\n    id=\"model1\"  checked=\"checked\"/><label for=\"model1\"></label></td>\n</tr>\n\n\n\n</tbody>\n</table>\n\n</div></div>\n<p align=\"center\" class=\"fixedbtn\">\n<input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\"\n class=\"btn\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','addfilegroup','#frm','#notification','true','#main_loader');\"/> </p>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>