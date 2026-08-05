<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace licince;

require "JWT.php";
require "JWK.php";
require_once "fun.inc.php";
class licince
{
}
function getLicenseDetails($call_from_internal = false, $force_check = false)
{
    global $config;
    global $db;
    global $licinfo;
    $LICENSE = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_license` WHERE `id`=1"));
    if (!$LICENSE["license_key"]) {
        throw new \Exception("Your product is not activated!");
    }
    if (!$LICENSE["verify_key"]) {
        $LICENSE["verify_key"] = updateLicensePublicKeys();
    }
    if (!$LICENSE["verify_key"]) {
        throw new \Exception("Unable to get product token, please contact support");
    }
    if (!$LICENSE["local_key"] || $force_check) {
        $LICENSE["local_key"] = updateLicenseLocalKey($LICENSE["license_key"]);
    }
    if (!$LICENSE["local_key"]) {
        throw new \Exception("Unable to update local key, please contact support");
    }
    $jwks = json_decode(base64_decode($LICENSE["verify_key"]), true);
    $jwt = $LICENSE["local_key"];
    try {
        \Firebase\JWT\JWT::$leeway = 5000;
        $_license_data = json_decode(json_encode(\Firebase\JWT\JWT::decode($jwt, \Firebase\JWT\JWK::parseKeySet($jwks), ["RS256"])), true);
    } catch (\Exception $e) {
        $_error = $e->getMessage();
        if (!$call_from_internal && $_error === "Expired token") {
            updateLicenseLocalKey($LICENSE["license_key"]);
            return getLicenseDetails(true);
        }
        throw new \Exception("Decode License Data Error#1002 : " . $_error);
    } catch (\TypeError $e) {
        $_error = $e->getMessage();
        throw new \Exception("Decode License Data Error#1001 : " . $_error);
    }
    if (reqaddon("Messenger Notification", true)) {
        saveSettings("slacksubscription", "1");
    }
    if (reqaddon("E-commerce", true)) {
        saveSettings("shoppingcart", 1);
    }
    if (reqaddon("Remove Branding", true)) {
        saveSettings("RemoveBranding", "true");
    }
    if (reqaddon("Reseller Store", true)) {
    }
    $_license_data["data"]["product_token"] = $LICENSE["license_key"];
    return $licinfo = $_license_data["data"];
}
function updateLicenseLocalKey($product_token)
{
    $post_json["domain"] = $_SERVER["SERVER_NAME"];
    $_req = json_decode(initCurl("https://api.dhru.com/integration/api/v1/verifylicense?token=" . $product_token, "", "", "", $post_json), true);
    if ($_req["code"] == 404) {
        dquery("UPDATE `tbl_license` SET `local_key`='',`license_key`=''");
        $_error = urlencode("You need to re-active your product! (Owner changed or Product not found)");
        echo "<script type=\"text/javascript\"> window.parent.location = \"update_lic.php?error=" . $_error . "\" </script>";
        header("location: update_lic.php?error=" . $_error);
        exit;
    }
    if ($_req["data"]["license_local_key"]) {
        $_license_local_key = $_req["data"]["license_local_key"];
        $_product_token = $_req["data"]["product_token"];
        dquery("UPDATE `tbl_license` SET `local_key`='" . $_license_local_key . "',`license_key`='" . $_product_token . "'");
        return $_license_local_key;
    }
    return false;
}
function updateLicensePublicKeys()
{
    $_req = base64_encode(initCurl("https://api.dhru.com/client/api/v1/authorize_keys"));
    $_time = time();
    if ($_req) {
        dquery("UPDATE `tbl_license` SET `verify_key`='" . $_req . "' ,`verify_last_update`='" . $_time . "' ");
        return $_req;
    }
    return false;
}
function mainChd19k521_old($licensekey = "", $localkey = "", $forcechk = false, $checksum = false)
{
    global $config;
    global $db;
    $LICENSE = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_license` WHERE `id`=1"));
    if ($licensekey == "") {
        $licensekey = $LICENSE["license_key"];
        $licensekey = dec($licensekey);
        $licensekey = str_replace("-", "", $licensekey);
        $licensekey = trim($licensekey);
    }
    if ($localkey == "" && !$forcechk) {
        $localkey = base64_decode($LICENSE["local_key"]);
    }
    $serverlink = base64_decode("aHR0cHM6Ly9jcC5kaHJ1LmNvbS9zdWJtaXQvdmVyaWZ5bGljZW5zZQ==");
    $licensing_secret_key = "6e8a052jaf8ca8hanu24bb8man5fee44";
    $check_token = time() . md5(mt_rand(1000000000, 0) . $licensekey);
    $checkdate = date("Ymd");
    $usersip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
    $localkeydays = 5;
    $allowcheckfaildays = 5;
    $localkeyvalid = false;
    if ($localkey) {
        $localkey = str_replace("\n", "", $localkey);
        $localdata = substr($localkey, 0, strlen($localkey) - 32);
        $md5hash = substr($localkey, strlen($localkey) - 32);
        if ($md5hash == md5($localdata . $licensing_secret_key)) {
            $localdata = strrev($localdata);
            $md5hash = substr($localdata, 0, 32);
            $localdata = substr($localdata, 32);
            $localdata = base64_decode($localdata);
            $localkeyresults = unserialize($localdata);
            $originalcheckdate = $localkeyresults["checkdate"];
            if ($md5hash == md5($originalcheckdate . $licensing_secret_key)) {
                $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - $localkeydays, date("Y")));
                if ($localexpiry < $originalcheckdate) {
                    $localkeyvalid = true;
                    $results = $localkeyresults;
                }
            }
        }
    }
    if (!$localkeyvalid) {
        dquery("UPDATE tbl_license set local_key=''");
        $postfields["licensekey"] = $licensekey;
        $postfields["domain"] = $_SERVER["SERVER_NAME"];
        $postfields["ip"] = $usersip;
        $postfields["dir"] = dirname(__FILE__);
        $configsend["version"] = $config["version"];
        $configsend["siteconfig"] = getSiteConfigs();
        $configsend["releasecandidate"] = $config["release_candidate"];
        $postfields["config"] = base64_encode(json_encode($configsend));
        $postfields["json"] = true;
        if ($checksum) {
            $postfields["checksum"] = true;
        }
        if ($check_token) {
            $postfields["check_token"] = $check_token;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serverlink);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        if (!$data || deregi("404 Not Found", $data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $serverlink2 . "license/fusion.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);
        }
        if (!$data || deregi("404 Not Found", $data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $serverlink3 . "license/fusion.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);
        }
        if (!$data) {
            $localexpiry = date("Ymd", mktime(0, 0, 0, date("m"), date("d") - ($localkeydays + $allowcheckfaildays), date("Y")));
            if ($localexpiry < $originalcheckdate) {
                $results = $localkeyresults;
            } else {
                $results["status"] = "Invalid";
                $results["description"] = "Remote Check Failed";
                return $results;
            }
        } else {
            $results = json_decode($data, true);
        }
        if ($results["md5hash"] && $results["md5hash"] != md5($licensing_secret_key . $check_token)) {
            $results["status"] = "Invalid";
            $results["description"] = "MD5 Checksum Verification Failed";
            return $results;
        }
        if ($results["status"] == "Active") {
            $results["checkdate"] = $checkdate;
            $data_encoded = serialize($results);
            $data_encoded = base64_encode($data_encoded);
            $data_encoded = md5($checkdate . $licensing_secret_key) . $data_encoded;
            $data_encoded = strrev($data_encoded);
            $data_encoded = $data_encoded . md5($data_encoded . $licensing_secret_key);
            $data_encoded = wordwrap($data_encoded, 80, "\n", true);
            $results["localkey"] = $data_encoded;
            if ($results["localkey"] && !$checksum) {
                $data = NULL;
                $got_local_key = base64_encode($results["localkey"]);
                if (dquery("UPDATE `tbl_license` SET `local_key`='" . $got_local_key . "'")) {
                    $results["localkey_updat"] = "Success";
                } else {
                    $results["localkey_updat"] = "Error";
                }
                $data = NULL;
            }
        }
        $results["remotecheck"] = true;
    }
    if ($results["status"] == "Active") {
        if (!function_exists("saveSettings")) {
            require_once ROOTDIR . "/includes/clients.fun.inc.php";
        }
        saveSettings("RemoveBranding", "");
        saveSettings("reseller_can_setup_store", "0");
        saveSettings("live_chat", "");
        if (isset($results["addons"]) && $results["addons"] != "") {
            $_is_ecommerce_addn_active = false;
            foreach ($results["addons"] as $key => $value) {
                if ($value["name"] == "Remove Branding") {
                    if ($value["status"] == "Active") {
                        saveSettings("RemoveBranding", "true");
                    } else {
                        saveSettings("RemoveBranding", "");
                    }
                }
                if ($value["name"] == "Reseller Store") {
                    if ($value["status"] == "Active") {
                        saveSettings("reseller_can_setup_store", "1");
                    } else {
                        saveSettings("reseller_can_setup_store", "0");
                    }
                }
                if ($value["name"] == "Messenger Notification") {
                    if ($value["status"] == "Active") {
                        saveSettings("slacksubscription", "1");
                        if ($value["billingcycle"] != "One Time" && $value["nextduedate"] < date("Y-m-d")) {
                            saveSettings("slacksubscription", "0");
                        }
                    } else {
                        saveSettings("slacksubscription", "0");
                    }
                }
                if ($value["name"] == "Live Chat") {
                    if ($value["status"] == "Active") {
                        saveSettings("live_chat", "1");
                    } else {
                        saveSettings("live_chat", "");
                    }
                }
                if ($value["name"] == "E-commerce") {
                    if ($value["status"] == "Active") {
                        $_is_ecommerce_addn_active = true;
                        saveSettings("shoppingcart", "1");
                    } else {
                        saveSettings("shoppingcart", "");
                    }
                }
                if ($value["name"] == "SMS") {
                    if ($value["status"] != "Active") {
                        saveSettings("smsgateway", "");
                    }
                }
                if ($value["name"] == "POS") {
                    if ($value["status"] == "Active") {
                        saveSettings("POS", "1");
                    } else {
                        saveSettings("POS", "");
                    }
                }
                if ($value["name"] == "Mobile Edition") {
                    if ($value["status"] == "Active") {
                        saveSettings("mobileaddon", "1");
                    } else {
                        saveSettings("mobileaddon", "");
                    }
                }
            }
        }
    }
    $results["_lickey"] = gen_key_formate($licensekey);
    unset($postfields);
    unset($data);
    unset($matches);
    unset($serverlink);
    unset($licensing_secret_key);
    unset($checkdate);
    unset($usersip);
    unset($localkeydays);
    unset($allowcheckfaildays);
    unset($md5hash);
    return $results;
}
function checkSupport()
{
    global $licinfo;
    $licence6month = date("Y-m-d", strtotime("-6 months"));
    if ($licence6month <= $licinfo["registration_date"] || reqaddon("Support and Maintenance", true)) {
        return true;
    }
    return false;
}
function reqaddon($reqAddon, $retun = false)
{
    global $licinfo;
    global $admindirpath;
    if (isset($lic_info)) {
        $licinfo = $lic_info;
    }
    $addonstatus = "";
    $addonarray = [];
    foreach ($licinfo["addons"] as $addon) {
        if (trim($addon["name"]) == trim($reqAddon)) {
            $addonstatus = $addon["status"];
            if ($addonstatus == "Active") {
                $addonarray = $addon;
                if ($addonstatus != "Active") {
                    if ($retun) {
                        return false;
                    }
                    if (is_file("includes/pages/addonnotactive.php")) {
                        include "includes/pages/addonnotactive.php";
                    } else {
                        include "../" . $admindirpath . "/includes/pages/addonnotactive.php";
                    }
                    exit;
                }
                if ($getarray) {
                    return $addonarray;
                }
                return true;
            }
            if ($addon["billingcycle"] != "One Time" && $addon["next_due_date"] < date("Y-m-d")) {
                $addonstatus = "Expired";
            }
        }
    }
}
function chkLite($service = "IMEI")
{
    global $licinfo;
    global $lite;
    if ($lite) {
        if ($service != $licinfo["customfields"]["Service"]) {
            include "includes/pages/thisliteversion.php";
            exit;
        }
    }
}
function chkLitePlus()
{
    global $licinfo;
    global $liteplus;
    if ($liteplus) {
        include "includes/pages/thisliteversion.php";
        exit;
    }
}

?>