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
$sql = "SELECT \ntbl_return_request.id as rid,\ntbl_return_request.date as date,uid,\nreason,action,\n(SELECT `username` FROM `tblUsers` WHERE tblUsers.id=tbl_order_product.user_id) as username,\n(SELECT `service_name` FROM `tbl_products` WHERE tbl_products.id=tbl_order_product.service_id  limit 1) as service,\nCONCAT(IF(tbl_return_request.status=0,'Requested', IF(tbl_return_request.status=1,'Authorize',IF(tbl_return_request.status=2,'Decline',IF(tbl_return_request.status=3,'Completed','Canceled')))) ) as status,\n\nCONCAT('<a class=\\'default_dg_a2 editdata\\' \nonclick=\"javascript: load_subpage(\\'main2.php?page=editreturn.request&id=',uid,'\\',\\'" . $LNG["return"] . " " . $LNG["request"] . "\\');\">" . $LNG["edit"] . "</a>') as actions\n  \nFROM `tbl_return_request` \nLEFT OUTER JOIN tbl_order_product ON `tbl_return_request`.oid = tbl_order_product.order_id \nLEFT OUTER JOIN tbl_products ON tbl_order_product.service_id=tbl_products.id\nWHERE 1=1 and user_id='" . $id . "'";
$serviceresult = dquery($sql);
echo " \n  <table cellspacing=\"0\" cellpadding=\"4\" id=\"main_tbl\">\n    <thead>    \n        <tr><th align=\"left\">ReturnId</th><th>Date</th><th align=\"left\">Item</th><th>Status</th><th style=\"text-align: right;\">Action</th></tr>\n    </thead>\n    <tbody>\n        ";
while ($servicerow = mysqli_fetch_assoc($serviceresult)) {
    echo "            <tr><td>";
    echo $servicerow["rid"];
    echo "</td><td>";
    echo $servicerow["date"];
    echo "</td><td>";
    echo $servicerow["service"];
    echo "</td><td>";
    echo $servicerow["status"];
    echo "</td><td align=\"right\">";
    echo $servicerow["actions"];
    echo "</td></tr>\n        ";
}
echo " \n    </tbody>\n</table>\n";
$fileverioncheck = "6.1.0";

?>