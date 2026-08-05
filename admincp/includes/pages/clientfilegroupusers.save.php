<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
if (!isset($_SESSION[adminid])) {
    exit;
}
foreach ($groupuser as $uid => $newprice) {
    dquery("DELETE FROM tbl_discount_file where user_id='" . $uid . "'\r\n      and service_id='" . $serviceid . "'");
    $data["user_id"] = $uid;
    $data["service_id"] = $serviceid;
    $data["discount"] = $serviceprice[$uid] - $newprice;
    $db->insert("tbl_discount_file", $data);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>