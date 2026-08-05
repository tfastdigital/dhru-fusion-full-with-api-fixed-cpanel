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
require "../../../includes/fun.inc.php";
include "../../../includes/gateway.fun.php";
include "../../../includes/invoice.fun.php";
$GATEWAY = loadGatewayModule("vnpay");
$vnp_HashSecret = $GATEWAY["secret"];
$inputData = [];
$returnData = [];
$data = $_REQUEST;
foreach ($data as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
$vnp_SecureHash = $inputData["vnp_SecureHash"];
unset($inputData["vnp_SecureHashType"]);
unset($inputData["vnp_SecureHash"]);
ksort($inputData);
$i = 0;
$hashData = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashData = $hashData . "&" . $key . "=" . $value;
    } else {
        $hashData = $hashData . $key . "=" . $value;
        $i = 1;
    }
}
$txn_id = $inputData["vnp_TransactionNo"];
$vnp_BankCode = $inputData["vnp_BankCode"];
$secureHash = hash("sha256", $vnp_HashSecret . $hashData);
$Status = 0;
$mc_gross = $inputData["vnp_Amount"] / 100;
$mc_fee = 0;
list($orderId) = explode("_", $inputData["vnp_TxnRef"]);
logTransaction("vnpay", $hashData, "Received", "", "", $orderId);
logTransaction("vnpay", $hashData, "Callback Received");
try {
    if ($secureHash == $vnp_SecureHash) {
        if ($inputData["vnp_ResponseCode"] == "00") {
            $Status = 1;
        } else {
            $Status = 2;
        }
        logTransaction("vnpay", $hashData, "Confirm Success");
        if (mysqli_num_rows(dquery("select id from tbl_invoices where (id)='" . $orderId . "'"))) {
            $row = mysqli_fetch_assoc(dquery("select * from tbl_invoices where (id)='" . $orderId . "'"));
            if ($row["status"] == "Unpaid") {
                $userid = $row["userid"];
                $invoiceid = $orderId;
                $vncurrency = $GATEWAY["curcode"];
                $result = select_query("tbl_currencies", "", ["code" => $vncurrency]);
                $data = mysqli_fetch_assoc($result);
                $vncurrencyid = $data["id"];
                $currencyconvrate = $data["rate"];
                $currency = getCurrency("", $userid);
                if ($vncurrencyid != $currency["id"]) {
                    $mc_gross = convertCurrency($mc_gross, $vncurrencyid, $currency["id"]);
                    $mc_fee = convertCurrency($mc_fee, $vncurrencyid, $currency["id"]);
                    $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
                    $data = mysqli_fetch_assoc($result);
                    $total = round($data["total"], 2);
                    if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                        $mc_gross = $total;
                    }
                }
                addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "vnpay", 1, "", "", "");
                header("Location: " . _url("viewinvoice/id/" . md5($orderId) . "?paymentsuccess=true", true));
                exit;
            }
        } else {
            logTransaction("vnpay", $hashData, "Invoice Not found");
        }
    } else {
        logTransaction("vnpay", $hashData, "The cycle does not work 97");
    }
} catch (Exception $e) {
    logTransaction("vnpay", $hashData, "Unknown Error 99");
}
header("Location:" . _url("viewinvoice/id/" . md5($orderId) . "?paymentfailed=true", true));

?>