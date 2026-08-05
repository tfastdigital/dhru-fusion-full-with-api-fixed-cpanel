<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 195;
checkPagePermission($pageid);
$cnt = 0;
if ($config["precision"] == 3) {
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='credit' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_order_imei` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL;");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='discount' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_order_imei` CHANGE `discount` `discount` DECIMAL(12,3) NULL DEFAULT NULL;");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='reseller_credit' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_order_imei` CHANGE `reseller_credit` `reseller_credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='reseller_discount' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_order_imei` CHANGE `reseller_discount` `reseller_discount` DECIMAL(13,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='credit' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_order_file` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='discount' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_order_file` CHANGE `discount` `discount` DECIMAL(12,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='reseller_credit' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_order_file` CHANGE `reseller_credit` `reseller_credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='reseller_discount' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_order_file` CHANGE `reseller_discount` `reseller_discount` DECIMAL(13,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='credit' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_services_imei` CHANGE `credit` `credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='retail_credit' and Type='decimal(15,2)'"))) {
        dquery("ALTER TABLE `tbl_services_imei` CHANGE `retail_credit` `retail_credit` DECIMAL(15,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='prev_price' and Type='decimal(20,2)'"))) {
        dquery("ALTER TABLE `tbl_services_imei` CHANGE `prev_price` `prev_price` DECIMAL(20,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='apilower' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_services_imei` CHANGE `apilower` `apilower` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_file where Field ='credit' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tbl_services_file` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_discount_imei where Field ='discount' and Type='decimal(20,2)'"))) {
        dquery("ALTER TABLE `tbl_discount_imei` CHANGE `discount` `discount` DECIMAL(20,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_discount_file where Field ='discount' and Type='decimal(20,2)'"))) {
        dquery("ALTER TABLE `tbl_discount_file` CHANGE `discount` `discount` DECIMAL(20,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_imei_credit where Field ='credit' and Type='decimal(25,2)'"))) {
        dquery("ALTER TABLE `tbl_imei_credit` CHANGE `credit` `credit` DECIMAL(25,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_file_credit where Field ='credit' and Type='decimal(25,2)'"))) {
        dquery("ALTER TABLE `tbl_file_credit` CHANGE `credit` `credit` DECIMAL(25,3) NULL DEFAULT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_client_group_price where Field ='discount' and Type='decimal(15,2)'"))) {
        dquery("ALTER TABLE `tbl_client_group_price` CHANGE `discount` `discount` DECIMAL(15,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_reseller_price where Field ='price' and Type='decimal(25,2)'"))) {
        dquery("ALTER TABLE `tbl_reseller_price` CHANGE `price` `price` DECIMAL(25,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_left' and Type='decimal(25,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `credit_left` `credit_left` DECIMAL(25,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_used' and Type='decimal(30,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `credit_used` `credit_used` DECIMAL(30,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_inprocess' and Type='decimal(25,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `credit_inprocess` `credit_inprocess` DECIMAL(25,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='sell_credit_limit' and Type='decimal(35,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `sell_credit_limit` `sell_credit_limit` DECIMAL(35,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='maxcredit' and Type='decimal(12,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `maxcredit` `maxcredit` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='creditlimit' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tblUsers` CHANGE `creditlimit` `creditlimit` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_statement_user where Field ='amount' and Type='decimal(15,2)'"))) {
        dquery("ALTER TABLE `tbl_statement_user` CHANGE `amount` `amount` DECIMAL(15,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoiceitems where Field ='amount' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoiceitems` CHANGE `amount` `amount` DECIMAL(15,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='subtotal' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `subtotal` `subtotal` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='credit' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `credit` `credit` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='tax' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `tax` `tax` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='tax2' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `tax2` `tax2` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='shippingtax' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `shippingtax` `shippingtax` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='total' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `total` `total` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='taxrate' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `taxrate` `taxrate` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
    if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='taxrate2' and Type='decimal(10,2)'"))) {
        dquery("ALTER TABLE `tbl_invoices` CHANGE `taxrate2` `taxrate2` DECIMAL(12,3) NOT NULL; ");
    } else {
        $cnt++;
    }
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_services_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "homepage") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("alter table tbl_services_imei add index `homepage` (show_onhome)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "user_can_c") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX (`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "timeserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `timeserver` ( `time`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "dtcanserverservice") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `dtcanserverservice` ( `date`, `user_can_c`,`server`,`service_id`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "new2019") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `new2019` ( `date`, `user_can_c`,`server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_swkey");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "key") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("alter table tbl_swkey add index `key` (status,group_id,expiredon);");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "servercantime") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `servercantime` ( `user_can_c`, `time`,`server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_apiservers");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "apiorder") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `ALTER TABLE `tbl_apiservers` ADD INDEX apiorder ( `gateway`, `setting`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "user_id_2") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX user_id_2 ( `user_can_c`, `server`, `user_id`) ");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "inactiveapi") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_services_imei` ADD INDEX inactiveapi ( `API`, `API_ID`, `inactivebyapi`) ");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "replyserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `replyserver` ( `reply_date`, `user_can_c`,`server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "currencyserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `currencyserver` ( `currency_id`, `user_can_c`,`server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "onlcycurrency") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `onlcycurrency` ( `currency_id`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "yearserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `yearserver` ( `date`,`user_can_c`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "replybyserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `replybyserver` ( `reply_by_admin`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "replybysupserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `replybysupserver` ( `reply_by_sup`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "onlycans") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `onlycans` ( `user_can_c`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "serververvice") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `serververvice` ( `service_id`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "userserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `userserver` ( `user_id`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "userserver") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX  `userserver` ( `user_id`, `server`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "orderatuser") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX orderatuser ( `user_id`, `user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "ordertime") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX ordertime (`user_can_c`,`time`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tblUsers");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "registe") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tblUsers` ADD INDEX registe (`userstatus`,`is_registered`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_server");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "servertime") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_server` ADD INDEX servertime (`time`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "cron") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX cron ( `fetchapitime`(17),`user_can_c`,`ORDERAPI`(20),`ORDERAPI_ID`(20),`service_id`,`autosend` )");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "fileuser") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX fileuser (`user_id`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "filetime") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX filetime (`time`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "imeireplyorder") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_imei` ADD INDEX imeireplyorder (`reply_date`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_file");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "filereplyorder") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_file` ADD INDEX filereplyorder (`reply_date`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_server");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "serverreplyorder") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_server` ADD INDEX serverreplyorder    (`reply_date`,`user_can_c`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_invoices");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "invstatus") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_invoices` ADD INDEX invstatus ( `status`, `total`,`adminid`)");
}
if ($collation) {
    $result = dquery("show tables");
    while ($tables = mysqli_fetch_row($result)) {
        dquery("alter table " . $tables[0] . " convert to character set utf8 collate utf8_general_ci;");
    }
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_featuresvalues");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "allfie") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_featuresvalues` ADD INDEX allfie ( `fieldid`, `relid`, `value`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_featuresvalues");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "fierel") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_featuresvalues` ADD INDEX fierel ( `fieldid`, `relid`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_products");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "manufacture_id") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_products` ADD INDEX(`manufacture_id`)");
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_order_server");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "verified") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_order_server` ADD INDEX (`verified`)");
}
dquery("ALTER  TABLE  `tbl_apiserversservices`  CHANGE  `gateway`  `gateway` VARCHAR( 50  )  CHARACTER  SET utf8 COLLATE utf8_general_ci NOT  NULL");
dquery("ALTER  TABLE  `tbl_client_group_price`  ADD  INDEX cpall (  `group_id` ,  `service_type` ,  `service_id`  )");
dquery("ALTER  TABLE  `tbl_apiserversservices`  ADD  INDEX cpgat (  `gateway` ,  `id`  )");
dquery("ALTER TABLE `tbl_mobile` ADD INDEX tmbp ( `B_ID` , `api` )");
dquery("ALTER TABLE `tbl_mobile` ADD INDEX tmibp ( `ID` , `B_ID` , `api` )");
$tables = ["tbl_order_imei", "tbl_services_imei", "tbl_support_tickets", "tbl_invoices", "tbl_invoiceitems", "tbl_review", "tbl_testimonial", "tblUsers", "tbl_order_product", "tbl_products", "tbl_order_server", "tbl_server_log", "tbl_imei_credit", "tbl_file_credit", "tbl_server_credit", "tbl_product_credit", "tbl_discount_imei", "tbl_discount_file", "tbl_discount_server_log", "tbl_discount_product", "tbl_imei_group", "tbl_file_group", "tbl_server_group", "tbl_product_group", "tbl_transaction", "tbl_blogs", "tbl_order_file", "tbl_services_file", "tbl_private_order", "tbl_mobile", "tbl_model_brand", "tbl_provider_country", "tbl_provider", "tbl_withdrawal", "tbl_return_request", "tbl_statement_user", "tbl_statement_supplier", "tbl_loginlog_user", "tbl_loginlog_admin", "tbl_apiservers", "tbl_system_activity"];
$field = ["tbl_order_imei" => ["ALTER TABLE `tbl_order_imei` ADD INDEX ( `order_id` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `user_can_c` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `verified` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `service_id` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `date` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `user_id` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `invoiceid` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `reply_time` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `imei` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `currency_id` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `profit` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `purchase_cost` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `retail_shop` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `gateway` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `reply_by_admin` )", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `reply_by_sup` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `reply_date` ) ", "ALTER TABLE `tbl_order_imei` ADD INDEX ( `service_id`, `user_can_c`)", "ALTER TABLE `tbl_order_imei` ADD  INDEX search ( `service_id`, `imei`)"], "tbl_services_imei" => ["ALTER TABLE `tbl_services_imei` ADD INDEX ( `group_id` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `status` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `service_name` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `active` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `API` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `API_ID` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `retail` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `store` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `model` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `provider` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `network` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `hot` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `purchase_cost` )", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `retail_credit` ) ", "ALTER TABLE `tbl_services_imei` ADD INDEX ( `review` ) "], "tbl_support_tickets" => ["ALTER TABLE `tbl_support_tickets` ADD INDEX ( `did` )", "ALTER TABLE `tbl_support_tickets` ADD INDEX ( `uid` )", "ALTER TABLE `tbl_support_tickets` ADD INDEX ( `sid` )", "ALTER TABLE `tbl_support_tickets` ADD INDEX ( `date` )", "ALTER TABLE `tbl_support_tickets` ADD INDEX ( `tid` )"], "tbl_invoices" => ["ALTER TABLE `tbl_invoices` ADD INDEX ( `userid` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `date` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `datepaid` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `status` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `paymentmethod` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `pos` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `duedate` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `total` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `adminid` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `subtotal` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `credit` )", "ALTER TABLE `tbl_invoices` ADD INDEX ( `tax` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `tax2` ) ", "ALTER TABLE `tbl_invoices` ADD INDEX ( `notice` ) "], "tbl_invoiceitems" => ["ALTER TABLE `tbl_invoiceitems` ADD INDEX ( `invoiceid` )", "ALTER TABLE `tbl_invoiceitems` ADD INDEX ( `userid` ) ", "ALTER TABLE `tbl_invoiceitems` ADD INDEX ( `relid` ) "], "tbl_review" => ["ALTER TABLE `tbl_review` ADD INDEX ( `status` ) ", "ALTER TABLE `tbl_review` ADD INDEX ( `pid` )", "ALTER TABLE `tbl_review` ADD INDEX ( `sid` )", "ALTER TABLE `tbl_review` ADD INDEX ( `lid` )"], "tbl_testimonial" => ["ALTER TABLE `tbl_testimonial` ADD INDEX ( `status` ) "], "tblUsers" => ["ALTER TABLE `tblUsers` ADD INDEX ( `username` )", "ALTER TABLE `tblUsers` ADD INDEX ( `userstatus` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `is_registered` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `credit_left` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `credit_date` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `usertype` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `online_status` ) ", "ALTER TABLE `tblUsers` ADD INDEX ( `client_group` )", "ALTER TABLE `tblUsers` ADD INDEX ( `email` ) "], "tbl_order_product" => ["ALTER TABLE `tbl_order_product` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `user_id` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `date` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `verified` )", "ALTER TABLE `tbl_order_product` ADD INDEX ( `user_can_c` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `invoiceid` ) ", "ALTER TABLE `tbl_order_product` ADD INDEX ( `reply_date` )"], "tbl_products" => ["ALTER TABLE `tbl_products` ADD INDEX ( `service_name` )", "ALTER TABLE `tbl_products` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_products` ADD INDEX ( `status` )", "ALTER TABLE `tbl_products` ADD INDEX ( `group_id` ) ", "ALTER TABLE `tbl_products` ADD INDEX ( `review` ) ", "ALTER TABLE `tbl_products` ADD INDEX ( `bysupplier` ) ", "ALTER TABLE `tbl_products` ADD INDEX ( `active` ) "], "tbl_order_server" => ["ALTER TABLE `tbl_order_server` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_order_server` ADD INDEX ( `user_id` ) ", "ALTER TABLE `tbl_order_server` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_order_server` ADD INDEX ( `user_can_c` )", "ALTER TABLE `tbl_order_server` ADD INDEX ( `reply` ) ", "ALTER TABLE `tbl_order_server` ADD INDEX ( `reply_time` )", "ALTER TABLE `tbl_order_server` ADD INDEX ( `invoiceid` ) ", "ALTER TABLE `tbl_order_server` ADD INDEX ( `reply_date` ) "], "tbl_server_log" => ["ALTER TABLE `tbl_server_log` ADD INDEX ( `service_name` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `group_id` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `active` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `API` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `purchase_cost` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `retail` ) ", "ALTER TABLE `tbl_server_log` ADD INDEX ( `store` )", "ALTER TABLE `tbl_server_log` ADD INDEX ( `show_onhome` ) "], "tbl_imei_credit" => ["ALTER TABLE `tbl_imei_credit` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_imei_credit` ADD INDEX ( `currency_id` ) ", "ALTER TABLE `tbl_imei_credit` ADD INDEX ( `credit` ) "], "tbl_file_credit" => ["ALTER TABLE `tbl_file_credit` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_file_credit` ADD INDEX ( `currency_id` ) ", "ALTER TABLE `tbl_file_credit` ADD INDEX ( `credit` ) "], "tbl_server_credit" => ["ALTER TABLE `tbl_server_credit` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_server_credit` ADD INDEX ( `currency_id` ) ", "ALTER TABLE `tbl_server_credit` ADD INDEX ( `credit` ) "], "tbl_product_credit" => ["ALTER TABLE `tbl_product_credit` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_product_credit` ADD INDEX ( `currency_id` ) ", "ALTER TABLE `tbl_product_credit` ADD INDEX ( `credit` ) "], "tbl_discount_imei" => ["ALTER TABLE tbl_discount_imei DROP INDEX user_id", "ALTER TABLE tbl_discount_imei DROP INDEX service_id ", "ALTER TABLE `tbl_discount_imei` DROP INDEX `discount` ", "ALTER TABLE `tbl_discount_imei` ADD INDEX `NEWIN` ( `user_id` , `service_id` ) "], "tbl_discount_file" => ["ALTER TABLE tbl_discount_file DROP INDEX user_id", "ALTER TABLE tbl_discount_file DROP INDEX service_id ", "ALTER TABLE `tbl_discount_file` DROP INDEX `discount` ", "ALTER TABLE `tbl_discount_file` ADD INDEX ( `user_id` , `service_id` ) "], "tbl_discount_server_log" => ["ALTER TABLE tbl_discount_server_log DROP INDEX user_id", "ALTER TABLE tbl_discount_server_log DROP INDEX service_id ", "ALTER TABLE `tbl_discount_server_log` DROP INDEX `discount` ", "ALTER TABLE `tbl_discount_server_log` ADD INDEX ( `user_id` , `service_id` ) "], "tbl_discount_product" => ["ALTER TABLE tbl_discount_product DROP INDEX user_id", "ALTER TABLE tbl_discount_product DROP INDEX service_id ", "ALTER TABLE `tbl_discount_product` DROP INDEX `discount` ", "ALTER TABLE `tbl_discount_product` ADD INDEX ( `user_id` , `service_id` ) "], "tbl_imei_group" => ["ALTER TABLE `tbl_imei_group` ADD INDEX ( `group_name`)", "ALTER TABLE `tbl_imei_group` ADD INDEX ( `active` ) "], "tbl_file_group" => ["ALTER TABLE `tbl_file_group` ADD INDEX ( `group_name`)", "ALTER TABLE `tbl_file_group` ADD INDEX ( `active` ) "], "tbl_server_group" => ["ALTER TABLE `tbl_server_group` ADD INDEX ( `group_name`)", "ALTER TABLE `tbl_server_group` ADD INDEX ( `active` ) "], "tbl_product_group" => ["ALTER TABLE `tbl_product_group` ADD INDEX ( `group_name`)", "ALTER TABLE `tbl_product_group` ADD INDEX ( `active` ) "], "tbl_transaction" => ["ALTER TABLE `tbl_transaction` ADD INDEX ( `invoiceid` )", "ALTER TABLE `tbl_transaction` ADD INDEX ( `userid` )", "ALTER TABLE `tbl_transaction` ADD INDEX ( `date` )", "ALTER TABLE `tbl_transaction` ADD INDEX ( `transid` )", "ALTER TABLE `tbl_transaction` ADD INDEX ( `currency` ) ", "ALTER TABLE `tbl_transaction` ADD INDEX ( `amountin` )", "ALTER TABLE `tbl_transaction` ADD INDEX ( `amountout` ) "], "tbl_blogs" => ["ALTER TABLE `tbl_blogs` ADD INDEX ( `date` )", "ALTER TABLE `tbl_blogs` ADD INDEX ( `status` )", "ALTER TABLE `tbl_blogposts` ADD INDEX ( `date` ) ", "ALTER TABLE `tbl_blogcomments` ADD INDEX ( `date` )"], "tbl_order_file" => ["ALTER TABLE `tbl_order_file` ADD INDEX ( `service_id` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `user_id` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `file` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `date` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `time` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `credit` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `discount` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `reply` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `currency_id` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `purchase_cost` )", "ALTER TABLE `tbl_order_file` ADD INDEX ( `reply_time` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `verified` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `profit` ) ", "ALTER TABLE `tbl_order_file` ADD INDEX ( `reply_date` )", "ALTER TABLE `tbl_order_file` ADD INDEX (`user_can_c`)"], "tbl_services_file" => ["ALTER TABLE `tbl_services_file` ADD INDEX ( `service_name` ) ", "ALTER TABLE `tbl_services_file` ADD INDEX ( `credit` ) ", "ALTER TABLE `tbl_services_file` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_services_file` ADD INDEX ( `group_id` )", "ALTER TABLE `tbl_services_file` ADD INDEX ( `active` )", "ALTER TABLE `tbl_services_file` ADD INDEX ( `purchase_cost` ) ", "ALTER TABLE `tbl_services_file` ADD INDEX ( `hot` )  "], "tbl_private_order" => ["ALTER TABLE `tbl_private_order` ADD INDEX ( `sid` )", "ALTER TABLE `tbl_private_order` ADD INDEX ( `uid` )", "ALTER TABLE `tbl_private_order` ADD INDEX ( `cid` )", "ALTER TABLE `tbl_private_order` ADD INDEX ( `status` )", "ALTER TABLE `tbl_private_order` ADD INDEX ( `date` )"], "tbl_mobile" => ["ALTER TABLE `tbl_mobile` ADD INDEX ( `B_ID` ) ", "ALTER TABLE `tbl_mobile` ADD INDEX ( `Name` )", "ALTER TABLE `tbl_mobile` ADD INDEX ( `N_ID` )", "ALTER TABLE `tbl_model_brand` ADD INDEX ( `Name` ) ", "ALTER TABLE `tbl_model_brand` ADD INDEX ( `N_ID` )", "ALTER TABLE `tbl_model_brand` ADD INDEX ( `B_ID` )"], "tbl_provider" => ["ALTER TABLE `tbl_provider_country` ADD INDEX ( `Name` )", "ALTER TABLE `tbl_provider_country` ADD INDEX ( `N_ID` ) ", "ALTER TABLE `tbl_provider` ADD INDEX ( `C_ID` ) ", "ALTER TABLE `tbl_provider` ADD INDEX ( `Name` ) ", "ALTER TABLE `tbl_provider` ADD INDEX ( `N_ID` ) "], "tbl_withdrawal" => ["ALTER TABLE `tbl_withdrawal` ADD INDEX ( `uid` ) ", "ALTER TABLE `tbl_withdrawal` ADD INDEX ( `amount` )", "ALTER TABLE `tbl_withdrawal` ADD INDEX ( `date` )", "ALTER TABLE `tbl_withdrawal` ADD INDEX ( `status` ) "], "tbl_return_request" => ["ALTER TABLE `tbl_return_request` ADD INDEX ( `oid` ) ", "ALTER TABLE `tbl_return_request` ADD INDEX ( `date` )", "ALTER TABLE `tbl_return_request` ADD INDEX ( `status` )", "ALTER TABLE `tbl_return_request` ADD INDEX ( `uid` ) "], "tbl_statement_user" => ["ALTER TABLE `tbl_statement_user` ADD INDEX ( `uid` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `stype` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `date` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `time` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `type` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `amount` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `relid` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `adminid` ) ", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `imei` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `file` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `server` )", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `shop` ) ", "ALTER TABLE `tbl_statement_user` ADD INDEX ( `balance` )"], "tbl_statement_supplier" => ["ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `supplier_id` )", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `stype` ) ", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `date` )", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `time` )", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `type` )", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `relid` )", "ALTER TABLE `tbl_statement_supplier` ADD INDEX ( `tid` )  "], "tbl_loginlog_user" => ["ALTER TABLE `tbl_loginlog_user` ADD INDEX ( `username` )", "ALTER TABLE `tbl_loginlog_user` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_loginlog_user` ADD INDEX ( `userid` )", "ALTER TABLE `tbl_loginlog_admin` ADD INDEX ( `username` )", "ALTER TABLE `tbl_loginlog_admin` ADD INDEX ( `time` ) ", "ALTER TABLE `tbl_loginlog_admin` ADD INDEX ( `userid` )"], "tbl_apiservers" => ["ALTER TABLE `tbl_system_activity` ADD INDEX ( `date` )"]];
if ($index) {
    $fl = 0;
    $ind = dquery("SHOW INDEX FROM tbl_order_imei");
    while ($r = mysqli_fetch_assoc($ind)) {
        if ($r["Key_name"] == "service_id_2") {
            $fl = 1;
        }
    }
    if ($fl == 0) {
        dquery("ALTER TABLE `tbl_order_imei` ADD INDEX ( `service_id`, `user_can_c`)");
    }
    $fl2 = 0;
    $ind = dquery("SHOW INDEX FROM tbl_order_imei");
    while ($r = mysqli_fetch_assoc($ind)) {
        if ($r["Key_name"] == "search") {
            $fl2 = 1;
        }
    }
    if ($fl2 == 0) {
        dquery("ALTER TABLE `tbl_order_imei` ADD  INDEX search ( `service_id`, `imei`)");
    }
    foreach ($tables as $t) {
        $cnt = 0;
        $ind = dquery("SHOW INDEX FROM " . $t);
        $cnt++;
        if ($r = mysqli_fetch_assoc($ind)) {
        } else {
            $cnt--;
        }
        if (0 < $cnt) {
            foreach ($field[$t] as $q) {
                dquery($q);
            }
        }
    }
    $cnt = 0;
    $cnt++;
    $ind = dquery("SHOW INDEX FROM `tbl_discount_imei`");
    while ($r = mysqli_fetch_assoc($ind)) {
        if ($r["Key_name"] == "NEWIN") {
            $cnt--;
        }
    }
    if (0 < $cnt) {
        $newarr = ["tbl_discount_imei", "tbl_discount_file", "tbl_discount_server", "tbl_discount_product"];
        foreach ($newarr as $t) {
            foreach ($field[$t] as $q) {
                dquery($q);
            }
        }
    }
}
$cnt++;
$ind = dquery("SHOW INDEX FROM `tbl_discount_imei`");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "NEWIN") {
        $cnt--;
    }
}
$cnt++;
$ind = dquery("SHOW INDEX FROM `tbl_order_imei`");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "search") {
        $cnt--;
    }
}
$flag = 0;
$cnt++;
$ind = dquery("SHOW INDEX FROM tbl_order_imei");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "service_id_2") {
        $flag = 1;
        $cnt--;
    }
}
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Database Status</a></li>\n</ul>\n";
if (0 < $cnt) {
    echo "<!--<div id=\"notification1\" class=\"info\">\nYour database is not indexed. <a href=\"main2.php?page=utilities.databasestatus&index=true\">Click here</a> to Indexed your database\n</div>-->\n";
}
$flagcil = 0;
$col = dquery("SHOW FULL COLUMNS FROM tbl_withdrawal_transaction");
while ($rcol = mysqli_fetch_assoc($col)) {
    if ($rcol["Field"] == "transid" && $rcol["Collation"] != "utf8_general_ci") {
        $flagcil = 1;
    }
}
if (0 < $flagcil) {
    echo "<div id=\"notification1\" class=\"info\">\nYour database character set is not utf8. <a href=\"main2.php?page=utilities.databasestatus&collation=true\">Click here</a> to set utf8\n</div>\n";
}
echo "<script>\n    function Indexing()\n    {\n        \$.post(\"api/v1/optimize/?index=1\", function(data, status){\n\n            if(data.status=='success'){\n\n                \$(\"#notification\").addClass(\"successbox\");\n                \$(\"#notification\").html(\"Database indexed\");\n\n            }else{\n                \$(\"#notification\").addClass(\"errorbox\");\n                \$(\"#notification\").html(\"Indexing failed\");\n            }\n        });\n    }\n\n    function Optimize()\n    {\n        \$.post(\"api/v1/optimize/?optimize=1\", function(data, status){\n\n            if(data.status=='success'){\n\n                \$(\"#notification\").addClass(\"successbox\");\n                \$(\"#notification\").html(\"Database Optimized\");\n\n            }else{\n                \$(\"#notification\").addClass(\"errorbox\");\n                \$(\"#notification\").html(\"Optimization failed\");\n            }\n        });\n    }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
$database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
$result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
$total = 0;
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $table[$i]["name"] = $row["Name"];
    $size = round($row["Data_length"] / 1048576, 2);
    $table[$i]["size"] = $size;
    $total = $total + $row["Data_length"] + $row["Index_length"];
    $i = $i + 1;
}
$total = $total / 1048576;
echo " \n";
if ($optimize) {
    $database = mysqli_fetch_assoc(dquery("SELECT database() as db"));
    $result = dquery("SHOW TABLE STATUS FROM " . $database["db"]);
    echo "    <table id=\"main_tbl\">\n    <thead>\n    <tr>\n    <th>";
    echo $LNG["table"];
    echo "</th>\n    <th>";
    echo $LNG["state"];
    echo "</th>\n    <th>";
    echo $LNG["message"];
    echo "</th>\n    <th></th>\n    </tr>\n    </thead>\n    ";
    while ($row = mysqli_fetch_assoc($result)) {
        $tabled = $row["Name"];
        $r = mysqli_fetch_assoc(dquery("OPTIMIZE TABLE " . $tabled . " "));
        echo "        <tr>\n        <td>";
        echo $r["Table"];
        echo "</td>\n        <td>";
        echo $r["Op"];
        echo "</td>\n        <td>";
        echo $r["Msg_text"];
        echo "</td>\n        <td></td>\n        </tr>\n        ";
    }
    echo "    </table>\n    <br /><br />\n    ";
}
echo "<table><tbody><tr><td valign=\"top\" style=\"padding: 0 20px;\">\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n  <th>";
echo $LNG["tablename"];
echo "</th><th>";
echo $LNG["size"];
echo " [MB]</th><th></th>\n  </tr>\n</thead>\n<tbody> \n";
for ($i = 0; $i < round(count($table) / 2); $i++) {
    if (!(deregi("imei", $table[$i]["name"]) || deregi("file", $table[$i]["name"]) || deregi("server", $table[$i]["name"]) || deregi("model", $table[$i]["name"]) || deregi("brand", $table[$i]["name"]) && $OnlyEcommerce)) {
        echo "<tr><td>" . $table[$i]["name"] . "</td><td>" . $table[$i]["size"] . "</td><td></td></tr>";
    }
}
echo "            \n</tbody></table>\n</td>\n\n\n<td valign=\"top\"  style=\"padding: 0 20px;\"> \n\n<table id=\"main_tbl\">\n<thead>\n  <tr>\n  <th>";
echo $LNG["tablename"];
echo "</th><th>";
echo $LNG["size"];
echo " [MB]</th><th></th>\n  </tr>\n</thead>\n<tbody> \n";
for ($i = round(count($table) / 2); $i < count($table); $i++) {
    if (!(deregi("imei", $table[$i]["name"]) || deregi("file", $table[$i]["name"]) || deregi("server", $table[$i]["name"]) || deregi("model", $table[$i]["name"]) || deregi("brand", $table[$i]["name"]) && $OnlyEcommerce)) {
        echo "<tr><td>" . $table[$i]["name"] . "</td><td>" . $table[$i]["size"] . "</td><td></td></tr>";
    }
}
echo "            \n</tbody></table>\n</td>\n\n</tr></tbody></table>\n\n<p class=\"fixedbtn\">\n\n\n    <input type=\"button\" onclick=\"serverRequest('optimize/?optimize=1','','#optimize',true)\" id=\"optimize\" name=\"optimize\" value=\"";
echo $LNG["optimizedb"];
echo "\" />\n\n    <input type=\"button\"  onclick=\"serverRequest('optimize/?index=1','','#indexing',true)\" id=\"indexing\" name=\"indexing\" value=\"Indexing\" />\n\n</p>\n\n<br />\n<div align=\"right\"><strong>";
echo $LNG["total"];
echo " ";
echo $LNG["size"];
echo " : ";
echo round($total, 2);
echo " [MB]</strong></div>\n\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>