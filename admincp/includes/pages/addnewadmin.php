<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 253;
checkPagePermission($pageid);
echo " <script>\n    subheader2_txt('');\n </script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmaddadmin\" id=\"frmaddadmin\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<div class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["system"];
echo " ";
echo $LNG["detail"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["username"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"username\" size=\"80\" value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"password\" size=\"80\" value=\"\" type=\"password\" class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["assignrole"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"group_name\">\n    ";
$query = "SELECT * FROM `tbl_admin_access_group`";
$result = dquery($query);
while ($noticia = mysqli_fetch_assoc($result)) {
    echo "<option value=\"";
    echo $noticia["id"];
    echo "\">";
    echo $noticia["group_name"];
    echo "</option>\n";
}
echo "</select> &nbsp; <a href=\"#\" data-target=\"adminroles\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " role\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " role</a>\n</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" class=\"onoff {labelOn: 'Active', labelOff: 'Inactive'}\" name=\"status\" value=\"0\" checked=\"checked\" id=\"active\"/><label for=\"active\"></label></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["language"];
echo "</td>\n    <td class=\"fieldarea\">\n";
echo str_replace("Language:", "", getLanguageDropdown($admin_info["language"]));
echo "</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["template"];
echo "</td>\n    <td class=\"fieldarea\"><select name=\"template\">\n ";
$handle = opendir("templates");
while (($file = readdir($handle)) !== false) {
    if ($file != "." && $file != ".." && $file != "mobile2") {
        if ($admin_info["template"] == $file) {
            $selected = "selected=selected";
        } else {
            $selected = "";
        }
        echo "<option value=" . $file . " " . $selected . ">" . $file . "</option>";
    }
}
closedir($handle);
echo "</select></td>\n</tr>\n\n</table>\n</div></div>\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Personal Details</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\" size=\"80\" value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\" size=\"80\" value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["contact"];
echo " ";
echo $LNG["no"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"contact\" size=\"40\" value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"email\" size=\"80\" value=\"\" type=\"text\"  class=\"txt medium\" /></td>\n</tr>\n\n\n\n</tbody>\n</table>\n\n</div>\n</div>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddadmin\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddadmin','addnewadmin','#frmaddadmin','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>