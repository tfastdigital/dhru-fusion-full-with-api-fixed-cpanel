<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 511;
checkPagePermission($pageid);
require_once ROOTDIR . "/comm.php";
$porder = dquery("select id,service_name,credit from tbl_products where active='1' and draw='1'");
echo "<style>\n#nota td:active{\n    background-color: #FFFFFF !important;\n}\n</style>\n<div id=\"content\"> \n<div id=\"content_padded\">\n\n<h2>    \n    <span class=\"groupstabesheadertext\">Lucky draw order</span>\n  </h2><br />\n  \n<div id=\"notification\"></div>\n\n<form method=\"post\">\n\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"productdraw.php\" />\n\n\n<table id=\"main_tbl\" >\n<thead>\n\n<th>";
echo $LNG["id"];
echo "</th>\n<th>";
echo $LNG["service"];
echo "</th>\n<th>";
echo $LNG["price"];
echo "</th>\n<th>";
echo $LNG["orders"];
echo "</th>\n<th>";
echo $LNG["total"];
echo " Recurring</th>\n<th align=\"right\">";
echo $LNG["action"];
echo "</th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($porder)) {
    $cnt = mysqli_num_rows(dquery("select order_id from tbl_order_product where user_can_c='8' \n  and service_id='" . $row["id"] . "'"));
    echo "    <tr  id=\"nota\">\n        <td>";
    echo $row["id"];
    echo "</td>\n        <td>";
    echo $row["service_name"];
    echo "</td>\n        <td>";
    echo $row["credit"];
    echo " ";
    echo $_SESSION["system_default_currency"]["code"];
    echo "</td>\n        <td>";
    echo $cnt;
    echo "</td>\n        <td>";
    echo $cnt * $row["credit"];
    echo "  ";
    echo $_SESSION["system_default_currency"]["code"];
    echo "</td>\n        <td align=\"right\">\n<a class=\"\" href=\"javascript: load_subpage('main2.php?page=viewdraworder&id=";
    echo $row["id"];
    echo "','Draw Order');\">View Order</a>\n        </td>\n    </tr>\n\n";
}
echo "</tbody>\n</table>\n</form>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>