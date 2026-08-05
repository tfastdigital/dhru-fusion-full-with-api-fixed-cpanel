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
$GATEWAY = loadGatewayModule("quickpay");
if (!$GATEWAY["paymentmethod"]) {
    exit("Module Not Activated");
}
$status = $_POST["state"];
$invoiceid = $_POST["ordernumber"];
$transid = $_POST["transaction"];
$amount = $_POST["amount"] / 100;
$fee = $_POST["fee"];
foreach ($_POST as $k => $v) {
    $orgipn .= $k . " = " . $v . "<br /> ";
}
if ($invoiceid) {
    $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
    $data = mysqli_fetch_assoc($result);
    $invoiceid = $data["id"];
    $userid = $data["userid"];
}
if ($transid && checkTransID($transid)) {
    exit;
}
if ($userid) {
    if ($status == "1" || $status == "3") {
        logTransaction("quickpay", $orgipn, "Successful");
        $currency = getCurrency("", $userid);
        addPayment($invoiceid, $transid, $amount, $fee, "quickpay");
        exit;
    }
    logTransaction("quickpay", $orgipn, "Unsuccessful");
}

?>