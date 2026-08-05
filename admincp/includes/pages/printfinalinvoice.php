<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
$invoice_info = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_invoices` WHERE `id`='" . $id . "' "));
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($invoice_info["userid"]);
require ROOTDIR . "/includes/invoice.fun.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<html>\n<head>\n<style>\n#tab1_active{display: none;}\n#itemstable{\n    background: #efefef;\n}\n#itemstable td{\n    border:2px solid #efefef;\n    padding: 5px;\n}\n\nbody,td,input,select {\n    font-family: Tahoma;\n    font-size: 11px;\n    color: #000000;\n}\n\nform {\n    margin: 0px;\n}\n\na {\n    color: #000000;\n}\n\n#wrapper {\n    width: 600px;\n}\n\n\n\ntd#invoicecontent {\n    background-color: #ffffff;\n    color: #000000;\n}\n\n.unpaid {\n    font-size: 16px;\n    color: #cc0000;\n    font-weight: bold;\n}\n\n.paid {\n    font-size: 16px;\n    color: #779500;\n    font-weight: bold;\n}\n\n.refunded {\n    font-size: 16px;\n    color: #224488;\n    font-weight: bold;\n}\n\n.cancelled {\n    font-size: 16px;\n    color: #cccccc;\n    font-weight: bold;\n}\n\n\n\n\n#clientdetails {   width: 100%;   background-color: #D3EDF9; padding: 10px; }\n#invheader {background-color: black; color: #FFF !important; font-weight: bold !important; }\n.dueaamount {font-size: 18px;}\n.applycredit { border: 1px dashed #cc0000;  font-weight: bold;  background-color: #FBEEEB; text-align: center; width: 100%; padding: 10px; color: #cc0000; margin-left: auto;  margin-right: auto;}\n.invoicesnotes { border: 1px dashed #CCC; padding: 10px; color: #000 !important; }\n\n#itemstable { width: 100%; background-color: #efefef;  border-collapse: seperate;}\ntd#itemsheading { color: #000000;  font-weight: bold;  padding: 5px;  border:2px solid #efefef; border-bottom:0px;}\ntd#itemsrow { background-color: #ffffff;  color: #000000 !important;  padding: 5px;   border:2px solid #efefef;  border-bottom:0px;}\n\n\n#notification { text-align: center; padding: 5px; color:#545454; width:100%;  margin:5px auto; display: block; cursor: pointer;}\n.clean { background-color: #efefef; border-top: 2px solid #dedede; border-bottom: 2px solid #dedede;  }\n.info  { background-color: #f7fafd; border-top: 2px solid #b5d3ff; border-bottom: 2px solid #b5d3ff; }\n.successbox    { background-color: #d7f7c4; border-top: 2px solid #82cb2f; border-bottom: 2px solid #82cb2f; }\n.alert { background-color: #fef5be; border-top: 2px solid #fdd425; border-bottom: 2px solid #fdd425; }\n.errorbox { background-color: #ffcdd1; border-top: 2px solid #e10c0c; border-bottom: 2px solid #e10c0c; }\n\n</style>\n<script>\nfunction activeTab(active,inactive){\n    document.getElementById(active+'_active').style.display='block';\t    \n    document.getElementById(inactive+'_active').style.display='none';\n}\nvar Lst;\nfunction CngClass(obj){\n if (Lst) Lst.className='';\n obj.className='tabmenu_active';\n Lst=obj;\n}\n</script>\n<script src=\"includes/js/jquery.ui.min.js\"></script>\n<link href=\"includes/css/ui/style.css\" rel=\"stylesheet\"/>\n<script>\n\$(function() {\n\t\tvar dates = \$( \"#from, #to\" ).datepicker({\n\t\t\tchangeMonth: true,\n            changeYear: true,\n            dateFormat:'yy-mm-dd', \n\t\t\tonSelect: function( selectedDate ) {\n\t\t\t\tvar option = this.id == \"from\" ? \"minDate\" : \"maxDate\",\n\t\t\t\t\tinstance = \$( this ).data( \"datepicker\" );\n\t\t\t\t\tdate = \$.datepicker.parseDate(\n\t\t\t\t\t\tinstance.settings.dateFormat ||\n\t\t\t\t\t\t\$.datepicker._defaults.dateFormat,\n\t\t\t\t\t\tselectedDate, instance.settings );\n\t\t\t\tdates.not( this ).datepicker( \"option\", option, date );\n\t\t\t}\n\t\t});\n\t});\n</script> \n</head>\n<body onload=\"window.print();\">\n \n<div align=\"center\">\n<input type=\"button\" name=\"print\" value=\"";
echo $LNG["print"];
echo " ";
echo $LNG["invoice"];
echo "\" onclick=\"window.print();\" /></div>\n<br />\n<div id=\"notification\"></div><br/>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($invoice_info["status"] == "Unpaid") {
}
$result = select_query("tbl_invoices", "", ["id" => $id]);
$data = mysqli_fetch_assoc($result);
$invoicenum = $data["invoicenum"];
$userid = $data["userid"];
$clns = mysqli_fetch_assoc(dquery("select state,country from tblUsers where id='" . $userid . "'"));
$date = $data["date"];
$duedate = $data["duedate"];
$subtotal = $data["subtotal"];
$credit = $data["credit"];
if ($config["taxenabled"]) {
    $tax = $data["tax"];
    $tax2 = $data["tax2"];
    $taxrate = $data["taxrate"];
    $taxrate2 = $data["taxrate2"];
} else {
    $taxrate = "0.00";
    $taxrate2 = "0.00";
}
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
$result = select_query("tbl_transaction", "SUM(amountin)-SUM(amountout)", ["invoiceid" => $id]);
$data = mysqli_fetch_assoc($result);
$amountpaid = $data[0];
$balance = $total - $amountpaid;
$balance = sprintf("%01.2f", $balance);
if ($taxrate != "0.00") {
    $taxname = getTaxRate(1, $clns["state"], $clns["country"]);
}
if ($taxrate2 != "0.00") {
    $taxname = getTaxRate(2, $clns["state"], $clns["country"]);
}
$result = select_query("tbl_transaction", "amountin", ["userid" => $userid], "id", "DESC");
$data = mysqli_fetch_assoc($result);
$lastpaymentamount = $data[0];
$invoiceitems = [];
$result = select_query("tbl_invoiceitems", "", ["invoiceid" => $id], "id", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $taxed = false;
    if ($data["taxed"]) {
        $taxed = true;
    }
    $invoiceitems[] = ["id" => $data["id"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br($data["description"]), "amount" => formatCurrency($data["amount"], $clientDetails["currency"]), "taxed" => $taxed];
    if ($data["type"] == "AddFunds" || $data["type"] == "AddFunds by Admin") {
        $desable_add_credit = true;
    }
    $promotion_code = $data["promotion_code"];
}
require_once ROOTDIR . "/includes/gateway.fun.php";
$gatewaysarray = getGatewaysArray();
$transactions = [];
$result = select_query("tbl_transaction", "", ["invoiceid" => $id], "date` ASC,`id", "ASC");
while ($data = mysqli_fetch_assoc($result)) {
    $date = $data["date"];
    $date = formatDate($date);
    $gateway = $data["gateway"];
    $description = $data["description"];
    $amountin = $data["amountin"];
    $fees = $data["fees"];
    $amountout = $data["amountout"];
    $transid = $data["transid"];
    $invoiceid = $data["invoiceid"];
    $gateway = $gatewaysarray[$gateway];
    if (!$gateway) {
        $gateway = "-";
    }
    $transactions[] = ["date" => $date, "gateway" => $gateway, "transid" => $transid, "amount" => formatCurrency($amountin - $amountout, $clientDetails["currency"])];
}
echo "\n<div style=\"width: 600px; margin: auto;\">\n\n<div class=\"subtabContent\">\n<div id=\"tab_active\"  align=\"center\">\n<table id=\"wrapper\" class=\"form\" cellspacing=\"1\" cellpadding=\"10\"  align=\"center\"><tr><td bgcolor=\"#ffffff\">\n\n    <table width=\"100%\" id=\"invheader\"><tr><td align=\"left\" width=\"50%\" id=\"invheader\">\n        <strong>";
echo $LNG["invoice"];
echo " ";
echo $LNG["id"];
echo " #";
if ($invoice_info["status"] == "Paid") {
    echo "I/" . $invoice_info["mask"];
} else {
    echo "P/" . $invoice_info["mask"];
}
echo "<input type=\"hidden\" name=\"invoiceid\" value=\"";
echo $invoice_info["id"];
echo "\"/></strong> \n    </td><td align=\"right\" width=\"50%\" id=\"invheader\">\n        ";
echo $LNG["invoice"];
echo " ";
echo $LNG["date"];
echo ": ";
echo $date;
echo "    </td>\n    </tr></table>\n\n    <br />\n    <table width=\"100%\"><tr><td width=\"50%\">\n        <strong>";
echo $LNG["invoicepayto"];
echo "</strong><br />\n           \n";
echo nl2br($config["invoicepayto"]);
echo "    </td><td width=\"50%\" align=\"right\">\n       ";
if ($status == "Unpaid") {
    echo "            <font class=\"unpaid\">";
    echo $status;
    echo "</font><br />\n       ";
} else {
    echo $status;
}
echo "</td></tr></table>\n    \n\n    \n    <table width=\"100%\" id=\"clientdetails\" cellspacing=\"0\"><tr><td width=\"50%\" align=\"left\" valign=\"top\" >\n        <strong>";
echo $clientDetails["company"];
echo "</strong><br />\n";
echo $clientDetails["firstname"] . " " . $clientDetails["lastname"];
echo " \n<br />\n";
echo $clientDetails["address1"];
echo "<br />\n";
echo $clientDetails["address2"];
echo "<br />\n";
echo $clientDetails["city"];
echo " - ";
echo $clientDetails["zip"];
echo "<br />\n";
echo $clientDetails["state"];
echo "<br />\n";
echo $clientDetails["country"];
echo " \n        </td><td width=\"50%\" align=\"right\" >\n            <table bgcolor=\"white\" cellspacing=\"0\" cellpadding=\"10\"  ><tr><td valign=\"top\" style=\"border:1px solid #cccccc\" align=\"center\">\n            \n                <span class=\"dueaamount\">";
echo formatCurrency($balance, $clientDetails["currency"]);
echo "</span> <br />\n                ";
echo $LNG["invoice"];
echo " ";
echo $LNG["due"];
echo " ";
echo $LNG["date"];
echo ": ";
echo $duedate;
echo "            </td></tr></table>\n    </td></tr></table>\n    \n    <br />\n    \n    <table cellspacing=\"0\" id=\"itemstable\" align=\"center\">\n        <tr>\n            <td id=\"itemsheading\" align=\"left\" width=\"70%\" ><strong>";
echo $LNG["invoice"];
echo " ";
echo $LNG["description"];
echo "</strong></td>\n            <td id=\"itemsheading\" align=\"center\" width=\"30%\" ><strong>";
echo $LNG["invoice"];
echo " ";
echo $LNG["amount"];
echo "</strong></td>\n        </tr>\n        ";
foreach ($invoiceitems as $invo) {
    echo "         <tr bgcolor=\"#FFFFFF\"> \n                <td id=\"itemsrow\" >\n                ";
    echo html_entity_decode($invo["description"]);
    echo " \n                ";
    if ($invo["taxed"] == "true") {
        echo "*";
    }
    if ($invo["type"] == "Product") {
        $sql = mysqli_fetch_assoc(dquery("select service_id,(select freeship from tbl_products where id=service_id) as freeship from tbl_order_product where order_id='" . $invo["relid"] . "'"));
        if ($sql["freeship"]) {
            echo "<br>&nbsp;&nbsp;&nbsp;<small><i style='color: #666 !important;'>" . $LNG["freeshipping"] . "</i>";
        }
        $cst = getCustomFields("product", $sql["service_id"], $invo["relid"], "", "", "", false, $clientDetails["currency"]);
        if ($cst) {
            echo "<br/>";
            foreach ($cst as $custom) {
                if ($custom["value"]) {
                    echo "                        &nbsp;&nbsp;&nbsp;<small><i style=\"color: #666 !important;\">";
                    echo $custom["name"];
                    echo " - ";
                    echo $custom["value"];
                    echo "</small></i><br />\n                                            ";
                }
            }
        }
    }
    echo "             \n                </td>\n                <td align=\"center\" id=\"itemsrow\" > ";
    echo $invo["amount"];
    echo " </td>\n            </tr>\n        ";
}
echo "       \n        <tr>\n            <td id=\"itemsheading\" ><div align=\"right\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["sub"];
echo $LNG["total"];
echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\" ><strong>";
echo formatCurrency($subtotal, $clientDetails["currency"]);
echo "</strong></td>\n        </tr>\n\n        ";
if ($taxrate) {
    echo "            <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
    echo $taxrate;
    echo "% ";
    echo $taxname["name"];
    echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
    echo formatCurrency($tax, $clientDetails["currency"]);
    echo "</strong></td>\n            </tr>\n        ";
}
echo "        \n        \n       ";
if ($shippingtax) {
    echo "            <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
    echo $LNG["shipping"];
    echo " ";
    echo $LNG["cost"];
    echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
    echo formatCurrency($shippingtax, $clientDetails["currency"]);
    echo "</strong></td>\n            </tr>\n        ";
}
if ($taxrate2 != "0.00") {
    echo "            <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
    echo $taxrate2;
    echo "% ";
    echo $taxname["name"];
    echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
    echo $tax2;
    echo "</strong></td>\n            </tr>\n        ";
}
echo "        \n        <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["credit"];
echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
echo formatCurrency($credit, $clientDetails["currency"]);
echo "</strong></td>\n        </tr>\n        ";
if ($promotion) {
    echo "        <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
    echo $LNG["promotion"];
    echo " [";
    echo $promotion_code;
    echo "]:&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
    echo formatCurrency($promotion, $clientDetails["currency"]);
    echo "</strong></td>\n        </tr>        \n        ";
}
echo "        <tr>\n            <td id=\"itemsheading\"><div align=\"right\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["total"];
echo ":&nbsp;</div></td>\n            <td id=\"itemsheading\" align=\"center\"><strong>";
echo formatCurrency($total, $clientDetails["currency"]);
echo "</strong></td>\n        </tr>\n    </table>\n    \n    \n    ";
if ($transactions) {
    echo "     <p><strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo "</strong></p>\n    <table cellspacing=\"0\" id=\"itemstable\" align=\"center\">\n        <tr>\n        <td id=\"itemsheading\" ><strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["date"];
    echo "</strong></td>\n        <td id=\"itemsheading\" ><strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["gateway"];
    echo "</strong></td>\n        <td id=\"itemsheading\" ><strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["id"];
    echo "</strong></td>\n        <td id=\"itemsheading\" ><strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["transaction"];
    echo " ";
    echo $LNG["amount"];
    echo "</strong></td>\n        </tr>\n        ";
    foreach ($transactions as $tran) {
        echo "            <tr >\n            <td id=\"itemsrow\" >";
        echo $tran["date"];
        echo "</td>\n            <td id=\"itemsrow\">";
        echo $tran["gateway"];
        echo "</td>\n            <td id=\"itemsrow\">";
        echo $tran["transid"];
        echo "</td>\n            <td id=\"itemsrow\">";
        echo $tran["amount"];
        echo "</td>\n            </tr>\n        ";
    }
    echo "        \n        <tr>\n            <td id=\"itemsheading\" width=\"30%\" colspan=\"3\"><div align=\"right\">\n            <strong>";
    echo $LNG["invoice"];
    echo " ";
    echo $LNG["balance"];
    echo ":&nbsp;</strong></div></td>\n            <td id=\"itemsheading\" align=\"center\" width=\"20%\" ><strong>";
    echo formatCurrency($balance, $clientDetails["currency"]);
    echo "</strong></td>\n        </tr>\n    </table>   \n    ";
}
echo "   \n\n\n</td></tr></table>\n</div>\n<div id=\"tab1_active\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"invoiceid\"  value=\"";
echo $id;
echo "\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">    \n    <tr><td class=\"fieldlabel\">";
echo $LNG["date"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"date\" id=\"from\" value=\"";
echo date("Y-m-d");
echo "\"/></td></tr>    \n    <tr><td class=\"fieldlabel\">";
echo $LNG["payment"];
echo " ";
echo $LNG["method"];
echo "</td><td class=\"fieldarea\"><select name=\"gateway\">\n  <option value=''>";
echo $LNG["select"];
echo "</option>\n    ";
$sql = dquery("select gateway,value from tbl_paymentgateways where setting='name'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value=" . $row["gateway"] . ">" . $row["value"] . "</option>";
}
echo "</select>\n    </td></tr>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["transaction"];
echo " ";
echo $LNG["id"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"transId\"/></td></tr>\n    <tr><td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td><td class=\"fieldarea\">\n    <input type=\"text\" name=\"amount\" value=\"";
echo $balance;
echo "\"/>\n    <input type=\"hidden\" name=\"applied\" value=\"";
echo $balance;
echo "\" />\n    </td></tr>\n     <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input type=\"checkbox\" name=\"sendmail\" value=\"1\" id=\"mail\"/><label for=\"mail\">";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo "</label></td></tr>\n    <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["payment"];
echo "\"  id=\"btnedituser\" type=\"button\" onclick=\"SubmitForm ('#btnedituser','edituser.payinvoice','#frmedituser','#notification','true','#main_loader');\"/></td></tr>   \n</table>\n\n</div>\n</div>    \n\n\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n     \n</form>\n";
if (isset($_GET["print"])) {
    echo "<p class=\"fixedbtn\">\n<input type=\"button\" name=\"print\" value=\"Print\" onclick=\"javascript:window.print();\"/>\n</p>\n";
}
echo "</div>\n</div>\n</div>\n</body>\n</html>";
$fileverioncheck = "6.1.0";

?>