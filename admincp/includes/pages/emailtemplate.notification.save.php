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
if ($_POST["adminnotice"]) {
    $_POST["adminnotice"] = 1;
} else {
    $_POST["adminnotice"] = 0;
}
if ($_POST["adminotice_newinvoice"]) {
    $_POST["adminotice_newinvoice"] = 1;
} else {
    $_POST["adminotice_newinvoice"] = 0;
}
if ($_POST["adminotice_neworder"]) {
    $_POST["adminotice_neworder"] = 1;
} else {
    $_POST["adminotice_neworder"] = 0;
}
if ($_POST["adminotice_verifyorder"]) {
    $_POST["adminotice_verifyorder"] = 1;
} else {
    $_POST["adminotice_verifyorder"] = 0;
}
if ($_POST["adminotice_newuser"]) {
    $_POST["adminotice_newuser"] = 1;
} else {
    $_POST["adminotice_newuser"] = 0;
}
if ($_POST["adminotice_userprofile"]) {
    $_POST["adminotice_userprofile"] = 1;
} else {
    $_POST["adminotice_userprofile"] = 0;
}
if ($_POST["adminotice_rechargevoucher"]) {
    $_POST["adminotice_rechargevoucher"] = 1;
} else {
    $_POST["adminotice_rechargevoucher"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:  " . $LNG["datasavesuccessfully"];

?>