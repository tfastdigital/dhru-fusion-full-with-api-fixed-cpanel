<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "client.head.php";
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n<script>\n\$( document ).ready(function() {\n    \$(\".email\").focus();\n});\nfunction setParent()\n{\n    if(\$(\"#fastclient\").val()==\"\"){\n\n\n    \$.post(\"includes/pages/pos.sales.product.php?getlast=true\",function(data) {\n      parent.setVLL1(data);\n      closePopup();\n    });\n\n    }\n}\n</script>\n";
$pageid = 61;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
$custom = getCustomFields("regis", $id, "");
echo "\n<div title=\"addnewclient\" id=\"tutid\"></div>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"\">\n<form id=\"frmaddclient\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" id=\"fastclient\" name=\"fastclient\" value=\"1\" />\n";
echo generate_token("form");
echo "\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Client Information </span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["registeredemail"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"\" type=\"text\"\n    class=\"txt medium email\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"password\"  value=\"\" type=\"password\"/><small>";
echo $LNG["blanktoauto"];
echo "</small> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["company"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"company\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "</td>\n    <td class=\"fieldarea\"><textarea name=\"address\"></textarea></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "2</td>\n    <td class=\"fieldarea\"><textarea name=\"address2\"></textarea></td>\n</tr>\n<tr>\n\t\t<td class=\"fieldlabel\">";
echo $LNG["state"];
echo "</td>\n\t\t<td class=\"fieldarea\"><input name=\"state\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["city"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"city\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["zip"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"zip\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown();
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phonenumber"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"phonenumber\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n    <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddclient\" class=\"btn\"\n    type=\"button\"\n    onclick=\"SubmitForm ('#btnaddclient','addnewclient','#frmaddclient','#notification','true','#main_loader','','','false');\n    setTimeout(function(){setParent();},400);\"/>\n    </td>\n</tr>\n</tbody>\n</table></div></div>\n\n</form>\n</div>\n</div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>