<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "nusoap/nusoap.php";
function GetQueue($api_url, $brute_email, $brute_password, $key, $keyIV)
{
    $client = new nusoap_client($api_url, true);
    $inpu_hash = Encrypt($brute_password . "||", $key, $keyIV);
    echo $result = $client->call("GetQueue", ["brute_email" => $brute_email, "input_hash" => $inpu_hash]);
    return $result;
}
function SetJobFile($api_url, $brute_email, $brute_password, $add_email, $log_type, $file_name, $file_data, $key, $keyIV)
{
    $client = new nusoap_client($api_url, true);
    $inpu_hash = Encrypt($brute_password . "||" . $add_email . "||" . $log_type . "||" . $file_name . "||" . $file_data . "||", $key, $keyIV);
    $result = $client->call("SetJobFile", ["brute_email" => $brute_email, "input_hash" => $inpu_hash]);
    return $result;
}
function CheckJob($api_url, $brute_email, $brute_password, $imei, $key, $keyIV)
{
    $client = new nusoap_client($api_url, true);
    $inpu_hash = Encrypt($brute_password . "||" . $imei . "||", $key, $keyIV);
    $result = $client->call("CheckJob", ["brute_email" => $brute_email, "input_hash" => $inpu_hash]);
    return $result;
}
function Encrypt($PlainText, $key, $keyIV)
{
    $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_CBC, "");
    if (mcrypt_generic_init($cipher, $key, $keyIV) != -1) {
        $cipherText = mcrypt_generic($cipher, $PlainText);
        mcrypt_generic_deinit($cipher);
    }
    return base64_encode($cipherText);
}

?>