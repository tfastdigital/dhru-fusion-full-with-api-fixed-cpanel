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
if ($_POST["config_is_under_maintanance"] == 0) {
    $_POST["config_is_under_maintanance"] = 1;
} else {
    $_POST["config_is_under_maintanance"] = 0;
}
$time_zone = mysqli_fetch_assoc(dquery("SELECT * from `tbl_timezone_1` WHERE `Time_zone_id`='" . $config["time_zone"] . "'"));
date_default_timezone_set($time_zone["Name"]);
unset($time_zone);
$_POST["maintanance_message"] = $_POST["tinyvalue"];
dquery("update tbl_settings set value='" . $_POST["maintanance_message"] . "' WHERE attribute='maintanance'");
unset($_POST["maintanance_message"]);
unset($_POST["tinyvalue"]);
$_POST["maintenancetime"] = $_POST["maintenancebacktime"];
$_POST["maintenancebacktime"] = $_POST["maintenancebacktime"] * 3600 + time();
if ($_POST["maintanacecontact"]) {
    $_POST["maintanacecontact"] = 1;
} else {
    $_POST["maintanacecontact"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>