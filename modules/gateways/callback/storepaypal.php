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
$postipn = "cmd=_notify-validate";
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
    $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
}
if ($demomode) {
    $_paypal_link = "ssl://www.sandbox.paypal.com";
    $urlParsed = parse_url("https://www.sandbox.paypal.com/cgi-bin/webscr");
} else {
    $_paypal_link = "ssl://www.paypal.com";
    $urlParsed = parse_url("https://www.paypal.com/cgi-bin/webscr");
}
$port = fsockopen($_paypal_link, 443, $errno, $errstr, 30);
if (!$port && !$error) {
    logTransaction("paypal", "No::" . $errno . " Error::" . $errstr, "Error-1");
    exit;
}
fputs($port, "POST " . $urlParsed["path"] . " HTTP/1.1\r\n");
fputs($port, "Host: " . $urlParsed["host"] . "\r\n");
fputs($port, "Content-type: application/x-www-form-urlencoded\r\n");
fputs($port, "Content-length: " . strlen($postipn) . "\r\n");
fputs($port, "Connection: close\r\n\r\n");
fputs($port, $postipn . "\r\n\r\n");
while (!feof($port)) {
    $reply .= fgets($port, 1024);
}
fclose($port);
if (deregi("VERIFIED", $reply) || deregi("verified", $reply)) {
    logTransaction("paypal", $orgipn, "Verified");
    $payment_status = $_POST["payment_status"];
    $subscr_id = $_POST["subscr_id"];
    $txn_type = $_POST["txn_type"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_fee"];
    $idnumber = $_POST["custom"];
    $idnumber = base64_decode($idnumber);
    $idnumber = explode("-", $idnumber);
    $storeowner = $idnumber[0] / 123;
    $uid = $idnumber[1] / 247;
    $tax = $_POST["tax"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $business = $_POST["business"];
    $currency = getCurrency("", $storeowner);
    if ($paypalcurrency != $currency["id"]) {
        $mc_gross = convertCurrency($mc_gross, $paypalcurrency, $currency["id"]);
        $mc_fee = convertCurrency($mc_fee, $paypalcurrency, $currency["id"]);
        $mc_gross = round($mc_gross, 2);
        $mc_fee = round($mc_fee, 2);
    }
    $pay = mysqli_fetch_assoc(dquery("select value \nfrom tbl_store_config where \nattribute='paypalid' and uid='" . $storeowner . "'"));
    if ($business != $pay["value"]) {
        logTransaction("paypal", $orgipn, "Wrong Business Email");
        exit;
    }
    if ($payment_status == "Pending") {
        logTransaction("paypal", $orgipn, "Pending");
        exit;
    }
    if ($txn_id && checkTransID($txn_id)) {
        exit;
    }
    switch ($txn_type) {
        case "web_accept":
            if ($payment_status != "Completed") {
                logTransaction("paypal", $orgipn, $payment_status);
                exit;
            }
            $storetax = mysqli_fetch_assoc(dquery("select value from tbl_store_config where \n            attribute='paypaltax' and uid='" . $storeowner . "'"));
            $storetax = $storetax["value"];
            $sample = 100 + $storetax;
            $validator["addcredit"] = round($mc_gross * 100 / $sample, 2);
            $amount = $validator["addcredit"];
            if ($amount * $storetax / 100 + $amount == $mc_gross) {
                require_once ROOTDIR . "/includes/clients.fun.inc.php";
                require_once ROOTDIR . "/includes/mail.fun.php";
                $stored = mysqli_fetch_assoc(dquery("select username from tblUsers\n                where id='" . $storeowner . "'"));
                $udet = mysqli_fetch_assoc(dquery("select username from tblUsers\n                where id='" . $uid . "'"));
                $validator["user"] = md5($uid);
                $lng_languag["notenoughsell"] = "not enought sell credit";
                if ($error = validateCredits($validator, $storeowner)) {
                    $mailmerge["transactionid"] = $txn_id;
                    $mailmerge["user"] = $udet["username"];
                    $mailmerge["amount"] = $amount . " " . $paypalcurrency;
                    sendMail("62", $storeowner, "", $mailmerge, true);
                    exit;
                }
                if ($validator["addcredit"] != "") {
                    addCredit($uid, $validator["addcredit"], true, "Credit Transfer by Add Fund from " . $stored["username"]);
                    rebateSellCredit($storeowner, $validator["addcredit"], false);
                    $mailmerge["user"] = $udet["username"];
                    $mailmerge["amount"] = $amount . " " . $paypalcurrency;
                    sendMail("63", $storeowner, "", $mailmerge, true);
                    $date = date("Y-m-d");
                    dquery("INSERT INTO tbl_store_fund_history (sid,uid,tid,amount,date)\n                    VALUES ('" . $storeowner . "','" . $uid . "','" . $txn_id . "','" . $amount . "','" . $date . "')");
                }
            }
            exit;
            break;
        default:
            logTransaction("paypal", $orgipn, "Not Supported");
    }
} else {
    if (deregi("INVALID", $reply)) {
        logTransaction("paypal", $orgipn, "Invalid");
        exit;
    }
    logTransaction("paypal", $orgipn, "Error-2");
    exit;
}

?>