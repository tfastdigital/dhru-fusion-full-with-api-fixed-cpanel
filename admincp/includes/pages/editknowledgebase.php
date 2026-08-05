<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n";
$pageid = 119;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
if ($titlea && $contenta && $add) {
    checkDemoMode(false);
    $data["title"] = $titlea;
    $data["content"] = $contenta;
    $data["date"] = $datea;
    $data["group_id"] = $groupa;
    $data["displayorder"] = $displayorder;
    if ($db->insert("tbl_knowledgebase", $data)) {
        echo "<div id=notification1 class=successbox>" . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox>" . $LNG["datanotsave"] . " </div>";
    }
    $data = NULL;
}
if ($title && $id) {
    checkDemoMode(false);
    $data["title"] = $title;
    $data["content"] = html_entity_decode($info);
    $data["date"] = $date;
    $data["group_id"] = $group;
    $data["login"] = $login;
    $data["displayorder"] = $displayorder;
    if ($db->update("tbl_knowledgebase", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$base = mysqli_fetch_assoc(dquery("select * from tbl_knowledgebase\n where id='" . $id . "'"));
$data = NULL;
echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" onclick=\"getContect('#tab','main2.php?page=knowledgebase','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["listknowledgebase"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=addknowledgebase','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["addknowledgebase"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab2','main2.php?page=knowledgebasecatlist','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["view"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab3','main2.php?page=knowledgebasecatadd','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n    <div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\">\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($loaddefaultpage) {
    echo "<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"addknowledgebase.php\" />\n";
    echo generate_token("form");
    echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["title"];
    echo " *</td>\n    <td class=\"fieldarea\"><input name=\"titlea\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["group"];
    echo " *</td>\n    <td class=\"fieldarea\">\n    <select name=\"groupa\">\n    ";
    $sql = dquery("select * from tbl_knowledgebasecat");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "  <option value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["category"];
        echo "</option>\n    ";
    }
    echo "    </select> &nbsp; <a href=\"#\" data-target=\"knowledgebasecatadd\"\n     data-target-header=\"";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["category"];
    echo "\"\n      onclick=\"AddnewInpopup(this);\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["category"];
    echo "</a>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["content"];
    echo " *</td>\n    <td class=\"fieldarea\"><textarea id=\"message\" name=\"contenta\"></textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["date"];
    echo "</td>\n    <td class=\"fieldarea\"><input name=\"datea\"  value=\"\"\n    type=\"text\" id=\"from\"/></td>\n</tr>\n\n</tbody>\n</table>\n\n\n<p class=\"fixedbtn\"><input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnaddgroup\"\nname=\"add\" class=\"btn\" type=\"submit\"  /> </p>\n\n</form> ";
} else {
    echo "\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n";
    echo generate_token("form");
    echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["title"];
    echo " *</td>\n    <td class=\"fieldarea\"><input name=\"title\"  value=\"";
    echo $base["title"];
    echo "\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["group"];
    echo " *</td>\n    <td class=\"fieldarea\">\n    <select name=\"group\">\n    ";
    $sql = dquery("select * from tbl_knowledgebasecat");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "        <option value=\"";
        echo $row["id"];
        echo "\"\n        ";
        if ($row["id"] == $base["group_id"]) {
            echo "selected";
        }
        echo " >";
        echo $row["category"];
        echo "</option>\n    ";
    }
    echo "    </select> &nbsp; <a href=\"#\" data-target=\"knowledgebasecatadd\" data-target-header=\"";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["category"];
    echo "\" onclick=\"AddnewInpopup(this);\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["category"];
    echo "</a>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["content"];
    echo " *</td>\n    <td class=\"fieldarea\"><textarea name=\"info\">";
    echo $base["content"];
    echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["date"];
    echo "</td>\n    <td class=\"fieldarea\"><input name=\"date\" id=\"from\"  class=\"datepicker\"  placeholder=\"yyyy-mm-dd\"\n    value=\"";
    echo $base["date"];
    echo "\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["display"];
    echo " ";
    echo $LNG["after"];
    echo " ";
    echo $LNG["login"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <label><input name=\"login\"  value=\"1\"\n    ";
    if ($base["login"]) {
        echo "checked";
    }
    echo "     type=\"checkbox\" id=\"login\"/></label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["display"];
    echo " ";
    echo $LNG["order"];
    echo "</td>\n    <td class=\"fieldarea\"><input size=\"3\" name=\"displayorder\" id=\"displayorder\"\n    value=\"";
    echo $base["displayorder"];
    echo "\" type=\"text\"/></td>\n</tr>\n\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\"   onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\" class=\"submit\" type=\"submit\"/>\n</div>\n\n</form>\n";
}
echo "</div></div>\n </div>";
$fileverioncheck = "6.1.0";

?>