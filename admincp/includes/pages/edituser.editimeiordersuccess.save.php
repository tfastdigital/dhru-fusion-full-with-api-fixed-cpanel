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
if ($replyscode) {
    $replycode = html_entity_decode(urldecode(base64_decode($replyscode)));
    $satus = replySuccessIMEI($md5id, $replycode, 99999, "", "", "", "", $id);
    if ($satus[0]) {
        echo "success:" . $LNG["order"] . " " . $LNG["reply"] . " " . $LNG["successfully"];
    } else {
        echo "error:" . $LNG["low"] . " " . $LNG["creditbalance"] . $satus[1];
    }
} else {
    echo "error:" . $LNG["reply"] . " " . $LNG["code"] . " " . $LNG["required"];
}

?>