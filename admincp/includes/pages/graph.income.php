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
echo "\n\n    <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n    <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/exporting.js\"></script>\n\n";
$year = $id;
if (!$year) {
    $year = date("Y");
}
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
foreach ($table as $key => $tbl) {
    $where = "";
    if ($tbl == "tbl_order_imei") {
        $where = " and `server`=0";
    } else {
        if ($tbl == "tbl_order_server") {
            $where = " and `server`=1";
            $tbl = "tbl_order_imei";
        }
    }
    $result = dquery("select MONTH(date) as month,sum(credit-discount) as income\n    ,currency_id from " . $tbl . " where YEAR(date)=" . $year . " and user_can_c='4' " . $where . "\n    group by MONTH(date),currency_id");
    $ctotal = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $income[$row["month"]][$row["currency_id"]] += $row["income"];
    }
}
for ($i = 1; $i <= 12; $i++) {
    $result = dquery("select code,id from tbl_currencies");
    while ($rowc = mysqli_fetch_assoc($result)) {
        if (!$income[$i][$rowc["id"]]) {
            $income[$i][$rowc["id"]] = "0";
        }
    }
}
$string = "";
$result = dquery("select code,id from tbl_currencies");
while ($rowc = mysqli_fetch_assoc($result)) {
    $string .= "{name: '" . $rowc["code"] . "',data:[";
    foreach ($income as $key => $value) {
        $string .= $income[$key][$rowc["id"]] . ",";
    }
    $string .= "]},";
}
echo "\n\t<script type=\"text/javascript\">\n\n\t\t\tvar chart;\n\t\t\t\$(document).ready(function() {\n\t\t\t\tchart = new Highcharts.Chart({\n\t\t\t\t\tchart: {\n\t\t\t\t\t\trenderTo: 'monthly',\n\t\t\t\t\t\tdefaultSeriesType: 'column'\n\t\t\t\t\t},\n\t\t\t\t\ttitle: {\n\t\t\t\t\t\ttext: '";
echo $LNG["annually"];
echo " ";
echo $LNG["income"];
echo " - ";
echo $year;
echo "'\n\t\t\t\t\t},\n\t\t\t\t\tsubtitle: {\n\t\t\t\t\t\ttext: ''\n\t\t\t\t\t},\n\t\t\t\t\txAxis: {\n\t\t\t\t\t\tcategories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']\n\t\t\t\t\t},\n\t\t\t\t\tyAxis: {\n\t\t\t\t\t\tmin: 0,\n\t\t\t\t\t\ttitle: {\n\t\t\t\t\t\t\ttext: '";
echo $LNG["total"];
echo " ";
echo $LNG["income"];
echo "'\n\t\t\t\t\t\t}\n\t\t\t\t\t},\n\t\t\t\t\tlegend: {\n\t\t\t\t\t\tlayout: 'horizontal',\n\t\t\t\t\t\tbackgroundColor: '#FFFFFF',\n\t\t\t\t\t\talign: 'right',\n\t\t\t\t\t\tverticalAlign: 'top',\n\t\t\t\t\t\tx: 0,\n\t\t\t\t\t\ty: -5,\n\t\t\t\t\t\tfloating: true,\n\t\t\t\t\t\tshadow: false\n\t\t\t\t\t},\n\t\t\t\t\ttooltip: {\n\t\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\t\treturn ''+\n\t\t\t\t\t\t\t\tthis.x +': '+ this.y;\n\t\t\t\t\t\t}\n\t\t\t\t\t},\n\t\t\t\t\tplotOptions: {\n\t\t\t\t\t\tcolumn: {\n\t\t\t\t\t\t\tpointPadding: 0.2,\n\t\t\t\t\t\t\tborderWidth: 0,\n                            shadow: false\n\t\t\t\t\t\t}\n\t\t\t\t\t},\n\t\t\t\t        series: [";
echo $string;
echo "]\n\t\t\t\t});\n\n\n\t\t\t});\n\n\t\t</script>\n  <div id=\"monthly\" style=\"height:500px;\"></div>\n\n<br />\n<table width=\"100%\"><tr><td><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab1','main2.php?page=graph.income','";
echo $year - 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["prev"];
echo " ";
echo $LNG["year"];
echo " </a></td><td align=\"right\"><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab1','main2.php?page=graph.income','";
echo $year + 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["next"];
echo " ";
echo $LNG["year"];
echo " </a></td></tr></table>";
$fileverioncheck = "6.1.0";

?>