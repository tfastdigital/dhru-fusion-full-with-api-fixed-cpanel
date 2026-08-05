<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "../comm.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
$id = $_SESSION["uid"];
$user_can_c = $status;
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl \nfrom tbl_order_imei WHERE year( date ) = year( now( ) ) and user_id='" . $id . "'\ngroup by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,2 \nfrom tbl_order_file WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' \ngroup by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3 \nfrom tbl_order_server WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' group by\nMONTH(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["tbl"]][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if ($user_can_c == "0") {
            $_order[$i][$j][$user_can_c]["count"] = $_order[$i][$j][$user_can_c]["count"] + $_order[$i][$j][1]["count"];
        }
        if (!$_order[$i][$j][$user_can_c]) {
            $_order[$i][$j][$user_can_c]["count"] = 0;
        }
    }
}
if ($user_can_c == "4") {
    $sts = "Available";
}
if ($user_can_c == "0") {
    $sts = "Pending";
}
if ($user_can_c == "3") {
    $sts = "Rejected";
}
echo "\n\n<script>\n    \$(function () {\n        \$('#container-chart').highcharts({\n            chart: {\n                type: 'column'\n            },\n            title: {\n                text: 'Monthly ";
echo $sts;
echo " Order'\n            },\n            subtitle: {\n                text: ''\n            },\n            xAxis: {\n                categories: [\n                    'Jan',\n                    'Feb',\n                    'Mar',\n                    'Apr',\n                    'May',\n                    'Jun',\n                    'Jul',\n                    'Aug',\n                    'Sep',\n                    'Oct',\n                    'Nov',\n                    'Dec'\n                ]\n            },\n            yAxis: {\n                min: 0,\n                title: {\n                    text: 'No. of orders'\n                }\n            },\n            tooltip: {\n                headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',\n                pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +\n                    '<td style=\"padding:0\"><b>{point.y}</b></td></tr>',\n                footerFormat: '</table>',\n                shared: true,\n                useHTML: true\n            },\n            plotOptions: {\n                column: {\n                    pointPadding: 0.2,\n                    borderWidth: 0\n                }\n            },\n            series: [{\n                 name: 'IMEI',\n                 data: [";
echo $_order[1][1][$user_can_c]["count"];
echo ",";
echo $_order[1][2][$user_can_c]["count"];
echo ",";
echo $_order[1][3][$user_can_c]["count"];
echo ",";
echo $_order[1][4][$user_can_c]["count"];
echo ",";
echo $_order[1][5][$user_can_c]["count"];
echo ",";
echo $_order[1][6][$user_can_c]["count"];
echo ",";
echo $_order[1][7][$user_can_c]["count"];
echo ",";
echo $_order[1][8][$user_can_c]["count"];
echo ",";
echo $_order[1][9][$user_can_c]["count"];
echo ",";
echo $_order[1][10][$user_can_c]["count"];
echo ",";
echo $_order[1][11][$user_can_c]["count"];
echo ",";
echo $_order[1][12][$user_can_c]["count"];
echo "]\n              },{\n                 name: 'File',\n                 data: [";
echo $_order[2][1][$user_can_c]["count"];
echo ",";
echo $_order[2][2][$user_can_c]["count"];
echo ",";
echo $_order[2][3][$user_can_c]["count"];
echo ",";
echo $_order[2][4][$user_can_c]["count"];
echo ",";
echo $_order[2][5][$user_can_c]["count"];
echo ",";
echo $_order[2][6][$user_can_c]["count"];
echo ",";
echo $_order[2][7][$user_can_c]["count"];
echo ",";
echo $_order[2][8][$user_can_c]["count"];
echo ",";
echo $_order[2][9][$user_can_c]["count"];
echo ",";
echo $_order[2][10][$user_can_c]["count"];
echo ",";
echo $_order[2][11][$user_can_c]["count"];
echo ",";
echo $_order[2][12][$user_can_c]["count"];
echo "]\n              }, {\n                 name: 'Server',\n                 data: [";
echo $_order[3][1][$user_can_c]["count"];
echo ",";
echo $_order[3][2][$user_can_c]["count"];
echo ",";
echo $_order[3][3][$user_can_c]["count"];
echo ",";
echo $_order[3][4][$user_can_c]["count"];
echo ",";
echo $_order[3][5][$user_can_c]["count"];
echo ",";
echo $_order[3][6][$user_can_c]["count"];
echo ",";
echo $_order[3][7][$user_can_c]["count"];
echo ",";
echo $_order[3][8][$user_can_c]["count"];
echo ",";
echo $_order[3][9][$user_can_c]["count"];
echo ",";
echo $_order[3][10][$user_can_c]["count"];
echo ",";
echo $_order[3][11][$user_can_c]["count"];
echo ",";
echo $_order[3][12][$user_can_c]["count"];
echo "]\n              }]\n        });\n    });\n</script>\n\n<div id=\"container-chart\"></div>";

?>