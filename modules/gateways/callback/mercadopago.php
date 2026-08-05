<?php
require_once __DIR__ . '/../../../comm.php';
require_once __DIR__ . '/../../../includes/gateway.fun.php';
require_once __DIR__ . '/../../../includes/invoice.fun.php';

$gatewaymodule = "mercadopago";
$GATEWAY = getGatewayVariables($gatewaymodule);

if (!$GATEWAY["type"]) {
    die("Module Not Activated");
}

// Get notification data
$body = @file_get_contents('php://input');
$data = json_decode($body, true);

if (!isset($data['type']) || $data['type'] != 'payment') {
    // Check for topic/id format (older IPN)
    if (isset($_GET['topic']) && $_GET['topic'] == 'payment') {
        $payment_id = $_GET['id'];
    } elseif (isset($_GET['type']) && $_GET['type'] == 'payment') {
        $payment_id = $_GET['data_id'];
    } elseif (isset($data['data']['id'])) {
        $payment_id = $data['data']['id'];
    } else {
        die("Invalid notification");
    }
} else {
    $payment_id = $data['data']['id'];
}

// Verify Payment
$accesstoken = $GATEWAY['accesstoken'];
$url = "https://api.mercadopago.com/v1/payments/" . $payment_id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer " . $accesstoken,
    "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$payment = json_decode($response, true);

if (isset($payment['status']) && $payment['status'] == 'approved') {
    $invoiceid = $payment['external_reference'];
    $transid = $payment['id'];
    $amount = $payment['transaction_amount'];
    $fee = $payment['fee_details'][0]['amount'];

    $invoiceid = checkCbInvoiceID($invoiceid, $GATEWAY["name"]);
    checkCbTransID($transid);

    // Convert back if needed? 
    // Usually Dhru handles the original invoice amount. 
    // We just confirm the payment.
    
    addPayment($invoiceid, $transid, $amount, $fee, $gatewaymodule);
    logTransaction($GATEWAY["name"], $_POST, "Successful");
    echo "HTTP/1.1 200 OK";
} else {
    logTransaction($GATEWAY["name"], $_POST, "Unsuccessful");
    echo "HTTP/1.1 200 OK"; // Always return 200 to MP to stop retries
}
?>