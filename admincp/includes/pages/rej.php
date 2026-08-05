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
$year = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $year);
if (!$year) {
    $year = 2015;
}
echo "<select name=\"year\" onchange=\"javascript: location.href='main2.php?page=rej&year='+this.value;\">\n<option ";
if ($year == 2015) {
    echo "selected";
}
echo " >2015</option>\n<option ";
if ($year == 2014) {
    echo "selected";
}
echo ">2014</option>\n<option ";
if ($year == 2013) {
    echo "selected";
}
echo ">2013</option>\n</select>\n";
$q = dquery("SELECT COUNT( * ) as cnt,relid,uid,amount,(select default_currency\nfrom tblUsers where id=uid) as dc,(select username from tblUsers\nwhere id=uid) as user,(select imei from tbl_order_imei where order_id=relid) as imei\nFROM tbl_statement_user\nWHERE description =  'Order Rejected'\nAND stype =  'imei'\nAND relid !=0\nAND date like '" . $year . "%'\nAND amount!=0\nGROUP BY relid, TIME, uid\nHAVING COUNT( * ) >1\n\nORDER BY uid asc,cnt desc");
echo "<table border=\"1\">\n<tr>\n    <th>Uid</th>\n    <th>Order ID</th>\n    <th>IMEI</th>\n    <th>Rejected Times</th>\n    <th>Order Amount</th>\n    <th>Extra Amount Refunded</th>\n    <th>Currency</th>\n</tr>\n";
$cu = 0;
$total = 0;
while ($r = mysqli_fetch_assoc($q)) {
    $cur = mysqli_fetch_assoc(dquery("select code from tbl_currencies\n    where id='" . $r["dc"] . "'"));
    if ($cu != $r["uid"] && $cu != 0) {
        echo "        <tr>\n        <td colspan=\"6\" \n        style=\"text-align: right;\"><strong>";
        echo $total;
        echo "</strong></td>\n        <td></td>\n        </tr>\n        ";
        $total = 0;
    }
    $total += $r["amount"] * ($r["cnt"] - 1);
    echo "    <tr>\n    <td>";
    echo $r["user"];
    echo " [";
    echo $r["uid"];
    echo "]</td>\n    <td>";
    echo $r["relid"];
    echo "</td>\n    <td>";
    echo $r["imei"];
    echo "</td>\n    <td>";
    echo $r["cnt"];
    echo "</td>\n    <td>";
    echo $r["amount"];
    echo "</td>\n    <td>";
    echo $r["amount"] * ($r["cnt"] - 1);
    echo "</td>\n    <td>";
    echo $cur["code"];
    echo "</td>\n    </tr>\n    ";
    $cu = $r["uid"];
}
echo "</table>";
$fileverioncheck = "6.1.0";

?>