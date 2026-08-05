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
if ($name) {
    $data["group_name"] = $name;
    if (!isset($access_permission[168]) && $id == "1") {
        $access_permission[168] = "168";
    }
    if (!isset($access_permission[55]) && $id == "1") {
        $access_permission[55] = "55";
    }
    if ($access_permission) {
        $data["access"] = implode(",", $access_permission);
    }
    $data["system"] = $systememails;
    $data["account"] = $accountemails;
    $data["support"] = $supportemails;
    if ($db->update("tbl_admin_access_group", $data, "id=" . $id)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:Error";
    }
} else {
    echo "error:" . $LNG["adminrole"] . " " . $LNG["required"];
}

?>