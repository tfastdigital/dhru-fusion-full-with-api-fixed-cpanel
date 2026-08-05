<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 449;
checkPagePermission($pageid);
if ($delete && $select) {
    foreach ($select as $s) {
        dquery("delete from tbl_voucher where id='" . $s . "'");
    }
}
$sql = dquery("SELECT\ntbl_voucher.id,    \ntbl_voucher.used,\nCONCAT((SELECT code FROM tbl_currencies WHERE tbl_currencies.id=tbl_voucher.currency),' ',tbl_voucher.amount) AS amount,\nCONCAT(tbl_voucher.vali_start,' - ',tbl_voucher.vali_end) AS vali_end,\ntbl_voucher.code\nFROM tbl_voucher WHERE uid='' and reseller=0 order by id desc ");
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form action=\"\" name=\"replied\" id=\"replied\" method=\"post\">\n<input type='hidden' name='laoddefaultpage' value='pendingcodelist.php' />\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>                \n                <th width=\"10px\"><input type='checkbox' name='checkall' onclick=\"CheckAll();\" class=\"check-all\" id=\"checkall\"/><label for=\"checkall\"></label></th>            \n                <th>";
echo $LNG["code"];
echo " </th>\n                <th>";
echo $LNG["credit"];
echo " </th>\n                <th>";
echo $LNG["use"] . " " . $LNG["left"];
echo " </th>\n                <th>";
echo $LNG["validity"];
echo " </th>              \n              </tr>\n            </thead> \n            <tbody> \n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<td><input type='checkbox' name=\"select[]\" id=\"select_";
    echo $row["id"];
    echo "\" value=\"";
    echo $row["id"];
    echo "\" /> <label for=\"select_";
    echo $row["id"];
    echo "\"></label></td> \n<td>";
    echo dec($row["code"], "9486");
    echo "</td>\n<td>";
    echo $row["amount"];
    echo "</td>\n<td>";
    echo $row["used"];
    echo "</td>\n<td>";
    echo $row["vali_end"];
    echo "</td>\n</tr>\n";
}
echo "</tbody></table>\n <img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin:0px 0 0 5px; border:0px;\">\n \n <input type='submit' onclick=\"return confirm('Are you sure want to Remove code ?');\" class=\"button_remove\" name='delete' value=\"";
echo $LNG["delete"];
echo "\" /> \n</form>\n</div>\n</div>\n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\n</script>";
$fileverioncheck = "6.1.0";

?>