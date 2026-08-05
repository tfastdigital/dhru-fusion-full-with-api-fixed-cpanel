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
echo "<div>\r\n";
$date = date("Y-m-d");
echo "<style>\r\n.bd td span{\r\n    font-weight: bold;\r\n}\r\n\r\n</style>\r\n<form method=\"post\">\r\n\r\n<table class=\"form\" style=\"width: auto;\">\r\n<tr>\r\n<td>\r\n<input type=\"text\" autocomplete=\"off\" name=\"from\"\r\n style=\"width: 100px;\"\r\nid=\"from\" value=\"";
echo $from ? $from : $date;
echo "\"  class=\"datepicker\"  autocomplete=\"off\"  placeholder=\"yyyy-mm-dd\" />\r\n\r\n </td>\r\n <td>\r\n\r\n<input type=\"text\" autocomplete=\"off\" name=\"to\" style=\"width: 100px;\"\r\nid=\"to\" value=\"";
echo $to ? $to : $date;
echo "\"  class=\"datepicker\"  autocomplete=\"off\"   placeholder=\"yyyy-mm-dd\" />\r\n\r\n</td>\r\n<td>\r\n<input type=\"submit\" class=\"btn btn-primary\" name=\"search\" value=\"";
echo $LNG["search"];
echo "\" />\r\n</td>\r\n</tr>\r\n </table>\r\n\r\n</form>\r\n";
if ($search && $from && $to) {
    $wherecond = " (`date` between '" . $from . "' and '" . $to . "')";
    $Disp = date("d M Y", strtotime($from)) . " to " . date("d M Y", strtotime($to));
} else {
    $wherecond = " (`date`='" . $date . "')";
    $Disp = (string) $date;
}
echo "\r\n\r\n\r\n\r\n\r\n  <table  cellspacing=\"0\" cellpadding=\"0\" id=\"main_tbl\" style=\"margin-top: 20px;\">\r\n        <tr class=\"bd\">\r\n            <td><h4><span class='badge'>Credit ";
echo $Disp;
echo "</span></h4></td>\r\n            ";
$currencyQ = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($currencyQ)) {
    echo "<th style='text-align: right;'><span class='badge'>" . $r["code"] . "</span></th>";
}
echo "        </tr>\r\n";
$currencyQ = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($currencyQ)) {
    $todaysCredit[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from tbl_statement_user\r\nwhere description like '%+ Add Funds%' and " . $wherecond . " and `type`='CR'\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $todaysDebit[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from \r\ntbl_statement_user\r\nwhere description like '%+ Add Funds%' and " . $wherecond . " and `type`='DR'\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $todaysOrder[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from \r\ntbl_statement_user\r\nwhere " . $wherecond . " and `type`='DR' \r\nand (stype='imei' or stype='file' or stype='server')\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $imeiOrders[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from \r\ntbl_statement_user where " . $wherecond . " and `type`='DR' and stype='imei'\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $fileOrders[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from \r\ntbl_statement_user where " . $wherecond . " and `type`='DR' and stype='file'\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $serverOrders[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(amount) as amount from \r\ntbl_statement_user where " . $wherecond . " and `type`='DR' and stype='server'\r\nand uid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    $unusedCredits[$r["id"]] = mysqli_fetch_assoc(dquery("select sum(credit_left) as amount\r\n    from tblUsers where default_currency='" . $r["id"] . "'"));
}
echo "<tbody class=\"tb\">\r\n<tr>\r\n    <td class=\"heads\">Added</td>\r\n    ";
foreach ($todaysCredit as $key => $value) {
    echo "                <td style=\"text-align: right;padding:5px\">";
    echo number_format(round($todaysCredit[$key]["amount"] - $todaysDebit[$key]["amount"], $precision), 2);
    echo "</td>\r\n            ";
}
echo "</tr>\r\n<tr>\r\n    <td class=\"heads\">Used</td>\r\n    ";
foreach ($todaysCredit as $key => $value) {
    echo "                <td style=\"text-align: right;padding:5px\">";
    echo number_format(round($todaysOrder[$key]["amount"] ? $todaysOrder[$key]["amount"] : "0", $precision), 2);
    echo "</td>\r\n            ";
}
echo "</tr>\r\n<tr>\r\n    <td class=\"heads\">IMEI Orders</td>\r\n    ";
foreach ($imeiOrders as $key => $value) {
    echo "                <td style=\"text-align: right;padding:5px\">";
    echo number_format(round($imeiOrders[$key]["amount"] ? $imeiOrders[$key]["amount"] : "0", $precision), 2);
    echo "</td>\r\n            ";
}
echo "</tr>\r\n<tr>\r\n    <td class=\"heads\">File Orders</td>\r\n    ";
foreach ($fileOrders as $key => $value) {
    echo "                <td style=\"text-align: right;padding:5px\">";
    echo number_format(round($fileOrders[$key]["amount"] ? $fileOrders[$key]["amount"] : "0", $precision), 2);
    echo "</td>\r\n            ";
}
echo "</tr>\r\n<tr>\r\n    <td class=\"heads\" style=\"border: none;\">Server Orders</td>\r\n    ";
foreach ($serverOrders as $key => $value) {
    echo "                <td style=\"border: none;text-align: right;padding:5px\">";
    echo number_format(round($serverOrders[$key]["amount"] ? $serverOrders[$key]["amount"] : "0", $precision), 2);
    echo "</td>\r\n            ";
}
echo "</tr>\r\n<tr>\r\n    <td class=\"heads\" style=\"border: none;\">Unused Credits [Till Today]</td>\r\n    ";
foreach ($unusedCredits as $key => $value) {
    echo "        <td style=\"border: none;text-align: right;padding:5px\">";
    echo number_format(round($unusedCredits[$key]["amount"] ? $unusedCredits[$key]["amount"] : "0", $precision), 2);
    echo "</td>\r\n        ";
}
echo "</tr>\r\n</tbody>\r\n         </table>\r\n    </div>\r\n\r\n\r\n\r\n";
$fileverioncheck = "6.1.0";

?>