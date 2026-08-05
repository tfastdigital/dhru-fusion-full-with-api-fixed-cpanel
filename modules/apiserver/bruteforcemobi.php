<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["bruteforcemobiname"] = "bruteforcemobi";
$APIMODULE["bruteforcemobivisiblename"] = "Bruteforce.mobi [File Service]";
$APIMODULE["bruteforcemobinotes"] = "";
function bruteforcemobi_activate()
{
    GatewayField("bruteforcemobi", "System", "servicetype", "file", "servicetype", "60", "");
    GatewayField("bruteforcemobi", "text", "Username", "", "Login Mail", "60", "");
    GatewayField("bruteforcemobi", "text", "Password", "", "Password", "60", "");
    GatewayField("bruteforcemobi", "text", "Key", "", "Key", "30", "");
    GatewayField("bruteforcemobi", "text", "KeyIV", "", "KeyIV", "30", "");
    GatewayField("bruteforcemobi", "System", "apiurl", "http://bruteforce.mobi/api.asmx?wsdl", "APi url", "500", "");
}
function bruteforcemobi_accoutinfo($VAL)
{
    if (!function_exists("mcrypt_module_open")) {
        echo 1;
        $return["ERROR"] = "mcrypt_module_open functions now available on your server, contact your hosting provider to install this function .";
        return $return;
    }
    include_once ROOTDIR . "/modules/apiserver/class/bruteforcemobi.class.php";
    $result = GetQueue($VAL["apiurl"], $VAL["Username"], $VAL["Password"], $VAL["Key"], $VAL["KeyIV"]);
    print_r($result);
    if ($result["status"] == "ok") {
        $return["status"] = htmlspecialchars("status : " . $result["status"]);
        $return["queue"] = htmlspecialchars("queue : " . $result["queue"]);
        $return["b"] = "============================";
    } else {
        $return["ERROR"] = $result["status"];
    }
    return $return;
}
function bruteforcemobi_services($VAL)
{
    $return["Group"][$Group]["Name"] = "bruteforcemobi";
    $return["Group"][$Group]["ID"] = "bruteforcemobi";
    $return["Group"][$Group]["Tool"]["slow"]["ID"] = "slow";
    $return["Group"][$Group]["Tool"]["slow"]["Name"] = "slow";
    $return["Group"][$Group]["Tool"]["slow"]["servicetype"] = "file";
    $return["Group"][$Group]["Tool"]["fast"]["ID"] = "fast";
    $return["Group"][$Group]["Tool"]["fast"]["Name"] = "fast";
    $return["Group"][$Group]["Tool"]["fast"]["servicetype"] = "file";
    return $return;
}
function bruteforcemobi_sendfile($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/bruteforcemobi.class.php";
    $result = SetJobFile($VAL["apiurl"], $VAL["Username"], $VAL["Password"], "", $VAL["API_ID"], $VAL["FILENAME"], $VAL["FILEDATA"], $VAL["Key"], $VAL["KeyIV"]);
    if ($result["status"] == "ok") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = json_encode($request);
        $return["ID"] = $result["job_api_id"];
    }
    return $return;
}
function bruteforcemobi_getfile($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/bruteforcemobi.class.php";
    $result = CheckJob($VAL["apiurl"], $VAL["Username"], $VAL["Password"], $VAL["API_ORDER_ID"], $VAL["Key"], $VAL["KeyIV"]);
    if ($result["status"] == "ok") {
        if ($result["job_status"] == "Not found") {
            $return["ERROR"] = $result["job_status"] . " ";
            $return["MESSAGE"] = $result["job_status"] . " ";
        }
        if ($result["job_status"] == "Archived") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Order Found";
            $code = NULL;
            if ($result["master_code"]) {
                $code .= " Master code:" . $result["master_code"];
            }
            if ($result["nck"]) {
                $code .= " nck:" . $result["nck"];
            }
            $return["CODES"] = $code;
        }
    }
    return $return;
}

?>