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
echo "\n\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/exporting.js\"></script>\n\n\n ";
$sql = "select count(*) as total,userstatus from tblUsers where usertype in(0,1) group by userstatus";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    if ($row["userstatus"] == 0) {
        $row["userstatus"] = "Active";
    } else {
        if ($row["userstatus"] == 1) {
            $row["userstatus"] = "Blocked";
        } else {
            if ($row["userstatus"] == 2) {
                $row["userstatus"] = "New Registered";
            }
        }
    }
    $_user[$row["userstatus"]] = $row["total"];
    $total += $row["total"];
}
echo "<script type=\"text/javascript\">\n    function initializeChart(){\n        chart = new Highcharts.Chart({\n            chart: {\n                renderTo: 'container',\n                plotBackgroundColor: null,\n                plotBorderWidth: null,\n                plotShadow: false\n            },\n            title: {\n                text: '";
echo $LNG["user"];
echo " - ";
echo $LNG["reseller"];
echo " ";
echo $LNG["account"];
echo " ";
echo $LNG["status"];
echo "'\n            },\n            tooltip: {\n                formatter: function() {\n                    return '<b>'+ this.point.name +'</b>: '+ this.y +'%';\n                }\n            },\n            plotOptions: {\n                pie: {\n                    allowPointSelect: true,\n                    cursor: 'pointer',\n                    dataLabels: {\n                        enabled: true,\n                        color: '#000000',\n                        connectorColor: '#000000',\n                        formatter: function() {\n                            return '<b>'+ this.point.name +'</b>: '+ this.y+' %';\n                        }\n                    }\n                }\n            },\n            series: [{\n                type: 'pie',\n                name: 'Browser share',\n                data: [\n                    ";
foreach ($_user as $key => $value) {
    $value = round($value * 100 / $total);
    echo "['" . $key . "'," . $value . "],";
}
echo "                ]\n            }]\n        });\n    }\n\n    var chart;\n\t\t\t\$(document).ready(function() {\n                initializeChart();\n\t\t\t});\n\n\t\t</script>\n\n<div id=\"container\"></div>\n\n<style>\n    #container {\n        max-width: 650px;\n        margin: 35px auto;\n    }\n</style>\n\n";
$fileverioncheck = "6.1.0";
echo "\n";

?>