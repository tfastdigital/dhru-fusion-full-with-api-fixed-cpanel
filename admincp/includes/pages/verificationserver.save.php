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
    $flag = false;
    $oidarr = "";
    foreach ($_POST["select"] as $oid) {
        $VERI = getOrdersServer("", "", "", md5($oid), "ALL");
        $VERI["verified"] = $VERI[$oid]["verified"];
        if ($VERI["verified"] != 2) {
            if (isset($_POST["reject"][$oid])) {
                $oidarr .= $oid . ",";
                if (rejectServer(md5($oid), $_POST["reply"][$oid], $_SESSION["adminid"])) {
                }
                $data["verified"] = 2;
                $data["verified_by_admin"] = $_SESSION["adminid"];
                $db->update("tbl_order_server", $data, "order_id=" . $oid);
                $data = NULL;
            } else {
                if ($_POST["reply"][$oid] != "") {
                    $oidarr .= $oid . ",";
                    $data["reply"] = $_POST["reply"][$oid];
                    $data["verified"] = 2;
                    $data["verified_by_admin"] = $_SESSION["adminid"];
                    $db->update("tbl_order_server", $data, "order_id=" . $oid);
                    $data = NULL;
                }
            }
            $flag = true;
        } else {
            echo "error: " . $LNG["alreadyverified"];
        }
    }
    if ($flag) {
        $oidarr = trim($oidarr, ",");
        echo "success: " . $LNG["verifiedsucc"] . ":" . $oidarr;
    }
} else {
    echo "error: " . $LNG["selectanyrow"];
}

?>