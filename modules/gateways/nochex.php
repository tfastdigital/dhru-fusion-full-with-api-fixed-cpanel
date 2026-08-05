<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function nochex_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Nochex"], "email" => ["Type" => "text", "Name" => "NoChex Merchant ID", "Size" => "50", "Description" => "This is the email you have registered with NoChex"], "hide" => ["Type" => "yesno", "Name" => "Hide Details", "Description" => "Tick to stop customer details being repeated on Nochex payment page"], "testmode" => ["Type" => "yesno", "Name" => "Test Mode", "Description" => "Tick to enable test transaction mode"]];
    return $configarray;
}
function nochex_link($params)
{
    global $lng_languag;
    $code = "<form action=\"https://secure.nochex.com/\" method=\"post\">\r\n<input type=hidden name=merchant_id value=\"" . $params["email"] . "\">\r\n<input type=hidden name=amount value=\"" . formatCurrency2($params["amount"]) . "\">\r\n<input type=hidden name=order_id value=\"" . $params["invoiceid"] . "\">\r\n<input type=hidden name=description value=\"" . $params["description"] . "\">\r\n<input type=hidden name=billing_fullname value=\"" . $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"] . "\">\r\n<input type=hidden name=billing_address value=\"" . $params["clientdetails"]["address1"] . "\r\n" . $params["clientdetails"]["address2"] . "\r\n" . $params["clientdetails"]["city"] . "\r\n" . $params["clientdetails"]["state"] . "\r\n" . $params["clientdetails"]["country"] . "\">\r\n<input type=hidden name=billing_postcode value=\"" . $params["clientdetails"]["postcode"] . "\">\r\n<input type=hidden name=customer_phone_number value=\"" . $params["clientdetails"]["phonenumber"] . "\">\r\n<input type=hidden name=email_address value=\"" . $params["clientdetails"]["email"] . "\">\r\n<input type=hidden name=success_url value=\"" . $params["returnurl"] . "&paymentsuccess=true\">\r\n<input type=hidden name=cancel_url value=\"" . $params["returnurl"] . "&paymentfailed=true\">\r\n<input type=hidden name=decline_url value=\"" . $params["returnurl"] . "&paymentfailed=true\">\r\n<input type=hidden name=responderurl value=\"" . $params["systemurl"] . "/modules/gateways/callback/nochex.php\">\r\n<input type=hidden name=callback_url value=\"" . $params["systemurl"] . "/modules/gateways/callback/nochex.php\">\r\n";
    if ($params["hide"]) {
        $code .= "<input type=hidden name=hide_billing_details value=\"true\">";
    }
    if ($params["testmode"]) {
        $code .= "<input type=hidden name=test_transaction value=\"100\">\r\n<input type=hidden name=test_success_url value=\"" . $params["returnurl"] . "\">";
    }
    $code .= "\r\n<input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\">\r\n</form>";
    return $code;
}

?>