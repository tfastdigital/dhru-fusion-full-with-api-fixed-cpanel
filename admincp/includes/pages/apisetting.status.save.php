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
$flag = true;
foreach ($service as $sid => $v) {
    if (!dquery("update tbl_services_imei set \n    credit='" . $v . "' where id='" . $sid . "'")) {
        $flag = false;
    }
}
if ($flag) {
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li>";
} else {
    echo "error:" . $LNG["datanotsave"];
}

?>