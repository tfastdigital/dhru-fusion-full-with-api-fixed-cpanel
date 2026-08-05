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
$values = trim($values);
$parameter = trim($parameter);
$flag = false;
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$q = dquery("SELECT credit_left,sell_credit_limit,id FROM tblUsers WHERE username='" . $search . "'");
$e = mysqli_fetch_assoc($q);
$id = $e["id"];
$clientDetails = getClientsDetails($id);
if ($values != "" && $values <= $e["credit_left"]) {
    $creditleft = round($values, $precision);
    if (rebateCredit($id, $creditleft, true, "", "")) {
        $flag = true;
    }
}
if ($parameter != "" && $parameter <= $e["sell_credit_limit"]) {
    $creditleft = round($parameter, $precision);
    if (rebateSellCredit($id, $creditleft, true)) {
        $flag = true;
    }
}
$q = dquery("SELECT * FROM tblUsers WHERE username='" . $search . "'");
$e = mysqli_fetch_assoc($q);
$output[] = $e;
if ($flag) {
    $reply["STATUS"] = "SUCCESS";
} else {
    $reply["STATUS"] = "ERROR";
}
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>