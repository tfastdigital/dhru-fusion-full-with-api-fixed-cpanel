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
$satus = replySuccessIMEI($md5id, "", 99999, "", "", "", "new", $id);
dquery("DELETE FROM tbl_apilog where orderid='" . $id . "' and `result`='Sending'");
if ($satus[0]) {
    echo "success:" . $LNG["order"] . " set back to  " . $LNG["new"] . " " . $LNG["successfully"];
} else {
    echo "error:" . $LNG["low"] . " " . $LNG["creditbalance"];
}

?>