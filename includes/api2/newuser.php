<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$q = dquery("SELECT id,username FROM tblUsers WHERE  userstatus=2 limit 10");
while ($e = mysqli_fetch_assoc($q)) {
    $output[]["username"] = $e["username"];
}
if (count($output) == 0) {
    $reply["STATUS"] = "ERROR";
} else {
    $reply["STATUS"] = "SUCCESS";
}
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>