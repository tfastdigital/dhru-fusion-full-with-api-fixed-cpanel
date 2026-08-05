<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
$GATEWAY = loadGatewayModule("paypal");
$postipn = "cmd=_notify-validate";
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
    $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
}
$_paypal_link = "ssl://www.sandbox.paypal.com";
$urlParsed = parse_url("https://www.sandbox.paypal.com/cgi-bin/webscr");
$_paypal_link = "ssl://www.paypal.com";
$urlParsed = parse_url("https://www.paypal.com/cgi-bin/webscr");
$port = fsockopen($_paypal_link, 443, $errno, $errstr, 30);
if (!$port && !$error) {
    logTransaction("paypal", "No::" . $errno . " Error::" . $errstr, "Error-1");
    exit;
}
fputs($port, "POST " . $urlParsed["path"] . " HTTP/1.1\r\n");
fputs($port, "Host: " . $urlParsed["host"] . "\r\n");
fputs($port, "Content-type: application/x-www-form-urlencoded\r\n");
fputs($port, "Content-length: " . strlen($postipn) . "\r\n");
fputs($port, "Connection: close\r\n\r\n");
fputs($port, $postipn . "\r\n\r\n");
while (!feof($port)) {
    $reply .= fgets($port, 1024);
}
fclose($port);
if (deregi("VERIFIED", $reply)) {
    $payment_status = $_POST["payment_status"];
    $subscr_id = $_POST["subscr_id"];
    $txn_type = $_POST["txn_type"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_fee"];
    $idnumber = $_POST["custom"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $item_number = $_POST["item_number"];
    $payer_email = $_POST["payer_email"];
    if ($payment_status == "Pending") {
        logTransaction("paypal", $orgipn, "Pending");
        exit;
    }
    if (!is_numeric($idnumber)) {
        $idnumber = "";
    }
    $result = select_query("tbl_currencies", "", ["code" => $paypalcurrency]);
    $data = mysqli_fetch_assoc($result);
    $paypalcurrencyid = $data["id"];
    $currencyconvrate = $data["rate"];
    if (!$paypalcurrencyid) {
        logTransaction("paypal", $orgipn, "Unrecognised Currency");
        exit;
    }
    switch ($txn_type) {
        case "web_accept":
            if ($payment_status != "Completed") {
                logTransaction("paypal", $orgipn, $payment_status);
                exit;
            }
            $services = explode(",", $item_number);
            $credit = count($services);
            $allowedimei = "";
            foreach ($services as $s) {
                $s = trim($s);
                $ebay = mysqli_fetch_assoc(dquery("select id from tbl_services_imei where ebay_code='" . $s . "'"));
                $allowedimei .= "," . $ebay["id"];
            }
            $allowedimei = trim($allowedimei, ",");
            $sql = dquery("select id from tblUsers where email='" . $payer_email . "'");
            if (!mysqli_num_rows($sql)) {
                $username = explode("@", $payer_email);
                $validator["username"] = [$username[0], true];
                $validator["address1"] = [$_POST["address_street"], true];
                $validator["first_name"] = [$_POST["first_name"], true];
                $validator["country"] = [$_POST["address_country_code"], true];
                $validator["last_name"] = [$_POST["last_name"], true];
                $validator["state"] = [$_POST["address_state"], true];
                if (addNewUser($validator, true, "", true, $credit, $allowedimei, $payer_email)) {
                    $User = mysqli_fetch_assoc(dquery("select id from tblUsers where email='" . $payer_email . "'"));
                }
            } else {
                $User = mysqli_fetch_assoc($sql);
                dquery("update tblUsers set credit_left=credit_left+'" . $credit . "',imei_services='" . $allowedimei . "' WHERE id='" . $User["id"] . "'");
            }
            logTransaction("paypal", $orgipn, $payment_status);
            break;
        default:
            logTransaction("paypal", $orgipn, "Not Supported");
    }
} else {
    if (deregi("INVALID", $reply)) {
        logTransaction("paypal", $orgipn, "Invalid");
        exit;
    }
    logTransaction("paypal", $orgipn, "Error-2");
    exit;
}

?>