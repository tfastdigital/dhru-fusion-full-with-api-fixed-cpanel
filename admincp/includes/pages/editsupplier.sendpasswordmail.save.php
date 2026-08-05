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
$password = generatePW("", "8");
$data["password"] = $password["password"];
if ($db->update("tbl_supplier", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
    if (!function_exists(sendMail)) {
        include ROOTDIR . "/includes/mail.fun.php";
    }
    $mailmerge["password"] = $password["txt"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>