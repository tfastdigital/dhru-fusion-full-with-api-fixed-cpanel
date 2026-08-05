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
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$find = $_POST["find"];
$sql = dquery("select order_id,(select service_name from tbl_services_imei where id=service_id) as service\n     ,imei,(credit-discount) as cc,user_id,date,reply from tbl_order_imei where service_id='" . $find . "' and user_can_c='0' order by order_id desc limit 20");
echo " <table class=\"grid\">\n <tr><th>#ID</th><th>User</th><th>IMEI</th><th>Price</th></tr>\n ";
while ($row = mysqli_fetch_assoc($sql)) {
    $q = mysqli_fetch_assoc(dquery("SELECT id,username,(select code from tbl_currencies where id=default_currency) as code FROM tblUsers WHERE id='" . $row["user_id"] . "'"));
    echo "\n <tr onclick=\"setSel(";
    echo $row["order_id"];
    echo ");\">\n    <td><input type=\"checkbox\" name=\"ids\" id=\"";
    echo $row["order_id"];
    echo "\" value=\"";
    echo $row["order_id"];
    echo "\" />  #";
    echo $row["order_id"];
    echo " </td>\n    <td><span style=\"font-size: 12px;\">";
    echo $q["username"];
    echo "</span></td>\n    <td>";
    echo $row["imei"];
    echo "</td>\n    <td><span style=\"font-size: 12px;\">";
    echo $row["cc"];
    echo " ";
    echo $q["code"];
    echo "</span></td>    \n</tr>\n";
}
echo "      \n</table>";

?>