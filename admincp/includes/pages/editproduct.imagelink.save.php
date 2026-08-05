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
$data["image_link1"] = $imagelink1;
$data["image_link2"] = $imagelink2;
$data["image_link3"] = $imagelink3;
$data["image_link4"] = $imagelink4;
$data["image_link5"] = $imagelink5;
$data["image_hotdeal"] = $image_hotdeal;
$data["default_image"] = $default_image;
if ($db->update("tbl_products", $data, "id=" . $id)) {
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>