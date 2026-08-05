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
$imei = explode("\n", $imei);
foreach ($imei as $i) {
    $j = explode("#", $i);
    $i = $j[0];
    if ($i) {
        $i = trim($i);
        if (!mysqli_num_rows(dquery("select id from tbl_blacklist_imei\r\nWHERE imei='" . $i . "'"))) {
            $data["imei"] = trim($i);
            $data["reason"] = trim($j[1]);
            $data["service_id"] = $imeiservice;
            $db->insert("tbl_blacklist_imei", $data);
        }
    }
}
echo "success: Data save successfully";

?>