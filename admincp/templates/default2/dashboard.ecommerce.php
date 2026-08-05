<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n<div title=\"dashboard\" id=\"tutid\"></div>\n";
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
echo "\n<div style=\"margin-right: 290px;\">\n  \n  <div>\n          <div class=\"graph\">\n            <div style=\"text-align: center;\"> <img src=\"images/ajax_loading_new.gif\" style=\"margin: 100px;\" /> </div>\n          </div>\n        </div>\n   \n<div style=\"margin: 40px 0;\">\n   \n      <div class=\"dcircle\">\n         <div style=\"text-align: center;min-height:159px;\"> <img src=\"images/ajax_loading_new.gif\" style=\"margin: 65px;\"/> </div>\n      </div>\n      \n  </div>  \n \n  <script>\n    \$(document).ready(function(){          \n        \$.post('templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.graph.shop.php',function(data, success, textStatus) {            \n            \$('.graph').html(data);                        \n        });\n        \$.post('templates/";
echo $_SESSION["admin_template"];
echo "/dashboard.circle.shop.php',function(data, success, textStatus) {            \n             \$('.dcircle').html(data);                        \n        });\n    })\n</script>\n\n \n       \n     <div >   \n      <ul class=\"item-list\"  style=\"width: 300px;float:left;top:20px;box-shadow:none;border-radius:0;display:block;right:0\">\n        <li class=\"tabmenu-header\"> Action Required (To Do) </li>\n";
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
$cntiv = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE verified='1'"));
$cntfv = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_file` WHERE verified='1'"));
$cntsv = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_server` WHERE verified='1'"));
$cntprofit = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE user_can_c='3' and refunded=1"));
$cntquick = mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE user_can_c='6'"));
if ($vals[8]) {
    echo "       \n    <li onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.new.php&id=1','Product New');\">\n  <a><span class=\"num\">";
    echo $vals[8];
    echo " </span> New Shop orders</a></li> \n  ";
}
if ($vals[9]) {
    echo "  <li onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.pending.php','Pending Shop orders');\">\n  <a><span class=\"num\">";
    echo $vals[9];
    echo "</span> Pending Shop orders</a>\n    </li> \n";
}
if ($cntwithdrawal) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.withdrawal','Pending withdrawal request');\">\n   <a> <span class=\"num\">";
    echo $cntwithdrawal;
    echo "</span> Pending withdrawal request</a>\n    </li> \n";
}
if ($cntcc) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('utilities.ccprocess','Orders waiting for offline Credit Card Process');\">\n    <a><span class=\"num\">";
    echo $cntcc;
    echo "</span> Orders waiting for offline Credit Card Process</a>\n    </li>\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <li onclick=\"javascript:load_fromsubpage('unpaidinvoice&bywhom=User','Unpaid invoices of User');\">\n    <a><span class=\"num\">";
    echo $cntunpu;
    echo "</span> Unpaid invoices of User </a></li>\n    <li onclick=\"javascript:load_fromsubpage('unpaidinvoice&bywhom=Admin','Invoices of Admin');\">\n     <a><span class=\"num\">";
    echo $cntunpa;
    echo "</span> Invoices of Admin</a>\n    </li>  \n";
}
if ($_SESSION["department"]) {
    $department = $_SESSION["department"];
} else {
    $department = "958959595959595";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=1 group by tid"));
if ($newtickets) {
    echo "       \n    <li onclick=\"javascript:load_fromsubpage('support.open&id=1','New tickets ');\">\n    <a><span class=\"num\">";
    echo $newtickets;
    echo "</span> New tickets </a></li> \n";
}
$newtickets = mysqli_num_rows(dquery("select id from tbl_support_tickets\n    where did in (" . $department . ") and sid=4 group by tid"));
if ($newtickets) {
    echo "    \n    <li onclick=\"javascript:load_fromsubpage('support.open&id=4','Waiting tickets');\"> \n    <a><span class=\"num\">";
    echo $newtickets;
    echo "</span>  Waiting tickets</a>\n    </li> \n";
}
if ($cntbc) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.comments','New blog comments');\">\n    <a><span class=\"num\">";
    echo $cntbc;
    echo "</span> New blog comments</a>\n    </li>\n";
}
if ($cnttst) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('dashboard.testimonial','New testimonial');\">\n    <a><span class=\"num\">";
    echo $cnttst;
    echo "</span> New testimonial</a>\n    </li>\n";
}
if ($cntwat) {
    echo "     \n    <li onclick=\"javascript:load_fromsubpage('utilities.userstatus','User waiting for activation');\">\n    <a><span class=\"num\">";
    echo $cntwat;
    echo "</span> User waiting for activation</a>\n    </li>  \n";
}
if ($cntpendingrr) {
    echo "    \n    <li  onclick=\"javascript:load_fromsubpage('productorder&loaddefaultpage=productorder.return.php','Pending Return request');\">\n    <a><span class=\"num\">";
    echo $cntpendingrr;
    echo "</span> Pending Return request</a>\n    </li>\n";
}
if ($cntsuppro) {
    echo "     \n    <li onclick=\"javascript:load_fromsubpage('catlog&defaultloadpage=resellerlist.php','Suppliers product waiting for approval');\">\n    <a><span class=\"num\">";
    echo $cntsuppro;
    echo "</span> Suppliers product waiting for approval</a>\n    </li>  \n";
}
if ($cntshopreview) {
    echo "    <li onclick=\"javascript:load_fromsubpage('utilities.review&laoddefaultpage=utilities.review_shop.php&status=pending','Pending Product review');\">\n    <a><span class=\"num\">";
    echo $cntshopreview;
    echo "</span> Pending Product review</a>\n    </li>\n";
}
echo " \n\n      </ul>  \n    </div>    \n        \n   \n    \n</div> \n    <div class=\"clear\"></div>\n \n";
$fileverioncheck = "6.1.0";

?>