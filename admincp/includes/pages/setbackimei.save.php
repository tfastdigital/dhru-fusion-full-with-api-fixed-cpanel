<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
include ROOTDIR . "/includes/imeiservices.fun.php";
if (isset($_POST["select"])) {
    $oidarr = "";
    $flag = false;
    foreach ($_POST["select"] as $oid) {
        $data["verified"] = 0;
        $data["verified_by_admin"] = $_SESSION["adminid"];
        $db->update("tbl_order_imei", $data, "order_id=" . $oid);
        $data = NULL;
        $flag = true;
    }
    if ($flag) {
        $oidarr = trim($oidarr, ",");
        echo "success: " . $LNG["verifiedsucc"] . ":" . $oidarr;
    }
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>