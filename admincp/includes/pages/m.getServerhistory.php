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
$sql = dquery("SELECT \n         order_id,(select service_name from tbl_server_log where id=service_id) as service\n         ,date,(tbl_order_server.credit-discount) as total,\n         (select default_currency from tblUsers where id=user_id) as ids,(select username from tblUsers where id=user_id) as user from tbl_order_server \n LEFT OUTER JOIN tbl_server_log ON `tbl_order_server`.service_id = tbl_server_log.id  where service_name LIKE '" . $find . "%' \n  and user_can_c!='0' and  user_can_c<5 ORDER BY order_id DESC   limit 20");
echo " <table class=\"grid\">\n <tr><th>#ID</th><th>Service</th><th>User</th><th>Price</th><th></th></tr>\n ";
while ($row = mysqli_fetch_assoc($sql)) {
    $q = mysqli_fetch_assoc(dquery("SELECT id,(select code from tbl_currencies where id=default_currency) as code FROM tblUsers WHERE id='" . $row["user_id"] . "'"));
    echo "     \n <tr>\n    <td>#";
    echo $row["order_id"];
    echo "</td>\n    <td> ";
    echo $row["service"];
    echo " </td>\n    <td>";
    echo $row["user"];
    echo "</td>\n    <td> <span>";
    echo $row["cc"];
    echo " ";
    echo $q["code"];
    echo "</span> </td>    \n    <td> <a href=\"main4.php?page=editserver&id=";
    echo $row["order_id"];
    echo "\" >Edit</a></td> \n </tr>   \n";
}
echo "      \n</table>";

?>