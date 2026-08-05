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
if ($cronpreference) {
    saveSettings("cronpreference", $cronpreference);
    exit;
}
$_POST["otherhtmlcode"] = base64_encode(urldecode(base64_decode($_POST["otherhtmlcode"])));
dquery("update tbl_settings set value='" . $_POST["otherhtmlcode"] . "' WHERE attribute='htmlcode'");
unset($_POST["otherhtmlcode"]);
if ($_POST["tracking_domain"] && !preg_match("/^([a-z0-9]+([\\-a-z0-9]*[a-z0-9]+)?\\.){0,}([a-z0-9]+([\\-a-z0-9]*[a-z0-9]+)?){1,63}(\\.[a-z0-9]{2,7})+\$/i", $_POST["tracking_domain"])) {
    echo "error: Wrong Domain Name";
    exit;
}
if ($analyticsecommerce == 1) {
    $_POST["analyticsecommerce"] = 1;
} else {
    $_POST["analyticsecommerce"] = "";
}
if ($gcmnotification == 1) {
    $_POST["gcmnotification"] = 1;
} else {
    $_POST["gcmnotification"] = "";
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success: " . $LNG["datasavesuccessfully"];

?>