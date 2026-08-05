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
if ($name && $banner && $width && $height) {
    $data["name"] = $name;
    if (strpos($banner, "http") === true) {
        $data["banner"] = $banner;
    } else {
        $data["banner"] = $config["site_address"] . $banner;
    }
    $data["width"] = $width;
    $data["height"] = $height;
    $data["type"] = $type;
    $data["alttag"] = $alttag;
    $data["description"] = $description;
    $data["service_id"] = $service;
    $data["group_id"] = $group;
    if ($db->insert("tbl_affiliate_banner", $data)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error: " . $LNG["fieldblank"];
}

?>