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
if ($date && $comment && $author) {
    $data["author"] = $author;
    $data["comment"] = $comment;
    $data["date"] = $date;
    $data["status"] = $status;
    $data["email"] = $email;
    $data["ip"] = $_SERVER["REMOTE_ADDR"];
    if ($db->insert("tbl_testimonial", $data)) {
        echo "success:" . $LNG["savesuccessfully"] . " ";
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>