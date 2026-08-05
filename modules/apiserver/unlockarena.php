<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["unlockarenaname"] = "unlockarena";
$APIMODULE["unlockarenavisiblename"] = "unlockarena";
$APIMODULE["unlockarenanotes"] = "unlockarena";
function unlockarena_activate()
{
    GatewayField("unlockarena", "text", "ipaddress", "", "Website IP Address", "100", "");
    GatewayField("unlockarena", "text", "domainname", "", "Web domain name", "100", "");
    GatewayField("unlockarena", "text", "apikey", "", "API Key", "100", "");
    GatewayField("unlockarena", "text", "username", "", "Username", "100", "");
    GatewayField("unlockarena", "text", "password", "", "Password", "100", "");
    GatewayField("unlockarena", "text", "url", "http://192.163.227.46/", "APi Url", "100", "");
}
function unlockarena_services($VAL)
{
    $return["Group"][0]["ID"] = "unlockarena";
    $return["Group"][0]["Name"] = "unlockarena";
    $return["Group"][0]["Tool"]["2014NotFound"]["ID"] = "2014NotFound";
    $return["Group"][0]["Tool"]["2014NotFound"]["Name"] = "2014NotFound";
    $return["Group"][0]["Tool"]["2014NotFound"]["Credits"] = "1";
    $return["Group"][0]["Tool"]["UnlockCode2014Users"]["ID"] = "UnlockCode2014Users";
    $return["Group"][0]["Tool"]["UnlockCode2014Users"]["Name"] = "UnlockCode2014Users";
    $return["Group"][0]["Tool"]["UnlockCode2014Users"]["Credits"] = "1";
    $return["Group"][0]["Tool"]["UnlockCodeOtherUsers"]["ID"] = "UnlockCodeOtherUsers";
    $return["Group"][0]["Tool"]["UnlockCodeOtherUsers"]["Name"] = "UnlockCodeOtherUsers";
    $return["Group"][0]["Tool"]["UnlockCodeOtherUsers"]["Credits"] = "1";
    return $return;
}
function unlockarena_send($VAL)
{
    $send["ipaddress"] = trim($VAL["ipaddress"]);
    $send["domainname"] = trim($VAL["domainname"]);
    $send["imeicode"] = trim("358714050492473");
    $send["apikey"] = trim($VAL["apikey"]);
    $send["username"] = trim($VAL["username"]);
    $send["password"] = trim($VAL["password"]);
    $request = initCurl($VAL["url"] . "/imeiapp/imeiApplication/Webservices/IMEIWebservice.asmx/GetImeiAuthenticationUnlockCode2014Users", $send);
    print_r($send);
    echo $request;
    exit;
}
function unlockarena_get($VAL)
{
    $content = file_get_contents("http://unlockarena.pl/api.php?login=" . $VAL["username"] . "&pass=" . $VAL["password"] . "&act=read&imei=" . $VAL["IMEI"]);
    if ($content) {
        if (deregi("no role", $content) || deregi("err", $content)) {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = $content;
        } else {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = str_replace(",", "<br />", trim($content));
            $return["CODES"] = str_replace("-", "", $return["CODES"]);
            $return["CODES"] = str_replace($VAL["IMEI"], "", $return["CODES"]);
        }
    }
    return $return;
}

?>