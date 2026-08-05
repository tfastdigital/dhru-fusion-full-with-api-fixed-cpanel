<?php
function mercadopago_config() {
    $configarray = array(
        "FriendlyName" => array("Type" => "System", "Value" => "Mercado Pago"),
        "accesstoken" => array("FriendlyName" => "Access Token", "Type" => "text", "Size" => "50"),
        "convertto" => array("FriendlyName" => "Convert To Currency", "Type" => "yesno", "Description" => "Convert to BRL if using another currency"),
        "exchange_rate" => array("FriendlyName" => "Exchange Rate (1 USD = X BRL)", "Type" => "text", "Size" => "10", "Description" => "Leave empty to use system rate if available"),
        "fee" => array("FriendlyName" => "Fee %", "Type" => "text", "Size" => "5", "Description" => "Percentage fee to add"),
        "testmode" => array("FriendlyName" => "Test Mode", "Type" => "yesno")
    );
    return $configarray;
}

function mercadopago_link($params) {
    // Gateway Configuration Parameters
    $accesstoken = $params['accesstoken'];
    $testmode = $params['testmode'];
    
    // Invoice Parameters
    $invoiceid = $params['invoiceid'];
    $description = $params["description"];
    $amount = $params['amount'];
    $currency = $params['currency'];

    // Client Parameters
    $firstname = $params['clientdetails']['firstname'];
    $lastname = $params['clientdetails']['lastname'];
    $email = $params['clientdetails']['email'];
    
    // System Parameters
    $companyname = $params['companyname'];
    $systemurl = $params['systemurl'];
    $returnurl = $params['returnurl'];

    // Conversion Logic
    $payAmount = $amount;
    if ($params['convertto'] == "on" && $currency != 'BRL') {
        $rate = $params['exchange_rate'];
        if (empty($rate) || $rate == 0) {
            // Fallback or fetch from DB if system has rate
            // Assuming rate is provided manually for simplicity or fixed
            $rate = 5.00; // Example fallback
        }
        $payAmount = $amount * $rate;
        $payCurrency = 'BRL';
    } else {
        $payCurrency = $currency;
    }
    
    // Add Fee
    if (isset($params['fee']) && $params['fee'] > 0) {
        $payAmount = $payAmount + ($payAmount * ($params['fee'] / 100));
    }

    $payAmount = number_format($payAmount, 2, '.', '');

    // Create Preference via API
    $url = "https://api.mercadopago.com/checkout/preferences";
    
    $preference_data = array(
        "items" => array(
            array(
                "title" => $description,
                "quantity" => 1,
                "currency_id" => $payCurrency,
                "unit_price" => (float)$payAmount
            )
        ),
        "payer" => array(
            "email" => $email,
            "name" => $firstname,
            "surname" => $lastname
        ),
        "back_urls" => array(
            "success" => $returnurl,
            "failure" => $returnurl,
            "pending" => $returnurl
        ),
        "auto_return" => "approved",
        "external_reference" => $invoiceid,
        "notification_url" => $systemurl . "/modules/gateways/callback/mercadopago.php"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($preference_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer " . $accesstoken,
        "Content-Type: application/json"
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $json = json_decode($response, true);
    
    if (isset($json['init_point'])) {
        $link = $testmode == "on" ? $json['sandbox_init_point'] : $json['init_point'];
        
        $code = '<form action="'.$link.'" method="GET">
            <input type="submit" value="Pagar com Mercado Pago" class="btn btn-primary" />
        </form>';
        return $code;
    } else {
        return 'Error creating preference: ' . ($json['message'] ?? 'Unknown error');
    }
}
?>