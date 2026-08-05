<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 359;
checkPagePermission($pageid);
require_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/products.fun.php";
$productDetails = getProducts("", "", "", true, true);
if ($search != "") {
    $porder = dquery("SELECT \n*,(select username from tblUsers where id=user_id) as user,\n(select email from tblUsers where id=user_id) as email\n FROM `tbl_order_product` where ( user_can_c='1') AND service_id='" . $search . "'\n  GROUP BY invoiceid");
    $_SESSION["once_accepted"] = true;
} else {
    $porder = dquery("SELECT \n*,(select username from tblUsers where id=user_id) as user,\n(select email from tblUsers where id=user_id) as email\n FROM `tbl_order_product` where ( user_can_c='1') GROUP BY invoiceid");
    $_SESSION["once_accepted"] = true;
}
echo "  \n<div id=\"content\"> \n<div id=\"content_padded\">\n<h2 style=\"float: left;\">    \n    <span class=\"groupstabesheadertext\">New Orders</span>\n  </h2> \n  \n<div id=\"notification\"></div>\n<script>\nfunction showhide(val){\n    var id = '#detail_'+ val;\n    \$(id).toggle();\n}\n</script>\n<form method=\"post\">\n \n<div style=\"float: right;\">  \n<select name='search' >\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n     \t";
$sql = dquery("select id,service_name from tbl_products");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "     \t\t<option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["service_name"];
    echo "</option>\n     \t\t";
}
echo "</select>\n \n<input type='submit' name='find' value='";
echo $LNG["search"];
echo "'  />\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"productorder.replied.php\" />\n</div> \n<div class=\"clear\"></div>\n \n <br />\n \n<table id=\"main_tbl\" >\n<thead>\n<th></th>\n<th>";
echo $LNG["order"];
echo "</th>\n<th>";
echo $LNG["total"];
echo " ";
echo $LNG["amount"];
echo "</th>\n<th>";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["user"];
echo "</th>\n<th align=\"right\">";
echo $LNG["action"];
echo "</th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($porder)) {
    $prod_q = "SELECT order_id,gift,buyadvance,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (SELECT credit from tbl_invoices where id=" . $row["invoiceid"] . ") as total ,\n        (SELECT subtotal from tbl_invoices where id=" . $row["invoiceid"] . ") as subtotal       \n         from tbl_order_product where invoiceid='" . $row["invoiceid"] . "' and user_can_c='1' order by order_id";
    $invoice = mysqli_fetch_assoc(dquery($prod_q));
    $prod = dquery($prod_q);
    $cnto = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $row["invoiceid"] . "'\nand (select paymentmethod from tbl_invoices where id='" . $row["invoiceid"] . "')='cod' "));
    $cnts = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $row["invoiceid"] . "' \n    and user_can_c<5 and (select paymentmethod from tbl_invoices where id='" . $row["invoiceid"] . "')='cod'"));
    $cod = false;
    if ($cnto == $cnts && $cnto != 0) {
        $cod = true;
    }
    echo " <tr  id=\"nota\">\n        <td><input type=\"checkbox\" name=\"future\" /></td>\n        <td onclick=\"showhide(";
    echo $row["invoiceid"];
    echo ");\" style=\"cursor: pointer;\" >";
    echo $LNG["order"];
    echo " : #";
    echo $row["invoiceid"];
    echo " ";
    echo $row["buyadvance"] ? "[" . $LNG["preorder"] . "]" : "";
    echo "  ";
    echo $cod ? "[COD]" : "";
    echo "</td>\n        <td onclick=\"showhide(";
    echo $row["invoiceid"];
    echo ");\" style=\"cursor: pointer;\" >";
    echo $invoice["subtotal"];
    echo " ";
    echo $invoice["code"];
    echo "</td>\n        <td onclick=\"showhide(";
    echo $row["invoiceid"];
    echo ");\" style=\"cursor: pointer;\" >";
    echo $row["date"];
    echo "</td>\n        <td onclick=\"showhide(";
    echo $row["invoiceid"];
    echo ");\" style=\"cursor: pointer;\" >";
    echo $row["user"];
    echo " [";
    echo $row["email"];
    echo "]</td>\n        <td><a class='default_dg_a2 editdata'  href=\"javascript:load_fromsubpage('productorder.edit&id=";
    echo $row["invoiceid"];
    echo "','Edit Product Order #";
    echo $row["invoiceid"];
    echo "')\"> ";
    echo $LNG["edit"];
    echo " </a></td>\n    </tr>\n    <tr id=\"detail_";
    echo $row["invoiceid"];
    echo "\" style=\"display: none;\" >\n    <td colspan=\"5\" >\n        <table>\n            <thead>\n            <tr>\n                <th>Item</th>\n                <th class=\"rightalign\">Qty</th>\n                <th>Shipping</th>\n            </tr>\n            </thead>\n\n            ";
    $cnt = mysqli_num_rows($prod);
    $flag = 0;
    while ($det = mysqli_fetch_assoc($prod)) {
        echo "                <tr>\n                    <td>\n                        ";
        echo $det["service"];
        echo " ";
        if ($det["bun"]) {
            echo "  [" . $LNG["bundle"] . "]";
        }
        echo " ";
        if ($det["gift"]) {
            echo "  [" . $LNG["gift"] . "]";
        }
        echo "                    </td>\n                    <td class=\"rightalign\" >1</td>\n                    ";
        if ($flag == 0) {
            echo "                        <td rowspan=\"";
            echo $cnt;
            echo "\">\n\n                            ";
            echo $det["sh_firstname"];
            echo "                            ";
            echo $det["sh_laststname"];
            echo " <br />\n                            ";
            echo $det["sh_address1"];
            echo " <br />\n                            ";
            echo $det["sh_address2"];
            echo " <br />\n                            ";
            echo $det["sh_city"];
            echo " ";
            echo $det["sh_zip"];
            echo " <br />\n                            ";
            echo $det["sh_state"];
            echo " <br />\n                        </td>\n\n                        ";
        }
        echo "                </tr>\n                ";
        $flag = 1;
    }
    echo "        </table>\n    </td>\n    <td></td>\n    </tr>\n";
}
echo "</tbody>\n</table>\n</form>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>