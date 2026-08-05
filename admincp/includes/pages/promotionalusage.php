<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"javascript:void(0)\">Promotion Usage</a></li>\n</ul>\n<table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr>\n<th>";
echo $LNG["coupon"];
echo " ";
echo $LNG["code"];
echo "</th>\n<th>";
echo $LNG["discount"];
echo " ";
echo $LNG["type"];
echo "</th>\n<th>";
echo $LNG["amount"];
echo "</th>\n<th>Usage Count</th>\n<th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th></tr></thead>\n<tbody>\n";
$pageid = 499;
checkPagePermission($pageid);
$sql = dquery("select *,(select code from tbl_currencies where id=currency) as codes from tbl_promotion");
while ($row = mysqli_fetch_assoc($sql)) {
    $promo = dec($row["code"], "9486");
    $cnt = mysqli_num_rows(dquery("select * from tbl_invoiceitems\n     where promotion_code='" . $promo . "'"));
    echo "<tr>\n<td>";
    echo $promo;
    echo "</td>\n<td>";
    if ($row["product_type"]) {
        echo $row["product_type"];
    } else {
        if ($row["total"]) {
            echo "Total>=" . $row["total"] . " " . $row["codes"];
        } else {
            echo "Fixed";
        }
    }
    echo "</td>\n<td>";
    echo $row["amount"];
    echo " ";
    echo $row["codes"];
    echo "</td>\n<td>";
    echo $cnt;
    echo "</td>\n<td align=\"right\"><a class=\"\" style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=promotionalusage.order&id=";
    echo $row["id"];
    echo "','";
    echo $LNG["view"] . " " . $LNG["order"];
    echo "');\">";
    echo $LNG["view"] . " " . $LNG["order"];
    echo "</a></td>\n</tr>\n";
}
echo "</tbody></table>";
$fileverioncheck = "6.1.0";

?>