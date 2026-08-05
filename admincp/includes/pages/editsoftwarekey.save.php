<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($key) {
    $key = explode("\n", $key);
    foreach ($key as $c) {
        $data["key"] = trim($c);
        $data["date"] = $from;
        $data["status"] = $status;
        $data["oid"] = "1";
        $data["expiredon"] = $to;
        $db->update("tbl_swkey", $data, "id=" . $id);
    }
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["key"] . " " . $LNG["required"];
}

?>