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
saveSettings("popafenable", $popafenable);
if (mysqli_num_rows(dquery("select * from tbl_settings where attribute='flashpopafter'"))) {
    $data["value"] = html_entity_decode(urldecode(base64_decode($tinyvalue)));
    $db->update("tbl_settings", $data, "attribute='flashpopafter'");
} else {
    $data["value"] = html_entity_decode(urldecode(base64_decode($tinyvalue)));
    $data["attribute"] = "flashpopafter";
    $db->insert("tbl_settings", $data);
}
echo "success:" . $LNG["datasave"] . " " . $LNG["savesuccessfully"];

?>