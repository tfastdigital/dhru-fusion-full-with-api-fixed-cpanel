<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<br />\r\n<div title=\"dashboard\" id=\"tutid\"></div>\r\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\r\n        ";
    echo $LNG["maintancemodeon"];
    echo "    </div>\r\n    ";
}
echo "    <div>\r\n\r\n     <div>\r\n      <ul class=\"todo\" style=\"text-align: left;\">\r\n            <span style=\"font-size: 16px;padding:10px\">Action Required (To Do)</span><hr />\r\n";
$table = ["tbl_order_imei", "tbl_order_file", "tbl_order_server"];
$defaultprogress = 3;
$today = date("Y-m-d", time());
$yesterday = date("Y-m-d", time() - 86400);
$month = date("m", time());
$pmonth = date("m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
$year = date("Y", time());
$pyear = date("Y") - 1;
$startTime = mktime(0, 0, 0, date("m"), 1, date("Y"));
$startYear = mktime(0, 0, 0, 1, 1, date("Y"));
$condition = ["totalorder" => "(1=1) ", "totalnew" => " user_can_c='0'", "totalaccepted" => " user_can_c='1'", "todaystotal" => "date='" . $today . "'", "todaysnew" => " date='" . $today . "' and user_can_c='0'", "todaysaccepted" => " date='" . $today . "' and user_can_c='1'"];
foreach ($table as $tbl) {
    foreach ($condition as $key => $cnd) {
        $cond = "";
        if ($tbl == "tbl_order_imei") {
            $cond = " and `server`=0";
        } else {
            if ($tbl == "tbl_order_server") {
                $tbl = "tbl_order_imei";
                $cond = " and `server`=1";
            }
        }
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd . " " . $cond));
        $order[$tbl][$key] = $ord["total"];
    }
}
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
$ordertime = time() - 86400;
$cntimeiapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei \r\nwhere server=0 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
$cntserverapiorder = mysqli_num_rows(dquery("select order_id from tbl_order_imei \r\nwhere server=1 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
if ($vals[0] || $vals[1] || $vals[2] || $vals[3] || $vals[4] || $vals[5] || $vals[8] || $vals[9]) {
}
if ($cntimeiapiorder) {
    echo "    <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php&waiting=1','APi Waiting Orders');\">\r\n        <a><span> ";
    echo $cntimeiapiorder;
    echo " </span> Waiting APi reply since 24 hr</a></li>\r\n    ";
}
if ($cntserverapiorder) {
    echo "    <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiorder.history.php&waiting=1&stype=server','APi Waiting Orders');\">\r\n        <a><span> ";
    echo $cntserverapiorder;
    echo " </span> Waiting APi reply since 24 hr</a></li>\r\n    ";
}
if (!$OnlyEcommerce) {
    if ($vals[0]) {
        echo "    <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">\r\n    <a><span>";
        echo $vals[0];
        echo " </span> New IMEI Orders</a></li>\r\n    ";
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
}
if ($vals[8]) {
    echo "    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.new.php','1');\">\r\n  <a><span>";
    echo $vals[8];
    echo " </span> New Shop orders</a></li>\r\n  ";
}
if ($vals[9]) {
    echo "    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.pending.php','');\">\r\n  <a><span >";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\r\n    </li>\r\n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    ";
}
if (!$OnlyEcommerce) {
    if ($cntwithdrawal) {
        echo "        <li onclick=\"javascript:redirectedit('utilities.withdrawal','');\">\r\n       <a> <span>";
        echo $cntwithdrawal;
        echo "</span> Pending withdrawal request</a>\r\n        </li>\r\n        ";
    }
    if ($cntpq) {
        echo "        <li  onclick=\"javascript:redirectedit('utilities.pendingquick','');\">\r\n       <a> <span>";
        echo $cntpq;
        echo "</span> Quick checkout pending orders</a>\r\n        </li>\r\n    ";
    }
}
if ($cntcc) {
    echo "    <li  onclick=\"javascript:redirectedit('utilities.ccprocess','');\">\r\n    <a><span>";
    echo $cntcc;
    echo "</span> Orders waiting for offline Credit Card Process</a>\r\n    </li>\r\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <li onclick=\"javascript:redirectedit('invoicereport&unpaidonly=User','');\">\r\n    <a><span>";
    echo $cntunpu;
    echo "</span> Unpaid invoices of User </a></li>\r\n    <li onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=Admin');\">\r\n     <a><span>";
    echo $cntunpa;
    echo "</span> Invoices of Admin</a>\r\n    </li>\r\n";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
}
if ($_SESSION["department"]) {
    $department = $_SESSION["department"];
} else {
    $department = "958959595959595";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\r\n    where did in (" . $department . ") and sid=1 group by tid"));
if ($newtickets) {
    echo "    <li onclick=\"javascript:redirectedit('support.open','1');\">\r\n    <a><span >";
    echo $newtickets;
    echo "</span> New tickets </a></li>\r\n";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\r\n    where did in (" . $department . ") and sid=4 group by tid"));
if ($newtickets) {
    echo "    <li onclick=\"javascript:redirectedit('support.open','4');\">\r\n    <a></a><span >";
    echo $newtickets;
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
if (!$OnlyEcommerce) {
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
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_shop.php','&status=pending');\">\r\n    <a><span>";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\r\n    </li>\r\n";
}
echo "\r\n      </ul>\r\n    </div>\r\n\r\n    </div>\r\n\r\n    <div class=\"clear\"></div>\r\n\r\n";
$fileverioncheck = "6.1.0";

?>