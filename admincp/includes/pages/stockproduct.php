<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 488;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/products.fun.php";
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
echo " \n<script src=\"includes/js/jqxuery.ui.min.js\"></script>\n<script>\nfunction setVLL(val)\n{\n    location.href='main2.php?page=stockproduct&loaddefault=stockproduct.php&sid='+val;\n}\n\$(document).ready(function() {\n    \n    \$('#import').keyup(function() {\n   \n       var vls=\$(this).val();\n       if(vls.length>1){\n           \$.post(\"includes/pages/search.product.php\", { fil: vls},function(data) {\n        \n                \n                 \$('#productsear').show();\n                 \$('#productsear').html(data);\n           });\n       }else{\n             \$('#productsear').hide();\n       }\n       \n     \n    });\n});\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n  \n});\n\n</script>\n<style>\n  .list{\n     background-color: #F9F9F9;\n     width: 350px;\n  }\n  .list:hover{\n     background-color: #EEEEEE;\n  }\n  #productsear, #client {\n    background: none repeat scroll 0 0 #222222;\n    position: absolute;\n}\n#productsear li, #client li {\n    border-bottom: 1px solid #666666;\n    color: #ffffff !important;\n    list-style: outside none none;\n    padding: 5px;\n    background: transparent;\n}\n#productsear li a, #client li a{\n    color:white\n}\n.selected,.selectedc{background-color: orange;}\n</style>\n<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=stockreport&defaultloadpage=stockproduct.php&wid='+this.value\">\n    <option value=\"\">Select Warehouse</option>\n";
$s = dquery("select id,name from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    if ($wid == 0) {
        $wid = $r["id"];
    }
    echo "<option ";
    if ($wid != "" && $wid == $r["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["name"];
    echo "</option>\n";
}
echo "</select>\n<div style=\"float:left;\">\n <input type=\"text\"  class=\"txt medium\" name=\"import\" id=\"import\"\n value=\"Search Product\"\n onfocus=\"if(this.value=='Search Product')value='';\"\n onblur=\"if(this.value=='')this.value='Search Product';\"  />\n    <div  id=\"productsear\"></div>\n</div>\n<div style=\"float:right\">\n    <form method=\"post\" action=\"includes/download.php\">\n        <input type=\"hidden\" name=\"wars\" value=\"";
echo $wid;
echo "\" />\n        <input type=\"submit\" name=\"exportcsv\" value=\"Export\" />\n    </form>\n</div>\n<div class=\"clear\"></div>\n <br />\n<table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr><th>";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th><th><div align=\"right\">\n";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</div></th><th><div align=\"right\">\n";
echo $LNG["action"];
echo "</div></th></tr></thead>\n<tbody>\n";
$total = 0;
if ($sid) {
    $iresult = dquery("SELECT id,service_name,stock,stock_allow from tbl_products\n     WHERE id='" . $sid . "'");
    while ($row = mysqli_fetch_assoc($iresult)) {
        if (!$row["stock"]) {
            $row["stock"] = 0;
        }
        $stock = getWarehouseStock($wid, $row["id"]);
        echo "<tr><td><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockproduct.detail&id=";
        echo $row["id"];
        echo "&wid=";
        echo $wid;
        echo "','View Detail Stock');\">\n";
        echo $row["service_name"] . "</a></td><td align=right>" . $stock . "</td>";
        echo " <td align=\"right\"><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockproduct.detail&id=";
        echo $row["id"];
        echo "','View Detail Stock');\">";
        echo $LNG["view"] . " " . $LNG["sold"] . " " . $LNG["stock"];
        echo "</td>\n        </tr>";
    }
} else {
    $gresult = dquery("select group_name,id from tbl_product_group");
    while ($group = mysqli_fetch_assoc($gresult)) {
        $iresult = dquery("SELECT id,service_name,stock,stock_allow from tbl_products\n     WHERE group_id='" . $group["id"] . "'");
        if (mysqli_num_rows($iresult)) {
            echo "<tr><td colspan=2><strong>" . $group["group_name"] . "</strong></td><td></td></tr>";
            while ($row = mysqli_fetch_assoc($iresult)) {
            }
        }
        if (!$row["stock"]) {
            $row["stock"] = 0;
        }
        $stock = getWarehouseStock($wid, $row["id"]);
        echo "<tr><td><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockproduct.detail&id=";
        echo $row["id"];
        echo "&wid=";
        echo $wid;
        echo "','View Detail Stock');\">\n";
        echo $row["service_name"] . "</a></td><td align=right>" . $stock . "</td>";
        echo " <td align=\"right\"><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockproduct.detail&id=";
        echo $row["id"];
        echo "','View Detail Stock');\">";
        echo $LNG["view"] . " " . $LNG["sold"] . " " . $LNG["stock"];
        echo "</td>\n        </tr>";
    }
}
echo "</tbody></table>";
$fileverioncheck = "6.1.0";

?>