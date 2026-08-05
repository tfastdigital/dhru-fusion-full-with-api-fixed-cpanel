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
$check = mysqli_num_rows(dquery("SELECT * FROM tbl_country_language where country_id='" . $country . "'"));
if ($check != 0) {
    echo "error:" . $LNG["country"] . " " . $LNG["language"] . " " . $LNG["already"] . " " . $LNG["exists"];
    exit;
}
$data["country_id"] = $country;
$data["language"] = $language;
$db->insert("tbl_country_language", $data);
echo "reload:" . $LNG["datasavesuccessfully"];

?>