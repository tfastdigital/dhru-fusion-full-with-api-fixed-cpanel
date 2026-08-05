<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once ROOTDIR . "/includes/products.fun.php";
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
echo "<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=pos.reorder&wid='+this.value\">\n";
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
echo "</select>\n<br /><br />\n<table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr><th>";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th>\n<th><div align=\"right\">";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</div></th>\n<th><div align=\"right\">";
echo $LNG["reorder"];
echo "</div></th>\n</tr></thead>\n<tbody>\n";
$total = 0;
$gresult = dquery("select group_name,id from tbl_product_group");
while ($group = mysqli_fetch_assoc($gresult)) {
    $iresult = dquery("SELECT id,service_name,stock,stock_allow,reorder_level\n     from tbl_products\n     WHERE group_id='" . $group["id"] . "'");
    if (mysqli_num_rows($iresult)) {
        echo "<tr><td colspan=2><strong>" . $group["group_name"] . "</strong></td><td></td></tr>";
        while ($row = mysqli_fetch_assoc($iresult)) {
        }
    }
    if (!$row["stock"]) {
        $row["stock"] = 0;
    }
    $stock = getWarehouseStock($wid, $row["id"]);
    if ($stock < $row["reorder_level"]) {
        echo "<tr><td><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockproduct.detail&id=";
        echo $row["id"];
        echo "&wid=";
        echo $wid;
        echo "','View Detail Stock');\">\n";
        echo $row["service_name"] . "</a></td><td align=right>" . $stock . "</td>";
        echo "<td align=right>" . $row["reorder_level"] . "</td>";
        echo "</tr>";
    }
}
echo "</tbody></table>";
$fileverioncheck = "6.1.0";

?>