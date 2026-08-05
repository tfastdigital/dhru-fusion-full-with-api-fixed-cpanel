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
echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\n ";
$year = $id;
if (!$year) {
    $year = date("Y");
}
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,4  from tbl_order_product WHERE year( date ) = " . $year . " group by MONTH(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($j = 1; $j <= 12; $j++) {
    if (!$_order[$j][4]) {
        $_order[$j][4]["count"] = 0;
    }
}
echo "   \n    \n\t<script type=\"text/javascript\">\n\nvar chart;\n\$(document).ready(function() {\n   chart = new Highcharts.Chart({\n      chart: {\n         renderTo: 'monthly',\n         defaultSeriesType: 'column'\n      },\n      title: {\n         text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo " - ";
echo $year;
echo "'\n      },\n      xAxis: {\n         categories: ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']\n      },\n      yAxis: {\n         min: 0,\n         title: {\n            text: '";
echo $LNG["total"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\n         }\n      },\n      legend: { \n         align: 'right',\n         x: 0,\n         verticalAlign: 'top',\n         y: -5,\n         floating: true,\n         backgroundColor:'#FFFFFF',\n         borderColor: '#CCC',\n         borderWidth: 1,\n         shadow: false\n      },\n      tooltip: {\n         formatter: function() {\n            return '<b>'+ this.x +'</b><br/>'+\n                this.series.name +': '+ this.y +'<br/>'+\n                'Total: '+ this.point.stackTotal;\n         }\n      },\n      plotOptions: {\n         column: {\n            stacking: 'normal'\n         }\n      },\n       series: [{\n         name: 'Shop',\n         data: [";
echo $_order[1][4]["count"];
echo ",";
echo $_order[2][4]["count"];
echo ",";
echo $_order[3][4]["count"];
echo ",";
echo $_order[4][4]["count"];
echo ",";
echo $_order[5][4]["count"];
echo ",";
echo $_order[6][4]["count"];
echo ",";
echo $_order[7][4]["count"];
echo ",";
echo $_order[8][4]["count"];
echo ",";
echo $_order[9][4]["count"];
echo ",";
echo $_order[10][4]["count"];
echo ",";
echo $_order[11][4]["count"];
echo ",";
echo $_order[12][4]["count"];
echo "]\n      }]\n   });\n   \n   \n});\n\t\t</script> \n        \n  <div id=\"monthly\" style=\"height:500px;\"></div>\n\n<br />\n<table width=\"100%\"><tr><td><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab2','main2.php?page=graph.order','";
echo $year - 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["prev"];
echo " ";
echo $LNG["year"];
echo " </a></td><td align=\"right\"><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab2','main2.php?page=graph.order','";
echo $year + 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["next"];
echo " ";
echo $LNG["year"];
echo " </a></td></tr></table>";
$fileverioncheck = "6.1.0";

?>