<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$cntbc = $conn->query("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id")->rowCount();
$cntrv = $conn->query("SELECT id from tbl_review where status='0'")->rowCount();
$cnttst = $conn->query("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'")->rowCount();
$cntpq = $conn->query("SELECT id FROM `tbl_invoices` WHERE status='Unpaid' and total=(select sum(amountin) from tbl_transaction where invoiceid=tbl_invoices.id)")->rowCount();
$cntcc = $conn->query("SELECT id FROM `tbl_invoices` WHERE status='Unpaid' and paymentmethod='cc'")->rowCount();
$cntoffline = $conn->query("SELECT id FROM `tbl_invoices` WHERE status='Unpaid' and offline='1'")->rowCount();
$cntwat = $conn->query("SELECT id FROM `tblUsers`  WHERE userstatus=2 and is_registered=0")->rowCount();
$cntbc = $conn->query("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id")->rowCount();
$cntrv = $conn->query("SELECT id from tbl_review where status='0'")->rowCount();
$cnttst = $conn->query("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'")->rowCount();
$cntpq = $conn->query("SELECT id FROM `tbl_invoices` WHERE status='Unpaid' and total=(select sum(amountin) from tbl_transaction where invoiceid=tbl_invoices.id)")->rowCount();
$cntcc = $conn->query("SELECT id FROM `tbl_invoices` WHERE  status='Unpaid' and paymentmethod='cc'")->rowCount();
$cntoffline = $conn->query("SELECT id FROM `tbl_invoices` WHERE status='Unpaid' and offline='1'")->rowCount();
$cntwat = $conn->query("SELECT id FROM `tblUsers`  WHERE userstatus=2 and is_registered=0")->rowCount();
$cntpendingrr = $conn->query("SELECT id FROM `tbl_return_request` WHERE status='0'")->rowCount();
$cntblog = $conn->query("select id from tbl_blogposts where status='unpublished'")->rowCount();
$cnttestimonial = $conn->query("select id from tbl_testimonial where status='pending'")->rowCount();
$cntimeireview = $conn->query("select id from tbl_review where status=0 and sid!=0")->rowCount();
$cntserverreview = $conn->query("select id from tbl_review where status=0 and lid!=0")->rowCount();
$cntshopreview = $conn->query("select id from tbl_review where status=0 and pid!=0")->rowCount();
$cntonline = $conn->query("SELECT username,id,online_status from tblUsers where online_status='1'")->rowCount();
$cntwithdrawal = $conn->query("SELECT id FROM tbl_withdrawal  WHERE status=0")->rowCount();
$cntoverdrive = $conn->query("select id from tblUsers where overdrive>0")->rowCount();
$cntsuppro = $conn->query("SELECT id FROM tbl_products  WHERE active=0 and bysupplier!=''")->rowCount();
$cntiv = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE verified=1")->rowCount();
$cntfv = $conn->query("SELECT order_id FROM `tbl_order_file` WHERE verified=1")->rowCount();
$cntsv = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE verified=1 and server=1")->rowCount();
$cntprofit = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE user_can_c=3 and refunded=1")->rowCount();
$cntquick = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE user_can_c=6")->rowCount();
$cntverifyapi = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE autosend=1 and user_can_c=0 and server=0")->rowCount();
$cntverifyapiserver = $conn->query("SELECT order_id FROM `tbl_order_imei` WHERE autosend=1 and user_can_c=0 and server=1")->rowCount();
$ordertime = time() - 86400;
$cntimeiapiorder = $conn->query("select order_id from tbl_order_imei where `server`=0 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime)->rowCount();
$sql = $conn->query("select support_department from tbl_admin where id='" . $_SESSION["adminid"] . "'");
$sql = $sql->fetch(PDO::FETCH_ASSOC);
if ($sql["support_department"]) {
    $_SESSION["department"] = $sql["support_department"];
}

$cntsupportnew = $conn->query("select distinct(tid) from tbl_support_tickets where sid=1 and admin_read='' and did in (" . $_SESSION["department"] . ") ")->rowCount();
$cntsupportwaiting = $conn->query("select distinct(tid)  from tbl_support_tickets where sid=4 and did in (" . $_SESSION["department"] . ")  ")->rowCount();
$cntserverapiorder = $conn->query("select order_id from tbl_order_imei where server=1 and ORDERAPI_ID!='' and user_can_c=1 and time<" . $ordertime)->rowCount();
$DISP["name"] = "Withdrawal request";
$DISP["link"] = "utilities.withdrawal";
$DISP["cnt"] = $cntwithdrawal;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Verify Payment - Fraud/KYC";
$DISP["link"] = "verifypaymentinvoice&filter=1";
$DISP["cnt"] = $cntpq;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Verify Payment - Offline Gateway";
$DISP["link"] = "verifypaymentinvoice&filter=2";
$DISP["cnt"] = $cntoffline;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Verify Payment - Credit Card";
$DISP["link"] = "verifypaymentinvoice&filter=3";
$DISP["cnt"] = $cntcc;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Quick Checkout pending Orders";
$DISP["link"] = "utilities.pendingquick";
$DISP["cnt"] = $cntquick;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "New Tickets";
$DISP["link"] = "support.open&id=1";
$DISP["cnt"] = $cntsupportnew;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Waiting Tickets";
$DISP["link"] = "support.open&id=4";
$DISP["cnt"] = $cntsupportwaiting;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "New Blog Comments";
$DISP["link"] = "utilities.comments";
$DISP["cnt"] = $cntbc;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Product review you have to verify";
$DISP["link"] = "utilities.review";
$DISP["cnt"] = $cntrv;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "New Testimonial";
$DISP["link"] = "dashboard.testimonial";
$DISP["cnt"] = $cnttst;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Users waiting for activation";
$DISP["link"] = "utilities.userstatus";
$DISP["cnt"] = $cntwat;
$RETURN["notification"][] = $DISP;
$DISP["name"] = "Pending Return request";
$DISP["link"] = "productorder.return";
$DISP["cnt"] = $cntpendingrr;
$RETURN["notification"][] = $DISP;
$total = 0;

    if (1==1) {
        unset($RETURN["notification"]);
        $total += $detail["cnt"];
        $Final[] = $detail;
    } else {
        $total += $detail["cnt"];
        $Final[] = $detail;
    }

unset($RETURN["notification"]);
$RETURN["notification"] = $Final;
$RETURN["total"] = $total;

?>