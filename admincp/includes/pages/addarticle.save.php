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
if ($titlea && $contenta) {
    $q = mysqli_fetch_assoc(dquery("select id from tbl_knowledgebase \n    where id<10000 order by id desc limit 1"));
    $data["title"] = $titlea;
    $data["content"] = $contenta;
    $data["date"] = $datea;
    $data["group_id"] = $groupa;
    $data["id"] = $q["id"] + 1;
    $data["login"] = $login;
    if ($db->insert("tbl_knowledgebase", $data)) {
        echo "success:  " . $LNG["savesuccessfully"] . " ";
    } else {
        echo "error: " . $LNG["datanotsave"] . " ";
    }
    $data = NULL;
}

?>