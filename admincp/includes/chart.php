<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!connection_status()) {
    define("DEFINE_MY_ACCESS", 1);
    define("DEFINE_DHRU_FILE", true);
    require "configs/config.php";
    require_once "class/Database.class.php";
    require_once "class/configer.php";
    $db = new Database($config["server"], $config["user"], $config["pass"], $config["database"], $config["tablePrefix"]);
    $db->connect();
}
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h2>Session expired. <a href=\"../index.php\">Please relogin</a></h2></div>";
    exit;
}
$sql = "SELECT count( *  ) AS total, tbl_services_imei.service_name AS name\nFROM `tbl_order_imei` , tbl_services_imei\nWHERE tbl_services_imei.id = tbl_order_imei.service_id and user_id='" . $_SESSION["User_ID"] . "'\nGROUP BY tbl_order_imei.service_id\nORDER BY total DESC limit 0,7";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_service["name"] = $row["name"];
    $_service["total"] = $row["total"];
    $service[] = $_service;
}
echo "\n\t\t<script type=\"text/javascript\">\n\t\tvar chart;\n\t\t\$(document).ready(function() {\n\t\t\tchart = new Highcharts.Chart({\n\t\t\t\tchart: {\n\t\t\t\t\trenderTo: 'top_imei',\n\t\t\t\t\tdefaultSeriesType: 'column',\n\t\t\t\t\tmargin: [ 50, 50, 150, 80]\n\t\t\t\t},\n\t\t\t\ttitle: {\n\t\t\t\t\ttext: 'Top imei orders'\n\t\t\t\t},\n\t\t\t\txAxis: {\n\t\t\t\t\tcategories: [\n\t\t\t\t\t\t\t\t ";
foreach ($service as $value) {
    echo "'" . $value["name"] . "',";
}
echo "\t\t\t\t\t\t\t\t],\n\t\t\t\t\tlabels: {\n\t\t\t\t\t\trotation: -90,\n\t\t\t\t\t\talign: 'right',\n\t\t\t\t\t\tstyle: {\n\t\t\t\t\t\t\t font: 'normal 11px Verdana, sans-serif'\n\t\t\t\t\t\t}\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tyAxis: {\n\t\t\t\t\tmin: 0,\n\t\t\t\t\ttitle: {\n\t\t\t\t\t\ttext: 'Number of orders'\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tlegend: {\n\t\t\t\t\tenabled: false\n\t\t\t\t},\n\t\t\t\tcredits: {\n\t\t\t\t\tenabled: false\n\t\t\t\t},\n\t\t\t\ttooltip: {\n\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\treturn '<b>'+ this.x +'</b><br/>'+\n\t\t\t\t\t\t\t ''+ Highcharts.numberFormat(this.y, 1) +\n\t\t\t\t\t\t\t '';\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t        series: [{\n\t\t\t\t\tname: 'Population',\n\t\t\t\t\tdata: [\n\t\t\t\t\t\t\t\t ";
foreach ($service as $value) {
    echo $value["total"] . ",";
}
echo "\t\t\t\t\t\t   ],\n\t\t\t\t\tdataLabels: {\n\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\trotation: -90,\n\t\t\t\t\t\tcolor: '#FFFFFF',\n\t\t\t\t\t\talign: 'right',\n\t\t\t\t\t\tx: -3,\n\t\t\t\t\t\ty: 10,\n\t\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\t\treturn this.y;\n\t\t\t\t\t\t},\n\t\t\t\t\t\tstyle: {\n\t\t\t\t\t\t\tfont: 'normal 13px Verdana, sans-serif'\n\t\t\t\t\t\t}\n\t\t\t\t\t}\t\t\t\n\t\t\t\t}]\n\t\t\t});\n\t\t});\n\t\t</script>        \n \n ";
$query = "SELECT count(*) as total,user_can_c FROM `tbl_order_imei` where user_id=" . $_SESSION["User_ID"] . " group by user_can_c";
$result = dquery($query);
while ($row = mysqli_fetch_assoc($result)) {
    $imei[$row["user_can_c"]] = $row["total"];
}
if (!$imei[0]) {
    $imei[0] = "0";
}
if (!$imei[1]) {
    $imei[1] = "0";
}
if (!$imei[3]) {
    $imei[3] = "0";
}
if (!$imei[4]) {
    $imei[4] = "0";
}
$query = "SELECT count(*) as total,user_can_c FROM `tbl_order_file` where user_id=" . $_SESSION["User_ID"] . " group by user_can_c";
$result = dquery($query);
while ($row = mysqli_fetch_assoc($result)) {
    $file[$row["user_can_c"]] = $row["total"];
}
if (!$file[0]) {
    $file[0] = "0";
}
if (!$file[1]) {
    $file[1] = "0";
}
if (!$file[3]) {
    $file[3] = "0";
}
if (!$file[4]) {
    $file[4] = "0";
}
$query = "SELECT count(*) as total,user_can_c FROM `tbl_order_server` where user_id=" . $_SESSION["User_ID"] . " group by user_can_c";
$result = dquery($query);
while ($row = mysqli_fetch_assoc($result)) {
    $server[$row["user_can_c"]] = $row["total"];
}
if (!$server[0]) {
    $server[0] = "0";
}
if (!$server[1]) {
    $server[1] = "0";
}
if (!$server[3]) {
    $server[3] = "0";
}
if (!$server[4]) {
    $server[4] = "0";
}
echo "\n\n<script type=\"text/javascript\">\n\t\tvar chart;\n\t\t\$(document).ready(function() {\n\t\t\tchart = new Highcharts.Chart({\n\t\t\t\tchart: {\n\t\t\t\t\trenderTo: 'order_details',\n\t\t\t\t\tdefaultSeriesType: 'bar'\n\t\t\t\t},\n\t\t\t\ttitle: {\n\t\t\t\t\ttext: 'Order Details'\n\t\t\t\t},\t\t\t\n\t\t\t\txAxis: {\n\t\t\t\t\tcategories: ['Pending', 'Available', 'Rejected'],\n\t\t\t\t\ttitle: {\n\t\t\t\t\t\ttext: null\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tyAxis: {\n\t\t\t\t\tmin: 0,\n\t\t\t\t\ttitle: {\n\t\t\t\t\t\ttext: '',\n\t\t\t\t\t\talign: 'high'\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\ttooltip: {\n\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\treturn '<b>'+ this.x +'</b><br/>'+\n\t\t\t\t\t\t\t this.series.name +': '+ this.y +' order';\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tplotOptions: {\n\t\t\t\t\tbar: {\n\t\t\t\t\t\tdataLabels: {\n\t\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\t\tcolor: 'auto'\n\t\t\t\t\t\t}\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tlegend: {\n\t\t\t\t\tlayout: 'horizontal',\n\t\t\t\t\tstyle: {\n\t\t\t\t\t\tleft: 'auto',\n\t\t\t\t\t\tbottom: 'auto',\n\t\t\t\t\t\tright: '40px',\n\t\t\t\t\t\ttop: '252px'\n\t\t\t\t\t},\n\t\t\t\t\tborderWidth: 1,\n\t\t\t\t\tbackgroundColor: '#FFFFFF'\n\t\t\t\t},\n\t\t\t\tcredits: {\n\t\t\t\t\tenabled: false\n\t\t\t\t},\n\t\t\t        series: [{\n\t\t\t\t\tname: 'IMEI',\n\t\t\t\t\tdata: [";
echo $imei[0] . "+" . $imei[1] . ",";
echo $imei[4] . ",";
echo (string) $imei[3];
echo "]\n\t\t\t\t}, {\n\t\t\t\t\tname: 'File',\n\t\t\t\t\tdata: [";
echo $file[0] . ",";
echo $file[4] . ",";
echo (string) $file[3];
echo "]\n\t\t\t\t}, {\n\t\t\t\t\tname: 'Server',\n\t\t\t\t\tdata: [";
echo $server[0] . ",";
echo $server[4] . ",";
echo (string) $server[3];
echo "]\n\t\t\t\t}]\n\t\t\t});\n\t\t\t\n\t\t\t\n\t\t});\n\t\t</script>\n        \n        \n ";
$sql = "SELECT credit_left,credit_used,credit_inprocess from tblUsers where id=" . $_SESSION["User_ID"];
$result = dquery($sql);
if ($row = mysqli_fetch_assoc($result)) {
    $left = $row["credit_left"] * 100 / ($row["credit_left"] + $row["credit_used"]);
    $used = $row["credit_used"] * 100 / ($row["credit_left"] + $row["credit_used"]);
    $process = $row["credit_inprocess"] * 100 / ($row["credit_inprocess"] + $row["credit_used"]);
    if ($row["credit_used"] == 0) {
        $used = 0;
    }
    if ($row["credit_left"] == 0) {
        $left = 0;
    }
    if ($row["credit_inprocess"] == 0) {
        $process = 0;
    }
}
echo "       \n        \n        <script type=text/javascript>\n\t\tvar chart;\n\t\t\$(document).ready(function() {\n\t\t\tchart = new Highcharts.Chart({\n\t\t\t\tchart: {\n\t\t\t\t\trenderTo: 'credit_details',\n\t\t\t\t\tmargin: [25, 10, 35, 10]\n\t\t\t\t},\n\t\t\t\ttitle: {\n\t\t\t\t\ttext: 'Credit Details'\n\t\t\t\t},\n\t\t\t\tplotArea: {\n\t\t\t\t\tshadow: null,\n\t\t\t\t\tborderWidth: null,\n\t\t\t\t\tbackgroundColor: null\n\t\t\t\t},\n\t\t\t\ttooltip: {\n\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\treturn '<b>'+ this.point.name +'</b>: '+ this.y +' %';\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tplotOptions: {\n\t\t\t\t\tpie: {\n\t\t\t\t\t\tallowPointSelect: true,\n\t\t\t\t\t\tdataLabels: {\n\t\t\t\t\t\t\tenabled: true,\n\t\t\t\t\t\t\tformatter: function() {\n\t\t\t\t\t\t\t\tif (this.y > 5) return this.point.name;\n\t\t\t\t\t\t\t},\n\t\t\t\t\t\t\tcolor: 'white',\n\t\t\t\t\t\t\tstyle: {\n\t\t\t\t\t\t\t\tfont: '13px Trebuchet MS, Verdana, sans-serif'\n\t\t\t\t\t\t\t}\n\t\t\t\t\t\t}\n\t\t\t\t\t}\n\t\t\t\t},\n\t\t\t\tlegend: {\n\t\t\t\t\tlayout: 'horizontal',\n\t\t\t\t\tstyle: {\n\t\t\t\t\t\tleft: 'auto',\n\t\t\t\t\t\tbottom: 'auto',\n\t\t\t\t\t\tright: '40px',\n\t\t\t\t\t\ttop: '252px'\n\t\t\t\t\t},\n\t\t\t\t\tborderWidth: 1,\n\t\t\t\t\tbackgroundColor: '#FFFFFF'\n\t\t\t\t},\n\t\t\t\tcredits: {\n\t\t\t\t\tenabled: false\n\t\t\t\t},\n\n\n\t\t\t\n\t\t\t    series: [{\n\t\t\t\t\ttype: 'pie',\n\t\t\t\t\tname: 'Browser share',\n\t\t\t\t\tdata: [\n\t\t\t\t\t\n\t\t\t\t\t['Left', ";
echo round($left, 0);
echo "],['Used', ";
echo round($used, 0);
echo "],['Process', ";
echo round($process, 0);
echo "],\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\n\t\t\t\t\t\t\n\t\t\t\t\t]\n\t\t\t\t\t\n\t\t\t\t}]\n\t\t\t});\n\t\t\t\n\t\t\t\n\t\t});\n\t\t</script>\n";
$fileverioncheck = "6.1.0";
echo "  ";

?>