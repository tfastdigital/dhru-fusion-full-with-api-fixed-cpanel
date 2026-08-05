<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 422;
checkPagePermission($pageid);
include ROOTDIR . "/includes/products.fun.php";
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown");
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add Product Group</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["listedingroup"];
echo " </td>\n    <td class=\"fieldarea\">\n    ";
echo $grp;
echo "    </td>\n</tr>\n <tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n   <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\"\n   class=\"btn save\" type=\"button\"\n    onclick=\"SubmitForm ('#btnaddgroup','productgroups','#frm','#notification','true','#main_loader');\"/>\n\n   </td>\n</tr>\n</tbody>\n</table>\n</div></div>\n</form>\n<br />\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"productgroups.php\" />\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\n            <thead>\n              <tr>\n<th style=\"width: 10% !important;\"> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\"\nonClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /></th>\n<th style=\"width: 90% !important;  text-align: left !important;\" align=\"left\">";
echo $LNG["group"];
echo "</th>\n              </tr>\n            </thead>\n";
$i = 1;
for ($g = dquery("select * from tbl_product_group"); $r = mysqli_fetch_assoc($g); $i++) {
    echo "<tr>\n<td style=\"width: 10% !important; \">\n<input name=\"imei_check[";
    echo $r["id"];
    echo "]\" value=\"";
    echo $r["id"];
    echo "\"\n    type=\"checkbox\" class=\"g_";
    echo $i;
    echo "\"/></td>\n<td style=\"width: 90% !important; \">\n<input style=\"float: left; width: 300px !important;\" type=\"text\" name=\"service[";
    echo $r["id"];
    echo "]\"  value=\"";
    echo $r["group_name"];
    echo "\" />\n</td>\n</tr>\n";
}
echo "</table>\n<br />\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\"\nclass=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnedituser1','productgroups.edit','#frmedituser','#notification','true','#main_loader');\"/></p>\n</form>\n\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>