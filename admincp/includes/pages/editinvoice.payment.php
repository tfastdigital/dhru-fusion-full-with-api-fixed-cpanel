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
$invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices` WHERE `id`='" . $id . "' "));
$clientDetails = getClientsDetails($invoice_info["userid"]);
$result = select_query("tbl_invoices", "", ["id" => $id]);
$data = mysqli_fetch_assoc($result);
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$date = $data["date"];
$duedate = $data["duedate"];
$subtotal = $data["subtotal"];
$credit = $data["credit"];
$credit = $data["credit"];
$shippingtax = $data["shippingtax"];
$total = $data["total"];
$status = $data["status"];
$promotion = $data["promotion"];
$paymentmethod = $data["paymentmethod"];
$paymentmethod2 = $gatewaysarray[$paymentmethod];
$notes = $data["notes"];
$datepaid = $data["datepaid"];
$rawduedate = $duedate;
$date = formatDate($date);
$datepaid = formatDate($datepaid, "time");
$duedate = formatDate($duedate);
$result = dquery("select sum(amountin) as amin,sum(amountout) as amout from tbl_transaction\nwhere invoiceid='" . $id . "'");
$data = mysqli_fetch_assoc($result);
$amountpaid = $data["amin"] - $data["amout"];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
echo "<script>\nfunction getGateways(val)\n{\n   \$.post(\"includes/pages/gatewayfield.php\", { gateway: val},function(data) {\n       var res=data.split(\"____\");\n       \$(\"#payfield\").html(res[0]);\n       if(res[1]){\n           \$(\".paypals\").show();\n           \$(\"#mail2\").prop( \"checked\", true );\n       }else{\n           \$(\".paypals\").hide();\n           \$(\"#mail2\").prop( \"checked\", false );\n       }\n   });\n}\n</script>\n<div id=\"notification\"></div>\n<div  style=\"height: 100%;\" class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Add Payment</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<input type=\"hidden\" name=\"ccg\" value=\"";
echo $ccg;
echo "\" />\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"editinvoice.payment.php\" />\n<input type=\"hidden\" name=\"addpayment\" value=\"1\" />\n<input type=\"hidden\" name=\"uid\" value=\"";
echo $clientDetails["id"];
echo "\" />\n<input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\"  >    \n    <tr><td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"date\" class=\"datepicker\" id=\"from\" value=\"";
echo date("Y-m-d");
echo "\"/></td></tr>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["payment"];
echo " ";
echo $LNG["method"];
echo "</td><td class=\"fieldarea\">\n    <select name=\"gateway\" onchange=\"getGateways(this.value)\">\n<option value=''>";
echo $LNG["select"];
echo "</option>\n";
$sql = dquery("select gateway,value from \n       tbl_paymentgateways where setting='name'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value=" . $row["gateway"] . ">" . $row["value"] . "</option>";
}
echo "</select>\n    </td></tr>\n    <tbody id=\"payfield\">\n    </tbody>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["transaction"];
echo " ";
echo $LNG["id"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"transId\"/></td></tr>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td><td class=\"fieldarea\">\n        <input type=\"text\" name=\"amount\" value=\"";
echo $balance;
echo "\"/>\n        <input type=\"hidden\" name=\"applied\" value=\"";
echo $balance;
echo "\" />\n    </td></tr>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["fees"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"fees\" value=\"\" id=\"fees\"/></td></tr>\n    <tr><td class=\"fieldlabel\"><label for=\"mail\">";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo "</label></td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" checked=\"checked\" name=\"sendmail\" value=\"1\" id=\"mail\"/></td>\n    </tr>\n    <tr class=\"paypals\" style=\"display: none\"><td class=\"fieldlabel\"><label for=\"mail2\">";
echo $LNG["auto"];
echo " Validate transaction id with Paypal</label></td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" name=\"autovalidate\" value=\"1\" id=\"mail2\"/></td>\n    </tr>\n</table>\n";
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    echo "    <p class=\"fixedbtn\">\n      <input value=\"";
    echo $LNG["add"];
    echo " ";
    echo $LNG["payment"];
    echo "\" id=\"btnedituser\" class=\"add btn btn-primary\"\n      type=\"submit\"/>\n    </p>\n    ";
}
echo "</form> \n</div>\n</div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>