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
if ($contents) {
    $data["content"] = $contents;
    if ($db->update("tbl_custom_page", $data, "type='index'")) {
        echo "success:  " . $LNG["savesuccessfully"] . " ";
    } else {
        echo "error: " . $LNG["datanotsave"] . " ";
    }
}

?>