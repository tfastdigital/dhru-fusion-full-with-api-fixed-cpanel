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
include ROOTDIR . "/includes/serverservices.fun.php";
if (isset($_POST["select"])) {
    $oidarr = "";
    foreach ($_POST["select"] as $oid) {
        if (strtolower(trim($_POST["reply"][$oid])) == "u") {
            $oidarr .= $oid . ",";
            if (rejectServer(md5($oid), "Unavilable Order", $_SESSION["adminid"])) {
            }
        } else {
            if ($_POST["reply"][$oid] != "") {
                $oidarr .= $oid . ",";
                replySuccessServer(md5($oid), $_POST["reply"][$oid], $_SESSION["adminid"]);
            }
        }
    }
    $oidarr = trim($oidarr, ",");
    echo "success: " . $LNG["orderrepliedsucc"] . ":" . $oidarr;
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>