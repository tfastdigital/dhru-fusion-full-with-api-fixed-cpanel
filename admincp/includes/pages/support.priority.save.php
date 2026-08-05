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
if ($priority && $color) {
    $sql = dquery("select priority from tbl_support_priority where priority='" . $priority . "'");
    if (!mysqli_num_rows($sql)) {
        $data["priority"] = $priority;
        $data["color"] = $color;
        if ($db->insert("tbl_support_priority", $data)) {
            echo "success:" . $LNG["datasavesuccessfully"];
        } else {
            echo "error:" . $LNG["datanotsave"];
        }
    } else {
        echo "error:" . $LNG["priority"] . " " . $LNG["already"] . " " . $LNG["exists"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>