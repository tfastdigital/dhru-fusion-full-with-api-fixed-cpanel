<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "includes/fun.inc.php";
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/includes/mail.fun.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$adminAddPayment = true;
if ($save && $payer_email && $mc_gross != "" && $txn_id) {
    $txn_type = $_POST["txn_type"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_gross"];
    $idnumber = $_POST["custom"];
    $tax = $_POST["tax"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $username = explode("@", $_POST["payer_email"]);
    require_once ROOTDIR . "/includes/clients.fun.inc.php";
    $validator["username"][0] = $username[0];
    $validator["email"][0] = $_POST["payer_email"];
    $validator["first_name"][0] = $_POST["first_name"];
    $validator["last_name"][0] = $_POST["last_name"];
    $validator["country"][0] = $_POST["residence_country"];
    $cur = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='" . $_POST["mc_currency"] . "'"));
    $validator["currency"][0] = $cur["id"];
    $validator["language"][0] = $config["language"];
    if (!mysqli_num_rows(dquery("select id from tblUsers where email='" . $_POST["payer_email"] . "'"))) {
        addNewUser($validator, true, "", true, "", "", $emailid = "");
    }
    $user = mysqli_fetch_assoc(dquery("select id from tblUsers where email='" . $_POST["payer_email"] . "'"));
    $order = mysqli_fetch_assoc(dquery("select * from tbl_order_imei where order_id='" . $idnumber . "'"));
    $pass_key = md5($order["time"] . $user["id"] . $order["time"]);
    dquery("UPDATE tbl_order_imei SET user_id='" . $user["id"] . "',currency_id='" . $cur["id"] . "',pass_key='" . $pass_key . "' WHERE order_id='" . $idnumber . "'");
    $serviceDetails = getIMEIServices("", md5($order["service_id"]), $order["user_id"], true);
    $adminmessage = "Service Name: " . $serviceDetails["service_name"] . "<br><Br>IMEI :<br><br> ";
    $adminmessage .= "&nbsp;&nbsp;" . $order["imei"] . "<br>";
    $sql = dquery("SELECT first_name, last_name, email FROM tbl_supplier\n         WHERE ( imei_services LIKE '%," . $serviceDetails["id"] . ",%' OR imei_services LIKE '" . $serviceDetails["id"] . ",%' \n        OR imei_services LIKE '%," . $serviceDetails["id"] . "' ) AND imei_service_access = '1' ");
    while ($r = mysqli_fetch_assoc($sql)) {
        $mailto = [$r["email"]];
        sendNotification("supplier", "New Order by IMEI Quick checkout", $adminmessage, $mailto);
        $mailto = NULL;
    }
    if (!$serviceDetails["notificationemail"]) {
        $mailto = explode(",", $serviceDetails["notification_mail"]);
        $adminmessage .= "<br /> Username : " . $_ClientsDetails["username"];
        if ($config["adminotice_neworder"] && $config["adminnotice"]) {
            sendNotification("system", "New Order by IMEI Quick checkout", $adminmessage, $mailto);
        }
    }
    if ($config["smsgateway"] && $serviceDetails["smsnotification"]) {
        $variable["SERVICE"] = $serviceDetails["service_name"];
        sendAdminNotification("system", 4, $variable);
    }
    $paymentmethod = $order["gateway"];
    $serviceDetails = mysqli_fetch_assoc(dquery("select service_name,taxed from tbl_services_imei where id='" . $order["service_id"] . "'"));
    if ($mc_gross != 0) {
        insert_query("tbl_invoiceitems", ["userid" => $user["id"], "type" => "IMEI", "relid" => $idnumber, "description" => $serviceDetails["service_name"], "amount" => $order["credit"] - $order["discount"] + $order["tax"], "taxed" => 0, "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        require_once ROOTDIR . "/includes/invoice.fun.php";
        $invoiceid = generateInvoice($user["id"]);
        $result = select_query("tbl_invoices", "", ["id" => $invoiceid]);
        $data = mysqli_fetch_assoc($result);
        $invoiceid = $data["id"];
        $userid = $data["userid"];
        if ($invoiceid) {
            $currency = getCurrency("", $userid);
            if ($paypalcurrencyid != $currency["id"]) {
                $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
                $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
                $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
                $data = mysqli_fetch_assoc($result);
                $total = $data["total"];
                if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                    $mc_gross = $total;
                }
            }
            addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, $order["gateway"]);
            echo "<div id='notification1' class='successbox'>" . $LNG["order"] . " " . $LNG["processed"] . " " . $LNG["successfully"] . "</div>";
        }
    } else {
        dquery("UPDATE tbl_order_imei SET user_can_c='0' WHERE order_id='" . $idnumber . "'");
    }
} else {
    if ($save) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    }
}
$sql = mysqli_fetch_assoc(dquery("select *,(select code from tbl_currencies where\nid=currency_id) as cod from tbl_order_imei where order_id='" . $id . "'"));
if ($sql["user_can_c"] != 6) {
    echo "Order Processed !";
    exit;
}
echo " \n<div id=\"content\">\n<div id=\"notification1\" class=\"info\">Note : Here you can manually process unprocessed Orders </div>\n<form id=\"frmnetwork\" name=\"\" method=\"post\" >\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"custom\"/>\n<input type=\"hidden\" value=\"";
echo $sql["tax"];
echo "\" name=\"tax\"/>\n<input type=\"hidden\" name=\"txn_type\" value=\"web_accept\" />\n";
$pa = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways \nwhere gateway='" . $sql["gateway"] . "' and setting='curcode'"));
echo "<input type=\"hidden\" name=\"mc_currency\" value=\"";
echo $pa["value"];
echo "\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">Pending Order</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table class=\"form\">\n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td><td  class=\"fieldarea\"><input type=\"text\" name=\"payer_email\" /> *</td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["invoicestransid"];
echo "</td><td  class=\"fieldarea\"><input type=\"text\" name=\"txn_id\" /> *</td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["order"];
echo " ";
echo $LNG["amount"];
echo "</td>\n<td  class=\"fieldarea\"><input type=\"hidden\" name=\"mc_gross\" \nvalue=\"";
echo round($sql["credit"] - $sql["discount"] + $sql["tax"], 2);
echo "\" />";
echo round($sql["credit"] - $sql["discount"] + $sql["tax"], 2);
echo $pa["value"];
echo " </td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["gateway"];
echo "</td><td  class=\"fieldarea\">\n";
$gt = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='" . $sql["gateway"] . "'\nand setting='name'"));
echo $gt["value"];
echo "</td></tr>\n\n<tr><td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td><td  class=\"fieldarea\"><input type=\"text\" name=\"first_name\" /></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td><td  class=\"fieldarea\"><input type=\"text\" name=\"last_name\" /></td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td><td  class=\"fieldarea\">";
echo str_replace("name=\"country\"", "name=\"residence_country\"", getCountriesDropDown());
echo "</td></tr>\n\n<tr><td></td><td  class=\"fieldarea\"><input value=\"";
echo $LNG["manual"];
echo " ";
echo $LNG["process"];
echo "\" name=\"save\" id=\"btnedituser\" class=\"btn save\" type=\"submit\" /></td></tr>\n</tbody></table>\n\n</div></div>\n\n\n\n</form>\n</div>\n";
$fileverioncheck = "6.1.0";

?>