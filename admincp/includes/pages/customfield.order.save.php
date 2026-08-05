<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
define("DEFINE_DHRU_FILE", true);
define("DEFINE_MY_ACCESS", true);
define("ADMIN", true);
require_once "../../../comm.php";
foreach ($_POST["main_tbl"] as $k => $v) {
    if ($v) {
        dquery("update tbl_customfields set \n        sortorder='" . $k . "' where id='" . $v . "'");
    }
}
echo " Field position changed successfully";

?>