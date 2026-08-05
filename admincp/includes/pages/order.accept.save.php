<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
if (!isset($_SESSION[adminid])) {
    exit;
}
$parameter = preg_replace("/[^,0-9a-zA-Z.]/i", "", $_POST["parameter"]);
$values = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["values"]);
$user = explode(",", $parameter);
if ($SERVER) {
    if ($selall) {
        dquery("update `tbl_order_server` set `user_can_c`='1' where `user_can_c`='0' and service_id='" . $sid . "'");
    } else {
        foreach ($user as $u) {
            $u = trim($u);
            if ($u) {
                if ($values == "REJECT") {
                    include_once ROOTDIR . "/includes/serverservices.fun.php";
                    rejectServer(md5($u), "Rejected By Admin", $_SESSION["adminname"]);
                } else {
                    dquery("update `tbl_order_server` set `user_can_c`='1' where `order_id`='" . $u . "' AND `user_can_c`='0'");
                }
            }
        }
    }
} else {
    if ($selall) {
        dquery("update `tbl_order_imei` set `user_can_c`='1' where `user_can_c`='0' and service_id='" . $sid . "'");
    } else {
        foreach ($user as $u) {
            $u = trim($u);
            if ($u) {
                if ($values == "REJECT") {
                    include_once ROOTDIR . "/includes/imeiservices.fun.php";
                    rejectIMEI(md5($u), "Rejected By Admin", $_SESSION["adminname"]);
                } else {
                    dquery("update `tbl_order_imei` set `user_can_c`='1' where `order_id`='" . $u . "' AND `user_can_c`='0'");
                }
            }
        }
    }
}
echo "success: " . $LNG["orderrepliedsucc"];

?>