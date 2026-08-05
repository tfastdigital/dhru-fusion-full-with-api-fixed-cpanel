<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$q = mysqli_fetch_assoc(dquery("SELECT id,(select code from tbl_currencies where id=default_currency) as code FROM tblUsers WHERE username='" . $search . "'"));
$sql = dquery("select id,date,subtotal,paymentmethod from tbl_invoices where userid='" . $q["id"] . "' and status='Unpaid' order by id desc limit 20");
while ($e = mysqli_fetch_assoc($sql)) {
    $e["code"] = $q["code"];
    $output[] = $e;
}
if (count($output) == 0) {
    $reply["STATUS"] = "ERROR";
} else {
    $reply["STATUS"] = "SUCCESS";
    $reply["DATA"] = $output;
}
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>