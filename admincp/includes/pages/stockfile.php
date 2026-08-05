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
echo "</th><th><div align=\"right\">\n";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</div></th><th><div align=\"right\">\n";
echo $LNG["action"];
echo "</div></th></tr></thead>\n<tbody>\n";
$total = 0;
$gresult = dquery("select group_name,id from tbl_file_group");
while ($group = mysqli_fetch_assoc($gresult)) {
    $iresult = dquery("SELECT id,service_name,stock,stock_allow from tbl_services_file\n    WHERE group_id='" . $group["id"] . "' and stock_allow=1");
    if (mysqli_num_rows($iresult)) {
        echo "<tr><td colspan=2><strong>" . $group["group_name"] . "</strong></td><td></td></tr>";
        while ($row = mysqli_fetch_assoc($iresult)) {
        }
    }
    if (!$row["stock"]) {
        $row["stock"] = 0;
    }
    echo "<tr><td><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockfile.detail&id=";
    echo $row["id"];
    echo "','View Detail Stock');\">\n";
    echo $row["service_name"] . "</a></td><td align=right>" . $row["stock"] . "</td>";
    echo " <td align=\"right\"><a style=\"text-decoration: none;\" onclick=\"load_subpage('main2.php?page=stockfile.detail&id=";
    echo $row["id"];
    echo "','View Detail Stock');\">";
    echo $LNG["view"] . " " . $LNG["sold"] . " " . $LNG["stock"];
    echo "</td>\n        </tr>";
}
echo "</tbody></table>";
$fileverioncheck = "6.1.0";

?>