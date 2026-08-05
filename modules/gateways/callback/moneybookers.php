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
$GATEWAY = loadGatewayModule("moneybookers");
header("HTTP/1.1 200 OK");
header("Status: 200 OK");
$idnumber = $_POST["transaction_id"];
$txn_id = $_POST["mb_transaction_id"];
$merchant_id = $_POST["merchant_id"];
$mb_amount = $_POST["mb_amount"];
$amount = $_POST["amount"];
$mb_currency = $_POST["mb_currency"];
$currency = $_POST["currency"];
$md5sig = $_POST["md5sig"];
$status = $_POST["status"];
foreach ($_POST as $k => $v) {
    $buff .= $k . " -" . $v . " \n";
}
if ($txn_id && checkTransID($_POST["mb_transaction_id"])) {
    exit;
}
$result = select_query("tbl_currencies", "", ["code" => $currency]);
$data = mysqli_fetch_assoc($result);
$currencyid = $data["id"];
$currencyconvrate = $data["rate"];
if (!$currencyid) {
    logTransaction("moneybookers", $orgipn, "Unrecognised Currency");
    exit;
}
if ($_POST["status"] == "2") {
    if (!$idnumber) {
        exit;
    }
    $result = select_query("tbl_invoices", "", ["id" => $idnumber]);
    $data = mysqli_fetch_assoc($result);
    $invoiceid = $data["id"];
    $userid = $data["userid"];
    $currency = getCurrency("", $userid);
    if ($currencyid != $currency["id"]) {
        $amount = convertCurrency($amount, $currencyid, $currency["id"]);
        $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
        $data = mysqli_fetch_assoc($result);
        $total = $data["total"];
        if ($total < $amount + 1 && $amount - 1 < $total) {
            $amount = $total;
        }
    }
    addPayment($invoiceid, $txn_id, $amount, "", "moneybookers");
    logTransaction("moneybookers", $orgipn, "Successful");
    exit;
}

?>