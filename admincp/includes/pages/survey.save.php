<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($title) {
    $data["title"] = $title;
    $data["detail"] = $detail;
    $data["captcha"] = $captcha;
    if ($gt = $db->insert("tbl_survey", $data)) {
        echo "callfunction:editsurvey:" . $gt;
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>