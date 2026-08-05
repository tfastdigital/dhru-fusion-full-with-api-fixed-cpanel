<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
if (!isset($_SESSION[adminid])) {
    exit;
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
require_once ROOTDIR . "/includes/gateway.fun.php";
if (!$invoice_info) {
    $invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices` WHERE `id`='" . $id . "' "));
}
$clientDetails = getClientsDetails($invoice_info["userid"]);
$payment = mysqli_num_rows(dquery("select value from \ntbl_paymentgateways where gateway='" . $invoice_info["paymentmethod"] . "' and setting='name'"));
if ($invoice_info["onholdreason"]) {
    echo "<div id='notification1' class='info'>" . $invoice_info["onholdreason"] . "</div>";
}
$GATEWAY = loadGatewayModule($invoice_info["paymentmethod"]);
$_client_id = $GATEWAY["clientid"];
$_secret = $GATEWAY["secretkey"];
if ($GATEWAY["testmode"]) {
    $_url = "https://api.sandbox.paypal.com";
} else {
    $_url = "https://api.paypal.com";
}
$_token = base64_encode($_client_id . ":" . $_secret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $_url . "/v2/checkout/orders/" . $invoice_info["exorderid"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = ["Content-Type: application/json"];
curl_setopt($ch, CURLOPT_USERPWD, $_client_id . ":" . $_secret);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec($ch);
curl_close($ch);
$orderdetail = json_decode($server_output, true);
if ($orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "COMPLETED" || $orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "CREATED") {
    $payment_status = "AUTHORIZED";
}
if ($orderdetail["purchase_units"][0]["payments"]["authorizations"][0]["status"] === "VOIDED") {
    $payment_status = "VOID";
}
if ($orderdetail["purchase_units"][0]["payments"]["captures"][0]["status"] === "COMPLETED") {
    $payment_status = "PAID";
}
if ($orderdetail["purchase_units"][0]["payments"]["refunds"][0]["status"] === "COMPLETED") {
    $payment_status = "REFUNDED";
}
echo "<div id=\"notification\"></div>\n<script>\n    function RefundCall(){\n        if(\$('#iknow').prop('checked')){\n                \$(\"#btnrefund\").prop('disabled',false);\n        }else{\n\n        }\n    }\n</script>\n<div class=\"groupstabes\">\n    <div class=\"groupstabescontant\">\n        <div id=\"content\">\n            <div id=\"content_padded\">\n\n\n                <h2>\n                    <span>KYC Details</span>\n                </h2>\n\n                <div  style=\"float: left;padding-right:40px\">\n\n";
$doc = mysqli_fetch_assoc(dquery("select * from tbl_document where uid='" . $invoice_info["userid"] . "'"));
$DocContent = base64_encode(file_get_contents("../" . $donloaddirpath . "/" . $doc["document"]));
$StatContent = base64_encode(file_get_contents("../" . $donloaddirpath . "/" . $doc["statement"]));
echo "                    <table>\n                        <tr><td> <a  href=\"javascript:load_fromsubpage('edituser&id=";
echo $clientDetails["id"];
echo "',' ";
echo $clientDetails["username"];
echo "')\">";
echo $clientDetails["username"];
echo "</a></td></tr>\n                        <tr><td>";
echo $clientDetails["firstname"];
echo " ";
echo $clientDetails["lastname"];
echo "</td></tr>\n                        <tr><td>";
echo $doc["city"] . " " . $doc["pin"];
echo " </td></tr>\n                        <tr><td>";
echo $doc["state"];
echo " </td></tr>\n                        <tr><td>";
echo $doc["country"];
echo " </td></tr>\n                        <tr><td>Phone: ";
echo $doc["contact"];
echo " </td></tr>\n                        <tr><td>";
echo $doc["email"];
echo " </td></tr>\n                        <tr><td><a style=\"border-bottom: #ccc solid 1px\" href=\"includes/download.php?action=idverifacation&id=";
echo $doc["id"];
echo "\"><i class=\"fa fa-download\"></i> ";
echo $doc["doctype"];
echo "</a></td></tr>\n                        ";
if ($doc["statement"]) {
    echo "                        <tr><td><a style=\"border-bottom: #ccc solid 1px\" href=\"includes/download.php?action=idstatement&id=";
    echo $doc["id"];
    echo "\"><i class=\"fa fa-download\"></i> Statement</a></td></tr>\n                        ";
}
echo "                    </table>\n\n                </div>\n\n\n                <div style=\"padding-right: 1rem; float: left\" >\n\n\n                    <a href=\"#\"    onclick=\"inlinePopup('#large-image','KYC Details');\">\n                        <img   style=\"max-width: 200px;cursor:pointer\"  src=\"data:image/png;base64,";
echo $DocContent;
echo "\">\n                    </a>\n                    <div id=\"large-image\" style=\"display:none\">\n                        <div style=\"display: flex;width:100%;align-items: center;vertical-align: middle;height: 100%;\">\n\n                                <img style=\"max-width: 100%;margin: auto\"  src=\"data:image/png;base64,";
echo $DocContent;
echo "\">\n\n                        </div>\n                    </div>\n                </div>\n                ";
if ($doc["statement"]) {
    echo "                <div style=\"padding-right: 1rem; float:left; padding-left: 20px\" >\n\n\n                    <a href=\"#\"    onclick=\"inlinePopup('#large-image','KYC Details');\">\n                        <img   style=\"max-width: 200px;cursor:pointer\"  src=\"data:image/png;base64,";
    echo $StatContent;
    echo "\">\n                    </a>\n\n                    <div id=\"large-image\" style=\"display:none\">\n                        <div style=\"display: flex;width:100%;align-items: center;vertical-align: middle;height: 100%;\">\n\n                            <img style=\"max-width: 100%;margin: auto\"  src=\"data:image/png;base64,";
    echo $StatContent;
    echo "\">\n\n                        </div>\n                    </div>\n\n                </div>\n                    ";
}
echo "\n                </div>\n            <div style=\"clear:both\">&nbsp;</div>\n            <div  style=\"border-right: rgba(0,0,0,0.1) solid 1px; \">\n                <hr />\n                ";
$tranaction = mysqli_fetch_assoc(dquery("select \n*,(select `value` from tbl_paymentgateways where tbl_paymentgateways.gateway=tbl_transaction.gateway and setting='name') as gatewayname from tbl_transaction\nwhere invoiceid='" . $id . "'"));
echo "                <h2>Payment Detail</h2>\n                <table id=\"main_tbl\" >\n            <thead>\n            <tr>\n                <th>Method</th>\n                <th>Amount</th>\n                <th>Date</th>\n                <th>Transaction ID</th>\n            </tr>\n            </thead>\n                <tr>\n                        <td>";
echo $tranaction["gatewayname"];
echo "</td>\n                        <td>";
echo $tranaction["amountin"];
echo "</td>\n                        <td>";
echo $tranaction["date"];
echo "</td>\n                        <td>";
echo $tranaction["transid"];
echo "</td>\n\n                    </tr>\n\n                </table>\n            </div>\n            <div  style=\"border-right: rgba(0,0,0,0.1) solid 1px; \">\n\n                ";
if ($tranaction["gateway"] == "paypalexpress") {
    if ($tranaction["note"]) {
        $Payer = json_decode($tranaction["note"], true);
        echo "                    <hr />\n                    <h2>Payer Detail</h2>\n                    <table>\n                        <tr><td>Name</td><td>";
        echo $Payer["name"]["given_name"] . " " . $Payer["name"]["surname"];
        echo "</td></tr>\n                        <tr><td>Payer ID</td><td>";
        echo $Payer["payer_id"];
        echo "</td></tr>\n                        <tr><td>Email</td><td>";
        echo $Payer["email_address"];
        echo "</td></tr>\n                        <tr><td>Country</td><td>";
        echo $Payer["address"]["country_code"];
        echo "</td></tr>\n                        <tr><td>Payment Status</td><td>";
        echo $payment_status;
        echo "</td></tr>\n                    </table><br/><br/>\n                ";
    }
    if (!($payment_status == "PAID" || $payment_status == "AUTHORIZED")) {
        echo "<div id='notification1' class='errorbox'>Payment status is " . $payment_status . "</div>";
        exit;
    }
}
echo "\n                <form method=\"post\" id=\"frmver\">\n                    <input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n\n                    <label>\n\n                    <input type=\"checkbox\" name=\"kyc\" id=\"kyc\" value=\"1\">\n                        ";
if ($tranaction["gateway"] == "paypalexpress") {
    echo "KYC Verified & bind PayPal to user profile";
} else {
    echo "KYC Verified";
}
echo "\n                </label>\n                <br/>\n                <input type=\"submit\" id=\"btnpmail3\" name=\"verifytrans\"\n                       onclick=\"javascript: \$('#btnpmail3').val('Processing Please wait...');\"\n                       class=\"btn btn-plain\" value=\"Verify & Capture Transaction\">\n                </form>\n            </div>\n\n            ";
if ($tranaction["gateway"] == "paypalexpress") {
    echo "                    <br/><br/>\n            <div  style=\"border-right: rgba(0,0,0,0.1) solid 1px; \">\n                <hr/>\n                <form method=\"post\" id=\"frmver\">\n                    <input type=\"hidden\" name=\"invoiceid\" value=\"";
    echo $id;
    echo "\" />\n\n                    <textarea name=\"refundnotes\" placeholder=\"Cancel & Refund Notes\"></textarea>\n                <br/>\n                    <lable><input type=\"checkbox\"  onclick=\"RefundCall()\" name=\"iknow\" value=\"1\" id=\"iknow\" />I know this will refund directly on PayPal</lable>\n                    <br/>\n                <input type=\"submit\" id=\"btnrefund\" disabled name=\"cancelrefund\"\n\n                       class=\"btn btn-plain\" value=\"Cancel Order & ";
    echo $payment_status == "PAID" ? "Refund" : "Void";
    echo "\">\n                </form>\n\n            </div>\n            ";
}
echo "\n        </div>\n    </div>\n</div>\n\n\n\n\n\n";
$fileverioncheck = "6.1.0";
echo "\n";

?>