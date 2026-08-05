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
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='maintanance'"));
$config["maintanance_message"] = $sql["value"];
echo "<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Maintenance</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">System In </td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Live Mode',labelOff: 'Maintenance Mode'}\" name=\"config_is_under_maintanance\" id=\"em\" value=\"1\" ";
if (!$config["config_is_under_maintanance"]) {
    echo "checked";
}
echo " /><label for=\"em\" ></label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["maintenancebacktime"];
echo "  </td>\n    <td class=\"fieldarea\">\n<input type=\"text\"  class=\"txt small\" name=\"maintenancebacktime\" value=\"";
echo $config["maintenancetime"];
echo "\" /> ";
echo $LNG["hrs"];
echo "   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["maintanance_message"];
echo "  </td>\n    <td class=\"fieldarea\">\n        <textarea name=\"maintanance_message\" id=\"message\">";
echo $config["maintanance_message"];
echo "</textarea>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">Contact Us</td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"maintanacecontact\" value=\"1\" id=\"fbme\" ";
if ($config["maintanacecontact"]) {
    echo "checked";
}
echo " /><label for=\"fbme\"></label>            </td>\n</tr>\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnaddgroup\" class=\"btn\" type=\"button\" name=\"save\"\nonclick=\"SubmitForm ('#btnaddgroup','maintenance','#frm','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>