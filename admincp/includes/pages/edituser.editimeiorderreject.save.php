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
include ROOTDIR . "/includes/imeiservices.fun.php";
if ($ids != 9999) {
    $order = mysqli_fetch_assoc(dquery("select user_can_c,ex_oid from \n    tbl_order_imei where order_id='" . $id . "'"));
    if ($order["user_can_c"] == 1 && $order["ex_oid"] != "") {
        echo "alert: Order is accepted and sent on server. Are you sure want to Reject?";
        exit;
    }
}
if ($replycode) {
    if ($error = rejectIMEI($md5id, $replycode, $_SESSION["adminid"], "", "", "", $id)) {
    }
    if (!$error[0]) {
        echo "error:" . $error[1];
    } else {
        echo "success:" . $LNG["order"] . " " . $LNG["rejected"] . " " . $LNG["successfully"];
    }
} else {
    echo "error:" . $LNG["reject"] . " " . $LNG["reason"] . " " . $LNG["required"];
}

?>