<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/products.fun.php";
require_once ROOTDIR . "/includes/shipping.fun.php";
if (!function_exists(getCustomFields)) {
    require_once "../includes/customfield.fun.inc.php";
}
$flagii = false;
if ($save && $payer_email && $mc_gross != "" && $txn_id) {
    $txn_type = $_POST["txn_type"];
    $txn_id = $_POST["txn_id"];
    $mc_gross = $_POST["mc_gross"];
    $mc_fee = $_POST["mc_gross"];
    $idnumber = $_POST["custom"];
    $tax = $_POST["tax"];
    $paypalcurrency = $_REQUEST["mc_currency"];
    $username = explode("@", $_POST["payer_email"]);
    require_once "../../../includes/clients.fun.inc.php";
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
        require_once "../../../includes/invoice.fun.php";
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
        }
    } else {
        dquery("UPDATE tbl_order_imei SET user_can_c='0' WHERE order_id='" . $idnumber . "'");
    }
} else {
    if ($save) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
    }
}
$prod = dquery("SELECT *,gift,\n(SELECT bundle FROM tbl_products WHERE id=service_id) as bun,user_id,\n        (SELECT service_name FROM tbl_products WHERE id=service_id) as service,\n        (SELECT code FROM tbl_currencies where id=(select default_currency from tblUsers where id=user_id)) as code ,\n        (select value from tbl_shipping_services where id=gatway) as gatway\n         from tbl_order_product where invoiceid='" . $id . "' order by order_id");
if ($shows && $secretkey == $adminsecret_key) {
    $flagii = true;
    $gst = mysqli_fetch_assoc(dquery("SELECT user_id\n         from tbl_order_product where invoiceid='" . $id . "'"));
    $usr = mysqli_fetch_assoc(dquery("select cardtype,cardlastfour,\n        AES_DECRYPT(cardnum,'" . $ccenckey . "') as cardno,\n        AES_DECRYPT(startdate,'" . $ccenckey . "') as stdt,\n        AES_DECRYPT(expdate,'" . $ccenckey . "') as expdt, \n        AES_DECRYPT(ccv,'" . $ccenckey . "') as ccv FROM tblUsers WHERE id='" . $gst["user_id"] . "'"));
}
echo "<div id=\"notification1\"></div>\n<h1 style=\"font-size: 12px;color: #666; text-decoration: none;\">";
echo $LNG["invoice"];
echo " : #";
echo $id;
echo "\n</h1>\n<form method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"";
echo $loaddefaultpage;
echo "\" />\n<table id=\"main_tbl\" >\n<thead>\n\n<th>";
echo $LNG["product"];
echo "</th>\n<th>";
echo $LNG["price"];
echo "</th>\n\n</thead>\n<tbody>\n    ";
while ($det = mysqli_fetch_assoc($prod)) {
    echo "        <tr class=\"fieldlable\"><td > &#45;&#45;";
    echo $det["service"];
    echo " ";
    if ($det["bun"]) {
        echo " [<strong>" . $LNG["bundle"] . "</strong>]";
    }
    echo " ";
    if ($det["gift"]) {
        echo " [<strong>" . $LNG["gift"] . "</strong>]";
    }
    echo "       \n        </td><td>";
    echo $det["credit"] - $det["discount"];
    echo " ";
    echo $det["code"];
    echo "</td>\n        \n        </tr>\n    ";
}
echo "</tbody>\n</table>\n</form>\n\n<style>\n#content table td{text-align: left !important;}\n#content table{width: 600px;}\nhr{border: none;border-bottom: silver solid 1px;}\n</style>\n\n<div id=\"content\" style=\"border: silver solid 1px;padding: 10px;\">\n\n\n\n";
if ($flagii) {
    echo "    <table border=\"0\"  cellspacing=\"0\" cellpadding=\"4\" >\n    <tr>\n    <td  width=\"30%\">";
    echo $LNG["creditcard"];
    echo " ";
    echo $LNG["number"];
    echo "</td>\n    <td>";
    echo $usr["cardno"];
    echo "</td>\n    </tr>\n    <tr>\n    <td  width=\"30%\">";
    echo $LNG["creditcard"];
    echo " ";
    echo $LNG["type"];
    echo "</td>\n    <td>";
    echo $usr["cardtype"];
    echo "</td>\n    </tr>\n   <tr>\n    <td  width=\"30%\">";
    echo $LNG["start"];
    echo " ";
    echo $LNG["date"];
    echo "</td>\n   <td>";
    echo $usr["stdt"];
    echo "</td>\n    </tr>\n    <tr>\n    <td  width=\"30%\">";
    echo $LNG["expiry"];
    echo " ";
    echo $LNG["date"];
    echo "</td>\n    <td>";
    echo $usr["expdt"];
    echo "</td>\n    </tr>   \n    <tr>\n    <td  width=\"30%\">CCV</td>\n    <td>";
    echo $usr["ccv"];
    echo "</td>\n    </tr>\n   \n    </table>\n    \n   <br /><br /> \n<form id=\"frmnetwork\" name=\"\" method=\"post\" >\n<input type=\"hidden\" value=\"";
    echo $id;
    echo "\" name=\"id\"/>\n\n";
    echo generate_token("form");
    echo "\n<table id=\"main_tbl\" style=\"display: table; float: left; width: 450px !important;\">\n<tbody>\n<tr><td>";
    echo $LNG["invoicestransid"];
    echo "</td><td><input type=\"text\" name=\"txn_id\" /></td></tr>\n<tr><td>";
    echo $LNG["order"];
    echo " ";
    echo $LNG["amount"];
    echo "</td>\n<td><input type=\"hidden\" \nname=\"mc_gross\" value=\"";
    echo $sql["credit"] - $sql["discount"] + $sql["tax"];
    echo "\" />\n";
    echo $sql["credit"] - $sql["discount"] + $sql["tax"];
    echo $pa["value"];
    echo " </td></tr>\n\n</tbody>\n</table>\n<p align=\"left\" style=\"clear: both;\" >\n<input value=\"";
    echo $LNG["process"];
    echo " ";
    echo $LNG["order"];
    echo "\" name=\"save\" id=\"btnedituser\" class=\"submit\" type=\"submit\" /></p>\n\n</form>\n";
} else {
    echo "<form method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n    <table border=\"0\"  cellspacing=\"0\" cellpadding=\"4\" >\n    <tr>\n    <td  width=\"30%\">";
    echo $LNG["enter"];
    echo " ";
    echo $LNG["secret"];
    echo " ";
    echo $LNG["key"];
    echo "</td>\n    <td><input type=\"text\" name=\"secretkey\" /></td>\n    </tr>\n    <tr>\n    <td  width=\"30%\">&nbsp;</td>\n    <td><input type=\"submit\" name=\"shows\" value=\"Show Credit Card Information\" /></td>\n    </tr>\n    </table>\n    </form>\n";
}
echo "    \n\n\n</div>\n\n\n</div>";
$fileverioncheck = "6.1.0";

?>