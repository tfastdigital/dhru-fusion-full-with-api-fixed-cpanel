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
$_POST["registration_lockfields"] = trim($lock_username . "," . $lock_email . "," . $lock_first_name . "," . $lock_last_name . "," . $lock_address . "," . $lock_address2 . "," . $lock_city . "," . $lock_state . "," . $lock_country . "," . $lock_zip, ",");
$_POST["usercan_signup"] = trim($google . "," . $yahoo . "," . $facebook, ",");
if ($_POST["minregistration"]) {
    $_POST["minregistration"] = 1;
} else {
    $_POST["minregistration"] = 0;
}
if ($_POST["phonerequired"]) {
    $_POST["phonerequired"] = 1;
} else {
    $_POST["phonerequired"] = 0;
}
if ($_POST["allowtelegramreg"]) {
    $_POST["allowtelegramreg"] = 1;
} else {
    $_POST["allowtelegramreg"] = 0;
}
if ($_POST["displayusername"]) {
    $_POST["displayusername"] = 1;
} else {
    $_POST["displayusername"] = 0;
}
if ($_POST["allowtransfer"]) {
    $_POST["allowtransfer"] = 1;
} else {
    $_POST["allowtransfer"] = 0;
}
if ($_POST["notdiscounteduser"]) {
    $_POST["notdiscounteduser"] = 1;
} else {
    $_POST["notdiscounteduser"] = 0;
}
if ($_POST["fraud_protection"]) {
    $_POST["fraud_protection"] = 1;
} else {
    $_POST["fraud_protection"] = 0;
}
if ($_POST["newsletter_registration"]) {
    $_POST["newsletter_registration"] = 1;
} else {
    $_POST["newsletter_registration"] = 0;
}
if ($_POST["captcha_forget"]) {
    $_POST["captcha_forget"] = 1;
} else {
    $_POST["captcha_forget"] = 0;
}
if ($_POST["registration_type"] == 3) {
    dquery("update tbl_navigation set display='0' where id=1015");
} else {
    dquery("update tbl_navigation set display='1' where id=1015");
}
if ($_POST["captcha_registration"]) {
    $_POST["captcha_registration"] = 1;
} else {
    $_POST["captcha_registration"] = 0;
}
if ($_POST["registration_terms"]) {
    $_POST["registration_terms"] = true;
} else {
    $_POST["registration_terms"] = false;
}
if ($_POST["registration_api"]) {
    $_POST["registration_api"] = 1;
} else {
    $_POST["registration_api"] = 0;
}
if ($_POST["registration_affiliate"]) {
    $_POST["registration_affiliate"] = 1;
} else {
    $_POST["registration_affiliate"] = 0;
}
if ($_POST["customize_email"]) {
    $_POST["customize_email"] = 1;
} else {
    $_POST["customize_email"] = 0;
}
$_POST["defaultgateway"] = implode(",", $_POST["gateway"]);
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$error = "";
foreach ($customfield as $key => $value) {
    if (!$customfield[$key]["required"]) {
        $customfield[$key]["required"] = "";
    }
}
if (!$customfield[-1]["fieldname"]) {
    unset($customfield[-1]);
}
saveCustomFieldServicewise($key, $customfield);
echo "success:" . $LNG["datasavesuccessfully"];

?>