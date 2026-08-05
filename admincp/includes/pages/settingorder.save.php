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
$_POST["directorderinfo"] = base64_encode($_POST["directorderinfo"]);
if ($_POST["default_service_imei"]) {
    $_POST["default_service_imei"] = 1;
    dquery("update tbl_navigation set display='1' \n    where id='1016'");
} else {
    $_POST["default_service_imei"] = 0;
    dquery("update tbl_navigation set display='0' \n    where id='1016'");
}
if ($_POST["default_service_file"]) {
    $_POST["default_service_file"] = 1;
    dquery("update tbl_navigation set display='1' \n    where id='1017'");
} else {
    $_POST["default_service_file"] = 0;
    dquery("update tbl_navigation set display='0' \n    where id='1017'");
}
if ($_POST["default_service_server"]) {
    $_POST["default_service_server"] = 1;
    dquery("update tbl_navigation set display='1' \n    where id='1018'");
} else {
    $_POST["default_service_server"] = 0;
    dquery("update tbl_navigation set display='0' \n    where id='1018'");
}
if ($_POST["default_service_remote"]) {
    $_POST["default_service_remote"] = 1;
    dquery("update tbl_navigation set display='1' \n    where id='1100'");
} else {
    $_POST["default_service_remote"] = 0;
    dquery("update tbl_navigation set display='0' \n    where id='1100'");
}
if ($_POST["encryptedorderid"]) {
    $_POST["encryptedorderid"] = 1;
} else {
    $_POST["encryptedorderid"] = 0;
}
if ($_POST["config_self_cancel"]) {
    $_POST["config_self_cancel"] = 1;
} else {
    $_POST["config_self_cancel"] = 0;
}
if ($_POST["averagedeliverytime"]) {
    $_POST["averagedeliverytime"] = 1;
} else {
    $_POST["averagedeliverytime"] = 0;
}
if ($_POST["duplicateimei"]) {
    $_POST["duplicateimei"] = 1;
} else {
    $_POST["duplicateimei"] = 0;
}
if ($_POST["clientorderalert"]) {
    $_POST["clientorderalert"] = 1;
} else {
    $_POST["clientorderalert"] = 0;
}
if ($_POST["allowoverdrive"]) {
    $_POST["allowoverdrive"] = 1;
} else {
    $_POST["allowoverdrive"] = 0;
}
if ($_POST["happyhours"]) {
    $_POST["happyhours"] = 1;
} else {
    $_POST["happyhours"] = 0;
}
if ($_POST["tooltip"]) {
    $_POST["tooltip"] = 1;
} else {
    $_POST["tooltip"] = 0;
}
if ($_POST["masterpin"]) {
    $_POST["masterpin"] = 1;
} else {
    $_POST["masterpin"] = 0;
}
if ($_POST["ordernotes"]) {
    $_POST["ordernotes"] = 1;
} else {
    $_POST["ordernotes"] = 0;
}
if ($_POST["ordercomments"]) {
    $_POST["ordercomments"] = 1;
} else {
    $_POST["ordercomments"] = 0;
}
if ($_POST["orderemail"]) {
    $_POST["orderemail"] = 1;
} else {
    $_POST["orderemail"] = 0;
}
if ($_POST["orderno"]) {
    $_POST["orderno"] = 1;
} else {
    $_POST["orderno"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>