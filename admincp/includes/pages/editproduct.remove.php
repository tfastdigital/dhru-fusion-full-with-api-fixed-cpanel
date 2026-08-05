<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "  \n";
$pageid = 315;
checkPagePermission($pageid);
if ($delete) {
    dquery("DELETE FROM tbl_products WHERE id='" . $id . "'");
    dquery("DELETE FROM tbl_product_credit WHERE service_id='" . $id . "'");
    if ($order) {
        dquery("DELETE FROM tbl_order_product WHERE service_id='" . $id . "'");
    }
    dquery("DELETE FROM tbl_discount_product WHERE service_id='" . $id . "'");
    echo "    \n    <div id=\"notification1\" class=\"successbox\">";
    echo $LNG["remove"] . " " . $LNG["successfully"];
    echo "</div>\n    ";
}
$pending = mysqli_num_rows(dquery("select * from tbl_order_product where (user_can_c='0' or user_can_c='1' or user_can_c='5') and service_id='" . $id . "'"));
echo "  \n ";
if ($pending) {
    echo "<div id=\"notification1\" class=\"alert\">";
    echo $LNG["servicependingorder"];
    echo "</div>\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<input type=\"hidden\" value=\"editproduct.remove.php\" name=\"defaultloadpage\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["remove"];
echo " ";
echo $LNG["orders"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"order\" value=\"1\" checked=\"checked\"/></td>\n</tr>\n\n\n</tbody>\n</table> \n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["remove"];
echo "\" id=\"btnoverview\" name=\"delete\" class=\"btn\" type=\"submit\"/> </p>\n</form>\n</div></div>";
$fileverioncheck = "6.1.0";

?>