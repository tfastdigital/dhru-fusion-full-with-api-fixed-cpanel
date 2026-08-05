<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function razorpay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Razorpay India (Credit Card/Debit Card/Net Banking)"], "KeyId" => ["FriendlyName" => "Key Id", "Type" => "text", "Size" => "50", "Description" => "Enter your Razorpay Key Id here"], "KeySecret" => ["FriendlyName" => "Key Secret", "Type" => "text", "Size" => "50", "Description" => "Enter your Razorpay Key Secret here"]];
    return $configarray;
}
function razorpay_link($params)
{
    global $config;
    $key_id = $params["KeyId"];
    $key_secret = $params["KeySecret"];
    $order_id = $params["invoiceid"];
    $description = $params["description"];
    $amount = round($params["amount"], 2) * 100;
    $currency = $params["currency"];
    $customer_name = $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"];
    $customer_email = $params["clientdetails"]["email"];
    $customer_phone = $params["clientdetails"]["phonenumber"];
    $name = $config["companyname"];
    $companyname = "razorpay";
    $checkoutURL = "https://checkout.razorpay.com/v1/checkout.js";
    $callbackURL = $params["systemurl"] . "/modules/gateways/callback/razorpay.php";
    $html = "<form name=\"razorpay-form\" id=\"razorpay-form\" action=\"" . $callbackURL . "\" method=\"POST\" onSubmit=\"if(!razorpay_open) razorpaySubmit(); return razorpay_submit;\">\n                <input type=\"hidden\" name=\"razorpay_payment_id\" id=\"razorpay_payment_id\" />\n                <input type=\"hidden\" name=\"merchant_order_id\" id=\"order_id\" value=\"" . $order_id . "\"/>\n                <input type=\"button\" class=\"btn btn-primary paymentbtn\" value=\"Click Here to Pay\" onClick=\"razorpaySubmit()\"/>\n            </form>";
    $js = "<script src=\"" . $checkoutURL . "\"></script>";
    $js .= "<script>\n            var razorpay_open = false;\n            var razorpay_submit = false;\n            var razorpay_options = {\n                'key': '" . $key_id . "',\n                'amount': '" . $amount . "',\n                'currency': '" . $currency . "',\n                'name': '" . $name . "',\n                'description': '" . $description . "',\n                'handler': function (transaction) {\n                    razorpay_submit = true;\n                    document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;\n                    document.getElementById('razorpay-form').submit();\n                },\n                'prefill': {\n                    'name': '" . $customer_name . "',\n                    'email': '" . $customer_email . "',\n                    'contact': '" . $customer_phone . "'\n                },\n                notes: {\n                    'dhru_fusion_order_id': '" . $order_id . "'\n                },\n                netbanking: true\n            };\n            \n            function razorpaySubmit(){                  \n                var rzp1 = new Razorpay(razorpay_options);\n                rzp1.open();\n                razorpay_open = true;\n                rzp1.modal.options.backdropClose = false;\n            }    \n\n            </script>";
    return $html . $js;
}

?>