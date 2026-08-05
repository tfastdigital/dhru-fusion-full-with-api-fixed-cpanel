<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/exporting.js\"></script>\n\n";
$pageid = 442;
checkPagePermission($pageid);
if (isset($currencys)) {
    $linked = $currencys;
} else {
    $sq = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
    $linked = $sq["id"];
}
echo "<script>\n    function filterby()\n    {\n        var currency=\$('select#currencys option:selected').val();\n        var month=\$('select#month option:selected').val();\n        location.href='main2.php?page=profitgraph&month='+month+'&currencys='+currency;\n    }\n</script>\n\nMonth:\n<select name=\"month\" id=\"month\" onchange=\"filterby()\">\n    ";
for ($i = 11; 0 <= $i; $i--) {
    $selected = "";
    $months = date("F Y", strtotime(date("Y-m-01") . " -" . $i . " months"));
    if ($month) {
        if ($month == $months) {
            $selected = "selected";
        }
    } else {
        if ($i == 0) {
            $selected = "selected";
        }
    }
    echo "        <option ";
    echo $selected;
    echo " value=\"";
    echo $months;
    echo "\">";
    echo $months;
    echo "</option>\n        ";
}
echo "</select>\n\nCurrency: <select name=\"currency\" id=\"currencys\" onchange=\"filterby()\">\n    ";
$q = dquery("select * from tbl_currencies order by FIELD(`default`,1,0)");
while ($r = mysqli_fetch_assoc($q)) {
    $selected = "";
    if ($currencys) {
        if ($currencys == $r["id"]) {
            $selected = "selected";
        }
    } else {
        if ($r["default"] == 1) {
            $selected = "selected";
        }
    }
    echo "        <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["code"];
    echo "</option>\n        ";
}
echo "</select>\n";
if ($month) {
    $first_date = date("Y-m-d", strtotime("first day of " . $month));
    $last_date = date("Y-m-d", strtotime("last day of " . $month));
} else {
    $first_date = date("Y-m-d", strtotime("first day of this month"));
    $last_date = date("Y-m-d", strtotime("last day of this month"));
}
$period = new DatePeriod(new DateTime($first_date), new DateInterval("P1D"), new DateTime($last_date));
$Graph = [];
foreach ($period as $key => $value) {
    $Graph[0][date("d", strtotime($value->format("Y-m-d")))] = 0;
    $Graph[1][date("d", strtotime($value->format("Y-m-d")))] = 0;
    $Graph[2][date("d", strtotime($value->format("Y-m-d")))] = 0;
    $Graph[3][date("d", strtotime($value->format("Y-m-d")))] = 0;
}
$sql = dquery("select `date`,`server`,sum(credit-discount-purchase_cost) as profit from tbl_order_imei where user_can_c=4 and currency_id='" . $linked . "' and purchase_cost>0 and date between '" . $first_date . "' and '" . $last_date . "' group by server,date");
while ($row = mysqli_fetch_assoc($sql)) {
    $Graph[$row["server"]][date("d", strtotime($row["date"]))] = $row["profit"];
}
$sql = dquery("select `date`,sum(credit-discount-purchase_cost) as profit from tbl_order_file where user_can_c=4 and currency_id='" . $linked . "' and purchase_cost>0 and date between '" . $first_date . "' and '" . $last_date . "' group by date");
while ($row = mysqli_fetch_assoc($sql)) {
    $Graph[3][date("d", strtotime($row["date"]))] = $row["profit"];
}
$background_colors = ["#2cbea5", "#313c42", "#ff5d53", "#eac651", "#094c61", "#4BADE8", "#72A421", "#7B1FA2", "#897B73", "#4375E0", "#BE360B"];
$Head = [];
foreach ($Graph as $sr => $details) {
    foreach ($details as $dt => $profit) {
        $Head[$dt] = $dt;
    }
}
$HeadString = "'" . implode("','", $Head) . "'";
echo "\n    <script type=\"text/javascript\">\n\n        \$(function () {\n            \$('#container').highcharts({\n                chart: {\n                    type: 'column',\n                    backgroundColor: 'transparent'\n                },\n                title: {\n                    text: 'Profite Graph',\n                    style: {\"color\": '#999999', \"fontSize\": \"18px\"}\n                },\n                legend: {\n                    layout: 'vertical',\n                    align: 'right',\n                    verticalAlign: 'top',\n                    x: 0,\n                    y: 0,\n                    floating: true,\n                    borderWidth: 1,\n                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'transparent',\n                    itemStyle: {\"color\": '#999999', \"fontSize\": \"12px\", \"fontWeight\": \"normal\"},\n                    navigation: {enabled: false}\n                },\n                xAxis: {\n                    categories: [\n                        ";
echo $HeadString;
echo "                    ],\n                    plotBands: [{\n                        from: 4.5,\n                        to: 6.5\n                    }]\n                },\n                yAxis: {\n                    title: {\n                        text: ''\n                    },\n                    stackLabels: {\n                        enabled: true,\n\n                    },\n                    gridLineColor: 'rgba(0,0,0,0.1)'\n                },\n                tooltip: {\n                    headerFormat: '<b>{point.x}</b><br/>',\n                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'\n                },\n                credits: {\n                    enabled: false\n                },\n                plotOptions: {\n                    column: {\n                        stacking: 'normal',\n                        dataLabels: {\n                            enabled: true\n                        }\n                    }\n                },\n                series: [\n                    ";
$index = 0;
foreach ($Graph as $server => $detail) {
    $GraphName = "";
    if ($server == 0) {
        $GraphName = "IMEI";
    } else {
        if ($server == 3) {
            $GraphName = "File";
        } else {
            if ($server == 1) {
                $GraphName = "Server";
            } else {
                if ($server == 2) {
                    $GraphName = "Remote";
                }
            }
        }
    }
    $GraphVals = [];
    foreach ($Head as $Date) {
        $GraphVals[$Date] = $detail[$Date] ? $detail[$Date] : "0";
    }
    $GraphValString = implode(",", $GraphVals);
    echo "                    {\n                        name: '";
    echo $GraphName;
    echo "',\n                        color: '";
    echo $background_colors[$index++];
    echo "',\n                        data: [";
    echo $GraphValString;
    echo "]\n                    },\n                    ";
}
echo "                ]\n            })\n        });\n\n\n    </script>\n\n    <div style=\"text-align: center;\">\n        <div id=\"container\" style=\"height: 350px; margin: 0 auto;\"></div>\n    </div>\n\n";
$fileverioncheck = "6.1.0";

?>