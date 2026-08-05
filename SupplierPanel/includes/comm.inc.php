<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace licince;

class licince
{
}
function mainChk($licensekey = "", $localkey = "", $forcechk = false, $checksum = false)
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
    $serverlink = base64_decode("aHR0cDovL2xpY2Vuc2UuZGhydS5jb20v");
    $serverlink2 = base64_decode("aHR0cDovL3VzLmRocnUuY29tLw==");
    $serverlink3 = base64_decode("aHR0cDovL2RocnUuY29tLw==");
    $licensing_secret_key = "6e8a052jaf8ca8hanu24bb8man5fee44";
    $check_token = time() . md5(mt_rand(1000000000, 0) . $licensekey);
    $checkdate = date("Ymd");
    $usersip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
    $localkeydays = 10;
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
        curl_setopt($ch, CURLOPT_URL, $serverlink . "license/fusion.php");
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
        if (isset($results["addons"]) && $results["addons"] != "") {
            foreach ($results["addons"] as $key => $value) {
            }
        }
        if (isset($results["customfields"]) && $results["customfields"] != "") {
            $_addon_featur = explode("|", $results["customfields"]);
            $results["customfields"] = NULL;
            $results["customfields"] = [];
            foreach ($_addon_featur as &$value) {
                $_addon_featur_f = explode("=", $value);
                $addon_featur_sam[$_addon_featur_f[0]] = $_addon_featur_f[1];
            }
            $results["customfields"] = $addon_featur_sam;
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
function reqaddon($reqAddon, $retun = false)
{
    global $licinfo;
    global $admindirpath;
    foreach ($licinfo["addons"] as $addon) {
        if ($addon["name"] == $reqAddon) {
            $addonstatus = $addon["status"];
        }
    }
    if ($addonstatus != "Active") {
        if ($retun) {
            return false;
        }
        include_once ROOTDIR . "/" . $admindirpath . "/includes/pages/addonnotactive.php";
        exit;
    }
    return true;
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