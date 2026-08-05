<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($seperatecron == 1) {
    $_POST["seperatecron"] = 1;
} else {
    $_POST["seperatecron"] = "";
}
$_POST["cronsendbatchorder"] = preg_replace("/[^0-9]/i", "", $_POST["cronsendbatchorder"]);
$_POST["crongetbatchorder"] = preg_replace("/[^0-9]/i", "", $_POST["crongetbatchorder"]);
$_POST["cron_password"] = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["cron_password"]);
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "reload:" . $LNG["datasavesuccessfully"];

?>