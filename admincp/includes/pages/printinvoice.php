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
echo "<link rel=\"stylesheet\" href=\"../css/x-main2.css\" />\n";
installadmin($pagetitle, $pageicon, $breadcrumbnav);
global $adminAddPayment;
$adminAddPayment = true;
if ($config["lowstockalert"]) {
    foreach ($_SESSION["SALES"] as $k => $s) {
        $sql = dquery("SELECT id,service_name,reorder_level,\n        reorder_notify,stock FROM tbl_products where stock<=reorder_level\n        and id='" . $k . "'");
        $today = time();
        while ($row = mysqli_fetch_assoc($sql)) {
            $remind = ($today - $row["reorder_notify"]) / 86400;
            if ($row["stock"] <= $row["reorder_level"] && $config["reorderlevel"] < $remind) {
                dquery("update tbl_products set reorder_notify='" . $today . "' where id='" . $row["id"] . "'");
                $pro = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editproduct&id=" . $row["id"]) . "&title=" . base64_encode("Edit Product") . "'>" . $row["service_name"] . "</a>";
                $buff .= " " . $pro . " - Current Stock : " . $row["stock"] . " <br />";
            }
        }
        if ($buff) {
            $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("catlog") . "&title=" . base64_encode("List Products") . "'>here</a>";
            $buff .= "<br /><br /> Click " . $here . " to view Product List";
            sendNotification("system", "[URGENT] Low quantity", $buff, "", (string) $config["config_admin_mail"]);
        }
    }
}
if (isset($_SESSION["SALES"]) && isset($_SESSION["CUSTOMER"])) {
    checkDemoMode(false);
    if (isset($_SESSION["STYPE"]) && $_SESSION["STYPE"] == 2) {
        $list = "";
        foreach ($_SESSION["SALES"] as $k => $s) {
            $sql = dquery("select (select service_name from tbl_products\n        where id=service_id)\n        as service from tbl_order_product \n        where service_id='" . $k . "' and user_id='" . $_SESSION["CUSTOMER"] . "'");
            if ($s["serial"]) {
                foreach ($s["serial"] as $sers) {
                    if ($sers) {
                        dquery("update `tbl_serial_list` set status='0',refund='1'\n                  where serial='" . $sers . "' and wid='" . $_SESSION["WAREHOUSE"] . "'\n                  limit 1");
                    }
                }
            }
            if (mysqli_num_rows($sql)) {
                if (mysqli_num_rows($sql) < $s["qnt"]) {
                    echo "<div id='notification1' class='errorbox'>Not enough Quantity</div>";
                    exit;
                }
                dquery("update tbl_order_product set user_can_c='3' where service_id='" . $k . "' and user_id='" . $_SESSION["CUSTOMER"] . "' AND pos='1'");
                dquery("update tbl_products set stock=stock+" . $s["qnt"] . "\n             where id='" . $k . "'");
                $ins["wid"] = $_SESSION["WAREHOUSE"];
                $ins["pid"] = $k;
                $ins["stockin"] = $s["qnt"];
                $db->insert("tbl_warehousestock", $ins);
                $ins = NULL;
                $ins["qnt"] = $s["qnt"];
                $ins["date"] = date("Y-m-d");
                $ins["time"] = time();
                $ins["pid"] = $k;
                $ins["wid"] = $_SESSION["WAREHOUSE"];
                $ins["aid"] = $_SESSION["adminid"];
                $ins["status"] = "IN";
                $db->insert("tbl_stock_history", $ins);
                $ins = NULL;
                $sql = mysqli_fetch_assoc($sql);
                $list = $list . $sql["service"] . "<br />";
                $prod = mysqli_fetch_assoc(dquery("select bundle,bundle_list \n            from tbl_products where id='" . $k . "'"));
                if ($prod["bundle"]) {
                    $ex = explode(",", $prod["bundle_list"]);
                    foreach ($ex as $e) {
                        dquery("update tbl_products set stock=stock+1\n                     where id='" . $e . "'");
                        $ins["wid"] = $_SESSION["WAREHOUSE"];
                        $ins["pid"] = $e;
                        $ins["stockin"] = 1;
                        $db->insert("tbl_warehousestock", $ins);
                        $ins = NULL;
                        $ins["qnt"] = 1;
                        $ins["date"] = date("Y-m-d");
                        $ins["time"] = time();
                        $ins["pid"] = $e;
                        $ins["wid"] = $_SESSION["WAREHOUSE"];
                        $ins["aid"] = $_SESSION["adminid"];
                        $ins["status"] = "IN";
                        $db->insert("tbl_stock_history", $ins);
                        $ins = NULL;
                    }
                }
            }
        }
        if ($list) {
            echo "<div id='notification1' class='successbox'>Order Rejected :<br />" . $list . "</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>No Order found</div>";
        }
        echo "    <script>\n window.opener.location.reload(true);\n    </script>\n";
    } else {
        $users = getClientsDetails($_SESSION["CUSTOMER"]);
        if ($users["currency"]["id"] != $_SESSION["system_default_currency"]["id"]) {
            foreach ($_SESSION["SALES"] as $k => $s) {
                $currencyid = $_ClientsDetails["currency"]["id"];
                $_SESSION["SALES"][$k]["price"] = convertCurrency($s["price"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                $_SESSION["SALES"][$k]["disc"] = convertCurrency($s["disc"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                $curid = $users["currency"]["id"];
                $_SESSION["AMOUNT"] = convertCurrency($_SESSION["AMOUNT"], $_SESSION["system_default_currency"]["id"], $users["currency"]["id"]);
                $data = mysqli_fetch_assoc(dquery("SELECT * FROM \n                `tbl_currencies` WHERE id='" . $curid . "'"));
                $_SESSION["currency"] = $data;
            }
        }
        $totaled = 0;
        foreach ($_SESSION["SALES"] as $k => $s) {
            $pro = mysqli_fetch_assoc(dquery("select purchase_cost,service_name,taxed \n    from tbl_products where id='" . $k . "'"));
            if ($s["serial"]) {
                $qc = 0;
                foreach ($s["serial"] as $sers) {
                    if ($sers) {
                        dquery("update `tbl_serial_list` set status='1'\n              where serial='" . $sers . "' and status='0'  limit 1");
                        $qc++;
                    }
                }
                if ($qc) {
                    $s["qnt"] = $qc;
                }
            }
            if (isset($_SESSION["SERIAL"][$k])) {
                $vals = $_SESSION["SERIAL"][$k];
                dquery("update `tbl_serial_list` set status='1'\n         where serial='" . $vals . "'");
            }
            if (isset($_SESSION["SERIAL"][$s["bundle"]])) {
                $vals = $_SESSION["SERIAL"][$s["bundle"]];
                dquery("update `tbl_serial_list` set status='1' where serial='" . $vals . "'");
            }
            $data = NULL;
            $data["note"] = $_SESSION["NOTES"];
            $data["service_id"] = $k;
            $data["purchase_cost"] = $pro["purchase_cost"];
            $data["user_id"] = $_SESSION["CUSTOMER"];
            $data["date"] = date("Y-m-d");
            $data["time"] = time();
            $data["reply_time"] = time();
            $data["reply_date"] = date("Y-m-d");
            $data["user_can_c"] = 4;
            $data["pass_key"] = md5(time() . $_SESSION["CUSTOMER"] . time());
            $data["credit"] = $s["price"];
            if ($_SESSION["DTYPE"]) {
                $disc = $s["price"] * $s["disc"] / 100;
            } else {
                $disc = $s["disc"];
            }
            $data["discount"] = $disc;
            $data["sh_email"] = $users["email"];
            $data["sh_contact"] = $users["phonenumber"];
            $data["sh_firstname"] = $users["firstname"];
            $data["sh_lastname"] = $users["lastname"];
            $data["sh_address1"] = $users["address1"];
            $data["sh_address2"] = $users["address2"];
            $data["sh_city"] = $users["city"];
            $data["sh_zip"] = $users["zip"];
            $data["sh_state"] = $users["state"];
            $data["sh_country"] = $users["country"];
            $data["pos"] = 1;
            $data["warehouse"] = $_SESSION["WAREHOUSE"];
            $date = date("Y-m-d");
            $data["ip"] = $_SERVER["REMOTE_ADDR"];
            $data["currency_id"] = $users["currency_id"];
            $oids = "";
            $ins["wid"] = $_SESSION["WAREHOUSE"];
            $ins["pid"] = $k;
            $ins["stockout"] = $s["qnt"];
            $db->insert("tbl_warehousestock", $ins);
            $ins = NULL;
            $ins["qnt"] = $s["qnt"];
            $ins["date"] = date("Y-m-d");
            $ins["time"] = time();
            $ins["pid"] = $k;
            $ins["wid"] = $_SESSION["WAREHOUSE"];
            $ins["aid"] = $_SESSION["adminid"];
            $ins["status"] = "OUT";
            $sth[] = $db->insert("tbl_stock_history", $ins);
            $ins = NULL;
            $m = 0;
            for ($i = 1; $i <= $s["qnt"]; $i++) {
                if ($s["serial"][$m]) {
                    $data["serial"] = $s["serial"][$m];
                } else {
                    $data["serial"] = "";
                }
                $order = $db->insert("tbl_order_product", $data);
                $ordarr[] = $order;
                $totaled = $totaled + $s["price"] - $disc;
                insert_query("tbl_invoiceitems", ["qnt" => "p_" . $k, "userid" => $_SESSION["CUSTOMER"], "type" => "Product", "serial" => $data["serial"], "relid" => $order, "shippingtax" => round($_SESSION["SHIP"], 2), "description" => $pro["service_name"], "amount" => $s["price"] - $disc, "taxed" => $pro["taxed"], "duedate" => "now()", "pos" => "1", "paymentmethod" => $_SESSION["GATEWAYS"], "bundleid" => $s["bundleid"], "warehouse" => $_SESSION["WAREHOUSE"]]);
                $_SESSION["SHIP"] = 0;
                $m++;
            }
        }
        $invoiceid = generateInvoice($_SESSION["CUSTOMER"], false);
        if (is_array($sth)) {
            foreach ($sth as $s) {
                if ($s) {
                    dquery("UPDATE tbl_stock_history set \n                relid='" . $invoiceid . "' where id='" . $s . "'");
                }
            }
        }
        if (is_array($ordarr)) {
            foreach ($ordarr as $o) {
                if ($o) {
                    dquery("UPDATE tbl_order_product set \n                invoiceid='" . $invoiceid . "' where order_id='" . $o . "'");
                }
            }
        }
        addPayment($invoiceid, "", $_SESSION["AMOUNT"], "", $_SESSION["GATEWAYS"]);
        update_query("tbl_invoices", ["paymentmethod" => $_SESSION["GATEWAYS"]], ["md5(id)" => md5($invoiceid), "userid" => $_SESSION["CUSTOMER"]]);
        if ($config["taxenabled"]) {
            $taxrate = getTaxRate(1, "", "", $_SESSION["GATEWAYS"]);
            $taxrate2 = getTaxRate(2, "", "", $_SESSION["GATEWAYS"]);
            $taxrate = $taxrate["rate"];
            $taxrate2 = $taxrate2["rate"];
            $tax = $totaled * $taxrate["rate"] / 100;
            $tax2 = $totaled * $taxrate2["rate"] / 100;
            $tax = round($tax, 2);
            $tax2 = round($tax2, 2);
            $sql = dquery("UPDATE tbl_invoices SET `taxrate`='" . $taxrate . "',\n       `taxrate2`='" . $taxrate2 . "'\n       WHERE  id='" . $invoiceid . "' AND userid='" . $_SESSION["CUSTOMER"] . "'");
            $sql = dquery("UPDATE tbl_invoices SET `tax`=" . $tax . ",`tax2`=" . $tax2 . "\n       WHERE  id='" . $invoiceid . "' AND userid='" . $_SESSION["CUSTOMER"] . "'");
            updateInvoiceTotal($invoiceid);
        }
        if ($gateway) {
            update_query("tbl_invoices", ["paymentmethod" => $_SESSION["GATEWAYS"]], ["id" => $invoiceid, "userid" => $_SESSION["CUSTOMER"]]);
        }
        require_once ROOTDIR . "/includes/gateway.fun.php";
        $gatewaysarray = getGatewaysArray();
        if ($_SESSION["adminid"]) {
            $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
        }
        updateInvoiceTotal($invoiceid);
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
        $result = dquery("select * from tbl_invoiceitems where \ninvoiceid='" . $invoiceid . "'\n GROUP BY qnt ORDER BY id ASC");
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
        echo "    <script>\n    window.opener.location.reload(true);\n    </script>\n    ";
    }
} else {
    echo "    <script>\n    alert('Please select products & customer to generate invoice');\n    window.close();\n    </script>\n    ";
}
$fileverioncheck = "6.1.0";

?>