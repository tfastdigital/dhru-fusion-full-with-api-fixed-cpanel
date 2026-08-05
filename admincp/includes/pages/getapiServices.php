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
require_once "../../../comm.php";
include_once ROOTDIR . "/includes/apiserver.fun.php";
foreach ($_POST as $k => $v) {
    $res = $k . "=" . $v . ",";
}
echo "\n";
logAdminActivity($res);
$script = "onchange='loadCustom(this.value," . $sid . ");'";
echo apiServicesDropdown($sid, "", "API_ID2", $servicetype, $server, "", $script);
$fileverioncheck = "6.1.0";

?>