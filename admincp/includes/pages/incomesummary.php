<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form {margin-bottom: 4px !important;}\n.form td a{text-decoration:none; display: block;}\n.form td a:hover{text-decoration:underline;}\n.fieldarea{text-align: center;}\ntable tr:hover td{background: #f4f4f4;}\n</style>\n";
$pageid = 411;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once DATAGRID_DIR . "comm.php";
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$table = ["tbl_invoices"];
$array = [" datepaid LIKE '" . $today . "%'", "month(datepaid)='" . $month . "' \n            and year(datepaid)='" . $year . "'", "year(datepaid)='" . $year . "'"];
foreach ($array as $value) {
    $cq = dquery("select * from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cq)) {
        $result = dquery("select sum(subtotal+shippingtax) as income\n        from tbl_invoices where " . $value . " and (select default_currency from tblUsers\n        where id=userid)='" . $rc["id"] . "'");
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income["income"] = $row["income"];
            $ctotal += $income["income"];
        }
        $inc[$rc["id"]] = $ctotal;
    }
    $cqs = dquery("select * from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cqs)) {
        $inctbl[$rc["id"]][] = mysqli_fetch_assoc(dquery("select sum(" . $inc[$rc["id"]] . ") as income"));
    }
}
$array = ["UNIX_TIMESTAMP(datepaid)='" . $yesterday . "'", "month(datepaid)='" . $pmonth . "'\n              and year(datepaid)='" . $year . "'", "year(datepaid)='" . $pyear . "'"];
foreach ($array as $value) {
    $cq = dquery("select * from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cq)) {
        $result = dquery("select sum(total) as income from " . $tbl . "\n            where " . $value . " and (select default_currency from tblUsers\n            where id=userid)='" . $rc["id"] . "'");
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income["income"] = $row["income"];
            $ctotal += $income["income"];
        }
        $inc[$rc["id"]] = $ctotal;
    }
    $cqs = dquery("select * from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cqs)) {
        $inctbly[] = mysqli_fetch_assoc(dquery("select sum(" . $inc[$rc["id"]] . ")\n         as income"));
    }
}
echo "\n<style>\n    .align-center {\n        text-align: center;\n    }\n    .align-right {\n        text-align: right;\n        width: 16.66%;\n    }\n    .income-table th, .income-table td {\n        border-bottom: 1px solid #dfe6ee;\n        border-right: 1px solid #dfe6ee;\n        padding: 5px;\n    }\n</style>\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n    \n    \n     <div>\n        <div class=\"groupstabes\">\n           \n          <table id=\"main_tbl\"  cellpadding=\"0\" cellspacing=\"0\">\n            <tr>\n              <th> ";
echo $LNG["income"];
echo " </th>\n              <th>";
echo $LNG["today"];
echo "</th>\n              <th >";
echo $LNG["last"];
echo "                Day</th>\n              <th> ";
echo $LNG["this"];
echo "                ";
echo $LNG["month"];
echo "</th>\n              <th > ";
echo $LNG["last"];
echo "                ";
echo $LNG["month"];
echo "</th>\n              <th>";
echo $LNG["this"];
echo "                ";
echo $LNG["year"];
echo "</th>\n              <th>";
echo $LNG["last"];
echo "                ";
echo $LNG["year"];
echo "</th>\n            </tr>\n            ";
$qc = dquery("select * from tbl_currencies");
while ($rc = mysqli_fetch_assoc($qc)) {
    echo "            <tr>\n              <td><h3>\n                  ";
    echo $rc["code"];
    echo "                </h3></td>\n              <td>";
    echo $inctbl[$rc["id"]][0]["income"];
    echo "</td>\n              <td>";
    echo $inctbly[$rc["id"]][0]["income"];
    echo "</td>\n              <td>";
    echo $inctbl[$rc["id"]][1]["income"];
    echo "</td>\n              <td>";
    echo $inctbly[$rc["id"]][1]["income"];
    echo "</td>\n              <td>";
    echo $inctbl[$rc["id"]][2]["income"];
    echo "</td>\n              <td>";
    echo $inctbly[$rc["id"]][2]["income"];
    echo "</td>\n            </tr>\n            ";
}
echo "          </table>\n        </div>\n      </div>\n \n \n \n \n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>