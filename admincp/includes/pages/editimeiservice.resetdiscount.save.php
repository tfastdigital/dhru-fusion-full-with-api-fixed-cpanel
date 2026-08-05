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
dquery("DELETE FROM tbl_discount_imei where service_id='" . $id . "'");
dquery("DELETE FROM tbl_service_pricing WHERE serviceid='" . $id . "'\nand (groupid!='base' and groupid!='retail')");
echo "success:" . $LNG["discountresetsuccessfully"];

?>