<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
error_reporting(-1);
ini_set("display_errors", "On");
try {
    $json = file_get_contents("php://input");
    $order = json_decode($json, true, 512, JSON_UNESCAPED_UNICODE);
    $orderdetail = $order["order"];
    logTransaction("networkae_ngenius", json_encode($orderdetail), "Callback Detail");
    $event = $order["eventName"];
    $outlet = $orderdetail["outletId"];
    $ref = $orderdetail["reference"];
    $invoiceid = $orderdetail["merchantOrderReference"];
    $emailAddress = $orderdetail["emailAddress"];
    $ordercurrency = $orderdetail["amount"]["currencyCode"];
    $mc_gross = number_format(preg_replace("/[^0-9.]/i", "", $orderdetail["amount"]["value"]) / 100, 2);
    $mc_fee = 0;
    logTransaction("networkae_ngenius", $result, "Received", "", "", $invoiceid);
    $IsAggregator = false;
    $IsWallet = false;
    $aggregatordata = explode("_", $invoiceid);
    $aggregatordata[0] = 0 < $aggregatordata[1] && $aggregatordata[2];
    if ($aggregatordata[0]) {
        $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
        $aggretran = mysqli_fetch_assoc($aggretran);
        if ($aggretran["aggregatortransid"]) {
            $idnumber = $aggregatordata[1];
            $IsAggregator = true;
        }
    }
    if (substr($invoiceid, 0, 1) == "B") {
        $aggregatordata[0] = "B";
        $aggregatordata[1] = str_replace("B", "", $invoiceid);
    }
    $aggregatordata[0] = 0 < $aggregatordata[1];
    if ($aggregatordata[0]) {
        $idnumber = $aggregatordata[1];
        $IsWallet = true;
    }
    if ($event == "AUTHORISED" || $event == "CAPTURED") {
        $Inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices where id='" . $invoiceid . "'"));
        $userid = $Inv["userid"];
        if (($Inv["status"] == "Unpaid" || $IsWallet) && !mysqli_num_rows(dquery("select id from tbl_transaction where transid='" . $ref . "'"))) {
            $Curr = mysqli_fetch_assoc(dquery("select id from tbl_currencies where\n        `code`='" . $ordercurrency . "'"));
            $currency = getCurrency("", $userid);
            $paypalcurrencyid = $Curr["id"];
            if ($paypalcurrencyid != $currency["id"]) {
                $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
                $mc_gross = round($mc_gross, 2);
                $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
                $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
                $data = mysqli_fetch_assoc($result);
                $total = round($data["total"], 2);
                if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                    $mc_gross = $total;
                }
            }
            $PaidAmount = $mc_gross;
            logTransaction("networkae_ngenius", json_encode($orderdetail), "Payment Successful");
            if ($IsWallet) {
                $INVOSI = explode("_", $invoiceid);
                $Gateway = loadGatewayModule("networkaengenius");
                $Wallet = mysqli_fetch_assoc(dquery("select fee,status,amount from tblWalletTransaction \nwhere transid='" . $INVOSI[1] . "'"));
                $Fee = $Wallet["fee"];
                $PaidAmount = round($PaidAmount, 2);
                if (0 < $Fee) {
                    $PaidAmount = $PaidAmount - $Fee;
                }
                if ($Wallet["amount"] <= $PaidAmount) {
                    if ($Wallet["status"] != "paid") {
                        walletTransaction($ref, $idnumber, $PaidAmount, $Fee, $Gateway["name"]);
                        logTransaction("rakbankpay", $params, "Wallet Paid", "invoice", $invoiceid);
                    }
                } else {
                    dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $INVOSI[1] . "'");
                    logTransaction("rakbankpay", $params, "Transaction Less Amount", "invoice", $invoiceid);
                    include_once ROOTDIR . "/includes/mail.fun.php";
                    $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $INVOSI[1] . " <br />";
                    $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                    $adminmessage .= "Amount : " . $PaidAmount;
                    sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
                }
            } else {
                addPayment($invoiceid, $ref, $mc_gross, $mc_fee, "networkaengenius", 1, "", "", $emailAddress);
            }
            exit;
        }
    }
} catch (Exception $e) {
    file_put_contents("network_ae_failuer.txt", "No Response");
    logTransaction("networkae_ngenius", $orderdetail, "No Response");
}

?>