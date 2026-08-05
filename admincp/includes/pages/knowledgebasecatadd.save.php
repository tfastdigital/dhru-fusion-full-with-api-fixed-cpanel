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
if ($category) {
    $q = mysqli_fetch_assoc(dquery("select id from tbl_knowledgebasecat \n    where id<1000 order by id desc limit 1"));
    $data["category"] = $category;
    $data["info"] = $info;
    $data["id"] = $q["id"] + 1;
    $data["image"] = $image;
    if ($db->insert("tbl_knowledgebasecat", $data)) {
        echo "success:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["field"] . " " . $LNG["required"];
}
echo " ";

?>