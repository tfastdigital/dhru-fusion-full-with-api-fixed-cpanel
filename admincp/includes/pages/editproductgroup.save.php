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
$data["group_name"] = $groupname;
$data["mid"] = $pgroup;
$group_name = mysqli_fetch_assoc(dquery("SELECT group_name FROM tbl_product_group where id='" . $id . "'"));
if ($groupname != $group_name["group_name"]) {
    $check = mysqli_num_rows(dquery("select * from tbl_product_group where BINARY  group_name LIKE '" . $groupname . "'"));
}
if ($check != 0) {
    echo "error:" . $LNG["groupname"] . " " . $LNG["already"] . " " . $LNG["exists"];
    exit;
}
if ($pgroup == $id) {
    echo "error: " . $LNG["select_"] . "  " . $LNG["different"] . " " . $LNG["master"] . " " . $LNG["group"];
    exit;
}
$data["active"] = $active;
$data["display_order"] = $order;
$data["imagelink"] = $imagelink;
$data["iconlink"] = $iconlink;
$data["seotitle"] = $seotitle;
$data["seodescription"] = $seodescription;
$data["description"] = html_entity_decode($description);
$data["mid"] = $pgroup;
if ($db->update("tbl_product_group", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>