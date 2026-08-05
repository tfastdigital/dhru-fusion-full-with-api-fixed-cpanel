<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\reqaddon("SMS");
$pageid = 548;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["sms"];
echo " ";
echo $LNG["gateway"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["smsgateway"];
echo " </td>\n    <td class=\"fieldarea\">\n\n<select name='smsgateway'>\n    <option value=\"\">";
echo $LNG["none"];
echo "</option>\n    <option ";
if ($config["smsgateway"] == "clickatell") {
    echo "selected";
}
echo "     value='clickatell'>Clickatell</option>\n    <option ";
if ($config["smsgateway"] == "customgateway") {
    echo "selected";
}
echo "     value='customgateway'>";
echo $LNG["custom"];
echo " ";
echo $LNG["gateway"];
echo "</option>\n</select>\n\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\">\n\n\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','smsgateway.settings','#frm','#notification','true','#main_loader');\"/>\n    </td>\n</tr>\n\n\n</tbody>\n</table>\n\n</form>\n</div></div>\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["sms"];
echo " ";
echo $LNG["testing"];
echo "</span>\n  </h2>\n<div class=\"groupstabescontant\">\n<form id=\"frmd\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mobile"];
echo " </td>\n    <td class=\"fieldarea\">\n        <input type='text' name='mobile' />\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["text"];
echo " </td>\n    <td class=\"fieldarea\">\n        <input type='text' name='text' value='Test SMS' />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td><td  class=\"fieldarea\">\n    <input value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["sms"];
echo "\"\nid=\"btnaddgroups\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroups','smsgateway.test','#frmd','#notification','true','#main_loader');\"/>\n    </td>\n</tr>\n\n</tbody>\n</table>\n\n\n</form>\n</div></div>\n\n</div></div>";
$fileverioncheck = "6.1.0";

?>