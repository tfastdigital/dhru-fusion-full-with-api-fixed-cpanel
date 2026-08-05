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
if ($_POST["compareproduct"]) {
    $_POST["compareproduct"] = 1;
} else {
    $_POST["compareproduct"] = 0;
}
if ($_POST["shoppingcart1"]) {
    $_POST["shoppingcart1"] = 0;
} else {
    $_POST["shoppingcart1"] = 1;
}
if ($_POST["cartforstore"]) {
    $_POST["cartforstore"] = 1;
} else {
    $_POST["cartforstore"] = "";
}
if ($_POST["retailmenu"]) {
    $_POST["retailmenu"] = 0;
} else {
    $_POST["retailmenu"] = "1";
}
if ($_POST["shippingcost"]) {
    $_POST["shippingcost"] = 1;
} else {
    $_POST["shippingcost"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:  " . $LNG["datasavesuccessfully"];

?>