<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["digitalunlockingname"] = "digitalunlocking";
$APIMODULE["digitalunlockingvisiblename"] = "DigitalUnlocking.tools [Unlimited Instant Server]";
$APIMODULE["digitalunlockingnotes"] = "";
function digitalunlocking_activate()
{
    GatewayField("digitalunlocking", "text", "apikey", "", "APi KEY", "100", "");
}
function digitalunlocking_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/digitalunlocking.class.php";
    $reqrest = digitalunlocking_api_request("account_info", $VAL["apikey"]);
    $reqrest = json_decode($reqrest, true);
    if ($reqrest["result"] == "success") {
        $return["Account email"] = "(" . $reqrest["login"] . ") " . $reqrest["mail"];
        $return["Credits available"] = $reqrest["credits"];
    }
    return $return;
}
function digitalunlocking_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/digitalunlocking.class.php";
    $reqrest = digitalunlocking_api_request("get_services", $VAL["apikey"]);
    $reqrest = json_decode($reqrest, true);
    if ($reqrest["result"] == "SUCCESS") {
        $return["Group"][0]["ID"] = "Digitalunlocking";
        $return["Group"][0]["Name"] = "Digitalunlocking";
        foreach ($reqrest["services"] as $K => $V) {
            if ($V["ID"]) {
                $return["Group"][0]["Tool"][$V["ID"]]["ID"] = $V["ID"];
                $return["Group"][0]["Tool"][$V["ID"]]["Name"] = $V["name"];
                $return["Group"][0]["Tool"][$V["ID"]]["Message"] = $V["descr"];
                $return["Group"][0]["Tool"][$V["ID"]]["Credits"] = $V["price"];
            }
        }
    }
    return $return;
}
function digitalunlocking_send($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/digitalunlocking.class.php";
    $reqrest = digitalunlocking_api_request("place_order", $VAL["apikey"], $VAL["IMEI"], $VAL["API_ID"]);
    $reqrest = json_decode($reqrest, true);
    if ($reqrest["order_id"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "Send Success";
        $return["ID"] = $reqrest["order_id"];
    }
    return $return;
}
function digitalunlocking_get($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/digitalunlocking.class.php";
    $reqrest = digitalunlocking_api_request("track_status", $VAL["apikey"], "", "", $VAL["API_ORDER_ID"]);
    $reqrest = json_decode($reqrest, true);
    print_r($reqrest);
    if (trim($reqrest["result"]) == "success") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "Code Found";
        $return["CODES"] = $reqrest["message"] ? $reqrest["message"] : "process successful";
    } else {
        if (trim($reqrest["result"]) == "reject") {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
        }
    }
    return $return;
}

?>