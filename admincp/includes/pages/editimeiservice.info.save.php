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
if ($tinyvalue) {
    $data["info"] = html_entity_decode(urldecode(base64_decode(trim($tinyvalue))));
    $data["acceptterms"] = $acceptterms;
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "success: " . $LNG["datasave"] . " " . $LNG["savesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
}

?>