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
global $email_merge_fields;
$imeiuniqueid = time();
if (count($_POST["select"])) {
    foreach ($_POST["reply"] as $orderid => $orderrepl) {
        $flag = true;
        foreach ($_POST["select"] as $ok => $ov) {
            if ($ov == $orderid) {
                $flag = false;
            }
        }
        if ($flag) {
            unset($_POST["reply"][$orderid]);
        }
    }
}
foreach ($_POST["accept"] as $oid => $just) {
    dquery("update tbl_order_imei set user_can_c=0\n      where order_id='" . $oid . "'");
    $oidarr .= $oid . ",";
}
if (is_array($_POST["accept"]) && $oidarr) {
    $oidarr = trim($oidarr, ",");
}
if (isset($_POST["reply"])) {
    foreach ($_POST["reply"] as $oid => $just) {
        if (isset($_POST["reject"][$oid])) {
            $oidarr .= $oid . ",";
            if (rejectIMEI(md5($oid), $_POST["reply"][$oid], $_SESSION["adminid"], "", "", "", $oid, false)) {
            }
        } else {
            if ($_POST["reply"][$oid] != "") {
                $oidarr .= $oid . ",";
                replySuccessIMEI(md5($oid), $_POST["reply"][$oid], $_SESSION["adminid"], "", "", "", "", $oid);
            }
        }
    }
    replySuccessIMEI_sendmail();
    replyRejectIMEI_sendmail();
    $oidarr = trim($oidarr, ",");
    echo "success: " . $LNG["orderrepliedsucc"] . ":" . $oidarr;
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>