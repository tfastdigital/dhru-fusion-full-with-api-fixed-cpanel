<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["sc_adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($selected) {
    $data = NULL;
    $data["member"] = $selected;
    $db->update("tbl_taskgroup", $data, "id='" . $id . "'");
    echo "success: Data save successfully";
} else {
    echo "error: Field should not blank";
}

?>