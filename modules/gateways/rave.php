<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function rave_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Rave"], "publickey" => ["Name" => "Public Key", "Type" => "text", "Size" => "50"], "secretkey" => ["Name" => "Secret Key", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function rave_link($params)
{
    $code = "\r\n    <form>\r\n      <script src=\"https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js\"></script>\r\n        <button type=\"button\" class=\"btn btn-primary  paymentbtn\" onClick=\"payWithRave()\">Pay Now</button>\r\n    </form> \r\n    \r\n    <script>\r\n    const API_publicKey = \"" . $params["publickey"] . "\";\r\n    function payWithRave() {\r\n        var x = getpaidSetup({\r\n            PBFPubKey: API_publicKey,\r\n            customer_email: \"" . $params["emailforstripe"] . "\",\r\n            amount: " . $params["amount"] . ",\r\n            customer_phone: \"" . $params["customerphone"] . "\",\r\n            currency: \"" . $params["currency"] . "\",\r\n            txref: \"" . md5($params["invoiceid"]) . "\",\r\n            meta: [{\r\n                metaname: \"INVS\",\r\n                metavalue: \"" . $params["invoiceid"] . "\"\r\n            }],\r\n            onclose: function() {},\r\n            callback: function(response) {\r\n                var txref = response.tx.txRef; // collect txRef returned and pass to a \t\t\t\t\tserver page to complete status check.\r\n               \r\n                if (\r\n                    response.tx.chargeResponseCode == \"00\" ||\r\n                    response.tx.chargeResponseCode == \"0\"\r\n                ) {\r\n                    // redirect to a success page\r\n                   window.location = \"" . $params["returnurl"] . "?txref=\"+txref; //Add your success page here\r\n\r\n                } else {\r\n                    // redirect to a failure page.\r\n                    window.location = \"" . $params["cancelurl"] . "?txref=\"+txref; //Add your success page here\r\n                }\r\n                x.close(); // use this to close the modal immediately after payment.\r\n            }\r\n        });\r\n    }\r\n</script>";
    return $code;
}

?>