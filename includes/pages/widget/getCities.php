<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
if (!isset($_COOKIE["DHRUFUSION"])) {
    http_response_code(404);
    exit;
}
require "./comm.php";
$stateCode = strtoupper(preg_replace("/[^A-Za-z0-9]/", "", $getCities));
$countryCode = strtoupper(preg_replace("/[^A-Za-z0-9]/", "", $country));
$_OUT = [];
if (!$countryCode) {
    $_OUT["status"] = "error";
    $_OUT["data"] = "Country code required.";
    _josnOUT($_OUT);
}
if ($_data = json_decode(file_get_contents("./includes/pages/widget/static/countries/" . $countryCode . ".json"), true)) {
    foreach ($_data["data"]["states"] as $sk => $sv) {
        if ($sv["state_code"] === $stateCode && 0 < count($sv["cities"])) {
            $_OUT["status"] = "success";
            $_OUT["data"] = $sv;
            _josnOUT($_OUT);
        }
    }
}
$_OUT["status"] = "error";
$_OUT["data"] = "No data found";
_josnOUT($_OUT);

?>