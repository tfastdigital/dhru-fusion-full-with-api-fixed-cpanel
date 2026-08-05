<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function quickpay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Quickpay"], "merchant" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "30"], "agreementid" => ["Name" => "Agreement ID", "Type" => "text", "Size" => "30"], "apiwindowkey" => ["Name" => "APi window private key", "Type" => "text", "Size" => "60"], "protocol" => ["Name" => "Protocol", "Type" => "dropdown", "Value" => "7", "Options" => "7"], "msgtype" => ["Name" => "Msg type", "Type" => "text", "Value" => "authorize", "Size" => "60"], "language" => ["Name" => "Language", "Type" => "dropdown", "Options" => "da,de,en,es,fi,fr,fo,kl,it,no,nl,pl,sv,ru"], "instructions" => ["Name" => "Payment Instructions", "Type" => "textarea", "Rows" => "5", "Description" => "Write special instructions to customer here"]];
    return $configarray;
}
function quickpay_link($params)
{
    global $config;
    global $lng_languag;
    $orderprefix = "";
    $protocol = $params["protocol"];
    $msgtype = $params["msgtype"];
    $merchant = $params["merchant"];
    $agreementid = $params["agreementid"];
    $apiwindowkey = $params["apiwindowkey"];
    $language = $params["language"];
    $ordernumber = $orderprefix . $params["invoiceid"];
    $amount = str_replace(".", "", $params["amount"]);
    $currency = $params["currency"];
    $continueurl = $params["continueurl"];
    $cancelurl = $params["cancelurl"];
    $callbackurl = $params["systemurl"] . "/modules/gateways/callback/quickpay.php";
    $autocapture = $params["autocapture"];
    $autofee = $params["autofee"];
    $cardtypelock = $params["cardtypelock"];
    $splitpayment = $params["splitpayment"];
    $md5secret = $params["md5secret"];
    $submitlabel = $params["submitlabel"] ? (string) $params["submitlabel"] : "Pay Now";
    $description = $params["description"];
    $firstname = $params["clientdetails"]["firstname"];
    $lastname = $params["clientdetails"]["lastname"];
    $email = $params["clientdetails"]["email"];
    $address1 = $params["clientdetails"]["address1"];
    $address2 = $params["clientdetails"]["address2"];
    $city = $params["client details"]["city"];
    $state = $params["client details"]["state"];
    $postcode = $params["clientdetails"]["postcode"];
    $country = $params["clientdetails"]["country"];
    $phone = $params["clientdetails"]["phonenumber"];
    $companyname = $params["companyname"];
    $systemurl = $params["systemurl"];
    $currency = $params["currency"];
    $SiteAddress = $config["site_address"];
    if ($config["config_ssl_allow"]) {
        $SiteAddress = $config["config_ssl_allow"];
    }
    $continueurl = $SiteAddress . _url("viewinvoice/id/" . md5($ordernumber));
    $cancelurl = $SiteAddress . _url("viewinvoice/id/" . md5($ordernumber));
    $callbackurl = $SiteAddress . "/modules/gateways/callback/quickpay.php";
    $params = ["version" => "v10", "merchant_id" => $merchant, "agreement_id" => $agreementid, "order_id" => $ordernumber, "amount" => $amount, "currency" => $currency, "continueurl" => $continueurl, "cancelurl" => $cancelurl, "callbackurl" => $callbackurl];
    $checksum = sign($params, $apiwindowkey);
    $md5check = md5($protocol . $msgtype . $merchant . $language . $ordernumber . $amount . $currency . $continueurl . $cancelurl . $callbackurl . $autocapture . $autofee . $cardtypelock . $splitpayment . $md5secret);
    $code = "<form action=\"https://secure.quickpay.dk/form/\" method=\"post\">\r\n    <input type=\"hidden\" name=\"protocol\" value=\"" . $protocol . "\" />\r\n    <input type=\"hidden\" name=\"msgtype\" value=\"" . $msgtype . "\" />\r\n    <input type=\"hidden\" name=\"merchant\" value=\"" . $merchant . "\" />\r\n    <input type=\"hidden\" name=\"language\" value=\"" . $language . "\" />\r\n    <input type=\"hidden\" name=\"ordernumber\" value=\"" . $ordernumber . "\" />\r\n    <input type=\"hidden\" name=\"amount\" value=\"" . $amount . "\" />\r\n    <input type=\"hidden\" name=\"currency\" value=\"" . $currency . "\" />\r\n    <input type=\"hidden\" name=\"continueurl\" value=\"" . $continueurl . "\" />\r\n    <input type=\"hidden\" name=\"cancelurl\" value=\"" . $cancelurl . "\" />\r\n    <input type=\"hidden\" name=\"callbackurl\" value=\"" . $callbackurl . "\" />\r\n    <input type=\"hidden\" name=\"autocapture\" value=\"" . $autocapture . "\" />\r\n    <input type=\"hidden\" name=\"autofee\" value=\"" . $autofee . "\" />\r\n    <input type=\"hidden\" name=\"cardtypelock\" value=\"" . $cardtypelock . "\" />\r\n    <input type=\"hidden\" name=\"splitpayment\" value=\"" . $splitpayment . "\" />\r\n    <input type=\"hidden\" name=\"md5check\" value=\"" . $md5check . "\" />\r\n    <input type=\"submit\" class=\"btn-primary btn paymentbtn\" value=\"" . $submitlabel . "\" />\r\n\t</form>";
    $code = "<form method=\"POST\" action=\"https://payment.quickpay.net\">\r\n  <input type=\"hidden\" name=\"version\" value=\"v10\">\r\n  <input type=\"hidden\" name=\"merchant_id\" value=\"" . $merchant . "\">\r\n  <input type=\"hidden\" name=\"agreement_id\" value=\"" . $agreementid . "\">\r\n  <input type=\"hidden\" name=\"order_id\" value=\"" . $ordernumber . "\">\r\n  <input type=\"hidden\" name=\"amount\" value=\"" . $amount . "\">\r\n      <input type=\"hidden\" name=\"autocapture\" value=\"" . $autocapture . "\" />\r\n\r\n  <input type=\"hidden\" name=\"currency\" value=\"" . $currency . "\">\r\n  <input type=\"hidden\" name=\"continueurl\" value=\"" . $continueurl . "\">\r\n  <input type=\"hidden\" name=\"cancelurl\" value=\"" . $cancelurl . "\">\r\n  <input type=\"hidden\" name=\"callbackurl\" value=\"" . $callbackurl . "\">\r\n  <input type=\"hidden\" name=\"checksum\" value=\"" . $checksum . "\">\r\n  <input type=\"submit\" value=\"Pay Now\" class=\"btn btn-primary paymentbtn\">\r\n</form>";
    return $code;
}
function sign($params, $api_key)
{
    $flattened_params = flatten_params($params);
    ksort($flattened_params);
    $base = implode(" ", $flattened_params);
    return hash_hmac("sha256", $base, $api_key);
}
function flatten_params($obj, $result = [], $path = [])
{
    if (is_array($obj)) {
        foreach ($obj as $k => $v) {
            $result = array_merge($result, flatten_params($v, $result, array_merge($path, [$k])));
        }
    } else {
        $result[implode("", array_map(function ($p) {
            return "[" . $p . "]";
        }, $path))] = $obj;
    }
    return $result;
}

?>