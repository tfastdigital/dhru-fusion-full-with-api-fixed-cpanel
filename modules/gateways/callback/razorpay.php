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
$gatewaymodule = "razorpay";
$GATEWAY = loadGatewayModule($gatewaymodule);
if (!$GATEWAY["KeyId"]) {
    exit("Module Not Activated");
}
$key_id = $GATEWAY["KeyId"];
$key_secret = $GATEWAY["KeySecret"];
$merchant_order_id = $_POST["merchant_order_id"];
$razorpay_payment_id = $_POST["razorpay_payment_id"];
$result = select_query("tbl_invoices", "", ["id" => $merchant_order_id]);
$data = mysqli_fetch_assoc($result);
$invoiceid = $data["id"];
$userid = $data["userid"];
if (!$invoiceid) {
    logTransaction($gatewaymodule, $orgipn, "Invalid Invoice ID " . $invoiceid, "invoice", $invoiceid);
    exit;
}
logTransaction("razorpay", $data, "Received", "", "", $invoiceid);
if (mysqli_num_rows(dquery("SELECT * FROM tbl_transaction WHERE  transid LIKE '%" . $razorpay_payment_id . "%'"))) {
    logTransaction($gatewaymodule, $orgipn, "txn found again");
    exit;
}
$success = true;
try {
    $converted_amount = round($data["total"] * 100);
    $url = "https://api.razorpay.com/v1/payments/" . $razorpay_payment_id . "/capture";
    $fields_string = "amount=" . $converted_amount . "&currency=" . $GATEWAY["curcode"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $key_id . ":" . $key_secret);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    logTransaction($gatewaymodule, $orgipn, "Response " . json_encode($result), "invoice", $invoiceid);
    if ($result === false) {
        $success = false;
        $error = "Curl error: " . curl_error($ch);
    } else {
        $response_array = json_decode($result, true);
        if ($http_status === 200 && isset($response_array["error"]) === false) {
            $success = true;
            addPayment($invoiceid, $response_array["id"], round($response_array["amount"] / 100), 0, "razorpay", 1, "", "", "");
            logTransaction($gatewaymodule, $orgipn, "Success", "invoice", $invoiceid);
        } else {
            $success = false;
            if (!empty($response_array["error"]["code"])) {
                $error = $response_array["error"]["code"] . ":" . $response_array["error"]["description"];
            } else {
                $error = "RAZORPAY_ERROR:Invalid Response <br/>" . $result;
            }
        }
    }
    curl_close($ch);
} catch (Exception $e) {
    $success = false;
    $error = "Request to Razorpay Failed";
}
if ($success !== true) {
}
header("Location: " . $GATEWAY["systemurl"] . _url("viewinvoice/id/" . md5($merchant_order_id)));

?>