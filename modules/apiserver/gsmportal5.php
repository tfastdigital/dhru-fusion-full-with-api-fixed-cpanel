<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["gsmportal5name"] = "gsmportal5";
$APIMODULE["gsmportal5visiblename"] = "Other GSM-Portal 5";
$APIMODULE["gsmportal5notes"] = "Connect Other GSM-Portal based site (Version 5.2.3 or above is required)";
include_once ROOTDIR . "/modules/apiserver/class/gsmportal1.class.php";
function gsmportal5_activate()
{
    GatewayField("gsmportal5", "text", "customname", "", "Name", "60", "");
    GatewayField("gsmportal5", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("gsmportal5", "text", "username", "", "Username", "30", "");
    GatewayField("gsmportal5", "text", "apiurl", "http://www.gsmportalsite.com/", "GSM-Portal URL", "500", "");
}
function gsmportal5_accoutinfo($VAL)
{
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $request = $api->action("GET_ACCOUNT_INFO");
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        echo "Mail : " . $request->reaply->mail . " <br />";
        echo "Account type : " . $request->reaply->accounttype . " <br />";
        $return["Credits available"] = $request->reaply->credit;
        echo "Gsm-Portal Version : <strong>" . $request->version . "</strong> <br />";
    } else {
        $return["ERROR"] = $request->statusmessage;
    }
    return $return;
}
function gsmportal5_services($VAL)
{
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $request = $api->action("GET_SERVICE_LIST");
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        $GID = NULL;
        foreach ($request->reaply->Group as $gk => $Group) {
            $GID = (string) $Group->ID;
            $return["Group"][$GID]["ID"] = (string) $Group->ID;
            $return["Group"][$GID]["Name"] = $Group->Name;
            $TID = NULL;
            foreach ($Group->Service as $kt => $Tool) {
                $TID = (string) $Tool->ID;
                $return["Group"][$GID]["Tool"][$TID]["ID"] = (string) $Tool->ID;
                $return["Group"][$GID]["Tool"][$TID]["Name"] = (string) $Tool->Name;
                $return["Group"][$GID]["Tool"][$TID]["Message"] = (string) $Tool->info;
                $return["Group"][$GID]["Tool"][$TID]["Credits"] = (string) $Tool->Credits;
                $return["Group"][$GID]["Tool"][$TID]["Delivery.Unit"] = (string) $Tool->Deliverytime;
                $return["Group"][$GID]["Tool"][$TID]["Requires.Network"] = (string) $Tool->network == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.Mobile"] = (string) $Tool->model == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.Provider"] = (string) $Tool->provider == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.PIN"] = (string) $Tool->PIN == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.KBH"] = (string) $Tool->KBH == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.MEP"] = (string) $Tool->mep == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.PRD"] = (string) $Tool->PRD == "1" ? "Required" : "None";
                $return["Group"][$GID]["Tool"][$TID]["Requires.Type"] = (string) $Tool->Type == "1" ? "Required" : "None";
            }
        }
        return $return;
    } else {
        $return["ERROR"] = $request->statusmessage;
        return $return;
    }
}
function gsmportal5_mobiles($VAL)
{
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $request = $api->action("GET_MODEL_LIST");
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        $BID = NULL;
        foreach ($request->reaply->Brand as $gk => $Brand) {
            echo $BID = (string) $Brand->ID;
            $return["Brand"][$BID]["ID"] = (string) $Brand->ID;
            $return["Brand"][$BID]["Name"] = (string) $Brand->Name;
            $MID = NULL;
            foreach ($Brand->Mobile as $gk => $Mobile) {
                $MID = (string) $Mobile->ID;
                $return["Brand"][$BID]["Mobile"][$MID]["ID"] = (string) $Mobile->ID;
                $return["Brand"][$BID]["Mobile"][$MID]["Name"] = (string) $Mobile->Name;
            }
        }
        return $return;
    } else {
        $return["ERROR"] = $request->statusmessage;
        return $return;
    }
}
function gsmportal5_provider($VAL)
{
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $request = $api->action("GET_PROVIDER_LIST");
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        $BID = NULL;
        foreach ($request->reaply->Country as $gk => $Country) {
            $BID = (string) $Country->ID;
            $return["Country"][$BID]["ID"] = (string) $Country->ID;
            $return["Country"][$BID]["Name"] = (string) $Country->Name;
            $MID = NULL;
            foreach ($Country->Network as $gk => $Network) {
                $MID = (string) $Network->ID;
                $return["Country"][$BID]["Network"][$MID]["ID"] = (string) $Network->ID;
                $return["Country"][$BID]["Network"][$MID]["Name"] = (string) $Network->Name;
            }
        }
        return $return;
    } else {
        $return["ERROR"] = $request->statusmessage;
        return $return;
    }
}
function gsmportal5_send($VAL)
{
    $return = $request = $sendPara = NULL;
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $sendPara["SERVICE_ID"] = $VAL["API_ID"];
    $sendPara["IMEI_LIST"] = base64_encode($VAL["IMEI"]);
    $sendPara["NETWORK_ID"] = $VAL["API_PROVIDER_ID"];
    $sendPara["MODEL_ID"] = $VAL["API_MODEL_ID"];
    $sendPara["PROVIDER_ID"] = $VAL["API_PROVIDER_ID"];
    $sendPara["MEP_ID"] = $VAL["MEP_ID"];
    $sendPara["PIN_ID"] = $VAL["PIN"];
    $sendPara["KBH_ID"] = $VAL["KBH"];
    $sendPara["PRD_ID"] = $VAL["PRD"];
    $sendPara["Type_ID"] = $VAL["TYPE"];
    $request = $api->action("PLACE_IMEI_ORDER", $sendPara);
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($request->reference_id);
        $return["ID"] = $request->reference_id;
    } else {
        $return["ERROR"] = $request->statusmessage;
    }
    return $return;
}
function gsmportal5_get($VAL)
{
    $return = $request = $sendPara = NULL;
    $api = new GsmPortal();
    $api->API_KEY = trim($VAL["apikey"]);
    $api->USERNAME = trim($VAL["username"]);
    $api->GSMPORTAL_URL = $VAL["apiurl"];
    $sendPara["REFERENCE_ID"] = $VAL["API_ORDER_ID"];
    $request = $api->action("GET_IMEI_ORDER", $sendPara);
    if ($request->status == "Success") {
        if ($request->version < $VAL["gsmportalversionreq"]) {
            $return["ERROR"] = "Gsm-portal Required version is : " . $VAL["gsmportalversionreq"];
            return $return;
        }
        if ($request->order_status == "available") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars($request->statusmessage);
            $return["CODES"] = $request->reaply;
        }
        if ($request->order_status == "rejected") {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
        }
    }
    return $return;
}

?>