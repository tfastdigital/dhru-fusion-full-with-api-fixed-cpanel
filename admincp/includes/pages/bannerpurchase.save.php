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
if ($store_item_id) {
    $ProductToken = $licinfo["product_token"];
    $post = [];
    $post["store_item_id"] = $store_item_id;
    $data = initCurl("https://api.dhru.com/integration/api/v1/store?token=" . $ProductToken . "&type=banner", $post);
    $res = json_decode($data, true);
    if ($res["status"] == "success") {
        $DownloadLinks = $res["data"]["download_links"];
    } else {
        echo "error:" . $res["message"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>