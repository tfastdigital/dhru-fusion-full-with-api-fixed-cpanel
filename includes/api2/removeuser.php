<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
if ($search != "") {
    dquery("DELETE FROM tblUsers WHERE username='" . $search . "'");
    $reply["STATUS"] = "SUCCESS";
} else {
    $reply["STATUS"] = "ERROR";
}
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>