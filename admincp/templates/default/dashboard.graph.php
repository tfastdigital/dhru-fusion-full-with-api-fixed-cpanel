<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  \n    from tbl_order_imei WHERE year( date ) = year( now( ) ) and `server`='0' group by MONTH(date),user_can_c \n    union select count(*) as total,MONTH(date) as month,user_can_c,2  \n    from tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),\n    user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3\n      from tbl_order_imei \n    WHERE year( date ) = year( now( ) ) and `server`='1' group by MONTH(date),\n    user_can_c \n    union select count(*) as total,MONTH(date) as month,user_can_c,4  \n    from tbl_order_product WHERE year( date ) = year( now( ) )\n     group by MONTH(date),user_can_c";
$result = dquery($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["tbl"]][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($i = 1; $i <= 4; $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if (!$_order[$i][$j][4]) {
            $_order[$i][$j][4]["count"] = 0;
        }
    }
}
echo "\n\n              \n\n <!--\n<canvas id=\"myChart\" width=\"400\" height=\"130\"></canvas>\n-->\n     \n    \n\n<script type=\"text/javascript\">\n \n \n\$(function () {\n \n   \n     \$('#container').highcharts({\n            chart: {\n                type: 'areaspline'\n            },title: {\n                text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\n            },\n            legend: {\n                layout: 'vertical',\n                align: 'right',\n                verticalAlign: 'top',\n                 x: 0,\n                 y: 0,\n                floating: true,\n                borderWidth: 1,\n                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'\n            },\n            xAxis: {\n                categories: [\n                    'Jan',\n                    'Feb',\n                    'Mar',\n                    'Apr',\n                    'May',\n                    'Jun',\n                    'Jul',\n                    'Aug',\n                    'Sep',\n                    'Oct',\n                    'Nov',\n                    'Dec'\n                ],\n                plotBands: [{  \n                    from: 4.5,\n                    to: 6.5,\n                    color: 'rgba(68, 170, 213, .2)'\n                }]\n            },\n            yAxis: {\n                title: {\n                    text: 'Orders'\n                }\n            },\n            tooltip: {\n                shared: true,\n                valueSuffix: ' Orders'\n            },\n            credits: {\n                enabled: false\n            },\n            plotOptions: {\n                areaspline: {\n                    fillOpacity: 0.9\n                }\n            },\n            series: [";
if (!$OnlyEcommerce) {
    echo "{\n                 name: 'IMEI',\n                  color: '#2cbea5',\n                 data: [";
    echo $_order[1][1][4]["count"];
    echo ",";
    echo $_order[1][2][4]["count"];
    echo ",";
    echo $_order[1][3][4]["count"];
    echo ",";
    echo $_order[1][4][4]["count"];
    echo ",";
    echo $_order[1][5][4]["count"];
    echo ",";
    echo $_order[1][6][4]["count"];
    echo ",";
    echo $_order[1][7][4]["count"];
    echo ",";
    echo $_order[1][8][4]["count"];
    echo ",";
    echo $_order[1][9][4]["count"];
    echo ",";
    echo $_order[1][10][4]["count"];
    echo ",";
    echo $_order[1][11][4]["count"];
    echo ",";
    echo $_order[1][12][4]["count"];
    echo "]\n              },{\n                 name: 'File',\n                  color: '#313c42',\n                 data: [";
    echo $_order[2][1][4]["count"];
    echo ",";
    echo $_order[2][2][4]["count"];
    echo ",";
    echo $_order[2][3][4]["count"];
    echo ",";
    echo $_order[2][4][4]["count"];
    echo ",";
    echo $_order[2][5][4]["count"];
    echo ",";
    echo $_order[2][6][4]["count"];
    echo ",";
    echo $_order[2][7][4]["count"];
    echo ",";
    echo $_order[2][8][4]["count"];
    echo ",";
    echo $_order[2][9][4]["count"];
    echo ",";
    echo $_order[2][10][4]["count"];
    echo ",";
    echo $_order[2][11][4]["count"];
    echo ",";
    echo $_order[2][12][4]["count"];
    echo "]\n              }, {\n                 name: 'Server',\n                  color: '#ff5d53',\n                 data: [";
    echo $_order[3][1][4]["count"];
    echo ",";
    echo $_order[3][2][4]["count"];
    echo ",";
    echo $_order[3][3][4]["count"];
    echo ",";
    echo $_order[3][4][4]["count"];
    echo ",";
    echo $_order[3][5][4]["count"];
    echo ",";
    echo $_order[3][6][4]["count"];
    echo ",";
    echo $_order[3][7][4]["count"];
    echo ",";
    echo $_order[3][8][4]["count"];
    echo ",";
    echo $_order[3][9][4]["count"];
    echo ",";
    echo $_order[3][10][4]["count"];
    echo ",";
    echo $_order[3][11][4]["count"];
    echo ",";
    echo $_order[3][12][4]["count"];
    echo "]\n              },";
}
echo " {\n                 name: 'Shop',\n                  color: '#094c61',\n                 data: [";
echo $_order[4][1][4]["count"];
echo ",";
echo $_order[4][2][4]["count"];
echo ",";
echo $_order[4][3][4]["count"];
echo ",";
echo $_order[4][4][4]["count"];
echo ",";
echo $_order[4][5][4]["count"];
echo ",";
echo $_order[4][6][4]["count"];
echo ",";
echo $_order[4][7][4]["count"];
echo ",";
echo $_order[4][8][4]["count"];
echo ",";
echo $_order[4][9][4]["count"];
echo ",";
echo $_order[4][10][4]["count"];
echo ",";
echo $_order[4][11][4]["count"];
echo ",";
echo $_order[4][12][4]["count"];
echo "]\n              }]\n        });\n    \n });\n\n \n  </script>\n    \n    \n    <div style=\"text-align: center;\">            \n        <div id=\"container\" style=\"height: 350px; margin: 0 auto;\"></div>\n    </div>";
$fileverioncheck = "6.1.0";

?>