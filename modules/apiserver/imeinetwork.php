<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["imeinetworkname"] = "imeinetwork";
$APIMODULE["imeinetworkvisiblename"] = "imeinetwork.com/sites made by imeinetwork (No more support)";
$APIMODULE["imeinetworknotes"] = "";
function imeinetwork_activate()
{
    GatewayField("imeinetwork", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("imeinetwork", "text", "apiurl", "", "APi url", "500", "for e.g. http://imeinetwork1.com/");
}
function imeinetwork_accoutinfo($VAL)
{
    return $return;
}
function imeinetwork_services($VAL)
{
    return $return;
}
function imeinetwork_mobiles($VAL)
{
    return $return;
}
function imeinetwork_provider($VAL)
{
    return $return;
}
function imeinetwork_mep($VAL)
{
    return $return;
}
function imeinetwork_send($VAL)
{
    return $return;
}
function imeinetwork_get($VAL)
{
    return $return;
}

?>