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
$qnew = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='0'"));
$qacc = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='1'"));
$qver = mysqli_num_rows(dquery("select order_id from tbl_order_imei where `user_can_c`='4' AND `verified`='1'"));
$serv = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei where id='" . $id . "'"));
echo "<h1 class=\"page-title\">IMEI Orders</h1>\n        <ul class=\"navigation\">\n            <li><a href=\"main4.php?page=imeiorder\" class=\"btn\">New <span class=\"total blue\">[";
echo $qnew;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=acceptsimei\" class=\"btn\">Accepted <span class=\"total green\">[";
echo $qacc;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=verifysimei\" class=\"btn\">Verification <span class=\"total orange\">[";
echo $qver;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=historyimei\" class=\"btn\">History</a></li>\n        </ul>\n    \n\n\n<div class=\"content\">\n<div class=\"panel\">\n            <h2>Accepted IMEI Orders <span>[";
echo $serv["service_name"];
echo "]</span></h2>\n            <div class=\"grid\"  id=\"userlist\" >\n\n";
$q = dquery("SELECT \n         order_id,(select service_name from tbl_services_imei where id=service_id) as service,imei\n         ,date,(credit-discount) as total,(credit-discount) as cc,\n         (select default_currency from tblUsers where id=user_id) as ids,\n         (select username from tblUsers where id=user_id) as user from tbl_order_imei where user_can_c='1' and service_id='" . $id . "'\n         ORDER BY order_id desc");
echo " <table class=\"grid\">\n <tr><th>#ID</th><th>User</th><th>IMEI</th><th>Price</th><th></th></tr>\n ";
while ($row = mysqli_fetch_assoc($q)) {
    $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $row["ids"] . "'"));
    echo "\n<tr>\n    <td>#";
    echo $row["order_id"];
    echo "</td>\n    <td><span>";
    echo $row["user"];
    echo "</span></td>\n    <td>";
    echo $row["imei"];
    echo " </td>\n    <td><span>";
    echo $row["cc"];
    echo " ";
    echo $sql["code"];
    echo "</span></td>\n    <td><a href=\"main4.php?page=editimei&id=";
    echo $row["order_id"];
    echo "\">Edit</a></td>\n</tr>\n";
}
echo "   \n</table>\n</div>\n</div>\n</div>\n      \n";

?>