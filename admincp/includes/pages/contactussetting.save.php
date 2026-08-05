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
if ($_POST["contactus"]) {
    $_POST["contactus"] = 1;
    dquery("update tbl_navigation set display='1' where id=1004");
} else {
    $_POST["contactus"] = 0;
    dquery("update tbl_navigation set display='0' where id=1004");
}
if ($_POST["contactby"]) {
    $_POST["contactby"] = 1;
} else {
    $_POST["contactby"] = 0;
}
if ($_POST["contactus"]) {
    if ($_POST["contactby"] == 1) {
        $contactus_mail = "";
        $_POST["contactus_mail"] = "";
        if (!$support_email) {
            echo "error: Support Department required";
            exit;
        }
    } else {
        $support_email = "";
        $_POST["support_email"] = "";
        if (!$contactus_mail) {
            echo "error: Contact Email Required";
            exit;
        }
    }
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:  " . $LNG["datasavesuccessfully"];

?>