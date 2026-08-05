<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["dcunlockename"] = "dcunlocke";
$APIMODULE["dcunlockevisiblename"] = "dc-unlocker.com";
$APIMODULE["dcunlockenotes"] = "dc-unlocker.com v2.02";
function dcunlocke_activate()
{
    GatewayField("dcunlocke", "text", "username", "", "Username", "500", "");
    GatewayField("dcunlocke", "text", "password", "", "Password", "500", "");
}
function dcunlocke_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/dcunlocke.class.php";
    define("DCU_API_PUBLIC_KEY", ROOTDIR . "/modules/apiserver/class/dcunlocker.key");
    $API = new DCUnlockerAPI($VAL[username], $VAL[password]);
    $action = $API->information();
    $action->creditsLeft();
    $message = $action->submit();
    $request = $message->get_response();
    if (!$request[errors]) {
        $return["username"] = $request[response][checked_name];
        $return["credits used"] = $request[response][credits_used];
        $return["credits left"] = $request[response][credits_left];
        return $return;
    }
    if ($request["errors"]) {
        $return["ERROR"] = $request[response][message];
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function dcunlocke_services($VAL)
{
    $tools = [];
    include_once ROOTDIR . "/modules/apiserver/class/dcunlocke.class.php";
    define("DCU_API_PUBLIC_KEY", ROOTDIR . "/modules/apiserver/class/dcunlocker.key");
    $API = new DCUnlockerAPI($VAL[username], $VAL[password]);
    $action = $API->information();
    $CustomFields_Username_withtype = $CustomFields_Username = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Username";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields_Username[] = $__CustomFields;
    $CustomFields_Username_withtype[] = $__CustomFields;
    $CustomFields_Username = $__CustomFields = [];
    $__CustomFields[fieldtype] = "dropdown";
    $__CustomFields[fieldoptions] = "NewUser,ExistingUser";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "USERTYPE";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields_Username_withtype[] = $__CustomFields;
    $CustomFields_srno = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Serial No";
    $__CustomFields[description] = "Dongle Serial to Renew";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields_srno[] = $__CustomFields;
    $tools["Activation"]["vygis-full"]["name"] = "DC Unlocker activation with 50 credits Vygis Dongle";
    $tools["Activation"]["vygis-full"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["vygis-lite"]["name"] = "DC Unlocker activation LITE (0 credits) Vygis Dongle";
    $tools["Activation"]["vygis-lite"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["infinity-full"]["name"] = "DC Unlocker activation with 50 credits Infinity Dongle";
    $tools["Activation"]["infinity-full"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["infinity-lite"]["name"] = "DC Unlocker activation LITE (0 credits) Infinity Dongle";
    $tools["Activation"]["infinity-lite"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["rocker-full"]["name"] = "DC Unlocker activation with 50 credits Rocker Dongle";
    $tools["Activation"]["rocker-full"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["rocker-lite"]["name"] = "DC Unlocker activation LITE (0 credits) Rocker Dongle";
    $tools["Activation"]["rocker-lite"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["auto-full"]["name"] = "DC Unlocker activation with 50 credits (Dongle Type Auto detection)";
    $tools["Activation"]["auto-full"]["custom"] = $CustomFields_srno;
    $tools["Activation"]["auto-lite"]["name"] = "DC Unlocker activation LITE (0 credits) (Dongle Type Auto detection)";
    $tools["Activation"]["auto-lite"]["custom"] = $CustomFields_srno;
    $tools["Support"]["year-1"]["name"] = "DC Unlocker activation Activation 1 Year Support";
    $tools["Support"]["year-1"]["custom"] = $CustomFields_srno;
    $tools["Support"]["year-1"]["price"] = 15;
    $tools["Support"]["year-2"]["name"] = "DC Unlocker activation Activation 2 Year Support";
    $tools["Support"]["year-2"]["custom"] = $CustomFields_srno;
    $tools["Support"]["year-2"]["price"] = 25;
    $action->getTimedLicenseList();
    $message = $action->submit();
    $results = $message->get_response();
    foreach ($results[response][licenses] as $k => $v) {
        $_id = $v[id];
        $tools["License"]["license-" . $_id]["name"] = "DC Unlocker " . $v[name];
        $tools["License"]["license-" . $_id]["custom"] = $CustomFields_Username;
        $tools["License"]["license-" . $_id]["description"] = $v[description];
        $tools["License"]["license-" . $_id]["price"] = $v[price];
    }
    $action->getFeaturesList();
    $message = $action->submit();
    $results = $message->get_response();
    foreach ($results[response][features] as $k => $v) {
        $_id = $v[id];
        $tools["Features"]["features-" . $_id]["name"] = "DC Unlocker " . $v[name];
        $tools["Features"]["features-" . $_id]["custom"] = $CustomFields_srno;
        $tools["Features"]["features-" . $_id]["description"] = $v[description];
        $tools["Features"]["features-" . $_id]["price"] = $v[price];
    }
    $tools["Credits"]["credits-todongle"]["name"] = "DC Unlocker Add Credits To Dongle";
    $tools["Credits"]["credits-todongle"]["custom"] = $CustomFields_srno;
    $tools["Credits"]["credits-todongle"]["qnt"] = 1;
    $tools["Credits"]["credits-touser"]["name"] = "DC Unlocker Add Credits To New/Existing User";
    $tools["Credits"]["credits-touser"]["custom"] = $CustomFields_Username_withtype;
    $tools["Credits"]["credits-touser"]["qnt"] = 1;
    $tools["Credits"]["credits-toreseller"]["name"] = "DC Unlocker Add Credits To New/Existing Reseller";
    $tools["Credits"]["credits-toreseller"]["custom"] = $CustomFields_Username_withtype;
    $tools["Credits"]["credits-toreseller"]["qnt"] = 1;
    $i = 0;
    foreach ($tools as $group => $tool) {
        $gid = $group;
        $return["Group"][$i]["ID"] = $gid;
        $return["Group"][$i]["Name"] = $gid;
        $return["Group"][$i]["GroupType"] = "SERVER";
        foreach ($tool as $k => $v) {
            $toolID = $k;
            $return["Group"][$i]["Tool"][$toolID]["ID"] = $toolID;
            $return["Group"][$i]["Tool"][$toolID]["ToolType"] = "SERVER";
            $return["Group"][$i]["Tool"][$toolID]["TypeID"] = $gid;
            $return["Group"][$i]["Tool"][$toolID]["QNT"] = $v[qnt] ? $v[qnt] : 0;
            $return["Group"][$i]["Tool"][$toolID]["Name"] = $v[name];
            $return["Group"][$i]["Tool"][$toolID]["Requires.Custom"] = $v[custom];
            $return["Group"][$i]["Tool"][$toolID]["Credits"] = $v[price];
            $return["Group"][$i]["Tool"][$toolID]["Message"] = utf8_decode($v[description]);
        }
        $i++;
    }
    return $return;
}
function dcunlocke_send($VAL)
{
    $testmode = false;
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
        $_srno = $customfields["Serial No"];
        $_username = $customfields["Username"];
        $_newUsername = preg_replace("/[^a-zA-Z0-9.-]/i", "", $_username);
        $_usertype = $customfields["USERTYPE"];
    }
    include_once ROOTDIR . "/modules/apiserver/class/dcunlocke.class.php";
    define("DCU_API_PUBLIC_KEY", ROOTDIR . "/modules/apiserver/class/dcunlocker.key");
    $API = new DCUnlockerAPI($VAL[username], $VAL[password]);
    trim($VAL["API_TYPEID"]);
    switch (trim($VAL["API_TYPEID"])) {
        case "Features":
            list($featureId) = explode("-", $VAL[API_ID]);
            $action = $API->activateFeature();
            $action->dongleName($_srno);
            $action->featureId($featureId);
            if ($testmode) {
                $action->testModeOn();
            }
            break;
        case "License":
            list($licenceId) = explode("-", $VAL[API_ID]);
            $action = $API->activateLicense();
            $action->userName($_username);
            $action->licenseId($licenceId);
            if ($testmode) {
                $action->testModeOn();
            }
            break;
        case "Support":
            list($supportType) = explode("-", $VAL[API_ID]);
            $action = $API->renewDongleSupport();
            $action->dongleName($_srno);
            $action->supportType($supportType);
            if ($testmode) {
                $action->testModeOn();
            }
            break;
        case "Activation":
            list($_dingletype) = explode("-", $VAL[API_ID]);
            list($_activaiyonType) = explode("-", $VAL[API_ID]);
            if ($_dingletype == "vygis") {
                $action = $API->activateVygisDongle();
            } else {
                if ($_dingletype == "infinity") {
                    $action = $API->activateInfinityDongle();
                } else {
                    if ($_dingletype == "rocker") {
                        $action = $API->activateRockerDongle();
                    } else {
                        if ($_dingletype == "auto") {
                            $action = $API->activateDongle();
                        }
                    }
                }
            }
            $action->dongleName($_srno);
            if ($_activaiyonType == "full") {
                $action->activationFull();
            } else {
                $action->activationLite();
            }
            if ($testmode) {
                $action->testModeOn();
            }
            break;
        case "Credits":
            list($_credtisto) = explode("-", $VAL[API_ID]);
            if ($_credtisto == "todongle") {
                $action = $API->addCreditsToDongle($_srno, $VAL["QNT"]);
            } else {
                if ($_credtisto == "touser") {
                    if ($_usertype == "ExistingUser") {
                        $action = $API->addCreditsToUser($_username, $VAL["QNT"]);
                    } else {
                        $action = $API->createNewUser($_newUsername, $VAL["QNT"]);
                    }
                } else {
                    if ($_credtisto == "toreseller") {
                        if ($_usertype == "ExistingUser") {
                            $action = $API->addCreditsToUser($_username, $VAL["QNT"]);
                        } else {
                            $action = $API->createNewUser($_newUsername, $VAL["QNT"], true);
                        }
                    }
                }
            }
            if ($testmode) {
                $action->testModeOn();
            }
            break;
        default:
            $message = $action->submit();
            $request = $message->get_response();
            print_r($request);
            if ($request[errors]) {
                $return["ERROR"] = nl2br(json_encode($request));
                $return["MESSAGE"] = nl2br($request[response][message]);
            } else {
                if ($request[response][status]) {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = nl2br(json_encode($request));
                    if ($request[response][new_user_pass]) {
                        $return["CODES"] = $request[response][message] . " <br /> Username : " . $request[response][user_name] . "<br /> Password : " . $request[response][new_user_pass] . "<br /> Credits : " . $request[response][credits];
                    } else {
                        $return["CODES"] = $request[response][message];
                    }
                }
            }
            print_r($return);
            unset($send);
            unset($request);
            return $return;
    }
}

?>