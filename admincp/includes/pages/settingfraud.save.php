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
if ($_POST["mobverbysms"]) {
    $_POST["mobverbysms"] = 1;
} else {
    $_POST["mobverbysms"] = 0;
}
if ($_POST["idverification"]) {
    $_POST["idverification"] = 1;
} else {
    $_POST["idverification"] = 0;
}
if ($_POST["autoverifycredits"]) {
    $_POST["autoverifycredits"] = 1;
} else {
    $_POST["autoverifycredits"] = 0;
}
if ($_POST["directunverified"]) {
    $_POST["directunverified"] = 1;
} else {
    $_POST["directunverified"] = 0;
}
dquery("update tbl_client_group set idverification='0'");
saveSettings("defaultgroupverification", 0);
foreach ($clientgroup as $cgid => $v) {
    dquery("update tbl_client_group set idverification='1' where id='" . $cgid . "'");
    if ($cgid == 9999) {
        saveSettings("defaultgroupverification", 1);
    }
}
if ($_POST["mobverbycall"]) {
    $_POST["mobverbycall"] = 1;
} else {
    $_POST["mobverbycall"] = 0;
}
include_once "../includes/fun.inc.php";
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>