<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 365;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$admin_template = $config["admin_template"];
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "imeiservice.head.php";
    echo "<div id=\"tabcontent\"> ";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_imei_group"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
global $admin_template;
if ($grpid && $sort != "") {
    sortOrder("tbl_services_imei", "sort", "id", $sort, $type, " AND group_id='" . $grpid . "'");
}
$imeiServiceDetails = getIMEIServices($groups);
echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }\n    }\n});\n\n</script>\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<table>\n<tr><td>\n\n<select name=\"groups\" onchange=\"javascript:redirectedit('imeiquick.edit','&grpid='+this.value+'&defaultpage=imeiquick.edit.php')\">\n";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group order by display_order");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo html_entity_decode($row["group_name"]);
    echo "</option>\n";
}
echo "</select>\n</td>\n<td style=\"float: right;\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','imeiquick.edit','#frmedituser','#notification','true','#main_loader');\"/>\n</td></tr>\n</table><br />\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"imeiquick.edit.php\" />\n<input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\n            <thead>\n              <tr>\n                <th width=\"80px\"> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\" onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" />";
echo $LNG["all"];
echo "</th>\n                <th colspan=\"2\">";
echo $LNG["servicename"];
echo "</th>\n                 <th>";
echo $LNG["time"];
echo "</th>\n                <th>";
echo $LNG["servicecredit"];
echo "  [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>\n";
$sql = dquery("SELECT `code` from `tbl_currencies` where `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <th><div align=\"left\">";
    echo $row["code"];
    echo "</div></th>\n";
}
echo "              </tr>\n            </thead>\n\n\n";
$nocurrency = mysqli_fetch_assoc(dquery("SELECT count(*) from `tbl_currencies` where `default`='0'"));
$nocur = $nocurrency[0] + 5;
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
$i = 0;
foreach ($imeiServiceDetailsKey as $group) {
    if (mysqli_num_rows(dquery("SELECT id FROM tbl_imei_group WHERE group_name='" . $group . "' and active='1'"))) {
        $selected = "checked";
    } else {
        $selected = "";
    }
    echo "<tr><td colspan=" . $nocur . " align=left><input onclick='SelectChildren(this.id);' type='checkbox' id='g_" . $i . "' " . $selected . " name='grp[" . $group . "]' value='" . $group . "'> <strong>" . $group . "</strong></td></tr>";
    $e = 0;
    foreach ($imeiServiceDetails[$group] as $keys) {
        $happyhours = getIMEIhappyhours($keys["id"]);
        if ($keys["status"]) {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $e++;
        echo "  <tbody id=\"menu-";
        echo $keys["id"];
        echo "\">\n<tr>\n<td></td><td><input  name=\"imei_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/></td>\n <td><input type=\"text\" name=\"servicename[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["service_name"];
        echo "\" style=\"width: 100%\"/>\n ";
        if ($e != 1) {
            echo " <a href=\"javascript: redirectedit('imeiquick.edit','";
            echo $keys["id"];
            echo "&sort=";
            echo $keys["id"];
            echo "&defaultpage=imeiquick.edit.php&grpid=";
            echo $keys["group"];
            echo "&type=up')\"><img border=\"0\" src=\"templates/";
            echo $admin_template;
            echo "/images/arrow_up.png\" alt=\"\" /></a>\n ";
        } else {
            echo "&nbsp;&nbsp;&nbsp;";
        }
        if ($e != count($imeiServiceDetails[$group])) {
            echo " <a href=\"javascript: redirectedit('imeiquick.edit','";
            echo $keys["id"];
            echo "&sort=";
            echo $keys["id"];
            echo "&defaultpage=imeiquick.edit.php&grpid=";
            echo $keys["group"];
            echo "&type=down')\"><img border=\"0\" src=\"templates/";
            echo $admin_template;
            echo "/images/arrow_down.png\" alt=\"\" /></a>\n ";
        }
        echo " </td>\n  <td><input type=\"text\" class=\"text-input vsmall-input\" name=\"times[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["time"];
        echo "\" /></td>\n<td align=\"left\">\n<input type=\"text\"  class=\"text-input vsmall-input\"  name=\"servicecredit[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["credit_admin"];
        echo "\"/></td>\n\n";
        $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $d = mysqli_fetch_assoc(dquery("SELECT `credit` FROM `tbl_imei_credit` WHERE `service_id`='" . $keys["id"] . "' AND `currency_id`='" . $row["id"] . "'"));
            echo "            <td><div align=\"left\"><input type=\"text\"  class=\"text-input vsmall-input\"  name=\"";
            echo $row["code"];
            echo "[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $d["credit"];
            echo "\"/></div></td>\n\n";
        }
        echo "</tr>\n";
    }
    $i++;
}
$addon = licince\reqaddon("E-commerce", true);
echo "\n</tbody>\n\n</table>\n<br />\n<select name=\"quickapply\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n<option value=\"1\">";
echo $LNG["disconnectapi"];
echo "</option>\n<option value=\"8\">";
echo $LNG["show"];
echo " ";
echo $LNG["on"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</option>\n";
if ($config["shoppingcart"] && $addon) {
    echo "<option value=\"2\">";
    echo $LNG["retail"];
    echo " ";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["enable"];
    echo "</option>\n<option value=\"3\">";
    echo $LNG["retail"];
    echo " ";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["disable"];
    echo "</option>\n";
}
echo "<option value=\"4\">";
echo $LNG["email"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"5\">";
echo $LNG["email"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["disable"];
echo "</option>\n<option value=\"6\">";
echo $LNG["sms"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"7\">";
echo $LNG["sms"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["disable"];
echo "</option>\n\n</select>&nbsp;<input value=\"";
echo $LNG["applyonselected"];
echo "\" id=\"btnapply\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnapply','imeiquick.apply','#frmedituser','#notification','true','#main_loader');\"/>\n<br/>\n[<small>Apply on checked service list of above</small>]\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','imeiquick.edit','#frmedituser','#notification','true','#main_loader');\"/></p>\n</form></div></div>\n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
echo "\n\n\n\n<script type=\"text/javascript\" src=\"../nest/jquery-ui-1.8.11.custom.min.js\"></script>\n<script type=\"text/javascript\" src=\"../nest/jquery.ui.nestedSortable.js\"></script>\n<script>\n\n\t\$(document).ready(function(){\n\n\t\t\$('table.sortable').nestedSortable({\n\t\t\tdisableNesting: 'no-nest',\n\t\t\tforcePlaceholderSize: true,\n\t\t\thandle: 'tbody',\n\t\t\thelper:\t'clone',\n\t\t\titems: 'tbody',\n\t\t\tmaxLevels: 1,\n\t\t\topacity: .6,\n\t\t\tplaceholder: 'placeholder',\n\t\t\trevert: 250,\n\t\t\ttabSize: 25,\n\t\t\ttolerance: 'pointer',\n\t\t\ttoleranceElement: '> div'\n\t\t});\n\n\t\t\$('#btn-save-menu').click(function(){\n\t\t\tserialized = \$('table.sortable').nestedSortable('toHierarchy');\n\t\t})\n\n\t\t\$('#frmedituser').submit(function() {\n\n\t\t\t\$.ajax({\n\t\t\t\ttype: 'POST',\n\t\t\t\turl: \$(this).attr('action'),\n\t\t\t\tdata: {easymm:  serialized},\n\t\t\t\terror: function() {\n\t\t\t\t\t\$('#btn-save-menu').attr('disabled', false);\n\t\t\t\t\tgbox.show({\n\t\t\t\t\t\tcontent: '<h2>Error</h2>Save menu error. Please try again.',\n\t\t\t\t\t\tautohide: 1000\n\t\t\t\t\t});\n\t\t\t\t},\n\t\t\t\tsuccess: function(data) {\n\t\t\t\t\talert(data);\n\t\t\t\t\tgbox.show({\n\t\t\t\t\t\tcontent: '<h2>Success</h2>Menu position has been saved',\n\t\t\t\t\t\tautohide: 1000\n\t\t\t\t\t});\n\t\t\t\t}\n\t\t\t});\n\t\t\treturn false;\n\t\t});\n\n\t});\n\n\n</script>\n\n<div id=\"page_info\" classs=\"page_info\">\n<li>Quick edit service details service name , time , credit of all currency</li>\n</div>";
$fileverioncheck = "6.1.0";

?>