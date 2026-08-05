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
if ($title) {
    $data["img"] = $banner;
    $data["img_title"] = $title;
    $data["info"] = $info;
    $data["info_header"] = $infoheader;
    $data["readmore_link"] = $readmore;
    $data["infox_box_width"] = $infox_box_width;
    $data["po_top"] = $po_top;
    $data["po_left"] = $po_left;
    $data["bgcolor"] = $bgcolor;
    $data["fontcolor"] = $fontcolor;
    unset($_POST["token"]);
    $data["data"] = json_encode($_POST);
    $data["backgroundimage"] = trim($backgroud_image);
    if ($db->update("tbl_bannerslider_banners", $data, "id=" . $id)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>