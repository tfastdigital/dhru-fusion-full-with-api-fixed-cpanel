<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
require_once "includes/clients.fun.inc.php";
$currentpage = "register";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$_nav = "<a href=\"main.php\">" . $lng_languag["registration"] . "</a> / ";
$pagetitle = $lng_languag["registration"];
$_nav .= "<a href='register.php' >" . $lng_languag["registration"] . "</a> / ";
$templatefile = "client_registration";
$pageicon = "";
ob_start();
installclient($pagetitle, $pageicon, $breadcrumbnav);
$email = preg_replace("/[^0-9\\-a-zA-Z@._]/i", "", $email);
error_reporting(0);
if (($action || $openid_mode) && !$_SESSION["uid"]) {
    if ($action == "googlep" && $config["googleclientid"] && $config["registration_type"] != 3) {
        if (strpos($config["usercan_signup"], "google") !== false) {
            include_once $config["admin_directory"] . "/includes/3rdparty/googleautho//Google_Client.php";
            include_once $config["admin_directory"] . "/includes/3rdparty/googleautho/contrib/Google_Oauth2Service.php";
            $clientId = $config["googleclientid"];
            $clientSecret = $config["googleclientsecret"];
            $redirectUrl = ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "loginoption.php?action=googlep";
            $homeUrl = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
            $gClient = new Google_Client();
            $gClient->setApplicationName("Login to " . $config["companyname"]);
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            if (isset($_REQUEST["code"])) {
                $gClient->authenticate();
                $_SESSION["gstoken"] = $gClient->getAccessToken();
                header("Location: " . filter_var($redirect_url, FILTER_SANITIZE_URL));
            }
            if (isset($_SESSION["gstoken"])) {
                $gClient->setAccessToken($_SESSION["gstoken"]);
            }
            if ($gClient->getAccessToken()) {
                $userProfile = $google_oauthV2->userinfo->get();
                $validator["first_name"] = [$userProfile["given_name"], false];
                $validator["last_name"] = [$userProfile["family_name"], false];
                $validator["email"] = [$userProfile["email"], true];
                $u = explode("@", $userProfile["email"]);
                $validator["username"] = [$u[0], true];
                if ($error = validateProfiles($validator)) {
                    header("Location: register.php?error=notmode");
                    exit;
                }
                if ($error = addNewUser($validator, true, "", true)) {
                    $email = $userProfile["email"];
                    $result = dquery("SELECT * FROM `tblUsers` WHERE                 (`email`='" . $email . "') ");
                    $data = mysqli_fetch_assoc($result);
                    if ($data["id"]) {
                        doQuickLogin($userProfile["email"]);
                        exit;
                    }
                    header("Location: register.php?error=notmode");
                    exit;
                }
                doQuickLogin($userProfile["email"]);
            } else {
                $authUrl = $gClient->createAuthUrl();
            }
            if (isset($authUrl)) {
                header("Location:" . $authUrl);
                echo "                <script>\n                    location.href='";
                echo $authUrl;
                echo "';\n                </script>\n                ";
            }
        }
    } else {
        if ($action == "facebook" && $config["facebookappid"] && $config["facebookaccesstoken"] && $config["facebookappsecret"] && $config["registration_type"] != 3) {
            if (strpos($config["usercan_signup"], "facebook") !== false) {
                define("FACEBOOK_SDK_V4_SRC_DIR", $config["admin_directory"] . "/includes/3rdparty/FB/");
                require_once $config["admin_directory"] . "/includes/3rdparty/FB/autoload.php";
                if (!$code) {
                    $fb = new Facebook\Facebook(["app_id" => $config["facebookappid"], "app_secret" => $config["facebookappsecret"], "default_graph_version" => "v3.3"]);
                    $helper = $fb->getRedirectLoginHelper();
                    $permissions = ["email"];
                    $loginUrl = $helper->getLoginUrl(($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "loginoption.php?action=facebook", $permissions);
                    if (isset($loginUrl)) {
                        header("Location:" . $loginUrl);
                        echo "                        <script>\n                            location.href='";
                        echo $loginUrl;
                        echo "';\n                        </script>\n                        ";
                    }
                } else {
                    $fb = new Facebook\Facebook(["app_id" => $config["facebookappid"], "app_secret" => $config["facebookappsecret"], "default_graph_version" => "v3.3"]);
                    echo $fb->getDefaultAccessToken();
                    exit;
                }
            }
        } else {
            require_once "includes/openid.class.php";
            if (empty($openid_mode)) {
                $openid = new LightOpenID();
                if ($action == "yahoo" && strstr($config["usercan_signup"], "yahoo") !== false) {
                    $_SESSION["oid_identity"] = "yahoo";
                    $openid->identity = "https://me.yahoo.com";
                }
                $openid->required = ["namePerson", "namePerson/first", "namePerson/last", "contact/email", "pref/language", "namePerson/friendly", "birthDate/birthYear"];
                $url_send = urldecode(html_entity_decode($openid->authUrl()));
                header("Location: " . $url_send);
            } else {
                header("Location: register.php?error=notmode");
                exit;
            }
        }
    }
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}
ob_flush();
chkMd5sumsubpage();
function doQuickLogin($email)
{
    global $remote_ip;
    $email = descape($email);
    $result = dquery("SELECT * FROM `tblUsers` WHERE                 (`email`='" . $email . "') and userstatus=0");
    $data = mysqli_fetch_assoc($result);
    if ($data["id"]) {
        if (!$remote_ip) {
            $remote_ip = determineIP();
        }
        $lastlogin = time();
        $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
        $session = session_id();
        $time = time();
        dquery("UPDATE `tblUsers` SET `enc_login`= '" . $encdata . "',`last_login`='" . $lastlogin . "',`last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\n                    `current_login_time`='" . $time . "',`online_status`='1' \n                    WHERE `id`= '" . $data["id"] . "' ");
        $_SESSION["uid"] = $data["id"];
        $_SESSION["username"] = $data["username"];
        $_SESSION["WLANG"] = $data["default_lang"];
        $_SESSION["currency"] = $data["default_currency"];
        if ($data["default_theme"]) {
            $_SESSION["template"] = $data["default_theme"];
        }
        $_SESSION["encdata"] = $encdata;
        $_SESSION["last_login"] = $data["last_login"] . "," . $data["last_login_ip"];
        header("Location: main.php?action=notes1");
    } else {
        header("Location: login.php?action=userincorrect");
    }
}

?>