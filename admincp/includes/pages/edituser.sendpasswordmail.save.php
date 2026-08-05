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
if ($password) {
    $password = createP($password, "8");
} else {
    $password = createP("", "8");
}
$data["password"] = md5(md5($password) . $passenc);
$data["lastpassreset"] = time();
$data["userstatus"] = 0;
if ($db->update("tblUsers", $data, "id=" . $id)) {
    dquery("DELETE FROM `tbl_bannedips`\nWHERE (\nSELECT block_reason\nFROM tblUsers\nWHERE id =" . $id . "\n) LIKE concat( '%', ip, '%' )");
    echo "success:" . $LNG["datasavesuccessfully"] . " & " . $LNG["mail"] . " " . $LNG["sent"];
    if (!function_exists(sendMail)) {
        include ROOTDIR . "/includes/mail.fun.php";
    }
    $mailmerge["password"] = $password;
    sendMail("10", $id, "", $mailmerge, true);
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>