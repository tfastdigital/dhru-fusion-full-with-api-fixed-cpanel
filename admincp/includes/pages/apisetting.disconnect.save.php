<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
dquery("update tbl_services_imei set API='',API_ID=''\r\n    where id='" . $serviceid . "'");
echo "success:" . $LNG["service"] . " " . $LNG["disconnected"] . " " . $LNG["from"] . " " . $LNG["api"];

?>