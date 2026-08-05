<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$values = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["values"]);
$parameter = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["parameter"]);
$extra = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["extra"]);
$values = trim($values);
$parameter = trim($parameter);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$id = mysqli_fetch_assoc(dquery("select id from tblUsers where username='" . $search . "'"));
$id = $id["id"];
$clientDetails = getClientsDetails($id);
if ($values != "") {
    $creditleft = round($values, $precision);
    if (addCredit($id, $creditleft, true, "", "") && ($extra == 2 || $extra == 12)) {
        include_once ROOTDIR . "/includes/invoice.fun.php";
        insert_query("tbl_invoiceitems", ["userid" => $id, "type" => "AddFunds by Admin", "relid" => "", "description" => "+ Add Funds", "amount" => $creditleft, "taxed" => "0", "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        $invoiceid = generateInvoice($id);
        if ($extra == 1 || $extra == 12) {
            processInvoicetoPaid($invoiceid);
        }
    }
}
if ($parameter != "") {
    $sellcreditlimit = round($parameter, $precision);
    addSellCredit($id, $sellcreditlimit, true);
}
$q = dquery("SELECT * FROM tblUsers WHERE username='" . $search . "'");
while ($e = mysqli_fetch_assoc($q)) {
    $output[] = $e;
}
$reply["STATUS"] = "SUCCESS";
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>