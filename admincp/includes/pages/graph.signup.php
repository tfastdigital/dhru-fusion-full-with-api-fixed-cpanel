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
echo "\n    <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n    <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/exporting.js\"></script>\n\n ";
$year = $id;
if (!$year) {
    $year = date("Y");
}
$sql = "select count(*) as total,MONTH(FROM_UNIXTIME(ac_create_dt)) as month  from tblUsers WHERE year(FROM_UNIXTIME(ac_create_dt)) =" . $year . " group by MONTH(FROM_UNIXTIME(ac_create_dt))";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["month"]] = $row["total"];
}
for ($j = 1; $j <= 12; $j++) {
    if (!$_order[$j]) {
        $_order[$j] = 0;
    }
}
echo "\n\t<script type=\"text/javascript\">\n\nvar chart;\n\$(document).ready(function() {\n   chart = new Highcharts.Chart({\n      chart: {\n         renderTo: 'monthly',\n         defaultSeriesType: 'column'\n      },\n      title: {\n         text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["signup"];
echo " - ";
echo $year;
echo "'\n      },\n      xAxis: {\n         categories: ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']\n      },\n      yAxis: {\n         min: 0,\n         title: {\n            text: '";
echo $LNG["total"];
echo " ";
echo $LNG["user"];
echo "'\n         }\n      },\n      legend: {\n         align: 'right',\n         x: 0,\n         verticalAlign: 'top',\n         y: -5,\n         floating: true,\n         backgroundColor:'#FFFFFF',\n         borderColor: '#CCC',\n         borderWidth: 1,\n         shadow: false\n      },\n      tooltip: {\n         formatter: function() {\n            return '<b>'+ this.x +'</b><br/>'+\n                this.series.name +': '+ this.y +'<br/>'+\n                'Total: '+ this.point.stackTotal;\n         }\n      },\n      plotOptions: {\n         column: {\n            stacking: 'normal',\n            shadow:false\n         }\n      },\n       series: [{\n         name: 'Users',\n         data: [\n         ";
foreach ($_order as $value) {
    echo $value . ",";
}
echo "         ]\n      }]\n   });\n\n\n});\n\t\t</script>\n\n  <div id=\"monthly\" style=\"height:500px;\"></div>\n\n<br />\n<table width=\"100%\"><tr><td><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab3','main2.php?page=graph.signup','";
echo $year - 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["prev"];
echo " ";
echo $LNG["year"];
echo " </a></td><td align=\"right\"><a class=\"boldlink\" style=\"text-decoration: none;\" href=\"javascript:void(0);\" onclick=\"getContect('#tab3','main2.php?page=graph.signup','";
echo $year + 1;
echo "','','#tabcontent',true,'#main_loader');\"> ";
echo $LNG["next"];
echo " ";
echo $LNG["year"];
echo " </a></td></tr></table>";
$fileverioncheck = "6.1.0";

?>