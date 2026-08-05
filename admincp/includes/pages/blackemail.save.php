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
if ($emaillist) {
    $ip = explode("\n", $emaillist);
    foreach ($ip as $i) {
        $value = explode("#", $i);
        $value[0] = trim($value[0]);
        if (preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $value[0])) {
            if (!mysqli_num_rows(dquery("select id from tbl_email_blacklist\nwhere email='" . $value[0] . "'"))) {
                $data["email"] = trim($value[0]);
                $data["reason"] = trim($value[1]);
                $db->insert("tbl_email_blacklist", $data);
                $data = NULL;
            }
        } else {
            echo "error:" . $LNG["clientareaerroremailinvalid"];
            exit;
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}

?>