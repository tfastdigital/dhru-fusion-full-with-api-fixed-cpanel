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
if ($productname) {
    $data["service_name"] = $productname;
    $data["group_id"] = $groupname;
    $data["credit"] = $credit;
    $data["active"] = 1;
    $data["retail_info"] = $retail_info;
    $db->insert("tbl_products", $data);
    echo "success: " . $LNG["product"] . " " . $LNG["added"] . " " . $LNG["successfully"];
} else {
    echo "error:" . $LNG["product"] . " " . $LNG["name"] . " " . $LNG["mustbe"] . " " . $LNG["required"];
}

?>