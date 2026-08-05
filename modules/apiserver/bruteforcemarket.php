<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["bruteforcemarketname"] = "bruteforcemarket";
$APIMODULE["bruteforcemarketvisiblename"] = "Bruteforcemarket.com [File Service]";
$APIMODULE["bruteforcemarketnotes"] = "";
function bruteforcemarket_activate()
{
    GatewayField("bruteforcemarket", "System", "servicetype", "file", "servicetype", "60", "");
    GatewayField("bruteforcemarket", "text", "Username", "", "Username", "60", "");
    GatewayField("bruteforcemarket", "text", "Apikey", "", "APi Key", "30", "");
    GatewayField("bruteforcemarket", "System", "apiurl", "https://bruteforcemarket.com/api/", "APi url", "500", "");
}
function bruteforcemarket_accoutinfo($VAL)
{
    $cmd = "getinfo";
    $result = initCurl($VAL["apiurl"] . "?cmd=" . $cmd . "&bfm_user=" . urlencode($VAL[Username]) . "&bfm_key=" . urlencode($VAL["Apikey"]));
    $result = json_decode($result, true);
    if ($result["success"]) {
        $return["status"] = htmlspecialchars("waiting time : " . $result["waiting_time"]);
        $return["queue"] = htmlspecialchars("balance : " . $result["balance"]);
        $return["punchup"] = htmlspecialchars("punchup : " . $result["punchup"]);
        $return["b"] = "============================";
    } else {
        $return["ERROR"] = $result["error_msg"];
    }
    return $return;
}
function bruteforcemarket_services($VAL)
{
    $return["Group"][$Group]["Name"] = "bruteforcemarket";
    $return["Group"][$Group]["ID"] = "bruteforcemarket";
    $return["Group"][$Group]["Tool"]["bruteforcemarket"]["ID"] = "bruteforcemarket";
    $return["Group"][$Group]["Tool"]["bruteforcemarket"]["Name"] = "bruteforcemarket";
    $return["Group"][$Group]["Tool"]["bruteforcemarket"]["servicetype"] = "file";
    return $return;
}
function bruteforcemarket_sendfile($VAL)
{
    $cmd = "uploadfile";
    $result = initCurl($VAL["apiurl"] . "?cmd=" . $cmd . "&bfm_user=" . urlencode($VAL[Username]) . "&bfm_key=" . urlencode($VAL["Apikey"]) . "&filename=" . urlencode(trim($VAL["FILENAME"])) . "&content=" . urlencode($VAL["FILEDATA"]));
    $result = json_decode($result, true);
    if ($result["success"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $result["type"];
        $return["ID"] = $result["imei"];
    } else {
        if ($result["error_no"] == "E_018" || $result["error_no"] == "E_017") {
            $return["ERROR"] = $result["error_msg"] . " ";
            $return["MESSAGE"] = $result["error_msg"] . " ";
        }
    }
    return $return;
}
function bruteforcemarket_getfile($VAL)
{
    $cmd = "job";
    $result = initCurl($VAL["apiurl"] . "?cmd=" . $cmd . "&bfm_user=" . urlencode($VAL[Username]) . "&bfm_key=" . urlencode($VAL["Apikey"]) . "&imei=" . $VAL["API_ORDER_ID"]);
    $result = json_decode($result, true);
    if ($result["success"]) {
        if ($result["status"] == "FINISHED" || $result["status"] == "ARCHIVE") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Order Found";
            $code = $result["nck1"] . "<br />";
            $code .= $result["nck2"] . "<br />";
            $code .= $result["nck3"] . "<br />";
            $code .= $result["nck4"] . "<br />";
            $code .= $result["nck5"] . "<br />";
            $code .= $result["nck6"] . "<br />";
            $code .= $result["nck7"] . "<br />";
            $return["CODES"] = $code;
        }
    } else {
        if ($result["error_no"] == "E_012") {
            $return["ERROR"] = $result["error_msg"] . " ";
            $return["MESSAGE"] = $result["error_msg"] . " ";
        }
    }
    return $return;
}

?>