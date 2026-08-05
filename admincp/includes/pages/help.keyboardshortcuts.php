<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " ";
licince\chklite();
echo "<script>\n\n    function saveConfig(){\n        alert('dr');\n        var status='0';\n        if(\$('#em').is(\":checked\")){\n            status='1';\n        }\n\n        \$.post('includes/config.save.php?keyboard_shortcuts='+status, function (data, textStatus) {});\n    }\n</script>\n<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Shortcuts</a></li>\n</ul>\n<div id=\"notification\"></div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Keyboard Shortcuts</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n    <div id=\"content\">\n    <div id=\"content_padded\">\n\n  <form id=\"frm\" name=\"\" method=\"post\">\n  <input type=\"hidden\" name=\"keyboard\" value=\"1\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["keyboardshortcuts"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable',labelOff: 'Disable'}\"\n   name=\"keyboard_shortcuts\"\n    id=\"em\" value=\"1\" ";
if ($config["keyboard_shortcuts"]) {
    echo "checked";
}
echo " /><label for=\"em\" ></label>\n    <small>";
echo $LNG["shortcutinfo"];
echo "</small>\n    </td>\n</tr>\n\n</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnaddgroup\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','settingauto','#frm','#notification','true','#main_loader');\"/></p>\n</form>\n\n\n\n\n        <table id=\"main_tbl\">\n            <tr><th align=\"left\" width=\"200px\">Page Name</th><th align=\"left\">Shortcuts</th></tr>\n            <tr><td>ADD NEW USER</td><td>CTRL + ALT + U</td></tr>\n            <tr><td>CLIENT LIST</td><td>CTRL + L</td></tr>\n            <tr><td>GENERAL SETTING </td><td>CTRL + Q</td></tr>\n            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n            ";
if (!$OnlyEcommerce) {
    echo "            <tr><td>NEW IMEI ORDERS</td><td>CTRL + ALT + I</td></tr>\n            <tr><td>NEW FILE ORDERS</td><td>CTRL + ALT + F</td></tr>\n            <tr><td>NEW SERVER ORDERS</td><td>CTRL + ALT + S</td></tr>\n            ";
}
echo "            <tr><td>NEW PRODUCT ORDER</td><td>CTRL + ALT +  P</td></tr>\n\n            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n            <tr><td>POS</td><td>F2</td></tr>\n        </table>\n\n    </div></div>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>