<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div title=\"dashboard\" id=\"tutid\"></div>\r\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\r\n        ";
    echo $LNG["maintancemodeon"];
    echo "    </div>\r\n    ";
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
$array = ["UNIX_TIMESTAMP(datepaid)='" . $today . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%m')='" . $month . "' \r\n             and from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'"];
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
$array = ["UNIX_TIMESTAMP(datepaid)='" . $yesterday . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%m')='" . $pmonth . "'\r\n            and from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $pyear . "'"];
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
echo "<div style=\"display: none !important;\" class=\"preload\">\r\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png\" />\r\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v2.png\" />\r\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v3.png\" />\r\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v4.png\" />\r\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v5.png\" class=\"v5\" />\r\n</div>\r\n\r\n<div style=\"margin-top: -35px;\">\r\n    <div class=\"floatleft\" style=\"width:23%\">\r\n";
if (!$config["litedashboard"]) {
    echo "        <div style=\"text-align: center;\" class=\"performance\">\r\n            <span style=\"font-size: 16px;color:#888\">System Performance</span><br />\r\n            <span style=\"font-size: 45px;font-weight: bold;color:#888\">";
    echo $totalper1;
    echo "%</span>\r\n               <div style=\"position: relative;width:200px;margin: auto;\">\r\n                    <img src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/images/progressbar.png\" class=\"progress\"/>\r\n                    <div style=\"position: absolute;top:70px;width:100%;background:white;height:80px;font-size:12px;color:#888;text-shadow:0 1px 1px white\"><br/>By Completed Orders <br/>and<br/>By Active Users\r\n                         <ul class=\"iper\">\r\n                            <li>IMEI completed Order <span>";
    echo $performance["tbl_order_imei"][0];
    echo "/";
    echo $performance["tbl_order_imei"][1];
    echo "</span></li>\r\n                            <li>File complated Order <span>";
    echo $performance["tbl_order_file"][0];
    echo "/";
    echo $performance["tbl_order_file"][1];
    echo "</span></li>\r\n                            <li>Server complated Order <span>";
    echo $performance["tbl_order_server"][0];
    echo "/";
    echo $performance["tbl_order_server"][1];
    echo "</span></li>\r\n                            <li>shop complated Order <span>";
    echo $performance["tbl_order_product"][0];
    echo "/";
    echo $performance["tbl_order_product"][1];
    echo "</span></li>\r\n                            <li>Active Users <span>";
    echo $performance["tbl_user"][0];
    echo "/";
    echo $performance["tbl_user"][1];
    echo "</span></li>\r\n                         </ul>\r\n                     </div>\r\n               </div>\r\n        </div>\r\n";
} else {
    echo "<span class='disabledesign'>Disabled</span>";
}
echo "    </div>\r\n\r\n\r\n";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  \r\nfrom tbl_order_imei WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c \r\nunion select count(*) as total,MONTH(date) as month,user_can_c,2  \r\nfrom tbl_order_file WHERE year( date ) = year( now( ) ) group by MONTH(date),\r\nuser_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3  from tbl_order_server \r\nWHERE year( date ) = year( now( ) ) group by MONTH(date),\r\nuser_can_c union select count(*) as total,MONTH(date) as month,\r\nuser_can_c,4  from tbl_order_product WHERE year( date ) = year( now( ) ) group by MONTH(date),user_can_c";
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
echo "\r\n<link href=\"templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.css\" media=\"screen\" rel=\"stylesheet\"/>\r\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/dashboard.js\"></script>\r\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\r\n<div class=\"colm2 floatleft\" style=\"border-left: #e0e0e0 solid 1px;border-right:#e0e0e0 solid 1px;width:52%\">\r\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/jQueryRotate.2.2.js\"></script>\r\n\r\n        <div style=\"text-align: center;\">\r\n            <div id=\"container\" style=\"height: 220px; margin: 0 auto\"></div>\r\n        </div>\r\n    </div>\r\n\r\n\r\n\r\n    <div class=\"floatright\" style=\"width:23%\">\r\n        <div style=\"text-align: center;position: relative;width:210px;margin:auto\" class=\"income\" id=\"today\">\r\n\r\n\r\n            <span style=\"font-size: 16px;color:#888\">";
echo $LNG["income"];
echo "</span>\r\n            <br />\r\n            <h2 style=\"font-size: 40px;\" class=\"todays view\">";
echo $inctbl[0]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo " </span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["today"];
echo "</span> </h2>\r\n            <h2 style=\"font-size: 40px;\" class=\"thismonth\">";
echo $inctbl[1]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["this"];
echo " ";
echo $LNG["month"];
echo "</span> </h2>\r\n            <h2 style=\"font-size: 40px;\" class=\"thisyear\">";
echo $inctbl[2]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["this"];
echo " ";
echo $LNG["year"];
echo "</span> </h2>\r\n\r\n            <br />\r\n\r\n           <a class=\"leftarrow\" onclick=\"javascript:showHid('yestered');\" style=\"text-decoration: none;position: absolute;left:-15px;padding:5px 0;cursor: pointer;opacity:0.3\" title=\"Last Day,Last Month, Last Year\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/larrow.png\"/></a>\r\n\r\n            <ul>\r\n                <li id=\"todays\">";
echo $LNG["today"];
echo " ";
echo $LNG["income"];
echo "</li>\r\n                <li id=\"thismonth\">";
echo $LNG["this"];
echo " ";
echo $LNG["month"];
echo "</li>\r\n                <li id=\"thisyear\">";
echo $LNG["this"];
echo "<br /> ";
echo $LNG["year"];
echo "</li>\r\n                <div class=\"clear\"></div>\r\n            </ul>\r\n\r\n        </div>\r\n\r\n        <div style=\"text-align: center;position: relative;width:210px;margin:auto;display: none;\" class=\"income\" id=\"yestered\">\r\n            <span style=\"font-size: 16px;color:#888\">";
echo $LNG["income"];
echo "</span>\r\n            <br />\r\n            <h2 style=\"font-size: 40px;\" class=\"todays view\">";
echo $inctbly[0]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["yesterday"];
echo "</span> </h2>\r\n            <h2 style=\"font-size: 40px;\" class=\"thismonth\">";
echo $inctbly[1]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo "</span> </h2>\r\n            <h2 style=\"font-size: 40px;\" class=\"thisyear\">";
echo $inctbly[2]["income"];
echo "  <br /><div style=\"text-align: center;font-size:12px\"><span>";
echo $config["base_currency"];
echo "</span></div><span style=\"font-size: 12px;font-weight:normal;color:#888;display: block;padding-top:20px\">";
echo $LNG["last"];
echo " ";
echo $LNG["year"];
echo "</span> </h2>\r\n            <br />\r\n\r\n           <a class=\"rightarrow\" onclick=\"javascript:showHid('today');\" style=\"text-decoration: none;position: absolute;right:-15px;cursor: pointer;padding:5px 0;opacity:0.3\" title=\"Today,This Month, This Year\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/rarrow.png\"/></a>\r\n\r\n            <ul>\r\n                <li id=\"todays\">";
echo $LNG["last"];
echo "<br /> Day </li>\r\n                <li id=\"thismonth\">";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo "</li>\r\n                <li id=\"thisyear\">";
echo $LNG["last"];
echo " <br />";
echo $LNG["year"];
echo "</li>\r\n                <div class=\"clear\"></div>\r\n            </ul>\r\n        </div>\r\n    </div>\r\n\r\n\r\n    <div class=\"clear\"></div>\r\n\r\n\r\n    <hr />\r\n     <div class=\"colm5 floatleft\" style=\"width: 21%;\">\r\n        <div style=\"text-align: center;width:230px;margin:auto\">\r\n            <span style=\"color: #888;font-size:16px;display:block;margin-bottom: 15px;\">Waiting for reply ticket</span>\r\n           <br />\r\n            <div class=\"clear\"></div>\r\n\r\n            ";
$result = dquery("SELECT sid,tid, 1 as total FROM tbl_support_tickets where (sid='4' or sid='1') AND did IN (" . $_SESSION["department"] . ") GROUP BY tid");
while ($row = mysqli_fetch_assoc($result)) {
    $ticket[$row["sid"]] += $row["total"];
}
echo "\r\n           <span style=\"font-size: 40px;font-weight: bold;color:#888;text-shadow:0 1px 1px white; border:#f4f4f4 solid 1px;background: #fafafa; border-radius:50%;height:60px;line-height:60px;width:60px;display: block;margin:8px auto;float:left\">";
echo $ticket[1] + $ticket[4];
echo "</span>\r\n           <ul style=\"text-align: left;list-style: none;float:left;margin-left:5px;margin-top:18px;position: relative;width:163px\" class=\"ticket\">\r\n                <li style=\"\"><a onclick=\"javascript:redirectedit('support.open','1');\" style=\"color: #666;font-size:16px\">";
echo $ticket[1];
echo " - ";
echo $LNG["open"];
echo " ";
echo $LNG["ticket"];
echo "</a></li>\r\n                <li style=\"\"><a onclick=\"javascript:redirectedit('support.open','5');\" style=\"color: #666;font-size:16px\">";
echo $ticket[4];
echo " - ";
echo $LNG["customer"];
echo "  ";
echo $LNG["reply"];
echo "</a></li>\r\n                <div class=\"clear\"></div>\r\n            </ul>\r\n\r\n            <div class=\"clear\"></div>\r\n        </div>\r\n    </div>\r\n\r\n\r\n";
$condition = ["totalorder" => "(1=1) ", "totalnew" => " user_can_c='0' limit 0,5000", "totalaccepted" => " user_can_c='1' limit 0,5000", "todaystotal" => "date='" . $today . "' and (1=1) limit 0,5000", "todaysnew" => " date='" . $today . "' and user_can_c='0' limit 0,5000", "todaysaccepted" => " date='" . $today . "' and user_can_c='1' limit 0,5000", "todaysrejected" => " date='" . $today . "' and user_can_c='3' limit 0,5000", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c='4') limit 0,5000", "verify" => "verified='1' and user_can_c='4' ", "yestotal" => " date='" . $yesterday . "' and (1=1) limit 0,5000", "yesaccepted" => " date='" . $yesterday . "' and user_can_c='1' limit 0,5000", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c='4') limit 0,5000", "frommonth" => "from_unixtime(time,'%m')='" . $month . "' and from_unixtime(time,'%Y')='" . $year . "'", "fromyear" => "from_unixtime(time,'%Y')='" . $year . "'"];
foreach ($condition as $key => $cnd) {
    foreach ($table as $tbl) {
        $append = "";
        if ($tbl == "tbl_order_imei") {
            $append = " and server=0";
            $tbl2 = "tbl_order_imei";
        } else {
            if ($tbl == "tbl_order_server") {
                $tbl2 = "tbl_order_imei";
                $append = " and server=1";
            } else {
                $tbl2 = $tbl;
            }
        }
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl2 . " where " . $cnd . "  " . $append));
        $order[$tbl][$key] = $ord["total"];
    }
}
echo "\r\n\r\n <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/jCProgress-1.0.2.js\"></script>\r\n\r\n\r\n    <div class=\"colm2 floatleft\"\r\n    style=\"width:55%;border-left: #e0e0e0 solid 1px;border-right:#e0e0e0 solid 1px;\">\r\n        <div style=\"text-align: center;\">\r\n\r\n          <span style=\"color: #888;font-size:16px\">Pending Order Details</span>\r\n\r\n           <ul class=\"orders\" style=\"margin: auto;width:550px\"> <br />\r\n\r\n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">\r\n            <li><div id=\"imei\"><a onclick=\"javascript:redirectedit('imeiorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_imei"]["totalnew"] + $order["tbl_order_imei"]["totalaccepted"];
echo "</strong><br /> IMEI</span></a></div>\r\n                <ul class=\"imei\">\r\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_imei"]["totalnew"];
echo "</span></a> </td><td class=\"org\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_imei"]["totalaccepted"];
echo "</span> </a> </td></tr></table>\r\n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_imei"]["todaystotal"];
echo "</span></li>\r\n                        <ol>\r\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysnew"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.replied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysaccepted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todayscompleted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysrejected"];
echo "</span></li>\r\n                        </ol>\r\n\r\n";
if (!$config["litedashboard"]) {
    echo " <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yestotal"];
    echo "</span></li>\r\n                        <ol>\r\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yesaccepted"];
    echo "</span></li>\r\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["yescompleted"];
    echo "</span></li>\r\n                        </ol>\r\n    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["frommonth"];
    echo "</span></li>\r\n    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_imei"]["fromyear"];
    echo "</span></li>\r\n    <li class=\"label\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.verification.php','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_imei"]["verify"];
    echo "</span></li>\r\n";
}
echo "                </ul>\r\n            </li>\r\n           </div>\r\n\r\n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">\r\n            <li><div id=\"file\"><a onclick=\"javascript:redirectedit('fileorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_file"]["totalnew"] + $order["tbl_order_file"]["totalaccepted"];
echo "</strong><br />File</span></a></div>\r\n                <ul class=\"file\">\r\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_file"]["totalnew"];
echo "</span></a> </td><td class=\"violet\"><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_file"]["totalaccepted"];
echo "</span> </a> </td></tr></table>\r\n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_file"]["todaystotal"];
echo "</span></li>\r\n                        <ol>\r\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysnew"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysaccepted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_file"]["todayscompleted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysrejected"];
echo "</span></li>\r\n                        </ol>\r\n\r\n";
if (!$config["litedashboard"]) {
    echo " <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_file"]["yestotal"];
    echo "</span></li>\r\n                        <ol>\r\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_file"]["yesaccepted"];
    echo "</span></li>\r\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["yescompleted"];
    echo "</span></li>\r\n                        </ol>\r\n                    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["frommonth"];
    echo "</span></li>\r\n                    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_file"]["fromyear"];
    echo "</span></li>\r\n                    <li class=\"label\"><a onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.verification.php','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_file"]["verify"];
    echo "</span></li>\r\n";
}
echo "                </ul>\r\n            </li>\r\n           </div>\r\n\r\n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">\r\n            <li><div id=\"server\"><a onclick=\"javascript:redirectedit('serverorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_server"]["totalnew"] + $order["tbl_order_server"]["totalaccepted"];
echo "</strong><br />Server</span></a></div>\r\n                <ul class=\"server\">\r\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_server"]["totalnew"];
echo "</span></a> </td><td class=\"blue\"><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_server"]["totalaccepted"];
echo "</span> </a> </td></tr></table>\r\n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_server"]["todaystotal"];
echo "</span></li>\r\n                        <ol>\r\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysnew"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysaccepted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.history.php','');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_server"]["todayscompleted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.history.php','');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysrejected"];
echo "</span></li>\r\n                        </ol>\r\n\r\n";
if (!$config["litedashboard"]) {
    echo "  <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_server"]["yestotal"];
    echo "</span></li>\r\n                        <ol>\r\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_server"]["yesaccepted"];
    echo "</span></li>\r\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["yescompleted"];
    echo "</span></li>\r\n                        </ol>\r\n                    <li class=\"label\">";
    echo $LNG["month"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["frommonth"];
    echo "</span></li>\r\n                    <li class=\"label\">";
    echo $LNG["year"];
    echo "  ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["total"];
    echo " ";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_server"]["fromyear"];
    echo "</span></li>\r\n                    <li class=\"label\"><a onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.verification.php&stype=server','');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_server"]["verify"];
    echo "</span></li>\r\n";
}
echo "                </ul>\r\n            </li>\r\n            </div>\r\n\r\n           <div class=\"floatleft\" style=\"width:25%;margin-right:0;\">\r\n            <li><div id=\"shop\"><a onclick=\"javascript:redirectedit('productorder','');\"><span class=\"label\"><strong style=\"font-size: 25px;color:black\">";
echo $order["tbl_order_product"]["totalnew"] + $order["tbl_order_product"]["totalaccepted"];
echo "</strong><br />Shop</span></a></div>\r\n                <ul class=\"shop\">\r\n                    <table cellpadding=\"0\" cellspacing=\"0\"><tr><td><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.new.php','');\">";
echo $LNG["new"];
echo " <span>";
echo $order["tbl_order_product"]["totalnew"];
echo "</span></a> </td><td class=\"green\"><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.replied.php','');\">";
echo $LNG["accepted"];
echo " <span>";
echo $order["tbl_order_product"]["totalaccepted"];
echo "</span></a>  </td></tr></table>\r\n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_product"]["todaystotal"];
echo "</span></li>\r\n                        <ol>\r\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.new.php','');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysnew"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.replied.php','');\">";
echo $LNG["inprocess"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysaccepted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.pending.php','');\">";
echo $LNG["pending"];
echo " </a><span>";
echo $order["tbl_order_product"]["todayscompleted"];
echo "</span></li>\r\n                            <li><a onclick=\"javascript:redirectedit('productorder&laoddefaultpage=productorder.return.php','');\">";
echo $LNG["returns"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysrejected"];
echo "</span></li>\r\n                        </ol>\r\n  ";
if (!$config["litedashboard"]) {
    echo "                    <li class=\"label\">";
    echo $LNG["yesterday"];
    echo "<span>";
    echo $order["tbl_order_product"]["yestotal"];
    echo "</span></li>\r\n                        <ol>\r\n                             <li>";
    echo $LNG["accepted"];
    echo "<span>";
    echo $order["tbl_order_product"]["yesaccepted"];
    echo "</span></li>\r\n                            <li>";
    echo $LNG["completed"];
    echo "<span>";
    echo $order["tbl_order_product"]["yescompleted"];
    echo "</span></li>\r\n                        </ol>\r\n";
}
echo "                </ul>\r\n            </li>\r\n\r\n\r\n            </div>\r\n            <div class=\"clear\"></div>\r\n           </ul>\r\n\r\n        </div>\r\n    </div>\r\n\r\n\r\n    <div class=\"colm5 floatleft\" style=\"width:21%;\">\r\n        <div style=\"text-align: center;\">\r\n            <ul style=\"text-align: left;margin-left:25px\" class=\"quicklink\">\r\n                <li><a href=\"javascript:redirectedit('unpaidinvoice','')\">";
echo $LNG["unpaid"];
echo " ";
echo $LNG["invoices"];
echo "</a></li>\r\n                <li><a href=\"javascript:redirectedit('utilities.resellershop','')\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["store"];
echo "</a></li>\r\n                <li><a href=\"javascript:redirectedit('utilities.discountcheck','')\">";
echo $LNG["discount"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["service"];
echo "</a></li>\r\n                <li><a href=\"javascript:redirectedit('ebayorder','')\">";
echo $LNG["imei"];
echo " ";
echo $LNG["direct"];
echo " ";
echo $LNG["order"];
echo "</a></li>\r\n                <li><a href=\"javascript:redirectedit('utilities.adminactivities','')\">";
echo $LNG["login"];
echo " ";
echo $LNG["log"];
echo "</a></li>\r\n            </ul>\r\n        </div>\r\n    </div>\r\n\r\n    <div class=\"clear\"></div>\r\n    <hr />\r\n\r\n\r\n    <div class=\"colm2 flexcroll floatleft\" style=\"text-align: center;width:32%;height:380px;border-right:#e0e0e0 solid 1px;\">\r\n        <span style=\"font-size: 16px;color:#888;\">Action Required (To Do)</span><br />\r\n     <div class=\"\" style=\"margin-top:8px;\">\r\n      <ul class=\"todo\" style=\"text-align: left;\">\r\n\r\n";
$allset = $order["tbl_order_imei"]["totalnew"] . "-" . $order["tbl_order_imei"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_server"]["totalnew"] . "-" . $order["tbl_order_server"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_product"]["totalnew"] . "-" . $order["tbl_order_product"]["totalaccepted"];
$vals = explode("-", $allset);
$cntbc = mysqli_num_rows(dquery("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id"));
$cntrv = mysqli_num_rows(dquery("SELECT * from tbl_review where status='0'"));
$cnttst = mysqli_num_rows(dquery("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'"));
$cntpq = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE user_can_c='6'"));
$cntcc = mysqli_num_rows(dquery("SELECT id FROM `tbl_invoices` WHERE\r\n status='Unpaid' and paymentmethod='cc'"));
$cntwat = mysqli_num_rows(dquery("SELECT * FROM `tblUsers` WHERE userstatus='2' and is_registered='0'"));
$cntunpu = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\r\n                                         total>0 AND adminid=''"));
$cntunpa = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\r\n                                         total>0 AND adminid!=''"));
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
    echo "\r\n";
}
if ($vals[0]) {
    echo "    <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">\r\n<a><span>";
    echo $vals[0];
    echo " </span>  New IMEI Orders</a></li>\r\n";
}
if ($vals[1]) {
    echo "<li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=quickreply.php','');\">\r\n<a><span>";
    echo $vals[1];
    echo "</span> Pending IMEI Orders</a>\r\n    </li>\r\n";
}
if ($vals[2]) {
    echo "    <li onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=filequickaccept.php','');\">\r\n<a><span>";
    echo $vals[2];
    echo " </span> New File Orders </a></li>\r\n";
}
if ($vals[3]) {
    echo " <li onclick=\"javascript:redirectedit('fileorder&laoddefaultpage=fileorder.repllied.php','');\">\r\n <a><span>";
    echo $vals[3];
    echo "</span> Pending File Orders</a></li>\r\n";
}
if ($vals[4]) {
    echo "    <li onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverquickaccept.php','');\">\r\n <a><span>";
    echo $vals[4];
    echo "</span> New Server Orders </a></li>\r\n ";
}
if ($vals[5]) {
    echo " <li  onclick=\"javascript:redirectedit('serverorder&laoddefaultpage=serverorder.replied.php','');\">\r\n  <a><span>";
    echo $vals[5];
    echo "</span> Pending Server Orders</a></li>\r\n";
}
if ($vals[8]) {
    echo "    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.new.php','1');\">\r\n  <a><span>";
    echo $vals[8];
    echo " </span> New Shop orders</a></li>\r\n  ";
}
if ($vals[9]) {
    echo "  <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.pending.php','');\">\r\n  <a><span >";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\r\n    </li>\r\n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    ";
}
if ($cntwithdrawal) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.withdrawal','');\">\r\n   <a> <span>";
    echo $cntwithdrawal;
    echo "</span> Pending withdrawal request</a>\r\n    </li>\r\n";
}
if ($cntpq) {
    echo "    <li  onclick=\"javascript:redirectedit('utilities.pendingquick','');\">\r\n   <a> <span>";
    echo $cntpq;
    echo "</span> Quick checkout pending orders</a>\r\n    </li>\r\n";
}
if ($cntcc) {
    echo "    <li  onclick=\"javascript:redirectedit('utilities.ccprocess','');\">\r\n    <a><span>";
    echo $cntcc;
    echo "</span> Orders waiting for offline Credit Card Process</a>\r\n    </li>\r\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <li onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=User');\">\r\n    <a><span>";
    echo $cntunpu;
    echo "</span> Unpaid invoices of User </a></li>\r\n    <li onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=Admin');\">\r\n     <a><span>";
    echo $cntunpa;
    echo "</span> Invoices of Admin</a>\r\n    </li>\r\n";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
    echo "\r\n    ";
}
if ($vals[6]) {
    echo "    <li onclick=\"javascript:redirectedit('support.ticket','1');\">\r\n    <a><span >";
    echo $vals[6];
    echo "</span> New tickets </a></li>\r\n";
}
if ($vals[7]) {
    echo "    <li onclick=\"javascript:redirectedit('support.ticket','4&laoddefaultpage=support.open.php');\">\r\n    <a></a><span >";
    echo $vals[7];
    echo "</span>  Waiting tickets</a>\r\n    </li>\r\n";
}
if ($cntbc) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.comments','');\">\r\n    <a><span>";
    echo $cntbc;
    echo "</span> New blog comments</a>\r\n    </li>\r\n";
}
if ($cnttst) {
    echo "    <li  onclick=\"javascript:redirectedit('dashboard.testimonial','');\">\r\n    <a><span>";
    echo $cnttst;
    echo "</span> New testimonial</a>\r\n    </li>\r\n";
}
if ($cntwat) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.userstatus','');\">\r\n    <a><span>";
    echo $cntwat;
    echo "</span> User waiting for activation</a>\r\n    </li>\r\n";
}
if ($cntpendingrr) {
    echo "    <li  onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.return.php','');\">\r\n    <a><span>";
    echo $cntpendingrr;
    echo "</span> Pending Return request</a>\r\n    </li>\r\n";
}
if ($cntsuppro) {
    echo "    <li onclick=\"javascript:redirectedit('catlog&defaultloadpage=resellerlist.php','');\">\r\n    <a><span>";
    echo $cntsuppro;
    echo "</span> Suppliers product waiting for approval</a>\r\n    </li>\r\n";
}
if ($cntimeireview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_imei.php','&status=pending');\">\r\n    <a><span>";
    echo $cntimeireview;
    echo "</span> Pending IMEI service review</a>\r\n    </li>\r\n";
}
if ($cntserverreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_server.php','&status=pending');\">\r\n    <a><span>";
    echo $cntserverreview;
    echo "</span> Pending Server service review</a>\r\n    </li>\r\n";
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_shop.php','&status=pending');\">\r\n    <a><span>";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\r\n    </li>\r\n";
}
echo "\r\n      </ul>\r\n    </div>\r\n\r\n    </div>\r\n\r\n\r\n<style>\r\n    #deshbordsub{width:100%;padding:10px}\r\n    #deshbordsub td{\r\n        border-bottom: 1px dotted #F4F4F4;\r\n        color: #666666;\r\n        font-size: 16px;\r\n        padding: 7px 2px;\r\n    }\r\n    #deshbordsub td a{color:#888;text-decoration: none;}\r\n    #deshbordsub th{padding:2px 2px;border-bottom:#ccc solid 1px;}\r\n\r\n    #deshbordsub.IMEI th{border-color:#f0aa65}\r\n    #deshbordsub.File th{border-color:#c4bfd9}\r\n    #deshbordsub.Server th{border-color:#90c0db}\r\n    #deshbordsub.Shop th{border-color:#a4cc8a}\r\n\r\n    #deshbordsub th{background: transparent !important;}\r\n    #deshbordsub th strong{color:#888;font-weight: normal;text-shadow:0 1px 1px white;font-size:11px;}\r\n    #deshbordsub td strong{font-weight: normal;}\r\n</style>\r\n\r\n    <div class=\"colm2 floatleft\" style=\"text-align: center;width:66%;\">\r\n\r\n    ";
$allset = base64_encode($cntin . "-" . $cntia . "-" . $cntfn . "-" . $cntfa . "-" . $cntsn . "-" . $cntsa . "-" . $cnttckn . "-" . $cnttckw . "-" . $cntpn . "-" . $cntpa);
echo "    <ul id=\"tabmenu\" class=\"dashboardtab\" style=\"margin: 0 0 0 10px;position: relative;left:0;top:0\">\r\n        <li><a onclick=\"getContect('#tab1','main2.php?page=dashboard.topservice','','','#tabcontent',true,'#main_loader');\" class=\"tabmenu_active\" id=\"tab1\">Top 10 Selling Services</a></li>\r\n        <li><a onclick=\"getContect('#tab2','main2.php?page=dashboard.happyhours','','','#tabcontent',true,'#main_loader');\"  id=\"tab2\" >";
echo $LNG["happyhours"];
echo " ";
echo $LNG["service"];
echo "</a></li>\r\n        <li><a onclick=\"getContect('#tab3','main2.php?page=dashboard.mostviewable','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["mostviewable"];
echo " ";
echo $LNG["products"];
echo "</a></li>\r\n        <li><a onclick=\"getContect('#tab5','main2.php?page=dashboard.apistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >APi ";
echo $LNG["status"];
echo "</a></li>\r\n        ";
if (!$fusionlite) {
    echo "            <li><a onclick=\"getContect('#tab4','main2.php?page=dashboard.twitterfeed','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >DHRU ";
    echo $LNG["news"];
    echo "</a></li>\r\n        ";
}
echo "        <div style=\"clear: both;\"></div>\r\n    </ul>\r\n\r\n  <div class=\"flexcroll\"   style=\"margin-top: 10px;min-height:350px;\">\r\n    <div  id='tabcontent' style=\"margin-top: 0px;\">\r\n        ";
if (!$sub) {
    include "includes/pages/dashboard.topservice.php";
} else {
    include $sub . ".php";
}
echo "    </div>\r\n </div>\r\n\r\n\r\n\r\n    </div>\r\n    <div class=\"clear\"></div>\r\n</div>\r\n    <div class=\"clear\"></div>\r\n\r\n\r\n<script type=\"text/javascript\">\r\n\r\n\r\n    var chart;\r\n    \$(document).ready(function() {\r\n\r\n   chart = new Highcharts.Chart({\r\n            chart: {\r\n                renderTo: 'container',\r\n                type: 'areaspline'\r\n            },\r\n            title: {\r\n                text: '";
echo $LNG["annually"];
echo " ";
echo $LNG["completed"];
echo " ";
echo $LNG["orders"];
echo "',\r\n                align:'left'\r\n            },\r\n            legend: {\r\n                layout: 'horizontal',\r\n                align: 'right',\r\n                verticalAlign: 'top',\r\n                x: 0,\r\n                y: -5,\r\n                floating: true,\r\n                borderWidth: 0,\r\n                backgroundColor: 'transparent'\r\n            },\r\n            xAxis: {\r\n                categories: [\r\n                    'Jan',\r\n                    'Feb',\r\n                    'Mar',\r\n                    'Apr',\r\n                    'May',\r\n                    'Jun',\r\n                    'Jul',\r\n                    'Aug',\r\n                    'Sep',\r\n                    'Oct',\r\n                    'Nov',\r\n                    'Dec'\r\n                ]\r\n            },\r\n            yAxis: {\r\n                title: {\r\n                    text: ''\r\n                }\r\n            },\r\n            tooltip: {\r\n                formatter: function() {\r\n                    return ''+\r\n                    this.x +': '+ this.y +' Orders';\r\n                }\r\n            },\r\n            credits: {\r\n                enabled: false\r\n            },\r\n            plotOptions: {\r\n                areaspline: {\r\n                    fillOpacity: 0.5\r\n                }\r\n            },\r\n             series: [{\r\n                 name: 'IMEI',\r\n                 data: [";
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
echo "]\r\n              },{\r\n                 name: 'File',\r\n                 data: [";
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
echo "]\r\n              }, {\r\n                 name: 'Server',\r\n                 data: [";
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
echo "]\r\n              }, {\r\n                 name: 'Shop',\r\n                 data: [";
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
echo "]\r\n              }]\r\n        });\r\n\r\n\r\n\r\n    \$('.progress').animate({  borderSpacing: ";
echo $totaldeg;
echo " }, {\r\n        step: function(now,fx) {\r\n          \$(this).rotate(now);\r\n        },\r\n        duration:'slow'\r\n    },'linear');\r\n\r\n\r\n      \$('#imei').cprogress({img1: 'templates/";
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
echo "});\r\n        \$('#file').cprogress({img1: 'templates/";
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
echo "});\r\n        \$('#server').cprogress({img1: 'templates/";
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
echo "});\r\n        \$('#shop').cprogress({img1: 'templates/";
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
echo "});\r\n\r\n\r\n     });\r\n\r\n</script>\r\n";
$fileverioncheck = "6.1.0";

?>