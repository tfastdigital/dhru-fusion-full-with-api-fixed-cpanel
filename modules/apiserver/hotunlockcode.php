<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["hotunlockcodename"] = "hotunlockcode";
$APIMODULE["hotunlockcodevisiblename"] = "hotunlockcode.com";
$APIMODULE["hotunlockcodenotes"] = "hotunlockcode api";
include_once ROOTDIR . "/modules/apiserver/class/hotunlockcode.class.php";
function hotunlockcode_activate()
{
    GatewayField("hotunlockcode", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("hotunlockcode", "text", "username", "", "Username", "60", "");
    GatewayField("hotunlockcode", "System", "apiurl", "http://www.hotunlockcode.com/API/get.php", "apiurl", "500", "");
}
function hotunlockcode_services($VAL)
{
    $return["Group"][0]["ID"] = "1";
    $return["Group"][0]["Name"] = "hotunlockcode";
    $return["Group"][0]["Tool"]["hotunlockcode"]["ID"] = "1";
    $return["Group"][0]["Tool"]["hotunlockcode"]["Name"] = "Motorola";
    $return["Group"][0]["Tool"]["hotunlockcode"]["Message"] = "hotunlockcode unlcok service";
    $return["Group"][0]["Tool"]["hotunlockcode"]["Credits"] = "1";
    return $return;
}
function hotunlockcode_send($VAL)
{
    $url = "http://www.hotunlockcode.com/API/get.php";
    $data = "<REQUEST>\n\t\t\t\t<ACTION>PLACE_IMEI_ORDER</ACTION>  \n\t\t\t\t<SERVICE_ID>" . $VAL["API_ID"] . "</SERVICE_ID>\n\t\t\t\t<IMEI_LIST>" . base64_encode($VAL["IMEI"]) . "</IMEI_LIST>\n\t\t\t</REQUEST>";
    $fields = ["USERNAME" => $VAL["username"], "API_KEY" => $VAL["apikey"], "DATA" => $data];
    foreach ($fields as $key => $value) {
        $fields_string .= $key . "=" . $value . "&";
    }
    rtrim($fields_string, "&");
    $api = new XMLHttpRequest();
    $api->open("POST", (string) $url);
    $api->send("langpair=pt|en&" . $fields_string);
    if ($api->status == 200) {
        $api->responseText;
        $result = base64_decode($api->responseText);
        $response = new SimpleXMLElement($result);
        if ($response->status == "ok") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars($response->message);
            $return["ID"] = $VAL["IMEI"];
        } else {
            $return["ERROR"] = $response->status;
            $return["MESSAGE"] = $response->status;
        }
    } else {
        $return["ERROR"] = $api->error;
        $return["MESSAGE"] = "ERROR 029";
    }
    return $return;
}
function hotunlockcode_get($VAL)
{
    $url = "http://www.hotunlockcode.com/API/get.php";
    $data = "<REQUEST>\n\t\t\t\t<ACTION>GET_IMEI_ORDER</ACTION>  \n\t\t\t\t<IMEI>" . $VAL["IMEI"] . "</IMEI>\n\t\t\t</REQUEST>";
    $fields = ["USERNAME" => $VAL["username"], "API_KEY" => $VAL["apikey"], "DATA" => $data];
    foreach ($fields as $key => $value) {
        $fields_string .= $key . "=" . $value . "&";
    }
    rtrim($fields_string, "&");
    $api = new XMLHttpRequest();
    $api->open("POST", (string) $url);
    $api->send("langpair=pt|en&" . $fields_string);
    if ($api->status == 200) {
        $api->responseText;
        $result = base64_decode($api->responseText);
        $response = new SimpleXMLElement($result);
        if ($response->status == "OK" && $response->code != "UNAVAILABLE") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = $response->code;
            $return["CODES"] = $response->code;
        }
        if ($response->status == "OK" && $response->code == "UNAVAILABLE") {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
        }
    }
    return $return;
}

?>