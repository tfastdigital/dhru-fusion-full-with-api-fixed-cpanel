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
$invid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $invid);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$gateway = preg_replace("/[^0-9a-z-]/i", "", $gateway);
global $smarty;
if ($gateway) {
    update_query("tbl_invoices", ["paymentmethod" => $gateway], ["md5(id)" => $id, "userid" => $_SESSION["uid"]]);
}
require ROOTDIR . "/includes/gateway.fun.php";
$gatewaysarray = getGatewaysArray();
if ($_SESSION["adminid"]) {
    $result = select_query("tbl_invoices", "", ["id" => $id]);
}
$data = mysqli_fetch_assoc($result);
$data["time"] = date("h:i A", $data["time"]);
if ($data["status"] == "Paid") {
    $mask = "I/" . $data["mask"];
} else {
    $mask = "P/" . $data["mask"];
}
$_SESSION["uid"] = $data["userid"];
installadmin($pagetitle, $pageicon, $breadcrumbnav);
$smarty->assign("invoicedata", $data);
$_ClientsDetails = getClientsDetails($data["userid"]);
$smarty->assign("userdetails", $_ClientsDetails);
$id = $data["id"];
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$Order = mysqli_fetch_assoc(dquery("select * from tbl_order_product where invoiceid='" . $id . "'"));
$smarty->assign("order", $Order);
$q = dquery("select service_id,group_concat(order_id) as ids,\n(select service_name from tbl_products where id=service_id) as service,\n(select sku from tbl_products where id=service_id) as sku,\ncredit from tbl_order_product where invoiceid='" . $id . "' group by service_id");
$Itemarr = [];
$i = 0;
$totalqnt = 0;
while ($r = mysqli_fetch_assoc($q)) {
    $or = explode(",", $r["ids"]);
    $Custom = getCustomFields("product", $r["service_id"], $or[0]);
    $qnt = mysqli_num_rows(dquery("select order_id from tbl_order_product\nwhere service_id='" . $r["service_id"] . "' and invoiceid='" . $id . "'"));
    $totalqnt += $qnt;
    $Itemarr[$i]["custom"] = $Custom;
    $Itemarr[$i]["service"] = $r["service"];
    $Itemarr[$i]["sku"] = $r["sku"];
    $Itemarr[$i]["qty"] = $qnt;
}
$smarty->assign("totalqnt", $totalqnt);
$smarty->assign("items", $Itemarr);
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
$result = select_query("tbl_transaction", "SUM(amountin)-SUM(amountout)", ["invoiceid" => $id]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data[0];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
if (!$invoicenum) {
    $invoicenum = $id;
}
if (!$id) {
    $tempalte_ver["notification"]["error"] = "Error #65984521";
}
if ($status == "Unpaid" && $paymentmethod && 0 < $balance) {
    $params = loadGatewayModule($paymentmethod, $id, $balance);
}
$smarty->assign("companyname", $config["companyname"]);
$smarty->assign("pagetitle", $LNG["invoicenumber"] . $invoicenum);
$smarty->assign("invoiceid", $id);
$smarty->assign("invoiceidmd5", md5($id));
$smarty->assign("invoicemask", $mask);
$smarty->assign("packingdate", date("d M Y"));
$smarty->assign("invoicenum", $invoicenum);
$smarty->assign("payto", nl2br($config["invoicepayto"]));
$smarty->assign("datecreated", $date);
$smarty->assign("contactemail", $config["contactusdisplayemail"]);
$smarty->assign("contactphone", $config["contactusphone"]);
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
$smarty->assign("allowchangegateway", false);
$smarty->assign("gatewaydropdown", $gatewaydropdown);
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
$invoiceitems = [];
$result = dquery("select * from tbl_invoiceitems where invoiceid='" . $id . "' GROUP BY qnt ORDER BY id ASC");
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
    $invoiceitems[] = ["id" => $data["id"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br(html_entity_decode($data["description"])), "freeship" => $freeship["freeship"], "unitprice" => formatCurrency($data["amount"]), "amount" => formatCurrency($data["amount"] * $cnt), "taxed" => $taxed, "customfields" => $customfields, "qnt" => $cnt];
    if ($data["type"] == "AddFunds" || $data["type"] == "AddFunds by Admin") {
        $desable_add_credit = true;
    }
    $desable_add_credit = true;
    $promocode = $data["promotion_code"];
}
$smarty->assign("invoiceitems", $invoiceitems);
$smarty->assign("promotion_code", $promocode);
if ($_ClientsDetails["credit"]["credit"] != "0.00" && $status == "Unpaid" && !$desable_add_credit) {
    if ($applycredit) {
        $totalcredit = $_ClientsDetails["credit"]["credit"];
        if ($totalcredit < $creditamount || $creditamount < 0) {
            echo $LNG["cannotapplycredit"];
            exit;
        }
        if ($balance < $creditamount) {
            echo $LNG["cannotapplycredit"];
            exit;
        }
        if (!function_exists(applyCredit)) {
            include "includes/invoice.fun.php";
        }
        applyCredit($id, $userid, $creditamount);
        header("Location: viewinvoice.php?id=" . md5($id));
        exit;
    }
    $smarty->assign("applycredit", true);
    $smarty->assign("totalcredit", formatCurrency($_ClientsDetails["credit"]["credit"]));
    if (!$creditamount) {
        if ($_ClientsDetails["credit"]["credit"] <= $balance) {
            $creditamount = $_ClientsDetails["credit"]["credit"];
        } else {
            $creditamount = $balance;
        }
    }
    $smarty->assign("creditamount", $creditamount);
}
$transactions = [];
$result = select_query("tbl_transaction", "", ["invoiceid" => $id], "date` ASC,`id", "ASC");
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
if ($_SESSION["adminid"] && !$_SESSION["uid"]) {
    unset($_SESSION["uid"]);
}
$smarty->assign("sitepath", $config["site_address"]);
echo AdminAreaProcessTemplate("packingslip");
$fileverioncheck = "6.1.0";

?>