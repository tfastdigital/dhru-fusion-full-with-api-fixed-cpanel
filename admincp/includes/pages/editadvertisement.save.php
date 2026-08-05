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
$data["html_code"] = $html_code;
$no_rows = mysqli_num_rows(dquery("select * from tbl_add_management where p_id='" . $p_id . "' and type='" . $type . "'"));
if ($no_rows != 0) {
    if ($db->update("tbl_add_management", $data, "p_id=" . $p_id . " and type='" . $type . "'")) {
        echo "success:" . $LNG["datasavesuccessfully"];
    }
} else {
    $data["p_id"] = $p_id;
    $data["type"] = $type;
    $db->insert("tbl_add_management", $data);
    echo "success:" . $LNG["datasavesuccessfully"];
}

?>