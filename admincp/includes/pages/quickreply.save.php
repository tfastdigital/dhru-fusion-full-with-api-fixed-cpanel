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
global $email_merge_fields;
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if (isset($_POST["reply"]) && 0 < count($_POST["reply"])) {
    $oidarr = "";
    foreach ($_POST["reply"] as $oid => $just) {
        if (strtolower(trim($_POST["reply"][$oid])) == "u") {
            $oidarr .= $oid . ",";
            if (rejectIMEI(md5($oid), "Unavailable Order", $_SESSION["adminid"], "", "", "", $oid, false)) {
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