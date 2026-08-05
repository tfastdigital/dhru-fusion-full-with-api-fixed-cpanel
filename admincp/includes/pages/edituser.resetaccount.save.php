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
$det = mysqli_fetch_assoc(dquery("select username,email from tblUsers where id='" . $id . "'"));
$password = createP("", "8");
$data["password"] = md5(md5($password) . $passenc);
$data["username"] = str_replace("_CLOSED", "", $det["username"]);
$data["email"] = str_replace("_CLOSED", "", $det["email"]);
$data["closeac"] = 0;
$data["userstatus"] = 0;
$db->update("tblUsers", $data, "id='" . $id . "'");
if (!function_exists(sendMail)) {
    include ROOTDIR . "/includes/mail.fun.php";
}
$mailmerge["password"] = $password;
sendMail("10", $id, "", $mailmerge, true);
echo "success: " . $LNG["accountisfullyactiveted"];

?>