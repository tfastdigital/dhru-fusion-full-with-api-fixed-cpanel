<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/invoice.fun.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
require "../../includes/admin.area.inc.php";
require "../../includes/fun.inc.php";
require ROOTDIR . "/includes/mail.fun.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
dquery("ALTER TABLE `tbl_serial_list` ADD `refund` INT(1)");
global $smarty;
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
require_once ROOTDIR . "/includes/gateway.fun.php";
require_once ROOTDIR . "/includes/products.fun.php";
$gatewaysarray = getGatewaysArray();
echo "\n<link rel=\"stylesheet\" href=\"../css/x-main2.css\" />\n\n";
installadmin($pagetitle, $pageicon, $breadcrumbnav);
global $adminAddPayment;
$adminAddPayment = true;
if ($_SESSION["adminid"]) {
    $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
}
$data = mysqli_fetch_assoc($result);
$_SESSION["uid"] = $data["userid"];
installadmin($pagetitle, $pageicon, $breadcrumbnav);
$_ClientsDetails = getClientsDetails($data["userid"]);
$smarty->assign("userdetails", $_ClientsDetails);
$id = $data["id"];
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$date = $data["date"];
$duedate = $data["duedate"];
$subtotal = $data["subtotal"];
$credit = $data["credit"];
if ($config["taxenabled"]) {
    $tax = $data["tax"];
    $tax2 = $data["tax2"];
    $taxrate = $data["taxrate"];
    $taxrate2 = $data["taxrate2"];
} else {
    $taxrate = "0.00";
    $taxrate2 = "0.00";
}
$shippingtax = $data["shippingtax"];
$total = $data["total"];
$tdisc = $data["posdiscount"];
$status = $data["status"];
$promotion = $data["promotion"];
$paymentmethod = $data["paymentmethod"];
$paymentmethod2 = $gatewaysarray[$paymentmethod];
$notes = $data["notes"];
$datepaid = $data["datepaid"];
$rawduedate = $duedate;
$date = formatDate($date);
$datepaid = formatDate($datepaid, "time");
$duedate = formatDate($duedate);
$result = select_query("tbl_transaction", "SUM(amountin)-SUM(amountout)", ["invoiceid" => $invoiceid]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data[0];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
if (!$invoicenum) {
    $invoicenum = $id;
}
if (!$invoiceid) {
    $tempalte_ver["notification"]["error"] = "Error #65984521";
}
if ($status == "Unpaid" && $paymentmethod && 0 < $balance) {
    $params = loadGatewayModule($paymentmethod, $id, $balance);
    $paymentbutton = call_user_func($paymentmethod . "_link", $params);
}
$smarty->assign("companyname", $config["companyname"]);
$smarty->assign("pagetitle", $LNG["invoicenumber"] . $invoicenum);
$smarty->assign("invoiceid", $invoiceid);
$smarty->assign("invoiceidmd5", md5($invoiceid));
$smarty->assign("invoicenum", $invoicenum);
$smarty->assign("payto", nl2br($config["invoicepayto"]));
$smarty->assign("datecreated", $date);
$smarty->assign("promotion", $promotion != 0 ? formatCurrency($promotion) : "");
$smarty->assign("datedue", $duedate);
$smarty->assign("subtotal", formatCurrency($subtotal));
$smarty->assign("credit", formatCurrency($credit));
if ($taxrate != "0.00") {
    $taxname = getTaxRate(1, $_ClientsDetails["state"], $_ClientsDetails["country"], $paymentmethod);
    $smarty->assign("taxname", $taxname["name"]);
    $smarty->assign("taxrate", $taxrate);
}
if ($taxrate2 != "0.00") {
    $taxname = getTaxRate(2, $_ClientsDetails["state"], $_ClientsDetails["country"], $paymentmethod);
    $smarty->assign("taxname2", $taxname["name"]);
    $smarty->assign("taxrate2", $taxrate2);
}
$smarty->assign("tax", formatCurrency($tax));
$smarty->assign("tax2", formatCurrency($tax2));
$smarty->assign("shippingcharge", formatCurrency($shippingtax));
$smarty->assign("t1", $tax);
$smarty->assign("t2", $tax2);
$smarty->assign("s", $shippingtax);
$smarty->assign("c", $credit);
$smarty->assign("shippingname", $LNG["shippingcharge"]);
$smarty->assign("total", formatCurrency($total));
$smarty->assign("balance", formatCurrency($balance));
$smarty->assign("status", $status);
$smarty->assign("datepaid", $datepaid);
$smarty->assign("paymentmethod", $paymentmethod2);
$smarty->assign("paymentbutton", $paymentbutton);
$smarty->assign("offlinepaid", $offlinepaid);
$smarty->assign("notes", nl2br($notes));
$smarty->assign("taxtype", $config["taxtype"]);
$result = select_query("tbl_invoices", "SUM(total)", ["userid" => $userid, "status" => "Unpaid"]);
$data = mysqli_fetch_assoc($result);
$alldueinvoices = $data[0];
$smarty->assign("previousbalance", $alldueinvoices - $total);
$smarty->assign("alldueinvoices", $alldueinvoices);
$result = select_query("tbl_transaction", "amountin", ["userid" => $userid], "id", "DESC");
$data = mysqli_fetch_assoc($result);
$lastpaymentamount = $data[0];
$smarty->assign("lastpaymentamount", $lastpaymentamount);
$disabledgateways = [];
$disabledgateways = array_unique($disabledgateways);
$gatewaydropdown = "<select name=\"gateway\" onchange=\"submit()\">";
$result = select_query("tbl_paymentgateways", "", ["setting" => "name"], "order", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $gateway = $data["gateway"];
    $result2 = select_query("tbl_paymentgateways", "", ["setting" => "visible", "value" => "1", "gateway" => $gateway]);
    $data2 = mysqli_fetch_assoc($result2);
    $gwid = $data2["gateway"];
    $skip_gateway = false;
    if (in_array($gwid, $disabledgateways)) {
        $skip_gateway = true;
    }
    if ($gateway == $paymentmethod) {
        $gwid = 1;
        $skip_gateway = false;
    }
    if ($gwid && !$skip_gateway) {
        $result2 = select_query("tbl_paymentgateways", "", ["setting" => "name", "gateway" => $gateway]);
        $data2 = mysqli_fetch_assoc($result2);
        $value = $data2["value"];
        $gatewaydropdown .= "<option value=\"" . $gateway . "\"";
        if ($gateway == $paymentmethod) {
            $gatewaydropdown .= " selected=\"selected\"";
        }
        $gatewaydropdown .= ">" . $value . "</option>";
    }
}
$gatewaydropdown .= "</select>";
$smarty->assign("allowchangegateway", $config["can_change_invoice_gateway"]);
$smarty->assign("gatewaydropdown", $gatewaydropdown);
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
$invoiceitems = [];
$result = dquery("select * from tbl_invoiceitems where \n\ninvoiceid='" . $invoiceid . "'\n\n GROUP BY qnt ORDER BY id ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $taxed = false;
    if ($data["taxed"]) {
        $taxed = true;
    }
    if ($data["type"] == "Product") {
        $sql = mysqli_fetch_assoc(dquery("select service_id from tbl_order_product where order_id='" . $data["relid"] . "'"));
        $customfields = getCustomFields("product", $sql["service_id"], $data["relid"], "", "", "", true, $_ClientsDetails["currency"]);
        $freeship = mysqli_fetch_assoc(dquery("select freeship from tbl_products where id='" . $sql["service_id"] . "'"));
        $cnt = mysqli_num_rows(dquery("select * from tbl_invoiceitems where invoiceid='" . $data["invoiceid"] . "' and qnt='" . $data["qnt"] . "'"));
    } else {
        $customfields = NULL;
    }
    $invoiceitems[] = ["id" => $data["id"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br(html_entity_decode($data["description"])), "freeship" => $freeship["freeship"], "unitprice" => formatCurrency($data["amount"]), "amount" => formatCurrency($data["amount"] * $cnt), "taxed" => $taxed, "customfields" => $customfields, "qnt" => $cnt, "serial" => $data["serial"]];
    if ($data["type"] == "AddFunds" || $data["type"] == "AddFunds by Admin") {
        $desable_add_credit = true;
    }
    $promocode = $data["promotion_code"];
}
$smarty->assign("invoiceitems", $invoiceitems);
$smarty->assign("promotion_code", $promocode);
$transactions = [];
$result = select_query("tbl_transaction", "", ["invoiceid" => $invoiceid], "date` ASC,`id", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $date = $data["date"];
    $date = formatDate($date);
    $gateway = $data["gateway"];
    $description = $data["description"];
    $amountin = $data["amountin"];
    $fees = $data["fees"];
    $amountout = $data["amountout"];
    $transid = $data["transid"];
    $invoiceid = $data["invoiceid"];
    $gateway = $gatewaysarray[$gateway];
    if (!$gateway) {
        $gateway = "-";
    }
    $transactions[] = ["date" => $date, "gateway" => $gateway, "transid" => $transid, "amount" => formatCurrency($amountin - $amountout)];
}
$smarty->assign("transactions", $transactions);
$smarty->assign("sitepath", $config["site_address"]);
$smarty->assign("invoicenum", $invoiceid);
if ($action == 1) {
    $action = "invoice";
} else {
    if ($action == 2) {
        $action = "landscape";
    } else {
        $action = "billing";
    }
}
if ($print == 1) {
    $smarty->assign("print", true);
}
echo AdminAreaProcessTemplate($action);
$data = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1' "));
$_SESSION["currency"] = $data;
echo "\n<script>\n\nwindow.opener.location.reload(true);\n\n</script>";
$fileverioncheck = "6.1.0";

?>