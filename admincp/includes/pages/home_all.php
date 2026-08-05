<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\r\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\r\n<script src=\"includes/js/jquery.columnhover.js\" type=\"text/javascript\"></script>\r\n<script src=\"includes/js/chili.js\" type=\"text/javascript\"></script>\r\n<script>\r\n\$(document).ready(function() {\r\n    \$('#deshbordsub').columnHover({eachCell:true, hoverClass:'betterhover'});\r\n});\r\n\r\n</script>\r\n<style>\r\n.leftarrow,.rightarrow{height: 35px;width: 15px;display: block;margin-top: -4px;}\r\n.leftarrow{background: url('images/leftar.png') left center;}\r\n.rightarrow{background: url('images/rightar.png') right center;}\r\n.leftarrow:hover{background: url('images/leftar.png') right center;}\r\n.rightarrow:hover{background: url('images/rightar.png') left center;}\r\n</style>\r\n<div style=\"min-width: 980px;\">\r\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\r\n        ";
    echo $LNG["maintancemodeon"];
    echo "    </div>\r\n    ";
}
echo "\r\n";
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
$array = ["date='" . $today . "'", "from_unixtime(time,'%m')='" . $month . "' \r\n            and from_unixtime(time,'%Y')='" . $year . "'", "from_unixtime(time,'%Y')='" . $year . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(credit-discount) as income,currency_id from " . $tbl . " where " . $value . " and user_can_c='4' group by currency_id");
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income[$tbl]["income"] = $row["income"];
            $income[$tbl]["currency_id"] = $row["currency_id"];
            if (!$income[$tbl]["income"]) {
                $inc[$tbl] = 0;
            } else {
                $ctotal += convertCurrency($income[$tbl]["income"], $income[$tbl]["currency_id"], $defaultcurrency["id"]);
            }
        }
        $inc[$tbl] = $ctotal;
    }
    $inctbl[] = mysqli_fetch_assoc(dquery("select sum(" . $inc["tbl_order_imei"] . "+" . $inc["tbl_order_file"] . "+" . $inc["tbl_order_server"] . "+" . $inc["tbl_order_product"] . ") as income"));
}
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
$array = ["date='" . $yesterday . "'", "from_unixtime(time,'%m')='" . $pmonth . "' \r\n            and from_unixtime(time,'%Y')='" . $pyear . "'", "from_unixtime(time,'%Y')='" . $pyear . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(credit-discount) as income,currency_id from " . $tbl . " where " . $value . " and user_can_c='4' group by currency_id");
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income[$tbl]["income"] = $row["income"];
            $income[$tbl]["currency_id"] = $row["currency_id"];
            if (!$income[$tbl]["income"]) {
                $inc[$tbl] = 0;
            } else {
                $ctotal += convertCurrency($income[$tbl]["income"], $income[$tbl]["currency_id"], $defaultcurrency["id"]);
            }
        }
        $inc[$tbl] = $ctotal;
    }
    $inctbly[] = mysqli_fetch_assoc(dquery("select sum(" . $inc["tbl_order_imei"] . "+" . $inc["tbl_order_file"] . "+" . $inc["tbl_order_server"] . "+" . $inc["tbl_order_product"] . ") as income"));
}
$condition = [" date='" . $today . "' and (1=1)", " date='" . $today . "' and (user_can_c='0' or user_can_c='1')", " reply_date='" . $today . "' and (user_can_c='4')", "verified='1'", " date='" . $yesterday . "' and (1=1)", " date='" . $yesterday . "' and (user_can_c='0' or user_can_c='1')", " reply_date='" . $yesterday . "' and ( user_can_c='4')", "from_unixtime(time,'%m')='" . $month . "' and from_unixtime(time,'%Y')='" . $year . "'", "from_unixtime(time,'%Y')='" . $year . "'"];
foreach ($condition as $cnd) {
    foreach ($table as $tbl) {
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd));
        if (!$ord["total"]) {
            $order[$tbl][] = "<span class=textwhite bold>" . $ord["total"] . "</label>";
        } else {
            $order[$tbl][] = $ord["total"];
        }
    }
}
$todayireject = mysqli_num_rows(dquery("select order_id from tbl_order_imei where reply_date='" . $today . "' and (user_can_c='3')"));
$todayfreject = mysqli_num_rows(dquery("select order_id from tbl_order_file where reply_date='" . $today . "' and (user_can_c='3')"));
$todaysreject = mysqli_num_rows(dquery("select order_id from tbl_order_server where reply_date='" . $today . "' and (user_can_c='3')"));
$todaypreject = mysqli_num_rows(dquery("select order_id from tbl_order_product where reply_date='" . $today . "' and (user_can_c='3')"));
$yesireject = mysqli_num_rows(dquery("select order_id from tbl_order_imei where reply_date='" . $yesterday . "' and (user_can_c='3')"));
$yesfreject = mysqli_num_rows(dquery("select order_id from tbl_order_file where reply_date='" . $yesterday . "' and (user_can_c='3')"));
$yessreject = mysqli_num_rows(dquery("select order_id from tbl_order_server where reply_date='" . $yesterday . "' and (user_can_c='3')"));
$yespreject = mysqli_num_rows(dquery("select order_id from tbl_order_product where reply_date='" . $yesterday . "' and (user_can_c='3')"));
echo "\r\n\r\n<div align=\"center\" style=\"border: 2px dashed #CCC; padding: 8px; margin: 5px;\">\r\n<!--\r\n<select>\r\n";
$result = dquery("select code,id from tbl_currencies");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value=" . $row["id"] . ">" . $row["code"] . "</option>";
}
echo "</select>\r\n-->\r\n<script>\r\nfunction showHid(v){\r\n       if(v=='todays'){\r\n            document.getElementById('yesterdays').style.display='';\r\n            document.getElementById('todays').style.display='none';\r\n       }else{\r\n            document.getElementById('yesterdays').style.display='none';\r\n            document.getElementById('todays').style.display='';\r\n       }\r\n}\r\n</script>\r\n    <span style=\"font-size: 18px; color: #666 !important;\" id=\"todays\">\r\n        <div style='float: left;'><a style=\"text-decoration: none;\" title=\"Yesterday / Last Month / Last Year\" onclick=\"javascript:showHid('todays');\"  class=\"leftarrow\"></a></div> ";
echo $LNG["income"];
echo " ";
echo $LNG["today"];
echo " : <strong>";
echo formatCurrency($inctbl[0]["income"]);
echo "</strong> | ";
echo $LNG["this"];
echo " ";
echo $LNG["month"];
echo " : <strong>";
echo formatCurrency($inctbl[1]["income"]);
echo "</strong> | ";
echo $LNG["this"];
echo " ";
echo $LNG["year"];
echo ": <strong>";
echo formatCurrency($inctbl[2]["income"]);
echo "</strong>\r\n    </span>\r\n    <span style=\"font-size: 18px; color: #666 !important; display:none;\" id=\"yesterdays\">\r\n      ";
echo $LNG["income"];
echo " ";
echo $LNG["yesterday"];
echo " : <strong>";
echo formatCurrency($inctbly[0]["income"]);
echo "</strong>\r\n    | ";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo " : <strong>";
echo formatCurrency($inctbly[1]["income"]);
echo "</strong> |\r\n    ";
echo $LNG["last"];
echo " ";
echo $LNG["year"];
echo ": <strong>";
echo formatCurrency($inctbly[2]["income"]);
echo "</strong>\r\n   <div style='float: right;' ><a  style=\"text-decoration: none;\"  onclick=\"javascript:showHid('yesterdays');\" class=\"rightarrow\"></a></div>\r\n    </span>\r\n</div>\r\n<br />\r\n<style>\r\n#deshbordsub{width: 97%;}\r\n#deshbordsub a {color: gray; text-decoration: none;}#deshbordsub a:hover{text-decoration: underline;}\r\n#deshbordsub td {border-bottom: solid #edeced 1px  ; }\r\nhr{border-color: #CCCCCC;border-right: 0 none; border-style: solid none none; border-width: 1px 0 0; display: block; height: 1px;margin: 1em 0;padding: 0;}\r\n.textwhite{color: #edeced !important;}\r\n</style>\r\n\r\n<table><tbody><tr>\r\n\t<td width=\"45%\" valign=\"top\">\r\n        <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\">\r\n            <thead align=\"left\">\r\n            <td><strong>";
echo $LNG["order"];
echo " ";
echo $LNG["summary"];
echo " </strong></td>\r\n            <td align=\"center\"><strong>";
echo $LNG["imei"];
echo "</strong></td>\r\n            <td align=\"center\"><strong>";
echo $LNG["file"];
echo "</strong></td>\r\n            <td align=\"center\"><strong>";
echo $LNG["server"];
echo "</strong></td>\r\n            <td align=\"center\"><strong>";
echo $LNG["shop"];
echo "</strong></td>\r\n            </thead>\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/shop.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["orders"];
echo "</td>\r\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_imei"][0];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_file"][0];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_server"][0];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_product"][0];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/pending.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["pending"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('imeiorder','');\" >";
echo $order["tbl_order_imei"][1];
echo "</a></span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('fileorder','');\" >";
echo $order["tbl_order_file"][1];
echo "</a></span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('serverorder','');\" >";
echo $order["tbl_order_server"][1];
echo "</a></span></td>\r\n                    <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('productorder','');\" >";
echo $order["tbl_order_product"][1];
echo "</a></span></td>\r\n            </tr>\r\n\r\n\t\t\t<tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["rejected"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textred bold\">";
echo $todayireject;
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $todayfreject;
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $todaysreject;
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $todaypreject;
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["completed"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_imei"][2];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_file"][2];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_server"][2];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_product"][2];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/maintance.png\" /> ";
echo $LNG["order"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["verification"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textred bold\">";
echo $order["tbl_order_imei"][3];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $order["tbl_order_file"][3];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $order["tbl_order_server"][3];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $order["tbl_order_product"][3];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["orders"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_imei"][4];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_file"][4];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_server"][4];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_product"][4];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["pending"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('imeiorder','');\" >";
echo $order["tbl_order_imei"][5];
echo "</a></span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('fileorder','');\" >";
echo $order["tbl_order_file"][5];
echo "</a></span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('serverorder','');\" >";
echo $order["tbl_order_server"][5];
echo "</a></span></td>\r\n                    <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('productorder','');\" >";
echo $order["tbl_order_product"][5];
echo "</a></span></td>\r\n            </tr>\r\n\r\n\r\n\r\n\t\t\t<tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["rejected"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textred bold\">";
echo $yesireject;
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $yesfreject;
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textred bold\">";
echo $yessreject;
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $yespreject;
echo "</span></td>\r\n            </tr>\r\n\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["completed"];
echo " </td>\r\n            <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_imei"][6];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_file"][6];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_server"][6];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_product"][6];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/total.png\" /> ";
echo $LNG["month"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["date"];
echo " ";
echo $LNG["total"];
echo "</td>\r\n            <td align=\"center\"><span class=\"textorange bold\">";
echo $order["tbl_order_imei"][7];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textorange bold\">";
echo $order["tbl_order_file"][7];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textorange bold\">";
echo $order["tbl_order_server"][7];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textorange bold\">";
echo $order["tbl_order_product"][7];
echo "</span></td>\r\n            </tr>\r\n\r\n            <tr align=\"left\"><td><img src=\"templates/default/images1/total.png\" /> ";
echo $LNG["year"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["date"];
echo " ";
echo $LNG["total"];
echo " </td>\r\n            <td align=\"center\"><span class=\"textblack bold\">";
echo $order["tbl_order_imei"][8];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblack bold\">";
echo $order["tbl_order_file"][8];
echo "</span></td>\r\n            \t\t<td align=\"center\"><span class=\"textblack bold\">";
echo $order["tbl_order_server"][8];
echo "</span></td>\r\n                    <td align=\"center\"><span class=\"textblack bold\">";
echo $order["tbl_order_product"][8];
echo "</span></td>\r\n            </tr>\r\n        </table>\r\n\t</td>\r\n\t<td align=\"right\" width=\"60%\" valign=\"top\">\r\n\r\n ";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  from tbl_order_imei WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,2  from tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3  from tbl_order_server WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,4  from tbl_order_product WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
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
echo "\r\n\t<script type=\"text/javascript\">\r\nvar chart;\r\n\$(document).ready(function() {\r\n   chart = new Highcharts.Chart({\r\n      chart: {\r\n         renderTo: 'monthly',\r\n         defaultSeriesType: 'column'\r\n      },\r\n      title: {\r\n         text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\r\n      },\r\n      xAxis: {\r\n         categories: ['Jan', 'Feb', 'Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']\r\n      },\r\n      yAxis: {\r\n         min: 0,\r\n         title: {\r\n            text: '";
echo $LNG["total"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "'\r\n         }\r\n      },\r\n      legend: {\r\n         align: 'right',\r\n         x: 0,\r\n         verticalAlign: 'top',\r\n         y: 20,\r\n         floating: true,\r\n         backgroundColor:'#FFFFFF',\r\n         borderColor: '#CCC',\r\n         borderWidth: 1,\r\n         shadow: false\r\n      },\r\n      tooltip: {\r\n         formatter: function() {\r\n            return '<b>'+ this.x +'</b><br/>'+\r\n                this.series.name +': '+ this.y +'<br/>'+\r\n                'Total: '+ this.point.stackTotal;\r\n         }\r\n      },\r\n      plotOptions: {\r\n         column: {\r\n            stacking: 'normal'\r\n         }\r\n      },\r\n       series: [{\r\n         name: 'IMEI',\r\n         data: [";
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
echo "]\r\n      },{\r\n         name: 'File',\r\n         data: [";
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
echo "]\r\n      }, {\r\n         name: 'Server Log',\r\n         data: [";
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
echo "]\r\n      }, {\r\n         name: 'Shop',\r\n         data: [";
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
echo "]\r\n      }]\r\n   });\r\n\r\n\r\n});\r\n\t\t</script>\r\n\r\n\t<style>\r\n\t\t.pendingorder td{background: #f5f4f4;text-align: center;padding:10px 0}\r\n\t\t.pendingorder td h5{font-size: 12px;}\r\n\t\t.pendingorder td span{margin-right: 10px}\r\n        td.betterhover, #deshbordsub tbody tr:hover{background: #fdfde7;}\r\n        #deshbordsub tr td:first-child{background:none !important}\r\n        #deshbordsub tr td a span{display: block;}\r\n\t</style>\r\n\r\n  <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\" width=\"600px\">\r\n    <thead align=\"left\"><td><strong>";
echo $LNG["completed"];
echo " ";
echo $LNG["order"];
echo " </strong></td></thead>\r\n    <tr align=\"left\"><td style=\"border-left: #edeced solid 1px !important; border-right: #edeced solid 1px !important;\"><div id=\"monthly\" style=\"height: 245px; width: 600px;\"></div> </strong></td></tr>\r\n    </table>\r\n\r\n";
$cntin = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='0'"));
$cntfn = mysqli_num_rows(dquery("select order_id from tbl_order_file where user_can_c='0'"));
$cntsn = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='0'"));
$cntpn = mysqli_num_rows(dquery("select order_id from tbl_order_product where user_can_c='0'"));
$cntia = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='1'"));
$cntfa = mysqli_num_rows(dquery("select order_id from tbl_order_file where user_can_c='1'"));
$cntsa = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='1'"));
$cntpa = mysqli_num_rows(dquery("select order_id from tbl_order_product where user_can_c='1'"));
echo "  <table class=\"pendingorder\" id=\"deshbordsub\" width=\"600px\">\r\n  \t<tr><td><h5 style=\"text-align: left\">Pending New</h5>\r\n  \t<span  class=\"imeiservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('imeiquickaccept','";
echo $cntin;
echo "')\">IMEI - ";
echo $cntin;
echo "</a></span>\r\n  \t<span  class=\"fileservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('filequickaccept','";
echo $cntin;
echo "')\">File - ";
echo $cntfn;
echo "</a></span>\r\n  \t<span  class=\"serverservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('serverquickaccept','";
echo $cntin;
echo "')\">Server - ";
echo $cntsn;
echo "</a></span>\r\n  \t<span  class=\"catalog\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('productorder.new','";
echo $cntin;
echo "')\">Shop - ";
echo $cntpn;
echo "</a></span></td> <td>\r\n\r\n  \t<h5 style=\"text-align: left\">Pending Accepted</h5>\r\n  \t<span  class=\"imeiservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('quickreply','";
echo $cntin;
echo "')\">IMEI - ";
echo $cntia;
echo "</a></span>\r\n  \t<span  class=\"fileservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('fileorder.repllied','";
echo $cntin;
echo "')\">File - ";
echo $cntfa;
echo "</a></span>\r\n  \t<span  class=\"serverservice\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('serverorder.replied','";
echo $cntin;
echo "')\">Server - ";
echo $cntsa;
echo "</a></span>\r\n  \t<span  class=\"catalog\">\r\n  \t<a class='default_dg_a' href=\"javascript:redirectedit('productorder.replied','";
echo $cntin;
echo "')\">Shop - ";
echo $cntpa;
echo "</a></span>\r\n\r\n      </td></tr>\r\n<tr>\r\n<td colspan=\"2\" style=\"text-align: left;\">\r\n<a href=\"javascript: load_subpage('main2.php?page=ebayorder','Direct Order Link');\">\r\n";
echo $LNG["direct"];
echo " ";
echo $LNG["order"];
echo "  ";
echo $LNG["link"];
echo "</a></td>\r\n</tr>\r\n  </table>\r\n    </td>\r\n</tr></tbody></table>\r\n<br />\r\n<ul id=\"tabmenu\">\r\n<li><a class='tabmenu_active' onClick=\"getContect('#tab1','main2.php?page=dashboard.topservice','','','#tabcontent',true,'#main_loader');\"  id=\"tab1\" >";
echo $LNG["top"];
echo " 10 ";
echo $LNG["selling"];
echo " ";
echo $LNG["services"];
echo "</a></li>\r\n<li><a onclick=\"getContect('#tab2','main2.php?page=dashboard.happyhours','','','#tabcontent',true,'#main_loader');\"  id=\"tab2\" >";
echo $LNG["happyhours"];
echo " ";
echo $LNG["service"];
echo "</a></li>\r\n<li><a onClick=\"getContect('#tab3','main2.php?page=dashboard.mostviewable','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["mostviewable"];
echo " ";
echo $LNG["products"];
echo "</a></li>\r\n<li><a onClick=\"getContect('#tab5','main2.php?page=dashboard.apistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >APi ";
echo $LNG["status"];
echo "</a></li>\r\n";
if (!$fusionlite) {
    echo "<li><a onClick=\"getContect('#tab4','main2.php?page=dashboard.twitterfeed','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >DHRU ";
    echo $LNG["news"];
    echo "</a></li>\r\n";
}
echo "<div style=\"clear: both;\"></div>\r\n</ul>\r\n<div id=\"tabcontent\">\r\n";
if (!$sub) {
    include "dashboard.topservice.php";
} else {
    include $sub . ".php";
}
echo "</div>\r\n\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>