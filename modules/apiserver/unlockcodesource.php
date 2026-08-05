<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["unlockcodesourcename"] = "unlockcodesource";
$APIMODULE["unlockcodesourcevisiblename"] = "Unlockcodesource.com (API V3)";
$APIMODULE["unlockcodesourcenotes"] = "Unlockcodesource api";
function unlockcodesource_activate()
{
    GatewayField("unlockcodesource", "text", "username", "", "Username", "300", "");
    GatewayField("unlockcodesource", "text", "password", "", "Password", "300", "");
    GatewayField("unlockcodesource", "text", "apikey", "", "APi KEY", "300", "");
    GatewayField("unlockcodesource", "System", "apiurl", "http://www.unlockcodesource.com/API_v2/ucs_apiv3.php", "apiurl", "30", "");
}
function unlockcodesource_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockcodesource.class.php";
    $ucs = new UCS();
    $ucs->username = $VAL["username"];
    $ucs->pass = $VAL["password"];
    $ucs->apikey = $VAL["apikey"];
    $ucs->action("get_accountinfo");
    $response = $ucs->response["data"];
    if ($response) {
        if (!$response["response"]["credits"]) {
            $return["ERROR"] = htmlspecialchars($response["response"]["message"]);
        } else {
            $return["Company Name"] = "Company Name : " . htmlspecialchars($response["response"]["company_name"]);
            $return["Credits available"] = htmlspecialchars($response["response"]["credits"]);
            return $return;
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function unlockcodesource_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockcodesource.class.php";
    $ucs = new UCS();
    $ucs->username = $VAL["username"];
    $ucs->pass = $VAL["password"];
    $ucs->apikey = $VAL["apikey"];
    $ucs->action("get_unlocktools");
    $response = $ucs->response["data"]["response"];
    if ($response) {
        if ($response["unlock_tools"]) {
            $return["Group"][$Group]["Name"] = "UCS Unlock Tools";
            $return["Group"][$Group]["ID"] = "UCSUNLOCKTOOLS";
            foreach ($response["unlock_tools"]["tool"] as $Tools => $SERVICES) {
                $MODEL_REQRED = NULL;
                $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["tool_id"];
                $return["Group"][$Group]["Tool"][$Tools]["Name"] = html_entity_decode($SERVICES["tool_name"]);
                $return["Group"][$Group]["Tool"][$Tools]["Message"] = htmlspecialchars($SERVICES["description"]);
                if (isset($SERVICES["supported"]["PhoneMakeID"])) {
                    $return["Group"][$GID]["Tool"][$Tools]["Requires.Mobile"] = "Required";
                }
                $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES["price"];
            }
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api ";
    }
    unset($response);
    return $return;
}
function unlockcodesource_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockcodesource.class.php";
    $ucs = new UCS();
    $ucs->username = $VAL["username"];
    $ucs->pass = $VAL["password"];
    $ucs->apikey = $VAL["apikey"];
    $ucs->action("get_unlocktools");
    $response = $ucs->response["data"]["response"];
    if ($response) {
        foreach ($VAL["services"] as $Tool) {
            if ($Tool["requires_mobile"] == "Required") {
                $BID = NULL;
                foreach ($response["unlock_tools"]["tool"] as $K => $V) {
                    if ($Tool["id"] == $V["tool_id"] && $V["supported"]["PhoneMakeID"][0]) {
                        foreach ($V["supported"]["PhoneMakeID"] as $gk => $Brand) {
                            $MID = $BID = $Brand["phonemake_id"];
                            $return["Brand"][$BID]["ID"] = $BID;
                            $return["Brand"][$BID]["Name"] = $Brand["phone_make"];
                            $return["Brand"][$BID]["Mobile"][$MID]["ID"] = $MID;
                            $return["Brand"][$BID]["Mobile"][$MID]["Name"] = "ALL";
                        }
                    }
                }
            }
        }
    }
    unset($response);
    return $return;
}
function unlockcodesource_send($VAL)
{
    global $debug_output;
    include_once ROOTDIR . "/modules/apiserver/class/unlockcodesource.class.php";
    $ucs = new UCS();
    $ucs->username = $VAL["username"];
    $ucs->pass = $VAL["password"];
    $ucs->apikey = $VAL["apikey"];
    $ucs->action("submit_order", ["imei" => $VAL["IMEI"], "phonemake_id" => $VAL["API_MODEL_ID"], "tool_id" => $VAL["API_ID"], "notes" => "Submitted By DHRU Fusion"]);
    $response = $ucs->response["data"]["response"];
    if ($debug_output) {
        echo "<h2>Module Send Order Array </h2>";
        print_r($response);
        echo "<hr />";
    }
    if ($response) {
        if ($response["status"] == "ERROR") {
            $return["ERROR"] = $response["message"];
            $return["MESSAGE"] = $response["message"];
        } else {
            if ($response["status"] == "OK") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($response["message"]);
                $return["ID"] = $response["orderID"];
            }
        }
    }
    return $return;
}
function unlockcodesource_get($VAL)
{
    global $debug_output;
    include_once ROOTDIR . "/modules/apiserver/class/unlockcodesource.class.php";
    $ucs = new UCS();
    $ucs->username = $VAL["username"];
    $ucs->pass = $VAL["password"];
    $ucs->apikey = $VAL["apikey"];
    $ucs->action("get_imei", ["imei" => $VAL["IMEI"]]);
    $response = $ucs->response["data"]["response"];
    if ($debug_output) {
        echo "<h2>Module Get Order Array </h2>";
        print_r($response);
        echo "<hr />";
    }
    if ($response) {
        if ($response["status"] == "N_EXIST" || $response["status"] == "NOT_FOUND" || $response["status"] == "N_EXIST") {
            $return["ERROR"] = $response["message"];
            $return["MESSAGE"] = $response["message"];
        } else {
            if ($response["status"] == "COMPLETED" && $response["order_status"] == "Available") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($response["message"]);
                $return["CODES"] = $response["unlockcode"];
            }
        }
    }
    return $return;
}

?>