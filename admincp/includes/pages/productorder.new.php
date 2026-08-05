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
if (isset($_POST["sendmail"])) {
    require "quickacceptedproductorder.php";
    exit;
}
if ($accept && is_array($inv)) {
    $order = array_keys($inv);
    $order = implode(",", $order);
    dquery("update `tbl_order_product` set `user_can_c`='1' where `invoiceid` IN (" . $order . ") AND `user_can_c`='0'");
    $success = $LNG["orderaccepted"];
    $Inv = mysqli_fetch_assoc(dquery("select userid from tbl_invoices\nwhere id='" . $order . "'"));
    require_once ROOTDIR . "/includes/mail.fun.php";
    $mailarr["orderid"] = $order;
    sendMail(92, $Inv["userid"], "", $mailarr, true);
    require "quickacceptedproductorder.php";
    exit;
}
$porder = dquery("SELECT *,(select username from tblUsers where id=user_id) as user,\n(select email from tblUsers where id=user_id) as email FROM `tbl_order_product`\n where user_can_c='0' GROUP BY invoiceid ORDER BY time desc");
echo "\n<div id=\"content\"> \n<div id=\"content_padded\">\n<h2>    \n    <span class=\"groupstabesheadertext\">New Orders</span>\n  </h2><br />\n<div id=\"notification\"></div>\n<script>\nfunction showhide(val){\n    var id = '#detail_'+ val;\n    \$(id).toggle();\n}\nfunction checkalls(){\n    var array = document.getElementsByTagName(\"input\");\n   for(var ii = 0; ii < array.length; ii++)\n    {\n       if(array[ii].type == \"checkbox\")\n       {  \n            if( array[ii].checked){\n                 array[ii].checked = false;\n            }else{\n                 array[ii].checked = true;\n            }\n       }\n    }\n}\n</script>\n<form method=\"post\" name=\"myfrom\">\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"productorder.new.php\" />\n<table id=\"main_tbl\" >\n<thead>\n<th><input type=\"checkbox\" name=\"checkall\"   onclick=\"checkalls();\" /></th>\n<th>";
echo $LNG["order"];
echo "</th>\n<th>";
echo $LNG["total"];
echo " ";
echo $LNG["amount"];
echo "</th>\n<th>";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["user"];
echo "</th>\n<th align=\"right\"><span>";
echo $LNG["view"];
echo "</span></th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($porder)) {
    $prod_q = "SELECT *,\n(select `value` from tbl_paymentgateways where setting='name' and gateway=gatway limit 1) as gateways\n        ,(SELECT bundle FROM tbl_products WHERE id=service_id) as bun,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (SELECT credit from tbl_invoices where id=" . $row["invoiceid"] . ") as total,\n        (SELECT subtotal from tbl_invoices where id=" . $row["invoiceid"] . ") as subtotal\n        from tbl_order_product where invoiceid='" . $row["invoiceid"] . "' \n        and user_can_c=0 order by order_id";
    $invoice = mysqli_fetch_assoc(dquery($prod_q));
    $prod = dquery($prod_q);
    $cnto = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $row["invoiceid"] . "'\nand (select paymentmethod from tbl_invoices where id='" . $row["invoiceid"] . "')='cod' "));
    $cnts = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $row["invoiceid"] . "' \n    and user_can_c<5 and (select paymentmethod from tbl_invoices where id='" . $row["invoiceid"] . "')='cod'"));
    $cod = false;
    if ($cnto == $cnts && $cnto != 0) {
        $cod = true;
    }
    echo "  <tr>\n        <td align=\"left\"><input type=\"checkbox\" id=\"inv\" name=\"inv[";
    echo $row["invoiceid"];
    echo "]\" /></td>\n        <td onclick=\"showhide(";
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
    echo "]</td>\n        <td><span>\n        <a onclick=\"load_subpage('main2.php?page=edituser.editinvoice&id=";
    echo $row["invoiceid"];
    echo "','";
    echo $LNG["view"];
    echo " ";
    echo $LNG["invoice"];
    echo "')\">";
    echo $LNG["view"];
    echo " ";
    echo $LNG["invoice"];
    echo "</a></span></td>\n    </tr>\n    <tr style=\"display: none;\" id=\"detail_";
    echo $row["invoiceid"];
    echo "\" >\n    <td colspan=\"5\">\n        <table>\n            <thead>\n            <tr>\n                <th>Item</th>\n                <th class=\"rightalign\">Qty</th>\n                <th>Shipping</th>\n            </tr>\n            </thead>\n\n    ";
    $cnt = mysqli_num_rows($prod);
    $flag = 0;
    while ($det = mysqli_fetch_assoc($prod)) {
        echo "    <tr>\n        <td>\n            ";
        echo $det["service"];
        echo " ";
        if ($det["bun"]) {
            echo "  [" . $LNG["bundle"] . "]";
        }
        echo " ";
        if ($det["gift"]) {
            echo "  [" . $LNG["gift"] . "]";
        }
        echo "        </td>\n        <td class=\"rightalign\" >1</td>\n        ";
        if ($flag == 0) {
            echo "            <td rowspan=\"";
            echo $cnt;
            echo "\">\n\n                ";
            echo $det["sh_firstname"];
            echo "                ";
            echo $det["sh_laststname"];
            echo " <br />\n                ";
            echo $det["sh_address1"];
            echo " <br />\n                ";
            echo $det["sh_address2"];
            echo " <br />\n                ";
            echo $det["sh_city"];
            echo " ";
            echo $det["sh_zip"];
            echo " <br />\n                ";
            echo $det["sh_state"];
            echo " <br />\n            </td>\n\n            ";
        }
        echo "    </tr>\n    ";
        $flag = 1;
    }
    echo "        </table>\n    </td>\n    <td></td>\n    </tr>\n\n";
}
echo "</tbody>\n</table>\n<input type=\"hidden\" value=\"productorder.new.php\" name=\"loaddefaultpage\"/>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"accept\" value=\"Accept Selected\" /></p>\n</form>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>