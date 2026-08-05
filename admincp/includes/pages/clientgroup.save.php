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
if ($group) {
    if (!mysqli_num_rows(dquery("select * from tbl_client_group where groupname='" . $group . "'"))) {
        $data["groupname"] = $group;
        if ($gid = $db->insert("tbl_client_group", $data)) {
            if ($allservice) {
                $sq = dquery("select id from tbl_services_imei");
                while ($rs = mysqli_fetch_assoc($sq)) {
                    $SD = [];
                    $SD["groupid"] = $gid;
                    $SD["serviceid"] = $rs["id"];
                    $SD["status"] = 1;
                    $db->insert("tbl_service_status", $SD);
                }
            }
            echo "reload:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        echo "error:" . $LNG["group"] . " " . $LNG["already"] . " " . $LNG["exists"];
    }
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>