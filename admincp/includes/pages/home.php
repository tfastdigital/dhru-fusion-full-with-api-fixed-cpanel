<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/js/highcharts.js\"></script>\n<!--[if IE]><script type=\"text/javascript\" src=\"includes/js/excanvas.compiled.js\"></script><![endif]-->\n<script src=\"includes/js/jquery.columnhover.js\" type=\"text/javascript\"></script>\n<script src=\"includes/js/chili.js\" type=\"text/javascript\"></script>\n<script>\n\$(document).ready(function() {\n   \$('#deshbordsub').columnHover({eachCell:true, hoverClass:'betterhover'});\n});\n</script>\n<style>\n.leftarrow,.rightarrow{height: 35px;width: 15px;display: block;margin-top: -4px;}\n.leftarrow{background: url('images/leftar.png') left center;}\n.rightarrow{background: url('images/rightar.png') right center;}\n.leftarrow:hover{background: url('images/leftar.png') right center;}\n.rightarrow:hover{background: url('images/rightar.png') left center;}\n</style>\n<div style=\"min-width: 980px;\">\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "        <div id=\"notification\" class=\"alert\">\n            ";
    echo $LNG["maintancemodeon"];
    echo "        </div>\n        ";
}
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` \nwhere `default`='1'"));
$table = ["tbl_order_product"];
$array = ["date='" . $today . "'", "from_unixtime(time,'%m')='" . $month . "' \n            and from_unixtime(time,'%Y')='" . $year . "'", "from_unixtime(time,'%Y')='" . $year . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(credit-discount) as income,currency_id \n        from " . $tbl . " where " . $value . " and user_can_c='4' group by currency_id");
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
$table = ["tbl_order_product"];
$array = ["date='" . $yesterday . "'", "from_unixtime(time,'%m')='" . $pmonth . "' \n            and from_unixtime(time,'%Y')='" . $pyear . "'", "from_unixtime(time,'%Y')='" . $pyear . "'"];
foreach ($array as $value) {
    foreach ($table as $tbl) {
        $result = dquery("select sum(credit-discount) as income,\n        currency_id from " . $tbl . " where " . $value . " and user_can_c='4' group by currency_id");
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
$todaypreject = mysqli_num_rows(dquery("select order_id from tbl_order_product where reply_date='" . $today . "' and (user_can_c='3')"));
$yespreject = mysqli_num_rows(dquery("select order_id from tbl_order_product where reply_date='" . $yesterday . "' and (user_can_c='3')"));
echo "\n\n<div align=\"center\" style=\"border: 2px dashed #CCC; padding: 8px; margin: 5px;\">\n<!--\n<select>\n";
$result = dquery("select code,id from tbl_currencies");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value=" . $row["id"] . ">" . $row["code"] . "</option>";
}
echo "</select>\n-->\n<script>\nfunction showHid(v){\n       if(v=='todays'){\n            document.getElementById('yesterdays').style.display='';\n            document.getElementById('todays').style.display='none';\n       }else{\n            document.getElementById('yesterdays').style.display='none';\n            document.getElementById('todays').style.display='';\n       }\n}\n</script>\n    <span style=\"font-size: 18px; color: #666 !important;\" id=\"todays\">\n        <div style='float: left;'><a style=\"text-decoration: none;\" title=\"Yesterday / Last Month / Last Year\" onclick=\"javascript:showHid('todays');\"  class=\"leftarrow\"></a></div> ";
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
echo "</strong>\n    </span>\n    <span style=\"font-size: 18px; color: #666 !important; display:none;\" id=\"yesterdays\">\n      ";
echo $LNG["income"];
echo " ";
echo $LNG["yesterday"];
echo " : <strong>";
echo formatCurrency($inctbly[0]["income"]);
echo "</strong>\n    | ";
echo $LNG["last"];
echo " ";
echo $LNG["month"];
echo " : <strong>";
echo formatCurrency($inctbly[1]["income"]);
echo "</strong> |\n    ";
echo $LNG["last"];
echo " ";
echo $LNG["year"];
echo ": <strong>";
echo formatCurrency($inctbly[2]["income"]);
echo "</strong>\n   <div style='float: right;' ><a  style=\"text-decoration: none;\"  onclick=\"javascript:showHid('yesterdays');\" class=\"rightarrow\"></a></div>\n    </span>\n</div>\n<br />\n<style>\n#deshbordsub{width: 97%;}\n#deshbordsub a {color: gray; text-decoration: none;}#deshbordsub a:hover{text-decoration: underline;}\n#deshbordsub td {border-bottom: solid #edeced 1px  ; }\nhr{border-color: #CCCCCC;border-right: 0 none; border-style: solid none none; border-width: 1px 0 0; display: block; height: 1px;margin: 1em 0;padding: 0;}\n.textwhite{color: #edeced !important;}\n.list li{width:200px}\n.list td a,.list li a{color:#888;text-decoration: none;display: block;}\n</style>\n\n<table><tbody><tr>\n\t<td width=\"22%\" valign=\"top\">\n        <table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\">\n            <thead align=\"left\">\n            <td><strong>";
echo $LNG["order"];
echo " ";
echo $LNG["summary"];
echo " </strong></td>\n            <td align=\"center\"><strong>";
echo $LNG["shop"];
echo "</strong></td>\n            </thead>\n            <tr align=\"left\"><td><img src=\"templates/default/images1/shop.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["orders"];
echo "</td>\n            \t\t<td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_product"][0];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/pending.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["pending"];
echo "</td>\n                    <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('productorder','');\" >";
echo $order["tbl_order_product"][1];
echo "</a></span></td>\n            </tr>\n\n\t\t\t<tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["rejected"];
echo "</td>\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $todaypreject;
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["todays"];
echo " ";
echo $LNG["completed"];
echo "</td>\n                    <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_product"][2];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/maintance.png\" /> ";
echo $LNG["order"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["verification"];
echo "</td>\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $order["tbl_order_product"][3];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["orders"];
echo "</td>\n                    <td align=\"center\"><span class=\"textblue bold\">";
echo $order["tbl_order_product"][4];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["pending"];
echo "</td>\n                    <td align=\"center\"><span class=\"textred bold\"><a onClick=\"javascript:redirectedit('productorder','');\" >";
echo $order["tbl_order_product"][5];
echo "</a></span></td>\n            </tr>\n\n\t\t\t<tr align=\"left\"><td><img src=\"templates/default/images1/completed.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["rejected"];
echo "</td>\n                    <td align=\"center\"><span class=\"textred bold\">";
echo $yespreject;
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/yesterday.png\" /> ";
echo $LNG["yesterdays"];
echo " ";
echo $LNG["completed"];
echo " </td>\n                    <td align=\"center\"><span class=\"textgreen bold\">";
echo $order["tbl_order_product"][6];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/total.png\" /> ";
echo $LNG["month"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["date"];
echo " ";
echo $LNG["total"];
echo "</td>\n                    <td align=\"center\"><span class=\"textorange bold\">";
echo $order["tbl_order_product"][7];
echo "</span></td>\n            </tr>\n\n            <tr align=\"left\"><td><img src=\"templates/default/images1/total.png\" /> ";
echo $LNG["year"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["date"];
echo " ";
echo $LNG["total"];
echo " </td>\n                    <td align=\"center\"><span class=\"textblack bold\">";
echo $order["tbl_order_product"][8];
echo "</span></td>\n            </tr>\n        </table>\n\t</td>\n\t<td align=\"right\" width=\"78%\" valign=\"top\">\n\t<style>\n        .contentbox{float: left;width:49%;text-align: left;border: #f4f4f4 solid 1px;margin: 2px;}\n        .contentbox h1{font-size:14px;background: #fafafa;padding: 5px;font-weight: normal;}\n        .contentbox .data{padding:10px;}\n        .contentbox .data ul{margin:0;padding:0}\n        .contentbox .data ul li{float: left;padding:10px 13px;}\n        .label:hover{background: #f4f4f4;}\n\t</style>\n\n\n<div class=\"contentbox\">\n";
$resultstock = dquery("select id,service_name,stock from tbl_products where stock < 5 order by stock limit 0,4");
if ($resultstock) {
    echo "    <h1>Finished item stock (";
    echo mysqli_num_rows(dquery("select id,service_name,stock from tbl_products where stock < 5"));
    echo ") <a style=\"float: right;font-size:11px;margin-top:3px\" onclick=\"load_subpage('main2.php?page=home.finishedstock','Finished Stock');\">";
    echo $LNG["view"];
    echo " ";
    echo $LNG["all"];
    echo "</a></h1>\n    <div class=\"data\" style=\"position: relative;\">\n        <table class=\"list\">\n           <tr><th align=\"left\">Service Name</th><th align=\"left\">Stock</th></tr>\n                ";
    while ($rowstock = mysqli_fetch_assoc($resultstock)) {
        echo "                    <tr><td class=\"label\"><a href=\"javascript:redirectedit('editproduct',";
        echo $rowstock["id"];
        echo ")\">";
        echo $rowstock["service_name"];
        echo "</a></td><td>";
        echo $rowstock["stock"];
        echo "</td></tr>\n                ";
    }
}
echo "       </table>\n   </div>\n</div>\n\n\n<div class=\"contentbox\">\n";
date_default_timezone_set("UTF-8");
$tomorrow = strtotime("+1 days", strtotime(date("11:00:00")));
$now = strtotime(date("H:i:s"));
$diff = $tomorrow - $now;
$min = intval($diff / 60);
$hour = intval($min / 60);
if (24 <= $hour) {
    $hour = $hour - 24;
}
$min = $min % 60;
$resultdeals = dquery("select id,service_name,stock from tbl_products where daily_deal = 1");
if ($resultdeals) {
    echo "        <h1>";
    echo $LNG["on"] . " " . $LNG["deal"];
    echo " (";
    echo mysqli_num_rows($resultdeals);
    echo ")</h1>\n            <div class=\"data\">\n                <table class=\"list\">\n                   <tr><th align=\"left\">Service Name</th><th align=\"left\">Stock</th><th align=\"left\">Left Time</th></tr>\n                    ";
    while ($rowdeals = mysqli_fetch_assoc($resultdeals)) {
        echo "                        <tr><td class=\"label\"><a href=\"javascript:redirectedit('editproduct',";
        echo $rowdeals["id"];
        echo ")\">";
        echo $rowdeals["service_name"];
        echo "</a></td><td>";
        echo $rowdeals["stock"];
        echo "</td><td>";
        echo $hour . ":" . $min . ":00";
        echo "</td></tr>\n                    ";
    }
}
echo "       </table>\n   </div>\n</div>\n\n\n<div class=\"contentbox\" style=\"width: 99%;\">\n    <h1>";
echo $LNG["action"] . " " . $LNG["required"];
echo "</h1>\n    <div class=\"data\">\n        <ul class=\"list\">\n          <li style=\"text-align: center;\"><a href=\"javascript:redirectedit('productorder.new')\"><img src=\"templates/default/images/pendingnew.png\"/><br /> ";
echo $LNG["pending"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo "  (";
echo $cntpn = mysqli_num_rows(dquery("select order_id from tbl_order_product where user_can_c='0'"));
echo ")</a> </li>\n          <li style=\"text-align: center;\"><a href=\"javascript:redirectedit('productorder.replied')\"><img src=\"templates/default/images/pendingaccepted.png\"/><br /> ";
echo $LNG["pending"];
echo " ";
echo $LNG["accepted"];
echo " ";
echo $LNG["order"];
echo " (";
echo $cntpa = mysqli_num_rows(dquery("select order_id from tbl_order_product where user_can_c='1'"));
echo ")</a></li>\n          <li style=\"text-align: center;\"><a href=\"javascript:redirectedit('support.open','4')\"><img src=\"templates/default/images/waitingticket.png\"/><br />";
echo $LNG["waiting"];
echo " ";
echo $LNG["ticket"];
echo "</a></li>\n       </ul>\n   </div>\n</div>\n\n\n</td>\n</tr></tbody></table>\n<br />\n\n\n<ul id=\"tabmenu\">\n<li><a class='tabmenu_active' onclick=\"getContect('#tab8','main2.php?page=dashboard.todo&allset=";
echo $allset;
echo "','','','#tabcontent',true,'#main_loader');\" id=\"tab8\" >Action Required</a></li>\n<li><a onclick=\"getContect('#tab6','main2.php?page=dashboard.orderchart','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >Orders Summary</a></li>\n<li><a onclick=\"getContect('#tab7','main2.php?page=dashboard.dailydealschart','','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >Daily Deals Summary</a></li>\n<li><a onclick=\"getContect('#tab1','main2.php?page=dashboard.topservice.shop','','','#tabcontent',true,'#main_loader');\"  id=\"tab1\" >";
echo $LNG["top"];
echo " 10 ";
echo $LNG["selling"];
echo " ";
echo $LNG["services"];
echo "</a></li>\n<li><a onclick=\"getContect('#tab2','main2.php?page=dashboard.happyhours.shop','','','#tabcontent',true,'#main_loader');\"  id=\"tab2\" >";
echo $LNG["happyhours"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n<li><a onclick=\"getContect('#tab3','main2.php?page=dashboard.mostviewable','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["mostviewable"];
echo " ";
echo $LNG["products"];
echo "</a></li>\n<li><a onclick=\"getContect('#tab5','main2.php?page=dashboard.apistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >APi ";
echo $LNG["status"];
echo "</a></li>\n";
if (!$fusionlite) {
    echo "    <li><a href=\"https://support.dhru.com/Dhru-Fusion/releasenotes/2022/?vid=196&pid=1\" target=\"_blank\"  id=\"tab4\" >Release Notes</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\">\n    <script>\n        getContect('#tab6','main2.php?page=dashboard.orderchart','','','#tabcontent',true,'#main_loader');\n    </script>\n</div>\n\n</div>";
$fileverioncheck = "6.1.0";

?>