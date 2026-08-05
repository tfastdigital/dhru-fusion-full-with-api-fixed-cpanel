<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$q = dquery("SELECT * FROM tblUsers WHERE username='" . $search . "'");
while ($e = mysqli_fetch_assoc($q)) {
    $sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id=" . $e["default_currency"]));
    $e["code"] = $sql["code"];
    $output[] = $e;
}
$reply["STATUS"] = "SUCCESS";
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>