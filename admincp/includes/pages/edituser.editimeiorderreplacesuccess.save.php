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
include ROOTDIR . "/includes/imeiservices.fun.php";
if ($replacecode) {
    $time = time();
    $date = date("Y-m-d");
    if (dquery("update tbl_order_imei set reply = '" . $replacecode . "',\n        reply_time = '" . $time . "',reply_date='" . $date . "',reply_by_admin=" . $_SESSION["adminid"] . "\n         where md5(order_id)='" . $md5id . "'")) {
        echo "success:" . $LNG["order"] . " " . $LNG["reply"] . " " . $LNG["successfully"];
    } else {
        echo "error:" . $LNG["not"] . " " . $LNG["save"];
    }
} else {
    echo "error:" . $LNG["reply"] . " " . $LNG["code"] . " " . $LNG["required"];
}

?>