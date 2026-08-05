<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<style>\r\ntable tr{\r\n    cursor: pointer;\r\n}\r\n.nonsel{\r\n    cursor:  auto !important;\r\n}\r\n.nonsel strong{\r\n    cursor: pointer;\r\n}\r\ntable thead {\r\n    cursor:  auto !important;\r\n}\r\n</style>\r\n<table cellspacing=\"0\" cellpadding=\"4\" id=\"deshbordsub\">\r\n";
$allset = base64_decode($allset);
$vals = explode("-", $allset);
$cntbc = mysqli_num_rows(dquery("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id"));
$cntrv = mysqli_num_rows(dquery("SELECT * from tbl_review where status='0'"));
$cnttst = mysqli_num_rows(dquery("SELECT distinct id,substring(comment,1,100) as comment,date,\r\n                                `tbl_testimonial`.author,email,`tbl_testimonial`.id,\r\n                                `tbl_testimonial`.`status`\r\n                                 FROM `tbl_testimonial` WHERE \r\n                                 `tbl_testimonial`.`status`='pending'"));
$cntiv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE verified='1' and `server`=0"));
$cntfv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_file` WHERE verified='1'"));
$cntsv = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE verified='1' and `server`=1"));
$cntpq = mysqli_num_rows(dquery("SELECT order_id\r\nFROM `tbl_order_imei` WHERE user_can_c='6' and `server`=0"));
$cntcc = mysqli_num_rows(dquery("SELECT id FROM `tbl_invoices` WHERE\r\n status='Unpaid' and paymentmethod='cc'"));
$cntwat = mysqli_num_rows(dquery("SELECT * FROM `tblUsers` WHERE userstatus='2' and is_registered='0'"));
$cntunpu = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\r\n                                         total>0 AND adminid=''"));
$cntunpa = mysqli_num_rows(dquery("SELECT id FROM tbl_invoices  where status='Unpaid' and\r\n                                         total>0 AND adminid!=''"));
$cntpendingrr = mysqli_num_rows(dquery("SELECT id FROM `tbl_return_request` WHERE status='0'"));
$cntblog = mysqli_num_rows(dquery("select id from tbl_blogposts where status='unpublished'"));
$cntoverdrive = mysqli_num_rows(dquery("select id from tblUsers where overdrive>0 and guest=0"));
$cnttestimonial = mysqli_num_rows(dquery("select id from tbl_testimonial where status='pending'"));
$cntonline = mysqli_num_rows(dquery("SELECT username,id,online_status from tblUsers where online_status='1'"));
$cntwithdrawal = mysqli_num_rows(dquery("SELECT * FROM tbl_withdrawal  WHERE status=0"));
$cntsuppro = mysqli_num_rows(dquery("SELECT * FROM tbl_products  WHERE active=0 and bysupplier!=''"));
$ordertime = time() - 86400;
$cntimeiapiorder = mysqli_num_rows(dquery("select order_id from tbl_imei_order \r\nwhere server=0 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
$cntserverapiorder = mysqli_num_rows(dquery("select order_id from tbl_imei_order \r\nwhere server=0 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime));
if ($vals[0] || $vals[1] || $vals[2] || $vals[3] || $vals[4] || $vals[5] || $vals[8] || $vals[9]) {
    echo "<thead class=\"nonsel\" >\r\n<th align=\"left\" >";
    echo $LNG["orders"];
    echo "</th>\r\n</thead>\r\n";
}
if ($vals[0] || $vals[1]) {
    echo "    <tr class='nonsel'>\r\n    <td>You have <strong onclick=\"javascript:redirectedit('imeiorder&laoddefaultpage=imeiquickaccept.php','');\">";
    echo $vals[0];
    echo " new IMEI Orders </strong> and <strong onclick=\"javascript:redirectedit('quickreply','');\">";
    echo $vals[1];
    echo " Pending</strong> IMEI Orders</td>\r\n    </tr>\r\n";
}
if ($vals[2] || $vals[3]) {
    echo "    <tr class='nonsel' >\r\n    <td>You have <strong onclick=\"javascript:redirectedit('filequickaccept','');\">";
    echo $vals[2];
    echo " new File Orders </strong> and <strong onclick=\"javascript:redirectedit('fileorder.replied','');\">";
    echo $vals[3];
    echo " Pending</strong> File Orders</td>\r\n    </tr>\r\n";
}
if ($vals[4] || $vals[5]) {
    echo "    <tr class='nonsel'>\r\n    <td>You have <strong onclick=\"javascript:redirectedit('imeiquickaccept&stype=server','');\">";
    echo $vals[4];
    echo " new Server Orders </strong> and <strong onclick=\"javascript:redirectedit('imeiorder.replied&stype=server','');\">";
    echo $vals[5];
    echo "</strong> Pending Server Orders</td>\r\n    </tr>\r\n";
}
if ($vals[8] || $vals[9]) {
    echo "    <tr class='nonsel'>\r\n    <td>You have <strong onclick=\"javascript:redirectedit('productorder.new','1');\">";
    echo $vals[8];
    echo " new Shop orders </strong> and <strong onclick=\"javascript:redirectedit('productorder.replied','');\">";
    echo $vals[9];
    echo " Pending</strong> Shop orders</td>\r\n    </tr>\r\n";
}
if ($cntiv) {
    echo "    <tr class='nonsel'>\r\n    <td>You have <strong onclick=\"javascript:redirectedit('main2.php?page=imeiorder&laoddefaultpage=imeiorder.verification.php','');\">";
    echo $cntiv;
    echo " IMEI Orders </strong> for verification</td>\r\n    </tr>\r\n";
}
if ($cntwithdrawal || $cntpq || $cntcc || $cntunpu || $cntunpa) {
    echo "    <thead class=\"nonsel\">\r\n    <th align=\"left\" >";
    echo $LNG["financial"];
    echo "</th>\r\n    </thead>\r\n    ";
}
if ($cntwithdrawal) {
    echo "    <tr onclick=\"javascript:redirectedit('utilities.withdrawal','');\">\r\n    <td>You have <strong>";
    echo $cntwithdrawal;
    echo "</strong> pending withdrawal request </td>\r\n    </tr>\r\n";
}
if ($cntpq) {
    echo "    <tr  onclick=\"javascript:redirectedit('utilities.pendingquick','');\">\r\n    <td><strong>";
    echo $cntpq;
    echo "</strong> Quick checkout pending orders</td>\r\n    </tr>\r\n";
}
if ($cntcc) {
    echo "    <tr  onclick=\"javascript:redirectedit('utilities.ccprocess','');\">\r\n    <td><strong>";
    echo $cntcc;
    echo "</strong> Orders waiting for offline Credit Card Process</td>\r\n    </tr>\r\n";
}
if ($cntunpu || $cntunpa) {
    echo "    <tr class=\"nonsel\">\r\n    <td>You have <strong onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=user');\">";
    echo $cntunpu;
    echo " unpaid invoices of User</strong>\r\n     and <strong onclick=\"javascript:redirectedit('unpaidinvoice','&bywhom=Admin');\">";
    echo $cntunpa;
    echo " Invoices of Admin</strong>\r\n    </td>\r\n    </tr>\r\n";
}
if ($cntbc || $cntrv || $cnttst || $vals[6] || $vals[7] || $cntwat || $cntpendingrr) {
    echo "    <thead class=\"nonsel\">\r\n    <th align=\"left\" >";
    echo $LNG["review"];
    echo "</th>\r\n    </thead>\r\n    ";
}
if ($vals[6] || $vals[7]) {
    echo "    <tr class='nonsel'>\r\n    <td>You have <strong onclick=\"javascript:redirectedit('support.ticket','1');\">";
    echo $vals[6];
    echo " new tickets </strong> and <strong onclick=\"javascript:redirectedit('support.ticket','4&laoddefaultpage=support.open.php');\">";
    echo $vals[7];
    echo " waiting</strong> tickets</td>\r\n    </tr>\r\n";
}
if ($cntbc) {
    echo "    <tr onclick=\"javascript:redirectedit('utilities.comments','');\">\r\n    <td>You have <strong>";
    echo $cntbc;
    echo "</strong> new blog comments</td>\r\n    </tr>\r\n";
}
if ($cntrv) {
    echo "    <tr onclick=\"javascript:redirectedit('utilities.review','');\">\r\n    <td>Customer left <strong>";
    echo $cntrv;
    echo "</strong> Product review you have to verify</td>\r\n    </tr>\r\n";
}
if ($cnttst) {
    echo "    <tr  onclick=\"javascript:redirectedit('dashboard.testimonial','');\">\r\n    <td>You have <strong>";
    echo $cnttst;
    echo "</strong> new testimonial</td>\r\n    </tr>\r\n";
}
if ($cntwat) {
    echo "    <tr onclick=\"javascript:redirectedit('utilities.userstatus','');\">\r\n    <td><strong>";
    echo $cntwat;
    echo "</strong> User waiting for activation</td>\r\n    </tr>\r\n";
}
if ($cntpendingrr) {
    echo "    <tr  onclick=\"javascript:redirectedit('productorder.return','');\">\r\n    <td><strong>";
    echo $cntpendingrr;
    echo "</strong> Pending Return request</td>\r\n    </tr>\r\n";
}
if ($cntsuppro) {
    echo "    <tr onclick=\"javascript:redirectedit('catlog','');\">\r\n    <td><strong>";
    echo $cntsuppro;
    echo "</strong> suppliers product waiting for approval</td>\r\n    </tr>\r\n";
}
if ($cnttestimonial) {
    echo "    <tr onclick=\"javascript:redirectedit('listtestimonial','');\">\r\n    <td><strong>";
    echo $cnttestimonial;
    echo "</strong> new Testimonial</td>\r\n    </tr>\r\n";
}
if ($cntblog) {
    echo "    <tr onclick=\"javascript:redirectedit('viewblog','');\">\r\n    <td><strong>";
    echo $cntblog;
    echo "</strong> new Blog Comments</td>\r\n    </tr>\r\n";
}
if ($cntoverdrive) {
    echo "    <tr onclick=\"javascript:redirectedit('clientlist','');\">\r\n    <td><strong>";
    echo $cntoverdrive;
    echo "</strong> Users are in Overdrive</td>\r\n    </tr>\r\n";
}
if ($cntimeiapiorder) {
    echo "    <tr onclick=\"javascript:redirectedit('clientlist','');\">\r\n        <td><strong>";
    echo $cntimeiapiorder;
    echo "</strong> IMEI order waiting in APi</td>\r\n    </tr>\r\n    ";
}
if ($cntserverapiorder) {
    echo "    <tr onclick=\"javascript:redirectedit('clientlist','');\">\r\n        <td><strong>";
    echo $cntserverapiorder;
    echo "</strong> Server order waiting in APi</td>\r\n    </tr>\r\n    ";
}
echo "</table>";
$fileverioncheck = "6.1.0";

?>