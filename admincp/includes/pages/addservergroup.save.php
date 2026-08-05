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
if ($groupname) {
    $data["group_name"] = $groupname;
    $group_name = mysqli_fetch_assoc(dquery("SELECT group_name FROM tbl_server_group where id='" . $id . "'"));
    if ($groupname != $group_name["group_name"]) {
        $check = mysqli_num_rows(dquery("select * from tbl_server_group where group_name='" . $groupname . "'"));
    }
    if ($check != 0) {
        echo "error:" . $LNG["groupname"] . " " . $LNG["already"] . " " . $LNG["exists"];
        exit;
    }
    $data["active"] = $active;
    if ($db->insert("tbl_server_group", $data)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["group"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
}

?>