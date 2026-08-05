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
    $data["author"] = $author;
    $data["title"] = $title;
    $data["post"] = $post;
    $data["date"] = $date;
    $data["status"] = $status;
    $data["comments"] = $comments;
    $data["type"] = $type;
    $data["permalink"] = $permalink;
    $data["cat"] = $category;
    if ($db->update("tbl_blogposts", $data, "id=" . $id)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}

?>