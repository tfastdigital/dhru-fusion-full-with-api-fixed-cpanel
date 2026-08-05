<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n";
$pageid = 11;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"addknowledgebase.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["title"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"titlea\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["group"];
echo " *</td>\n    <td class=\"fieldarea\">\n    <select name=\"groupa\">\n        ";
$sql = dquery("select * from tbl_knowledgebasecat");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "        <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["category"];
    echo "</option>\n        ";
}
echo "    </select>  &nbsp; <a href=\"#\" data-target=\"knowledgebasecatadd\"\n    data-target-header=\"";
echo $LNG["add"];
echo "     ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "\"\n     onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["content"];
echo " *</td>\n    <td class=\"fieldarea\"><textarea name=\"contenta\" rows=\"15\"\n    style=\"width: 100%;\" id=\"message\"></textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"datea\" class=\"datepicker\" autocomplete=\"off\" value=\"\" type=\"text\" id=\"from\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " ";
echo $LNG["after"];
echo " ";
echo $LNG["login"];
echo "</td>\n    <td class=\"fieldarea\">\n    <label><input name=\"login\"  value=\"1\"\n     type=\"checkbox\" id=\"login\"/></label></td>\n</tr>\n\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"tinyMCE.triggerSave(); SubmitForm ('#btnoverview','addarticle','#frm','#notification','true','#main_loader');\"/> </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>