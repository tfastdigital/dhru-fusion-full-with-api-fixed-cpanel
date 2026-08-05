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
$getStates = strtoupper(preg_replace("/[^A-Za-z0-9]/", "", $getStates));
if ($_data = json_decode(file_get_contents("./includes/pages/widget/static/countries/" . $getStates . ".json"), true)) {
    if ($getStates === "GB") {
        foreach ($_data["data"]["states"] as $sk => $sv) {
            if (!count($_data["data"]["states"][$sk]["cities"])) {
                unset($_data["data"]["states"][$sk]);
            }
        }
    }
    foreach ($_data["data"]["states"] as $sk => $sv) {
        unset($_data["data"]["states"][$sk]["cities"]);
    }
    _josnOUT($_data);
}
$_OUT["status"] = "error";
$_OUT["data"] = "No data found";
_josnOUT($_OUT);

?>