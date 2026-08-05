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
$GATEWAY = loadGatewayModule("googlecheckout");
$xml_response = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents("php://input");
if (get_magic_quotes_gpc()) {
    $xml_response = stripslashes($xml_response);
}
$xmldata = XMLtoArray($xml_response);
if (is_array($xmldata["CHARGE-AMOUNT-NOTIFICATION"])) {
    $ordernumber = $xmldata["CHARGE-AMOUNT-NOTIFICATION"]["GOOGLE-ORDER-NUMBER"];
    $amount = $xmldata["CHARGE-AMOUNT-NOTIFICATION"]["LATEST-CHARGE-AMOUNT"];
    $fee = $xmldata["CHARGE-AMOUNT-NOTIFICATION"]["LATEST-CHARGE-FEE"]["TOTAL"];
    $data = mysqli_fetch_assoc(dquery("SELECT data FROM \n    tbl_gatewaylog WHERE gateway='Google Checkout' \n    AND data LIKE '%new-order-notification%" . $ordernumber . "%'"));
    $gatewaylogdata = $data["data"];
    $orderxml = XMLtoArray($gatewaylogdata);
    $invoiceid = $orderxml["NEW-ORDER-NOTIFICATION"]["SHOPPING-CART"]["ITEMS"]["ITEM"]["MERCHANT-ITEM-ID"];
    if (deregi("QUICK", $invoiceid)) {
        $e = explode("-", $invoiceid);
        $orderid = $e[1];
        $name = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["CONTACT-NAME"];
        $payeremail = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["EMAIL"];
        $country = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["COUNTRY-CODE"];
        $address1 = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["ADDRESS1"];
        $city = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["CITY"];
        $state = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["REGION"];
        $zip = $orderxml["NEW-ORDER-NOTIFICATION"]["BUYER-BILLING-ADDRESS"]["POSTAL-CODE"];
        $curcode = substr($gatewaylogdata, strrpos($gatewaylogdata, "currency") + 10, 3);
        $mc_gross = $amount;
        $mc_fee = $fee;
        $username = explode("@", $payeremail);
        require_once ROOTDIR . "/includes/clients.fun.inc.php";
        $validator["username"][0] = $username[0];
        $validator["email"][0] = $payeremail;
        $validator["first_name"][0] = $name;
        $validator["city"][0] = $city;
        $validator["state"][0] = $state;
        $validator["zip"][0] = $zip;
        $validator["address1"][0] = $address1;
        $validator["country"][0] = $country;
        $cur = mysqli_fetch_assoc(dquery("select id from \n            tbl_currencies where code='" . $curcode . "'"));
        $validator["currency"][0] = $cur["id"];
        $validator["language"][0] = $config["language"];
        if (!mysqli_num_rows(dquery("select id from tblUsers where email='" . $payeremail . "'"))) {
            addNewUser($validator, true, "", true, "", "", $emailid = "");
        }
        $user = mysqli_fetch_assoc(dquery("select id,default_currency \n                        from tblUsers where email='" . $payeremail . "'"));
        $order = mysqli_fetch_assoc(dquery("select * from tbl_order_imei where order_id='" . $orderid . "'"));
        $pass_key = md5($order["time"] . $user["id"] . $order["time"]);
        $serviceDetails = getIMEIServices("", md5($order["service_id"]), $order["user_id"], true);
        $currency = getCurrency("", $order["user_id"]);
        if ($user["default_currency"] != $cur["id"]) {
            $mc_gross = convertCurrency($mc_gross, $cur["id"], $user["default_currency"]);
            $mc_fee = convertCurrency($mc_fee, $cur["id"], $user["default_currency"]);
        }
        dquery("UPDATE tbl_order_imei SET credit=" . $mc_gross . ",discount='0'\n                     WHERE order_id='" . $orderid . "'");
        dquery("UPDATE tbl_order_imei SET user_id='" . $user["id"] . "',\n                currency_id='" . $user["default_currency"] . "',pass_key='" . $pass_key . "' WHERE order_id='" . $orderid . "'");
        $adminmessage = "Service Name: " . $serviceDetails["service_name"] . "<br><Br>IMEI :<br><br> ";
        $adminmessage .= "&nbsp;&nbsp;" . $order["imei"] . "<br>";
        $sql = dquery("SELECT first_name, last_name, \n                email FROM tbl_supplier WHERE ( imei_services LIKE '%," . $serviceDetails["id"] . ",%' \n                OR imei_services LIKE '" . $serviceDetails["id"] . ",%' \n                OR imei_services LIKE '%," . $serviceDetails["id"] . "' ) AND imei_service_access = '1' ");
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
        $paymentmethod = "googlecheckout";
        $serviceDetails = mysqli_fetch_assoc(dquery("select \n            service_name,taxed from tbl_services_imei where id='" . $order["service_id"] . "'"));
        insert_query("tbl_invoiceitems", ["userid" => $user["id"], "type" => "IMEI", "relid" => $orderid, "description" => $serviceDetails["service_name"], "amount" => $mc_gross, "taxed" => "", "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        require_once ROOTDIR . "/includes/invoice.fun.php";
        $invoiceid = generateInvoice($user["id"]);
        if ($invoiceid) {
            logTransaction("paypal", $orgipn, "Successful - QC");
            addPayment($invoiceid, $ordernumber, $mc_gross, $mc_fee, "googlecheckout");
        }
        exit;
    }
    checkTransID($ordernumber);
    if ($GATEWAY["convertto"]) {
        $data = mysqli_fetch_assoc(select_query("tbl_invoices", "userid,total", ["id" => $invoiceid]));
        $userid = $data["userid"];
        $total = $data["total"];
        $currency = getCurrency("", $userid);
        $amount = convertCurrency($amount, $GATEWAY["convertto"], $currency["id"]);
        $fee = convertCurrency($fee, $GATEWAY["convertto"], $currency["id"]);
        if ($total < $amount + 1 && $amount - 1 < $total) {
            $amount = $total;
        }
    }
    addPayment($invoiceid, $ordernumber, $amount, $fee, "googlecheckout");
    logTransaction("Google Checkout", $xml_response, "Successful");
} else {
    logTransaction("Google Checkout", $xml_response, "Status Update");
}
function XMLtoArray($rawxml)
{
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
    xml_parser_free($xml_parser);
    $params = [];
    $level = [];
    $alreadyused = [];
    $x = 0;
    foreach ($vals as $xml_elem) {
        if ($xml_elem["type"] == "open") {
            if (in_array($xml_elem["tag"], $alreadyused)) {
                $x++;
                $xml_elem["tag"] = $xml_elem["tag"] . $x;
            }
            $level[$xml_elem["level"]] = $xml_elem["tag"];
            $alreadyused[] = $xml_elem["tag"];
        }
        if ($xml_elem["type"] == "complete") {
            $start_level = 1;
            for ($php_stmt = "\$params"; $start_level < $xml_elem["level"]; $start_level++) {
                $php_stmt .= "[\$level[" . $start_level . "]]";
            }
            $php_stmt .= "[\$xml_elem['tag']] = \$xml_elem['value'];";
            eval($php_stmt);
        }
    }
    return $params;
}

?>