<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\n<div style=\"width: 1020px !important;\">\n";
$pageid = 457;
checkPagePermission($pageid);
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$year = date("Y", time());
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
$array = ["date='" . $today . "'", "MONTH(date)='" . $month . "' and YEAR(date)='" . $year . "'", "YEAR(date)='" . $year . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $income[$tbl] = mysqli_fetch_assoc(dquery("select sum(credit-discount) as income from " . $tbl . " where " . $value . " and user_can_c='4'"));
        if (!$income[$tbl]["income"]) {
            $inc[$tbl] = 0;
        } else {
            $inc[$tbl] = $income[$tbl]["income"];
        }
    }
    $inctbl[] = mysqli_fetch_assoc(dquery("select sum(" . $inc["tbl_order_imei"] . "+" . $inc["tbl_order_file"] . "+" . $inc["tbl_order_server"] . "+" . $inc["tbl_order_product"] . ") as income"));
}
echo "\n\n<div align=\"center\" style=\"border: 2px dashed #CCC; padding: 8px; margin: 5px;\">\n    <span style=\"font-size: 18px; color: #666 !important;\">\n    ";
echo $LNG["monthly"];
echo " ";
echo $LNG["income"];
echo ": <strong>";
echo formatCurrency($inctbl[1]["income"]);
echo "</strong> | \n    </span>\n</div>\n<br />\n\n<br />\n</div>\n";
$fileverioncheck = "6.1.0";

?>