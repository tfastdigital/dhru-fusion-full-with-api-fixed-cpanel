<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n";
$pageid = 389;
checkPagePermission($pageid);
require_once "../comm.php";
require_once "includes/fun.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
if ($newpage) {
    checkDemoMode(false);
    if (!($obj = mysqli_num_rows(dquery("SELECT * FROM tbl_cms_pages WHERE  `urlname`='" . $newpage . "'")))) {
        $data["urlname"] = preg_replace("/[^a-zA-Z0-9]/", "", $newpage);
        $data["status"] = "published";
        $data["publish_time"] = date("Y-m-d H:i:s");
        $data["view"] = "all";
        $db->insert("tbl_cms_pages", $data);
        $data = NULL;
        $newpage = NULL;
        $oid = $pageinfors = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_pages` ORDER BY `id` DESC"));
        $oid = $oid["id"];
    }
}
echo "\n<ul id=\"tabmenu\"> \n";
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    $file = trim($file);
    if ($file != "." && $file != ".." && $file != "") {
        $file2 = explode(".", $file);
        $file = explode(".", $file);
        $file = $file[0];
        if ($file2[0] && $file2[1] == "txt") {
            echo "             <li><a ";
            if ($config["language"] == $file && !$files) {
                echo "class='tabmenu_active'";
            } else {
                if ($files == $file) {
                    echo "class='tabmenu_active'";
                }
            }
            echo "  onclick=\"javascript:redirectedit('newpage','&oid=";
            echo $oid;
            echo "&files=";
            echo $file;
            echo "')\" id=\"tab1\" >";
            echo $file;
            echo "</a></li>\n        ";
        }
    }
}
echo "<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent1\"> \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($oid && $files && $edit) {
    checkDemoMode(false);
    $data["status"] = $status ? "published" : "";
    $db->update("tbl_cms_pages", $data, "id=" . $oid);
    $data = NULL;
    $obj = dquery("SELECT * FROM tbl_cms_page_language WHERE `relid`='" . $oid . "' AND `language`='" . $files . "'");
    if (mysqli_num_rows($obj)) {
        $editor = mysqli_fetch_assoc($obj);
        $data["title"] = $title;
        $data["breadcrumb"] = $breadcrumb;
        $data["body"] = $body;
        if ($db->update("tbl_cms_page_language", $data, "id=" . $editor["id"])) {
            echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
        $data = NULL;
    } else {
        $data["title"] = $title;
        $data["breadcrumb"] = $breadcrumb;
        $data["body"] = $body;
        $data["language"] = $files;
        $data["relid"] = $oid;
        if ($db->insert("tbl_cms_page_language", $data)) {
            echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
        $data = NULL;
    }
}
if ($oid && $files) {
    $pageinfors = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_pages` WHERE  `id`='" . $oid . "'"));
    $cms = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_cms_page_language` WHERE  `relid`='" . $oid . "' AND `language`='" . $files . "'"));
    echo "<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"edit\" value=\"true\" />\n";
    echo generate_token("form");
    echo "<input type=\"hidden\"  name=\"oid\" value=\"";
    echo $oid;
    echo "\"/>\n<input type=\"hidden\" name=\"files\" value=\"";
    echo $files;
    echo "\"/>\n<table class=\"form\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["title"];
    echo " </td>\n    <td class=\"fieldarea\"><input name=\"title\"  value=\"";
    echo $cms["title"];
    echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["breadcrumb"];
    echo " </td>\n    <td class=\"fieldarea\"><input name=\"breadcrumb\"  value=\"";
    echo $cms["breadcrumb"];
    echo "\" type=\"text\"  class=\"txt large\"/></td>\n</tr>\n<tr> \n    <td class=\"fieldlabel\">Page Details</td>   \n    <td class=\"fieldarea\"><textarea name='body' id=\"message\">";
    echo $cms["body"];
    echo "</textarea></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">Page Property</td><td class=\"fieldarea\"><input type=\"checkbox\" id=\"inr\" ";
    if ($pageinfors["status"] == "published") {
        echo "checked='checked'";
    }
    echo " value=\"1\" name=\"status\" /> <label for=\"inr\">";
    echo $LNG["published"];
    echo "</label></td>\n</tr>\n<tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n<input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnoverview\" class=\"btn save\" type=\"submit\"   /></td></tr>\n</tbody>\n</table>\n\n\n</form>\n";
} else {
    if ($oid) {
        echo "<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"edit\" value=\"true\" />\n";
        echo generate_token("form");
        echo "<input type=\"hidden\"  name=\"oid\" value=\"";
        echo $oid;
        echo "\"/>\n<input type=\"hidden\" name=\"files\" value=\"";
        echo $config["language"];
        echo "\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["title"];
        echo " </td>\n    <td class=\"fieldarea\"><input name=\"title\"  value=\"\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
        echo $LNG["breadcrumb"];
        echo " </td>\n    <td class=\"fieldarea\"><input name=\"breadcrumb\"  value=\"\" type=\"text\"  class=\"txt large\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>   \n    <td class=\"fieldarea\"><textarea name='body' id=\"message\"></textarea></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input type=\"checkbox\" id=\"inr\" ";
        if ($pageinfors["status"] == "published") {
            echo "checked='checked'";
        }
        echo " value=\"1\" name=\"status\" /> <label for=\"inr\">";
        echo $LNG["published"];
        echo "</label></td>\n</tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\">\n\n<input value=\"";
        echo $LNG["save"];
        echo "\" id=\"btnoverview\" class=\"btn save\" type=\"submit\"   />\n </p>\n</form>\n";
    }
}
echo "</div></div>\n </div> \n \n \n";
$fileverioncheck = "6.1.0";

?>