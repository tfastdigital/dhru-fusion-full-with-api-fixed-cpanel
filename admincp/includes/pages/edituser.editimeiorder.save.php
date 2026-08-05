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
require ROOTDIR . "/includes/customfield.fun.inc.php";
if ($modelId2) {
    $data["model_id"] = $modelId2;
} else {
    $data["model_id"] = $modelId1;
}
if ($providerId2) {
    $data["provider_id"] = $providerId2;
} else {
    $data["provider_id"] = $providerId1;
}
$data["network_id"] = $networkId;
$data["provider_c_id"] = $countryId;
$data["mep"] = $mepId;
$data["PIN"] = $pin;
$data["KBH"] = $kbh;
$data["PRD"] = $prd;
$data["SN"] = $SN;
$data["SecRO"] = $SecRO;
$data["Type"] = $type;
$data["note"] = $note;
$data["comments"] = $comments;
$data["adminnote"] = $adminnote;
$data["response_email"] = $response_email;
if ($db->update("tbl_order_imei", $data, "order_id=" . $id)) {
    $data = NULL;
    saveCustomFields($id, $customfield);
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>