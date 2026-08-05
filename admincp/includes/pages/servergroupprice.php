<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n \n";
$pageid = 408;
checkPagePermission($pageid);
include ROOTDIR . "/includes/imeiservices.fun.php";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    echo "<ul id=\"tabmenu\">  \n\n    <li><a id=\"tab1\"  onclick=\"getContect('#tab1','main2.php?page=imeigroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["imeiserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab2\"  onclick=\"getContect('#tab2','main2.php?page=filegroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["fileserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab3\"  class='tabmenu_active' onclick=\"getContect('#tab3','main2.php?page=servergroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["serverlogserviceprising"];
    echo "</a></li>\n<li><a id=\"tab4\"   onclick=\"getContect('#tab4','main2.php?page=productgroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["pricing"];
    echo "</a></li>      \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_imei_group  where server=1"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
$serverServiceDetails = getIMEIServices($groups, "", "", "", "", "", "", "", "", "", "", "", 999, "", "", "", "", "", "", "", 2);
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>              \n              <th  colspan=\"2\"> \n                <select name=\"groups\" onchange=\"javascript:reloadsubpageiframe('servergroupprice&grpid='+this.value+'&id=";
echo $id;
echo "&loaddefaultpage=servergroupprice.php','";
echo $id;
echo "');\">\n                    ";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group where server=1");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                    <option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n                    ";
}
echo "                 </select>\n                </th>\n                  <th>";
echo $LNG["custom"];
echo " ";
echo $LNG["price"];
echo " ";
echo $LNG["user"];
echo "</th>\n\n                  ";
$sql = dquery("SELECT * from `tbl_currencies` ORDER BY `default` DESC");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                        \n                <th><div align=\"center\">";
    echo $row["code"];
    echo "</div></th> \n";
}
echo "                \n            <th></th>  </tr>\n            </thead>\n            <tbody>  \n                \n";
$serverServiceDetailsKey = array_keys($serverServiceDetails);
$i = 0;
foreach ($serverServiceDetailsKey as $group) {
    foreach ($serverServiceDetails[$group] as $keys) {
        $selected = "";
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM\n       tbl_client_group_price \n      WHERE group_id='" . $id . "' AND service_type='imei' AND service_id='" . $keys["id"] . "'"));
        if ($sql["service_id"]) {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        if ($keys["status"]) {
            $ApiCredit = mysqli_fetch_assoc(dquery("select credits from tbl_apiserversservices\n where gateway='" . $keys["API"] . "' and id='" . $keys["API_ID"] . "' and type_id='" . $keys["API_TYPEID"] . "'"));
            $APiCurrency = mysqli_fetch_assoc(dquery("select value from \n      `tbl_apiservers` WHERE `gateway` LIKE 'fusion10' and setting='currency'"));
            echo "\n<tr>\n\n<input type=\"hidden\" name=\"servicecredit[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["credit_admin"];
            echo "\"/>\n<!--<input name=\"server_check[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["id"];
            echo "\" type=\"hidden\" />-->  \n<td><input name=\"imei_check[";
            echo $keys["id"];
            echo "]\" ";
            echo $selected;
            echo " value=\"";
            echo $keys["id"];
            echo "\" type=\"checkbox\" id=\"g_";
            echo $i;
            echo "\"/><label for=\"g_";
            echo $i;
            echo "\"></label> </td>\n<td align=\"left\" >";
            echo $keys["service_name"];
            echo "    ";
            if ($keys["autoapi"]) {
                echo "<br ><span style='color: red;'>Auto Price From APi " . $keys["API"] . " [" . round($ApiCredit[credits], 2) . " " . $APiCurrency["value"] . "]</span> ";
            } else {
                echo "<br ><span>APi " . $keys["API"] . " [" . round($ApiCredit[credits], 2) . " " . $APiCurrency["value"] . "]</span> ";
            }
            echo "\n</td>\n    <td><a href=\"#\" data-target=\"clientservergroupusers\"\n           data-target-header=\"Discounted Users of ";
            echo $keys["service_name"];
            echo "\"\n           onclick=\"AddnewInpopup(this,'";
            echo $keys["id"] . "_" . $id;
            echo "');\"><i class=\"flaticon-edit\">&nbsp;</i>";
            echo $LNG["list"];
            echo " ";
            echo $LNG["users"];
            echo "</a> </td>\n\n";
            $sql1 = dquery("SELECT * from `tbl_currencies`  ORDER BY `default` DESC");
            while ($row1 = mysqli_fetch_assoc($sql1)) {
                $data = mysqli_fetch_assoc(dquery("SELECT * from tbl_client_group_price \n        where group_id='" . $id . "' AND service_type='imei' AND service_id='" . $keys["id"] . "' and currency_id='" . $row1["id"] . "'"));
                $price = mysqli_fetch_assoc(dquery("SELECT * from tbl_imei_credit\n         where service_id='" . $keys["id"] . "' AND currency_id='" . $row1["id"] . "'"));
                if ($price["credit"]) {
                    $orig = $price["credit"];
                } else {
                    $orig = round($keys["credit"] * $row1["rate"], 2);
                }
                if ($data["discount"] != "") {
                    $credit = round($orig - $data["discount"], 2);
                } else {
                    $credit = "";
                }
                if ($credit != 0) {
                    $classChange = "chcreditvsmall-input";
                } else {
                    $classChange = "vsmall-input";
                }
                echo "        \n<input type=\"hidden\" name=\"";
                echo $row1["code"] . $row1["id"];
                echo "[";
                echo $keys["id"];
                echo "]\" value=\"";
                echo $orig;
                echo "\" />\n<td align=\"center\"><small style=\"display: block;\">";
                echo $orig;
                echo "</small><input style=\"width: 100px;text-align:center;\" name=\"";
                echo $row1["code"];
                echo "[";
                echo $keys["id"];
                echo "]\" align=\"right\"   ";
                if ($keys["autoapi"]) {
                    echo "readonly";
                }
                echo "  class=\"text-input ";
                echo $classChange;
                echo "\" value=\"";
                echo $credit;
                echo "\" type=\"text\" size=\"5\"  /></td>\n";
            }
            echo "<td></td></tr>\n";
        }
    }
    $i++;
}
unset($keys);
echo "\n</tbody></table>\n<br />\n<input type=\"checkbox\" checked=\"checked\" name=\"allprice\" id=\"ue\" /><label for=\"ue\">";
echo $LNG["updatealluser"];
echo "</label><br>\n[<small>Tick this to apply price and service changes to this group owner now</small>]\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" \nid=\"btnedituser1\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','clientgroup.server','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n\n</form></div></div> \n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>