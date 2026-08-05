<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

error_reporting(0);
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
define("SSLON", true);
$_limits = ["imeiservicelist" => 10, "getimeiservicedetails" => 10];
$allowed = true;
global $apiresults;
$apiresults = [];
$action = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["action"]);
$username = preg_replace("/[^0-9a-zA-Z-_\\.]/i", "", $_POST["username"]);
$_IP = determineIPOnPage();
$_ratelimit_dir = "./rate_limits/";
$_file_rate_limit = $_ratelimit_dir . md5($_IP . $action . $username);
if (isset($_limits[$action])) {
    $_time_limit = $_limits[$action] * 60;
    if (is_file($_file_rate_limit)) {
        $_last_time = file_get_contents($_file_rate_limit);
        if (time() <= $_last_time + $_time_limit) {
            $_lastsync = round((time() - (int) $_last_time) / 60);
            $allowed = false;
            $apiresults["ERROR"][] = ["MESSAGE" => "Sorry, you are calling our service too frequent, Action [" . $action . "] only Allows once per " . $_limits[$action] . " Minutes,\n             last synced " . $_lastsync . " Minute ago."];
        }
    }
}
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/api.fun.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
unset($apiaccesskey);
unset($username);
unset($action);
unset($userid);
unset($parameters);
unset($customfield);
$apiaccesskey = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["apiaccesskey"]);
$username = preg_replace("/[^0-9a-zA-Z-_\\.]/i", "", $_POST["username"]);
$action = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["action"]);
$reqversion = preg_replace("/[^0-9.]/i", "", $_POST["version"]);
$customfield = $_POST["customfield"];
$parameters = $_POST["parameters"];
$apiverion = "8.1";
if (!$apiaccesskey) {
    $apiresults["ERROR"][] = ["MESSAGE" => "Invalid Access Key"];
    $allowed = false;
}
if (!$username) {
    $apiresults["ERROR"][] = ["MESSAGE" => "Invalid Username"];
    $allowed = false;
}
if (!$action) {
    $apiresults["ERROR"][] = ["MESSAGE" => "Invalid Action Request"];
    $allowed = false;
}
if ($allowed) {
    $result = select_query("tblUsers", "", ["username" => $username, "api_key" => $apiaccesskey, "userstatus" => "0"]);
    $data = mysqli_fetch_assoc($result);
    $userid = $data["id"];
    if (!$userid) {
        $apiresults["ERROR"][] = ["MESSAGE" => "Authentication Failed"];
        $allowed = false;
    } else {
        if ($data["api_ip"] == "") {
            $db->update("tblUsers", ["api_ip" => $remote_ip], "id=" . $data["id"]);
            if (!function_exists(sendMail)) {
                require_once ROOTDIR . "/includes/mail.fun.php";
            }
            $mailmerge["api"] = "APi";
            $mailmerge["ip"] = $remote_ip;
            sendMail("88", $data[id], "", $mailmerge, true);
            if ($data["messengerid"]) {
                $sendmessage = "Your APi assigned new ip " . $remote_ip;
                sendTelegramMessage(urlencode($sendmessage), $data["messengerid"]);
            }
        } else {
            if (!checkIPinList($data["api_ip"], $remote_ip)) {
                $apiresults["ERROR"][] = ["MESSAGE" => "Invalid IP Request"];
                $allowed = false;
            }
        }
        if ($allowed) {
            if ($data["api_access"]) {
                $_SESSION["uid"] = $userid;
                $_SESSION["username"] = $data["username"];
                $_SESSION["WLANG"] = $data["default_lang"];
                $_SESSION["currency"] = $data["default_currency"];
                $UserDetails = $_ClientsDetails = getClientsDetails($userid);
            } else {
                $apiresults["ERROR"][] = ["MESSAGE" => "Access Denied"];
                $allowed = false;
            }
        }
    }
    if ($allowed) {
        if (file_exists(ROOTDIR . "/includes/api/" . trim($action) . ".php")) {
            include ROOTDIR . "/includes/api/" . trim($action) . ".php";
        } else {
            $apiresults["ERROR"][] = ["MESSAGE" => "Command Not Found"];
        }
    }
}
if (count($apiresults)) {
    header("X-Powered-By: DHRU-FUSION");
    $encoding = false;
    header_remove("pragma");
    header_remove("server");
    header_remove("cache-control");
    header_remove("expires");
    if (isset($_limits[$action]) && 0 < count($apiresults["SUCCESS"])) {
        forceCreaDirDirOnpage($_ratelimit_dir);
        file_put_contents($_file_rate_limit, time());
    }
    if ($requestformat == "JSON") {
        header("Content-Type: application/json; charset=utf-8");
        $apiresults["apiversion"] = $apiverion;
        if ($encoding) {
            echo gzencode(json_encode($apiresults));
        } else {
            $_encode = json_encode($apiresults);
            if (json_last_error()) {
                $_EROP["ERROR"][] = ["MESSAGE" => json_last_error_msg()];
                exit(json_encode($_EROP));
            }
            exit($_encode);
        }
    } else {
        header("Content-Type: application/xml; charset=utf-8");
        if ($encoding) {
            header("Dhru-encoded: true");
            echo gzencode(toXml($apiresults, "DHRUFUSION Version=\"" . $apiverion . "\""));
        } else {
            echo toXml($apiresults, "DHRUFUSION Version=\"" . $apiverion . "\"");
        }
    }
}
exit;
class no
{
}
function determineIPOnPage()
{
    if (checkIPOnpage($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        return $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    if (checkIPOnpage($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    $ip_array = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
    if (checkIPOnpage(trim($ip_array[0]))) {
        return trim($ip_array[0]);
    }
    if (checkIPOnpage($_SERVER["HTTP_X_FORWARDED"])) {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    if (checkIPOnpage($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
        return $_SERVER["HTTP_X_CLUSTER_CLIENT_IP"];
    }
    if (checkIPOnpage($_SERVER["HTTP_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    if (checkIPOnpage($_SERVER["HTTP_FORWARDED"])) {
        return $_SERVER["HTTP_FORWARDED"];
    }
    return $_SERVER["REMOTE_ADDR"];
}
function checkIPOnpage($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return true;
    }
    return false;
}
function forceCreaDirDirOnpage($dir)
{
    if (!is_dir($dir)) {
        $dir_p = explode("/", $dir);
        for ($a = 1; $a <= count($dir_p); $a++) {
            @mkdir(@implode("/", @array_slice($dir_p, 0, $a)));
        }
    }
}

?>