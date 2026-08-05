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
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"refunds\" value=\"1\" />\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"editinvoice.refund.php\" />\n<input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "<table class=\"form\">    \n    <tr><td class=\"fieldlabel\">";
echo $LNG["transaction"];
echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"tid\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n    ";
$sql = dquery("select * from tbl_transaction \n    where invoiceid='" . $id . "' and amountin>0");
while ($r = mysqli_fetch_assoc($sql)) {
    echo "        <option value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["date"];
    echo " | ";
    echo $r["transid"];
    echo " | ";
    echo 0 < $r["amountin"] ? $r["amountin"] : $r["amountout"];
    echo $clientDetails["currency"]["code"];
    echo "</option>\n    ";
}
echo "    </select>\n    </td></tr>    \n  \n    <tr><td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" name=\"amount\" value=\"\"/>\n    <br />\n    <small>";
echo $LNG["leaveblankrefund"];
echo "</small>\n    </td>   \n    </tr> \n     \n    <tr><td class=\"fieldlabel\">";
echo $LNG["refund"];
echo " ";
echo $LNG["to"];
echo "</td>\n    <td class=\"fieldarea\">  \n    <select name=\"refundto\">\n      \n        <option value=\"2\">";
echo $LNG["process"];
echo " ";
echo $LNG["manual"];
echo "</option>\n          <option value=\"1\">";
echo $LNG["add"];
echo " ";
echo $LNG["to"];
echo " \n        ";
echo $LNG["clients"];
echo " ";
echo $LNG["credit"];
echo "</option>\n    </select>\n    </td>\n    </tr>    \n         \n    <tr><td class=\"fieldlabel\">";
echo $LNG["note"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"note\" cols=\"30\" rows=\"4\"></textarea>\n    </td>\n    </tr> \n    <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n    <input type=\"checkbox\" name=\"sendmail\" id=\"mail\" value=\"1\"/>\n    <label for=\"mail\">";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo "</label>\n    </td>\n    </tr>   \n          \n</table>\n    ";
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    echo "    <p class=\"fixedbtn\">\n        <input value=\"";
    echo $LNG["refund"];
    echo "\" name=\"refund\" id=\"btnedituser\" type=\"submit\"/>\n    </p>\n    ";
}
echo "</form> \n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>