<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "fileservice.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 364;
checkPagePermission($pageid);
$admin_template = $config["admin_template"];
global $admin_template;
if ($grpid && $sort != "") {
    sortOrder("tbl_services_file", "sort", "id", $sort, $type, " AND group_id='" . $grpid . "'");
}
include_once ROOTDIR . "/includes/fileservices.fun.php";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    echo "<div id=\"tabcontent\">";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_file_group \n    ORDER BY display_order"));
    $groups = $sql["id"];
}
$limit = 100;
$fileServiceDetails = getFileServices($groups);
echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }\n    }\n});\nfunction checkRemove(val){\n    if(val==15){\n        \$(\"#removetype\").show();\n    }else{\n        \$(\"#removetype\").hide();\n        \$(\"#remoption\").hide();\n    }\n}\nfunction checkRemType(val){\n    if(val==2){\n        \$(\"#remoption\").show();\n    }else{\n        \$(\"#remoption\").hide();\n    }\n}\n</script>\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n    \$('#main_tbl').tableDnD({\n        onDrop: function(table, row) {\n           var serialized= \$.tableDnD.serialize();\n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/filequick.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\n</script>\n<style>\n    #main_tbl td{border-right: #eee solid 1px;}\n</style>\n<div id=\"notification1\"></div>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n\n<fieldset class=\"search-form\">\n            <legend>Quick Search</legend>\n            <div class=\"row\">\n                <select  name=\"groups\"  class=\"chosen\"\nonchange=\"javascript:reloadcurrent('filequick.edit','&grpid='+this.value+'&id=";
echo $id;
echo "&defaultpage=filequick.edit.php')\">\n";
$sql = dquery("SELECT id,group_name FROM\n tbl_file_group ORDER BY display_order,group_name asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($grpid == $row["id"]) {
        echo "selected";
    }
    echo "value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n";
}
echo "</select>\n\n                <input type=\"text\" name=\"searchkey\" class=\"txt col\" placeholder=\"Search service from any group\" value=\"\" >\n                <input value=\"Search\" type=\"submit\" class=\"button ml-1\" name=\"add\">\n            </div>\n        </fieldset>\n\n\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" class=\"quick quicksort\">\n            <thead>\n              <tr class='nodrag'>\n                <th class=\"sorter-false\"> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\"\n                onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /><label></label></th>\n                <th>\n                    Service Name\n                </th>\n                <th  class=\"sorter-false\">";
echo $LNG["purchase"];
echo " <br/>";
echo $LNG["cost"];
echo " [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>\n                <th  class=\"sorter-false\">";
echo $LNG["servicecredit"];
echo " <br/>  [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>\n";
$sql = dquery("SELECT `code` from `tbl_currencies` where `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <th  class=\"sorter-false\"><div>";
    echo $row["code"];
    echo "</div></th>\n";
}
echo "\n              </tr>\n            </thead>\n             <tbody>\n";
$nocurrency = mysqli_fetch_assoc(dquery("SELECT count(*) from `tbl_currencies` where `default`='0'"));
$nocur = $nocurrency[0] + 4;
$fileServiceDetailsKey = array_keys($fileServiceDetails);
$i = 0;
foreach ($fileServiceDetailsKey as $group) {
    if (mysqli_num_rows(dquery("SELECT id FROM tbl_file_group WHERE group_name=\"" . $group . "\" and active='1'"))) {
        $selected = "checked";
    } else {
        $selected = "";
    }
    $e = 0;
    echo "\n";
    foreach ($fileServiceDetails[$group] as $keys) {
        $happyhours = getFilehappyhours($keys["id"]);
        if ($keys["status"]) {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $e++;
        echo "\n<tr id=\"";
        echo $keys["id"];
        echo "\" title=\"";
        echo html_entity_decode($keys["service_name"]);
        echo "\">\n<td class=\"text-center\"><input  name=\"file_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\"\n type=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/><label></label></td>\n<td class=\"w-100\">\n    <span class=\"d-none\">";
        echo html_entity_decode($keys["service_name"]);
        echo "</span>\n    <input type=\"text\"  name=\"servicename[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo html_entity_decode($keys["service_name"]);
        echo "\" />\n</td>\n <td>\n<input type=\"text\"   class=\"text-input  alert-update\"\nname=\"purchase_cost[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["purchase_cost"];
        echo "\"/>\n</td>\n<td>\n<input type=\"text\"    class=\"text-input  alert-update\"\nname=\"servicecredit[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["credit_admin"];
        echo "\"/>\n</td>\n";
        $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
        while ($row = mysqli_fetch_assoc($sql)) {
            $d = mysqli_fetch_assoc(dquery("SELECT `credit` FROM\n         `tbl_file_credit` WHERE `service_id`='" . $keys["id"] . "' \n         AND `currency_id`='" . $row["id"] . "'"));
            echo "<td><div><input type=\"text\"  style=\"width: 100px;\"\nclass=\"text-input  alert-update\"\nname=\"";
            echo $row["code"];
            echo "[";
            echo $keys["id"];
            echo "]\"\nvalue=\"";
            echo $d["credit"];
            echo "\"/></div></td>\n";
        }
        echo "\n</tr>\n";
    }
    $i++;
}
unset($keys);
echo "\n</tbody></table>\n\n <img width=\"38\" height=\"22\" style=\"padding:0px; margin-left:5px; border:0px;\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" alt=\"With selected\" title=\"\">\n\n<select name=\"quickapply\" onchange=\"checkRemove(this.value);\" >\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n<option value=\"15\">";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "</option>\n</select>&nbsp;\n<select name=\"removetype\" id=\"removetype\"  style=\"display: none;\" onchange=\"checkRemType(this.value);\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n<option value=\"1\">";
echo $LNG["soft"];
echo " ";
echo $LNG["delete"];
echo "</option>\n<option value=\"2\">";
echo $LNG["physically"];
echo " ";
echo $LNG["delete"];
echo "</option>\n</select>\n&nbsp;\n<div id=\"remoption\" style=\"display: none;    width: 200px; margin-left: 10px; \">\n<input type=\"checkbox\" name=\"remorder\" id=\"remorder\" value=\"1\" /> <label for=\"remorder\">";
echo $LNG["remove"];
echo " ";
echo $LNG["orders"];
echo "</label> <br />\n<input type=\"checkbox\" name=\"remclient\" id=\"remclient\" value=\"1\" /> <label for=\"remclient\">";
echo $LNG["remove"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["clientgroup"];
echo "</label>\n</div>\n&nbsp;\n<input value=\"";
echo $LNG["applyonselected"];
echo "\" id=\"btnapply\" class=\"btn\"\ntype=\"button\"  onclick=\"SubmitForm ('#btnapply','filequick.apply','#frmedituser','#notification','true','#main_loader');\"/>\n<br/>\n<small style=\"margin-left: 50px;\">Apply on checked service list of above</small>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser12\"\nclass=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser12','filequick.edit','#frmedituser','#notification','true','#main_loader');\"/></p>\n</form></div></div>\n\n<div id=\"page_info\" class=\"page_info\">\n<li>Quick edit service details,service name,time,price in all currency and service active or inactive </li>\n<li>Just Drag and drop to change postion of listing</li>\n</div>\n";
if (isset($_GET["grpid"])) {
    echo "</div> ";
}
$fileverioncheck = "6.1.0";

?>