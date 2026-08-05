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
if ($selectedg && $id) {
    dquery("update tbl_invoices set paymentmethod='" . $selectedg . "' where id='" . $id . "'");
}
$result = select_query("tbl_invoices", "", ["id" => $id]);
$data = mysqli_fetch_assoc($result);
$invoiceitems = mysqli_fetch_assoc(dquery("select `type` from tbl_invoiceitems where invoiceid='" . $id . "' limit 1"));
$ItemType = $invoiceitems["type"];
$paymenttype = $data["paymentmethod"];
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$date = $data["date"];
$duedate = $data["duedate"];
$subtotal = $data["subtotal"];
$credit = $data["credit"];
$fixedcharge = $data["fixedcharge"];
$invoiceid = $data["id"];
if ($data["status"] == "Paid") {
    $mask = "I/" . $data["mask"];
} else {
    $mask = "P/" . $data["mask"];
}
$shippingtax = $data["shippingtax"];
if ($data["total"] == 0 && 0 < $data["subtotal"]) {
    $total = $data["subtotal"] + $data["shippingtax"] - $data["credit"];
} else {
    $total = $data["total"];
}
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
$result = select_query("tbl_transaction", "(SUM(amountin)-SUM(amountout)) as total", ["invoiceid" => $id]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data["total"];
$balance = $subtotal - $amountpaid;
$balance = sprintf("%01.2f", $balance);
echo "\n<div id=\"notification\"></div>\n\n\n\n  <div class=\"groupstabes\">\n\n\n  <div class=\"groupstabescontant\">\n\n\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"ccg\" value=\"";
echo $ccg;
echo "\" />\n<input type=\"hidden\" name=\"balance\" value=\"";
echo $balance;
echo "\" />\n<input type=\"hidden\" name=\"uid\" value=\"";
echo $clientDetails["id"];
echo "\" />\n<input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "\n<div style=\"position: absolute;top:0px;right:0px;border-radius:0;\">\n    <span  style=\"color: white !important;font-size:18px\" ";
if ($invoice_info["status"] == "Paid") {
    echo "class='spgreen'";
} else {
    echo "class='spred'";
}
echo ">\n";
echo $invoice_info["status"];
echo " </span>\n</div>\n\n\n\n<div  style=\"border-right: rgba(0,0,0,0.1) solid 1px;float: left;padding-right:40px;margin-right: 40px\">\n<h2>\n    <span>Payment Details</span>\n</h2>\n\n<table>\n\n<tr><td>";
echo $LNG["client"];
echo " </td><td>\n<a  href=\"javascript:load_fromsubpage('edituser&id=";
echo $clientDetails["id"];
echo "',' ";
echo $clientDetails["username"];
echo "')\">";
echo $clientDetails["username"];
echo "</a>  </td></tr>\n<tr><td>";
echo $LNG["invoice"];
echo " ";
echo $LNG["date"];
echo " </td><td> ";
echo $date;
echo " </td></tr>\n<tr><td>";
echo $LNG["due"];
echo " ";
echo $LNG["date"];
echo " </td><td> ";
echo $duedate;
echo " </td></tr>\n<tr><td>";
echo $LNG["total"];
echo " ";
echo $LNG["due"];
echo " </td>\n<td> ";
echo formatCurrency($total, $clientDetails["currency"]);
echo " </td></tr>\n\n<tr><td>";
echo $LNG["invoice"];
echo "  </td><td> #";
echo $mask;
echo " </td></tr>\n<tr><td>";
echo $LNG["reference"];
echo "  </td><td> #";
echo $invoiceid;
echo "</td></tr>\n\n<tr><td>\n";
echo $LNG["pending"];
echo " </td><td style=\"font-size: 20px;\">\n    ";
if ($balance <= 0) {
    echo "<span style='color: #779500;'>";
} else {
    echo "<span style='color: #c00;'>";
}
echo "    ";
echo formatCurrency($total - $amountpaid, $clientDetails["currency"]);
echo "</td></tr>\n\n\n";
$no = mysqli_num_rows(dquery("select value from \ntbl_paymentgateways where gateway='" . $paymentmethod . "' and setting='name'"));
echo "<tr>\n<td> ";
echo $LNG["offline"];
echo " ";
echo $LNG["gateway"];
echo " </td>\n";
$gatewa = mysqli_fetch_assoc(dquery("select value from \ntbl_paymentgateways where gateway='" . $paymentmethod . "'and setting='name'"));
echo "<td  class=\"fieldvalue\">\n    <select name=\"newpaymentmethod\" onchange=\"javascript:getContect('','main2.php?page=editinvoice.summary&selectedg='+this.value,'";
echo $id;
echo "',''); \">\n\n";
if (!$paymentmethod) {
    echo "    <option selected>Wallet/Credit balance</option>\n        ";
}
$qp = dquery("select value from \ntbl_paymentgateways where  setting='name'");
while ($rqp = mysqli_fetch_assoc($qp)) {
    $selected = "";
    if ($rqp["value"] == $gatewa["value"]) {
        $selected = "selected";
    }
    echo "        <option ";
    echo $selected;
    echo ">";
    echo $rqp["value"];
    echo "</option>\n        ";
}
echo "    </select>\n</td>\n\n</tr>\n    <tr>\n        <td>";
echo $LNG["notes"];
echo "</td>\n        <td>";
echo $notes;
echo "</td>\n    </tr>\n";
$flag = false;
$custom = getCustomFields($paymentmethod, "", $id);
foreach ($custom as $c) {
    if ($c["value"]) {
        $flag = true;
    }
}
if ($flag) {
    $custom = getCustomFields($paymentmethod, "", $id);
    foreach ($custom as $c) {
        echo "            <tr><td class=\"fieldlabel\">";
        echo $c["name"];
        echo "  </td><td> ";
        echo $c["value"];
        echo " </td> </tr>\n  ";
    }
}
if ($invoice_info["screenshot"]) {
    echo "      <tr> <td>   Screenshot : </td><td>\n<a href=\"includes/download.php?id=";
    echo $invoice_info["id"];
    echo "&action=screensht&names=";
    echo $invoice_info["screenshot"];
    echo "\">\n";
    echo $invoice_info["screenshot"];
    echo "<img width=\"22\" src=\"templates/default/images/down_arr.png\"/></a>\n</td></tr>\n        ";
}
echo "</table>\n\n</div>\n\n\n <div class=\"\" style=\"float:left\">\n <h2><span>Action</span></h2>\n\n<div>\n\n <table class=\"form\"><tr><td  style=\"padding: 0;\">\n  <select name=\"invoicemail\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='invoice' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "  <optgroup   label=\"";
    echo $ss["type"];
    echo "\" >\n ";
    $s = dquery("select id,name,type from tbl_emailtemplates WHERE type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "    <option   value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n ";
    }
    echo "    </optgroup>\n";
}
echo " </select>\n </td><td  >\n <input type=\"button\" class=\"addFromgallery\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" id=\"btnpmail1\" onclick=\"SubmitForm('#btnpmail1','edituser.sendprofilemail','#frm','#notification','true','#main_loader');\" />\n\n </td></tr></table>\n\n <div style=\"padding: 10px 0;\">\n\n";
$balance = $total - $amountpaid;
$pageid = 523;
if (checkPagePermission($pageid, true)) {
    if ($status == "Unpaid" && $balance <= 0) {
        echo "        <input type=\"submit\" name=\"processorder\" class=\"btn save\"\n               value=\"";
        echo $LNG["process"];
        echo " ";
        echo $LNG["valid"];
        echo " ";
        echo $LNG["transaction"];
        echo "\"\n               id=\"btnprocessorder\"/>\n        ";
    }
    if ($status == "Paid" || $status == "Cancel") {
        echo "        <input type=\"submit\" name=\"setstats\" class=\"btn delete\" value=\"";
        echo $LNG["set"];
        echo " ";
        echo $LNG["unpaid"];
        echo "\"\n               id=\"btnunpaid\"/>\n        ";
    } else {
        if (!($status == "Unpaid" && $balance == 0)) {
            echo "            <input type=\"submit\" class=\"btn btn-primary\" name=\"setstats\" value=\"";
            echo $LNG["set"];
            echo " ";
            echo $LNG["paid"];
            echo "\"\n                   id=\"btnunpaid\"/>\n            ";
        }
    }
    if ($status == "Cancel") {
        echo "        <input type=\"submit\" name=\"setstats\" class=\"btn btn-primary\" value=\"";
        echo $LNG["set"];
        echo " ";
        echo $LNG["paid"];
        echo "\"\n               id=\"btnunpaid\"/>\n        ";
    } else {
        echo "        <input type=\"submit\" class=\"btn btn-default\" id=\"btnpmail2\" name=\"setcancel\"\n               value=\"";
        echo $LNG["set"];
        echo " ";
        echo $LNG["cancel"];
        echo "\"\n               id=\"btncancel\"\n               onclick=\"SubmitForm('#btnpmail2','editinvoice.cancel','#frm','#notification','true','#main_loader');\"\n               style=\"color: white;\"/>\n        ";
        if (stripos($ItemType, "AddFunds") === false) {
            echo "        <input type=\"submit\" class=\"btn btn-default\" id=\"btnpmail22\" name=\"setrebate\"\n               value=\"";
            echo $LNG["cancel"];
            echo " & ";
            echo $LNG["refund"];
            echo "\"\n               id=\"btnrcancel\"\n               onclick=\"SubmitForm('#btnpmail22','editinvoice.rebate','#frm','#notification','true','#main_loader');\"\n               style=\"color: white;\"/>\n            ";
        }
        echo "        <input type=\"submit\" class=\"btn btn-default\" id=\"btnpmail222\" name=\"rsetrebate\"\n               value=\"";
        echo $LNG["cancel"];
        echo " & ";
        echo $LNG["rebate"];
        echo "\"\n               id=\"btnrcancel\"\n               onclick=\"SubmitForm('#btnpmail222','editinvoice.orebate','#frm','#notification','true','#main_loader');\"\n               style=\"color: white;\"/>\n\n        ";
    }
    echo "    <input type=\"button\" id=\"btnpmail3\" class=\"btn btn-plain\" name=\"resetpin\" value=\"";
    echo $LNG["print"];
    echo "\"\n           id=\"btnpmail3\" onclick=\"window.open('includes/pages/printfinalinvoice.php?id=";
    echo $id;
    echo "','popUpWindow',\n            'height=600,width=600,left=100,top=100,resizable=no,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');\n            \"/>\n    ";
}
echo "</div>\n</div>\n</div>\n<div class=\"clear\"></div>\n\n\n\n\n</form>\n</div>\n</div></div> </div>\n";
$fileverioncheck = "6.1.0";

?>