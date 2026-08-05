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
if (isset($_POST["select"])) {
    $oidarr = "";
    foreach ($_POST["select"] as $oid) {
        if (dquery("DELETE FROM tbl_voucher WHERE id='" . $oid . "'")) {
            $oidarr .= $oid . ",";
        }
    }
    $oidarr = trim($oidarr, ",");
    echo "success: " . $LNG["datadeletesuccessfully"] . ":" . $oidarr;
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>