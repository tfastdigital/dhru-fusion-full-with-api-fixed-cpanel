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
echo "<table id=\"main_tbl\" style=\"display: table;\">\n\n    <script>\n        function getorder(days){\n            location.href='main2.php?page=salesbyproduct&defaultloadpage=salesbyfile.php&ordersfrom='+days;\n        }\n    </script>\n    Orders From :\n    <select name=\"ordersfrom\" onchange=\"getorder(this.value);\">\n        <option ";
if ($ordersfrom == 2) {
    echo "selected";
}
echo " value=\"2\">Last 30 Days</option>\n        <option ";
if ($ordersfrom == 1) {
    echo "selected";
}
echo " value=\"1\">Last 7 Days</option>\n        <option ";
if ($ordersfrom == 3) {
    echo "selected";
}
echo " value=\"3\">Yesterday</option>\n    </select>\n\n\n<thead><tr><th>";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th><th><div align=\"right\">";
echo $LNG["total"];
echo " ";
echo $LNG["order"];
echo "</div></th> <th></th> </tr></thead>\n<tbody>\n";
$total = 0;
if ($ordersfrom == 3) {
    $date = date("Y-m-d", strtotime("-1 days"));
    $WHERE .= " and date='" . $date . "'";
} else {
    if ($ordersfrom == 1) {
        $datet = date("Y-m-d", strtotime("-7 days"));
        $datef = date("Y-m-d");
        $WHERE .= " and (date between '" . $datet . "' and '" . $datef . "')";
    } else {
        $datet = date("Y-m-d", strtotime("-30 days"));
        $datef = date("Y-m-d");
        $WHERE .= " and (date between '" . $datet . "' and '" . $datef . "')";
    }
}
$iresult = dquery("SELECT count(service_id) as total,service_id\n,sum(tbl_order_file.credit-discount) as credit\n,tbl_services_file.service_name \nFROM `tbl_order_file` \nright outer join tbl_services_file on service_id=id  and user_can_c='4' \n " . $WHERE . "\n group by tbl_services_file.id\norder by total desc");
while ($row = mysqli_fetch_assoc($iresult)) {
    if (!$row["credit"]) {
        $row["credit"] = 0;
    }
    echo "<tr><td><a class=\"default_dg_a\" href=\"javascript:load_fromsubpage('editfileservice&id=" . $row["service_id"] . "', '" . $row["service_name"] . "')\">" . $row["service_name"] . "</a></td><td align=right>" . $row["total"] . "</td><td></td></tr>";
    $total = $total + $row["total"];
}
echo "</tbody></table>";
$fileverioncheck = "6.1.0";

?>