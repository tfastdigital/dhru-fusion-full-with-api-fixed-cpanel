<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$sql = "select count(service_id) as total,service_name,daily_deal,service_id  from tbl_order_product,tbl_products WHERE year( date ) = year( now( ) ) and user_can_c=4 and id=service_id and daily_deal=1 group by service_id";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["service_id"]]["servicename"] = $row["service_name"];
    $_order[$row["service_id"]]["total"] = $row["total"];
}
echo "   \n    \n\t<script type=\"text/javascript\">\nvar chart;\n\$(document).ready(function() {\n   chart = new Highcharts.Chart({\n      chart: {\n         renderTo: 'monthly',\n         defaultSeriesType: 'column'\n      },\n      title: {\n         text: 'Daily Deals Order'\n      },\n      xAxis: {         \n         categories: [";
foreach ($_order as $key => $value) {
    echo "'" . $value["servicename"] . "',";
}
echo "]\n      },\n      yAxis: {\n         min: 0,\n         title: {\n            text: '";
echo $LNG["total"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\n         }\n      },\n      legend: { \n         align: 'right',\n         x: 0,\n         verticalAlign: 'top',\n         y: 20,\n         floating: true,\n         backgroundColor:'#FFFFFF',\n         borderColor: '#CCC',\n         borderWidth: 1,\n         shadow: false\n      },\n      tooltip: {\n         formatter: function() {\n            return '<b>'+ this.x +'</b><br/>'+\n                this.series.name +': '+ this.y +'<br/>'+\n                'Total: '+ this.point.stackTotal;\n         }\n      },\n      plotOptions: {\n         column: {\n            stacking: 'normal'\n         }\n      },\n       series: [{\n         name: 'Shop',\n         data: [";
foreach ($_order as $key => $value) {
    echo $value["total"] . ",";
}
echo "]\n      }]\n   });\n   \n   \n});\n\t\t</script> \n\t\n\t<style>\n\t\t.pendingorder td{background: #f5f4f4;text-align: center;padding:10px 0}\n\t\t.pendingorder td h5{font-size: 12px;}\n\t\t.pendingorder td span{margin-right: 10px}\n        td.betterhover, #deshbordsub tbody tr:hover{background: #fdfde7;}\n        #deshbordsub tr td:first-child{background:none !important}\n        #deshbordsub tr td a span{display: block;}       \n\t</style>\n\t\t\n  <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\" width=\"1000px\">\n    <thead align=\"left\"><td></td></thead>\n    <tr align=\"left\"><td style=\"border-left: #edeced solid 1px !important; border-right: #edeced solid 1px !important;\"><div id=\"monthly\" style=\"height: 245px; width: 100%;\"></div> </strong></td></tr>    \n    </table>   \n    ";
$fileverioncheck = "6.1.0";

?>