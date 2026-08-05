<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/invoice.fun.php";
$adminAddPayment = true;
global $adminAddPayment;
$clientDetails = getClientsDetails($id);
$success = "";
$error = "";
$sellcreditlimit = round($sellcreditlimit, $precision);
$rebatecredit = round($rebatecredit, $precision);
$rebatesellcredit = round($rebatesellcredit, $precision);
$creditleft = round($creditleft, $precision);
if ($sellcreditlimit) {
    if (addSellCredit($id, $sellcreditlimit, $sendmailsa)) {
        $success .= "<li>" . $sellcreditlimit . " " . $LNG["sellcreditlimitsuccessfullyadded"] . "</li>";
    } else {
        $error .= "<li>" . $sellcreditlimit . " " . $LNG["sellcreditlimitnotadded"] . "</li>";
    }
}
if ($rebatecredit && 0 < $rebatecredit) {
    $admn = mysqli_fetch_assoc(dquery("select credit from tbl_admin\n    where id='" . $_SESSION["adminid"] . "'"));
    $flagallow = true;
    if ($invoice && mysqli_num_rows(dquery("select id from tbl_invoices \nwhere total<'" . $rebatecredit . "' and id='" . $invoice . "'"))) {
        $flagallow = false;
        $error .= "<li>Invoice total should be greater than or equal to " . $rebatecredit . "</li>";
    }
    $flager = false;
    if ($flagallow) {
        if (rebateCredit($id, $rebatecredit, $sendmailcr, "", $admin_noter, $user_noter, $invoice)) {
            if ($_SESSION["system_default_currency"]["id"] != $clientDetails["currency"]["id"]) {
                $convtrtc = convertCurrency($rebatecredit, $clientDetails["currency"]["id"], $_SESSION["system_default_currency"]["id"]);
            } else {
                $convtrtc = $rebatecredit;
            }
            if (0 < $convtrtc && $admn["credit"] != "") {
                $flager = true;
            }
            if ($flager) {
            }
            if ($invoice) {
                dquery("update tbl_invoiceitems set amount=amount-" . $rebatecredit . " where invoiceid='" . $invoice . "' and type='AddFunds by Admin'");
                updateInvoiceTotal($invoice);
            }
            if ($config["slack_adminaddcredit"]) {
                $_cols[0]["titel"] = $clientDetails["username"];
                $_cols[0]["text"] = $_SESSION["currencyarray"][$clientDetails["currency_id"]]["prefix"] . $rebatecredit . " " . $_SESSION["currencyarray"][$clientDetails["currency_id"]]["suffix"];
                SlackSendMsg($config["slack_adminaddcredit"], "Admin - Rebate Fund", "good", $_cols, true);
            }
            $success .= "<li>" . $rebatecredit . " " . $LNG["creditsuccessfullyrebate"] . "</li>";
        } else {
            $error .= "<li>" . $LNG["creditnotrebate"] . "</li>";
        }
    }
} else {
    if ($rebatecredit) {
        $error .= "<li>" . $LNG["creditnotrebate"] . "</li>";
    }
}
if ($rebatesellcredit) {
    if (rebateSellCredit($id, $rebatesellcredit, $sendmailsr)) {
        $success .= "<li>" . $rebatesellcredit . " " . $LNG["sellcreditlimitsuccessfullyrebate"] . "</li>";
    } else {
        $error .= "<li>" . $LNG["sellcreditlimitnotadded"] . "</li>";
    }
}
if ($creditvalidity) {
    $diff = time() - $clientDetails["credit"]["date"];
    $days = round($diff / 86400);
    if ($clientDetails["credit"]["validity"] != 0) {
        if ($clientDetails["credit"]["validity"] < $days) {
            $date = time();
            if (dquery("update tblUsers set credit_validity ='" . $creditvalidity . "',credit_date='" . $date . "' where id=" . $id)) {
                $success .= "<li>" . $LNG["creditvaliditysuccessfullysave"] . "</li>";
            }
        } else {
            if (dquery("update tblUsers set credit_validity =" . $creditvalidity . "+credit_validity where id=" . $id)) {
                $success .= "<li>" . $LNG["creditvaliditysuccessfullysave"] . "</li>";
            }
        }
    } else {
        $date = time();
        if (dquery("update tblUsers set credit_validity =" . $creditvalidity . ",credit_date=" . $date . " where id=" . $id)) {
            $success .= "<li>" . $LNG["creditvaliditysuccessfullysave"] . "</li>";
        }
    }
}
if ($creditvalidity == "0" && dquery("update tblUsers set credit_validity = 0 where id=" . $id)) {
    $success .= "<li>" . $LNG["creditvaliditysuccessfullysave"] . "</li>";
}
if ($creditleft && 0 < $creditleft) {
    $admn = mysqli_fetch_assoc(dquery("select credit from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $flager = false;
    if ($_SESSION["system_default_currency"]["id"] != $clientDetails["currency"]["id"]) {
        $convtrtc = convertCurrency($creditleft, $clientDetails["currency"]["id"], $_SESSION["system_default_currency"]["id"]);
    } else {
        $convtrtc = $creditleft;
    }
    if (mysqli_num_rows(dquery("select id from tbl_transaction\n    where transid='" . $transactionid . "'")) && $transactionid) {
        echo "error: " . $LNG["transaction"] . " " . $LNG["id"] . " " . $LNG["already"] . " " . $LNG["exists"];
        exit;
    }
    if (0 < $convtrtc && $admn["credit"] != "") {
        if ($admn["credit"] < $convtrtc) {
            echo "error: " . $LNG["notengouthcredit"];
            exit;
        }
        $flager = true;
    }
    $_SESSION["creditreason"] = "";
    if (addCredit($id, $creditleft, $sendmailca, "", $admin_notea, $user_note, "", $transactionid)) {
        if ($flager) {
            dquery("update tbl_admin set credit=credit-" . $convtrtc . " where id='" . $_SESSION["adminid"] . "'");
        }
        if ($geninvoice) {
            dquery("DELETE from tbl_invoiceitems\n            where invoiceid='0' and userid='" . $id . "'");
            if (!$paid) {
                if ($duedays != 99) {
                    $duedate = date("Y-m-d", strtotime(date("Y-m-d") . " + " . $duedays . " days"));
                }
            } else {
                $duedate = "now()";
            }
            insert_query("tbl_invoiceitems", ["userid" => $id, "type" => "AddFunds by Admin", "relid" => "", "description" => "+ Add Funds", "amount" => $creditleft, "taxed" => "0", "duedate" => $duedate, "paymentmethod" => $paymentgateway]);
            $invoiceid = generateInvoice($id, $sendmailca, "", $paid);
            if ($paymentgateway) {
                addTransaction($id, 0, "AddFunds by Admin", $creditleft, $fees, 0, $paymentgateway, $transactionid, $invoiceid);
            }
            if ($paid) {
                processInvoicetoPaid($invoiceid);
            }
        }
        if ($config["slack_adminaddcredit"]) {
            $_cols[0]["titel"] = $clientDetails["username"];
            $_cols[0]["text"] = $creditleft . " " . $clientDetails["currency"]["code"];
            if ($geninvoice) {
                $_cols[1]["titel"] = "INV#" . $invoiceid;
                $_cols[1]["text"] = $paid ? "Paid" : "Unpaid";
            }
            if ($paymentgateway) {
                $Gateway = mysqli_fetch_assoc(dquery("select `value` from tbl_paymentgateways\nwhere setting='name' and gateway='" . $paymentgateway . "'"));
                $_cols[2]["titel"] = $Gateway["value"];
                $_cols[2]["text"] = $transactionid;
            }
            SlackSendMsg($config["slack_adminaddcredit"], "Admin + Add Fund" . (!$geninvoice ? " W/O Invoice" : ""), !$geninvoice ? "danger" : "good", $_cols, true, $admin_notea);
        }
        if ($invoiceid) {
            $success .= "<li>" . $creditleft . " " . $LNG["creditsuccessfullyadded"] . ". " . $LNG["invoice"] . "#" . $invoiceid . " [" . ($paid ? "Paid" : "Unpaid") . "]</li>";
        } else {
            $success .= "<li>" . $creditleft . " " . $LNG["creditsuccessfullyadded"] . "</li>";
        }
    } else {
        $error .= "<li>" . $LNG["creditnotadded"] . " " . $_SESSION["creditreason"] . "</li>";
    }
} else {
    if ($creditleft) {
        $error .= "<li>" . $LNG["creditnotadded"] . "</li>";
    }
}
if ($success) {
    echo "success:<strong>" . $LNG["financial"] . "</strong><br>" . $success;
}
if ($error) {
    echo "error:" . $error;
}

?>