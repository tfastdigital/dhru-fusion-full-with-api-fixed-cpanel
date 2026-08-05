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
$currency = getAllCurrency("code");
if ($onlymerchant) {
    $background_colors = ["#0846A6", "#FF9A1E", "#DC002F", "#076398", "#62BA3C", "#4BADE8", "#72A421", "#7B1FA2", "#897B73", "#4375E0", "#BE360B"];
    $i = 1;
    $startdate = date("Y") . "-01-01";
    $enddate = date("Y") . "-12-31";
    $sql = "select sum(fee) as total,MONTH(date) as month,(select code from tbl_currencies \r\nwhere tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid)) as code\r\nfrom tblTransferFee where (date between '" . $startdate . "' and '" . $enddate . "') \r\n group by MONTH(date)";
    $q = dquery($sql);
    while ($row = mysqli_fetch_assoc($q)) {
        $_order[1][$row["month"]][$row["code"]]["count"] = $row["total"];
    }
    foreach ($currency as $code => $e) {
        for ($j = 1; $j <= 12; $j++) {
            if (!$_order[$i][$j][$code]) {
                $_order[$i][$j][$code]["count"] = 0;
            }
        }
    }
    echo "    <script type=\"text/javascript\">\r\n        \$(function () {\r\n            \$('#container').highcharts({\r\n                chart: {\r\n                    type: 'areaspline',\r\n                    backgroundColor: 'transparent'\r\n                }, title: {\r\n                    text: '";
    echo $LNG["annual"];
    echo " ";
    echo $LNG["fee"];
    echo "',\r\n                    style: {\"color\": '#999999', \"fontSize\": \"18px\"}\r\n                },\r\n                legend: {\r\n                    layout: 'vertical',\r\n                    align: 'right',\r\n                    verticalAlign: 'top',\r\n                    x: 0,\r\n                    y: 0,\r\n                    floating: true,\r\n                    borderWidth: 1,\r\n                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'transparent',\r\n                    itemStyle: {\"color\": '#999999', \"fontSize\": \"12px\", \"fontWeight\": \"normal\"},\r\n                    navigation: {enabled: false}\r\n                },\r\n                xAxis: {\r\n                    categories: [\r\n                        'Jan',\r\n                        'Feb',\r\n                        'Mar',\r\n                        'Apr',\r\n                        'May',\r\n                        'Jun',\r\n                        'Jul',\r\n                        'Aug',\r\n                        'Sep',\r\n                        'Oct',\r\n                        'Nov',\r\n                        'Dec'\r\n                    ],\r\n                    plotBands: [{\r\n                        from: 4.5,\r\n                        to: 6.5\r\n                    }]\r\n                },\r\n                yAxis: {\r\n                    title: {\r\n                        text: ''\r\n                    },\r\n                    gridLineColor: 'rgba(0,0,0,0.1)'\r\n                },\r\n                tooltip: {\r\n                    shared: true,\r\n                    valueSuffix: ' Fee'\r\n                },\r\n                credits: {\r\n                    enabled: false\r\n                },\r\n                plotOptions: {\r\n                    areaspline: {\r\n                        fillOpacity: 1\r\n                    }\r\n                },\r\n                series: [\r\n                    ";
    $index = 0;
    foreach ($currency as $code => $detail) {
        echo "                    {\r\n                        name: '";
        echo $code;
        echo "',\r\n                        color: '";
        echo $background_colors[$index++];
        echo "',\r\n                        data: [";
        echo $_order[1][1][$code]["count"];
        echo ",";
        echo $_order[1][2][$code]["count"];
        echo ",";
        echo $_order[1][3][$code]["count"];
        echo ",";
        echo $_order[1][4][$code]["count"];
        echo ",";
        echo $_order[1][5][$code]["count"];
        echo ",";
        echo $_order[1][6][$code]["count"];
        echo ",";
        echo $_order[1][7][$code]["count"];
        echo ",";
        echo $_order[1][8][$code]["count"];
        echo ",";
        echo $_order[1][9][$code]["count"];
        echo ",";
        echo $_order[1][10][$code]["count"];
        echo ",";
        echo $_order[1][11][$code]["count"];
        echo ",";
        echo $_order[1][12][$code]["count"];
        echo "]\r\n                    },\r\n                       ";
    }
    echo "                   ]\r\n            })\r\n        });\r\n\r\n\r\n    </script>\r\n    ";
} else {
    $sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl\r\n    from tbl_order_imei WHERE year( date ) = year( now( ) ) and `server`='0' group by MONTH(date),user_can_c\r\n    union select count(*) as total,MONTH(date) as month,user_can_c,2\r\n    from tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),\r\n    user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3\r\n      from tbl_order_imei\r\n    WHERE year( date ) = year( now( ) ) and `server`='1' group by MONTH(date),\r\n    user_can_c\r\n    union select count(*) as total,MONTH(date) as month,user_can_c,4\r\n    from tbl_order_product WHERE year( date ) = year( now( ) )\r\n     group by MONTH(date),user_can_c ";
    $year = date("Y");
    if (is_file("../../tmp/graph.json")) {
        $GraphData = file_get_contents("../../tmp/graph.json");
        $GraphData = json_decode($GraphData, true);
        $currentmonth = date("m");
        unset($GraphData[1][$currentmonth]);
        unset($GraphData[2][$currentmonth]);
        unset($GraphData[3][$currentmonth]);
        unset($GraphData[4][$currentmonth]);
        $_order = $GraphData;
        $startdate = date("Y") . "-" . date("m") . "-01";
        $enddate = date("Y") . "-" . date("m") . "-31";
    } else {
        $startdate = date("Y-m-d", strtotime("-1 year", strtotime(date("Y-m-d"))));
        $enddate = date("Y-m-d");
    }
    $ArrMonth = [];
    $sql = "select count(order_id) as total,MONTH(date) as month,YEAR(date) as yr,user_can_c\r\nfrom tbl_order_imei where (date between '" . $startdate . "' and '" . $enddate . "') \r\nand `server`=0  group by MONTH(date),user_can_c";
    $result = dquery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrMonth[$row["month"] . " " . $row["yr"]] = $row["month"] . " " . $row["yr"];
        $_order[1][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
    }
    $sql = "select count(order_id) as total,MONTH(date) as month,YEAR(date) as yr,user_can_c\r\nfrom tbl_order_imei where (date between '" . $startdate . "' and '" . $enddate . "') \r\nand `server`=1  group by MONTH(date),user_can_c";
    $result = dquery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrMonth[$row["month"] . " " . $row["yr"]] = $row["month"] . " " . $row["yr"];
        $_order[3][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
    }
    $sql = "select count(order_id) as total,MONTH(date) as month,YEAR(date) as yr,user_can_c\r\nfrom tbl_order_file where (date between '" . $startdate . "' and '" . $enddate . "') \r\n group by MONTH(date),user_can_c";
    $result = dquery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrMonth[$row["month"] . " " . $row["yr"]] = $row["month"] . " " . $row["yr"];
        $_order[2][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
    }
    $sql = "select count(order_id) as total,MONTH(date) as month,YEAR(date) as yr,user_can_c\r\nfrom tbl_order_product where (date between '" . $startdate . "' and '" . $enddate . "') \r\ngroup by  MONTH(date),user_can_c";
    $result = dquery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrMonth[$row["month"] . " " . $row["yr"]] = $row["month"] . " " . $row["yr"];
        $_order[4][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
    }
    $sql = "select count(order_id) as total,MONTH(date) as month,YEAR(date) as yr,user_can_c\r\nfrom tbl_order_imei \r\nwhere (date between '" . $startdate . "' and '" . $enddate . "') and `server`=2  \r\ngroup by MONTH(date),YEAR(date),user_can_c";
    $result = dquery($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $_order[5][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
    }
    file_put_contents("../../tmp/graph.json", json_encode($_order));
    for ($i = 1; $i <= 5; $i++) {
        for ($j = 1; $j <= 12; $j++) {
            if (!$_order[$i][$j][4]) {
                $_order[$i][$j][4]["count"] = 0;
            }
        }
    }
    $months = [];
    $IMEIArrange = "";
    $FileArrange = "";
    $ServerArrange = "";
    $RemoteArrange = "";
    $ShopArrange = "";
    for ($i = 11; 0 <= $i; $i--) {
        $months[] = date("Y M", strtotime(date("Y-m-01") . " -" . $i . " months"));
        $IMEIArrange .= $_order[1][date("n", strtotime(date("Y-m-01") . " -" . $i . " months"))][4]["count"] . ",";
        $FileArrange .= $_order[2][date("n", strtotime(date("Y-m-01") . " -" . $i . " months"))][4]["count"] . ",";
        $ServerArrange .= $_order[3][date("n", strtotime(date("Y-m-01") . " -" . $i . " months"))][4]["count"] . ",";
        $RemoteArrange .= $_order[5][date("n", strtotime(date("Y-m-01") . " -" . $i . " months"))][4]["count"] . ",";
        $ShopArrange .= $_order[4][date("n", strtotime(date("Y-m-01") . " -" . $i . " months"))][4]["count"] . ",";
    }
    $IMEIArrange = trim($IMEIArrange, ",");
    $FileArrange = trim($FileArrange, ",");
    $ServerArrange = trim($ServerArrange, ",");
    $RemoteArrange = trim($RemoteArrange, ",");
    $ShopArrange = trim($ShopArrange, ",");
    echo "\r\n    <script type=\"text/javascript\">\r\n        \$(function () {\r\n            \$('#container').highcharts({\r\n                chart: {\r\n                    type: 'areaspline',\r\n                    backgroundColor: 'transparent'\r\n                }, title: {\r\n                    text: 'Last 12 months Orders',\r\n                    style: {\"color\": '#999999', \"fontSize\": \"18px\"}\r\n                },\r\n                legend: {\r\n                    layout: 'vertical',\r\n                    align: 'right',\r\n                    verticalAlign: 'top',\r\n                    x: 0,\r\n                    y: 0,\r\n                    floating: true,\r\n                    borderWidth: 1,\r\n                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'transparent',\r\n                    itemStyle: {\"color\": '#999999', \"fontSize\": \"12px\", \"fontWeight\": \"normal\"},\r\n                    navigation: {enabled: false}\r\n                },\r\n                xAxis: {\r\n                    categories: [\r\n                      ";
    echo "'" . implode("','", $months) . "'";
    echo "                    ],\r\n                    plotBands: [{\r\n                        from: 4.5,\r\n                        to: 6.5\r\n                    }]\r\n                },\r\n                yAxis: {\r\n                    title: {\r\n                        text: ''\r\n                    },\r\n                    gridLineColor: 'rgba(0,0,0,0.1)'\r\n                },\r\n                tooltip: {\r\n                    shared: true,\r\n                    valueSuffix: ' Orders'\r\n                },\r\n                credits: {\r\n                    enabled: false\r\n                },\r\n                plotOptions: {\r\n                    areaspline: {\r\n                        fillOpacity: 1\r\n                    }\r\n                },\r\n                series: [";
    if (!$OnlyEcommerce) {
        echo "{\r\n                    name: 'IMEI',\r\n                    color: '#2cbea5',\r\n                    data: [";
        echo $IMEIArrange;
        echo "]\r\n                }, {\r\n                    name: 'File',\r\n                    color: '#313c42',\r\n                    data: [";
        echo $FileArrange;
        echo "]\r\n                }, {\r\n                    name: 'Server',\r\n                    color: '#ff5d53',\r\n                    data: [";
        echo $ServerArrange;
        echo "]\r\n                }, {\r\n                    name: 'Remote',\r\n                    color: '#eac651',\r\n                    data: [";
        echo $RemoteArrange;
        echo "]\r\n                },";
    }
    echo " {\r\n                    name: 'Shop',\r\n                    color: '#094c61',\r\n                    data: [";
    echo $ShopArrange;
    echo "]\r\n                }]\r\n            })\r\n        });\r\n\r\n\r\n    </script>\r\n    ";
}
echo "\r\n    <div style=\"text-align: center;\">\r\n        <div id=\"container\" style=\"height: 350px; margin: 0 auto;\"></div>\r\n    </div>";
$fileverioncheck = "6.1.0";

?>