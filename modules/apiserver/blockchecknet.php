<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["blockchecknetname"] = "blockchecknet";
$APIMODULE["blockchecknetvisiblename"] = "blockcheck.net";
$APIMODULE["blockchecknetnotes"] = "This blockcheck.net api";
function blockchecknet_activate()
{
    GatewayField("blockchecknet", "text", "apikey", "", "APi KEY", "100", "");
}
function blockchecknet_accoutinfo($VAL)
{
    define("blockchecknet_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/blockchecknet.class.php";
    $api = new blockchecknet_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function blockchecknet_services($VAL)
{
    $return["Group"][0]["ID"] = "blockchecknet";
    $return["Group"][0]["Name"] = "blockchecknet";
    $return["Group"][0]["Tool"]["blockchecknet"]["ID"] = "blockchecknet";
    $return["Group"][0]["Tool"]["blockchecknet"]["Name"] = "blockchecknet";
    $return["Group"][0]["Tool"]["blockchecknet"]["Message"] = "blockchecknet";
    $return["Group"][0]["Tool"]["blockchecknet"]["Credits"] = "1";
    $return["Group"][0]["Tool"]["blockchecknet"]["Requires.Network"] = "Required";
    return $return;
}
function blockchecknet_provider($VAL)
{
    $BID = NULL;
    $BID = 1;
    $return["Country"][$BID]["ID"] = $BID;
    $return["Country"][$BID]["Name"] = "Country";
    $return["Country"][$BID]["Network"][1]["ID"] = 1;
    $return["Country"][$BID]["Network"][1]["Name"] = "USA";
    $return["Country"][$BID]["Network"][2]["ID"] = 2;
    $return["Country"][$BID]["Network"][2]["Name"] = "UK All Networks";
    $return["Country"][$BID]["Network"][3]["ID"] = 3;
    $return["Country"][$BID]["Network"][3]["Name"] = "Australia All Networks";
    $return["Country"][$BID]["Network"][4]["ID"] = 4;
    $return["Country"][$BID]["Network"][4]["Name"] = "SFR France";
    $return["Country"][$BID]["Network"][5]["ID"] = 5;
    $return["Country"][$BID]["Network"][5]["Name"] = "Telenor Sweden";
    $return["Country"][$BID]["Network"][6]["ID"] = 6;
    $return["Country"][$BID]["Network"][6]["Name"] = "Claro Chile";
    $return["Country"][$BID]["Network"][7]["ID"] = 7;
    $return["Country"][$BID]["Network"][7]["Name"] = "TELE2 Sweden";
    $return["Country"][$BID]["Network"][8]["ID"] = 8;
    $return["Country"][$BID]["Network"][8]["Name"] = "TELE2 Estonia";
    $return["Country"][$BID]["Network"][9]["ID"] = 9;
    $return["Country"][$BID]["Network"][9]["Name"] = "Ireland All Networks";
    $return["Country"][$BID]["Network"][10]["ID"] = 10;
    $return["Country"][$BID]["Network"][10]["Name"] = "10th";
    $return["Country"][$BID]["Network"][11]["ID"] = 11;
    $return["Country"][$BID]["Network"][11]["Name"] = "11th";
    $return["Country"][$BID]["Network"][12]["ID"] = 12;
    $return["Country"][$BID]["Network"][12]["Name"] = "12th";
    $return["Country"][$BID]["Network"][13]["ID"] = 13;
    $return["Country"][$BID]["Network"][13]["Name"] = "13th";
    $return["Country"][$BID]["Network"][14]["ID"] = 14;
    $return["Country"][$BID]["Network"][14]["Name"] = "14th";
    return $return;
}
function blockchecknet_send($VAL)
{
    define("blockchecknet_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/blockchecknet.class.php";
    $api = new blockchecknet_API();
    $api->sendCommand("IMEI_SUBMIT", ["imei" => $VAL["IMEI"], "country_id" => $VAL["API_PROVIDER_COUNTRY_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["ID"]) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Send Success";
            $return["ID"] = $response["IMEI1"]["ID"];
        }
    }
    return $return;
}
function blockchecknet_get($VAL)
{
    define("blockchecknet_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/blockchecknet.class.php";
    $api = new blockchecknet_API();
    $api->sendCommand("IMEI_STATUS", ["id" => $VAL["API_ORDER_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["STATUS"] == "1") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = "Blocked " . $response["IMEI1"]["CHECKMEND_ID"];
        } else {
            if ($response["IMEI1"]["STATUS"] == "2") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = "Code Found";
                $return["CODES"] = "Clean - " . $response["IMEI1"]["CHECKMEND_ID"];
            } else {
                if ($response["IMEI1"]["STATUS"] == "3") {
                    $return["ERROR"] = "Not Found";
                    $return["MESSAGE"] = "Not Found";
                }
            }
        }
    }
    return $return;
}

?>