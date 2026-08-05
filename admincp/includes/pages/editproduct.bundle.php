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
include_once ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n\n       <a class=\"btn\" onclick=\"load_subpage('main2.php?page=editproduct.bundlelist&pid=";
echo $id;
echo "','";
echo $LNG["add"];
echo " ";
echo $LNG["products"];
echo "');\"> + ";
echo $LNG["add"];
echo " ";
echo $LNG["items"];
echo " ";
echo $LNG["in"];
echo " ";
echo $LNG["bundle"];
echo "</a>\n\n<br /><br />\n\n<div>\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th >";
echo $LNG["bundle"];
echo " ";
echo $LNG["items"];
echo "</th>\n                <th >";
echo $LNG["price"];
echo " </th>\n                <th ><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n              </tr>\n            </thead>\n            <tbody> \n";
if ($remove) {
    $sql = mysqli_fetch_assoc(dquery("select bundle_list from tbl_products where id='" . $id . "'"));
    $prod = explode(",", $sql["bundle_list"]);
    foreach ($prod as $k => $v) {
        if ($v == $remove) {
            unset($prod[$k]);
        }
    }
    $prod = implode(",", $prod);
    dquery("update tbl_products set bundle_list='" . $prod . "' where id='" . $id . "'");
}
$flag = false;
$sql = mysqli_fetch_assoc(dquery("select bundle_list from tbl_products where id='" . $id . "'"));
$bun = explode(",", $sql["bundle_list"]);
foreach ($bun as $b) {
    if ($b) {
        $flag = true;
        $row = mysqli_fetch_assoc(dquery("select service_name,credit from tbl_products where id='" . $b . "'"));
        $total = $total + $row["credit"];
        echo "<tr>\n<td>";
        echo $row["service_name"];
        echo "</td>\n<td>";
        echo $row["credit"];
        echo " ";
        echo $config["base_currency"];
        echo "</td>\n<td align=\"right\"><a class=\"deletedata\" href=\"javascript: reloadcurrent('editproduct','";
        echo $id;
        echo "&remove=";
        echo $b;
        echo "&defaultloadpage=editproduct.bundle.php')\">";
        echo $LNG["remove"];
        echo "</a></td>\n</tr>\n";
    }
}
if ($flag) {
    echo " \n<tr style=\"border-bottom: 0px !important;\">\n<td>&nbsp;</td>\n<td style=\"font-weight:  bold;\">=";
    echo $total;
    echo " ";
    echo $config["base_currency"];
    echo " <br /> <span style=\"color: green;font-size:20px\">";
    echo $productDetails["credit_admin"];
    echo " ";
    echo $config["base_currency"];
    echo "  Offer ";
    echo $LNG["price"];
    echo " </span> (<small>";
    echo $LNG["savings"];
    echo " : ";
    echo $total - $productDetails["credit_admin"];
    echo " ";
    echo $config["base_currency"];
    echo "</small> )\n \n</td>\n<td>&nbsp;</td>\n</tr>     \n";
}
echo "      \n</tbody>\n</table>   \n</div>         \n</div></div>";
$fileverioncheck = "6.1.0";

?>