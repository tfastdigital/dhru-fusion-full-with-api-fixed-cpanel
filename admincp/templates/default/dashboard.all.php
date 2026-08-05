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
    echo "    <div id=\"notification\" class=\"alert\">\r\n      ";
    echo $LNG["maintancemodeon"];
    echo "    </div>\r\n";
}
$defaultprogress = 3;
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
echo "<div style=\"margin-right: 290px;\">\r\n";
if (!$mobilebrowser && !$OnlyEcommerce) {
    echo "        <div style=\"background:white;\">\r\n          <div class=\"graph\">\r\n            <div style=\"text-align: center;\"> <img src=\"images/ajax_loading_new.gif\" style=\"margin: 100px;\" /> </div>\r\n          </div>\r\n        </div>\r\n        ";
}
echo "\r\n  <div style=\"margin: 40px 0;\">\r\n\r\n      <div class=\"dcircle\">\r\n         <div style=\"text-align: center;min-height:159px;\"> <img src=\"images/ajax_loading_new.gif\" style=\"margin: 65px;\"/> </div>\r\n      </div>\r\n  </div>\r\n\r\n\r\n<script>\r\n    \$(document).ready(function(){\r\n        \$.post('templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.graph.php',function(data, success, textStatus) {\r\n            \$('.graph').html(data);\r\n        });\r\n        \$.post('templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.circle.php',function(data, success, textStatus) {\r\n             \$('.dcircle').html(data);\r\n        });\r\n    })\r\n</script>\r\n  ";
$fileverioncheck = "6.1.0";
echo "\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n      <ul class=\"item-list\"  style=\"width: 300px;float:left;top:20px;box-shadow:none;border-radius:0;display:block;background: white;right:0\">\r\n        <li class=\"tabmenu-header\"> Action Required (To Do) </li>\r\n";
$allset = base64_encode($cntin . "-" . $cntia . "-" . $cntfn . "-" . $cntfa . "-" . $cntsn . "-" . $cntsa . "-" . $cnttckn . "-" . $cnttckw . "-" . $cntpn . "-" . $cntpa);
$condition = ["totalnew" => " user_can_c='0'", "totalaccepted" => " user_can_c='1'", "todaystotal" => "date='" . $today . "' and (1=1)", "todaysnew" => "  date='" . $today . "' and user_can_c='0'", "todaysaccepted" => " date='" . $today . "' and user_can_c='1'", "todaysrejected" => " date='" . $today . "' and user_can_c='3'", "todayscompleted" => " reply_date='" . $today . "' and (user_can_c='4')", "verify" => "verified='1' and user_can_c='4'", "yestotal" => " date='" . $yesterday . "' and (1=1)", "yesaccepted" => " date='" . $yesterday . "' and user_can_c='1'", "yescompleted" => " reply_date='" . $yesterday . "' and ( user_can_c='4')", "frommonth" => "MONTH(date)='" . $month . "' and YEAR(date)='" . $year . "'", "fromyear" => "YEAR(date)='" . $year . "'"];
foreach ($condition as $key => $cnd) {
    foreach ($table as $tbl) {
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total\r\n         from " . $tbl . " where " . $cnd));
        $order[$tbl][$key] = $ord["total"];
    }
}
$allset = $order["tbl_order_imei"]["totalnew"] . "-" . $order["tbl_order_imei"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_server"]["totalnew"] . "-" . $order["tbl_order_server"]["totalaccepted"] . "-" . $order["tbl_order_file"]["totalnew"] . "-" . $order["tbl_order_file"]["totalaccepted"] . "-" . $order["tbl_order_product"]["totalnew"] . "-" . $order["tbl_order_product"]["totalaccepted"];
$vals = explode("-", $allset);
$cntbc = mysqli_num_rows(dquery("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id"));
$cntrv = mysqli_num_rows(dquery("SELECT * from tbl_review where status='0'"));
$cnttst = mysqli_num_rows(dquery("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'"));
$cntpq = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE user_can_c='6' and `server`=0"));
$cntcc = mysqli_num_rows(dquery("SELECT id FROM `tbl_invoices` WHERE\r\n status='Unpaid' and paymentmethod='cc'"));
$cntwat = mysqli_num_rows(dquery("SELECT * FROM `tblUsers`\r\n  WHERE userstatus=2 and is_registered=0"));
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
$cntoverdrive = mysqli_num_rows(dquery("select id from tblUsers \r\nwhere overdrive>0"));
$ordertime = time() - 86400;
$cntimeiapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei \r\nwhere server=0 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
$cntserverapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei \r\nwhere server=1 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
$cntsuppro = mysqli_num_rows(dquery("SELECT * FROM tbl_products  WHERE active=0 and bysupplier!=''"));
$cntiv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE verified=1 and `server`=0"));
$cntfv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_file` WHERE verified=1"));
$cntsv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE verified=1 and `server`=1"));
$cntprofit = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE user_can_c=3 and refunded=1  and `server`=0"));
$cntquick = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE user_can_c=6  and `server`=0"));
$cntverifyapi = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE autosend=1 and user_can_c=0  and `server`=0"));
if ($vals[0] || $vals[1] || $vals[2] || $vals[3] || $vals[4] || $vals[5] || $vals[8] || $vals[9]) {
    echo "        ";
}
if (!$OnlyEcommerce) {
    if ($cntprofit) {
        echo "        <li onClick=\"javascript:load_fromsubpage('utilities.pendingrefund','Quick Checkout Pending Refund');\"> <a><span class=\"num\">\r\n          ";
        echo $cntprofit;
        echo "          </span>\r\n          ";
        echo $LNG["quick"];
        echo "          ";
        echo $LNG["checkout"];
        echo "          ";
        echo $LNG["pending"];
        echo "          ";
        echo $LNG["refund"];
        echo "          </a></li>\r\n        ";
    }
    if ($cntverifyapi) {
        echo " <li onClick=\"javascript:load_fromsubpage('imeiapiverify',\r\n 'Verify for APi');\"> <a>\r\n <span class=\"num\"> ";
        echo $cntverifyapi;
        echo "          </span>IMEI ";
        echo $LNG["order"];
        echo " Verify for APi</a></li>\r\n";
    }
    if ($cntquick) {
        echo "        <li onClick=\"javascript:load_fromsubpage('utilities.pendingquick','";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["gateway"];
        echo " ";
        echo $LNG["pending"];
        echo " ";
        echo $LNG["review"];
        echo "');\"> <a><span class=\"num\">\r\n          ";
        echo $cntquick;
        echo "          </span>\r\n          ";
        echo $LNG["custom"];
        echo "          ";
        echo $LNG["gateway"];
        echo "          ";
        echo $LNG["pending"];
        echo "          ";
        echo $LNG["review"];
        echo "          </a></li>\r\n        ";
    }
    if ($vals[0]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiquickaccept.php','IMEI Quick Accepted');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[0];
        echo "          </span> New IMEI Orders</a></li>\r\n        ";
    }
    if ($vals[1]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=quickreply.php','IMEI Quick Reply');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[1];
        echo "          </span> Pending IMEI Orders</a> </li>\r\n        ";
    }
    if ($vals[2]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=filequickaccept.php','File Quick Accepted');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[2];
        echo "          </span> New File Orders </a></li>\r\n        ";
    }
    if ($vals[3]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.repllied.php','File Replied');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[3];
        echo "          </span> Pending File Orders</a></li>\r\n        ";
    }
    if ($vals[4]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverquickaccept.php','Server Quick Accepted');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[4];
        echo "          </span> New Server Orders </a></li>\r\n        ";
    }
    if ($vals[5]) {
        echo "        <li onClick=\"javascript:load_fromsubpage('serverorder&laoddefaultpage=serverorder.replied.php','Server Replied');\"> <a><span class=\"num\">\r\n          ";
        echo $vals[5];
        echo "          </span> Pending Server Orders</a></li>\r\n        ";
    }
    if ($cntiv) {
        echo " <li onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.verification.php','IMEI Verification');\"> <a><span class=\"num\">\r\n          ";
        echo $cntiv;
        echo "    </span> IMEI orders for verification</a></li>\r\n";
    }
    if ($cntfv) {
        echo "        <li  onclick=\"javascript:load_fromsubpage('fileorder&laoddefaultpage=fileorder.verification.php','File Verification');\"> <a><span class=\"num\">\r\n          ";
        echo $cntfv;
        echo "          </span> File orders for verification</a></li>\r\n        ";
    }
    if ($cntsv) {
        echo "        <li  onclick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.verification.php&stype=server','Server Verification');\"> <a><span class=\"num\">\r\n          ";
        echo $cntsv;
        echo "          </span> Servers orders for verification</a></li>\r\n        ";
    }
}
if ($vals[8]) {
    echo "        <li onClick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.new.php&id=1','Product New');\"> <a><span class=\"num\">\r\n          ";
    echo $vals[8];
    echo "          </span> New Shop orders</a></li>\r\n        ";
}
if ($vals[9]) {
    echo "        <li onClick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.pending.php','Pending Shop orders');\"> <a><span  class=\"num\">\r\n          ";
    echo $vals[9];
    echo "          </span> Pending Shop orders</a> </li>\r\n        ";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
}
if ($cntwithdrawal) {
    echo "        <li onClick=\"javascript:load_fromsubpage('utilities.withdrawal','Pending withdrawal request');\"> <a> <span class=\"num\">\r\n          ";
    echo $cntwithdrawal;
    echo "          </span> Pending withdrawal request</a> </li>\r\n        ";
}
if (!$OnlyEcommerce && $cntpq) {
    echo "        <li  onclick=\"javascript:load_fromsubpage('utilities.pendingquick','Quick checkout pending orders');\"> <a> <span  class=\"num\">\r\n          ";
    echo $cntpq;
    echo "          </span> Quick checkout pending orders</a> </li>\r\n        ";
}
if ($cntcc) {
    echo "        <li  onclick=\"javascript:load_fromsubpage('utilities.ccprocess','Orders waiting for offline Credit Card Process');\"> <a><span class=\"num\">\r\n          ";
    echo $cntcc;
    echo "          </span> Orders waiting for offline Credit Card Process</a> </li>\r\n        ";
}
if ($cntunpu || $cntunpa) {
    echo "\r\n        <li onClick=\"javascript:load_fromsubpage('invoicereport&bywhom=User','Unpaid invoices of User');\"> <a><span class=\"num\">\r\n          ";
    echo $cntunpu;
    echo "          </span> Unpaid invoices of User </a></li>\r\n\r\n        <li onClick=\"javascript:load_fromsubpage('unpaidinvoi' +\r\n         'ce&bywhom=Admin','Invoices of Admin');\"> <a><span class=\"num\">\r\n          ";
    echo $cntunpa;
    echo "          </span> Invoices of Admin</a> </li>\r\n        ";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
    echo "        ";
}
if ($_SESSION["department"]) {
    $department = $_SESSION["department"];
} else {
    $department = "958959595959595";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\r\n    where did in (" . $department . ") and sid=1 group by tid"));
if ($newtickets) {
    echo "        <li onClick=\"javascript:load_fromsubpage('support.open&id=1','New tickets ');\"> <a><span class=\"num\">\r\n          ";
    echo $newtickets;
    echo "          </span> New tickets </a></li>\r\n        ";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\r\n    where did in (" . $department . ") and sid=4 group by tid"));
if ($newtickets) {
    echo "        <li onClick=\"javascript:load_fromsubpage('support.open&id=4','Waiting tickets');\"> <a><span class=\"num\">\r\n          ";
    echo $newtickets;
    echo "          </span> Waiting tickets</a> </li>\r\n        ";
}
if ($cntbc) {
    echo "        <li onClick=\"javascript:load_fromsubpage('utilities.comments','New blog comments');\"> <a><span class=\"num\">\r\n          ";
    echo $cntbc;
    echo "          </span> New blog comments</a> </li>\r\n        ";
}
if ($cnttst) {
    echo "        <li  onclick=\"javascript:load_fromsubpage('dashboard.testimonial','New testimonial');\"> <a><span class=\"num\">\r\n          ";
    echo $cnttst;
    echo "          </span> New testimonial</a> </li>\r\n        ";
}
if ($cntwat) {
    echo "        <li onClick=\"javascript:load_fromsubpage('utilities.userstatus','User waiting for activation');\"> <a><span class=\"num\">\r\n          ";
    echo $cntwat;
    echo "          </span> User waiting for activation</a> </li>\r\n        ";
}
if ($cntpendingrr) {
    echo "        <li  onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.return.php','Pending Return request');\"> <a><span class=\"num\">\r\n          ";
    echo $cntpendingrr;
    echo "          </span> Pending Return request</a> </li>\r\n        ";
}
if ($cntsuppro) {
    echo "        <li onClick=\"javascript:load_fromsubpage('catlog&defaultloadpage=resellerlist.php','Suppliers product waiting for approval');\"> <a><span class=\"num\">\r\n          ";
    echo $cntsuppro;
    echo "          </span> Suppliers product waiting for approval</a> </li>\r\n        ";
}
if (!$OnlyEcommerce) {
    if ($cntimeireview) {
        echo "        <li onClick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_imei.php&status=pending','Pending IMEI service review');\"> <a><span class=\"num\">\r\n          ";
        echo $cntimeireview;
        echo "          </span> Pending IMEI service review</a> </li>\r\n        ";
    }
    if ($cntserverreview) {
        echo "        <li onClick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_server.php&status=pending','Pending Server service review');\"> <a><span class=\"num\">\r\n          ";
        echo $cntserverreview;
        echo "          </span> Pending Server service review</a> </li>\r\n        ";
    }
}
if ($cntshopreview) {
    echo "        <li onClick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_shop.php&status=pending','Pending Product review');\"> <a><span class=\"num\">\r\n          ";
    echo $cntshopreview;
    echo "          </span> Pending Product review</a> </li>\r\n        ";
}
if ($cntoverdrive) {
    echo "<li onClick=\"javascript:load_fromsubpage('clientlist&checkoverdrive=1','Overdrive Client List');\"> <a><span class=\"num\">\r\n";
    echo $cntoverdrive;
    echo " </span> Users are in Overdrive</a>\r\n</li>\r\n";
}
if ($cntimeiapiorder) {
    echo "        <li onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.history.php&waiting=1','APi Waiting Orders');\"> <a><span class=\"num\">\r\n    ";
    echo $cntimeiapiorder;
    echo " </span> IMEI Orders waiting in APi (24 Hours)</a>\r\n        </li>\r\n        ";
}
if ($cntserverapiorder) {
    echo "        <li onClick=\"javascript:load_fromsubpage('imeiorder&laoddefaultpage=imeiorder.history.php&waiting=1&stype=server','Overdrive Client List');\"> <a><span class=\"num\">\r\n    ";
    echo $cntserverapiorder;
    echo " </span> Server Orders waiting in APi (24 Hours)</a>\r\n        </li>\r\n        ";
}
echo "\r\n         <li class=\"tabmenu-header\">Quick Links</li>\r\n        ";
$result = dquery("SELECT sid,tid, 1 as total FROM tbl_support_tickets where (sid='4' or sid='1') AND did IN (" . $_SESSION["department"] . ") GROUP BY tid");
while ($row = mysqli_fetch_assoc($result)) {
    $ticket[$row["sid"]] += $row["total"];
}
echo "\r\n\r\n           <br />\r\n        <br />\r\n\r\n          <li><a onClick=\"load_fromsubpage('dashboard.topservice','Top 10 Selling Services');\"    id=\"tab1\">Top 10 Selling Services</a></li>\r\n          <li><a onClick=\"load_fromsubpage('dashboard.happyhours',' ";
echo $LNG["happyhours"];
echo "            ";
echo $LNG["service"];
echo "');\" id=\"tab2\" >\r\n            ";
echo $LNG["happyhours"];
echo "            ";
echo $LNG["service"];
echo "            </a></li>\r\n          <li><a onClick=\"load_fromsubpage('dashboard.mostviewable','";
echo $LNG["mostviewable"];
echo "            ";
echo $LNG["products"];
echo "');\" id=\"tab3\" >\r\n            ";
echo $LNG["mostviewable"];
echo "            ";
echo $LNG["products"];
echo "            </a></li>\r\n          <li><a onClick=\"load_fromsubpage('dashboard.apistatus','APi ";
echo $LNG["status"];
echo "');\" id=\"tab5\" >APi\r\n            ";
echo $LNG["status"];
echo "            </a></li>\r\n          ";
if (!$fusionlite) {
    echo "          <li><a href=\"https://support.dhru.com/Dhru-Fusion/releasenotes/2022/?vid=196&pid=1\" target=\"_blank\"\r\n           id=\"tab4\" >Release Notes\r\n            </a></li>\r\n          ";
}
echo "\r\n\r\n      </ul>\r\n\r\n</div>\r\n\r\n<style>\r\n    .padding td{padding:5px;border:none;color:#676a6c}\r\n    .bd td{border-bottom:#ddd solid 1px}\r\n    .badge{font-size:14px;color:#808080;padding:5px;display:block;}\r\n    .padding .tb tr:hover td{background: #f4f4f4;}\r\n</style>\r\n";

?>