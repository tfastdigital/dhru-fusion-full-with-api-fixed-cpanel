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
$total = $data["total"];
$status = $data["status"];
$datepaid = formatDate($datepaid, "time");
$duedate = formatDate($duedate);
$result = select_query("tbl_transaction", "SUM(amountin)-SUM(amountout)", ["invoiceid" => $id]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data[0];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
echo " \n<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">Add Credit</span> \n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<input type=\"hidden\" name=\"ccg\" value=\"";
echo $ccg;
echo "\" />\n<input type=\"hidden\" name=\"addcredit\" value=\"1\" />\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"editinvoice.credit.php\" />\n<input type=\"hidden\" name=\"totalcredit\" value=\"";
echo $clientDetails["credit"]["credit"];
echo "\" />\n<input type=\"hidden\" name=\"userid\" value=\"";
echo $clientDetails["id"];
echo "\" />\n<input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" >    \n    <tr><td class=\"fieldlabel\">";
echo $LNG["credit"];
echo " ";
echo $LNG["left"];
echo "</td>\n    <td  class=\"fieldarea\">";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "</td></tr>    \n  \n       <tr><td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" name=\"amount\" value=\"";
echo $balance;
echo "\"/>\n    <input type=\"hidden\" name=\"applied\" value=\"";
echo $balance;
echo "\" />\n    </td></tr>\n              \n</table>\n<div style=\"clear: both;\" ></div>\n";
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    echo "    <div class=\"fixedbtn\">\n        <input value=\"";
    echo $LNG["apply"];
    echo " ";
    echo $LNG["credit"];
    echo "\" id=\"btnedituser\" class=\"btn save\" type=\"submit\"/>\n    </div>\n    ";
}
echo "</form> \n</div>\n</div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>