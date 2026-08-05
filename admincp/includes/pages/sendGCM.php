<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 500;
checkPagePermission($pageid);
include_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$cnt = mysqli_num_rows(dquery("select * from tblUsers\r\nwhere gcmid!=''"));
echo "<ul id=\"tabmenu\">\r\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Mass Notification</a></li>\r\n</ul>\r\n<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n<div id=\"content_padded\">\r\n\r\n\r\n<div  class=\"groupstabes\" >\r\n  <h2>\r\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\r\n    <span class=\"groupstabesheadertext\">GCM Receipiant [<strong>";
echo $cnt;
echo "</strong>]</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n  </h2>\r\n  <div class=\"groupstabescontant\">\r\n\r\n<form id=\"mails\" name=\"mails\" method=\"post\" >\r\n\r\n\r\n<table class=\"form\"  cellpadding=\"5\">\r\n\r\n\r\n<tr>\r\n    <td class=\"fieldlabel\" >\r\n    \t";
echo $LNG["userstatus"];
echo "    </td>\r\n    <td class=\"fieldarea\">\r\n       <input type=\"radio\" name=\"type\" id=\"uu\" value=\"3\" checked />\r\n        <label for=\"uu\">";
echo $LNG["all"];
echo " ";
echo $LNG["user"];
echo "</label>\r\n    \t<input type=\"radio\" id=\"ee\" name=\"type\" value=\"1\"  />\r\n        <label for=\"ee\">";
echo $LNG["active"];
echo " ";
echo $LNG["user"];
echo "</label>\r\n        <input type=\"radio\" id=\"dd\" name=\"type\" value=\"2\"  />\r\n        <label for=\"dd\">";
echo $LNG["inactive"];
echo " ";
echo $LNG["user"];
echo "</label>\r\n     </td>\r\n    </tr>\r\n\r\n</table>\r\n<br/>\r\n\r\n";
echo generate_token("form");
echo "<table class=\"form\" cellpadding=\"5\">\r\n<tbody>\r\n\r\n\r\n\r\n<tr>\r\n    <td class=\"fieldlabel\">";
echo $LNG["notification"];
echo " ";
echo $LNG["title"];
echo "</td>\r\n    <td class=\"fieldarea\"><input size=\"50\" type=\"text\" name=\"title\" /></td>\r\n</tr>\r\n\r\n<tr>\r\n    <td class=\"fieldlabel\">";
echo $LNG["notification"];
echo " ";
echo $LNG["body"];
echo "</td>\r\n    <td class=\"fieldarea\"><textarea rows=\"7\" cols=\"40\" name='body' id=\"body\"></textarea></td>\r\n</tr>\r\n\r\n\r\n\r\n</tbody></table>\r\n<p align=\"center\" class=\"fixedbtn\"><input type=\"button\" name=\"send\"\r\nonclick=\"SubmitForm ('#sendmai','sendgcm','#mails','#notification','true','#main_loader');\"\r\nid=\"sendmai\" class=\"btn\"  value=\"";
echo $LNG["send"];
echo "\"  /></p>\r\n</form></div></div></div></div>\r\n";
$fileverioncheck = "6.1.0";

?>