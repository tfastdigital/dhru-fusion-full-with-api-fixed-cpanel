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
if ($title && $post && $author) {
    $data["author"] = $_SESSION["adminname"];
    $data["title"] = $title;
    $data["cat"] = $category;
    $data["post"] = $post;
    $data["date"] = formatDate($date);
    $data["status"] = $status;
    $data["comments"] = $comments;
    $data["type"] = $type;
    $data["permalink"] = urlencode($permlink);
    if ($db->insert("tbl_blogposts", $data)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>