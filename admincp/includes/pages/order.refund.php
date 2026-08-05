<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
$orde = mysqli_fetch_assoc(dquery("select invoice_id,refunded,reply,imei,user_id,(select service_name\nfrom tbl_services_imei where id=service_id) as service from \ntbl_order_imei where order_id='" . $id . "'"));
$invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices`\n WHERE `id`='" . $orde["invoice_id"] . "'"));
$tr = mysqli_fetch_assoc(dquery("select id from tbl_transaction where invoiceid='" . $orde["invoice_id"] . "'"));
$clientDetails = getClientsDetails($orde["user_id"]);
if ($refund) {
    checkDemoMode(false);
    if ($amount && $refundid) {
        $sql = mysqli_fetch_assoc(dquery("select * from tbl_transaction \n        where invoiceid='" . $orde["invoice_id"] . "'"));
        $data = NULL;
        $data = $sql;
        unset($data["id"]);
        if ($amount) {
            $data["amountout"] = $amount;
        }
        $data["amountin"] = 0;
        $data["refundid"] = $refundid;
        $data["note"] = $note;
        $db->insert("tbl_transaction", $data);
        $data = NULL;
        updateInvoiceTotal($orde["invoice_id"]);
        dquery("update tbl_invoices set status='Cancel' where id='" . $orde["invoice_id"] . "'");
        dquery("update tbl_order_imei set refunded=0 where order_id='" . $id . "'");
        $vars = "<div id='notification1' class='successbox'>" . $LNG["transaction"] . " " . $LNG["refunded"] . " " . $LNG["successfully"] . "</div>";
    } else {
        $vars = "<div id='notification1' class='errorbox'>" . $LNG["amount"] . " and " . $LNG["refund"] . " ID " . $LNG["required"] . "</div>";
    }
}
echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n\n<div id=\"notification\"></div>\n";
echo $vars;
echo "<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($orde["refunded"]) {
    echo "<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"order.refund.php\" />\n";
    echo generate_token("form");
    echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" style=\"width: 100%;  \" >    \n    <tr><td class=\"fieldlabel\">";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["id"];
    echo "</td>\n    <td class=\"fieldarea\">\n   #";
    echo $invoice_info["id"];
    echo "    </td></tr>    \n    <tr><td class=\"fieldlabel\">";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["id"];
    echo "</td>\n    <td class=\"fieldarea\">\n   #";
    echo $tr["id"];
    echo "    </td></tr>  \n    \n   <tr><td class=\"fieldlabel\">";
    echo $LNG["gateway"];
    echo " </td>\n    <td class=\"fieldarea\">\n   ";
    echo $invoice_info["paymentmethod"];
    echo "    </td></tr> \n     \n   <tr><td class=\"fieldlabel\">";
    echo $LNG["orderid"];
    echo " </td>\n    <td class=\"fieldarea\">\n   #";
    echo $id;
    echo "    </td></tr>\n     \n   <tr><td class=\"fieldlabel\">";
    echo $LNG["service"];
    echo " </td>\n    <td class=\"fieldarea\">\n   ";
    echo $orde["service"];
    echo "    </td></tr>\n         \n   <tr><td class=\"fieldlabel\">";
    echo $LNG["imei"];
    echo " </td>\n    <td class=\"fieldarea\">\n   ";
    echo $orde["imei"];
    echo "    </td></tr>\n         \n   <tr><td class=\"fieldlabel\">";
    echo $LNG["reason"];
    echo " </td>\n    <td class=\"fieldarea\">\n   ";
    echo $orde["reply"];
    echo "    </td></tr>\n    \n    <tr><td class=\"fieldlabel\">";
    echo $LNG["amount"];
    echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" size=\"8\" name=\"amount\" value=\"";
    echo $invoice_info["total"];
    echo "\"/>\n    ";
    echo $clientDetails["currency"]["code"];
    echo "    </td>   \n    </tr> \n    \n    <tr><td class=\"fieldlabel\">";
    echo $LNG["refund"];
    echo " ";
    echo $LNG["id"];
    echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" name=\"refundid\" value=\"\"/>\n    </td>   \n    </tr> \n             \n    <tr><td class=\"fieldlabel\">";
    echo $LNG["note"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"note\" cols=\"30\" rows=\"4\"></textarea>\n    </td>\n    </tr> \n         \n</table>\n<div style=\"clear: both;\" ></div>\n<div align=\"center\">\n<input value=\"";
    echo $LNG["refund"];
    echo "\" name=\"refund\"  id=\"btnedituser\" type=\"submit\" />\n</div>\n</form> \n";
}
echo "</div>\n</div>";
$fileverioncheck = "6.1.0";

?>