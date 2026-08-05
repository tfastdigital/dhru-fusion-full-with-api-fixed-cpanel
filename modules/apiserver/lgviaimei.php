<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["lgviaimeiname"] = "lgviaimei";
$APIMODULE["lgviaimeivisiblename"] = "lg-via-imei.com";
$APIMODULE["lgviaimeinotes"] = "lg-via-imei.com";
function lgviaimei_activate()
{
    GatewayField("lgviaimei", "text", "username", "", "Username", "100", "");
    GatewayField("lgviaimei", "text", "password", "", "Password", "100", "");
}
function lgviaimei_services($VAL)
{
    $return["Group"][0]["ID"] = "lgviaimei";
    $return["Group"][0]["Name"] = "lgviaimei";
    $return["Group"][0]["Tool"]["LgTool"]["ID"] = "lgviaimei";
    $return["Group"][0]["Tool"]["LgTool"]["Name"] = "Lg via imei";
    $return["Group"][0]["Tool"]["LgTool"]["Credits"] = "1";
    return $return;
}
function lgviaimei_send($VAL)
{
    $content = file_get_contents("http://lg-via-imei.com/api.php?login=" . $VAL["username"] . "&pass=" . $VAL["password"] . "&act=add&imei=" . $VAL["IMEI"]);
    if ($content) {
        if (trim($content) == "ok:imei was added") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Send Success";
            $return["ID"] = $VAL["IMEI"];
        } else {
            $return["ERROR"] = $content;
            $return["MESSAGE"] = "ERROR 035";
        }
    }
    return $return;
}
function lgviaimei_get($VAL)
{
    $content = file_get_contents("http://lg-via-imei.com/api.php?login=" . $VAL["username"] . "&pass=" . $VAL["password"] . "&act=read&imei=" . $VAL["IMEI"]);
    if ($content) {
        if (deregi("no role", $content) || deregi("err", $content)) {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
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