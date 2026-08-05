<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

header("Status: 200", true, 200);
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");
$OUT = [];
$OUT["server"] = $_SERVER["SERVER_SOFTWARE"];
if (contains($_SERVER["SERVER_SOFTWARE"], "nginx")) {
    $OUT["nginx"] = true;
    $OUT["server"] = "nginx";
} else {
    $OUT["nginx"] = false;
}
echo json_encode($OUT);
function contains($string, $find)
{
    return stripos($string, $find) !== false;
}

?>