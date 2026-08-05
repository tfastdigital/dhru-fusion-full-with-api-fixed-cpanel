<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

licince\reqaddon("POS");
include_once ROOTDIR . "/includes/products.fun.php";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_product_group\n    where mid=0 order by display_order ASC"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
$limit = 200;
global $admin_template;
if ($grpid && $sort != "") {
    sortOrder("tbl_products", "sort", "id", $sort, $type, " AND group_id='" . $grpid . "'");
}
if ($sid) {
    $proServiceDetails = getProducts("", [$sid]);
} else {
    $proServiceDetails = getProducts($groups, "", "", "", "", "", "", "", "", "", "", 500);
}
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groups", $grpid, "", "", true);
echo "<style>\n  .list{\n    padding:5px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n  }\n</style>\n<script src=\"includes/js/jquery.ui.min.js\"></script>\n<script>\nfunction setVLL(val)\n{\n    location.href='main2.php?page=pos.manage&loaddefault=pos.products.php&sid='+val;\n}\n\$(document).ready(function() {\n    \n    \$('#import').keyup(function() {\n   \n       var vls=\$(this).val();\n       if(vls.length>1){\n           \$.post(\"includes/pages/search.product.php\", { fil: vls},function(data) {\n        \n                \n                 \$('#productsear').show();\n                 \$('#productsear').html(data);\n           });\n       }else{\n             \$('#productsear').hide();\n       }\n       \n     \n    });\n});\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n  \n});\n\n</script>\n<style>\n  .list{\n     background-color: #F9F9F9;\n     width: 350px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n  }\n  #productsear, #client {\n    background: none repeat scroll 0 0 #222222;\n    position: absolute;\n}\n#productsear li, #client li {\n    border-bottom: 1px solid #666666;\n    color: #ffffff !important;\n    list-style: outside none none;\n    padding: 5px;\n    background: transparent;\n}\n#productsear li a, #client li a{\n    color:white\n}\n.selected,.selectedc{background-color: orange;}\n</style>\n    \n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div>\n";
echo $grp;
echo "\n</div>\n<div style=\"text-align:left;\">\n \n    <div  id=\"productsear\"></div>\n</div>\n<div class=\"clear\"></div>\n \n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"pos.manage.php\" />\n<input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='sortable'>\n        <thead>\n          <tr>\n            <th> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\" onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /></th>\n            <th>";
echo $LNG["products"];
echo "</th>\n            <th >";
echo $LNG["selling"];
echo " ";
echo $LNG["price"];
echo "  [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>\n            <th >";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo "  [";
echo $_SESSION["currency_admin"]["code"];
echo "]</th>    \n            <th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>  \n          </tr>\n        </thead>\n";
$nocurrency = mysqli_fetch_assoc(dquery("SELECT count(*) from `tbl_currencies` where `default`='0'"));
$nocur = $nocurrency[0] + 5;
$proServiceDetailsKey = array_keys($proServiceDetails);
$i = 0;
foreach ($proServiceDetailsKey as $group) {
    $grps = explode("_", $group);
    $grps = $grps[0];
    $grps = htmlspecialchars($grps);
    if (mysqli_num_rows(dquery("SELECT id FROM tbl_product_group \n        WHERE group_name='" . $grps . "' and active='1'"))) {
        $selected = "checked";
    } else {
        $selected = "";
    }
    echo "<tr><td colspan=4 align=left><input onclick='SelectChildren(this.id);' class='check-child' type='checkbox' id='g_" . $i . "' " . $selected . " name='grp[" . $grps . "]' value='" . $grps . "'> <strong>" . htmlspecialchars_decode($grps) . "</strong></td><td></td></tr>";
    $e = 0;
    foreach ($proServiceDetails[$group] as $keys) {
        if ($keys["status"]) {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $e++;
        echo "  <tbody class=\"filterarea accordian\" id=\"menu-";
        echo $keys["id"];
        echo "\">  \n<tr>\n<td><input  name=\"imei_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/></td>\n<td><span class=\"searchme\"><a class=\"default_dg_a2\" onclick=\"load_subpage('main2.php?page=pos.editproduct&id=";
        echo $keys["id"];
        echo "','Edit ";
        echo $keys["service_name"];
        echo "');\">";
        echo $keys["service_name"];
        echo "</a> </span></td> \n<td align=\"left\">\n<input type=\"text\"  class=\"text-input vsmall-input\"  name=\"servicecredit[";
        echo $keys["id"];
        echo "]\" \nvalue=\"";
        echo $keys["credit_admin"];
        echo "\"/>\n</td>\n\n<td align=\"left\">\n<input type=\"text\"  class=\"text-input vsmall-input\"  name=\"purchasecost[";
        echo $keys["id"];
        echo "]\" \nvalue=\"";
        echo $keys["purchase_cost"];
        echo "\"/>\n</td>\n\n<td>\n<div align=\"right\"><a class='default_dg_a' onclick=\"load_subpage('main2.php?page=pos.addstock&id=";
        echo $keys["id"];
        echo "','";
        echo $LNG["add"];
        echo " ";
        echo $LNG["stock"];
        echo "');\">";
        echo $LNG["add"];
        echo " ";
        echo $LNG["stock"];
        echo "</a>\n|\n<a class='default_dg_a' onclick=\"load_subpage('main2.php?page=stock&id=";
        echo $keys["id"];
        echo "','View Detail Stock');\">";
        echo $LNG["view"];
        echo " ";
        echo $LNG["stock"];
        echo " ";
        echo $LNG["report"];
        echo "</a>\n</div>\n</td>\n</tr>\n";
    }
    $i++;
}
$addon = licince\reqaddon("E-commerce", true);
echo "</tbody>\n\n</table>\n<br />\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\" \nclass=\"btn\" type=\"button\"  \nonclick=\"SubmitForm ('#btnedituser1','productquick.edit','#frmedituser','#notification','true','#main_loader');\"/></p>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>