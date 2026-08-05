<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
$find = $_POST["find"];
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$sql = dquery("select order_id,(select service_name from tbl_services_imei where id=service_id) as service,user_id\n     ,imei,(credit-discount) as cc,date,reply from tbl_order_imei where imei  LIKE '" . $find . "%' order by order_id desc limit 20");
echo " <table class=\"grid\">\n <tr><th>#ID</th><th>Service</th><th>IMEI</th><th>Price</th><th></th></tr>\n ";
while ($row = mysqli_fetch_assoc($sql)) {
    $q = mysqli_fetch_assoc(dquery("SELECT id,(select code from tbl_currencies where id=default_currency) as code FROM tblUsers WHERE id='" . $row["user_id"] . "'"));
    echo "\n <tr>\n    <td>#";
    echo $row["order_id"];
    echo "</td>\n    <td> ";
    echo $row["service"];
    echo " </td>\n    <td>";
    echo $row["imei"];
    echo "</td>\n    <td> <span>";
    echo $row["cc"];
    echo " ";
    echo $q["code"];
    echo "</span> </td>    \n    <td> <a href=\"main4.php?page=editimei&id=";
    echo $row["order_id"];
    echo "\" >Edit</a></td> \n </tr>\n";
}
echo "     \n</table> ";

?>