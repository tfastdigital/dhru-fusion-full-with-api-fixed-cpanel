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
$satus = replySuccessIMEI($md5id, $replycode, 99999, "", "", "", "accept", $id);
if ($satus[0]) {
    echo "success:" . $LNG["order"] . " set back to " . $LNG["accepted"] . " " . $LNG["successfully"];
} else {
    echo "error:" . $LNG["low"] . " " . $LNG["creditbalance"];
}

?>