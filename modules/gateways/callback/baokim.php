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
$GATEWAY = loadGatewayModule("baokim");
$req = "";
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&" . $key . "=" . $value;
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.baokim.vn/bpn/verify");
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
$result = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
if ($result != "" && strstr($result, "VERIFIED") && $status == 200) {
    fwrite($fh, " => VERIFIED");
    $order_id = $_POST["order_id"];
    $transaction_id = $_POST["transaction_id"];
    $transaction_status = $_POST["transaction_status"];
    $payment_type = $_POST["payment_type"];
    $total_amount = $_POST["total_amount"];
    $customer_name = $_POST["customer_name"];
    $customer_address = $_POST["customer_address"];
    logTransaction("baokim", $result, "Received", "", "", $order_id);
    if ($transaction_status == 13) {
        $thongtin = "info:" . $transaction_id . ", Orderid:" . $order_id . ", Ma giao dich BaoKim.VN:" . $transaction_id . ", KieuPay:" . $payment_type . ", Error:" . $error_text . ", Price:" . $total_amount;
        logTransaction("baokim", $thongtin, "Error");
        exit;
    }
    $thongtin = "Giao dich hoan tat dang trong qua trinh kiem tra.";
    logTransaction("baokim", $thongtin, "Successful");
    addPayment($order_id, $transaction_id, $total_amount, "", "baokim");
    exit;
}
$thongtin = "Thanh toan khong duoc xac thuc";
logTransaction("baokim", $thongtin, "Error");
if ($error) {
    $thongtin = "Thanh toan loi.";
    logTransaction("baokim", $thongtin, "Error");
}

?>