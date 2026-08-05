<?php
require_once __DIR__ . '/../../../comm.php';
require_once __DIR__ . '/../../../includes/gateway.fun.php';
require_once __DIR__ . '/../../../includes/invoice.fun.php';

$gatewaymodule = "binancepay";
$GATEWAY = getGatewayVariables($gatewaymodule);

if (!$GATEWAY["type"]) die("Module Not Activated");

$body = file_get_contents('php://input');
$headers = getallheaders();

$timestamp = $headers['BinancePay-Timestamp'];
$nonce = $headers['BinancePay-Nonce'];
$signature = $headers['BinancePay-Signature'];
$secretKey = $GATEWAY['secretKey'];

$payload = $timestamp . "\n" . $nonce . "\n" . $body . "\n";
$calcSignature = strtoupper(hash_hmac('sha512', $payload, $secretKey));

if ($signature === $calcSignature) {
    $data = json_decode($body, true);
    $bizStatus = $data['bizStatus'];
    
    if ($bizStatus == 'PAY_SUCCESS') {
        $data = json_decode($data['data'], true);
        $merchantTradeNo = $data['merchantTradeNo'];
        $transid = $data['transactionId'];
        $amount = $data['totalFee'];
        
        $parts = explode('_', $merchantTradeNo);
        $invoiceid = $parts[0];
        
        $invoiceid = checkCbInvoiceID($invoiceid, $GATEWAY["name"]);
        checkCbTransID($transid);
        addPayment($invoiceid, $transid, $amount, 0, $gatewaymodule);
        logTransaction($GATEWAY["name"], $_POST, "Successful");
        
        echo json_encode(array("returnCode" => "SUCCESS", "returnMessage" => null));
    }
} else {
    logTransaction($GATEWAY["name"], $_POST, "Signature Verification Failed");
    echo json_encode(array("returnCode" => "FAIL", "returnMessage" => "Signature Verification Failed"));
}
?>