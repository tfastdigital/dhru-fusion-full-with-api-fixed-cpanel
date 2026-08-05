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
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  \r\n    from tbl_order_imei WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c \r\n    union select count(*) as total,MONTH(date) as month,user_can_c,2  \r\n    from tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),\r\n    user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3  from tbl_order_server \r\n    WHERE year( date ) = year( now( ) ) group by MONTH(date),\r\n    user_can_c \r\n    union select count(*) as total,MONTH(date) as month,user_can_c,4  \r\n    from tbl_order_product WHERE year( date ) = year( now( ) )\r\n     group by MONTH(date),user_can_c";
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
echo "\r\n   \r\n\r\n<script type=\"text/javascript\">\r\n \r\n\$(function () {\r\n \r\n   \r\n     \$('#container').highcharts({\r\n            chart: {\r\n                type: 'areaspline'\r\n            },title: {\r\n                text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\r\n            },\r\n            legend: {\r\n                layout: 'vertical',\r\n                align: 'right',\r\n                verticalAlign: 'top',\r\n                 x: 0,\r\n                 y: 0,\r\n                floating: true,\r\n                borderWidth: 1,\r\n                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'\r\n            },\r\n            xAxis: {\r\n                categories: [\r\n                    'Jan',\r\n                    'Feb',\r\n                    'Mar',\r\n                    'Apr',\r\n                    'May',\r\n                    'Jun',\r\n                    'Jul',\r\n                    'Aug',\r\n                    'Sep',\r\n                    'Oct',\r\n                    'Nov',\r\n                    'Dec'\r\n                ],\r\n                plotBands: [{  \r\n                    from: 4.5,\r\n                    to: 6.5,\r\n                    color: 'rgba(68, 170, 213, .2)'\r\n                }]\r\n            },\r\n            yAxis: {\r\n                title: {\r\n                    text: 'Orders'\r\n                }\r\n            },\r\n            tooltip: {\r\n                shared: true,\r\n                valueSuffix: ' Orders'\r\n            },\r\n            credits: {\r\n                enabled: false\r\n            },\r\n            plotOptions: {\r\n                areaspline: {\r\n                    fillOpacity: 0.9\r\n                }\r\n            },\r\n            series: [{\r\n                 name: 'Shop',\r\n                 data: [";
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
echo "]\r\n              }]\r\n        });\r\n    \r\n });\r\n \r\n  </script>\r\n    \r\n    \r\n    <div style=\"text-align: center;\">            \r\n        <div id=\"container\" style=\"height: 350px; margin: 0 auto;\"></div>\r\n    </div>";
$fileverioncheck = "6.1.0";

?>