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
$data["discount"] = "0";
if ($db->update("tbl_discount_server_log", $data, "service_id=" . $id)) {
    dquery("UPDATE  tbl_client_group_price SET discount='' WHERE service_id='" . $id . "' \n    AND service_type='server'");
    echo "success:" . $LNG["discountresetsuccessfully"];
}

?>