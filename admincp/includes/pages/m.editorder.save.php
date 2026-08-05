<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
include ROOTDIR . "/includes/imeiservices.fun.php";
if ($verify) {
    dquery("UPDATE tbl_order_imei SET verified=2 WHERE order_id='" . $md5id . "'");
}
if ($reject) {
    if ($reply) {
        dquery("update tbl_order_imei set reply='" . $reply . "' where md5(order_id)='" . $md5id . "'");
    }
    rejectIMEI($md5id, $reply, $_SESSION["adminid"]);
    echo "success:" . $LNG["order"] . " " . $LNG["rejected"] . " " . $LNG["successfully"];
} else {
    if ($reply) {
        $flag = dquery("update tbl_order_imei set reply='" . $reply . "' where md5(order_id)='" . $md5id . "'");
        $satus = replySuccessIMEI($md5id, $reply, $_SESSION["adminid"]);
        if ($satus[0]) {
            echo "success:" . $LNG["order"] . " " . $LNG["reply"] . " " . $LNG["successfully"];
        } else {
            if ($flag) {
                echo "success:" . $LNG["order"] . " " . $LNG["reply"] . " " . $LNG["successfully"];
            }
        }
    } else {
        echo "error:" . $LNG["reply"] . " " . $LNG["code"] . " " . $LNG["required"];
    }
}

?>