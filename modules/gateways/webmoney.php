<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function webmoney_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "WebMoney"], "webmoneyrurpurse" => ["Name" => "WebMoney Purse", "Type" => "text", "Size" => "100"]];
    return $configarray;
}
function webmoney_link($params)
{
    global $config;
    $gatewayusername = $params["username"];
    $gatewaytestmode = $params["testmode"];
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $amount = $params["amount"];
    $duedate = $params["duedate"];
    $rate = $params["webmoneyrurrate"];
    $firstname = $params["clientdetails"]["firstname"];
    $lastname = $params["clientdetails"]["lastname"];
    $email = $params["clientdetails"]["email"];
    $address1 = $params["clientdetails"]["address1"];
    $address2 = $params["clientdetails"]["address2"];
    $city = $params["clientdetails"]["city"];
    $state = $params["clientdetails"]["state"];
    $postcode = $params["clientdetails"]["postcode"];
    $country = $params["clientdetails"]["country"];
    $phone = $params["clientdetails"]["phone"];
    $companyname = $params["companyname"];
    $systemurl = $params["systemurl"];
    $currency = $params["currency"];
    $rate = 1;
    $itogo = round(sprintf("%.2f", $amount) * $rate, 2);
    $code = "<style type=\"text/css\" media=\"all\">\r\n\t\t\t.button {\r\n\t\t\tcolor:#000000;\r\n\t\t\tcursor: pointer;\r\n\t\t\tcursor: hand;\r\n\t\t\theight:20px;\r\n\t\t\tfont-weight:bold;\r\n\t\t\tbackground-color:#ffffff;\r\n\t\t\tborder:1px solid #8FBCE9;\r\n\t\t\tfilter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr='#FFFFFF',EndColorStr='#E5E5E5');}\r\n\t\t\t}\r\n\t\t\t</style>\r\n\t<br>\r\n\t<form action=\"https://merchant.webmoney.ru/lmi/payment.asp\" method=\"POST\">\r\n\t\n<input type=\"hidden\" name=\"LMI_PAYEE_PURSE\" value=\"" . $params["webmoneyrurpurse"] . "\">\r\n  \n<input type=\"hidden\" name=\"LMI_PAYMENT_NO\" value=\"" . $params["invoiceid"] . "\">\r\n   \n<input type=\"hidden\" name=\"LMI_PAYMENT_AMOUNT\" value=\"" . $itogo . "\">\r\n    \n<input type=\"hidden\" name=\"LMI_PAYMENT_DESC\" value=\"Invoice # " . $params["invoiceid"] . "\">\r\n\n<input type=\"hidden\" name=\"LMI_RESULT_URL\" value=\"" . $params["systemurl"] . "\\modules\\gateways\\callback\\webmoneyresult.php\">\r\n \n<input type=\"hidden\" name=\"LMI_SUCCESS_URL\" value=\"" . $params["systemurl"] . "\">\r\n\n<input type=\"hidden\" name=\"LMI_SUCCESS_METHOD\" value=\"1\">\r\n \n<input type=\"hidden\" name=\"LMI_FAIL_URL\" value=\"" . $params["systemurl"] . "\">\r\n\n<input type=\"hidden\" name=\"LMI_FAIL_METHOD\" value=\"1\">\r\n \n<input type=\"submit\"  value=\"" . $params["langpaynow"] . "\" class=\"button btn btn-primary paymentbtn\">\r\n \n</form>";
    return $code;
}

?>