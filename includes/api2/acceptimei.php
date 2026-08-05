<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^-0-9a-zA-Z.]/i", "", $_POST["parameter"]);
$values = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["search"]);
$user = explode("-", $parameter);
foreach ($user as $u) {
    $u = trim($u);
    if ($u) {
        if ($values == "REJECT") {
            include_once ROOTDIR . "/includes/imeiservices.fun.php";
            rejectIMEI(md5($u), "Rejected By Admin", $username);
        } else {
            dquery("update `tbl_order_imei` set `user_can_c`='1'\n                   where `order_id`='" . $u . "' AND `user_can_c`='0'");
        }
    }
}
$reply["STATUS"] = "SUCCESS";
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>