<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["unlockhkname"] = "unlockhk";
$APIMODULE["unlockhkvisiblename"] = "Unlock.HK";
$APIMODULE["unlockhknotes"] = "This UnlockHK api";
function unlockhk_activate()
{
    GatewayField("unlockhk", "text", "username", "", "Username", "100", "");
    GatewayField("unlockhk", "text", "apikey", "", "APi KEY", "100", "");
}
function unlockhk_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    $XML = UnlockHK::CallAPI("AccountInfo");
    if (is_string($XML)) {
        $Data = UnlockHK::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                $return["AccountEmail"] = htmlspecialchars($Data["Email"]);
                $return["Credits available"] = htmlspecialchars($Data["Credits"]);
                $return["b"] = "============================";
                return $return;
            }
        } else {
            echo "Could not parse the XML stream";
        }
    } else {
        echo "Could not communicate with the api";
    }
    return $return;
}
function unlockhk_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    $XML = UnlockHK::CallAPI("GetModels");
    if (is_string($XML)) {
        $Data = UnlockHK::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
            } else {
                $return = NULL;
                foreach ($Data["PhoneBrand"] as $PhoneBrand) {
                    $return["Group"][$PhoneBrand["Name"]]["ID"] = $PhoneBrand["ID"];
                    $return["Group"][$PhoneBrand["Name"]]["Name"] = $PhoneBrand["Name"];
                    foreach ($PhoneBrand["PhoneModel"] as $PhoneModel) {
                        $return["Group"][$PhoneBrand["Name"]]["Tool"][$PhoneModel["ID"]]["ID"] = $PhoneModel["ID"];
                        $return["Group"][$PhoneBrand["Name"]]["Tool"][$PhoneModel["ID"]]["Name"] = $PhoneModel["Name"];
                        $return["Group"][$PhoneBrand["Name"]]["Tool"][$PhoneModel["ID"]]["Credits"] = $PhoneModel["Credits"];
                        $return["Group"][$PhoneBrand["Name"]]["Tool"][$PhoneModel["ID"]]["Message"] = $PhoneModel["Remark"];
                    }
                }
                return $return;
            }
        } else {
            echo "Could not parse the XML stream";
        }
    } else {
        echo "Could not communicate with the api";
    }
    return $return;
}
function unlockhk_provider($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        echo "Getting Country/Netowrk for Service ID : " . $Tool["id"] . " : ";
        $XML = UnlockHK::CallAPI("GetNetWorks", ["ModelId" => $Tool["id"]]);
        if (is_string($XML)) {
            $Data = UnlockHK::ParseXML($XML);
            if (is_array($Data)) {
                if (isset($Data["Error"])) {
                    echo "No Network required for this service <br />";
                } else {
                    echo "feached.... Done <br />";
                    $return["Country"][$Tool["id"]]["ID"] = $Tool["id"];
                    $return["Country"][$Tool["id"]]["Name"] = $Tool["name"];
                    foreach ($Data["NetWork"] as $NetWork) {
                        $return["Country"][$Tool["id"]]["Network"][$NetWork["ID"]]["ID"] = $NetWork["ID"];
                        $return["Country"][$Tool["id"]]["Network"][$NetWork["ID"]]["Name"] = $NetWork["Name"];
                    }
                }
            } else {
                echo "Could not parse the XML stream";
            }
        } else {
            echo "Could not communicate with the api";
        }
    }
    return $return;
}
function unlockhk_assign_networks($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    if ($VAL["services"]) {
        foreach ($VAL["services"] as $Tool) {
            echo "Getting Assign Country/Netowrk for Service ID : " . $Tool["id"] . " : ";
            $XML = UnlockHK::CallAPI("GetNetWorks", ["ModelId" => $Tool["id"]]);
            if (is_string($XML)) {
                $Data = UnlockHK::ParseXML($XML);
                if (is_array($Data)) {
                    if (isset($Data["Error"])) {
                        echo "No Network required for this service <br />";
                    } else {
                        echo "feached.... Done <br />";
                        foreach ($Data["NetWork"] as $NetWork) {
                            $return[$Tool["id"]][$NetWork["ID"]]["ID"] = $NetWork["ID"];
                            $return[$Tool["id"]][$NetWork["ID"]]["Name"] = $NetWork["Name"];
                        }
                    }
                } else {
                    echo "Could not parse the XML stream";
                }
            } else {
                echo "Could not communicate with the api";
            }
        }
    }
    return $return;
}
function unlockhk_send($VAL)
{
    global $debug_output;
    $sendArr = NULL;
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            if ($customfield["name"] == "Provider ID") {
                $ProviderID = $customfield["value"];
            }
        }
    }
    $sendArr["Imei"] = $VAL["IMEI"];
    $PhoneBrandId = mysqli_fetch_assoc(dquery("SELECT `group` AS `GID` FROM `tbl_apiserversservices` WHERE `id` = '" . $VAL["API_ID"] . "' and `gateway` ='unlockhk' and `type` = 'Tool'"));
    $sendArr["PhoneBrandId"] = $PhoneBrandId["GID"];
    $sendArr["PhoneModelId"] = $VAL["API_ID"];
    $sendArr["TradeNo"] = $VAL["ORDERID"];
    $sendArr["COther"] = $VAL["PROVIDER"];
    unset($PhoneBrandId);
    if ($debug_output) {
        echo "<h2>Module Send Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
    }
    $XML = UnlockHK::CallAPI("AddImei", $sendArr);
    $sendArr = NULL;
    if (is_string($XML)) {
        $Data = UnlockHK::ParseXML($XML);
        if ($debug_output) {
            print_r($Data);
        }
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = htmlspecialchars($Data["Error"]);
                $return["MESSAGE"] = htmlspecialchars($Data["Error"]);
            } else {
                $return["SUCCESS"] = true;
                $return["ID"] = $VAL["ORDERID"];
            }
        }
    }
    return $return;
}
function unlockhk_get($VAL)
{
    global $debug_output;
    $sendArr = NULL;
    include_once ROOTDIR . "/modules/apiserver/class/unlockhk.class.php";
    define("UNLOCKHK_USER_NAME", $VAL["username"]);
    define("UNLOCKHK_API_KEY", $VAL["apikey"]);
    $sendArr["TradeNo"] = $VAL["API_ORDER_ID"];
    if ($debug_output) {
        echo "<h2>Module Get Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
    }
    $XML = UnlockHK::CallAPI("GetImei", $sendArr);
    if (is_string($XML)) {
        $Data = UnlockHK::ParseXML($XML);
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
                if ($Data["IMEI"][0]["SuccessCodeLine"] == "1") {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($Data["IMEI"][0]["Code"]);
                    $return["CODES"] = trim(str_replace($VAL["IMEI"], "", $Data["IMEI"][0]["Code"]));
                } else {
                    if ($Data["IMEI"][0]["FailCodeLine"] == "1") {
                        $return["ERROR"] = "Not Found";
                        $return["MESSAGE"] = "Not Found";
                    }
                }
            }
        }
    }
    return $return;
}

?>