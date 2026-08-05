<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 55;
checkPagePermission($pageid);
echo " \n<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n";
$access_group = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_admin_access_group` WHERE `id`='" . $id . "' "));
$current_access_group = explode(",", $access_group["access"]);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmeditrolegroup\" id=\"frmeditrolegroup\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n";
echo $LNG["name"];
echo " &nbsp;&nbsp;&nbsp; <input name=\"name\" size=\"80\" value=\"";
echo $access_group["group_name"];
echo "\" type=\"text\" /><br />\n\n<table  border=\"0\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldarea\" colspan=\"2\">\n        <div align=\"right\"><a class=\"boldlink\" href=\"#\" onclick=\"zCheckAll(frmeditrolegroup);return false\">";
echo $LNG["checkall"];
echo "</a> | <a class=\"boldlink\" href=\"#\" onclick=\"zUncheckAll(frmeditrolegroup);return false\">";
echo $LNG["uncheckall"];
echo "</a></div>\n            \n            ";
$group = dquery("select distinct groupname from tbl_admin_access");
$k = 0;
while ($group_row = mysqli_fetch_assoc($group)) {
    echo "<fieldset style='padding:0 5px;margin-bottom:30px;'><legend style='padding:5px 10px'><input onclick=SelectChildren(this.id); type=checkbox id='g_" . $k . "' class=''><label for='g_" . $k . "' onclick=SelectChildren(g_" . $k . ");> " . $group_row["groupname"] . " </label></legend>";
    if ($OnlyEcommerce) {
        $result = dquery("SELECT * FROM `tbl_admin_access` where groupname='" . $group_row["groupname"] . "' and shop='1'");
    } else {
        $result = dquery("SELECT * FROM `tbl_admin_access` where groupname='" . $group_row["groupname"] . "'");
    }
    $count = ceil(mysqli_num_rows($result) / 3);
    $i = 0;
    echo "<table width=100%><tbody><tr>";
    while ($val = mysqli_fetch_assoc($result)) {
        if ($i == 0 || $i == $count || $i == $count * 2) {
            echo "<td valign=\"top\" width=\"33%\" style=\"padding:10px\">";
        }
        if (in_array($val["id"], $current_access_group)) {
            $checked = "checked=\"checked\"";
        } else {
            $checked = "";
        }
        if (($val["id"] == "168" || $val["id"] == "55") && $id == "1") {
            $disable = "disabled=\"disable\"";
        } else {
            $disable = "";
            echo "<input name='access_permission[" . $val["id"] . "]' id='access_permission" . $val["id"] . "' type='checkbox' " . $disable . " " . $checked . " value='" . $val["id"] . "' class='g_" . $k . "'/> <label for='access_permission" . $val["id"] . "'>" . $val["page_description"] . "</label><hr style='margin:5px 0;border-top:#f4f4f4 dotted 1px'/>";
        }
        $i++;
        if ($i == $count || $i == $count * 2) {
            echo "</td>";
        }
    }
    $k++;
    echo "</tr></tbody></table></fieldset>";
}
echo "            \n    \n</td>\n</tr>\n<tr>\n<td>\n\n<fieldset style=\"padding:0 5px;margin-bottom:30px;\">\n    <legend style=\"padding:5px 10px\">\n        ";
echo $LNG["emailmessages"];
echo "    </legend>\n\n    <table width=\"100%\">\n        <tbody>\n            <tr>\n                <td width=\"33%\" valign=\"top\" style=\"padding:10px\">\n                \n<input name=\"systememails\" value=\"1\" type=\"checkbox\" id=\"systememails\" ";
if ($access_group["system"] == "1") {
    echo "checked=checked";
}
echo "/><label for=\"systememails\">";
echo $LNG["systememails"];
echo "</label>                    <hr style=\"margin:5px 0;border-top:#f4f4f4 dotted 1px\" />\n<input name=\"accountemails\" value=\"1\" type=\"checkbox\" id=\"accountemails\" ";
if ($access_group["account"] == "1") {
    echo "checked=checked";
}
echo "/><label for=\"accountemails\">";
echo $LNG["accountemails"];
echo "</label>                    <hr style=\"margin:5px 0;border-top:#f4f4f4 dotted 1px\" />\n<input name=\"supportemails\" value=\"1\" type=\"checkbox\" id=\"supportemails\" ";
if ($access_group["support"] == "1") {
    echo "checked=checked";
}
echo "/> <label for=\"supportemails\">";
echo $LNG["supportemails"];
echo "</label>\n\n                    \n                </td>\n            </tr>\n        </tbody>\n    </table>\n</fieldset>\n\n</td></tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btneditrolegroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btneditrolegroup','editadminaccessgroup','#frmeditrolegroup','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>