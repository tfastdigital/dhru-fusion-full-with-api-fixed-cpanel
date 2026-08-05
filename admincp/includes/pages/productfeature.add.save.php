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
include_once ROOTDIR . "/includes/features.fun.php";
foreach ($customfield as $key => $value) {
    if (!$customfield[$key]["required"]) {
        $customfield[$key]["required"] = "";
    }
}
if (!$customfield[-1]["fieldname"]) {
    unset($customfield[-1]);
}
saveFeaturesServicewise($key, $customfield);
echo "success:" . $LNG["datasavesuccessfully"];

?>