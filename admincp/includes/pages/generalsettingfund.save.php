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
$data["value"] = trim($addfund);
$db->update("tbl_configer", $data, "attribute='addfund'");
$data = NULL;
$data["value"] = $AddFundsMinimum;
$db->update("tbl_configer", $data, "attribute='AddFundsMinimum'");
$data = NULL;
$data["value"] = trim($AddFundsMaximum);
$db->update("tbl_configer", $data, "attribute='AddFundsMaximum'");
$data = NULL;
$data["value"] = trim($AddFundsMaximumBalance);
$db->update("tbl_configer", $data, "attribute='AddFundsMaximumBalance'");
$data = NULL;
echo "success:" . $LNG["datasavesuccessfully"];

?>