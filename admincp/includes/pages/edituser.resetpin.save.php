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
include ROOTDIR . "/includes/mail.fun.php";
if ($username) {
    $setpin = rand(1000, 9999);
    $pin = enc((string) $setpin, "9486");
    dquery("update tblUsers set master_pin='" . $pin . "'\n     where id='" . $id . "'");
    $mailmerge["masterpin"] = $setpin;
    sendMail("56", $id, "", $mailmerge, true, "", "", "", "", "", false);
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["username"] . " " . $LNG["required"];
}

?>