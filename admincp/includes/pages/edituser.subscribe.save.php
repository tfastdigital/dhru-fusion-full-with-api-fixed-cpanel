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
include ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($imei != "") {
    $type = "tbl_services_imei";
    $tcredit = "tbl_imei_credit";
    $srv = $imei;
    $name = "IMEI";
} else {
    if ($file != "") {
        $type = "tbl_services_file";
        $tcredit = "tbl_file_credit";
        $srv = $file;
        $name = "File";
    } else {
        if ($server != "") {
            $type = "tbl_services_imei";
            $tcredit = "tbl_imei_credit";
            $srv = $server;
            $name = "IMEI";
        } else {
            if ($product != "") {
                $type = "tbl_products";
                $tcredit = "tbl_product_credit";
                $srv = $product;
                $name = "Product";
            } else {
                echo "error: " . $LNG["selectanyservice"];
                exit;
            }
        }
    }
}
$uid = $id;
$sid = $srv;
$cur = mysqli_fetch_assoc(dquery("SELECT default_currency,credit_left FROM tblUsers WHERE id='" . $uid . "'"));
$sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM " . $tcredit . " where service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
$serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days,service_name FROM " . $type . " where id='" . $sid . "'"));
if ($sql["credit_subscribe"] != "") {
    $credit = $sql["credit_subscribe"];
} else {
    $credit = $serv["subscribe_credit"];
}
$credit = subscribeCurrency($sid, $type, $cur["default_currency"]);
$days = $serv["subscribe_days"];
$check = mysqli_num_rows(dquery("select id from tbl_subscribers where user_id='" . $uid . "' \nand type='" . $type . "' and service_id='" . $sid . "'"));
if ($check) {
    echo "error: " . $LNG["youalreadysubscribed"];
    exit;
}
$check = mysqli_num_rows(dquery("select id from tbl_subscribers\n             where user_id='" . $uid . "' and type='" . $type . "' and service_id='" . $sid . "' and status='active'"));
if ($check) {
    echo "error: " . $lng_languag["yousubscribed"];
    exit;
}
if ($account) {
    if ($cur["credit_left"] < $credit) {
        echo "error: " . $LNG["notengouthcredit"];
        exit;
    }
    dquery("UPDATE tblUsers SET credit_left=credit_left-" . $credit . " WHERE id='" . $uid . "'");
    include_once ROOTDIR . "/includes/mail.fun.php";
    $geninvoice = true;
    $paid = true;
    $adminAddPayment = true;
}
if ($geninvoice && $credit) {
    if ($type == "tbl_products") {
        $reals = "shop";
    } else {
        if ($type == "tbl_services_imei") {
            $reals = "imei";
        } else {
            if ($type == "tbl_services_file") {
                $reals = "file";
            } else {
                if ($type == "tbl_server_log") {
                    $reals = "server";
                }
            }
        }
    }
    insert_query("tbl_invoiceitems", ["userid" => $uid, "type" => "Subscription", "relid" => "", "description" => $LNG["subscription"] . " Service : " . $serv["service_name"], "amount" => $credit, "taxed" => "0", "duedate" => "now()", "paymentmethod" => "", "serviceid" => $srv, "service" => $reals]);
    require ROOTDIR . "/includes/invoice.fun.php";
    $invoiceid = generateInvoice($uid);
    if ($paid) {
        processInvoicetoPaid($invoiceid);
    }
}
echo "reload: " . $LNG["datasavesuccessfully"];

?>