<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 12;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once "includes/3rdparty/editor/editor.php";
if ($title && $pagename && $type) {
    checkDemoMode(false);
    $data["title"] = $title;
    $data["type"] = $type;
    $data["content"] = html_entity_decode($tinyvalue);
    $data["login"] = $login;
    $data["show_top"] = $top;
    $data["page_name"] = $page_name;
    if ($db->insert("tbl_custom_page", $data)) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\"  width=\"15%\">";
echo $LNG["title"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"title\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["pagename"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"pagename\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["type"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"type\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["content"];
echo " *</td>\n    <td class=\"fieldarea\"><textarea name=\"info\"></textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["loginrequired"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"login\" value=\"1\" checked /> Yes\n    <input type=\"radio\" name=\"login\" value=\"0\" /> No\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["showontop"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"top\" value=\"1\" checked /> Yes\n    <input type=\"radio\" name=\"top\" value=\"0\" /> No\n    </td>\n</tr>\n</tbody>\n</table>\n\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"submit\" onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('info').getContent();\"/> </p>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>