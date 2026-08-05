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
$verioninfo = initCurl("http://broadcast.dhru.com/");
$verioninfo = new SimpleXMLElement($verioninfo);
$verioninfo = (array) $verioninfo;
$verioninfo = (array) $verioninfo["geodatabse"];
$cp = curl_init($verioninfo["dllink"]);
$fp = fopen("../../includes/geodata/GeoIP.dat", "w");
curl_setopt($cp, CURLOPT_FILE, $fp);
curl_setopt($cp, CURLOPT_HEADER, 0);
curl_exec($cp);
curl_close($cp);
fclose($fp);
saveSettings("geodate", $verioninfo["date"]);
echo "success: " . $LNG["database"] . " " . $LNG["updated"] . " " . $LNG["successfully"];

?>