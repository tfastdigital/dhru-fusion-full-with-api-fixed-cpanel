<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 547;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$admin_template = $config["admin_template"];
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "catlog.head.php";
    echo "<div id=\"tabcontent\"> ";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_product_group"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
global $admin_template;
if ($grpid && $sort != "") {
    sortOrder("tbl_products", "sort", "id", $sort, $type, " AND group_id='" . $grpid . "'");
}
$proServiceDetails = getProducts($groups);
echo "<script>\n\$(function () {\n    SelectChildren = function (element)\n    {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }\n    }\n});\n</script>\n<div id=\"notification\"></div>\n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n    \$('#main_tbl').tableDnD({\n        onDrop: function(table, row) {\n           var serialized= \$.tableDnD.serialize();\n\n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/productquick.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\nfunction checkRemove(val){\n    if(val==15){\n        \$(\"#removetype\").show();\n    }else{\n        \$(\"#removetype\").hide();\n        \$(\"#remoption\").hide();\n    }\n}\nfunction checkRemType(val){\n    if(val==2){\n        \$(\"#remoption\").show();\n    }else{\n        \$(\"#remoption\").hide();\n    }\n}\n</script>\n\n<table>\n<tr><td>\n\n<select name=\"groups\" onchange=\"javascript:\nreloadcurrent('productquick.edit','&grpid='+this.value+'&defaultpage=productquick.edit.php')\">\n";
$sql = dquery("SELECT id,group_name FROM tbl_product_group \nORDER BY display_order");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n";
}
echo "</select>\n\n</td>\n<td style=\"float: right;\">\n<form method=\"post\" action=\"includes/pages/dl.php\" style=\"float: left;\">\n<input type=\"submit\" name=\"expocatalog\" value=\"";
echo $LNG["export"];
echo " ";
echo $LNG["catlog"];
echo "\" />\n</form>\n</td></tr>\n</table><br />\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"productquick.edit.php\" />\n<input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\n            <thead>\n              <tr>\n                <th> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\"\n                 type=\"checkbox\" /><label></label></th>\n                <th>";
echo $LNG["servicename"];
echo "</th>\n                <th>";
echo $LNG["servicecredit"];
echo "  [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>\n        ";
$sql = dquery("SELECT `code` from `tbl_currencies` where\n         `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <th><div align=\"left\">";
    echo $row["code"];
    echo "</div></th>\n        ";
}
echo "                <th>";
echo $LNG["affiliate"];
echo " ";
echo $LNG["commission"];
echo " %</th>\n                <th>";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n       <tbody>\n";
$nocurrency = mysqli_fetch_assoc(dquery("SELECT count(*) from `tbl_currencies` where `default`='0'"));
$nocur = $nocurrency[0] + 5;
$proServiceDetailsKey = array_keys($proServiceDetails);
$i = 0;
foreach ($proServiceDetailsKey as $group) {
    $grps = explode("_", $group);
    $grps = $grps[0];
    $grps = htmlspecialchars($grps);
    if (mysqli_num_rows(dquery("SELECT id FROM tbl_product_group WHERE group_name=\"" . $grps . "\" and active='1'"))) {
        $selected = "checked";
    } else {
        $selected = "";
    }
    echo "<tr class='nodrag'><td colspan=" . $nocur . " align=left class='singletd'><input onclick='SelectChildren(this.id);' class='check-child' type='checkbox' id='g_" . $i . "' " . $selected . " name='grp[" . $grps . "]' value='" . $grps . "'> <strong><label>" . html_entity_decode($grps) . "</label></strong></td><td></td></tr>";
    $e = 0;
    foreach ($proServiceDetails[$group] as $keys) {
        if ($keys["status"]) {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $e++;
        echo "<tr id=\"";
        echo $keys["id"];
        echo "\" title=\"Drag & Drop to Change Position\">\n<td><input  name=\"imei_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\"\ntype=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/><label></label></td>\n<td>";
        echo $keys["service_name"];
        echo "</td>\n<td align=\"left\">\n  <input type=\"text\"  class=\"text-input vsmall-input\"\n  name=\"servicecredit[";
        echo $keys["id"];
        echo "]\"\n  value=\"";
        echo $keys["credit_admin"];
        echo "\"/>\n</td>\n";
        $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $d = mysqli_fetch_assoc(dquery("SELECT `credit` FROM \n`tbl_product_credit` WHERE `service_id`='" . $keys["id"] . "' \nAND `currency_id`='" . $row["id"] . "'"));
            echo "<td><div align=\"left\"><input type=\"text\"\nclass=\"text-input vsmall-input\"\nname=\"";
            echo $row["code"];
            echo "[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $d["credit"];
            echo "\"/>\n<label></label></div></td>\n";
        }
        echo "<td><input type=\"text\" class=\"text-input vsmall-input\" name=\"commission[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["affiliate_comission"];
        echo "\" /></td>\n<td><a class='default_dg_a editdata' href=\"javascript:load_fromsubpage('editproduct&id=";
        echo $keys["id"];
        echo "', '";
        echo $keys["service_name"];
        echo "')\">";
        echo $LNG["edit"];
        echo "</a></td>\n</tr>\n";
    }
    $i++;
}
$addon = licince\reqaddon("E-commerce", true);
echo "</tbody>\n</table>\n\n <img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin:0px 0 0 5px; border:0px;\" />\n\n<select name=\"quickapply\" onchange=\"checkRemove(this.value);\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n<option value=\"1\">";
echo $LNG["remove"];
echo " ";
echo $LNG["key"];
echo " ";
echo $LNG["selling"];
echo "</option>\n<option value=\"2\">";
echo $LNG["show"];
echo " ";
echo $LNG["on"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</option>\n<option value=\"3\">";
echo $LNG["remove"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</option>\n<option value=\"4\">";
echo $LNG["best"];
echo " ";
echo $LNG["selling"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"5\">";
echo $LNG["best"];
echo " ";
echo $LNG["selling"];
echo " ";
echo $LNG["disable"];
echo "</option>\n<option value=\"6\">";
echo $LNG["stock"];
echo " ";
echo $LNG["calculation"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"7\">";
echo $LNG["stock"];
echo " ";
echo $LNG["calculation"];
echo " ";
echo $LNG["disable"];
echo "</option>\n<option value=\"8\">";
echo $LNG["disable"];
echo " ";
echo $LNG["happy"];
echo " ";
echo $LNG["hours"];
echo "</option>\n<option value=\"11\">";
echo $LNG["review"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"12\">";
echo $LNG["review"];
echo " ";
echo $LNG["disable"];
echo "</option>\n<option value=\"13\">";
echo $LNG["tax"];
echo " ";
echo $LNG["enable"];
echo "</option>\n<option value=\"14\">";
echo $LNG["tax"];
echo " ";
echo $LNG["disable"];
echo "</option>\n<option value=\"15\">";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "</option>\n";
if (licince\reqaddon("E-commerce", true)) {
    echo "<option value=\"16\">Partner Site ";
    echo $LNG["enable"];
    echo "</option>\n<option value=\"17\">Partner Site ";
    echo $LNG["disable"];
    echo "</option>\n";
}
echo "</select>\n&nbsp;\n<select name=\"removetype\" id=\"removetype\"\nstyle=\"display: none;\" onchange=\"checkRemType(this.value);\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n<option value=\"1\">";
echo $LNG["soft"];
echo " ";
echo $LNG["delete"];
echo "</option>\n<option value=\"2\">";
echo $LNG["physically"];
echo " ";
echo $LNG["delete"];
echo "</option>\n</select>\n&nbsp;\n<div id=\"remoption\" style=\"display: none;width: 200px;\n margin-left: 10px; \">\n<input type=\"checkbox\" name=\"remorder\" id=\"remorder\" value=\"1\" />\n<label for=\"remorder\">";
echo $LNG["remove"];
echo " ";
echo $LNG["orders"];
echo "</label> <br />\n</div>\n&nbsp;\n<input value=\"";
echo $LNG["applyonselected"];
echo "\"\nid=\"btnapply\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnapply','productquick.apply','#frmedituser','#notification','true','#main_loader');\"/>\n<br/>\n<small style=\"margin-left: 50px;\">Apply on checked service list of above</small>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','productquick.edit','#frmedituser','#notification','true','#main_loader');\"/></p>\n</form></div></div>\n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
echo "<div id=\"page_info\" class=\"page_info\">\n<li>Quick edit service details,service name,time,price in all currency and service active or inactive </li>\n<li>Just Drag and drop to change postion of listing</li>\n</div>";
$fileverioncheck = "6.1.0";

?>