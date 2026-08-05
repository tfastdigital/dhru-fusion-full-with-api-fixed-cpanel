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
if ($title && $body) {
    if ($type == 1) {
        $WHERE = " and userstatus=0";
    } else {
        if ($type == 2) {
            $WHERE = " and userstatus=2";
        }
    }
    $q = dquery("select * from tblUsers where gcmid!=''\r\n    and usertype!='3' " . $WHERE);
    do {
    } while (!($r = mysqli_fetch_assoc($q)));
    echo "success: GCM " . $LNG["notification"] . " " . $LNG["sent"];
} else {
    echo "error: " . $LNG["title"] . " and " . $LNG["body"] . " required";
}

?>