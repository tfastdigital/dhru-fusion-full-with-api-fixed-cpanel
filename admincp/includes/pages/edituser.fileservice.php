<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 214;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
echo " ";
if ($clientDetails["usertype"] == "3") {
    echo "<div id=notification1 class=info>" . $LNG["logineedres"] . "</div>";
    exit;
}
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "edituser.head.php";
    echo "<div id=\"tabcontent\">";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_file_group ORDER BY display_order"));
    $groups = $sql["id"];
}
include_once ROOTDIR . "/includes/fileservices.fun.php";
if ($clientDetails["usertype"] == "3") {
    $fileServiceDetails = getFileServices($groups, "", "", "", "", md5($id), "", true);
} else {
    $fileServiceDetails = getFileServices($groups, "", $id, true, true, "", "", true, true);
}
$allowServices = explode(",", $clientDetails["access"]["alow_fileservices"]);
if ($clientDetails["access"]["fileservice"]) {
    $enable = "checked";
    $display = "table";
} else {
    $disable = "checked";
    $display = "none";
}
echo "<script>\nfunction resetDiscount(){\n    if(confirm('Are you sure want to reset Discount of All services?')){\n        SubmitForm ('#resetdiscount','edituser.resetdiscount','#frmedituser','#notification','true','#main_loader');\n    }\n}\nfunction enable_me(id)\n{\n    document.getElementById(id).style.display='table';\n}\nfunction disable_me(id)\n{\n    document.getElementById(id).style.display='none';\n}\n\n\$(document).ready(function(){\n    \$(\"#enable\")\n      .iButton({\n         labelOn: \"Enable\"\n       , labelOff: \"Disable\"\n       , change: function (\$input){\n          if(\$input.is(\":checked\")){\n             \$('.file-pricing,.file-pricing-table').show();\n          }\n          else{\n             \$('.file-pricing,.file-pricing-table').hide();\n          }\n        }\n      })\n      .trigger(\"change\");\n\n\n    \$('#alls').click(function(){\n        if(\$(this).is(':checked')){\n            //\$('.file-pricing-table').hide();\n            \$('.check-all,input[class*=\"g_\"]').prop({'checked':true});\n        }\n        else{\n            //\$('.file-pricing-table').show();\n            \$('.check-all,input[class*=\"g_\"]').prop({'checked':false});\n        }\n    })\n\n});\n\n\n</script>\n";
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"resetfile\" value=\"1\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'} dontset\"\n name=\"access\"  value=\"1\" ";
echo $enable;
echo " id=\"enable\"/><label for=\"enable\"></label>\n\n<div  class=\"file-pricing\" style=\"text-align: right;\">\n\n <input type=\"checkbox\" class=\"dontset\" name=\"allservices\" value=\"1\" id=\"alls\" />\n<label for=\"alls\"> Assign All Services</label>\n\n</div>\n\n\n<table id=\"main_tbl\"  class=\"file-pricing-table\">\n            <thead>\n              <tr>\n                <th>";
if ($clientDetails["usertype"] != "3") {
    echo "  <input  class=\"check-all\"  name=\"all_file\" onclick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" value=\"ALL\"/><label></label>\n                  ";
}
echo "</th>\n                  <th>\n\n<select  name=\"groups\"\nonchange=\"javascript:reloadcurrent('edituser.fileservice','&grpid='+this.value+'&id=";
echo $id;
echo "&laoddefaultpage=edituser.fileservice.php')\">\n";
$sql = dquery("SELECT id,group_name FROM tbl_file_group ORDER BY display_order");
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
echo "</select>\n                  </th>\n                 <th><div align=\"center\">";
echo $LNG["flage"];
echo "</div></th>\n                <th>";
echo $LNG["servicecredit"];
echo " <small>[";
echo $clientDetails["currency"]["code"];
echo "]</small> </th>\n                <th><div align=\"right\">";
echo $LNG["usercredit"];
echo "</div></th>\n                <th></th>\n              </tr>\n            </thead>\n            <tbody>\n      <input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n\n";
$fileServiceDetailsKey = array_keys($fileServiceDetails);
$i = 0;
foreach ($fileServiceDetailsKey as $group) {
    foreach ($fileServiceDetails[$group] as $keys) {
        if (in_array($keys["id"], $allowServices) || $clientDetails["access"]["alow_fileservices"] == "ALL") {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        $happyhours = getFilehappyhours($keys["id"]);
        if ($keys["credit"] - $keys["discount_admin"] != $keys["credit"]) {
            $classChange = "chcreditvsmall-input";
            $customdatachange = "changedatarow";
        } else {
            $classChange = "vsmall-input";
            $customdatachange = "";
        }
        echo "<tr class=\"";
        echo $customdatachange;
        echo "\">\n<td><input name=\"file_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/><label></label></td>\n<td style=\"cursor: pointer;\" onclick=\"javascript:load_fromsubpage('editfileservice&id=";
        echo $keys["id"];
        echo "','";
        echo $keys["service_name"];
        echo "')\"> ";
        echo $keys["service_name"];
        echo " </td>\n<td align=\"center\"  width=\"300px\">";
        if ($happyhours["promotiondis"] != 0) {
            echo "<a onclick=\"getContect('','main2.php?sid=";
            echo $keys["id"];
            echo "&page=editfileservice.happyhours','";
            echo $keys["id"];
            echo "','','#tabcontent',true,'#main_loader');\" id=\"tab13\" ><img src=\"images/red.gif\" title=\"Under Happy Hours\" /></a>";
        }
        echo "</td>\n<td>";
        echo $keys["credit"];
        echo "<input type=\"hidden\" name=\"servicecredit[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["credit"];
        echo "\"/></td>\n<td align=\"right\"><input name=\"user_credit[";
        echo $keys["id"];
        echo "]\" style=\"text-align: right;\" class=\"text-input ";
        echo $classChange;
        echo "\" value=\"";
        echo $keys["credit"] - $keys["discount_admin"];
        echo "\" type=\"text\"  onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/></td>\n<td></td>\n</tr>\n";
    }
    $i++;
}
unset($keys);
echo "\n</tbody></table>\n<p  class=\"fixedbtn\">\n\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','edituser.fileservice','#frmedituser','#notification','true','#main_loader');\"/>\n<input type=\"button\" class=\"btn btn-default floatright\" id=\"resetdiscount\" name=\"resetdiscount\" value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "\"\nonclick=\"javascript: resetDiscount();\"/>\n\n</p>\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>