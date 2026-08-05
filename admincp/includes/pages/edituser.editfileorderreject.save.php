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
include ROOTDIR . "/includes/fileservices.fun.php";
if ($reply) {
    rejectFile($md5id, $reply, $_SESSION["adminid"]);
    echo "success:" . $LNG["order"] . " " . $LNG["reject"] . " " . $LNG["successfully"];
} else {
    echo "error:" . $LNG["reject"] . " " . $LNG["reason"] . " " . $LNG["required"];
}

?>