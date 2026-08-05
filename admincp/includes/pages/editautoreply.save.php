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
$data["group"] = $group;
$data["codetable"] = $codetable;
$data["codeimei"] = $codeimei;
$data["codereply"] = $codereply;
$data["exlcludestart"] = $exlcludestart;
$data["exludeend"] = $exludeend;
$data["replysprintf"] = $replysprintf;
$data["autoreject"] = $autoreject;
$db->update("tbl_keygroup", $data, "id=" . $id);
echo "success: Data save successfully";

?>