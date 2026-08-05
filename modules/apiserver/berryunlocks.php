<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["berryunlocksname"] = "berryunlocks";
$APIMODULE["berryunlocksvisiblename"] = "berryunlocks.com";
$APIMODULE["berryunlocksnotes"] = "Berryunlocks.com api";
function berryunlocks_activate()
{
    GatewayField("berryunlocks", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("berryunlocks", "text", "apiurl", "http://bb.swiftunlocks.com/api/", "APi url", "500", "");
}
function berryunlocks_services($VAL)
{
    $return["Group"][0]["ID"] = "berryunlocks";
    $return["Group"][0]["Name"] = "berryunlocks.com";
    $return["Group"][0]["Tool"][0]["ID"] = "1";
    $return["Group"][0]["Tool"][0]["Name"] = "berryunlocks via mep";
    $return["Group"][0]["Tool"][0]["Message"] = "berryunlocks via mep";
    $return["Group"][0]["Tool"][0]["Requires.MEP"] = "Required";
    $return["Group"][0]["Tool"][1]["ID"] = "2";
    $return["Group"][0]["Tool"][1]["Name"] = "berryunlocks via provider";
    $return["Group"][0]["Tool"][1]["Message"] = "berryunlocks via provider";
    $return["Group"][0]["Tool"][1]["Requires.Provider"] = "Required";
    return $return;
}
function berryunlocks_mep($VAL)
{
    $send["key"] = $VAL["apikey"];
    $request = initCurl($VAL["apiurl"] . "/get-mep-codes", $send);
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        foreach ($request["out"]["meps"] as $key => $MEP) {
            $return[$key] = $MEP["code"];
        }
    } else {
        $return["ERROR"] = nl2br($request["error"]);
    }
    return $return;
}
function berryunlocks_provider($VAL)
{
    $send["key"] = $VAL["apikey"];
    $request = initCurl($VAL["apiurl"] . "/get-countries", $send);
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        $BID = NULL;
        $send["country"] = NULL;
        foreach ($request["out"]["countries"] as $gk => $Country) {
            $BID = $Country["id"];
            $return["Country"][$BID]["ID"] = $BID;
            $return["Country"][$BID]["Name"] = $Country["name"];
            $MID = NULL;
            $send["country"] = $BID;
            $request2 = initCurl($VAL["apiurl"] . "/get-country-providers", $send);
            $request2 = json_decode($request2, true);
            if ($request2["errno"] == "0") {
                foreach ($request2["out"]["providers"] as $gk => $Network) {
                    $MID = $Network["id"];
                    $return["Country"][$BID]["Network"][$MID]["ID"] = $MID;
                    $return["Country"][$BID]["Network"][$MID]["Name"] = $Network["name"];
                }
            }
        }
    } else {
        $return["ERROR"] = nl2br($request["error"]);
    }
    return $return;
}
function berryunlocks_send($VAL)
{
    $send["key"] = $VAL["apikey"];
    $send["imei"] = $VAL["IMEI"];
    if ($VAL["API_ID"] == "1") {
        $send["mep"] = $VAL["MEP"];
        $request = initCurl($VAL["apiurl"] . "/unlock-code-by-mep", $send);
    } else {
        if ($VAL["API_ID"] == "2") {
            $send["provider"] = $VAL["API_PROVIDER_ID"];
            $request = initCurl($VAL["apiurl"] . "/unlock-code-by-network", $send);
        }
    }
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "IMEI SENT TO berryunlocks.com";
        $return["ID"] = $request["out"]["ticket"];
    } else {
        $return["ERROR"] = nl2br($request["error"]);
        $return["MESSAGE"] = "Invalid field options ";
    }
    unset($send);
    unset($request);
    return $return;
}
function berryunlocks_get($VAL)
{
    $send["key"] = $VAL["apikey"];
    $send["ticket"] = $VAL["API_ORDER_ID"];
    $request = initCurl($VAL["apiurl"] . "/get-job-status", $send);
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        if ($request["out"]["status"] == "Solved") {
            $request2 = initCurl($VAL["apiurl"] . "/get-job-results", $send);
            $request2 = json_decode($request2, true);
            if ($request2["errno"] == "0") {
                $code = NULL;
                foreach ($request2["out"]["codes"] as $_codes) {
                    if (htmlspecialchars($_codes["mep2"])) {
                        $code .= " MEP2:" . $_codes["mep2"];
                    }
                    if (htmlspecialchars($_codes["mep4"])) {
                        $code .= " MEP4:" . $_codes["mep4"];
                    }
                    if (1 < count($request2["out"]["codes"])) {
                        $code .= " ";
                    }
                }
                if ($code) {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($code);
                    $return["CODES"] = $code;
                } else {
                    $return["ERROR"] = "APi error (Job status : Solved but code not return)";
                    $return["MESSAGE"] = "Not Found 632";
                }
            } else {
                $return["ERROR"] = "APi error (Could not connect to host)";
                $return["MESSAGE"] = "Not Found 632";
            }
        } else {
            if ($request["out"]["status"] == "Failed") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>