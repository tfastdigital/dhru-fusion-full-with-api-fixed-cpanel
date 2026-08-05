<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "favourite";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"] && $UserDetails["id"]) {
    $favouriteid = $parameters["favourite"];
    $Fav = mysqli_fetch_assoc(dquery("select imeifrequent from tblUsers\nwhere id='" . $UserDetails["id"] . "'"));
    $freq = explode(",", $Fav["imeifrequent"]);
    if (in_array($favouriteid, $freq)) {
        if (($key = array_search($favouriteid, $freq)) !== false) {
            unset($freq[$key]);
        }
    } else {
        $freq[] = $favouriteid;
    }
    $freq = implode(",", $freq);
    dquery("UPDATE tblUsers set imeifrequent='" . $freq . "' WHERE id='" . $UserDetails["id"] . "'");
    $apiresults["SUCCESS"][] = ["message" => "Your Favourite list updated", "data" => $Fav];
}

?>