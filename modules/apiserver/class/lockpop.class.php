<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getLockpop($requestBody, $url)
{
    $headers[] = "Content-Type: application/atom+xml";
    $options = [CURLOPT_URL => $url, CURLOPT_HTTPHEADER => $headers, CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => $requestBody, CURLOPT_POST => true];
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    if (curl_errno($crul) != CURLE_OK) {
        echo curl_error($crul);
        curl_close($crul);
        return false;
    }
    curl_close($crul);
    $response = new SimpleXMLElement($response);
    return $response;
}

?>