<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n \n</script>\n \n";
include_once ROOTDIR . "/includes/products.fun.php";
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
    echo "</a></li>\n    <li><a id=\"tab3\"  onclick=\"getContect('#tab3','main2.php?page=servergroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["serverlogserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab4\"  class='tabmenu_active'  onclick=\"getContect('#tab4','main2.php?page=productgroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["pricing"];
    echo "</a></li>  \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_product_group"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
$imeiServiceDetails = getProducts($groups, "", "", "", "", "", "", "", "", "", "", 999);
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>              \n                <th  colspan=\"2\">\n";
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groups", $groups);
echo str_replace("select ", "select \nonchange='javascript:reloadsubpageiframe(\"productgroupprice\",\"&grpid=\"+this.value+\"&id=" . $id . "\")'", $grp);
echo "           \n                </th>\n                      \n";
$sql = dquery("SELECT * from `tbl_currencies` ORDER BY `default` DESC");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                        \n                <th><div align=\"center\">";
    echo $row["code"];
    echo "</div></th> \n";
}
echo "                \n            <th></th>  </tr>\n            </thead>\n            <tbody>  \n                \n";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
$i = 0;
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $selected = "";
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_client_group_price \n      WHERE group_id='" . $id . "' AND service_type='product' AND service_id='" . $keys["id"] . "'"));
        if ($sql["service_id"]) {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        if ($keys["status"]) {
            echo "\n<tr>\n\n<input type=\"hidden\" name=\"servicecredit[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["credit_admin"];
            echo "\"/>\n<!--<input name=\"imei_check[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["id"];
            echo "\" type=\"hidden\" />-->  \n<td><input name=\"imei_check[";
            echo $keys["id"];
            echo "]\"  value=\"";
            echo $keys["id"];
            echo "\"\n type=\"hidden\" id=\"g_";
            echo $i;
            echo "\"/> </td>\n<td align=\"left\" >";
            echo $keys["service_name"];
            echo "</td>\n\n";
            $sql1 = dquery("SELECT * from `tbl_currencies`  ORDER BY `default` DESC");
            while ($row1 = mysqli_fetch_assoc($sql1)) {
                $data = mysqli_fetch_assoc(dquery("SELECT * from tbl_client_group_price \n        where group_id='" . $id . "' AND service_type='product' AND service_id='" . $keys["id"] . "' and currency_id='" . $row1["id"] . "'"));
                $price = mysqli_fetch_assoc(dquery("SELECT * from tbl_product_credit where service_id='" . $keys["id"] . "' AND currency_id='" . $row1["id"] . "'"));
                if ($price["credit"]) {
                    $orig = $price["credit"];
                } else {
                    $orig = round($keys["credit"] * $row1["rate"], $precision);
                }
                if ($data["discount"] != "") {
                    $credit = $orig - $data["discount"];
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
                echo "]\" align=\"right\" class=\"text-input ";
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
echo "\" id=\"btnedituser1\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','clientgroup.product','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n\n</form></div></div> \n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
echo " ";
$fileverioncheck = "6.1.0";

?>