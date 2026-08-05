<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function digitalunlocking_api_request($type, $key, $imei = "", $service_id = "", $order_id = "")
{
    $add_url = "";
    if ($imei != "") {
        $add_url .= "&imei=" . $imei;
    }
    if ($service_id != "") {
        $add_url .= "&service_id=" . $service_id;
    }
    if ($order_id != "") {
        $add_url .= "&order_id=" . $order_id;
    }
    $curl_url = "http://digitalunlocking.biz/apu_api.php?type=" . $type . "&key=" . $key . $add_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $curl_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    return $result;
}

?>