<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n";
$pageid = 56;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add Testimonial</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"newpost\" method=\"post\">\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"addtestimonial.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["author"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n  <input type=\"text\"  class=\"txt medium\" name=\"author\" value=\"\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"email\" value=\"\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["comments"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <textarea name=\"comment\" id=\"message\" class=\"textarea large\"></textarea>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium datepicker\"  autocomplete=\"off\" name=\"date\" id=\"to\" value=\"\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"published\" checked=\"checked\" name=\"status\"  id=\"publi\" /> <label for=\"publi\">";
echo $LNG["approved"];
echo "</label>\n    <input type=\"radio\" value=\"pending\" name=\"status\" id=\"unpubli\" /> <label for=\"unpubli\">";
echo $LNG["pending"];
echo "</label>\n    </span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n<p align=\"center\" class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"tinyMCE.triggerSave(); SubmitForm ('#btnaddgroup','addtestimonial','#frm','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div></div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>