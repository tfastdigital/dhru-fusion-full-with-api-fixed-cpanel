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
echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\n<style>\n    #tabmenu{border-radius:0}\n</style>\n";
if (!$s) {
    echo "<ul id=\"tabmenu\"> \n<li><a class='tabmenu_active' onclick=\"getContect('#tab2','main2.php?page=stock','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["stock"];
    echo "</a></li>\n<li><a onclick=\"getContect('#tab','main2.php?page=stockproduct.detail&s=ok','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["sold"];
    echo " ";
    echo $LNG["stock"];
    echo "</a></li> \n<li><a onclick=\"getContect('#tab1','main2.php?page=stockproduct.order','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["stock"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li> \n   <div style=\"clear: both;\"></div>\n</ul>\n<br />\n<div id=\"tabcontent\">\n";
}
$serv = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $id . "'"));
$year = date("Y");
for ($i = 1; $i <= 12; $i++) {
    $j = $i;
    if (strlen($j) < 2) {
        $j = "0" . $j;
    }
    $cntr = mysqli_fetch_assoc(dquery("SELECT count(*) as cnt FROM \n    `tbl_order_product` WHERE (date\n     between '" . $year . "-" . $j . "-01' and '" . $year . "-" . $j . "-31') and service_id='" . $id . "' and user_can_c=4"));
    $out[$i] = $cntr["cnt"];
}
echo "   \n    \n<script type=\"text/javascript\">\nvar chart;\n\$(document).ready(function() {\n   chart = new Highcharts.Chart({\n      chart: {\n         renderTo: 'monthly',\n         defaultSeriesType: 'column'\n      },\n      title: {\n         text: '";
echo $serv["service_name"];
echo "'\n      },\n      xAxis: {\n         categories: ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']\n      },\n      yAxis: {\n         min: 0,\n         title: {\n            text: '";
echo $LNG["sold"];
echo "  ";
echo $LNG["stock"];
echo "'\n         }\n      },\n      legend: { \n         align: 'right',\n         x: 0,\n         verticalAlign: 'top',\n         y: 20,\n         floating: true,\n         backgroundColor:'#FFFFFF',\n         borderColor: '#CCC',\n         borderWidth: 1,\n         shadow: false\n      },\n      tooltip: {\n         formatter: function() {\n            return '<b>'+ this.x +'</b><br/> Sold '+\n                this.series.name +': '+ this.y ;\n         }\n      },\n      plotOptions: {\n         column: {\n            stacking: 'normal'\n         }\n      },\n       series: [{\n         name: 'Sold Stock',\n         data: [";
echo $out[1];
echo ",";
echo $out[2];
echo ",";
echo $out[3];
echo ",";
echo $out[4];
echo ",";
echo $out[5];
echo ",";
echo $out[6];
echo ",";
echo $out[7];
echo ",";
echo $out[8];
echo ",";
echo $out[9];
echo ",";
echo $out[10];
echo ",";
echo $out[11];
echo ",";
echo $out[12];
echo "]\n      }]\n   });\n   \n   \n});\n</script> \n\n<div id=\"monthly\" style=\"height: 350px; width: 800px;\"></div> \n ";
if (!$s) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>