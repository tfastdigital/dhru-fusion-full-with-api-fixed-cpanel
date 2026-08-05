<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["dlgsmname"] = "dlgsm";
$APIMODULE["dlgsmvisiblename"] = "dlgsm (Apple gsx report source)";
$APIMODULE["dlgsmnotes"] = "";
function dlgsm_activate()
{
    GatewayField("dlgsm", "text", "username", "", "Username", "100", "");
    GatewayField("dlgsm", "text", "apikey", "", "APi KEY", "100", "");
    GatewayField("dlgsm", "System", "server", "http://www.dlgsm.com/gsx/api_index.php", "Url/IP", "100", "");
}
function dlgsm_accoutinfo($VAL)
{
    $send["action"] = "getcredit";
    $send["API_ACCESS_KEY"] = trim($VAL["apikey"]);
    $send["USERNAME"] = trim($VAL["username"]);
    $request = initCurl($VAL["server"], $send);
    $request = json_decode($request, true);
    if ($request["SUCCESS"]) {
        $return["Credits available"] = "Credits available : " . $request["SUCCESS"]["CREDIT"];
    }
    if ($request["ERROR"]) {
        $return["ERROR"] = nl2br($request["ERROR"]["DESCRIPTION"]);
        $return["MESSAGE"] = $request["ERROR"]["DESCRIPTION"];
    }
    return $return;
}
function dlgsm_services($VAL)
{
    $send["action"] = "servicelist";
    $send["API_ACCESS_KEY"] = trim($VAL["apikey"]);
    $send["USERNAME"] = trim($VAL["username"]);
    $request = initCurl($VAL["server"], $send);
    $request = json_decode($request, true);
    foreach ($request["SUCCESS"]["LIST"] as $gk => $gv) {
        $GID = $gk;
        $return["Group"][$GID]["ID"] = $GID;
        $return["Group"][$GID]["Name"] = $gv["GROUPNAME"];
        $TID = NULL;
        foreach ($gv["SERVICES"] as $kt => $Tool) {
            $TID = (string) $Tool["SERVICEID"];
            $return["Group"][$GID]["Tool"][$TID]["ID"] = (string) $Tool["SERVICEID"];
            $return["Group"][$GID]["Tool"][$TID]["Name"] = (string) $Tool["SERVICENAME"];
            $return["Group"][$GID]["Tool"][$TID]["Message"] = (string) $Tool["INFO"];
            $return["Group"][$GID]["Tool"][$TID]["Credits"] = (string) $Tool["CREDIT"];
            $return["Group"][$GID]["Tool"][$TID]["Delivery.Unit"] = (string) $Tool["TIME"];
        }
    }
    return $return;
}
function dlgsm_send($VAL)
{
    $send["action"] = "placeimeiorder";
    $send["API_ACCESS_KEY"] = trim($VAL["apikey"]);
    $send["USERNAME"] = trim($VAL["username"]);
    $send["IMEI"] = trim($VAL["IMEI"]);
    $send["ID"] = $VAL["API_ID"];
    $request = initCurl($VAL["server"], $send);
    $request = json_decode($request, true);
    if ($request["SUCCESS"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "Code Found";
        $return["ID"] = $request["ID"];
        if ($request["SUCCESS"]["CODE"]) {
            $return["CODES"] = nl2br($request["SUCCESS"]["CODE"]);
        }
    }
    if ($request["ERROR"]) {
        $return["ERROR"] = nl2br($request["ERROR"]["DESCRIPTION"]);
        $return["MESSAGE"] = $request["ERROR"]["DESCRIPTION"];
    }
    return $return;
}
function dlgsm_get($VAL)
{
    $send["action"] = "orderstatus";
    $send["API_ACCESS_KEY"] = trim($VAL["apikey"]);
    $send["USERNAME"] = trim($VAL["username"]);
    $send["ORDERID"] = $VAL["API_ORDER_ID"];
    $request = initCurl($VAL["server"], $send);
    $request = json_decode($request, true);
    if ($request["SUCCESS"]["STATUS"] == 4) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars("Order Found");
        $return["CODES"] = $request["SUCCESS"]["CODE"]["response_code"];
    }
    if ($request["SUCCESS"]["STATUS"] == 2 || $request["SUCCESS"]["STATUS"] == 3) {
        $return["ERROR"] = "Refunded";
        $return["MESSAGE"] = $request["SUCCESS"]["CODE"]["response_code"];
    }
    if ($request["ERROR"]) {
        $return["ERROR"] = nl2br($request["ERROR"]["DESCRIPTION"]);
        $return["MESSAGE"] = $request["ERROR"]["DESCRIPTION"];
    }
    return $return;
}

?>