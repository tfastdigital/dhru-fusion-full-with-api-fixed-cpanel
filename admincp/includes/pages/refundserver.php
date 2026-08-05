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
echo "<table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr><th>";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th>\n<th>";
echo $LNG["action"];
echo "</th>\n<th><div align=\"right\">";
echo $LNG["refunded"];
echo " ";
echo $LNG["order"];
echo "</div></th></tr></thead>\n<tbody>\n";
$total = 0;
$gresult = dquery("select group_name,id from tbl_server_group");
while ($group = mysqli_fetch_assoc($gresult)) {
    echo "<tr><td colspan=2><strong>" . $group["group_name"] . "</strong></td><td></td></tr>";
    $iresult = dquery("SELECT count(service_id) as total,sum(tbl_order_server.credit-discount) \n    as credit,tbl_server_log.service_name,tbl_server_log.id FROM `tbl_order_server` \n    right outer join tbl_server_log on service_id=id  and user_can_c='3' \n    where group_id=" . $group["id"] . " group by tbl_server_log.id");
    while ($row = mysqli_fetch_assoc($iresult)) {
        echo "<tr><td>" . $row["service_name"] . "</td>\n    <td ><a class='default_dg_a' style='color: #868686;' href=\"javascript: load_subpage('main2.php?page=serverorder.history&id=" . $row["id"] . "&action=refund','View Refunded Order')\">View Order</a></td>\n    <td align=right>" . $row["total"] . "</td></tr>";
        $total = $total + $row["total"];
    }
}
echo "<tr><td colspan='2'></td></td>\n\n<td>";
echo $LNG["total"] . " = " . $total;
echo "</td></tr>\n\n</tbody></table>";
$fileverioncheck = "6.1.0";

?>