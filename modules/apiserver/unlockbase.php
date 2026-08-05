<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["unlockbasename"] = "unlockbase";
$APIMODULE["unlockbasevisiblename"] = "Unlockbase.com (API V3)";
$APIMODULE["unlockbasenotes"] = "This unlockbase api";
function unlockbase_activate()
{
    GatewayField("unlockbase", "text", "apikey", "", "APi KEY", "30", "");
}
function unlockbase_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    $XML = UnlockBase::CallAPI("AccountInfo");
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                $return["Account email"] = htmlspecialchars($Data["Email"]);
                $return["Credits available"] = htmlspecialchars($Data["Credits"]);
                return $return;
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function unlockbase_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    $XML = UnlockBase::CallAPI("GetTools");
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                $Data["Group"]["CleanIMEICheck"]["ID"] = "CleanIMEICheck";
                $Data["Group"]["CleanIMEICheck"]["Name"] = "Clean IMEI Check";
                $Data["Group"]["CleanIMEICheck"]["Tool"][0]["ID"] = "CleanIMEICheck";
                $Data["Group"]["CleanIMEICheck"]["Tool"][0]["Name"] = "Clean IMEI Check (CheckMend Report)";
                $Data["Group"]["CleanIMEICheck"]["Tool"][0]["Credits"] = "2.99";
                return $Data;
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function unlockbase_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    $XML = UnlockBase::CallAPI("GetMobiles");
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                return $Data;
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function unlockbase_provider($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    $XML = UnlockBase::CallAPI("GetNetworks");
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                return $Data;
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function unlockbase_assign_networks($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    if ($VAL["services"]) {
        foreach ($VAL["services"] as $Tool) {
            if ($Tool["requires_network"] != "None") {
                $XML = UnlockBase::CallAPI("GetToolNetworks", ["ID" => $Tool["id"]]);
                if (is_string($XML)) {
                    $Data = UnlockBase::ParseXML($XML);
                    if (is_array($Data)) {
                        if (isset($Data["Error"])) {
                            $return["ERROR"] = htmlspecialchars($Data["Error"]);
                        } else {
                            $return[$Tool["id"]] = $Data["Network"];
                        }
                    } else {
                        $return["ERROR"] = "Could not parse the XML stream";
                    }
                } else {
                    $return["ERROR"] = "Could not communicate with the api";
                }
            }
        }
    }
    return $return;
}
function unlockbase_assign_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    if ($VAL["services"]) {
        foreach ($VAL["services"] as $Tool) {
            if ($Tool["requires_mobile"] == "Required") {
                $XML = UnlockBase::CallAPI("GetToolMobiles", ["ID" => $Tool["id"]]);
                if (is_string($XML)) {
                    $Data = UnlockBase::ParseXML($XML);
                    if (is_array($Data)) {
                        if (isset($Data["Error"])) {
                            $return["ERROR"] = htmlspecialchars($Data["Error"]);
                        } else {
                            saveApiAssignMobiles($Data["Mobile"], $VAL["apiservers"], true, $Tool["id"]);
                        }
                    } else {
                        $return["ERROR"] = "Could not parse the XML stream";
                    }
                } else {
                    $return["ERROR"] = "Could not communicate with the api";
                }
            }
        }
    }
    return $return;
}
function unlockbase_mep($VAL)
{
    $MEP = initCurl("http://dhrufusion.com/sync/mep.php");
    $response = new SimpleXMLElement($MEP);
    $response = obj2array($response);
    $response = array_unique($response["response"]);
    return $response;
}
function unlockbase_send($VAL)
{
    global $debug_output;
    $sendArr = NULL;
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            if ($customfield["name"] == "Provider ID") {
                $ProviderID = $customfield["value"];
            }
        }
    }
    $sendArr["Tool"] = $VAL["API_ID"];
    $sendArr["IMEI"] = $VAL["IMEI"];
    $sendArr["Comments"] = "Submitted by Dhru Fusion APi (#" . $VAL["ORDERID"] . ")";
    $sendArr["Mobile"] = $VAL["API_MODEL_ID"];
    $sendArr["Provider"] = $VAL["API_PROVIDER_ID"];
    if ($ProviderID) {
        $sendArr["Provider"] = $ProviderID;
    } else {
        $sendArr["Network"] = $VAL["API_PROVIDER_ID"];
    }
    $sendArr["PIN"] = $VAL["PIN"];
    $sendArr["KBH"] = $VAL["KBH"];
    $sendArr["MEP"] = $VAL["MEP"];
    $sendArr["PID"] = $VAL["PRD"];
    $sendArr["Type"] = $VAL["TYPE"];
    $sendArr["Locks"] = $VAL["LOCKS"];
    $sendArr["SN"] = $VAL["SN"];
    $sendArr["SecRO"] = $VAL["SecRO"];
    $sendArr["ICloudEmail"] = $VAL["ICloudEmail"];
    $sendArr["ICloudPhone"] = $VAL["ICloudPhone"];
    if ($debug_output) {
        echo "<h2>Module Send Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
    }
    if ($VAL["API_ID"] == "CleanIMEICheck") {
        $APiCammd = "PlaceCleanCheckOrder";
    } else {
        $APiCammd = "PlaceOrder";
    }
    $XML = UnlockBase::CallAPI($APiCammd, $sendArr);
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if (is_array($Data)) {
            if ($debug_output) {
                echo "<h2>Module Send Order Array </h2>";
                print_r($Data);
                echo "<hr />";
            }
            if (isset($Data["Error"])) {
                if (deregi("Order already submitted", htmlspecialchars($Data["Error"]))) {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($Data["Error"]);
                    $return["ID"] = $VAL["IMEI"];
                } else {
                    if (deregi("Order already submitted", htmlspecialchars($Data["Error"]))) {
                        $return["SUCCESS"] = true;
                        $return["MESSAGE"] = htmlspecialchars($Data["Error"]);
                        $return["ID"] = $VAL["IMEI"];
                    } else {
                        $return["ERROR"] = htmlspecialchars($Data["Error"]);
                        $return["MESSAGE"] = "ERROR 021";
                    }
                }
            } else {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($Data["Success"]);
                $return["ID"] = $Data["ID"];
                $return["CODES"] = $Data["Codes"];
            }
        }
    }
    return $return;
}
function unlockbase_get($VAL)
{
    global $debug_output;
    $sendArr = NULL;
    include_once ROOTDIR . "/modules/apiserver/class/unlockbase.class.php";
    if (strlen($VAL["API_ORDER_ID"]) == 15) {
        $sendArr["IMEI"] = $VAL["API_ORDER_ID"];
    } else {
        $sendArr["ID"] = $VAL["API_ORDER_ID"];
    }
    if ($debug_output) {
        echo "<h2>Module Get Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
    }
    if ($VAL["API_ID"] == "CleanIMEICheck") {
        $APiCammd = "GetCleanCheckOrders";
    } else {
        $APiCammd = "GetOrders";
    }
    $XML = UnlockBase::CallAPI($APiCammd, $sendArr);
    if (is_string($XML)) {
        $Data = UnlockBase::ParseXML($XML);
        if ($debug_output) {
            echo "<h2>Module Get Order Array og by api</h2>";
            print_r($Data);
            echo "<hr />";
        }
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
                $return["MESSAGE"] = "ERROR 030";
            } else {
                if ($VAL["API_ID"] == "CleanIMEICheck" && $Data["Order"][0]["Available"] == "True") {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($Data["Order"][0]["Status"]);
                    $return["CODES"] = $Data["Order"][0]["Status"];
                }
                if ($Data["Order"][0]["Status"] == "Delivered" && $Data["Order"][0]["Available"] == "True") {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($Data["Order"][0]["Codes"]);
                    $return["CODES"] = $Data["Order"][0]["Codes"];
                }
                if ($Data["Order"][0]["Status"] == "Canceled" || $Data["Order"][0]["Available"] == "False") {
                    $return["ERROR"] = $Data["Order"][0]["Reason"];
                    $return["MESSAGE"] = $Data["Order"][0]["Reason"];
                }
            }
        }
    }
    return $return;
}

?>