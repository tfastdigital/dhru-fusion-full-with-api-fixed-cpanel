<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<br />\n<link href=\"templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.css?v=";
echo $versioncatch;
echo "\" media=\"screen\" rel=\"stylesheet\"/>\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/dashboard.js?v=";
echo $versioncatch;
echo "\"></script>\n<div title=\"dashboard\" id=\"tutid\"></div>\n";
$pageid = 298;
checkPagePermission($pageid);
if ($config["config_is_under_maintanance"]) {
    echo "    <div id=\"notification\" class=\"alert\">\n        ";
    echo $LNG["maintancemodeon"];
    echo "         \n    </div>\n    ";
}
echo "  \n    <div>\n                 \n     <div>   \n      <ul class=\"todo\" style=\"text-align: left;\">\n            <span style=\"font-size: 16px;padding:10px\">Action Required (To Do)</span><hr />\n";
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
        $ord = mysqli_fetch_assoc(dquery("select count(*) as total from " . $tbl . " where " . $cnd . " "));
        $order[$tbl][$key] = $ord["total"];
    }
}
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
if (!$OnlyEcommerce) {
    if ($vals[0]) {
        echo "    \n        <li onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">\n    <a><span>";
        echo $vals[0];
        echo " </span>  New IMEI Orders</a></li>\n    ";
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
}
if ($vals[8]) {
    echo "       \n    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.new.php','1');\">\n  <a><span>";
    echo $vals[8];
    echo " </span> New Shop orders</a></li> \n  ";
}
if ($vals[9]) {
    echo "    <li onclick=\"javascript:redirectedit('productorder&loaddefaultpage=productorder.pending.php','');\">\n  <a><span >";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\n    </li> \n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    ";
}
if (!$OnlyEcommerce) {
    if ($cntwithdrawal) {
        echo "        <li onclick=\"javascript:redirectedit('utilities.withdrawal','');\">\n       <a> <span>";
        echo $cntwithdrawal;
        echo "</span> Pending withdrawal request</a>\n        </li> \n        ";
    }
    if ($cntpq) {
        echo "  \n        <li  onclick=\"javascript:redirectedit('utilities.pendingquick','');\">\n       <a> <span>";
        echo $cntpq;
        echo "</span> Quick checkout pending orders</a>\n        </li>\n    ";
    }
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
if ($_SESSION["department"]) {
    $department = $_SESSION["department"];
} else {
    $department = "958959595959595";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=1 group by tid"));
if ($newtickets) {
    echo "       \n    <li onclick=\"javascript:redirectedit('support.open','1');\">\n    <a><span >";
    echo $newtickets;
    echo "</span> New tickets </a></li> \n";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=4 group by tid"));
if ($newtickets) {
    echo "    \n    <li onclick=\"javascript:redirectedit('support.open','4');\"> \n    <a></a><span >";
    echo $newtickets;
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
if (!$OnlyEcommerce) {
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
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:redirectedit('utilities.review&laoddefaultpage=utilities.review_shop.php','&status=pending');\">\n    <a><span>";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\n    </li>\n";
}
echo " \n\n      </ul>  \n    </div>    \n        \n    </div>\n\n    <div class=\"clear\"></div>\n    \n";
$fileverioncheck = "6.1.0";

?>