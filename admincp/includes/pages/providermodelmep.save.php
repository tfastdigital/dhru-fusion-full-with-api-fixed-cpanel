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
if ($pid && $mid && $mep && ($mep1 || $mep4)) {
    $data["pid"] = $pid;
    $data["mid"] = $mid;
    $data["mep"] = $mep;
    if ($mep1) {
        $str .= "2,";
    }
    if ($mep4) {
        $str .= "4,";
    }
    $str = trim($str, ",");
    $data["mepl"] = $str;
    $db->insert("tbl_provider_model_mep", $data);
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>