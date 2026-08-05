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
if (!$API_ID2 && $API_ID) {
    $API_ID2 = $API_ID;
}
if ($orders && $API && $API_ID2) {
    $orders = trim($orders, ",");
    $APIID = explode("_", $API_ID2);
    dquery("UPDATE tbl_order_imei \r\n    set user_can_c=0,ORDERAPI='" . $API . "',ORDERAPI_ID='" . $APIID[0] . "' \r\n    WHERE order_id in (" . $orders . ") and ( user_can_c=1 or user_can_c=0  or user_can_c=8) ");
    echo "success: Connect successfully";
} else {
    echo "error: Field should not blank";
}

?>