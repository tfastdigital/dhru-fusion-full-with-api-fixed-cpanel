<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
include_once ROOTDIR . "/includes/serverservices.fun.php";
$imeiServiceDetails = getServerServices("", "", "", true, true, "", "", "", "", "", "", "", 9999);
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_server` WHERE `user_can_c`='0' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            $e["service"] = $keys["service_name"];
            $e["order"] = $cnt;
            $e["id"] = $keys["id"];
            $output[] = $e;
        }
    }
}
if (count($output) == 0) {
    $reply["STATUS"] = "ERROR";
} else {
    $reply["STATUS"] = "SUCCESS";
    $reply["DATA"] = $output;
}
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>