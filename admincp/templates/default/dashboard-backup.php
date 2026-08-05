<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.tabloader {    \n    padding: 11px;    \n}\n</style>\n\n<link href=\"templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.css\" media=\"screen\" rel=\"stylesheet\"/>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/dashboard.js\"></script>\n<div title=\"dashboard\" id=\"tutid\"></div>\n";
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
$array = [" datepaid LIKE '" . $today . "%'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%m')='" . $month . "' \n            and from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'", "from_unixtime(UNIX_TIMESTAMP(datepaid),'%Y')='" . $year . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(subtotal+shippingtax) as income from " . $tbl . " where " . $value);
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
if (!$mobilebrowser) {
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
    echo "  \n\n<div style=\"background: white;margin-right:-176px;\">\n    <div class=\"floatleft dperfor\">\n";
    if (!$config["litedashboard"]) {
        echo "    \n       <script src=\"templates/";
        echo $_SESSION["admin_template"];
        echo "/js/jQueryRotate.2.2.js\"></script>\n        <div style=\"text-align: center;\" class=\"performance\">              \n            <span style=\"font-size: 16px;color:#888\">System Performance</span><br />       \n            <span style=\"font-size: 45px;font-weight: bold;color:#888\">";
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
        echo "</span></li>                \n                         </ul>                \n                     </div>\n               </div>                     \n        </div>\n          <script type=\"text/javascript\">    \n              \$(document).ready(function() {  \n                \$('.progress').animate({  borderSpacing: ";
        echo $totaldeg;
        echo " }, {\n                    step: function(now,fx) {\n                      \$(this).rotate(now);                           \n                    },\n                    duration:'slow'\n                },'linear');  \n              });  \n          </script>\n";
    } else {
        echo "<span class='disabledesign'>Disabled</span>";
    }
    echo "        \n    </div>\n    \n\n\n<script src=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/js/highcharts.js\"></script>\n\n<div class=\"colm2 floatleft graph\">             \n    <div style=\"text-align: center;min-height:220px;\">\n            <img src=\"images/ajax_loading_new.gif\" style=\"margin-top: 100px;\" />  \n         </div> \n</div>\n \n";
}
echo " \n  \n    \n    <div class=\"floatright dincome\">\n        <div style=\"text-align: center;position: relative;width:210px;margin:auto\" class=\"income\" id=\"today\">\n                 \n         \n            <span style=\"font-size: 16px;color:#888\">";
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
echo "</li>\n                <div class=\"clear\"></div>                            \n            </ul>                                 \n        </div>        \n    </div>\n \n\n   \n    \n    <hr class=\"ford\" />\n     <div class=\"colm5 floatleft wticket\">\n        <div style=\"text-align: center;width:230px;margin:auto\">  \n            <span style=\"color: #888;font-size:16px;display:block;margin-bottom: 15px;\">Waiting for reply ticket</span>\n           <br />\n            <div class=\"clear\"></div>                          \n            \n            ";
$result = dquery("SELECT sid,tid, 1 as total FROM tbl_support_tickets where (sid='4' or sid='1') AND did IN (" . $_SESSION["department"] . ") GROUP BY tid");
while ($row = mysqli_fetch_assoc($result)) {
    $ticket[$row["sid"]] += $row["total"];
}
echo " \n           \n           <span style=\"font-size: 40px;font-weight: bold;color:#888;text-shadow:0 1px 1px white; border:#f4f4f4 solid 1px;background: #fafafa; border-radius:50%;height:60px;line-height:60px;width:60px;display: block;margin:8px auto;float:left\">";
echo $ticket[1] + $ticket[4];
echo "</span>\n           <ul style=\"text-align: left;list-style: none;float:left;margin-left:5px;margin-top:18px;position: relative;width:163px\" class=\"ticket\">           \n                <li style=\"\"><a onclick=\"javascript:load_fromsubpage('support.open&id=1','Open Ticket');\" style=\"color: #666;font-size:16px\">";
echo $ticket[1];
echo " - ";
echo $LNG["open"];
echo " ";
echo $LNG["ticket"];
echo "</a></li>                \n                <li style=\"\"><a onclick=\"javascript:load_fromsubpage('support.open&id=5','Customer Reply');\" style=\"color: #666;font-size:16px\">";
echo $ticket[4];
echo " - ";
echo $LNG["customer"];
echo "  ";
echo $LNG["reply"];
echo "</a></li>\n                <div class=\"clear\"></div>              \n            </ul>\n                        \n            <div class=\"clear\"></div>\n        </div>\n    </div>\n\n \n\n \n <script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/jCProgress-1.0.2.js\"></script>  \n \n <div style=\"display: none !important;\" class=\"preload\">\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v1.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v2.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v3.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v4.png\" />\n    <img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/v5.png\" class=\"v5\" />\n</div>\n\n\n\n\n    <div class=\"colm2 floatleft dcircle\">\n         <div style=\"text-align: center;min-height:159px;\">\n            <img src=\"images/ajax_loading_new.gif\" style=\"margin-top: 65px;\"/>  \n         </div>   \n    </div>\n  \n  \n  \n        \n    <div class=\"colm5 floatright dlinks\">\n        <div style=\"text-align: center;\">            \n            <ul style=\"text-align: left;margin-left:25px\" class=\"quicklink\">\n                <li><a href=\"javascript:load_fromsubpage('unpaidinvoice','Unpaid Invoices')\">";
echo $LNG["unpaid"];
echo " ";
echo $LNG["invoices"];
echo "</a></li>\n                <li><a href=\"javascript:load_fromsubpage('utilities.resellershop','Reseller Store')\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["store"];
echo "</a></li>\n                <li><a href=\"javascript:load_fromsubpage('utilities.discountcheck','Discount by service')\">";
echo $LNG["discount"];
echo " ";
echo $LNG["by"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n                <li><a href=\"javascript:load_fromsubpage('ebayorder','Direct Order')\">";
echo $LNG["imei"];
echo " ";
echo $LNG["direct"];
echo " ";
echo $LNG["order"];
echo "</a></li>\n                <li><a href=\"javascript:load_fromsubpage('utilities.adminactivities','Login Log')\">";
echo $LNG["login"];
echo " ";
echo $LNG["log"];
echo "</a></li>\n            </ul>\n        </div>\n    </div>\n    \n       \n  \n  \n  \n  <div class=\"circledetails\">\n        <div style=\"text-align: center;\">   \n        <hr />\n          <h4>Pending Order Details</h4>  \n            \n           <ul>\n            \n           <div class=\"floatleft circle\" style=\"margin-right:0;display: block;\">   \n            <li>\n                <ul>\n                    <table cellpadding=\"0\" cellspacing=\"0\"   class=\"org\"><tr><td>IMEI </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_imei"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiquickaccept.php','IMEI New');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysnew"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.replied.php','IMEI Accepted');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysaccepted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.history.php','IMEI Completed');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todayscompleted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.history.php','IMEI Rejected');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_imei"]["todaysrejected"];
echo "</span><div class=\"clear\"></div></li>\n                        </ol> \n                     \n";
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
    echo "</span></li>\n    <li class=\"label\"><a onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.verification.php','IMEI Verify');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_imei"]["verify"];
    echo "</span><div class=\"clear\"></div></li>\n";
}
echo "                    \n                </ul>\n            </li>            \n           </div>\n           \n           <div class=\"floatleft circle\" style=\"margin-right:0;\"> \n            <li>\n                <ul >\n                    <table cellpadding=\"0\" cellspacing=\"0\"  class=\"violet\"><tr><td>File </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_file"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=filequickaccept.php','File New');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysnew"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.repllied.php','File Accepted');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysaccepted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.history.php','File Complted');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_file"]["todayscompleted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.history.php','File Rejected');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_file"]["todaysrejected"];
echo "</span><div class=\"clear\"></div></li>\n                        </ol> \n                   \n";
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
    echo "</span></li>\n                    <li class=\"label\"><a onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.verification.php','File Verify');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_file"]["verify"];
    echo "</span><div class=\"clear\"></div></li>\n";
}
echo "                    \n                </ul>\n            </li>\n           </div>\n           \n           <div class=\"floatleft circle\" style=\"margin-right:0;\">  \n            <li>\n                <ul >\n                    <table cellpadding=\"0\" cellspacing=\"0\"  class=\"blue\"><tr><td>Server </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_server"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverquickaccept.php','Server New');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysnew"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.replied.php','Server Accepted');\">";
echo $LNG["accepted"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysaccepted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.history.php','Server Completed');\">";
echo $LNG["completed"];
echo " </a><span>";
echo $order["tbl_order_server"]["todayscompleted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.history.php','Server Rejected');\">";
echo $LNG["rejected"];
echo " </a><span>";
echo $order["tbl_order_server"]["todaysrejected"];
echo "</span><div class=\"clear\"></div></li>\n                        </ol> \n                  \n";
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
    echo "</span></li>\n                    <li class=\"label\"><a onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.verification.php','Server Verify');\">";
    echo $LNG["order"];
    echo " ";
    echo $LNG["for"];
    echo " ";
    echo $LNG["verification"];
    echo " </a><span>";
    echo $order["tbl_order_server"]["verify"];
    echo "</span><div class=\"clear\"></div></li>\n";
}
echo "                    \n                </ul>\n            </li>\n            </div>\n           \n           <div class=\"floatleft circle\" style=\"margin-right:0;\"> \n            <li>\n                <ul >\n                    <table cellpadding=\"0\" cellspacing=\"0\"  class=\"green\"><tr><td>Shop </td></tr></table>                    \n                    <li class=\"label\"> ";
echo $LNG["todays"];
echo " <span>";
echo $order["tbl_order_product"]["todaystotal"];
echo "</span></li>    \n                        <ol>               \n                            <li><a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.new.php','Product New');\">";
echo $LNG["new"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysnew"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.replied.php','Product Inprocess');\">";
echo $LNG["inprocess"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysaccepted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.pending.php','Product Pending');\">";
echo $LNG["pending"];
echo " </a><span>";
echo $order["tbl_order_product"]["todayscompleted"];
echo "</span><div class=\"clear\"></div></li>\n                            <li><a onclick=\"javascript:load_fromsubpage('productorder&laoddefaultpage=productorder.return.php','Product Return');\">";
echo $LNG["returns"];
echo " </a><span>";
echo $order["tbl_order_product"]["todaysrejected"];
echo "</span><div class=\"clear\"></div></li>\n                        </ol> \n  ";
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
echo "                                                             \n                </ul>\n            </li>\n            \n            \n            </div>\n            <div class=\"clear\"></div>           \n           </ul>             \n                     \n        </div>\n    </div>\n    \n    \n \n  \n    <hr  class=\"ford\"/>              \n \n  \n    <div class=\"colm2 flexcroll floatleft dation\">\n        <span style=\"font-size: 16px;color:#888;\">Action Required (To Do)</span><br />         \n     <div class=\"\" style=\"margin-top:8px;\">   \n      <ul class=\"todo\" style=\"text-align: left;\">\n\n";
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
    echo "    \n    <li onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiquickaccept.php','IMEI Quick Accepted');\">\n<a><span>";
    echo $vals[0];
    echo " </span>  New IMEI Orders</a></li>\n";
}
if ($vals[1]) {
    echo "<li onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=quickreply.php','IMEI Quick Reply');\">\n<a><span>";
    echo $vals[1];
    echo "</span> Pending IMEI Orders</a>\n    </li>\n";
}
if ($vals[2]) {
    echo "    \n    <li onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=filequickaccept.php','File Quick Accepted');\">\n<a><span>";
    echo $vals[2];
    echo " </span> New File Orders </a></li>\n";
}
if ($vals[3]) {
    echo " <li onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.repllied.php','File Replied');\">\n <a><span>";
    echo $vals[3];
    echo "</span> Pending File Orders</a></li>    \n";
}
if ($vals[4]) {
    echo "      \n    <li onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverquickaccept.php','Server Quick Accepted');\">\n <a><span>";
    echo $vals[4];
    echo "</span> New Server Orders </a></li>\n ";
}
if ($vals[5]) {
    echo " <li  onclick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.replied.php','Server Replied');\">\n  <a><span>";
    echo $vals[5];
    echo "</span> Pending Server Orders</a></li> \n";
}
if ($vals[8]) {
    echo "       \n    <li onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.new.php&id=1','Product New');\">\n  <a><span>";
    echo $vals[8];
    echo " </span> New Shop orders</a></li> \n  ";
}
if ($vals[9]) {
    echo "  <li onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.pending.php','Pending Shop orders');\">\n  <a><span >";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\n    </li> \n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    ";
}
if ($cntwithdrawal) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.withdrawal','Pending withdrawal request');\">\n   <a> <span>";
    echo $cntwithdrawal;
    echo "</span> Pending withdrawal request</a>\n    </li> \n";
}
if ($cntpq) {
    echo "  \n    <li  onclick=\"javascript:load_fromsubpage('utilities.pendingquick','Quick checkout pending orders');\">\n   <a> <span>";
    echo $cntpq;
    echo "</span> Quick checkout pending orders</a>\n    </li>\n";
}
if ($cntcc) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('utilities.ccprocess','Orders waiting for offline Credit Card Process');\">\n    <a><span>";
    echo $cntcc;
    echo "</span> Orders waiting for offline Credit Card Process</a>\n    </li>\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <li onclick=\"javascript:load_fromsubpage('unpaidinvoice&bywhom=User','Unpaid invoices of User');\">\n    <a><span>";
    echo $cntunpu;
    echo "</span> Unpaid invoices of User </a></li>\n    <li onclick=\"javascript:load_fromsubpage('unpaidinvoice&bywhom=Admin','Invoices of Admin');\">\n     <a><span>";
    echo $cntunpa;
    echo "</span> Invoices of Admin</a>\n    </li>  \n";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
    echo "\n    ";
}
if ($_SESSION["department"]) {
    $department = $_SESSION["department"];
} else {
    $department = "958959595959595";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=1 group by tid"));
if ($newtickets) {
    echo "       \n    <li onclick=\"javascript:load_fromsubpage('support.open&id=1','New tickets ');\">\n    <a><span >";
    echo $newtickets;
    echo "</span> New tickets </a></li> \n";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=4 group by tid"));
if ($newtickets) {
    echo "    \n    <li onclick=\"javascript:load_fromsubpage('support.open&id=4','Waiting tickets');\"> \n    <a></a><span >";
    echo $newtickets;
    echo "</span>  Waiting tickets</a>\n    </li> \n";
}
if ($cntbc) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.comments','New blog comments');\">\n    <a><span>";
    echo $cntbc;
    echo "</span> New blog comments</a>\n    </li>\n";
}
if ($cnttst) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('dashboard.testimonial','New testimonial');\">\n    <a><span>";
    echo $cnttst;
    echo "</span> New testimonial</a>\n    </li>\n";
}
if ($cntwat) {
    echo "     \n    <li onclick=\"javascript:load_fromsubpage('utilities.userstatus','User waiting for activation');\">\n    <a><span>";
    echo $cntwat;
    echo "</span> User waiting for activation</a>\n    </li>  \n";
}
if ($cntpendingrr) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.return.php','Pending Return request');\">\n    <a><span>";
    echo $cntpendingrr;
    echo "</span> Pending Return request</a>\n    </li>\n";
}
if ($cntsuppro) {
    echo "     \n    <li onclick=\"javascript:load_fromsubpage('catlog&defaultloadpage=resellerlist.php','Suppliers product waiting for approval');\">\n    <a><span>";
    echo $cntsuppro;
    echo "</span> Suppliers product waiting for approval</a>\n    </li>  \n";
}
if ($cntimeireview) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_imei.php&status=pending','Pending IMEI service review');\">\n    <a><span>";
    echo $cntimeireview;
    echo "</span> Pending IMEI service review</a>\n    </li>\n";
}
if ($cntserverreview) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_server.php&status=pending','Pending Server service review');\">\n    <a><span>";
    echo $cntserverreview;
    echo "</span> Pending Server service review</a>\n    </li>\n";
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_shop.php&status=pending','Pending Product review');\">\n    <a><span>";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\n    </li>\n";
}
echo " \n\n      </ul>  \n    </div>    \n        \n    </div>\n \n \n<style>\n    #deshbordsub{width:100%;padding:10px}\n    #deshbordsub td{\n        border-bottom: 1px dotted #F4F4F4;\n        color: #666666;\n        font-size: 16px;\n        padding: 7px 2px;        \n    }\n    #deshbordsub td a{color:#888;text-decoration: none;}\n    #deshbordsub th{padding:2px 2px;border-bottom:#ccc solid 1px;}\n    \n    #deshbordsub.IMEI th{border-color:#f0aa65}\n    #deshbordsub.File th{border-color:#c4bfd9}\n    #deshbordsub.Server th{border-color:#90c0db}\n    #deshbordsub.Shop th{border-color:#a4cc8a}\n    \n    #deshbordsub th{background: transparent !important;}\n    #deshbordsub th strong{color:#888;font-weight: normal;text-shadow:0 1px 1px white;font-size:11px;}\n    #deshbordsub td strong{font-weight: normal;}\n</style>\n  \n ";
if (!$mobilebrowser) {
    echo "   \n    <div class=\"colm2 floatleft dtabs\">\n    \n    ";
    $allset = base64_encode($cntin . "-" . $cntia . "-" . $cntfn . "-" . $cntfa . "-" . $cntsn . "-" . $cntsa . "-" . $cnttckn . "-" . $cnttckw . "-" . $cntpn . "-" . $cntpa);
    echo "    <ul id=\"tabmenuinner\" class=\"dashboardtab\" style=\"margin: 0 0 0 10px;position: relative;left:0;top:0;z-index:0\">        \n        <li><a onclick=\"getContect('#tab1','main2.php?page=dashboard.topservice','','','#tabcontent',true,'#main_loader');\"  id=\"tab1\">Top 10 Selling Services</a></li>\n        <li><a onclick=\"getContect('#tab2','main2.php?page=dashboard.happyhours','','','#tabcontent',true,'#main_loader');\" class=\"tabmenu_active\" id=\"tab2\" >";
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
    echo "        <div style=\"clear: both;\"></div> \n    </ul>\n  \n  <div class=\"flexcroll dashboardtabc\"   style=\"margin-top: 10px;min-height:300px;\">     \n    <div  id='tabcontent' style=\"margin-top: 0px;\">\n        ";
    if (!$sub) {
        include "includes/pages/dashboard.happyhours.php";
    } else {
        include $sub . ".php";
    }
    echo "    </div>\n </div>   \n \n    </div>\n    <div class=\"clear\"></div>\n";
}
echo "    \n</div> \n    <div class=\"clear\"></div>\n    \n\n<script>\n    \$(document).ready(function(){        \n        \$.post('templates/default/dashboard.graph.php',function (data, success, textStatus) {            \n            \$('.graph').html(data);                        \n        });\n        \$.post('templates/default/dashboard.circle.php',function (data, success, textStatus) {            \n            \$('.dcircle').html(data);                        \n        });\n    })\n</script>\n";

?>