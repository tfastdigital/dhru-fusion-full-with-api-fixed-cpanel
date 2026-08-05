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
$GATEWAY = loadGatewayModule("coinbase");
if (!$GATEWAY["name"]) {
    exit("Module Not Activated");
}
$rawBody = file_get_contents("php://input");
$decodedBody = json_decode($rawBody, true);
$success = $decodedBody["event"]["type"];
$TmpInvoiceNo = $idnumber = $decodedBody["event"]["data"]["metadata"]["invoice_id"];
$txn_id = $decodedBody["event"]["data"]["payments"][0]["transaction_id"];
$paymentAmount = $decodedBody["event"]["data"]["payments"][0]["value"]["local"]["amount"];
$Currency = $decodedBody["event"]["data"]["payments"][0]["value"]["local"]["currency"];
$hash = $_SERVER["HTTP_X_CC_WEBHOOK_SIGNATURE"];
$transactionStatus = $success == "charge:confirmed" ? "Success" : "Failure";
$idnumber = explode("-", $TmpInvoiceNo);
$storeowner = $idnumber[0] / 123;
$uid = $idnumber[1] / 247;
$storetax = mysqli_fetch_assoc(dquery("select value from tbl_store_config where \n            attribute='coinbasetax' and uid='" . $storeowner . "'"));
$storetax = $storetax["value"];
$sample = 100 + $storetax;
$validator["addcredit"] = round($paymentAmount * 100 / $sample, 2);
$amount = $validator["addcredit"];
if ($amount * $storetax / 100 + $amount == $paymentAmount) {
    require_once ROOTDIR . "/includes/clients.fun.inc.php";
    require_once ROOTDIR . "/includes/mail.fun.php";
    $stored = mysqli_fetch_assoc(dquery("select username from tblUsers\n                where id='" . $storeowner . "'"));
    $udet = mysqli_fetch_assoc(dquery("select username from tblUsers\n                where id='" . $uid . "'"));
    $validator["user"] = md5($uid);
    $lng_languag["notenoughsell"] = "not enought sell credit";
    if ($error = validateCredits($validator, $storeowner)) {
        $mailmerge["transactionid"] = $txn_id;
        $mailmerge["user"] = $udet["username"];
        $mailmerge["amount"] = $amount . " " . $Currency;
        sendMail("62", $storeowner, "", $mailmerge, true);
        exit;
    }
    if ($validator["addcredit"] != "") {
        addCredit($uid, $validator["addcredit"], true, "Credit Transfer by Add Fund from " . $stored["username"]);
        rebateSellCredit($storeowner, $validator["addcredit"], false);
        $mailmerge["user"] = $udet["username"];
        $mailmerge["amount"] = $amount . " " . $Currency;
        sendMail("63", $storeowner, "", $mailmerge, true);
        $date = date("Y-m-d");
        dquery("INSERT INTO tbl_store_fund_history (sid,uid,tid,amount,date)\n                    VALUES ('" . $storeowner . "','" . $uid . "','" . $txn_id . "','" . $amount . "','" . $date . "')");
    }
}

?>