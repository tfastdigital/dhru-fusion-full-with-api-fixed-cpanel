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
require_once ROOTDIR . "/includes/imeiservices.fun.php";
include_once ROOTDIR . "/includes/mail.fun.php";
$GATEWAY = loadGatewayModule("paypal");
$postipn = "cmd=_notify-validate";
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
    $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
}
if (!isset($_POST["processfromadmin"])) {
    if ($GATEWAY["SendBox"]) {
        $_paypal_link = "ssl://www.sandbox.paypal.com";
        $urlParsed = parse_url("https://www.sandbox.paypal.com/cgi-bin/webscr");
    } else {
        $_paypal_link = "ssl://www.paypal.com";
        $urlParsed = parse_url("https://www.paypal.com/cgi-bin/webscr");
    }
    $port = fsockopen($_paypal_link, 443, $errno, $errstr, 30);
    if (!$port && !$error) {
        logTransaction("paypal", "No::" . $errno . " Error::" . $errstr, "Error-1 - QC");
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
    if (deregi("VERIFIED", $reply) || deregi("verified", $reply)) {
        logTransaction("paypal", $orgipn, "Verified - QC");
    } else {
        $payment_status = $_POST["payment_status"];
        if (deregi("Completed", $payment_status)) {
            $txn_id = $_POST["txn_id"];
            $idnumber = $_POST["custom"];
            include_once ROOTDIR . "/includes/mail.fun.php";
            $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $idnumber) . "&title=" . base64_encode("View Invoice -" . $idnumber) . "'>here</a>";
            $adminmessage = "Payment received for invoice#" . $idnumber . " .\n            <<br /> But this payer (" . $_POST["payer_email"] . ") is unverified so please\n             review transaction (" . $txn_id . ") and Pay invoice Manualy .\n             <br /><br /> Click " . $here . " to view invoice";
            sendNotification("account", "Unverified transaction [" . $txn_id . "]", $adminmessage, "");
            exit;
        }
        if (deregi("INVALID", $reply)) {
            logTransaction("paypal", $orgipn, "Invalid - QC");
            exit;
        }
        if (deregi("unverified", $reply)) {
            logTransaction("paypal", $orgipn, "Unverified - QC");
            exit;
        }
        logTransaction("paypal", $orgipn, "Error-2 - QC");
        exit;
    }
}
$payment_status = $_POST["payment_status"];
$subscr_id = $_POST["subscr_id"];
$txn_type = $_POST["txn_type"];
$txn_id = $_POST["txn_id"];
$mc_gross = $_POST["mc_gross"];
$mc_fee = $_POST["mc_fee"];
$idnumber = $_POST["custom"];
$tax = $_POST["tax"];
$paypalcurrency = $_REQUEST["mc_currency"];
if ($payment_status == "Pending") {
    logTransaction("paypal", $orgipn, "Pending - QC");
    exit;
}
if ($txn_id && checkTransID($txn_id)) {
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
    logTransaction("paypal", $orgipn, "Unrecognised Currency - QC");
    exit;
}
switch ($txn_type) {
    case "web_accept":
        if ($payment_status != "Completed") {
            logTransaction("paypal", $orgipn, $payment_status . "- QC");
            exit;
        }
        $username = explode("@", $_POST["payer_email"]);
        require_once ROOTDIR . "/includes/clients.fun.inc.php";
        $validator["username"][0] = $username[0];
        $validator["email"][0] = $_POST["payer_email"];
        $validator["first_name"][0] = $_POST["first_name"];
        $validator["last_name"][0] = $_POST["last_name"];
        $validator["country"][0] = $_POST["residence_country"];
        $validator["guest"] = true;
        $cur = mysqli_fetch_assoc(dquery("select id from tbl_currencies \n            where code='" . $_POST["mc_currency"] . "'"));
        $validator["currency"][0] = $cur["id"];
        $validator["language"][0] = $config["language"];
        if (!mysqli_num_rows(dquery("select id from tblUsers where email='" . $_POST["payer_email"] . "'"))) {
            addNewUser($validator, true, "", true, "", "", $emailid = "", "quick");
        }
        $user = mysqli_fetch_assoc(dquery("select id,default_currency from tblUsers where email='" . $_POST["payer_email"] . "'"));
        $order = mysqli_fetch_assoc(dquery("select * from tbl_order_imei where order_id='" . $idnumber . "'"));
        $pass_key = md5($order["time"] . $user["id"] . $order["time"]);
        $serviceDetails = getIMEIServices("", md5($order["service_id"]), $order["user_id"], true);
        $currency = getCurrency("", $order["user_id"]);
        if ($user["default_currency"] != $cur["id"]) {
            $mc_gross = convertCurrency($mc_gross, $cur["id"], $user["default_currency"]);
            $mc_fee = convertCurrency($mc_fee, $cur["id"], $user["default_currency"]);
        }
        dquery("UPDATE tbl_order_imei SET user_id='" . $user["id"] . "',currency_id='" . $user["default_currency"] . "',pass_key='" . $pass_key . "' WHERE order_id='" . $idnumber . "'");
        $adminmessage = "Service Name: " . $serviceDetails["service_name"] . "<br><Br>IMEI :<br><br> ";
        $adminmessage .= "&nbsp;&nbsp;" . $order["imei"] . "<br>";
        $sql = dquery("SELECT first_name, last_name, email FROM tbl_supplier WHERE ( imei_services LIKE '%," . $serviceDetails["id"] . ",%' OR imei_services LIKE '" . $serviceDetails["id"] . ",%' \n                OR imei_services LIKE '%," . $serviceDetails["id"] . "' ) AND imei_service_access = '1' ");
        while ($r = mysqli_fetch_assoc($sql)) {
            $mailto = [$r["email"]];
            sendNotification("supplier", "New IMEI Order", $adminmessage, $mailto);
            $mailto = NULL;
        }
        if (!$serviceDetails["notificationemail"]) {
            $mailto = explode(",", $serviceDetails["notification_mail"]);
            $adminmessage .= "<br /> Username : " . $_ClientsDetails["username"];
            if ($config["adminotice_neworder"] && $config["adminnotice"]) {
            }
        }
        if ($config["smsgateway"] && $serviceDetails["smsnotification"]) {
            $variable["SERVICE"] = $serviceDetails["service_name"];
            sendAdminNotification("system", 4, $variable);
        }
        $paymentmethod = "paypal";
        $serviceDetails = mysqli_fetch_assoc(dquery("select service_name,taxed from tbl_services_imei where id='" . $order["service_id"] . "'"));
        insert_query("tbl_invoiceitems", ["userid" => $user["id"], "type" => "IMEI", "relid" => $idnumber, "description" => $serviceDetails["service_name"], "amount" => $mc_gross, "taxed" => "", "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        require_once ROOTDIR . "/includes/invoice.fun.php";
        $invoiceid = generateInvoice($user["id"]);
        break;
    default:
        if ($invoiceid) {
            logTransaction("paypal", $orgipn, "Successful - QC");
            addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "paypal");
            exit;
        }
        logTransaction("paypal", $orgipn, "Not Supported - QC");
}

?>