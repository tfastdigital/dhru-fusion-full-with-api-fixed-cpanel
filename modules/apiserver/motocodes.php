<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["motocodesname"] = "motocodes";
$APIMODULE["motocodesvisiblename"] = "motocodes.pl";
$APIMODULE["motocodesnotes"] = "motocodes.pl";
function motocodes_activate()
{
    GatewayField("motocodes", "text", "username", "", "Username", "100", "");
    GatewayField("motocodes", "text", "password", "", "Password", "100", "");
}
function motocodes_services($VAL)
{
    $return["Group"][0]["ID"] = "motocodes";
    $return["Group"][0]["Name"] = "motocodes";
    $return["Group"][0]["Tool"]["LgTool"]["ID"] = "motocodes";
    $return["Group"][0]["Tool"]["LgTool"]["Name"] = "motocodes";
    $return["Group"][0]["Tool"]["LgTool"]["Credits"] = "1";
    return $return;
}
function motocodes_send($VAL)
{
    $content = file_get_contents("http://motocodes.pl/api.php?login=" . $VAL["username"] . "&pass=" . $VAL["password"] . "&act=add&imei=" . $VAL["IMEI"]);
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
function motocodes_get($VAL)
{
    $content = file_get_contents("http://motocodes.pl/api.php?login=" . $VAL["username"] . "&pass=" . $VAL["password"] . "&act=read&imei=" . $VAL["IMEI"]);
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