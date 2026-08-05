<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
$data["group_name"] = $groupname;
$group_name = mysqli_fetch_assoc(dquery("SELECT group_name FROM tbl_imei_group where id='" . $id . "'"));
if ($groupname != $group_name["group_name"]) {
    $check = mysqli_num_rows(dquery("select * from tbl_imei_group\n     where group_name='" . $groupname . "'"));
}
if ($check != 0) {
    echo "error:" . $LNG["groupname"] . " " . $LNG["already"] . " " . $LNG["exists"];
    exit;
}
$data["active"] = $active;
$data["showonhomepage"] = $showonhomepage;
$data["hideguest"] = $hideguest;
$data["imagelink"] = $imagelink;
$data["disabletelegram"] = $disabletelegram;
$data["description"] = html_entity_decode($description);
if ($db->update("tbl_imei_group", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>