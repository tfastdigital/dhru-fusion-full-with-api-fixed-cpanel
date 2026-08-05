<?php
function binancepay_config() {
    return array(
        "FriendlyName" => array("Type" => "System", "Value" => "Binance Pay"),
        "apiKey" => array("FriendlyName" => "API Key", "Type" => "text", "Size" => "50"),
        "secretKey" => array("FriendlyName" => "Secret Key", "Type" => "text", "Size" => "50"),
        "testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno")
    );
}

function binancepay_link($params) {
    $apiKey = $params['apiKey'];
    $secretKey = $params['secretKey'];
    $testmode = $params['testmode'];
    
    $invoiceid = $params['invoiceid'];
    $amount = $params['amount'];
    $currency = $params['currency'];
    $description = $params["description"];
    
    $systemurl = $params['systemurl'];
    $returnurl = $params['returnurl'];

    // Binance Pay API URL
    $baseUrl = "https://bpay.binanceapi.com";
    
    // Generate Random String for Nonce
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $nonce = '';
    for($i=0; $i<32; $i++) $nonce .= $chars[mt_rand(0, strlen($chars)-1)];
    
    $timestamp = round(microtime(true) * 1000);
    
    $request = array(
        "env" => array("terminalType" => "WEB"),
        "merchantTradeNo" => $invoiceid . "_" . time(),
        "orderAmount" => number_format($amount, 2, '.', ''),
        "currency" => $currency,
        "description" => $description,
        "goods" => array(
            "goodsType" => "02",
            "goodsCategory" => "Z000",
            "referenceGoodsId" => $invoiceid,
            "goodsName" => $description,
            "goodsDetail" => "Add Funds"
        ),
        "returnUrl" => $returnurl,
        "cancelUrl" => $returnurl,
        "webhookUrl" => $systemurl . "/modules/gateways/callback/binancepay.php"
    );
    
    $json_request = json_encode($request);
    $payload = $timestamp . "\n" . $nonce . "\n" . $json_request . "\n";
    $signature = strtoupper(hash_hmac('sha512', $payload, $secretKey));
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . "/binancepay/openapi/v2/order");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "BinancePay-Timestamp: $timestamp",
        "BinancePay-Nonce: $nonce",
        "BinancePay-Certificate-SN: $apiKey",
        "BinancePay-Signature: $signature"
    ));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $result = json_decode($response, true);
    curl_close($ch);
    
    if ($result['status'] == 'SUCCESS') {
        $checkoutUrl = $result['data']['checkoutUrl'];
        $code = '<a href="'.$checkoutUrl.'" class="btn btn-warning">Pay with Binance</a>';
        return $code;
    } else {
        return "Binance Pay Error: " . ($result['errorMessage'] ?? 'Unknown error');
    }
}
?>