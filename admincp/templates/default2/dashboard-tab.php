<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div title=\"dashboard\" id=\"tutid\"></div>\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\n        ";
    echo $LNG["maintancemodeon"];
    echo "         \n    </div>\n    ";
}
$defaultprogress = 3;
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$table = ["tbl_invoices"];
$array = ["UNIX_TIMESTAMP(datepaid)='" . $today . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%m')='" . $month . "' \n            and from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(total) as income from " . $tbl . " where " . $value);
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income[$tbl]["income"] = $row["income"];
            $ctotal += $income[$tbl]["income"];
        }
        $inc[$tbl] = $ctotal;
    }
    $inctbl[] = mysqli_fetch_assoc(dquery("select sum(" . $inc["tbl_invoices"] . ") as income"));
}
$array = ["UNIX_TIMESTAMP(datepaid)='" . $yesterday . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%m')='" . $pmonth . "'\n              and from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $pyear . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(total) as income from " . $tbl . " where " . $value);
        $ctotal = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $income[$tbl]["income"] = $row["income"];
            $ctotal += $income[$tbl]["income"];
        }
        $inc[$tbl] = $ctotal;
    }
    $inctbly[] = mysqli_fetch_assoc(dquery("select sum(" . $inc["tbl_invoices"] . ") as income"));
}
echo "     \n  \n  \n";
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server", "tbl_order_product"];
$condition = [" user_can_c='4'", " 1=1"];
foreach ($condition as $cnd) {
    foreach ($table as $tbl) {
        $per = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd));
        $performance[$tbl][] = $per["total"];
    }
}
$condition = [" userstatus='0'", " 1=1"];
foreach ($condition as $cnd) {
    $per = mysqli_fetch_assoc(dquery("select count(*) as total from tblUsers where " . $cnd));
    $performance["tbl_user"][] = $per["total"];
}
foreach ($performance as $key => $value) {
    $totalper += $value[0];
    $total += $value[1];
}
$totalper1 = round(100 * $totalper / $total, 0);
$totaldeg = round(180 * $totalper / $total, 0);
echo "  \n<div style=\"display: none !important;\" class=\"preload\">\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v2.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v3.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v4.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v5.png\" class=\"v5\" />\n</div>\n\n<div style=\"margin-top: -35px;\">\n    <div class=\"floatleft\" style=\"width:23%\">\n";
if (!$config["litedashboard"]) {
    echo "    \n        <div style=\"text-align: center;\" class=\"performance\">              \n            <span style=\"font-size: 16px;color:#888\">System Performance</span><br />       \n            <span style=\"font-size: 45px;font-weight: bold;color:#888\">";
    echo $totalper1;
    echo "%</span>\n               <div style=\"position: relative;width:200px;margin: auto;\"> \n                    <img src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/images/progressbar.png\" class=\"progress\"/>\n                    <div style=\"position: absolute;top:70px;width:100%;background:white;height:80px;font-size:12px;color:#888;text-shadow:0 1px 1px white\"><br/>By Completed Orders <br/>and<br/>By Active Users \n                         <ul class=\"iper\">\n                            <li>IMEI completed Order <span>";
    echo $performance["tbl_order_imei"][0];
    echo "/";
    echo $performance["tbl_order_imei"][1];
    echo "</span></li>                    \n                            <li>File complated Order <span>";
    echo $performance["tbl_order_file"][0];
    echo "/";
    echo $performance["tbl_order_file"][1];
    echo "</span></li>\n                            <li>Server complated Order <span>";
    echo $performance["tbl_order_server"][0];
    echo "/";
    echo $performance["tbl_order_server"][1];
    echo "</span></li>\n                            <li>shop complated Order <span>";
    echo $performance["tbl_order_product"][0];
    echo "/";
    echo $performance["tbl_order_product"][1];
    echo "</span></li>\n                            <li>Active Users <span>";
    echo $performance["tbl_user"][0];
    echo "/";
    echo $performance["tbl_user"][1];
    echo "</span></li>                \n                         </ul>                \n                     </div>\n               </div>                     \n        </div>\n";
} else {
    echo "<span class='disabledesign'>Disabled</span>";
}
echo "        \n    </div>\n    \n\n";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  \nfrom tbl_order_imei WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c \nunion select count(*) as total,MONTH(date) as month,user_can_c,2  \nfrom tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),\nuser_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3  from tbl_order_server \nWHERE year( date ) = year( now( ) ) group by MONTH(date),\nuser_can_c union select count(*) as total,MONTH(date) as month,\nuser_can_c,4  from tbl_order_product WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c";
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
echo "\n<link href=\"templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.css\" media=\"screen\" rel=\"stylesheet\"/>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/dashboard.js\"></script>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n<div class=\"colm2 floatleft\" style=\"border-left: #e0e0e0 solid 1px;border-right:#e0e0e0 solid 1px;width:52%\">\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/jQueryRotate.2.2.js\"></script>\n    \n        <div style=\"text-align: center;\">            \n            <div id=\"container\" style=\"height: 220px; margin: 0 auto\"></div>\n        </div>\n    </div>\n \n  \n    \n    <div class=\"floatright\" style=\"width:23%\">\n        <div style=\"text-align: center;position: relative;width:210px;margin:auto\" class=\"income\" id=\"today\">\n                 \n         \n            <span style=\"font-size: 16px;color:#888\">";
echo $LNG["income"];
echo "</span>\n            <br />                        \n            <h2 style=\"font-size: 40px;\" class=\"todays view\">";
echo $inctbl[0]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo " </span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["today"];
echo "</span> </h2>\n            <h2 style=\"font-size: 40px;\" class=\"thismonth\">";
echo $inctbl[1]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["this"];
echo " ";
echo $LNG["month"];
echo "</span> </h2>\n            <h2 style=\"font-size: 40px;\" class=\"thisyear\">";
echo $inctbl[2]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["this"];
echo " ";
echo $LNG["year"];
echo "</span> </h2>\n            \n            <br /> \n            \n           <a class=\"leftarrow\" onclick=\"javascript:showHid('yestered');\" style=\"text-decoration: none;position: absolute;left:-15px;padding:5px 0;cursor: pointer;opacity:0.3\" title=\"Last Day,Last Month, Last Year\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/larrow.png\"/></a>\n           \n            <ul>                                        \n                <li id=\"todays\">";
echo $LNG["today"];
echo " ";
echo $LNG["income"];
echo "</li>\n                <li id=\"thismonth\">";
echo $LNG["this"];
echo " ";
echo $LNG["month"];
echo "</li>\n                <li id=\"thisyear\">";
echo $LNG["this"];
echo "<br /> ";
echo $LNG["year"];
echo "</li>  \n                <div class=\"clear\"></div>              \n            </ul>         \n                        \n        </div>\n        \n        <div style=\"text-align: center;position: relative;width:210px;margin:auto;display: none;\" class=\"income\" id=\"yestered\">            \n            <span style=\"font-size: 16px;color:#888\">";
echo $LNG["income"];
echo "</span>\n            <br />                        \n            <h2 style=\"font-size: 40px;\" class=\"todays view\">";
echo $inctbly[0]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["yesterday"];
echo "</span> </h2>\n            <h2 style=\"font-size: 40px;\" class=\"thismonth\">";
echo $inctbly[1]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo "</span> </h2>\n            <h2 style=\"font-size: 40px;\" class=\"thisyear\">";
echo $inctbly[2]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["last"];
echo " ";
echo $LNG["year"];
echo "</span> </h2>            \n            <br /> \n           \n           <a class=\"rightarrow\" onclick=\"javascript:showHid('today');\" style=\"text-decoration: none;position: absolute;right:-15px;cursor: pointer;padding:5px 0;opacity:0.3\" title=\"Today,This Month, This Year\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/rarrow.png\"/></a>\n           \n            <ul>                \n                <li id=\"todays\">";
echo $LNG["last"];
echo "<br /> Day </li>\n                <li id=\"thismonth\">";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo "</li>\n                <li id=\"thisyear\">";
echo $LNG["last"];
echo " <br />";
echo $LNG["year"];
echo "</li>\n                <div class=\"clear\"></div>                            \n            </ul>                                 \n        </div>        \n    </div>\n \n\n    <div class=\"clear\"></div>\n\n    \n    <hr />\n     <div class=\"colm5 floatleft\" style=\"width: 21%;\">\n        <div style=\"text-align: center;width:230px;margin:auto\">  \n            <span style=\"color: #888;font-size:16px;display:block;margin-bottom: 15px;\">Waiting for reply ticket</span>\n           <br />\n            <div class=\"clear\"></div>                          \n            \n            ";
$result = dquery("SELECT sid,tid, 1 as total FROM tbl_support_tickets where (sid='4' or sid='1') AND did IN (" . $_SESSION["department"] . ") GROUP BY tid");
while ($row = mysqli_fetch_assoc($result)) {
    $ticket[$row["sid"]] += $row["total"];
}
echo " \n           \n           <span style=\"font-size: 40px;font-weight: bold;color:#888;text-shadow:0 1px 1px white; border:#f4f4f4 solid 1px;background: #fafafa; border-radius:50%;height:60px;line-height:60px;width:60px;display: block;margin:8px auto;float:left\">";
echo $ticket[1] + $ticket[4];
echo "</span>\n           <ul style=\"text-align: left;list-style: none;float:left;margin-left:5px;margin-top:18px;position: relative;width:163px\" class=\"ticket\">           \n                <li style=\"\"><a onclick=\"javascript:redirectedit('support.open','1');\" style=\"color: #666;font-size:16px\">";
echo $ticket[1];
echo " - ";
echo $LNG["open"];
echo " ";
echo $LNG["ticket"];
echo "</a></li>                \n                <li style=\"\"><a onclick=\"javascript:redirectedit('support.open','5');\" style=\"color: #666;font-size:16px\">";
echo $ticket[4];
echo " - ";
echo $LNG["customer"];
echo "  ";
echo $LNG["reply"];
echo "</a></li>\n                <div class=\"clear\"></div>              \n            </ul>\n                        \n            <div class=\"clear\"></div>\n        </div>\n    </div>\n\n \n";
$condition = ["totalorder" => "(1=1) ", "totalnew" => " user_can_c='0' limit 0,5000", "totalaccepted" => " user_can_c='1' limit 0,5000", "todaystotal" => "date='" . $today . "' and (1=1) limit 0,5000", "todaysnew" => " date='" . $today . "' and user_can_c='0' limit 0,5000", "todaysaccepted" => " date='" . $today . "' and user_can_c='1' limit 0,5000", "todaysrejected" => " date='" . $today . "' and user_can_c='3' limit 0,5000", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c='4') limit 0,5000", "verify" => "verified='1' and user_can_c='4' ", "yestotal" => " date='" . $yesterday . "' and (1=1) limit 0,5000", "yesaccepted" => " date='" . $yesterday . "' and user_can_c='1' limit 0,5000", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c='4') limit 0,5000", "frommonth" => "from_unixtime(time,'%m')='" . $month . "' and from_unixtime(time,'%Y')='" . $year . "'", "fromyear" => "from_unixtime(time,'%Y')='" . $year . "'"];
foreach ($condition as $key => $cnd) {
    foreach ($table as $tbl) {
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd . " "));
        $order[$tbl][$key] = $ord["total"];
    }
}
echo "   \n\n \n <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/jCProgress-1.0.2.js\"></script>  \n \n\n    <div class=\"colm2 floatleft\" \n    style=\"width:55%;border-left: #e0e0e0 solid 1px;border-right:#e0e0e0 solid 1px;\">\n        <div style=\"text-align: center;\">   \n       \n          <span style=\"color: #888;font-size:16px\">Pending Order Details</span>  \n            \n           <ul class=\"orders\" style=\"margin: auto;width:550px\"> <br />\n            \n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">     \n            <li><div id=\"imei\"><a onclick=\"javascript:redirectedit('imeiorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_imei"]["totalnew"] + $order["tbl_order_imei"]["totalaccepted"];
echo "</strong><br /> IMEI</span></a></div>\n                <ul class=\"imei\">\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_imei"]["totalnew"];
echo "</span></a> </td><td class=\"org\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_imei"]["totalaccepted"];
echo "</span> </a> </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_imei"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysnew"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.replied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysaccepted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todayscompleted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysrejected"];
echo "</span></li>\n                        </ol> \n                     \n";
if (!$config["litedashboard"]) {
    echo "      \n <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yestotal"];
    echo "</span></li>\n                        <ol>\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yesaccepted"];
    echo "</span></li>\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yescompleted"];
    echo "</span></li>\n                        </ol>                                   \n    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["frommonth"];
    echo "</span></li>\n    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["fromyear"];
    echo "</span></li>\n    <li class=\"label\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.verification.php','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_imei"]["verify"];
    echo "</span></li>\n";
}
echo "                    \n                </ul>\n            </li>            \n           </div>\n           \n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\"> \n            <li><div id=\"file\"><a onclick=\"javascript:redirectedit('fileorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_file"]["totalnew"] + $order["tbl_order_file"]["totalaccepted"];
echo "</strong><br />File</span></a></div>\n                <ul class=\"file\">\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_file"]["totalnew"];
echo "</span></a> </td><td class=\"violet\"><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_file"]["totalaccepted"];
echo "</span> </a> </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_file"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysnew"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysaccepted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_file"]["todayscompleted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysrejected"];
echo "</span></li>\n                        </ol> \n                   \n";
if (!$config["litedashboard"]) {
    echo "     \n <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_file"]["yestotal"];
    echo "</span></li>\n                        <ol>\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_file"]["yesaccepted"];
    echo "</span></li>\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["yescompleted"];
    echo "</span></li>\n                        </ol>                                       \n                    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["frommonth"];
    echo "</span></li>\n                    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["fromyear"];
    echo "</span></li>\n                    <li class=\"label\"><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.verification.php','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_file"]["verify"];
    echo "</span></li>\n";
}
echo "                    \n                </ul>\n            </li>\n           </div>\n           \n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">  \n            <li><div id=\"server\"><a onclick=\"javascript:redirectedit('serverorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_server"]["totalnew"] + $order["tbl_order_server"]["totalaccepted"];
echo "</strong><br />Server</span></a></div>\n                <ul class=\"server\">\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_server"]["totalnew"];
echo "</span></a> </td><td class=\"blue\"><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_server"]["totalaccepted"];
echo "</span> </a> </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_server"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysnew"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysaccepted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_server"]["todayscompleted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysrejected"];
echo "</span></li>\n                        </ol> \n                  \n";
if (!$config["litedashboard"]) {
    echo "         \n  <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_server"]["yestotal"];
    echo "</span></li>\n                        <ol>\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_server"]["yesaccepted"];
    echo "</span></li>\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["yescompleted"];
    echo "</span></li>\n                        </ol>                                   \n                    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["frommonth"];
    echo "</span></li>\n                    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["fromyear"];
    echo "</span></li>\n                    <li class=\"label\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.verification.php&stype=server','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_server"]["verify"];
    echo "</span></li>\n";
}
echo "                    \n                </ul>\n            </li>\n            </div>\n           \n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\"> \n            <li><div id=\"shop\"><a onclick=\"javascript:redirectedit('productorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_product"]["totalnew"] + $order["tbl_order_product"]["totalaccepted"];
echo "</strong><br />Shop</span></a></div>\n                <ul class=\"shop\">\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.new.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_product"]["totalnew"];
echo "</span></a> </td><td class=\"green\"><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_product"]["totalaccepted"];
echo "</span></a>  </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_product"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.new.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysnew"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.replied.php','');\">";
echo $LNG["inprocess"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysaccepted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.pending.php','');\">";
echo $LNG["pending"];
echo " </a><span>";
echo $order["tbl_order_product"]["todayscompleted"];
echo "</span></li>\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.return.php','');\">";
echo $LNG["returns"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysrejected"];
echo "</span></li>\n                        </ol> \n  ";
if (!$config["litedashboard"]) {
    echo "                      \n                    <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_product"]["yestotal"];
    echo "</span></li>\n                        <ol>\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_product"]["yesaccepted"];
    echo "</span></li>\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_product"]["yescompleted"];
    echo "</span></li>\n                        </ol> \n";
}
echo "                                                             \n                </ul>\n            </li>\n            \n            \n            </div>\n            <div class=\"clear\"></div>           \n           </ul>             \n                     \n        </div>\n    </div>\n    \n       \n    <div class=\"colm5 floatleft\" style=\"width:21%;\">\n        <div style=\"text-align: center;\">            \n            <ul style=\"text-align: left;margin-left:25px\" class=\"quicklink\">\n                <li><a href=\"javascript:redirectedit('unpaidinvoice','')\">";
echo $LNG["unpaid"];
echo " ";
echo $LNG["invoices"];
echo "</a></li>\n                <li><a href=\"javascript:redirectedit('utilities.resellershop','')\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["store"];
echo "</a></li>\n                <li><a href=\"javascript:redirectedit('utilities.discountcheck','')\">";
echo $LNG["discount"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n                <li><a href=\"javascript:redirectedit('ebayorder','')\">";
echo $LNG["imei"];
echo " ";
echo $LNG["direct"];
echo " ";
echo $LNG["order"];
echo "</a></li>\n                <li><a href=\"javascript:redirectedit('utilities.adminactivities','')\">";
echo $LNG["login"];
echo " ";
echo $LNG["log"];
echo "</a></li>\n            </ul>\n        </div>\n    </div>\n    \n    <div class=\"clear\"></div>    \n    <hr />              \n \n  \n    <div class=\"colm2 flexcroll floatleft\" style=\"text-align: center;width:32%;height:380px;border-right:#e0e0e0 solid 1px;\">\n        <span style=\"font-size: 16px;color:#888;\">Action Required (To Do)</span><br />         \n     <div class=\"\" style=\"margin-top:8px;\">   \n      <ul class=\"todo\" style=\"text-align: left;\">\n\n";
$allset = $order["tbl_order_imei"]["totalnew"] . "-" . $order["tbl_order_imei"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_server"]["totalnew"] . "-" . $order["tbl_order_server"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_product"]["totalnew"] . "-" . $order["tbl_order_product"]["totalaccepted"];
$vals = explode("-", $allset);
$cntbc = mysqli_num_rows(dquery("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id"));
$cntrv = mysqli_num_rows(dquery("SELECT * from tbl_review where status='0'"));
$cnttst = mysqli_num_rows(dquery("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'"));
$cntpq = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE user_can_c='6'"));
$cntcc = mysqli_num_rows(dquery("SELECT id FROM `tbl_invoices` WHERE\n status='Unpaid' and paymentmethod='cc'"));
$cntwat = mysqli_num_rows(dquery("SELECT * FROM `tblUsers` WHERE userstatus='2' and is_registered='0'"));
$cntunpu = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\n                                         total>0 AND adminid=''"));
$cntunpa = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\n                                         total>0 AND adminid!=''"));
$cntpendingrr = mysqli_num_rows(dquery("SELECT id FROM `tbl_return_request` WHERE status='0'"));
$cntblog = mysqli_num_rows(dquery("select id from tbl_blogposts where status='unpublished'"));
$cnttestimonial = mysqli_num_rows(dquery("select id from tbl_testimonial where status='pending'"));
$cntimeireview = mysqli_num_rows(dquery("select id from tbl_review where status=0 and sid!=0"));
$cntserverreview = mysqli_num_rows(dquery("select id from tbl_review where status=0 and lid!=0"));
$cntshopreview = mysqli_num_rows(dquery("select id from tbl_review where status=0 and pid!=0"));
$cntonline = mysqli_num_rows(dquery("SELECT username,id,online_status from tblUsers where online_status='1'"));
$cntwithdrawal = mysqli_num_rows(dquery("SELECT * FROM tbl_withdrawal  WHERE status=0"));
$cntsuppro = mysqli_num_rows(dquery("SELECT * FROM tbl_products  WHERE active=0 and bysupplier!=''"));
if ($vals[0] || $vals[1] || $vals[2] || $vals[3] || $vals[4] || $vals[5] || $vals[8] || $vals[9]) {
    echo "\n";
}
if ($vals[0]) {
    echo "    \n    <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">\n<a><span>";
    echo $vals[0];
    echo " </span>  New IMEI Orders</a></li>\n";
}
if ($vals[1]) {
    echo "<li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=quickreply.php','');\">\n<a><span>";
    echo $vals[1];
    echo "</span> Pending IMEI Orders</a>\n    </li>\n";
}
if ($vals[2]) {
    echo "    \n    <li onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">\n<a><span>";
    echo $vals[2];
    echo " </span> New File Orders </a></li>\n";
}
if ($vals[3]) {
    echo " <li onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">\n <a><span>";
    echo $vals[3];
    echo "</span> Pending File Orders</a></li>    \n";
}
if ($vals[4]) {
    echo "      \n    <li onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">\n <a><span>";
    echo $vals[4];
    echo "</span> New Server Orders </a></li>\n ";
}
if ($vals[5]) {
    echo " <li  onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">\n  <a><span>";
    echo $vals[5];
    echo "</span> Pending Server Orders</a></li> \n";
}
if ($vals[8]) {
    echo "       \n    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.new.php','1');\">\n  <a><span>";
    echo $vals[8];
    echo " </span> New Shop orders</a></li> \n  ";
}
if ($vals[9]) {
    echo "  <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.pending.php','');\">\n  <a><span >";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\n    </li> \n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    ";
}
if ($cntwithdrawal) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.withdrawal','');\">\n   <a> <span>";
    echo $cntwithdrawal;
    echo "</span> Pending withdrawal request</a>\n    </li> \n";
}
if ($cntpq) {
    echo "  \n    <li  onclick=\"javascript:redirectedit('utilities.pendingquick','');\">\n   <a> <span>";
    echo $cntpq;
    echo "</span> Quick checkout pending orders</a>\n    </li>\n";
}
if ($cntcc) {
    echo "    \n    <li  onclick=\"javascript:redirectedit('utilities.ccprocess','');\">\n    <a><span>";
    echo $cntcc;
    echo "</span> Orders waiting for offline Credit Card Process</a>\n    </li>\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <li onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=User');\">\n    <a><span>";
    echo $cntunpu;
    echo "</span> Unpaid invoices of User </a></li>\n    <li onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=Admin');\">\n     <a><span>";
    echo $cntunpa;
    echo "</span> Invoices of Admin</a>\n    </li>  \n";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
    echo "\n    ";
}
if ($vals[6]) {
    echo "       \n    <li onclick=\"javascript:redirectedit('support.ticket','1');\">\n    <a><span >";
    echo $vals[6];
    echo "</span> New tickets </a></li> \n";
}
if ($vals[7]) {
    echo "    \n    <li onclick=\"javascript:redirectedit('support.ticket','4&laoddefaultpage=support.open.php');\"> \n    <a></a><span >";
    echo $vals[7];
    echo "</span>  Waiting tickets</a>\n    </li> \n";
}
if ($cntbc) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.comments','');\">\n    <a><span>";
    echo $cntbc;
    echo "</span> New blog comments</a>\n    </li>\n";
}
if ($cnttst) {
    echo "    \n    <li  onclick=\"javascript:redirectedit('dashboard.testimonial','');\">\n    <a><span>";
    echo $cnttst;
    echo "</span> New testimonial</a>\n    </li>\n";
}
if ($cntwat) {
    echo "     \n    <li onclick=\"javascript:redirectedit('utilities.userstatus','');\">\n    <a><span>";
    echo $cntwat;
    echo "</span> User waiting for activation</a>\n    </li>  \n";
}
if ($cntpendingrr) {
    echo "    \n    <li  onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.return.php','');\">\n    <a><span>";
    echo $cntpendingrr;
    echo "</span> Pending Return request</a>\n    </li>\n";
}
if ($cntsuppro) {
    echo "     \n    <li onclick=\"javascript:redirectedit('catlog&defaultloadpage=resellerlist.php','');\">\n    <a><span>";
    echo $cntsuppro;
    echo "</span> Suppliers product waiting for approval</a>\n    </li>  \n";
}
if ($cntimeireview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_imei.php','&status=pending');\">\n    <a><span>";
    echo $cntimeireview;
    echo "</span> Pending IMEI service review</a>\n    </li>\n";
}
if ($cntserverreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_server.php','&status=pending');\">\n    <a><span>";
    echo $cntserverreview;
    echo "</span> Pending Server service review</a>\n    </li>\n";
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_shop.php','&status=pending');\">\n    <a><span>";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\n    </li>\n";
}
echo " \n\n      </ul>  \n    </div>    \n        \n    </div>\n \n \n<style>\n    #deshbordsub{width:100%;padding:10px}\n    #deshbordsub td{\n        border-bottom: 1px dotted #F4F4F4;\n        color: #666666;\n        font-size: 16px;\n        padding: 7px 2px;        \n    }\n    #deshbordsub td a{color:#888;text-decoration: none;}\n    #deshbordsub th{padding:2px 2px;border-bottom:#ccc solid 1px;}\n    \n    #deshbordsub.IMEI th{border-color:#f0aa65}\n    #deshbordsub.File th{border-color:#c4bfd9}\n    #deshbordsub.Server th{border-color:#90c0db}\n    #deshbordsub.Shop th{border-color:#a4cc8a}\n    \n    #deshbordsub th{background: transparent !important;}\n    #deshbordsub th strong{color:#888;font-weight: normal;text-shadow:0 1px 1px white;font-size:11px;}\n    #deshbordsub td strong{font-weight: normal;}\n</style>\n    \n    <div class=\"colm2 floatleft\" style=\"text-align: center;width:66%;\">\n    \n    ";
$allset = base64_encode($cntin . "-" . $cntia . "-" . $cntfn . "-" . $cntfa . "-" . $cntsn . "-" . $cntsa . "-" . $cnttckn . "-" . $cnttckw . "-" . $cntpn . "-" . $cntpa);
echo "    <ul id=\"tabmenu\" class=\"dashboardtab\" style=\"margin: 0 0 0 10px;position: relative;left:0;top:0\">        \n        <li><a onclick=\"getContect('#tab1','main2.php?page=dashboard.topservice','','','#tabcontent',true,'#main_loader');\" class=\"tabmenu_active\" id=\"tab1\">Top 10 Selling Services</a></li>\n        <li><a onclick=\"getContect('#tab2','main2.php?page=dashboard.happyhours','','','#tabcontent',true,'#main_loader');\"  id=\"tab2\" >";
echo $LNG["happyhours"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n        <li><a onclick=\"getContect('#tab3','main2.php?page=dashboard.mostviewable','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["mostviewable"];
echo " ";
echo $LNG["products"];
echo "</a></li>\n        <li><a onclick=\"getContect('#tab5','main2.php?page=dashboard.apistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >APi ";
echo $LNG["status"];
echo "</a></li>\n        ";
if (!$fusionlite) {
    echo "            <li><a onclick=\"getContect('#tab4','main2.php?page=dashboard.twitterfeed','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >DHRU ";
    echo $LNG["news"];
    echo "</a></li>\n        ";
}
echo "        <div style=\"clear: both;\"></div> \n    </ul>\n  \n  <div class=\"flexcroll\"   style=\"margin-top: 10px;min-height:350px;\">     \n    <div  id='tabcontent' style=\"margin-top: 0px;\">\n        ";
if (!$sub) {
    include "includes/pages/dashboard.topservice.php";
} else {
    include $sub . ".php";
}
echo "    </div>\n </div>   \n  \n  \n        \n    </div>\n    <div class=\"clear\"></div>\n</div> \n    <div class=\"clear\"></div>\n    \n    \n<script type=\"text/javascript\">\n\n\n    var chart;\n    \$(document).ready(function() {\n   \n   chart = new Highcharts.Chart({\n            chart: {\n                renderTo: 'container',\n                type: 'areaspline'\n            },\n            title: {\n                text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "',\n                align:'left'\n            },\n            legend: {\n                layout: 'horizontal',\n                align: 'right',\n                verticalAlign: 'top',\n                x: 0,\n                y: -5,\n                floating: true,\n                borderWidth: 0,\n                backgroundColor: 'transparent'\n            },                        \n            xAxis: {\n                categories: [\n                    'Jan',\n                    'Feb',\n                    'Mar',\n                    'Apr',\n                    'May',\n                    'Jun',\n                    'Jul',\n                    'Aug',\n                    'Sep',\n                    'Oct',\n                    'Nov',\n                    'Dec'\n                ]\n            },\n            yAxis: {\n                title: {\n                    text: ''\n                }\n            },\n            tooltip: {\n                formatter: function() {\n                    return ''+\n                    this.x +': '+ this.y +' Orders';\n                }\n            },\n            credits: {\n                enabled: false\n            },\n            plotOptions: {\n                areaspline: {\n                    fillOpacity: 0.5\n                }\n            },\n             series: [{\n                 name: 'IMEI',\n                 data: [";
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
echo "]\n              },{\n                 name: 'File',\n                 data: [";
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
echo "]\n              }, {\n                 name: 'Server',\n                 data: [";
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
echo "]\n              }, {\n                 name: 'Shop',\n                 data: [";
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
echo "]\n              }]\n        }); \n    \n    \n    \n    \$('.progress').animate({  borderSpacing: ";
echo $totaldeg;
echo " }, {\n        step: function(now,fx) {\n          \$(this).rotate(now);                           \n        },\n        duration:'slow'\n    },'linear');  \n    \n    \n      \$('#imei').cprogress({img1: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png',img2: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v3.png',speed: 5,limit: ";
if ($order["tbl_order_imei"]["totalnew"] + $order["tbl_order_imei"]["totalaccepted"]) {
    $imei = round($order["tbl_order_imei"]["totalaccepted"] * 100 / ($order["tbl_order_imei"]["totalnew"] + $order["tbl_order_imei"]["totalaccepted"]), 0);
    if ($imei <= 2) {
        $imei = $defaultprogress;
    }
    echo $imei;
} else {
    echo $defaultprogress;
}
echo "});\t\n        \$('#file').cprogress({img1: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png',img2: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v2.png',speed: 5,limit: ";
if ($order["tbl_order_file"]["totalnew"] + $order["tbl_order_file"]["totalaccepted"]) {
    $file = round($order["tbl_order_file"]["totalaccepted"] * 100 / ($order["tbl_order_file"]["totalnew"] + $order["tbl_order_file"]["totalaccepted"]), 0);
    if ($file <= 2) {
        $file = $defaultprogress;
    }
    echo $file;
} else {
    echo $defaultprogress;
}
echo "});\n        \$('#server').cprogress({img1: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png',img2: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v4.png',speed: 5,limit: ";
if ($order["tbl_order_server"]["totalnew"] + $order["tbl_order_server"]["totalaccepted"]) {
    $server = round($order["tbl_order_server"]["totalaccepted"] * 100 / ($order["tbl_order_server"]["totalnew"] + $order["tbl_order_server"]["totalaccepted"]), 0);
    if ($server <= 2) {
        $server = $defaultprogress;
    }
    echo $server;
} else {
    echo $defaultprogress;
}
echo "});\n        \$('#shop').cprogress({img1: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png',img2: 'templates/";
echo $_SESSION["admin_template"];
echo "/images/v5.png',speed: 5,limit: ";
if ($order["tbl_order_product"]["totalnew"] + $order["tbl_order_product"]["totalaccepted"]) {
    $shop = round($order["tbl_order_product"]["totalaccepted"] * 100 / ($order["tbl_order_product"]["totalnew"] + $order["tbl_order_product"]["totalaccepted"]), 0);
    if ($shop <= 2) {
        $shop = $defaultprogress;
    }
    echo $shop;
} else {
    echo $defaultprogress;
}
echo "});    \n   \n       \n     }); \n    \n</script>\n";
$fileverioncheck = "6.1.0";

?>