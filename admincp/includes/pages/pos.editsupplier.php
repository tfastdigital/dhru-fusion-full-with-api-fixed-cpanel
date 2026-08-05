<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 35;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($id);
echo "\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Profile <a style=\"float: right;\" href=\"javascript:load_fromsubpage('pos.supplieritems','Supplier Services','clients')\">Services</a></span> \n    \n    \n    \n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<form id=\"frmeditsupplier\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\"><span>";
echo $clientDetails["username"];
echo "</span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"password\" id=\"password\" value=\"\"  type=\"text\"  class=\"txt medium\"/> <!--<input type=\"button\" value=\"";
echo $LNG["resetpass"];
echo "\" name=\"resetpass\" id=\"btnedituserpass\" onclick=\"genpass();\"/>--></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"1\" ";
if ($clientDetails["userstatus"] == "1") {
    echo "checked";
}
echo "/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\" id=\"blocked\" value=\"0\" ";
if ($clientDetails["userstatus"] == "0") {
    echo "checked";
}
echo "/><label for=\"blocked\">";
echo $LNG["blocked"];
echo "</label></span>\n  \n  \n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phone"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"phone\"   value=\"";
echo $clientDetails["phone"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\"  value=\"";
echo $clientDetails["first_name"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\"  value=\"";
echo $clientDetails["last_name"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["registeredemail"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"";
echo $clientDetails["email"];
echo "\" type=\"text\"  class=\"txt large\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "</td>\n    <td class=\"fieldarea\"><textarea name=\"address\">";
echo $clientDetails["address"];
echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown($clientDetails["country"]);
echo "</td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["warehouse"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"mywarehouse\">\n        <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$sq = dquery("select id,name from tbl_warehouse");
while ($row = mysqli_fetch_assoc($sq)) {
    echo "        <option ";
    if ($clientDetails["mywarehouse"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["name"];
    echo "</option>\n        ";
}
echo "    </select>\n    </td>\n</tr>\n    \n</tbody>\n</table>\n</div>\n</div>\n\n<br />\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["login"];
echo " ";
echo $LNG["period"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n  <table>\n    <tbody>\n      <tr>\n        <td>";
$days = explode(",", $clientDetails["logindays"]);
echo "            <input type=\"checkbox\"  name=\"days['sun']\" value=\"sun\"\n             ";
if (in_array("sun", $days)) {
    echo "checked";
}
echo " id=\"days['sun']\"/>\n            <label for=\"days['sun']\">\n            ";
echo $LNG["sun"];
echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['mon']\" value=\"mon\" ";
if (in_array("mon", $days)) {
    echo "checked";
}
echo " id=\"1\"/>\n            <label for=\"1\">\n            ";
echo $LNG["mon"];
echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['tue']\" value=\"tue\" ";
if (in_array("tue", $days)) {
    echo "checked";
}
echo " id=\"2\"/>\n            <label for=\"2\">\n            ";
echo $LNG["tue"];
echo "          </label></td>\n        <td><input type=\"checkbox\"  name=\"days['wed']\" value=\"wed\" ";
if (in_array("wed", $days)) {
    echo "checked";
}
echo " id=\"3\"/>\n            <label for=\"3\">\n            ";
echo $LNG["wed"];
echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['thu']\" value=\"thu\" ";
if (in_array("thu", $days)) {
    echo "checked";
}
echo " id=\"4\"/>\n            <label for=\"4\">\n            ";
echo $LNG["thr"];
echo "            </label>\n            <br />\n            <input type=\"checkbox\"  name=\"days['fri']\" value=\"fri\" ";
if (in_array("fri", $days)) {
    echo "checked";
}
echo " id=\"5\"/>\n            <label for=\"5\">\n            ";
echo $LNG["fri"];
echo "          </label></td>\n        <td><input type=\"checkbox\"  name=\"days['sat']\" value=\"sat\" ";
if (in_array("sat", $days)) {
    echo "checked";
}
echo " id=\"6\"/>\n            <label for=\"6\">\n            ";
echo $LNG["sat"];
echo "            </label>\n            <br />              </td>\n      </tr>\n      \n    </tbody>\n</table>  \n\n\n\n  \n    <br />\n    ";
$start = explode(" ", $clientDetails["start_time"]);
$end = explode(" ", $clientDetails["end_time"]);
echo "    ";
echo $LNG["start"];
echo " ";
echo $LNG["time"];
echo " : \n    <select name=\"starthrs\" style=\"width: 50px;\">\n    ";
for ($i = 0; $i <= 24; $i++) {
    echo "<option ";
    if ($start[0] == $i) {
        echo "selected";
    }
    echo " value=\"";
    echo $i;
    echo "\">";
    echo $i;
    echo "</option>";
}
echo "    </select>\n    :\n    <select name=\"startsec\" style=\"width: 50px;\">\n    ";
for ($i = 0; $i <= 60; $i++) {
    echo "<option ";
    if ($start[1] == $i) {
        echo "selected";
    }
    echo " value=\"";
    echo $i;
    echo "\">";
    echo $i;
    echo "</option>";
}
echo "    </select> ( HH:MM )\n     <br /> <br />\n    ";
echo $LNG["end"];
echo " ";
echo $LNG["time"];
echo "  : &nbsp;\n    <select name=\"endhrs\" style=\"width: 50px;\">\n    ";
for ($i = 0; $i <= 24; $i++) {
    echo "<option ";
    if ($end[0] == $i) {
        echo "selected";
    }
    echo " value=\"";
    echo $i;
    echo "\">";
    echo $i;
    echo "</option>";
}
echo "    </select>\n    :\n    <select name=\"endsec\" style=\"width: 50px;\">\n    ";
for ($i = 0; $i <= 60; $i++) {
    echo "<option ";
    if ($end[1] == $i) {
        echo "selected";
    }
    echo " value=\"";
    echo $i;
    echo "\">";
    echo $i;
    echo "</option>";
}
echo "    </select> ( HH:MM ) \n    \n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  \nonclick=\"SubmitForm ('#btnedituser','editsupplier.profile','#frmeditsupplier','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div>\n</div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>