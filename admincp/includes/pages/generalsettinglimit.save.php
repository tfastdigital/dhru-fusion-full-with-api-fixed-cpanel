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
$data["value"] = trim($default_page_limit);
$db->update("tbl_configer", $data, "attribute='default_page_limit'");
$data = NULL;
$data["value"] = $BlogPostsperpage;
$db->update("tbl_configer", $data, "attribute='BlogPostsperpage'");
$data = NULL;
$data["value"] = trim($ActivityLogLimit);
$db->update("tbl_configer", $data, "attribute='ActivityLogLimit'");
$data = NULL;
echo "success:" . $LNG["datasavesuccessfully"];

?>