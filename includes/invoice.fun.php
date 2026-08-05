<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function generateInvoice($userid = "", $sendemail = true, $posdiscount = "", $flagpaid = false, $notes = "", $retail = false)
{
    global $admindirpath;
    global $config;
    $z = 0;
    $where = [];
    $where["invoiceid"] = "";
    if ($userid) {
        $where["userid"] = $userid;
    }
    $result = select_query("tbl_invoiceitems", "DISTINCT userid,duedate,paymentmethod,pos,warehouse", $where, "duedate", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        $userid = $data["userid"];
        if (!function_exists("getClientDetails")) {
            require_once ROOTDIR . "/includes/clients.fun.inc.php";
        }
        $_ClientsDetails = getClientsDetails($userid);
        $duedate = $data["duedate"];
        $paymentmethod = $data["paymentmethod"];
        $shippingtax = $data["shippingtax"];
        if ($config["taxenabled"]) {
            $taxrate = getTaxRate(1, $_ClientsDetails["state"], $_ClientsDetails["country"], $data["paymentmethod"]);
            $taxrate2 = getTaxRate(2, $_ClientsDetails["state"], $_ClientsDetails["country"], $data["paymentmethod"]);
            $taxrate = $taxrate["rate"];
            $taxrate2 = $taxrate2["rate"];
        }
        $incs = dquery("SHOW TABLE STATUS LIKE 'tbl_invoices'");
        $iso = mysqli_fetch_assoc($incs);
        if (!$config["invoiceincrement"]) {
            $config["invoiceincrement"] = 1;
        }
        if ($flagpaid) {
            $invsmask = mysqli_fetch_assoc(dquery("select mask from \n            tbl_invoices where status='Paid' order by mask desc limit 1"));
        } else {
            $invsmask = mysqli_fetch_assoc(dquery("select mask from \n             tbl_invoices where status='Unpaid' order by mask desc limit 1"));
        }
        $time = time();
        $invoiceid = insert_query("tbl_invoices", ["date" => "now()", "duedate" => $duedate, "time" => $time, "retail" => $retail, "orderstatus" => "new", "userid" => $userid, "status" => "Unpaid", "taxrate" => $taxrate, "taxrate2" => $taxrate2, "paymentmethod" => $paymentmethod, "shippingtax" => $shippingtax, "adminid" => ADMIN == "1" ? $_SESSION["adminid"] : "", "pos" => $data["pos"], "posdiscount" => $posdiscount, "bundleid" => $data["bundleid"], "notes" => $notes, "mask" => $invsmask["mask"] + 1, "id" => $iso["Auto_increment"] + $config["invoiceincrement"] - 1, "warehouse" => $data["warehouse"]]);
        update_query("tbl_invoiceitems", ["invoiceid" => $invoiceid], ["invoiceid" => "", "duedate" => $duedate, "userid" => $userid, "paymentmethod" => $paymentmethod]);
        logActivity("Created Invoice - Invoice ID: " . $invoiceid);
        updateInvoiceTotal($invoiceid);
        $query2 = "SELECT total FROM tbl_invoices WHERE id='" . $invoiceid . "' AND status='Unpaid'";
        $result2 = dquery($query2);
        $data2 = mysqli_fetch_assoc($result2);
        $total = $data2["total"];
        if ($sendemail) {
            include_once ROOTDIR . "/includes/mail.fun.php";
            $mailarr = ["invoiceid" => "P/" . ($invsmask["mask"] + 1), "referenceid" => $invoiceid];
          //  sendMail(31, $userid, "", $mailarr, true);
            if ($config["adminotice_newinvoice"] && $config["adminnotice"]) {
                $usr = mysqli_fetch_assoc(dquery("select username from \n                tblUsers where id='" . $userid . "'"));
                $adminmessage = "Proforma Invoice #P/" . ($invsmask["mask"] + 1) . " <br />\n                UserID #" . $userid . " <br />\n                Reference #" . $invoiceid . " <br />\n                Username :" . $usr["username"] . " <br />\n                Invoice Amount # " . $total . " <br />";
                $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
                $here = "<a href='" . $siteaddress . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Proforma Invoice #" . $invoiceid) . "'>here</a>";
                $adminmessage .= "<br /> <br />\n                You can view invoice  from " . $here;
                sendNotification("account", "Proforma Invoice #P/" . ($invsmask["mask"] + 1), $adminmessage, "");
                $adminmessage = NULL;
            }
        }
        if ($userid) {
            return $invoiceid;
        }
    }
}
function updateInvoiceTotal($id)
{
    global $admindirpath;
    global $config;
    global $precision;
    $shippingtax = 0;
    $allpromotion = 0;
    $result = dquery("select * from tbl_invoiceitems where invoiceid='" . $id . "'");
    while ($data = mysqli_fetch_assoc($result)) {
        $qnt = 0 < $data["qnt"] ? $data["qnt"] : 1;
        if ($data["promotion"]) {
            $allpromotion = $allpromotion + $data["promotion"];
        }
        $promocode = $data["promotion_code"];
        if ($data["shippingtax"] != "0.00") {
            $warehoulse[$data["warehouseid"]] = $data["shippingtax"];
        }
        if ($data["taxed"] == "1") {
            $taxsubtotal += $data["amount"] * $qnt;
        } else {
            $nontaxsubtotal += $data["amount"] * $qnt;
        }
    }
    if (is_array($warehoulse)) {
        foreach ($warehoulse as $w) {
            $shippingtax += $w;
        }
    }
    $subtotal = $total = $nontaxsubtotal + $taxsubtotal;
    $result = select_query("tbl_invoices", "userid,credit,taxrate,taxrate2,posdiscount", ["id" => $id]);
    $data = mysqli_fetch_assoc($result);
    $userid = $data["userid"];
    $credit = $data["credit"];
    $taxrate = $data["taxrate"];
    $taxrate2 = $data["taxrate2"];
    $posdicount = $data["posdiscount"];
    $tax = $tax2 = 0;
    if ($config["taxenabled"]) {
        if ($taxrate != "0.00") {
            $tax = $taxsubtotal * $taxrate / 100;
        }
        if ($taxrate2 != "0.00") {
            $tax2 = $taxsubtotal * $taxrate2 / 100;
        }
        $tax = round($tax, $precision);
        $tax2 = round($tax2, $precision);
    }
    if ($config["taxtype"] == "Inclusive") {
        $total = $subtotal;
        $subtotal = $subtotal - $tax - $tax2;
    } else {
        $total = $subtotal + $tax + $tax2;
    }
    $total = $total + $shippingtax;
    if (0 < $credit) {
        if ($total < $credit) {
            $total = 0;
            $remainingcredit = $total - $credit;
        } else {
            $total -= $credit;
        }
    }
    if ($promocode != "" && 0 < $subtotal) {
        $cur = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $userid . "'"));
        if (!function_exists(getPromotion)) {
            require_once ROOTDIR . "/includes/cart.fun.php";
        }
        $getpromo = getPromotion($promocode, ["id" => $cur["default_currency"]], $subtotal, "", "", $subtotal);
        if ($getpromo) {
            $allpromotion = $getpromo;
        }
    }
    $total = $total - $allpromotion;
    if ($posdicount) {
        $total = $total - $posdicount;
    }
    update_query("tbl_invoices", ["subtotal" => round($subtotal, 2), "tax" => round($tax, 2), "tax2" => round($tax2, 2), "total" => round($total, 2), "shippingtax" => $shippingtax, "promotion" => $allpromotion], ["id" => $id]);
}
function applyCredit($invoiceid, $userid, $amount)
{
    $query = "UPDATE tbl_invoices SET credit=credit+" . $amount . " WHERE id='" . descape($invoiceid) . "'";
    full_query($query);
    $uds = descape($userid);
    $query = "UPDATE tblUsers SET credit_left=credit_left-'" . $amount . "' WHERE id='" . $uds . "'";
    dquery("UPDATE tbl_invoiceitems SET used='1' WHERE invoiceid='" . $invoiceid . "'");
    full_query($query);
    addStatementuser($userid, "Credit Apply to Invoice# " . $invoiceid, "DR", $amount, $invoiceid);
    updateinvoicetotal($invoiceid);
    $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
    $data = mysqli_fetch_assoc($result);
    $total = $data["total"];
    $result = select_query("tbl_transaction", "SUM(amountin)-SUM(amountout)", ["invoiceid" => $invoiceid]);
    $data = mysqli_fetch_assoc($result);
    $amountpaid = $data[0];
    $balance = $total - $amountpaid;
    logActivityGlobal("Apply Credit [#" . $invoiceid . "] Amount: [" . $amount . "] ", "invoice", $userid, $_SESSION["adminid"] ? "admin" : "user");
    if ($balance <= 0) {
        processInvoicetoPaid($invoiceid);
    }
}
function addPayment($invoiceid, $transid, $amount, $fees, $gateway, $sendemail = true, $date = "", $desc = "Invoice Payment", $payeremail = "")
{
    global $admindirpath;
    global $adminAddPayment;
    global $config;
    $result = select_query("tbl_invoices", "userid,total,status", ["id" => $invoiceid]);
    $data = mysqli_fetch_assoc($result);
    $userid = $data["userid"];
    $total = $data["total"];
    $status = $data["status"];
    $result = mysqli_fetch_assoc(dquery("select sum(amountin)-sum(amountout) as tot\n    from tbl_transaction where invoiceid='" . $invoiceid . "'"));
    $amountpaid = $result["tot"];
    $balance = $total - $amountpaid;
    if (!$amount) {
        $amount = $balance;
        if ($amount <= 0) {
            return false;
        }
    }
    dquery("update tbl_invoices set receivedamount=receivedamount+'" . $amount . "' where id='" . $invoiceid . "'");
    addTransaction($userid, 0, $desc, $amount, $fees, 0, $gateway, $transid, $invoiceid, $date, "", "", $payeremail);
    $balance = formatCurrency2($balance);
    $amount = formatCurrency2($amount);
    $balance -= $amount;
    logActivity("Added Invoice Payment - Invoice ID: " . $invoiceid);
    logActivityGlobal("Add Payment [#" . $invoiceid . "] Amount: [" . $amount . "] ", "invoice", $userid, $_SESSION["adminid"] ? "admin" : "user");
    if ($balance <= 0 && $status == "Unpaid") {
        processInvoicetoPaid($invoiceid, $sendemail, $date, $payeremail);
        $status = "Paid";
    } else {
        if ($sendemail) {
            include_once ROOTDIR . "/includes/mail.fun.php";
            $email_merge_fields["invoice"] = $invoiceid;
            $email_merge_fields["payment"] = $amount;
            sendMail(30, $userid, "", $email_merge_fields);
            $sql = mysqli_fetch_assoc(dquery("select username,(select code from tbl_currencies \nwhere id=default_currency) as code from tblUsers where id='" . $userid . "'"));
            $username = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser&id=" . $userid) . "&title=" . base64_encode("Edit User") . "'>" . $sql["username"] . "</a>";
            $adminmessage .= "<br /> <br />\n            You can view user account from " . $here . "            ";
            $here = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>" . $sql["username"] . "</a>";
            $adminmessage .= "<br /> <br />\n            You can view Invoice from " . $here;
            $adminmessage = "Payment Received For Invoice #" . $invoiceid . " <br />\n            UserID:" . $username . "  #" . $userid . " <br />\n            Invoice Amount # " . $amount . " <br />\n            Invoice Status # UnPaid <br />\n            Invoice outstanding balance # " . $balance . "\n            Payer Email : " . $payeremail . "\n            <br /> <br />\n            You can view invoice from " . $here . "";
            if (!$adminAddPayment) {
                sendNotification("account", "Payment Received For Invoice #" . $invoiceid, $adminmessage, "");
            }
            $adminmessage = NULL;
        }
    }
    if ($config["slack_manualinvoicepaid"] && isset($_SESSION["adminid"])) {
        $qq = dquery("select description from tbl_invoiceitems where \n                invoiceid='" . $invoiceid . "'");
        $sql = mysqli_fetch_assoc(dquery("select username,(select code from tbl_currencies where id=default_currency) as code  from \ntblUsers where id='" . $userid . "'"));
        $invoiceitemsarr = [];
        while ($rs = mysqli_fetch_assoc($qq)) {
            $invoiceitemsarr[] = $rs["description"];
        }
        $_cols[0]["titel"] = $invoiceid;
        $_cols[0]["text"] = $status;
        $_cols[1]["titel"] = $sql["username"];
        $_cols[1]["text"] = $amount . "" . $sql["code"];
        if ($transid) {
            $Gateway = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\nwhere setting='name' and gateway='" . $gateway . "'"));
            $_cols[2]["titel"] = $Gateway["value"];
            $_cols[2]["text"] = $transid;
        }
        $callwithout[100]["titel"] = "Items";
        $callwithout[100]["text"] = implode("\n", $invoiceitemsarr);
        SlackSendMsg($config["slack_manualinvoicepaid"], "Manual Invoice Process", "good", $_cols, true, "", $callwithout);
    }
}
function addTransaction($userid, $currencyid, $description, $amountin, $fees, $amountout, $gateway = "", $transid = "", $invoiceid = "", $date = "", $refundid = "", $rate = "", $payeremail = "")
{
    $date = $date ? formatDateforMySQL($date) . date("His") : "now()";
    if (!$rate) {
        $result = select_query("tbl_currencies", "rate", ["id" => $currencyid]);
        $data = mysqli_fetch_assoc($result);
        $rate = $data["rate"];
    }
    $array = ["userid" => $userid, "currency" => $currencyid, "gateway" => $gateway, "date" => $date, "description" => $description, "amountin" => $amountin, "fees" => $fees, "amountout" => $amountout, "rate" => $rate, "transid" => $transid, "invoiceid" => $invoiceid, "payerid" => $payeremail, "adminid" => $_SESSION["adminid"], "refundid" => $refundid];
    $saveid = insert_query("tbl_transaction", $array);
    logActivity("Added Transaction - Transaction ID: " . $saveid);
}
function processInvoicetoPaid($invoiceid, $sendemail = true, $date = "", $payeremail = "")
{
    global $config;
    global $adminAddPayment;
    global $admindirpath;
    global $db;
    global $precision;
    $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
    $data = mysqli_fetch_assoc($result);
    $invoicestatus = $data["status"];
    $mask = $data["mask"];
    $credit = $data["credit"];
    $paymentmethod = $data["paymentmethod"];
    $subtotals = $data["subtotal"];
    $invoicenum = $data["invoicenum"];
    if ($invoicestatus != "Unpaid") {
        return false;
    }
    $business = $data["businessid"];
    $invoiceitemsarr = [];
    $result = select_query("tbl_invoiceitems", "", "invoiceid='" . descape($invoiceid) . "' AND type!=''", "id", "ASC");
    while ($data = mysqli_fetch_assoc($result)) {
        $userid = $data["userid"];
        $type = $data["type"];
        $relid = $data["relid"];
        $amount = $data["amount"];
        $used = $data["used"];
        $invoiceitemsarr[] = $data["description"];
        include_once ROOTDIR . "/includes/mail.fun.php";
        $userdtl = mysqli_fetch_assoc(dquery("select fraud_protection,paypalaccount,\n        default_currency,username,usertype,client_group,email,reseller_id from tblUsers\n         where id='" . $userid . "'"));
        $clientgroup = $userdtl["client_group"];
        $currency = $userdtl["default_currency"];
        $AllowedEmail = true;
        if (mysqli_num_rows(dquery("select order_id from tbl_order_imei\n        where order_id='" . $data["relid"] . "' and retail_shop=1")) && $data["type"] == "IMEI") {
            $userdtl["fraud_protection"] = 0;
        }
        if ($config["paypalemailautopay"] && $paymentmethod == "paypal" && trim($userdtl["paypalaccount"])) {
            $AllowedEmail = false;
            $paypalid = trim($userdtl["paypalaccount"]);
            $paypalid = json_decode($paypalid, true);
            foreach ($paypalid as $paypalemail) {
                if ($payeremail == $paypalemail) {
                    $AllowedEmail = true;
                    dquery("update tbl_invoices set notes='Allowed Other Payer email' where id='" . $invoiceid . "'");
                }
            }
        }
        if (isFraudUser(trim($userdtl["email"]))) {
            dquery("update tbl_invoices set onhold=1 where id='" . $invoiceid . "'");
            $adminmessage = "Client #ID " . $userid . " (" . $userdtl["username"] . ")\n    <br><Br> Paid invoice#I/" . $invoiceid . " . \n      <br><Br>  This email is available in fraud list so please review payment and Pay invoice Manualy .";
            $here = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>here</a>";
            $fc = "<a href='http://fraudcage.com/checkfraud/" . $userdtl["email"] . "'>FraudCage.com</a>";
            $adminmessage .= "<br /> <br />\n    You can view invoice from " . $here . " <br />\n    You can check detial on " . $fc . " if listed\n    \n    ";
            sendNotification("account", "Fraud Email [Manually process invoice #" . $invoiceid . "]", $adminmessage, "");
            return false;
        }
        if (isFraudUser(trim($business))) {
            dquery("update tbl_invoices set onhold=1 where id='" . $invoiceid . "'");
            $adminmessage = "Client #ID " . $userid . " (" . $userdtl["username"] . ")\n            <br><Br> Paid invoice#I/" . $invoiceid . " . \n              <br><Br>  This client's business email " . $business . " available in fraud list so please review payment and Pay invoice Manualy .";
            $here = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>here</a>";
            $adminmessage .= "<br /> <br />\n            You can view invoice from " . $here;
            sendNotification("account", "Fraud Email [Manually process invoice #" . $invoiceid . "]", $adminmessage, "");
            return false;
        }
        if ($userdtl["fraud_protection"] && !$adminAddPayment || !$AllowedEmail && !$adminAddPayment) {
            dquery("update tbl_invoices set onhold=1 where id='" . $invoiceid . "'");
            $adminmessage = "Client #ID " . $userid . " (" . $userdtl["username"] . ")\n            <br><Br> Paid invoice#I/" . $invoiceid . " . \n              <br><Br>  This client enable fraud protection so please review payment and Pay invoice Manualy .";
            $sitelink = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config[site_address];
            $here = "<a href='" . $sitelink . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>here</a>";
            $adminmessage .= "<br /> <br />\n            You can view invoice from " . $here . "\n            ";
            sendNotification("account", "Fraud protection [Manually process invoice #" . $invoiceid . "]" . (!$AllowedEmail ? ". Payer email mismatch." : ""), $adminmessage, "");
            if ($config["slack_fraudinvoice"]) {
                $sql = mysqli_fetch_assoc(dquery("select (select username from \ntblUsers where id=userid) as username,(select code from tbl_currencies where \nid=(select default_currency from \ntblUsers where id=userid)) as code,(select `value` from \ntbl_paymentgateways where setting='name' and gateway=paymentmethod) as gateway,\n(select transid from tbl_transaction where invoiceid=id limit 1) as transaction\n from tbl_invoices where id='" . $invoiceid . "'"));
                $qq = dquery("select description from tbl_invoiceitems where \n                invoiceid='" . $invoiceid . "'");
                $invoiceitemsarr = [];
                while ($rs = mysqli_fetch_assoc($qq)) {
                    $invoiceitemsarr[] = $rs["description"];
                }
                $_cols[0]["titel"] = "Paid Amount";
                $_cols[0]["text"] = $amount . "" . $sql["code"];
                $_cols[1]["titel"] = $sql["gateway"];
                $_cols[1]["text"] = $sql["transaction"];
                $callwithout[100]["titel"] = "Items";
                $callwithout[100]["text"] = implode("\n", $invoiceitemsarr);
                SlackSendMsg($config["slack_fraudinvoice"], !$AllowedEmail ? "Fraud protection for Invoice #" . $invoiceid . ". Payer email mismatch." : "Fraud Protection alert for Invoice #" . $invoiceid, "good", $_cols, true, "", $callwithout);
            }
            return false;
        }
        if ($data["promotion_code"]) {
            $promocode = enc($data["promotion_code"], "9486");
            $date = date("Y-m-d");
            $qn = dquery("select * from tbl_promotion where code='" . $promocode . "'  and (\n\t('" . $date . "' between vali_start and vali_end)\n\tor (vali_start='' or vali_end='') ) and used>0");
            if (mysqli_num_rows($qn)) {
                $qn = mysqli_fetch_assoc($qn);
                $userspr = explode(",", $qn["uid"]);
                $flag = true;
                foreach ($userspr as $u) {
                    if ($u == $userid) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $qn["uid"] = $qn["uid"] . "," . $userid;
                    $qn["uid"] = trim($qn["uid"], ",");
                }
                dquery("update tbl_promotion set \n                    used=used-1,uid='" . $qn["uid"] . "' where id='" . $qn["id"] . "'");
                if ($config["adminotice_rechargevoucher"]) {
                    $adminmessage = "Promocode Used in Invoice :" . $invoiceid . " <br />\n                 Promocode : " . $data["promotion_code"] . " <br /> \n                 User ID : " . $userid;
                    sendNotification("account", "Promo code used in invoice #" . $invoiceid, $adminmessage, "");
                }
            }
        }
        if ($type == "Subscription") {
            $serviced = $data["service"];
            $sid = $data["serviceid"];
            if ($serviced == "imei") {
                $uid = $userid;
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency,credit_left\n                         FROM tblUsers WHERE id='" . $uid . "'"));
                $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_imei_credit where \n                            service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,\n                            subscribe_days,service_name \n                            FROM tbl_services_imei where id='" . $sid . "'"));
                $table = "tbl_services_imei";
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                $name = "IMEI";
                addStatementuser($uid, "Subscription for Service : " . $serv["service_name"] . " ", "DR", $price, "", $name, 1);
                $email_merge_fields["type"] = $serv["service_name"];
                $email_merge_fields["subscription_start"] = date("d-m-Y");
                $end = time() + $serv["subscribe_days"] * 24 * 60 * 60;
                $email_merge_fields["subscription_end"] = date("d-m-Y", $end);
                $days = (int) ($end - time()) / 86400;
                $email_merge_fields["days"] = $days;
                sendMail(52, $uid, "", $email_merge_fields, true);
                $datar["user_id"] = $uid;
                $datar["type"] = "tbl_services_imei";
                $datar["service_id"] = $sid;
                $datar["status"] = "active";
                $datar["subscribe_start"] = time();
                $sub = mysqli_fetch_assoc(dquery("SELECT subscribe_days FROM \n                        tbl_services_imei WHERE id='" . $sid . "'"));
                $datar["subscribe_end"] = time() + $sub["subscribe_days"] * 24 * 60 * 60;
                $rid = $db->insert("tbl_subscribers", $datar);
                $datar = NULL;
            }
            if ($serviced == "shop") {
                $uid = $userid;
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency,\n                        credit_left FROM tblUsers WHERE id='" . $uid . "'"));
                $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe\n                         FROM tbl_product_credit where  service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit\n                        ,subscribe_days,service_name \n                            FROM tbl_products where id='" . $sid . "'"));
                $table = "tbl_products";
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                $name = "Product";
                addStatementuser($uid, "Subscription for Service : " . $serv["service_name"] . " ", "DR", $price, "", $name, 1);
                $email_merge_fields["type"] = $serv["service_name"];
                $email_merge_fields["subscription_start"] = date("d-m-Y");
                $end = time() + $serv["subscribe_days"] * 24 * 60 * 60;
                $email_merge_fields["subscription_end"] = date("d-m-Y", $end);
                $days = (int) ($end - time()) / 86400;
                $email_merge_fields["days"] = $days;
                sendMail(52, $uid, "", $email_merge_fields, true);
                $datar["user_id"] = $uid;
                $datar["type"] = "tbl_products";
                $datar["service_id"] = $sid;
                $datar["subscribe_start"] = time();
                $sub = mysqli_fetch_assoc(dquery("SELECT subscribe_days FROM tbl_products \n                        WHERE id='" . $sid . "'"));
                $datar["subscribe_end"] = time() + $sub["subscribe_days"] * 24 * 60 * 60;
                $rid = $db->insert("tbl_subscribers", $datar);
                $datar = NULL;
            }
            if ($serviced == "file") {
                $uid = $userid;
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency,credit_left FROM tblUsers\n             WHERE id='" . $uid . "'"));
                $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_file_credit where \n            service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days,service_name \n            FROM tbl_services_file where id='" . $sid . "'"));
                $table = "tbl_services_file";
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                $name = "File";
                addStatementuser($uid, "Subscription for Service : " . $serv["service_name"] . " ", "DR", $price, "", $name, 1);
                $email_merge_fields["type"] = $serv["service_name"];
                $email_merge_fields["subscription_start"] = date("d-m-Y");
                $end = time() + $serv["subscribe_days"] * 24 * 60 * 60;
                $email_merge_fields["subscription_end"] = date("d-m-Y", $end);
                $days = (int) ($end - time()) / 86400;
                $email_merge_fields["days"] = $days;
                sendMail(52, $uid, "", $email_merge_fields, true);
                $datar["user_id"] = $uid;
                $datar["type"] = "tbl_services_file";
                $datar["service_id"] = $sid;
                $datar["subscribe_start"] = time();
                $sub = mysqli_fetch_assoc(dquery("SELECT subscribe_days FROM tbl_services_file \n            WHERE id='" . $sid . "'"));
                $datar["subscribe_end"] = time() + $sub["subscribe_days"] * 24 * 60 * 60;
                $rid = $db->insert("tbl_subscribers", $datar);
                $datar = NULL;
            }
            if ($serviced == "server") {
                $uid = $userid;
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency,\n                        credit_left FROM tblUsers WHERE id='" . $uid . "'"));
                $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_server_credit where \n            service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days,service_name \n            FROM tbl_server_log where id='" . $sid . "'"));
                $table = "tbl_server_log";
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                $name = "Server";
                addStatementuser($uid, "Subscription for Service : " . $serv["service_name"] . " ", "DR", $price, "", $name, 1);
                $email_merge_fields["type"] = $serv["service_name"];
                $email_merge_fields["subscription_start"] = date("d-m-Y");
                $end = time() + $serv["subscribe_days"] * 24 * 60 * 60;
                $email_merge_fields["subscription_end"] = date("d-m-Y", $end);
                $days = (int) ($end - time()) / 86400;
                $email_merge_fields["days"] = $days;
                sendMail(52, $uid, "", $email_merge_fields, true);
                $datar["user_id"] = $uid;
                $datar["type"] = "tbl_server_log";
                $datar["service_id"] = $sid;
                $datar["subscribe_start"] = time();
                $sub = mysqli_fetch_assoc(dquery("SELECT subscribe_days FROM tbl_server_log \n            WHERE id='" . $sid . "'"));
                $datar["subscribe_end"] = time() + $sub["subscribe_days"] * 24 * 60 * 60;
                $rid = $db->insert("tbl_subscribers", $datar);
                $datar = NULL;
            }
        }
        if ($type == "Gift") {
            $sql = mysqli_fetch_assoc(dquery("select * from tbl_gift_coupon where id='" . $relid . "'"));
            $c = generateMyPromo();
            $d = enc($c, "9486");
            $uid = mysqli_fetch_assoc(dquery("select id,email,first_name,last_name from tblUsers \n                where id='" . $sql["uid"] . "'"));
            dquery("INSERT INTO `tbl_promotion`                 (`code` ,`amount` ,`used`, `currency` ,`vali_start`,`vali_end`,                `type`,`product`,`product_type`,`total`)                VALUES ( '" . $d . "','" . $sql["amount"] . "','1'," . $_SESSION["system_default_currency"]["id"] . ",'" . $from . "','" . $to . "','" . $type . "','" . $product . "','" . $ptype . "','" . $total . "')");
            $email_merge_fields["message"] = $sql["message"];
            $email_merge_fields["coupon"] = $c;
            $email_merge_fields["from"] = $uid["first_name"] . " " . $uid["last_name"];
            $email_merge_fields["amount"] = $sql["amount"] . " " . $_SESSION["system_default_currency"]["code"];
            $tomails = [["to" => $sql["to"]]];
            sendMail(71, $uid["id"], "", $email_merge_fields, false, "", "", "", $tomails, "", "", "", $uid["email"]);
            dquery("UPDATE tbl_gift_coupon set status='1' where id='" . $relid . "'");
        } else {
            if ($type == "Client Group") {
                if ($relid != "") {
                    $data7["client_group"] = $relid;
                }
                if ($relid != 0) {
                    dquery("DELETE from tbl_discount_imei where user_id='" . $userid . "'");
                    if (!$currency) {
                        $currency = $userdtl["default_currency"];
                    }
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n                    group_id='" . $relid . "' AND service_type='imei' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $userid;
                            $data2["service_id"] = $r["service_id"];
                            $db->insert("tbl_discount_imei", $data2);
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data7["imei_services"] = trim($imeiacc, ",");
                    dquery("DELETE from tbl_discount_file where user_id='" . $userid . "'");
                    $grp = dquery("SELECT * FROM tbl_client_group_price\n                     WHERE group_id='" . $relid . "' AND service_type='file' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $userid;
                            $data2["service_id"] = $r["service_id"];
                            $db->insert("tbl_discount_file", $data2);
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data7["file_services"] = trim($imeiacc, ",");
                    dquery("DELETE from tbl_discount_server_log where user_id='" . $userid . "'");
                    $grp = dquery("SELECT * FROM tbl_client_group_price WHERE \n                    group_id='" . $relid . "' AND service_type='server' AND currency_id='" . $currency . "'");
                    $imeiacc = "";
                    while ($r = mysqli_fetch_assoc($grp)) {
                        if ($r["discount"]) {
                            $data2["discount"] = $r["discount"];
                            $data2["user_id"] = $userid;
                            $data2["service_id"] = $r["service_id"];
                            $db->insert("tbl_discount_server_log", $data2);
                            $data2 = NULL;
                        }
                        $imeiacc .= $r["service_id"] . ",";
                    }
                    $data7["server_logs"] = trim($imeiacc, ",");
                    $data7["newserver_services"] = trim($imeiacc, ",");
                } else {
                    $data7["imei_service_access"] = 1;
                    $data7["file_service_access"] = 1;
                    $data7["server_log_access"] = 1;
                    $data7["imei_services"] = "ALL";
                    $data7["file_services"] = "ALL";
                    $data7["server_logs"] = "ALL";
                    $data7["newserver_services"] = "ALL";
                    dquery("DELETE FROM tbl_discount_imei where userid='" . $userid . "'");
                    dquery("DELETE FROM tbl_discount_file where userid='" . $userid . "'");
                    dquery("DELETE FROM tbl_discount_server_log where userid='" . $userid . "'");
                }
                $cgr = mysqli_fetch_assoc(dquery("select days,`type` from tbl_client_group\n                where id='" . $relid . "'"));
                $data7["group_start"] = date("Y-m-d");
                if ($cgr["type"] == 2) {
                    $data7["group_end"] = "";
                } else {
                    if ($cgr["type"] == 1) {
                        $data7["group_end"] = date("Y-m-d", strtotime("+1 months", time()));
                    } else {
                        $data7["group_end"] = date("Y-m-d", strtotime("+" . $cgr["days"] . " days", time()));
                    }
                }
                $db->update("tblUsers", $data7, "id='" . $userid . "'");
                $data7 = NULL;
            } else {
                if ($type == "AddFunds") {
                    dquery("UPDATE tblUsers SET credit_left=credit_left+'" . $amount . "' WHERE id='" . $userid . "'");
                    dquery("UPDATE tblUsers SET sell_credit_limit=sell_credit_limit+'" . $amount . "' WHERE id='" . $userid . "' and usertype='1'");
                    addStatementuser($userid, "+ Add Funds (invoice #P/" . $mask . ")", "CR", $amount, $invoiceid);
                    $trns = mysqli_fetch_assoc(dquery("select transid from tbl_transaction where invoiceid='" . $invoiceid . "'"));
                    $mailmerge["creditadded"] = $amount;
                    $mailmerge["transactionid"] = $trns["transid"];
                    $mailmerge = NULL;
                    sendMail(8, $userid, "", $mailmerge);
                    dquery("UPDATE tbl_invoiceitems SET used='1' WHERE invoiceid='" . $invoiceid . "'");
                    if ($config["rewardpoint"] && $config["addfundpoints"]) {
                        $clientgroup = $clientgroup ? $clientgroup : "base";
                        $Groupwise = json_decode($config["addfundpoints"], true);
                        if (0 < $Groupwise[$clientgroup][$currency]) {
                            $point = $Groupwise[$clientgroup][$currency];
                            $totalpoint = $amount * $point;
                            processPoints($userid, $totalpoint, 0, 0);
                        }
                    }
                    if ($userdtl["reseller_id"] && $userdtl["usertype"] == 3) {
                        dquery("UPDATE tblUsers SET credit_left=credit_left+'" . $amount . "' WHERE id='" . $userdtl["reseller_id"] . "'");
                        addStatementuser($userdtl["reseller_id"], "+ Add Funds by your User[" . $userdtl["username"] . "]", "CR", $amount, $invoiceid);
                    }
                } else {
                    if ($type == "IMEI") {
                        $query3 = "UPDATE `tbl_order_imei` SET `user_can_c`='0' WHERE `order_id`='" . $relid . "'";
                        full_query($query3);
                        if (!$used) {
                            $pro = mysqli_fetch_assoc(dquery("select \n                    (select stock_allow \n                    from tbl_services_imei where id=service_id) \n                    as allow,service_id\n                    from tbl_order_imei where order_id='" . $relid . "'"));
                            if ($pro["allow"]) {
                                dquery("update tbl_services_imei \n                        set stock=stock-1 where id='" . $pro["service_id"] . "'");
                            }
                            dquery("UPDATE tbl_invoiceitems SET\n                     used='1' WHERE invoiceid='" . $invoiceid . "'");
                        }
                        updateAffiliate($relid, "tbl_order_imei");
                        if ($data["promotion"]) {
                            $discor = ",discount='" . $data["promotion"] . "'";
                        } else {
                            $discor = "";
                        }
                        dquery("UPDATE tbl_order_imei set invoiceid='" . $invoiceid . "'\n                 " . $discor . " where order_id='" . $relid . "'");
                        $sql = dquery("select reseller_id,(select key_selling from \n                tbl_services_imei where id=service_id) as key_selling,reseller_discount,(select store \n                from tbl_services_imei where id=service_id) as stor\n                 from tbl_order_imei where order_id='" . $relid . "'");
                        if (mysqli_num_rows($sql)) {
                            $disc = mysqli_fetch_assoc($sql);
                            if ($disc["key_selling"]) {
                                include_once ROOTDIR . "/includes/keyselling.fun.php";
                                processKey($disc["key_selling"], $relid, "imei");
                            }
                            if ($disc["stor"]) {
                                $user = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $userid . "'"));
                                $resell = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $disc["reseller_id"] . "'"));
                                if ($user["default_currency"] != $resell["default_currency"]) {
                                    $disc["reseller_discount"] = round(convertCurrency($disc["reseller_discount"], $user["default_currency"], $resell["default_currency"]), $precision);
                                } else {
                                    $disc["reseller_discount"] = round($disc["reseller_discount"], $precision);
                                }
                                if (0 < $disc["reseller_discount"]) {
                                    $query3 = "UPDATE tblUsers SET credit_left=credit_left+" . $disc["reseller_discount"] . " WHERE id='" . $disc["reseller_id"] . "'";
                                    full_query($query3);
                                    addStatementuser($disc["reseller_id"], "Reseller Store Commision (invoice #" . $invoiceid . ")", "CR", $disc["reseller_discount"], $invoiceid);
                                    include_once ROOTDIR . "/includes/mail.fun.php";
                                    sendMail(59, $disc["reseller_id"], "", ["amount" => $disc["reseller_discount"]]);
                                }
                            }
                        }
                    } else {
                        if ($type == "Server") {
                            $query3 = "UPDATE `tbl_order_server` SET `user_can_c`='0' WHERE `order_id`='" . $relid . "'";
                            full_query($query3);
                            if (!$used) {
                                $pro = mysqli_fetch_assoc(dquery("select (select stock_allow \n                    from tbl_server_log where id=service_id) as allow,service_id\n                    from tbl_order_server where order_id='" . $relid . "'"));
                                if ($pro["allow"]) {
                                    dquery("update tbl_server_log set stock=stock-1 where id='" . $pro["service_id"] . "'");
                                }
                                dquery("UPDATE tbl_invoiceitems SET used='1' WHERE invoiceid='" . $invoiceid . "'");
                            }
                            updateAffiliate($relid, "tbl_order_server");
                            dquery("UPDATE tbl_order_server set invoiceid='" . $invoiceid . "' where order_id='" . $relid . "'");
                            $sql = dquery("select reseller_id,reseller_discount,(select store \n                from tbl_server_log where id=service_id) as stor\n                from tbl_order_server where order_id='" . $relid . "'");
                            if (mysqli_num_rows($sql)) {
                                $disc = mysqli_fetch_assoc($sql);
                                if ($disc["stor"]) {
                                    $user = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $userid . "'"));
                                    $resell = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $disc["reseller_id"] . "'"));
                                    if ($user["default_currency"] != $resell["default_currency"]) {
                                        $disc["reseller_discount"] = round(convertCurrency($disc["reseller_discount"], $user["default_currency"], $resell["default_currency"]), $precision);
                                    } else {
                                        $disc["reseller_discount"] = round($disc["reseller_discount"], $precision);
                                    }
                                    if (0 < $disc["reseller_discount"]) {
                                        $query3 = "UPDATE tblUsers SET credit_left=credit_left+" . $disc["reseller_discount"] . " WHERE id='" . $disc["reseller_id"] . "'";
                                        full_query($query3);
                                        addStatementuser($disc["reseller_id"], "Reseller Store Commision (invoice #" . $invoiceid . ")", "CR", $disc["reseller_discount"], $invoiceid);
                                        include_once ROOTDIR . "/includes/mail.fun.php";
                                        sendMail(59, $disc["reseller_id"], "", ["amount" => $disc["reseller_discount"]]);
                                    }
                                }
                            }
                        } else {
                            if ($type == "Product") {
                                $s = mysqli_fetch_assoc(dquery("select service_id,pos,\n                    (select key_selling from tbl_products where id=service_id) as ksell,\n                    (select draw from tbl_products where id=service_id) as dr,\n                     (select service_name from tbl_products where id=service_id) as itemname from tbl_order_product \n                    where order_id='" . $relid . "'"));
                                if ($s["dr"]) {
                                    $query3 = "UPDATE `tbl_order_product` SET `user_can_c`='8',`invoiceid`='" . $invoiceid . "' \n                        WHERE `order_id`='" . $relid . "'";
                                } else {
                                    if (!$s["pos"]) {
                                        $query3 = "UPDATE `tbl_order_product` SET `user_can_c`='0',`invoiceid`='" . $invoiceid . "'\n                            WHERE `order_id`='" . $relid . "'";
                                    }
                                }
                                full_query($query3);
                                $sql = dquery("select reseller_id,reseller_discount,(select store \n                from tbl_products where id=service_id) as stor\n                 from tbl_order_product where order_id='" . $relid . "'");
                                if (mysqli_num_rows($sql)) {
                                    $disc = mysqli_fetch_assoc($sql);
                                    if ($disc["stor"]) {
                                        $user = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $userid . "'"));
                                        $resell = mysqli_fetch_assoc(dquery("select default_currency from tblUsers where id='" . $disc["reseller_id"] . "'"));
                                        if ($user["default_currency"] != $resell["default_currency"]) {
                                            $disc["reseller_discount"] = round(convertCurrency($disc["reseller_discount"], $user["default_currency"], $resell["default_currency"]), $precision);
                                        } else {
                                            $disc["reseller_discount"] = round($disc["reseller_discount"], $precision);
                                        }
                                        if (0 < $disc["reseller_discount"]) {
                                            $query3 = "UPDATE tblUsers SET credit_left=credit_left+" . $disc["reseller_discount"] . " WHERE id='" . $disc["reseller_id"] . "'";
                                            full_query($query3);
                                            addStatementuser($disc["reseller_id"], "Reseller Store Commision (invoice #" . $invoiceid . ")", "CR", $disc["reseller_discount"], $invoiceid);
                                            include_once ROOTDIR . "/includes/mail.fun.php";
                                            sendMail(59, $disc["reseller_id"], "", ["amount" => $disc["reseller_discount"]]);
                                        }
                                    }
                                }
                                updateAffiliate($relid, "tbl_order_product");
                                if ($s["ksell"]) {
                                    include_once ROOTDIR . "/includes/keyselling.fun.php";
                                    processKey($s["ksell"], $relid, "product");
                                }
                                if ($config["slack_shopordernotification"]) {
                                    $_cols[0]["titel"] = $s["itemname"];
                                    $_cols[0]["text"] = "";
                                    $callwithout[100]["titel"] = "Invoice";
                                    $callwithout[100]["text"] = $invoiceid . " - PAID";
                                    SlackSendMsg($config["slack_shopordernotification"], " New Cart Order Placed #" . $invoiceid, "good", $_cols, false, "", $callwithout);
                                }
                                if (!$used) {
                                    $pro = mysqli_fetch_assoc(dquery("select (select stock_allow \n                    from tbl_products where id=service_id) as allow\n                   ,(select bundle from tbl_products where id=service_id) as bundle,\n                   (select bundle_list from tbl_products where id=service_id) as list,service_id\n                   from tbl_order_product where order_id='" . $relid . "'"));
                                    if ($pro["allow"]) {
                                        dquery("update tbl_products set stock=stock-1 where id='" . $pro["service_id"] . "'");
                                        if ($pro["bundle"]) {
                                            $bund = explode(",", $pro["list"]);
                                            foreach ($bund as $b) {
                                                dquery("update tbl_products set stock=stock-1 where id='" . $b . "'");
                                            }
                                        }
                                    }
                                    dquery("UPDATE tbl_invoiceitems SET used='1' WHERE invoiceid='" . $invoiceid . "'");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $date = date("Y:m:d H:i:s");
    $mask = mysqli_fetch_assoc(dquery("select mask from tbl_invoices\n    where status='Paid' order by mask desc limit 1"));
    $sql = mysqli_fetch_assoc(dquery("select username,(select code from tbl_currencies\nwhere id=default_currency) as code,first_name,last_name,email \n                            from tblUsers where id='" . $userid . "'"));
    $Tran = mysqli_fetch_assoc(dquery("select * from tbl_transaction\nwhere invoiceid='" . $invoiceid . "'"));
    if (!isset($_SESSION["adminid"]) && $config["slack_invoicepaid"]) {
        $_cols[0]["titel"] = $sql["username"];
        $_cols[0]["text"] = $amount . "" . $sql["code"];
        if ($Tran["id"]) {
            $_cols[1]["titel"] = $Tran["gateway"];
            $_cols[1]["text"] = $Tran["transid"];
        } else {
            if (0 < $credit) {
                $_cols[1]["titel"] = "Credit Balance";
                $_cols[1]["text"] = "N/A";
            }
        }
        $callwithout[100]["titel"] = "Items";
        $callwithout[100]["text"] = implode("\n", $invoiceitemsarr);
        SlackSendMsg($config["slack_invoicepaid"], "Auto Invoice Paid #" . $invoiceid, "good", $_cols, true, "", $callwithout);
    }
    update_query("tbl_invoices", ["status" => "Paid", "mask" => $mask["mask"] + 1, "datepaid" => $date], ["id" => $invoiceid]);
    logActivity("Invoice Paid - Invoice ID: " . $invoiceid);
    if ($sendemail) {
        include_once ROOTDIR . "/includes/mail.fun.php";
        $email_merge_fields["invoice"] = $invoiceid;
        $email_merge_fields["payment"] = $amount;
        sendMail(30, $userid, "", $email_merge_fields);
        $FullAmount = $amount;
        if (is_numeric($data["qnt"])) {
            $FullAmount = round($amount * $data["qnt"], $precision);
        }
        $adminmessage = "Payment Received For Invoice #I/" . $invoiceid . " <br />\n            User ID :" . $sql["username"] . "  #" . $userid . " <br />\n            User Detail :" . $sql["first_name"] . " " . $sql["last_name"] . " <br />\n             &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;" . $sql["email"] . " <br />\n            Invoice Amount # " . $FullAmount . " <br />\n            Invoice Status # Paid <br />\n            Payment Method # " . $paymentmethod . " <br /><br />\n            Invoice Items<br />\n            ";
        $it = dquery("select description from `tbl_invoiceitems` WHERE invoiceid='" . $invoiceid . "'");
        while ($r = mysqli_fetch_assoc($it)) {
            $adminmessage .= "        -" . $r["description"] . "<br />";
        }
        $here = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $invoiceid) . "&title=" . base64_encode("Edit Invoice #" . $invoiceid) . "'>here</a>";
        $adminmessage .= "<br /> <br />\n            You can view Invoice from " . $here . "\n            ";
        if (!$adminAddPayment) {
            sendNotification("account", "Payment Received For Invoice #" . $invoiceid, $adminmessage, "");
        }
        $adminmessage = NULL;
    }
    $adminAddPayment = false;
}
function updateAffiliate($oid, $type)
{
    if ($type == "tbl_order_imei") {
        $serv = "tbl_services_imei";
        $stype = "imei";
    } else {
        if ($type == "tbl_order_server") {
            $serv = "tbl_server_log";
            $stype = "server";
        } else {
            if ($type == "tbl_order_product") {
                $serv = "tbl_products";
                $stype = "product";
            } else {
                return false;
            }
        }
    }
    $aff = mysqli_fetch_assoc(dquery("select credit,discount,user_id,aid,\n\t(select affiliate_comission from " . $serv . " where id=service_id) \n\tas comission,\n   (select service_name from " . $serv . " where id=service_id) \n\tas servc\n\tfrom " . $type . " where order_id='" . $oid . "' and aid!='0'"));
    $amount = $aff["credit"] - $aff["discount"];
    if ($aff["aid"]) {
        $commision = round($amount * $aff["comission"] / 100, $precision);
        if ($commision) {
            $acur = mysqli_fetch_assoc(dquery("select default_currency,(select prefix from tbl_currencies where id=default_currency) as pre from tblUsers where id='" . $aff["aid"] . "'"));
            $ucur = mysqli_fetch_assoc(dquery("select default_currency,username from tblUsers where id='" . $aff["user_id"] . "'"));
            $commision = convertCurrency($commision, $ucur["default_currency"], $acur["default_currency"]);
            $amount = convertCurrency($amount, $ucur["default_currency"], $acur["default_currency"]);
            $date = date("Y-m-d");
            dquery("INSERT INTO tbl_affiliate_history \n\t\t\t(aid,uid,oid,amount,comission,type,date) values \n\t\t\t(" . $aff["aid"] . "," . $aff["user_id"] . "," . $oid . ",'" . $amount . "','" . $commision . "','" . $stype . "','" . $date . "')");
            dquery("update tblUsers set affiliate_balance=affiliate_balance+" . $commision . " where id='" . $aff["aid"] . "'");
            include_once ROOTDIR . "/includes/mail.fun.php";
            sendMail(61, $aff["aid"], "", ["commission" => $acur["pre"] . $commision, "product" => $aff["servc"], "username" => $ucur["username"]], true);
        }
    }
    return true;
}
function getTaxRate($level, $state = "", $country = "", $gateway = "")
{
    global $lng_languag;
    $result = select_query("tbl_tax", "", ["level" => $level, "state" => $state, "country" => $country, "gateway" => $gateway]);
    if ($result) {
        $data = mysqli_fetch_assoc($result);
    }
    $taxname = $data["name"];
    $taxrate = $data["taxrate"];
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => $state, "country" => $country, "gateway" => ""]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => "", "country" => $country, "gateway" => $gateway]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => "", "country" => $country, "gateway" => ""]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => "", "country" => "", "gateway" => $gateway]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => $state, "country" => "", "gateway" => ""]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => $state, "country" => "", "gateway" => $gateway]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => "", "country" => $country, "gateway" => ""]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $result = select_query("tbl_tax", "", ["level" => $level, "state" => "", "country" => "", "gateway" => ""]);
        if ($result) {
            $data = mysqli_fetch_assoc($result);
        }
        $taxname = $data["name"];
        $taxrate = $data["taxrate"];
    }
    if (!$taxrate) {
        $taxrate = 0;
    }
    if (!$taxname) {
        $taxname = $lng_languag["invoicestax"];
    }
    return ["name" => $taxname, "rate" => $taxrate];
}
function generateMyPromo($length = 12)
{
    $password = "";
    $possible = "2346789ABCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($maxlength < $length) {
        $length = $maxlength;
    }
    $i = 0;
    while ($i < $length) {
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;
}

?>