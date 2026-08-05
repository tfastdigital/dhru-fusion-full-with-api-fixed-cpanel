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
$uesr = mysqli_fetch_assoc(dquery("select username from tblUsers where id='" . $id . "'"));
logActivityGlobal("Tmp Password Generated", "password", "", $uesr["username"]);
$pass = TMPS();
dquery("update tblUsers set tmp_password=md5('" . $pass . "'),tmp_pass_time=UNIX_TIMESTAMP() where id='" . $id . "'");
echo "success:Temporary Password  '" . $pass . "' generated for one hour::1";
function TMPS($length = 4)
{
    $chars = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    $Code = "";
    for ($i = 0; $i < $length; $i++) {
        $Code .= substr($chars, (int) mt_rand(0, strlen($chars)) - 1, 1);
    }
    return $Code;
}

?>