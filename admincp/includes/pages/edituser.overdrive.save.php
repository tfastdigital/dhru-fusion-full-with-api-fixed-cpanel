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
if ($overdrive) {
    if (!(is_numeric($overdrive) && 0 <= $overdrive)) {
        echo "error: " . $LNG["wrong"] . " " . $LNG["vaule"] . " " . $LNG["for"] . " " . $LNG["overdrive"];
        exit;
    }
}
$data["allowoverdrive"] = $allowoverdrive;
$data["overdrive"] = $overdrive;
$data["maxcredit"] = $maxcredit;
if ($db->update("tblUsers", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>