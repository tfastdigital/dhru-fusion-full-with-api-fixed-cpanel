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
echo "</th><th><div align=\"right\">";
echo $LNG["total"];
echo " ";
echo $LNG["order"];
echo "</div></th><th></th> </tr></thead>\n<tbody>\n";
$total = 0;
$gresult = dquery("select group_name,id from tbl_server_group");
while ($group = mysqli_fetch_assoc($gresult)) {
    echo "<tr><td><strong>" . $group["group_name"] . "</strong></td><td></td><td></td></tr>";
    $iresult = dquery("SELECT count(service_id) as total,sum(tbl_order_server.credit-discount) as credit,tbl_server_log.service_name FROM `tbl_order_server` right outer join tbl_server_log on service_id=id  and user_can_c='4' where group_id=" . $group["id"] . " group by tbl_server_log.id");
    while ($row = mysqli_fetch_assoc($iresult)) {
        if (!$row["credit"]) {
            $row["credit"] = 0;
        }
        echo "<tr><td>" . $row["service_name"] . "</td><td align=right>" . $row["total"] . "</td><td></td></tr>";
        $total = $total + $row["total"];
    }
}
echo "<tr><td></td><td>";
echo $LNG["total"] . " = " . $total;
echo "</td><td></td></tr>\n</tbody></table>";
$fileverioncheck = "6.1.0";

?>