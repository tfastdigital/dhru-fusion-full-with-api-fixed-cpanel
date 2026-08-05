<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 254;
checkPagePermission($pageid);
echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form method=\"post\" name=\"frmaddrolegroup\" id=\"frmaddrolegroup\">\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\"><input name=\"name\" size=\"80\" value=\"";
echo $access_group["group_name"];
echo "\" type=\"text\" /></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["permission"];
echo "</td><td class=\"fieldarea\">\n    <table width=\"100%\"><tbody>\n        <tr>\n            \n             ";
$group = dquery("select distinct groupname from tbl_admin_access");
$k = 0;
while ($group_row = mysqli_fetch_assoc($group)) {
    echo "<br><h3><input onclick=SelectChildren(this.id); type=checkbox id='g_" . $k . "'> " . $group_row["groupname"] . "</h3><hr noshade size=1 align=center background-color: #cccccc;>";
    $result = dquery("SELECT * FROM `tbl_admin_access` where groupname='" . $group_row["groupname"] . "'");
    $count = ceil(mysqli_num_rows($result) / 3);
    $i = 0;
    echo "<table width=100%><tbody><tr>";
    while ($val = mysqli_fetch_assoc($result)) {
        if ($i == 0 || $i == $count || $i == $count * 2) {
            echo "<td valign=\"top\" width=\"33%\">";
        }
        echo "<input name='access_permission[" . $val["id"] . "]' id='access_permission" . $val["id"] . "' type='checkbox' value='" . $val["id"] . "' class='g_" . $k . "'/> <label for='access_permission" . $val["id"] . "'>" . $val["page_description"] . "</label><br />";
        $i++;
        if ($i == $count || $i == $count * 2) {
            echo "</td>";
        }
    }
    $k++;
    echo "</tr></tbody></table>";
}
echo "            \n        </tr>\n    </tbody></table>\n    <div align=\"right\"><a class=\"boldlink\" href=\"#\" onclick=\"zCheckAll(frmaddrolegroup);return false\">";
echo $LNG["checkall"];
echo "</a> | <a class=\"boldlink\" href=\"#\" onclick=\"zUncheckAll(frmaddrolegroup);return false\">";
echo $LNG["uncheckall"];
echo "</a></div>\n</td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["emailmessages"];
echo "</td><td class=\"fieldarea\">\n<input name=\"systememails\" value=\"1\" type=\"checkbox\"/> ";
echo $LNG["systememails"];
echo "<br />\n<input name=\"accountemails\" value=\"1\" type=\"checkbox\"/>";
echo $LNG["accountemails"];
echo "<br />\n<input name=\"supportemails\" value=\"1\" type=\"checkbox\"/>";
echo $LNG["supportemails"];
echo " </td></tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddrolegroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddrolegroup','addnewadminrole','#frmaddrolegroup','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>