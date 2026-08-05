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
if ($checkall) {
    unset($user);
    $result = dquery("select id from tblUsers where usertype=0 or usertype=1");
    while ($row = mysqli_fetch_assoc($result)) {
        $user[$row["id"]] = $row["id"];
    }
}
if ($user) {
    if (!is_array($user)) {
        $user = explode(",", $user);
    }
    foreach ($user as $value) {
        dquery("update tblUsers set sndlogin='' where id=" . $value);
    }
    echo "success:" . $LNG["update"] . " OTP " . $LNG["successfully"] . " ";
} else {
    echo "error:" . $LNG["user"] . " " . $LNG["not"] . "  " . $LNG["selected"] . " ";
}

?>