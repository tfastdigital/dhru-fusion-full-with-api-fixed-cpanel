<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function gsmcoin_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "GsmCoin.com (Accept crypto payments BTC,USDT,GSMC,ETH,etc...)"], "authorization_token" => ["Name" => "authorization_token", "Type" => "text", "Size" => "120", "Description" => "Merchant Authorization Token."], "private_key" => ["Name" => "private_key", "Type" => "text", "Size" => "55", "Description" => "Merchant Private key"]];
    return $configarray;
}
function gsmcoin_link($params)
{
    global $config;
    global $lng_languag;
    global $paygsm;
    global $gsmemail;
    global $gsmpassword;
    if ($paygsm) {
        $POST = [];
        $POST["amount"] = $params["amount"];
        $POST["description"] = $params["description"];
        $POST["customer_name"] = $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"];
        $POST["customer_email"] = $params["clientdetails"]["email"];
        $POST["currency_code"] = $params["curcode"];
        $POST["custom_id"] = $params["invoiceid"];
        $POST["ipn_url"] = $params["systemurl"] . "/modules/gateways/callback/gsmcoin.php";
        $POST["success_url"] = $params["returnurl"] . "?paymentsuccess=true";
        $POST["fail_url"] = $params["returnurl"] . "?paymentfail=true";
        $Header["HEADER"] = ["Content-Type: application/json", "Authorization: Bearer " . $params["authorization_token"]];
        $Resp = initCurl("https://api.gsmcoin.com/checkout/v1/orders", json_encode($POST), $Header);
        $Result = json_decode($Resp, true);
        if ($Result["status"] == "success") {
            $OrderURL = $Result["data"]["order_url"];
            header("Location: " . $OrderURL);
            echo "            <script>\r\n                location.href = '";
            echo $OrderURL;
            echo "';\r\n            </script>\r\n            ";
        } else {
            echo "            <script>\r\n                alert('";
            echo addslashes($Result["message"]);
            echo "');\r\n            </script>\r\n            ";
        }
    }
    $code .= "<form  action='' method='post'>\r\n            <input type='submit' class='btn btn-primary paymentbtn' name='paygsm' value='Pay Now' />\r\n            </form>";
    return $code;
}

?>