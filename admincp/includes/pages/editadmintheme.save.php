<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../../comm.php";
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($theme) {
    $data["theme"] = $theme;
    $_SESSION["admintheme"] = $data["theme"];
}
if ($template) {
    $data["template"] = $template;
    $_SESSION["admin_template"] = $data["template"];
}
$admin = $_SESSION["adminid"];
$db->update("tbl_admin", $data, "id=" . $admin);

?>