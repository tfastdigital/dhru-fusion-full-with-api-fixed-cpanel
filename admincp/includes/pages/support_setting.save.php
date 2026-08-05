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
if ($tid) {
    $data = NULL;
    $data["subject"] = $subject;
    $data["sid"] = $status;
    $data["did"] = $department;
    $data["pid"] = $priority;
    if ($db->update("tbl_support_tickets", $data, "tid='" . $tid . "'")) {
        $data = NULL;
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error: " . $LNG["datanotsave"];
}
echo " ";

?>