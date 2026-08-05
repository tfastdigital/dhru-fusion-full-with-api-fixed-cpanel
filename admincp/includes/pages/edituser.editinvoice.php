<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 164;
checkPagePermission($pageid);
global $adminAddPayment;
$adminAddPayment = true;
require ROOTDIR . "/includes/invoice.fun.php";
require_once ROOTDIR . "/includes/gateway.fun.php";
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices` WHERE `id`='" . $id . "' "));
if ($cancelrefund || $verifytrans) {
    $tranaction = mysqli_fetch_assoc(dquery("select * from tbl_transaction\nwhere invoiceid='" . $id . "'"));
    $GATEWAY = loadGatewayModule("paypalexpress");
    $_client_id = $GATEWAY["clientid"];
    $_secret = $GATEWAY["secretkey"];
    if ($GATEWAY["testmode"]) {
        $_url = "https://api.sandbox.paypal.com";
    } else {
        $_url = "https://api.paypal.com";
    }
    $post = [];
    $post = ["note_to_payer" => $refundnotes . " Invoice #" . $id];
    $_token = base64_encode($_client_id . ":" . $_secret);
    $_token = base64_encode($_client_id . ":" . $_secret);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_url . "/v2/checkout/orders/" . $invoice_info["exorderid"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = ["Content-Type: application/json"];
    curl_setopt($ch, CURLOPT_USERPWD, $_client_id . ":" . $_secret);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $orderdetail = json_decode($server_output, true);
    if ($orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "COMPLETED" || $orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "CREATED") {
        $payment_status = "AUTHORIZED";
    }
    if ($orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "VOIDED") {
        $payment_status = "VOID";
    }
    if ($orderdetail["purchase_units"][0]["payments"]["captures"][0]["status"] === "COMPLETED") {
        $payment_status = "PAID";
    }
    if ($orderdetail["purchase_units"][0]["payments"]["refunds"][0]["status"] === "COMPLETED") {
        $payment_status = "REFUNDED";
    }
}
if ($cancelrefund) {
    if ($payment_status == "AUTHORIZED") {
        $paypal_capture_id = $orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["id"];
        $action = $_url . "/v2/payments/authorizations/" . $paypal_capture_id . "/void";
    } else {
        if ($payment_status == "PAID") {
            $paypal_capture_id = $orderdetail["purchase_units"][0]["payments"]["captures"][0]["id"];
            $action = $_url . "/v2/payments/captures/" . $paypal_capture_id . "/refund";
        }
    }
    if ($orderdetail["id"]) {
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => $action, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_HEADER => 1, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => json_encode($post), CURLOPT_HTTPHEADER => ["Authorization: Basic " . $_token, "Content-Type: application/json", "PayPal-Request-Id: " . uuid()]]);
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $data = json_decode($response, true);
        if ($httpcode === 204 || $httpcode === 200) {
            $refundid = $data["id"];
            $data = NULL;
            $data = $tranaction;
            unset($data["id"]);
            $data["amountout"] = $tranaction["amountin"];
            $data["amountin"] = 0;
            $data["transid"] = $refundid ? $refundid : $tranaction["transid"];
            $data["refundid"] = $tranaction["id"];
            $data["note"] = $refundnotes . " Invoice #" . $id;
            $db->insert("tbl_transaction", $data);
            $data = NULL;
            dquery("update tbl_invoices set status='Cancel' where id='" . $id . "'");
            $refid = $data["id"];
            echo "<div id='notification1' class='successbox'>Invoice cancelled and refunded</div>";
        } else {
            echo "<div id='notification1' class='errorbox'>Error in refund and cancel " . $data["message"] . "</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Error in get order details</div>";
    }
}
if ($verifytrans) {
    $_success = true;
    $InvItems = mysqli_fetch_assoc(dquery("select group_concat(relid) as refid from tbl_invoiceitems where invoiceid='" . $id . "'"));
    if ($orderdetail["intent"] == "AUTHORIZE" && $orderdetail["purchase_units"][0]["payments"]["captures"][0]["status"] != "COMPLETED") {
        $_success = false;
        $paypal_authorization_id = $orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["id"];
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => $_url . "/v2/payments/authorizations/" . $paypal_authorization_id . "/capture", CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => json_encode($post), CURLOPT_HTTPHEADER => ["Authorization: Basic " . $_token, "Content-Type: application/json", "PayPal-Client-Metadata-Id: " . md5($id), "PayPal-Request-Id: " . uuid()]]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        $_cap_tx_id = $data["id"];
        if ($data["status"] == "COMPLETED") {
            $_success = true;
            $TRA["amountout"] = 0;
            $TRA["amountin"] = 0;
            $TRA["transid"] = $_cap_tx_id;
            $TRA["refundid"] = "";
            $TRA["note"] = "Captured";
            $TRA["invoiceid"] = $id;
            $TRA["gateway"] = $invoice_info["paymentmethod"];
            $TRA["date"] = date("Y-m-d h:i:s");
            $db->insert("tbl_transaction", $TRA);
        } else {
            echo "<div id='notification1' class='errorbox'>Capture transaction failed " . $data["message"] . "</div>";
        }
    }
    if ($_success) {
        processInvoicetoPaid($invoiceid);
        echo "<div id='notification1' class='successbox'>Invoice Paid</div>";
    }
    if ($kyc && $_success) {
        $tranaction = mysqli_fetch_assoc(dquery("select * from tbl_transaction\nwhere invoiceid='" . $id . "'"));
        if ($tranaction["gateway"] == "paypalexpress") {
            $ClientData = mysqli_fetch_assoc(dquery("select `data`,`paypalaccount` from tblUsers\nwhere id='" . $tranaction["userid"] . "'"));
            $ClientUpdate = "";
            $ClientPaypalAc = $ClientData["paypalaccount"];
            if ($ClientPaypalAc) {
                $ClientPaypalAc = json_decode($ClientPaypalAc, true);
            } else {
                $ClientPaypalAc = [];
            }
            if ($ClientData["data"]) {
                $ClientUpdate = json_decode($ClientData["data"], true);
            }
            if ($tranaction["note"]) {
                $ClientUpdate["payer"] = json_decode($tranaction["note"], true);
            }
            $ClientPaypalAc[] = $ClientUpdate["payer"]["email_address"];
            $ClientPaypalAc = array_unique($ClientPaypalAc);
            $ClientPaypalAc = json_encode($ClientPaypalAc);
            $ClientUpdate = json_encode($ClientUpdate);
            dquery("update tblUsers set idverification='1',`paypalaccount`='" . $ClientPaypalAc . "',`data`='" . $ClientUpdate . "' where id='" . $tranaction["userid"] . "'");
            dquery("update tbl_document set status='1' where uid='" . $tranaction["userid"] . "'");
        }
        echo "<div id='notification1' class='successbox'>KYC verified and Payer email allowed for next transaction</div>";
    }
}
if ($removetra) {
    dquery("DELETE FROM tbl_transaction where id='" . $removetra . "'");
    $tq = mysqli_fetch_assoc(dquery("select sum(amountin) as paid from tbl_transaction\nwhere invoiceid='" . $id . "'"));
    $invs = mysqli_fetch_assoc(dquery("select total from tbl_invoices\nwhere id='" . $id . "'"));
    if ($invs["total"] <= $tq["paid"]) {
        dquery("UPDATE tbl_invoices set status='Paid' where id='" . $id . "'");
    } else {
        dquery("UPDATE tbl_invoices set status='Unpaid' where id='" . $id . "'");
    }
    echo "    <div id=\"notification1\" class=\"successbox\" >";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["remove"];
    echo " ";
    echo $LNG["successfully"];
    echo "</div>\n    ";
}
if ($delete && $invoiceid && $ids) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    foreach ($ids as $e) {
        dquery("delete from tbl_invoiceitems where id='" . $e . "'");
    }
    updateInvoiceTotal($invoiceid);
}
if ($split && $invoiceid && $ids) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    foreach ($ids as $e) {
        $arrs = NULL;
        $arrs = mysqli_fetch_assoc(dquery("select * from  tbl_invoiceitems where id='" . $e . "'"));
        $arrs["invoiceid"] = NULL;
        $arrs["id"] = NULL;
        $db->insert("tbl_invoiceitems", $arrs);
        dquery("delete from tbl_invoiceitems where id='" . $e . "'");
    }
    $invid = generateInvoice($_SESSION["uid"]);
    updateInvoiceTotal($invoiceid);
    echo "    <script>\n        redirectedit('edituser.editinvoice','";
    echo $invid;
    echo "');\n    </script>\n    ";
}
$vars = "";
$flagii = false;
if (!$amount && $addpayment) {
    echo "<div id='notification1' class='errorbox'>" . $LNG["amount"] . " " . $LNG["must"] . " " . $LNG["required"] . "</div>";
} else {
    if ($addpayment) {
        checkDemoMode(false);
        $pageid = 523;
        checkPagePermission($pageid);
        $transId = trim($transId);
        global $adminAddPayment;
        $adminAddPayment = true;
        if (!$gateway) {
            echo "<div id='notification1' class='errorbox'>" . $LNG["gateway"] . " " . $LNG["must"] . " " . $LNG["required"] . "</div>";
        } else {
            if (!$transId) {
                echo "<div id='notification1' class='errorbox'>" . $LNG["invoicestransid"] . " " . $LNG["must"] . " " . $LNG["required"] . "</div>";
            } else {
                if ($amount <= $applied) {
                    if (!mysqli_num_rows(dquery("select * from tbl_transaction\n       where  transid='" . $transId . "'")) || $transId == "") {
                        $allowed = true;
                        $error = "";
                        if ($autovalidate) {
                            $allowed = false;
                            $_apiusername = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apiusername' and gateway='" . $gateway . "' "));
                            $_apiusername = $_apiusername["value"];
                            $_apipassword = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apipassword' and gateway='" . $gateway . "'"));
                            $_apipassword = $_apipassword["value"];
                            $_apisignature = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apisignature' and gateway='" . $gateway . "'"));
                            $_apisignature = $_apisignature["value"];
                            $paypalaccount = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='payto' and gateway='" . $gateway . "'"));
                            $paypalaccount = $paypalaccount["value"];
                            if (!$paypalaccount) {
                                $paypalaccount = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='email' and gateway='" . $gateway . "'"));
                                $paypalaccount = $paypalaccount["value"];
                            }
                            $User = mysqli_fetch_assoc(dquery("select (\n select  (select code from tbl_currencies where id=default_currency)  from tblUsers where id=userid) as code from tbl_invoices where id=" . $id));
                            $USERCURRENCYCODE = $User["code"];
                            $convertto = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='convertto' and gateway='" . $gateway . "'"));
                            $convertto = $convertto["value"];
                            $currencycode = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies`\n         WHERE `id` = '" . $convertto . "'"));
                            $currencycode = $currencycode["code"];
                            $url = "https://api-3t.paypal.com/nvp";
                            $postfields = [];
                            $postfields["VERSION"] = "3.0";
                            $postfields["METHOD"] = "GetTransactionDetails";
                            $postfields["USER"] = trim($_apiusername);
                            $postfields["PWD"] = trim($_apipassword);
                            $postfields["SIGNATURE"] = trim($_apisignature);
                            $postfields["TransactionID"] = trim($transactionid);
                            $result = inCurl11($url, $postfields);
                            $resultsarray2 = explode("&", $result);
                            $resultsarray = [];
                            foreach ($resultsarray2 as $line) {
                                $line = explode("=", $line);
                                $resultsarray[$line[0]] = urldecode(trim($line[1]));
                            }
                            if (strtoupper($resultsarray["ACK"]) == "SUCCESS") {
                                if ($resultsarray["PAYMENTSTATUS"] == "Completed" && stripos($resultsarray["PAYERSTATUS"], "verified") !== false) {
                                    if ($resultsarray["TRANSACTIONID"] != $transactionid) {
                                        $postfields["TRANSACTIONID"] = $resultsarray["TRANSACTIONID"];
                                        $result = inCurl11($url, $postfields);
                                        $resultsarray2 = explode("&", $result);
                                        foreach ($resultsarray2 as $line) {
                                            $line = explode("=", $line);
                                            $resultsarray[$line[0]] = urldecode($line[1]);
                                        }
                                    }
                                    if ($resultsarray["AMT"] == $amount) {
                                        if ($resultsarray["RECEIVERBUSINESS"] == $paypalaccount) {
                                            if ($resultsarray["CURRENCYCODE"] == $USERCURRENCYCODE) {
                                                $allowed = true;
                                            } else {
                                                $allowed = false;
                                            }
                                        } else {
                                            $allowed = false;
                                        }
                                    } else {
                                        $allowed = false;
                                        $error = "Amount not match with your entered amount";
                                    }
                                } else {
                                    $error = "Payer status not verified";
                                }
                            } else {
                                $error = "Failed to fetch this transaction id";
                            }
                        }
                        global $adminAddPayment;
                        $adminAddPayment = true;
                        if ($allowed) {
                            if ($customfield) {
                                saveCustomFields($invoiceid, $customfield);
                            }
                            addPayment($invoiceid, $transId, $amount, $fees, $gateway, $sendmail, $date);
                            $vars = "<div id='notification1' class='successbox'>" . $LNG["add"] . " " . $LNG["payment"] . " " . $LNG["successfully"] . "</div>";
                        } else {
                            $vars = "<div id='notification1' class='errorbox'>" . $error . "</div>";
                        }
                    } else {
                        $vars = "<div id='notification1' class='errorbox'>" . $LNG["transaction"] . " " . $LNG["id"] . " " . $LNG["already"] . " " . $LNG["used"] . "</div>";
                    }
                } else {
                    $vars = "<div id='notification1' class='errorbox'>" . $LNG["youcantpaymore"] . "</div>";
                }
            }
        }
    }
}
if ($processorder && $invoiceid) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    processInvoicetoPaid($invoiceid);
}
if ($setcancel && $invoiceid) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    dquery("update tbl_invoices set status='Cancel' where id='" . $invoiceid . "'");
    $vars = "<div id='notification1' class='successbox'>" . $LNG["status"] . " " . $LNG["changed"] . " " . $LNG["successfully"] . "</div>";
}
if ($setstats && $invoiceid) {
    $pageid = 523;
    checkPagePermission($pageid);
    checkDemoMode(false);
    dquery("update tbl_invoices set status=IF(status='Paid','Unpaid','Paid')\n    where id='" . $invoiceid . "'");
    $st = mysqli_fetch_assoc(dquery("select status from tbl_invoices\n    where id='" . $invoiceid . "'"));
    $paiddate = date("Y:m:d H:i:s");
    if ($st["status"] == "Paid") {
        $cur = "Unpaid to Paid";
        $mask = mysqli_fetch_assoc(dquery("select mask from tbl_invoices\n         where status='Paid' order by mask desc limit 1"));
        dquery("update tbl_invoices set mask='" . $mask["mask"] . "'+1,datepaid='" . $paiddate . "'\n         where id='" . $invoiceid . "'");
    } else {
        $cur = "Paid to Unpaid";
        $mask = mysqli_fetch_assoc(dquery("select mask from tbl_invoices\n         where status='Unpaid' order by mask desc limit 1"));
        dquery("update tbl_invoices set mask='" . $mask["mask"] . "'+1\n         where id='" . $invoiceid . "'");
    }
    if ($config["slack_directinvoicestatus"]) {
        $_cols[0]["titel"] = "INV #" . $invoiceid;
        $_cols[0]["text"] = $st["status"];
        SlackSendMsg($config["slack_directinvoicestatus"], "Direct Invoice Status Change", "danger", $_cols, true);
    }
    logActivity("Invoice[#" . $invoiceid . "] Status Change:" . $cur, "Invoice Status");
    $vars = "<div id='notification1' class='successbox'>" . $LNG["status"] . " " . $LNG["changed"] . " " . $LNG["successfully"] . "</div>";
}
if ($addcredit && $invoiceid && $userid) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    if ($totalcredit < $amount || $amount < 0) {
        $vars = "<div id='notification1' class='errorbox'>" . $LNG["notengouthcredit"] . "</div>";
    } else {
        $adminAddPayment = true;
        applyCredit($invoiceid, $userid, $amount);
        $vars = "<div id='notification1' class='successbox'>" . $LNG["creditsuccessfullyadded"] . "</div>";
    }
}
if ($refund && $tid && $invoiceid) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_transaction \n        where id='" . $tid . "'"));
    $data = NULL;
    $data = $sql;
    unset($data["id"]);
    if ($amount) {
        $data["amountout"] = $amount;
    } else {
        $data["amountout"] = $sql["amountin"];
    }
    $data["amountin"] = 0;
    $data["refundid"] = $tid;
    $data["note"] = $note;
    $db->insert("tbl_transaction", $data);
    $data = NULL;
    if ($refundto == 1) {
        $inv = mysqli_fetch_assoc(dquery("select userid from tbl_invoices\n            where id='" . $invoiceid . "'"));
        include_once ROOTDIR . "/includes/clients.fun.inc.php";
        addCredit($inv["userid"], $amount ? $amount : $sql["amountin"], $sendmail, "", $note, $user_note, $invoiceid);
    }
    updateInvoiceTotal($invoiceid);
    $vars = "<div id='notification1' class='successbox'>" . $LNG["transaction"] . " " . $LNG["refunded"] . " " . $LNG["successfully"] . "</div>";
}
if ($shows) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    if ($secretkey == $ccenckey) {
        $flagii = true;
        $gst = mysqli_fetch_assoc(dquery("SELECT userid\n        from tbl_invoices where id='" . $id . "'"));
        $usr = mysqli_fetch_assoc(dquery("select cardtype,cardlastfour,\n        AES_DECRYPT(cardnum,'" . $ccenckey . "') as cardno,cardname,\n        AES_DECRYPT(startdate,'" . $ccenckey . "') as stdt,\n        AES_DECRYPT(expdate,'" . $ccenckey . "') as expdt, \n        AES_DECRYPT(ccv,'" . $ccenckey . "') as ccv FROM tblUsers WHERE id='" . $gst["userid"] . "'"));
    }
}
if ($save && $invoiceid && ($upid || $new)) {
    checkDemoMode(false);
    $pageid = 523;
    checkPagePermission($pageid);
    if ($upid) {
        foreach ($upid as $e) {
            if ($ship[$e]) {
                $ware = mysqli_fetch_assoc(dquery("select warehouseid from tbl_invoiceitems where id='" . $e . "'"));
                dquery("update tbl_invoiceitems set shippingtax='" . $ship[$e] . "' \n         where invoiceid='" . $invoiceid . "' and warehouseid='" . $ware["warehouseid"] . "'");
            }
            dquery("update tbl_invoiceitems set description='" . $item[$e] . "',\n       amount='" . $price[$e] . "',taxed='" . $taxed[$e] . "' where id='" . $e . "'");
        }
    }
    if ($newitem) {
        $pageid = 523;
        checkPagePermission($pageid);
        if (!$newprice) {
            $newprice = 0;
        }
        $sql = mysqli_fetch_assoc(dquery("select * from tbl_invoiceitems where id='" . $ob . "'"));
        if ($newshipping) {
            $e = dquery("select warehouseid,shippingtax,id from tbl_invoiceitems where invoiceid='" . $invoiceid . "'");
            while ($d = mysqli_fetch_assoc($e)) {
                if ($d["warehouseid"] == $warehouseid) {
                    $newshipping = $newshipping + $d["shippingtax"];
                    dquery("update tbl_invoiceitems set shippingtax='" . $newshipping . "' where \n                    invoiceid='" . $invoiceid . "' and warehouseid='" . $d["warehouseid"] . "'");
                }
            }
            $data["shippingtax"] = $newshipping;
            $data["warehouseid"] = $warehouseid;
        } else {
            $data["warehouseid"] = $sql["warehouseid"];
        }
        $data["invoiceid"] = $sql["invoiceid"];
        $data["userid"] = $sql["userid"];
        $data["type"] = $sql["type"];
        $data["relid"] = $sql["relid"];
        $data["description"] = $newitem;
        $data["amount"] = $newprice;
        $data["taxed"] = $newtaxed;
        $data["duedate"] = $sql["duedate"];
        $data["pos"] = $sql["pos"];
        $data["bundleid"] = $sql["bundleid"];
        $data["warehouse"] = $sql["warehouse"];
        $db->insert("tbl_invoiceitems", $data);
        $data = NULL;
    }
    updateInvoiceTotal($invoiceid);
    $vars = "<div id='notification1' class='successbox'>" . $LNG["data"] . " " . $LNG["updated"] . " " . $LNG["successfully"] . "</div>";
}
if ($vars) {
    echo $vars;
}
$invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices` WHERE `id`='" . $id . "' "));
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($invoice_info["userid"]);
$result = select_query("tbl_invoices", "", ["id" => $id]);
$data = mysqli_fetch_assoc($result);
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$clnk = mysqli_fetch_assoc(dquery("select state,country from tblUsers where id='" . $userid . "'"));
$date = $data["date"];
$duedate = $data["duedate"];
$subtotal = $data["subtotal"];
$credit = $data["credit"];
if ($config["taxenabled"]) {
    $tax = $data["tax"];
    $taxname = getTaxRate(1, $clnk["state"], $clnk["country"], $data["paymentmethod"]);
    $tax2 = $data["tax2"];
    $taxrate = $data["taxrate"];
    $taxrate2 = $data["taxrate2"];
} else {
    $taxrate = "0.00";
    $taxrate2 = "0.00";
}
if ($taxrate != "0.00") {
    $taxname = getTaxRate(1, $clnk["state"], $clnk["country"], $paymentmethod);
}
if ($taxrate2 != "0.00") {
    $taxname = getTaxRate(2, $clnk["state"], $clnk["country"], $paymentmethod);
}
$shippingtax = $data["shippingtax"];
$total = $data["total"];
$fixedcharge = $data["fixedcharge"];
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
$result = select_query("tbl_transaction", "concat(SUM(amountin)-SUM(amountout)) as tots", ["invoiceid" => $id]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data["tots"];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
$invoiceitems = [];
$result = select_query("tbl_invoiceitems", "", ["invoiceid" => $id], "warehouseid", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $taxed = false;
    if ($data["taxed"]) {
        $taxed = true;
    }
    $invoiceitems[] = ["id" => $data["id"], "warehouseid" => $data["warehouseid"], "shippingtax" => $data["shippingtax"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br($data["description"]), "amount" => $data["amount"], "taxed" => $taxed];
    if ($data["type"] == "AddFunds" || $data["type"] == "AddFunds by Admin") {
        $desable_add_credit = true;
    }
    $promotion_code = $data["promotion_code"];
}
require_once ROOTDIR . "/includes/gateway.fun.php";
$gatewaysarray = getGatewaysArray();
$transactions = [];
$paid = 0;
$result = select_query("tbl_transaction", "", ["invoiceid" => $id], "date` ASC,`id", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $date = $data["date"];
    $date = date("Y-m-d h:i A", strtotime($date));
    $gateway = $data["gateway"];
    $description = $data["description"];
    $amountin = $data["amountin"];
    $fees = $data["fees"];
    $amountout = $data["amountout"];
    $paid += $amountin;
    $paid -= $amountout;
    $transid = $data["transid"];
    $invoiceid = $data["invoiceid"];
    $gateway = $gatewaysarray[$gateway];
    if (!$gateway) {
        $gateway = "-";
    }
    $transactions[] = ["date" => $date, "gateway" => $gateway, "transid" => $transid, "id" => $data["id"], "amount" => formatCurrency($amountin - $amountout, $clientDetails["currency"])];
}
echo "    <style>\n\n        .spgreen {\n            background-color: #28ac7c;\n            color: #ffffff !important;\n            display: inline-block;\n            padding: 0 10px !important;\n            text-align: center;\n            border-radius: 3px;\n        }\n        .spred {\n            background-color: #c60607;\n            color: #ffffff !important;\n            display: inline-block;\n            padding: 0 10px !important;\n            text-align: center;\n            border-radius:0px;\n        }\n        li.spred a:hover{\n            color: white !important;\n        }\n        li.spgreen a:hover{\n            color: white !important;\n        }\n    </style>\n    <script>\n        function showShipping(){\n            var ob=document.getElementsByClassName('shipper');\n            for(var i=0;i<ob.length;i++){\n                ob[i].style.display='';\n            }\n        }\n    </script>\n";
if ($invoice_info["status"] == "Unpaid" && $invoice_info["total"] == $amountpaid) {
    echo "    <script>\n        \$(document).ready(function() {\n            \$('.invoiceitemslist').hide();\n        });\n\n    </script>\n        ";
}
echo "    <ul id=\"tabmenu\">\n        ";
if ($invoice_info["status"] == "Unpaid" && $invoice_info["total"] == $amountpaid) {
    echo "            <li><a class='tabmenu_active' onclick=\"\$('.invoiceitemslist').hide();getContect('#tab111','main2.php?page=editinvoice.verification&ccg=";
    echo $ccg;
    echo "','";
    echo $id;
    echo "','','#tabcontent33',true,'#main_loader');\" id=\"tab111\" >Verification & Authorize</a></li>\n            ";
    $refund = true;
}
echo "        <li><a ";
if (!(($addpayment || $addcredit || $refund) && $invoice_info["status"] != "Paid")) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"\$('.invoiceitemslist').show();getContect('#tab1','main2.php?page=editinvoice.summary&ccg=";
echo $ccg;
echo "','";
echo $id;
echo "','','#tabcontent33',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["summary"];
echo "</a></li>\n        ";
if ($invoice_info["status"] != "Paid" && $invoice_info["status"] != "Cancel") {
    echo "            <li><a ";
    if ($addpayment) {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"\$('.invoiceitemslist').hide();getContect('#tab2','main2.php?page=editinvoice.payment&ccg=";
    echo $ccg;
    echo "','";
    echo $id;
    echo "','','#tabcontent33',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["add"];
    echo " ";
    echo $LNG["payment"];
    echo "</a></li>\n            <li><a ";
    if ($addcredit) {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"\$('.invoiceitemslist').hide();getContect('#tab3','main2.php?page=editinvoice.credit&ccg=";
    echo $ccg;
    echo "','";
    echo $id;
    echo "','','#tabcontent33',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["apply"];
    echo " ";
    echo $LNG["credit"];
    echo "</a></li>\n            ";
}
if (0 < $paid) {
    echo "            <li><a ";
    if ($refunds) {
        echo "class='tabmenu_active'";
    }
    echo "                        onclick=\"\$('.invoiceitemslist').hide();getContect('#tab4','main2.php?page=editinvoice.refund','";
    echo $id;
    echo "','','#tabcontent33',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["refund"];
    echo "</a></li>\n            ";
}
echo "    </ul>\n\n";
$InvoiceItemsArr = $invoiceitems;
echo "    <div id=\"tabcontent33\" >\n        ";
if ($invoice_info["status"] == "Unpaid" && $invoice_info["total"] == $amountpaid) {
    include "editinvoice.verification.php";
} else {
    if ($laoddefaultpage) {
        include $laoddefaultpage;
    } else {
        include "editinvoice.summary.php";
    }
}
echo "    </div>\n\n    <div style=\"clear: both;\">&nbsp;</div>\n";
if ($ccg) {
    echo "    <div id=\"content\" >\n        <div id=\"content_padded\">\n            ";
    if ($flagii) {
        echo "                <table border=\"0\" class=\"form\"  cellspacing=\"0\" cellpadding=\"4\" >\n                    <tr>\n                        <td>";
        echo $LNG["card"];
        echo " ";
        echo $LNG["holder"];
        echo "  ";
        echo $LNG["name"];
        echo "</td>\n                        <td>";
        echo $usr["cardname"];
        echo "</td>\n                    </tr>\n                    <tr>\n                        <td>";
        echo $LNG["creditcard"];
        echo " ";
        echo $LNG["number"];
        echo "</td>\n                        <td>";
        echo $usr["cardno"];
        echo "</td>\n                    </tr>\n                    <tr>\n                        <td>";
        echo $LNG["creditcard"];
        echo " ";
        echo $LNG["type"];
        echo "</td>\n                        <td>\n                            ";
        echo $usr["cardtype"] == "mcd" ? "Master Card" : ($usr["cardtype"] == "vis" ? "Visa Card" : ($usr["cardtype"] == "amx" ? "American Express" : ($usr["cardtype"] == "dnr" ? "Diner Club" : "Discover")));
        echo "</td>\n                    </tr>\n                    <tr>\n                        <td>";
        echo $LNG["start"];
        echo " ";
        echo $LNG["date"];
        echo "</td>\n                        <td>";
        $exp = explode("-", $usr["stdt"]);
        echo $exp[0] . "[" . date("m", strtotime($exp[0])) . "]/" . $exp[1];
        echo "</td>\n                    </tr>\n                    <tr>\n                        <td>";
        echo $LNG["expiry"];
        echo " ";
        echo $LNG["date"];
        echo "</td>\n                        <td>\n                            ";
        $exp = explode("-", $usr["expdt"]);
        echo $exp[0] . "[" . date("m", strtotime($exp[0])) . "]/" . $exp[1];
        echo "</td>\n                    </tr>\n                    <tr>\n                        <td>CCV</td>\n                        <td>";
        echo $usr["ccv"];
        echo "</td>\n                    </tr>\n\n                </table>\n                ";
    } else {
        echo "                <div id=\"accountinfo1\" class=\"groupstabes \">\n                    <h2>\n                        <span class=\"groupstabesheadertext\">Secret Key</span>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n\n                        <form method=\"post\">\n                            <input type=\"hidden\" name=\"id\" value=\"";
        echo $id;
        echo "\" />\n                            <input type=\"hidden\" name=\"ccg\" value=\"";
        echo $ccg;
        echo "\" />\n                            <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\n                                <tbody>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
        echo $LNG["enter"];
        echo " ";
        echo $LNG["secret"];
        echo " ";
        echo $LNG["key"];
        echo "</td>\n                                    <td><input type=\"text\" name=\"secretkey\" /></td>\n                                </tr>\n                                <tr>\n                                    <td>&nbsp;</td>\n                                    <td><input type=\"submit\" class=\"btn add\" name=\"shows\" value=\"Show Credit Card Information\" /></td>\n                                </tr>\n                                </tbody>\n                            </table>\n                        </form>\n                    </div></div>\n                ";
    }
    echo "\n        </div>\n    </div>\n    ";
}
echo "    <div class=\"invoiceitemslist\" >\n        <hr />\n        <div>\n            <div id=\"accountinfo1\" class=\"groupstabes \" >\n                <h2>\n                    <span class=\"groupstabesheadertext\"> ";
echo $LNG["invoice"];
echo " ";
echo $LNG["items"];
echo "</span>\n                </h2>\n                <div class=\"groupstabescontant\">\n\n                    <form method=\"post\" id=\"frmitem\">\n                        <input type=\"hidden\" name=\"ccg\" value=\"";
echo $ccg;
echo "\" />\n                        <input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n                        <div  style=\"\">\n                            <table id=\"main_tbl\">\n                                <thead>\n                                <tr>\n                                    <th>&nbsp;</th>\n                                    <th>";
echo $LNG["item"];
echo "</th>\n                                    <th style=\"text-align: right !important;\" >";
echo $LNG["amount"];
echo "</th>\n                                    <th  class=\"shipper\" style=\"text-align: right !important; display:none;\">\n                                        ";
echo $LNG["shipping"];
echo " ";
echo $LNG["cost"];
echo "</th>\n                                    <th>";
echo $LNG["taxed"];
echo "</th>\n                                </tr>\n                                </thead>\n                                ";
$ob = NULL;
foreach ($InvoiceItemsArr as $invo) {
    if (!$ob) {
        $ob = true;
        echo "                                        <input type=\"hidden\" name=\"ob\" value=\"";
        echo $invo["id"];
        echo "\" />\n                                        ";
    }
    echo "                                    <input type=\"hidden\" name=\"upid[";
    echo $invo["id"];
    echo "]\" value=\"";
    echo $invo["id"];
    echo "\" />\n                                    <tr >\n                                        <td><input type=\"checkbox\"  name=\"ids[";
    echo $invo["id"];
    echo "]\" value=\"";
    echo $invo["id"];
    echo "\" /></td>\n                                        <td style=\"width: 100%;\">\n                                            <input style=\"width:100%\" type=\"text\" class=\"txt\"  name=\"item[";
    echo $invo["id"];
    echo "]\" value=\"";
    echo html_entity_decode($invo["description"]);
    echo "\" />\n\n                                            ";
    if ($invo["type"] == "IMEI") {
        $or = mysqli_fetch_assoc(dquery("select imei,order_id,server from tbl_order_imei\nwhere order_id='" . $invo["relid"] . "'"));
        if ($or["server"] == 1) {
            echo "<Br /> Server Order : " . $or["order_id"];
        } else {
            echo "<br /><small>IMEI : " . $or["imei"] . "</small>";
        }
    }
    echo "                                        </td>\n                                        <td  align=\"right\" > <input style=\"text-align: right !important;\" class=\"txt small\" type=\"text\" name=\"price[";
    echo $invo["id"];
    echo "]\" value=\"";
    echo $invo["amount"];
    echo "\" /> </td>\n                                        <td  align=\"right\" class=\"shipper\" style=\"display:none;\" >\n                                            ";
    if ($ware != $invo["warehouseid"]) {
        $ware = $invo["warehouseid"];
        echo "                                                <input style=\"text-align: right !important;\" type=\"text\" name=\"ship[";
        echo $invo["id"];
        echo "]\" value=\"";
        echo $invo["shippingtax"];
        echo "\" />\n                                                ";
    }
    echo "                                        </td>\n                                        <td><input type=\"checkbox\"\n                                                ";
    if ($invo["taxed"] == "true") {
        echo "checked='checked'";
    }
    echo " name=\"taxed[";
    echo $invo["id"];
    echo "]\" value=\"1\" id=\"reject\" /></td>\n                                    </tr>\n                                    ";
}
echo "                                <tr >\n                                    <td><input type=\"checkbox\"   name=\"new\"  value=\"1\" /></td>\n                                    <td >\n                                        <input type=\"text\" name=\"newitem\" class=\"text\" value= \"\" />\n                                    </td>\n                                    <td align=\"right\"><input type=\"text\" class=\"txt small\"  name=\"newprice\" value=\"\" /> </td>\n                                    <td  align=\"right\" class=\"shipper\" style=\"display:none;\" >\n                                        <input style=\"text-align: right !important;\" type=\"text\" class=\"txt\" name=\"newshipping\" value=\"\" /><br />\n                                        <select style=\"width: 153px !important;margin-top:5px\" name=\"warehouseid\">\n                                            ";
$sql = dquery("select * from tbl_warehouse");
while ($ro = mysqli_fetch_assoc($sql)) {
    echo "                                                <option value=\"";
    echo $ro["id"];
    echo "\">";
    echo $ro["name"];
    echo "</option>\n                                                ";
}
echo "                                        </select>\n                                    </td>\n                                    <td><input type=\"checkbox\"   name=\"newtaxed\" id=\"reject\" value=\"1\" /></td>\n                                </tr>\n                            </table>\n\n                            <div>\n\n                                <img src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" />\n                                ";
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    echo "                                    <input type=\"submit\" class=\"btn\" onclick=\"return confirm('Are you sure want to remove Item ?');\" name=\"delete\"\n                                           value=\"Delete Selected\"/>\n\n                                    <input type=\"submit\" class=\"btn btn-primary\" name=\"split\" value=\"Split Selected\"/>\n                                    ";
}
echo "                            </div>\n\n                            <table id=\"main_tbl\" style=\"float: right;width:auto\">\n                                <tr>\n                                    <td id=\"itemsheading\" ><div align=\"right\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["sub"];
echo $LNG["total"];
echo ":&nbsp;</div></td>\n                                    <td id=\"itemsheading\" style=\"text-align: right;width:100px\"><strong>";
echo formatCurrency($subtotal, $clientDetails["currency"]);
echo "</strong></td>\n                                </tr>\n                                ";
if ($shippingtax) {
    echo "                                    <tr>\n                                        <td id=\"itemsheading\"><div align=\"right\">\n                                                (<a style=\"color: gray; text-decoration: none;\" href=\"javascript: showShipping();\">";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["shipping"];
    echo "  ";
    echo $LNG["cost"];
    echo "</a>)\n                                                ";
    echo $LNG["shipping"];
    echo " ";
    echo $LNG["cost"];
    echo ":&nbsp;</div></td>\n                                        <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
    echo formatCurrency($shippingtax, $clientDetails["currency"]);
    echo " </td>\n                                    </tr>\n                                    ";
}
if ($taxrate != "0.00") {
    echo "                                    <tr>\n                                        <td id=\"itemsheading\"><div align=\"right\">";
    echo $taxrate;
    echo "%\n                                                ";
    echo $taxname["name"];
    echo ":&nbsp;</div></td>\n                                        <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
    echo formatCurrency($tax, $clientDetails["currency"]);
    echo " </td>\n                                    </tr>\n                                    ";
}
if ($taxrate2 != "0.00") {
    echo "                                    <tr>\n                                        <td id=\"itemsheading\"><div align=\"right\">";
    echo $taxrate2;
    echo "% ";
    echo $taxname["name"];
    echo ":&nbsp;</div></td>\n                                        <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
    echo $tax2;
    echo " </td>\n                                    </tr>\n                                ";
}
if ($fixedcharge != "0.00") {
    echo "                                    <tr>\n                                        <td id=\"itemsheading\"><div align=\"right\">Fixed Charge:&nbsp;</div></td>\n                                        <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
    echo formatCurrency($fixedcharge, $clientDetails["currency"]);
    echo " </td>\n                                    </tr>\n                                ";
}
echo "\n\n                                <tr>\n                                    <td id=\"itemsheading\"><div align=\"right\"> ";
echo $LNG["credit"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["balance"];
echo ":&nbsp;</div></td>\n                                    <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
echo formatCurrency($credit, $clientDetails["currency"]);
echo " </td>\n                                </tr>\n\n\n                                ";
if ($promotion) {
    echo "                                    <tr>\n                                        <td id=\"itemsheading\"><div align=\"right\">";
    echo $LNG["promotion"];
    echo " [";
    echo $promotion_code;
    echo "]:&nbsp;</div></td>\n                                        <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"> ";
    echo formatCurrency($promotion, $clientDetails["currency"]);
    echo " </td>\n                                    </tr>\n                                    ";
}
echo "                                <tr>\n                                    <td id=\"itemsheading\"><div align=\"right\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["total"];
echo ":&nbsp;</div></td>\n                                    <td id=\"itemsheading\" align=\"right\"  style=\"text-align: right;\"><strong>";
echo formatCurrency($total, $clientDetails["currency"]);
echo "</strong></td>\n                                </tr>\n\n\n                            </table>\n\n                        </div>\n                        ";
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    echo "                            <p class=\"fixedbtn\">\n                                <input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
    echo $LNG["save"];
    echo "\"/>\n                            </p>\n                            ";
}
echo "                    </form>\n                </div></div>\n\n        </div>\n\n\n        ";
if ($transactions) {
    echo "            <hr />\n            <div >\n                <div id=\"accountinfo1\" class=\"groupstabes\" >\n                    <h2>\n                        <span class=\"groupstabesheadertext\">";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo "</span>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n                        <table id=\"main_tbl\"   cellspacing=\"0\"  align=\"center\">\n                            <thead>\n                            <tr>\n                                <th>";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["date"];
    echo "</th>\n                                <th>";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["gateway"];
    echo "</th>\n                                <th>";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["id"];
    echo "</th>\n                                <th>";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["amount"];
    echo "</th>\n                                <th>";
    echo $LNG["action"];
    echo "</th>\n                            </tr>\n                            </thead>\n                            ";
    foreach ($transactions as $tran) {
        echo "                                <tr>\n                                    <td id=\"itemsrow\" >";
        echo $tran["date"];
        echo "</td>\n                                    <td id=\"itemsrow\">";
        echo $tran["gateway"];
        echo "</td>\n                                    <td id=\"itemsrow\">";
        echo $tran["transid"];
        echo "</td>\n                                    <td align=\"right\" id=\"\">";
        echo $tran["amount"];
        echo "</td>\n                                    <td align=\"right\" id=\"\"><a onclick=\"return confirm('Are you sure want to remove?');\" href=\"javascript:reloadcurrent('edituser.editinvoice','";
        echo $id;
        echo "&id=";
        echo $id;
        echo "&removetra=";
        echo $tran["id"];
        echo "')\" class=\"deletedata\"></a></td>\n                                </tr>\n                                ";
    }
    echo "                            <tr class=\"bolds\">\n                                <td id=\"itemsheading\" colspan=\"3\"></td>\n                                <td  align=\"center\">\n                                    ";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["balance"];
    echo ":&nbsp;\n                                    ";
    echo formatCurrency($total - $amountpaid, $clientDetails["currency"]);
    echo "\n                                </td>\n                                <td></td>\n                            </tr>\n                        </table>\n\n                    </div></div></div>\n            ";
}
echo " </div> ";
$fileverioncheck = "6.1.0";
function inCurl11($url, $postfields = [], $curlopts = [])
{
    global $debug_output;
    $curlopts["CURLOPT_TIMEOUT"] = 1000;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($postfields) {
        $fieldstring = $postfields;
        if (is_array($fieldstring)) {
            $fieldstring = "";
            foreach ($postfields as $k => $v) {
                $fieldstring .= "" . $k . "=" . urlencode($v) . "&";
            }
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldstring);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $curlopts["CURLOPT_TIMEOUT"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if ($curlopts["HEADER"]) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlopts["HEADER"]);
    }
    $retval = curl_exec($ch);
    return $retval;
}

?>