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
if ($API_ID) {
    $vals = explode("_", $API_ID);
    list($API_ID, $API_TYPE) = $vals;
}
if ($API_ID2) {
    $data["API_ID"] = $API_ID2;
} else {
    $data["API_ID"] = $API_ID;
}
$data["API"] = $API;
$data["key_selling"] = $key_selling;
if ($db->update("tbl_services_file", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
    logActivityGlobal("File Service [" . $id . "] API Connect to [" . $API . "] API Service Name [" . $API_ID2 . "] ", "editservice", "", "admin");
} else {
    echo "error:" . $LNG["datanotsave"];
}
$fileverioncheck = "6.1.0";

?>