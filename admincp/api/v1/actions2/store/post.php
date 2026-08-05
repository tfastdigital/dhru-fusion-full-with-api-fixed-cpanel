<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($action == "Purchase") {
    if ($store_item_id) {
        global $conn;
        $Query = $conn->query("SELECT * FROM `tbl_license` WHERE `id`=1");
        $LICENSE = $Query->fetch(PDO::FETCH_ASSOC);
        $ProductToken = $LICENSE["license_key"];
        $post = [];
        $post["store_item_id"] = $store_item_id;
        $Header["HEADER"][] = "Content-Type: application/json";
        $data = initCurl("https://api.dhru.com/integration/api/v1/store?token=" . $ProductToken, [], $Header, "", json_encode($post));
        $res = json_decode($data, true);
        if ($res["status"] == "success") {
            $DownloadLinks = $res["data"]["download_links"];
            $_RETURN["status"] = "success";
            $_RETURN["msg"] = $res["message"];
            $_RETURN["download_links"] = $DownloadLinks;
            $_RETURN["store_item_id"] = $store_item_id;
        } else {
            $_RETURN["status"] = "error";
            $_RETURN["msg"] = $res["message"];
        }
    } else {
        $_RETURN["status"] = "error";
        $_RETURN["msg"] = "Item ID required";
    }
}
if ($action == "Install") {
    if ($banner_link) {
        $banner_link = base64_decode($banner_link);
        $BannerContent = initCurl($banner_link);
        $url = parse_url($banner_link);
        parse_str($url["query"], $query);
        $itemid = $query["id"];
        $size = $query["size"];
        $filetype = $query["filetype"];
        if (!$filetype) {
            $filetype = "jpg";
        }
        $file_name = $itemid . "_" . $size . "." . $filetype;
        if (!is_dir(ROOTDIR . "/../../../images/gallery/storebanners")) {
            mkdir(ROOTDIR . "/../../../images/gallery/storebanners");
        }
        file_put_contents(ROOTDIR . "/../../../images/gallery/storebanners/" . $file_name, $BannerContent);
        $Data["title"] = "Store Banner " . $file_name;
        $Data["bg"] = "image";
        $Data["backgroundImage"] = "images/gallery/storebanners/" . $file_name;
        $Data["backgroundSVG"] = "";
        $Data["backgroundColor"] = "";
        $Data["readmore"] = "";
        $Data["info"] = "";
        $data["data"] = json_encode($Data);
        $data["img_title"] = "Store Banner " . $file_name;
        $data["info_header"] = "";
        $data["info"] = "";
        $data["readmore_link"] = "";
        $data["store"] = 0;
        $data["infox_box_width"] = "";
        $data["po_top"] = "";
        $data["po_left"] = "";
        $data["bgcolor"] = "";
        $data["sort"] = 0;
        $data["backgroundimage"] = "";
        $data["other_html"] = "";
        $data["cloud"] = 0;
        $data["fontcolor"] = "";
        $data["img"] = "";
        insertData("tbl_bannerslider_banners", $data);
        $_RETURN["status"] = "success";
        $_RETURN["msg"] = "Banner installed successfully";
    } else {
        $_RETURN["status"] = "error";
        $_RETURN["msg"] = "Banner Size & Link required";
    }
}
$RETURN = $_RETURN;

?>