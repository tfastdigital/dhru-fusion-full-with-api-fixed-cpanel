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
$q = mysqli_fetch_assoc(dquery("SELECT id,(select code from tbl_currencies where id=default_currency) as code FROM tblUsers WHERE id='" . $find . "'"));
$sql = dquery("select id,date,subtotal,paymentmethod from tbl_invoices where userid='" . $find . "' and status='Unpaid' order by id desc limit 20");
echo "<table class=\"grid\"><tr><th>#ID</th><th>Date</th><th>Price</th><th>Payment Method</th></tr>\n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n    <td>#";
    echo $row["id"];
    echo "</td>\n    <td><span style=\"font-size: 12px;\">";
    echo $row["date"];
    echo "</span></td>\n    <td>";
    echo $row["subtotal"];
    echo " ";
    echo $q["code"];
    echo "</td>\n    <td><span style=\"font-size: 12px;\">";
    echo $row["paymentmethod"];
    echo "</span></td>\n</tr>             \n";
}
echo "      \n</table>";

?>