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
if ($taxname && $taxrate) {
    $data["level"] = trim($level);
    $data["name"] = trim($taxname);
    $data["state"] = trim($state);
    $data["country"] = trim($country);
    $data["taxrate"] = trim($taxrate);
    $data["gateway"] = trim($gateway);
    $data["fixedcharge"] = trim($fixedcharge);
    $db->insert("tbl_tax", $data);
    $data = NULL;
    echo "reload:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>