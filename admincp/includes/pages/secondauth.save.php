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
require_once "../includes/3rdparty/googleauth.php";
if (Google2FA::verify_key($_SESSION["secretk"], $otp)) {
    dquery("update tbl_admin set google='1',\n    seclogin='" . $_SESSION["secretk"] . "' where id='" . $admn . "'");
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error: Wrong OTP";
}

?>