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
if ($api) {
    dquery("DELETE FROM tbl_mep where api='" . $api . "'");
    dquery("DELETE FROM tbl_model_brand where api='" . $api . "'");
    dquery("DELETE FROM tbl_mobile where api='" . $api . "'");
    dquery("DELETE FROM tbl_provider where api='" . $api . "'");
    dquery("DELETE FROM tbl_provider_country where api='" . $api . "'");
    $success .= "<li>" . $LNG["clear"] . " " . $LNG["listing"] . " " . $LNG["successfully"] . "</li>";
    echo "success:" . $success;
} else {
    echo "error: Select Any API";
}

?>