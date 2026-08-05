<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
define("SSLON", true);
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/api.fun.php";
require ROOTDIR . "/includes/mail.fun.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/clients.fun.inc.php";
foreach ($_GET as $k => $v) {
    $_POST[$k] = $v;
}
global $remote_ip;
unset($password);
unset($username);
unset($action);
unset($userid);
unset($parameters);
global $apiresults;
$apiresults = [];
$password = md5(trim($_POST["password"]) . $passenc);
$username = preg_replace("/[^0-9a-zA-Z-_@\\.]/i", "", $_POST["username"]);
$action = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["action"]);
$serialno = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["serialno"]);
$secotp = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["secotp"]);
$reqversion = (double) preg_replace("/[^0-9.]/i", "", $_POST["version"]);
$parameters = $_POST["parameters"];
if ($withencode) {
    $parameters["imei"] = base64_decode($parameters["imei"]);
}
$allowed = true;
$apiverion = 0;
if ($reqversion < $apiverion) {
}
if (!$_POST["password"]) {
    $apiresults["ERROR"][] = ["message" => "Invalid Password"];
    $allowed = false;
}
if (!$username) {
    $apiresults["ERROR"][] = ["message" => "Invalid Username"];
    $allowed = false;
}
if (!$action) {
    $apiresults["ERROR"][] = ["message" => "Invalid Action Request"];
    $allowed = false;
}
if ($action != "login" && $action != "getservicedetails" && !$serialno) {
    $apiresults["ERROR"][] = ["message" => "Invalid Serial No"];
    $allowed = false;
}
if ($config["config_is_under_maintanance"]) {
    $apiresults["ERROR"][] = ["message" => "Server is temporarily unavailable. "];
    $allowed = false;
}
if ($allowed) {
    $result = dquery("SELECT * FROM `tblUsers` WHERE (`username`='" . $username . "' or `email`='" . $username . "') and password='" . $password . "' and userstatus='0'");
    $data = mysqli_fetch_assoc($result);
    $userid = $data["id"];
    if (!$userid) {
        $result = dquery("SELECT * FROM `tblUsers` WHERE (`username`='" . $username . "' or `email`='" . $username . "') ");
        $UserData = mysqli_fetch_assoc($result);
        if ($UserData["id"]) {
            dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 WHERE `id`= '" . $UserData["id"] . "'");
            $login_attempts = mysqli_fetch_assoc(dquery("SELECT `login_failed_atoms` FROM `tblUsers` WHERE `id`='" . $UserData["id"] . "' AND `login_failed_atoms` > '" . $config["MaxLoginFailedAttempts"] . "' "));
            if ($login_attempts) {
                $mail_ver["blockreson"] = "Automatically block [App] (" . $config["MaxLoginFailedAttempts"] . " failed login attempts) from IP -" . $remote_ip;
                dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $UserData["id"] . "' ");
                if (!isWhiteIP($remote_ip)) {
                    blockIP($remote_ip, $mail_ver["blockreson"], 15);
                }
                require_once ROOTDIR . "/includes/mail.fun.php";
                sendMail(5, $UserData["id"], "", $mail_ver);
                if ($config["adminblocknotice"]) {
                    $adminmessage = " " . $UserData["username"] . " [#" . $UserData["id"] . "] Account blocked<Br />\n                    Email: " . $UserData["email"] . " <br />\n                    Country : " . $UserData["country"] . " <br />                    \n                    " . $mail_ver["blockreson"] . " ";
                    sendNotification("system", "Client Account blocked", $adminmessage, "");
                }
            }
        }
        $apiresults["ERROR"][] = ["message" => "Authentication Failed"];
        $allowed = false;
    } else {
        if ($data["ip_range"] && !checkIPinList($data["ip_range"], $remote_ip)) {
            $apiresults["ERROR"][] = ["message" => "Sorry, Your ip is not match with account."];
            $allowed = false;
        }
        if ($allowed && $action == "terminalregister" && ($config["force2fa"] || $data["sndlogin"])) {
            $OTP = rand(111111, 999999);
            $ERrorMessage = "OTP sent on your email";
            if (!$secotp) {
                if ($config["force2fa"]) {
                    $LICENSE = mysqli_fetch_assoc(dquery("SELECT license_key FROM `tbl_license` WHERE `id`=1"));
                    $tmptime = time() - 3600;
                    dquery("update tblUsers set tmp_password='" . $OTP . "',tmp_pass_time='" . $tmptime . "' where id='" . $data["id"] . "'");
                    if ($data["messengerid"]) {
                        $ERrorMessage .= " and Telegram";
                        $sendmessage = "Verification OTP :<b>" . $OTP . "</b>";
                        sendTelegramMessage(urlencode($sendmessage), $data["messengerid"]);
                    }
                    if ($config["dhruotpservice"]) {
                        $URL = "https://api.dhru.com/integration/api/v1/otpservice?token=" . $LICENSE["license_key"];
                        $POST = [];
                        $POST["chanel"] = "email";
                        $POST["to"] = $data["email"];
                        $POST["otp"] = $OTP;
                        $POST["name"] = $config["companyname"];
                        $Res = initCurl($URL, "", "", "", $POST);
                        $Res = json_decode($Res, true);
                    } else {
                        $mail_ver["otp"] = $OTP;
                        $mail_ver["user"] = $data["username"];
                        require_once ROOTDIR . "/includes/mail.fun.php";
                        sendMail(100, $data["id"], "", $mail_ver, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", true);
                    }
                }
                if ($data["sndlogin"]) {
                    $ERrorMessage = "Google Authenticator OTP required";
                }
                $apiresults["ERROR"][] = ["message" => $ERrorMessage, "OTP" => true];
                $allowed = false;
            } else {
                if ($data["sndlogin"]) {
                    require_once ROOTDIR . "/includes/loginsec.fun.php";
                    if (!Google2FA::verify_key($data["sndlogin"], $secotp)) {
                        $apiresults["ERROR"][] = ["message" => "Wrong Google OTP"];
                        $allowed = false;
                    }
                } else {
                    if ($data["tmp_password"] != $secotp) {
                        $apiresults["ERROR"][] = ["message" => "Wrong  OTP"];
                        $allowed = false;
                    }
                }
            }
        }
        if ($gcmid) {
            dquery("update tblUsers set gcmid='" . $gcmid . "' where id='" . $userid . "'");
        }
        if ($action != "terminalregister" && $action != "login" && $action != "getservicedetails") {
        }
        if ($allowed) {
            $_SESSION["uid"] = $userid;
            $_SESSION["username"] = $data["username"];
            $_SESSION["WLANG"] = $data["default_lang"];
            $_SESSION["currency"] = $data["default_currency"];
            $UserDetails = $_ClientsDetails = getClientsDetails($userid);
        }
    }
    if ($allowed) {
        if ($action == "dashboard") {
            $action = "terminalregister";
        }
        if (file_exists(ROOTDIR . "/includes/apipos/" . trim($action) . ".php")) {
            include ROOTDIR . "/includes/apipos/" . trim($action) . ".php";
        } else {
            $apiresults["ERROR"][] = ["message" => "Command Not Found"];
        }
    }
}
if (count($apiresults)) {
    header("X-Powered-By: DHRU-FUSION");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $encoding = false;
    header_remove("pragma");
    header_remove("server");
    header_remove("cache-control");
    header_remove("expires");
    header("Content-Type: application/json; charset=utf-8");
    $apiresults["apiversion"] = $apiverion;
    if ($encoding) {
        echo gzencode(json_encode($apiresults));
    } else {
        $_encode = json_encode($apiresults);
        if (json_last_error()) {
            $_EROP["ERROR"][] = ["message" => json_last_error_msg()];
            exit(json_encode($_EROP));
        }
        exit($_encode);
    }
}
exit;

?>