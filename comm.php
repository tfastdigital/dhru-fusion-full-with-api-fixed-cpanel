<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */
 
defined("DEFINE_DHRU_FILE") || exit("<h2 style=\"color: #C00; text-align: center;\"><strong>Restricteds Access</strong></h2>");
session_name("DHRUFUSION");
session_set_cookie_params(0, "/", NULL, false, true);
session_start();
if (isset($_REQUEST["debug"]) && isset($_SESSION["adminid"])) {
    $display_errors = $debug_output = $mysqli_errors = true;
    error_reporting(1); // eret edemiyorum kasıyor
    ini_set("display_errors", "1");
} else {
    error_reporting(1);
    $display_errors = $debug_output = $mysqli_errors = false;
}
global $lng_languag;
define("DHRUSOFT", true);
define("ROOTDIR", dirname(__FILE__));
if (!defined("COMMSTART")) {
    define("COMMSTART", true);
    include ROOTDIR . "/includes/comm.inc.php";
    include_once ROOTDIR . "/includes/Log.class.php";
    if (defined('CLIENT') && CLIENT == "1" && is_dir("installer")) {
        echo "<div style=\"border: 1px dashed #cc0000;font-family:Tahoma;background-color:#FBEEEB;width:95%;padding:10px;color:#cc0000;\"><strong>Security Warning</strong><br>The installer folder needs to be deleted for security reasons before using Dhru Fusion</div>";
        exit;
    }
    if (defined('ADMIN') && ADMIN == "1" && is_dir("installer")) {
        header("Location: ../installer/index.php");
        exit;
    }
    if (!$config["cart_page_limit"]) {
        $config["cart_page_limit"] = 100;
    }
    if (isset($_REQUEST["display_errors"])) {
        unset($_REQUEST["display_errors"]);
    }
    if (isset($_REQUEST["debug_output"])) {
        unset($_REQUEST["debug_output"]);
    }
    if (isset($_REQUEST["mysqli_errors"])) {
        unset($_REQUEST["mysqli_errors"]);
    }
    
    // Define htmlspecialchars_array function if not exists
    if (!function_exists('htmlspecialchars_array')) {
        function htmlspecialchars_array($arr) {
            if (!is_array($arr)) {
                return htmlspecialchars($arr, ENT_QUOTES, 'UTF-8');
            }
            $out = array();
            foreach ($arr as $key => $val) {
                $out[$key] = htmlspecialchars_array($val);
            }
            return $out;
        }
    }
    if (!function_exists("determineIP")) {
        function determineIP()
        {
            if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                $parts = explode(",", (string) $_SERVER["HTTP_CLIENT_IP"]);
                return trim($parts[0]);
            }
            if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $parts = explode(",", (string) $_SERVER["HTTP_X_FORWARDED_FOR"]);
                return trim($parts[0]);
            }
            if (!empty($_SERVER["REMOTE_ADDR"])) {
                return $_SERVER["REMOTE_ADDR"];
            }
            return "127.0.0.1";
        }
    }
    if (!function_exists("chkMd5sum")) {
        function chkMd5sum()
        {
            return true;
        }
    }
    
    $PHP_SELF = htmlspecialchars_array($_SERVER["PHP_SELF"]);
    $_SERVER["PHP_SELF"] = $PHP_SELF;
    foreach ($_COOKIE as $reg_globals_key => $reg_globals_value) {
        unset($_REQUEST[$reg_globals_key]);
    }
    $_GET = htmlspecialchars_array($_GET);
    $_POST = htmlspecialchars_array($_POST);
    $_REQUEST = htmlspecialchars_array($_REQUEST);
    $_COOKIE = htmlspecialchars_array($_COOKIE);
    if ($_FILES) {
        foreach ($_FILES as $fk => $fv) {
            if (!$_FILES[$fk]["name"]) {
                foreach ($_FILES[$fk] as $ok => $ov) {
                    if (stripos($_FILES[$fk][$ok]["name"], ".php") !== false) {
                        unset($_FILES[$fk][$ok]);
                    }
                }
            } else {
                if (is_array($_FILES[$fk]["name"])) {
                    foreach ($_FILES[$fk]["name"] as $ok => $ov) {
                        if (stripos($_FILES[$fk]["name"][$ok], ".php") !== false) {
                            unset($_FILES[$fk]["name"][$ok]);
                        }
                    }
                } else {
                    if (stripos($_FILES[$fk]["name"], ".php") !== false) {
                        unset($_FILES[$fk]);
                    }
                }
            }
        }
    }
    foreach ($_REQUEST as $reg_globals_key => $reg_globals_value) {
        if ($reg_globals_key == "_SERVER" || $reg_globals_key == "_COOKIE" || $reg_globals_key == "_SESSION") {
            exit;
        }
        ${$reg_globals_key} = $reg_globals_value;
    }
    unset($reg_globals_key);
    unset($reg_globals_value);
    unset($donloaddirpath);
    unset($cmslink);
    unset($_where);
    unset($where);
    unset($_ClientsDetails);
    unset($templatecompilerpath);
    unset($languagedirectorypath);
    unset($admindirpath);
    if (file_exists(ROOTDIR . "/configs/config.php")) {
        require ROOTDIR . "/configs/config.php";
        $MySqlStricktMode = true;
        if (!isset($overidephptimelimit)) {
            $overidephptimelimit = 300;
        }
        if (!ini_get("safe_mode")) {
            set_time_limit($overidephptimelimit);
        }
        include ROOTDIR . "/includes/mysqlfunction.inc.php";
        include ROOTDIR . "/includes/mysqlclass.php";
        $db = Database::obtain($config["server"], $config["user"], $config["pass"], $config["database"]);
        if (defined('CLIENT') && CLIENT == "1" && !isset($mysqli_errors)) {
            $db->debug = false;
        }
        $db->connect();
        $db_conn2 = mysqli_connect($config["server"], $config["user"], $config["pass"], $config["database"]);
        if (!$db_conn2) {
            exit("<strong>Critical Error</strong><br>Could not connect to the database");
        }
        // dquery("SELECT @@sql_mode");
        // dquery("SET sql_mode = ''");
        // @mysqli_query($db_conn2, "SET SESSION sql_mode = ''");
        dquery("set character_set_client='utf8'");
        dquery("set character_set_results='utf8'");
        dquery("set collation_connection='utf8_general_ci'");
        mysqli_set_charset($db_conn2, "utf8");
        $DB_USER = "admin_test";
        $DB_PASS = "admin_test";
        $DB_HOST = "localhost";
        $DB_NAME = "admin_test";
        $remote_ip = determineIP();
        $config = [];
        $result = mysqli_fetch_assoc(select_query("tbl_settings", "", ["attribute" => "config"]));
        $config = isset($result["value"]) ? @unserialize($result["value"]) : [];
        if (!is_array($config)) {
            $config = [];
        }
        if ($config["quick_checkout"] != "disable" && $config["quick_checkout"] != 5) {
            $config["quick_checkout"] = 4;
        }
        if ($BRANDMODELCOUNTRYPRO) {
            $config["quick_checkout"] = 3;
        }
        if ($config["quick_checkout"] == "disable") {
            $config["quick_checkout"] = NULL;
        }
        $config["captcha_registration"] = true;
        $config["captcha_forget"] = true;
        $config["captchaonnewsletter"] = true;
        $config["captchaoncontact"] = true;
        $config["cart_page_limit"] = 50;
        $config["adminlistlimit"] = 50;
        $config["default_page_limit"] = 50;
        $config["BlogPostsperpage"] = 50;
        $config["ActivityLogLimit"] = 1000;
        $config["charset"] = $config["charset"] ? $config["charset"] : "UTF-8";
        $config["admincharset"] = $config["admincharset"] ? $config["admincharset"] : "UTF-8";
        if ($config["precision"]) {
            $precision = $config["precision"];
        } else {
            $precision = 2;
        }
        $time = time();
        if (!isset($config["template"])) {
            $result = mysqli_fetch_assoc(select_query("tbl_settings", "", ["attribute" => "config_backup"]));
            $config_backup = isset($result["value"]) ? @unserialize($result["value"]) : [];
            if (!is_array($config_backup)) {
                $config_backup = [];
            }
            if (!isset($config["template"])) {
                if (!isset($config_backup["template"])) {
                    $config_backup["template"] = "default";
                }
                if (!isset($config_backup["template_afterlogin"])) {
                    $config_backup["template_afterlogin"] = "default";
                }
                if (!isset($config_backup["themecolor"])) {
                    $config_backup["themecolor"] = "theme1";
                }
                if (!isset($config_backup["version"])) {
                    $config_backup["version"] = isset($config["version"]) ? $config["version"] : "10";
                }
                if (!isset($config_backup["release_candidate"])) {
                    $config_backup["release_candidate"] = isset($config["release_candidate"]) ? $config["release_candidate"] : "";
                }
                $config = array_merge($config, $config_backup);
                $config_serialized = serialize($config);
                dquery("update tbl_settings set value='" . addslashes($config_serialized) . "' where attribute='config'");
            }
        }
        $tbl_visitors_exists = dquery("SHOW TABLES LIKE 'tbl_visitors'");
        if ($tbl_visitors_exists && mysqli_num_rows($tbl_visitors_exists) > 0) {
            dquery("DELETE FROM tbl_visitors WHERE (time+300)<'" . $time . "'");
        }
        if ($admindirpath) {
            $config["admin_directory"] = $admindirpath;
        } else {
            $config["admin_directory"] = "admin";
        }
        if ($donloaddirpath) {
            $config["download_path"] = $donloaddirpath;
        } else {
            $config["download_path"] = $donloaddirpath = "download";
        }
        if ($templatecompilerpath) {
            $config["config_template_c"] = $templatecompilerpath;
        } else {
            $config["config_template_c"] = $templatecompilerpath = "templates_c";
        }
        if ($languagedirectorypath) {
            $config["lang_folder"] = $languagedirectorypath;
        } else {
            $config["lang_folder"] = "language";
            $languagedirectorypath = $config["lang_folder"];
        }
        $config["followstock"] = $followstock;
        if ($config["reseller_can_setup_store"]) {
            $reqrested_domain = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
            $result = select_query("tbl_store_config", "", ["attribute" => "domain"]);
            while ($data = mysqli_fetch_assoc($result)) {
                if (trim($data["value"]) == trim($reqrested_domain) || trim($data["value"]) == "www." . trim($reqrested_domain)) {
                    $storeowner["id"] = $data["uid"];
                }
            }
        }
        
        if ($storeowner["id"]) {
            $result = select_query("tbl_store_config", "", ["uid" => $storeowner["id"]]);
            $config["token_secret"] = NULL;
            $config["access_token"] = $config["token_secret"];
            $config["consumer_secret"] = $config["access_token"];
            $config["consumer_key"] = $config["consumer_secret"];
            $config["currency"] = $config["consumer_key"];
            $config["otherhtmlcode"] = $config["currency"];
            $config["AddFundsMinimum"] = $config["otherhtmlcode"];
            $config["site_description"] = $config["AddFundsMinimum"];
            $config["config_admin_mail"] = $config["site_description"];
            $config["sitekeywords"] = $config["config_admin_mail"];
            $config["config_admin_mail"] = $config["sitekeywords"];
            $config["contactus_mail"] = $config["config_admin_mail"];
            $config["invoicepayto"] = $config["contactus_mail"];
            $config["googlelike"] = $config["invoicepayto"];
            $config["facebook"] = $config["googlelike"];
            $config["facebooklike"] = $config["facebook"];
            $config["tracking_domain"] = $config["facebooklike"];
            $config["tracking_code"] = $config["tracking_domain"];
            $config["linkedin"] = $config["tracking_code"];
            $config["twitter"] = $config["linkedin"];
            $config["logo_link"] = $config["twitter"];
            while ($data = mysqli_fetch_assoc($result)) {
                $config[$data["attribute"]] = $data["value"];
            }
            unset($_SESSION["template"]);
            if ($action == "ownerlogin" && $passkey && mysqli_num_rows(dquery("select id from tblUsers where \n                    md5(CONCAT(username,password,lastloginalert))='" . $passkey . "'"))) {
                $_SESSION["storeowneredit"] = $storeowner["id"];
            }
        }
        if (defined('CLIENT') && CLIENT == "1") {
            header("Content-type: text/html; charset=" . $config["charset"]);
            if (isset($config["config_is_under_maintanance"]) && $config["config_is_under_maintanance"] && !isset($_SESSION["adminid"])) {
            if (isset($email) && isset($captcha)) {
                if (isset($config["contactus_mail"]) && $config["contactus_mail"]) {
                        $send = [$config["contactus_mail"]];
                    } else {
                        $send = [$config["config_admin_mail"]];
                    }
                    $captcha = md5($captcha);
                    if ($captcha == $_SESSION["varify"]) {
                        $adminmessage = " \n                    Email : " . $email . " <br />\n                    Inquiry: " . $inquiry;
                        include_once ROOTDIR . "/includes/mail.fun.php";
                        sendNotification("other", "Maintanace Inquiry", nl2br($adminmessage), $send, "", "", "", $email);
                    }
                }
                include ROOTDIR . "/includes/systemundermantance.php";
                exit;
            }
            if (preg_replace("/[^0-9a-zA-Z]/i", "", $action) == "setdefaulttemplate") {
                $_SESSION["template"] = NULL;
                $_SESSION["carttemplate"] = NULL;
                $_SESSION["setdefaulttemplate"] = true;
            }
            if ($qcheckout == "brand") {
                $_SESSION["quickwidget"] = $qcheckout;
            } else {
                if ($qcheckout) {
                    unset($_SESSION["quickwidget"]);
                }
            }
            $tempalte_ver["phpself"] = $_SERVER["REQUEST_URI"];
            $tempalte_ver["mobverbysms"] = $config["mobverbysms"];
            $tempalte_ver["mobverbycall"] = $config["mobverbycall"];
            $tempalte_ver["storesetup"] = $config["reseller_can_setup_store"];
            include_once ROOTDIR . "/includes/mobiledevice.inc.php";
            $mobilebrowser = mobile_device_detect();
            if ($_SESSION["template"] != "app") {
                if (!$_SESSION["setdefaulttemplate"] && $config["mobileaddon"] && $mobilebrowser) {
                    $template = "default";
                    $carttemplate = "default";
                }
                if ($config["template_mobile"] && $mobilebrowser) {
                    $template = "default";
                    $carttemplate = "default";
                }
            }
            $template = preg_replace("/[^0-9a-z-]/i", "", $template);
            if ($template && !$storeowner["id"]) {
                if (is_dir(ROOTDIR . "/templates/" . $template)) {
                    $_SESSION["template"] = $template;
                } else {
                    $_SESSION["template"] = $config["template"];
                }
            } else {
                if (!$_SESSION["template"]) {
                    $_SESSION["template"] = $config["template"];
                }
            }
            $carttemplate = preg_replace("/[^0-9a-zA-Z-]/i", "", $carttemplate);
            if ($carttemplate && !$storeowner["id"]) {
                $carttemplate = $carttemplate == "steps" ? "Steps" : ($carttemplate == "singlepage" ? "SingalPage" : "default");
                if (is_dir(ROOTDIR . "/templates/" . $_SESSION["template"] . "/cart/" . $carttemplate)) {
                    $_SESSION["carttemplate"] = $carttemplate;
                } else {
                    $_SESSION["carttemplate"] = $config["carttpl"];
                }
            } else {
                if (!$_SESSION["carttemplate"]) {
                    $_SESSION["carttemplate"] = $config["carttpl"];
                }
            }
            $selectlanguage = preg_replace("/[^0-9a-z-]/i", "", $selectlanguage);
            if ($selectlanguage) {
                $_SESSION["WLANG"] = $selectlanguage;
            }
            if ($_SESSION["uid"]) {
                if ($_SESSION["forcepasschnage"] && !stripos($_SERVER["REQUEST_URI"], "cart.php") !== false && !stripos($_SERVER["REQUEST_URI"], "logout.php") !== false && !stripos($_SERVER["REQUEST_URI"], "action=password") !== false && !stripos($_SERVER["REQUEST_URI"], "includes") !== false && !stripos($_SERVER["REQUEST_URI"], "widget") !== false && !stripos($_SERVER["REQUEST_URI"], "viewcompare") !== false) {
                    header("Location: " . $config["site_address"] . "settings.php?action=password&msg=1");
                    exit("ERROR Redirecting : settings.php?action=password&msg=1");
                }
                $_SESSION["WLANG"] = $_SESSION["USERLANG"];
            } else {
                if ($storeowner["id"]) {
                    $data = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `id`='" . $config["currency"] . "' "));
                    $_SESSION["currency"] = $data;
                } else {
                    if (!$_SESSION["currency"]) {
                        if (mysqli_num_rows(dquery("select id from tbl_currencies where \nclient='1'"))) {
                            $curd = mysqli_fetch_assoc(dquery("select * from tbl_currencies\n                        where client='1'"));
                            $_SESSION["currency"] = $curd;
                        } else {
                            $data = mysqli_fetch_assoc(dquery("SELECT * FROM  `tbl_currencies` WHERE `default`='1' "));
                            $_SESSION["currency"] = $data;
                        }
                    }
                    if ($selectcurrencie && is_numeric($selectcurrencie)) {
                        $_SESSION["currency"]["id"] = $selectcurrencie;
                        $data = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `id`='" . $selectcurrencie . "'"));
                        $_SESSION["currency"] = $data;
                    }
                }
                unset($data);
            }
            $_SESSION["currency"]["prefix"] = htmlentities($_SESSION["currency"]["prefix"]);
            $filename = $_SERVER["PHP_SELF"];
            $filename = substr($filename, strrpos($filename, "/"));
            $filename = str_replace("/", "", $filename);
            $requesturl = $_SERVER["REQUEST_URI"] . "?";
            $requesturl = substr($requesturl, 0, -1);
            $requesturl = ltrim($requesturl, "/");
            
            if (defined("SSLON") && $config["config_ssl_allow"]) {
                if (!$_SERVER["HTTPS"] || $_SERVER["HTTPS"] == "off") {
                    header("Location: " . $config["config_ssl_allow"] . $requesturl);
                    exit;
                }
                $in_ssl = true;
                $config["site_address"] = $config["config_ssl_allow"];
                $config["siteurl"] = $config["site_address"];
            } else {
                $config["site_address"] = $config["site_address"];
                $config["siteurl"] = $config["site_address"];
            }
            if ($_SERVER["HTTPS"] && !defined("SSLON")) {
                header("Location: " . $config["site_address"] . $requesturl);
            }
            $time = time();
            if (($aid = preg_replace("/[^0-9a-zA-Z]/i", "", $aid)) && $config["affiliate"]) {
                if (mysqli_num_rows($que = dquery("select id from tblUsers where (md5(id)='" . $aid . "' or username='" . $aid . "' ) and affiliate='1'"))) {
                    $que = mysqli_fetch_assoc($que);
                    if (!isset($_COOKIE["AFFILIATETO"]) && $que["id"] != $_SESSION["uid"]) {
                        dquery("update tblUsers set affiliate_visitors=affiliate_visitors+1 where id='" . $que["id"] . "'");
                    }
                    setcookie("AFFILIATETO", enc($que["id"], 9486), time() + 2592000);
                    unset($que);
                    unset($aid);
                }
                if (dec($_COOKIE["AFFILIATETO"], 9486) == $_SESSION["uid"]) {
                    unset($_SESSION["AFFILIATETO"]);
                    setcookie("AFFILIATETO", "NOTA", time() - 2592000);
                }
            }
            if ($page) {
                $page = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $page);
                if (!$next && $next != 0 || $l) {
                    if ($l) {
                        $next = $config["default_page_limit"] * ($page - 1);
                    } else {
                        $next = $config["default_page_limit"] * $page;
                    }
                }
            }
        }
        if (!$next) {
            $next = 0;
        } else {
            if (!is_numeric($next)) {
                $next = preg_replace("/[^0-9]/i", "", $next);
            }
        }
        if (defined('CLIENT') && CLIENT == "1" && !isset($_SESSION["WLANG"]) && !isset($_SESSION["uid"])) {
            $current_country_code = ipToCountry($remote_ip);
            $sql = mysqli_fetch_assoc(dquery("select language from tbl_country_language where country_id='" . $current_country_code . "'"));
            if ($sql["language"]) {
                $_SESSION["WLANG"] = $sql["language"];
            }
        }
        if (defined('CLIENT') && CLIENT == "1" || (defined('API') && API == "1")) {
            if ($_SESSION["WLANG"]) {
                ob_start();
                if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $_SESSION["WLANG"] . ".custom.txt")) {
                    include ROOTDIR . "/" . $config["lang_folder"] . "/" . $_SESSION["WLANG"] . ".custom.txt";
                } else {
                    if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $_SESSION["WLANG"] . ".txt")) {
                        include ROOTDIR . "/" . $config["lang_folder"] . "/" . $_SESSION["WLANG"] . ".txt";
                    } else {
                        include ROOTDIR . "/" . $config["lang_folder"] . "/English.txt";
                    }
                }
            } else {
                ob_start();
                if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $config["language"] . ".custom.txt")) {
                    include ROOTDIR . "/" . $config["lang_folder"] . "/" . $config["language"] . ".custom.txt";
                } else {
                    if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $config["language"] . ".txt")) {
                        include ROOTDIR . "/" . $config["lang_folder"] . "/" . $config["language"] . ".txt";
                    } else {
                        include ROOTDIR . "/" . $config["lang_folder"] . "/English.txt";
                    }
                }
            }
            $lang_cont = ob_get_contents();
            ob_end_clean();
            eval($lang_cont);
        }
        if (!$pagelimit) {
            $pagelimit = $config["default_page_limit"];
        } else {
            if (!is_numeric($pagelimit)) {
                $pagelimit = 10;
            }
        }
        if ($pagelimit == "all") {
            $pagelimit = 99999999;
        }
        if (is_numeric($pagelimit)) {
            setcookie("pagelimit", $itemlimit, time() + 7776000);
            $_COOKIE["pagelimit"] = $itemlimit;
        }
        if (isset($_COOKIE["pagelimit"]) && is_numeric($_COOKIE["pagelimit"])) {
            $pagelimit = $_COOKIE["pagelimit"];
        }
        if (!is_numeric($pagelimit)) {
            $pagelimit = preg_replace("/[^0-9]/i", "", $pagelimit);
        }
        unset($_SESSION["system_default_currency"]);
        if (!$_SESSION["system_default_currency"]) {
            $data = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1' "));
            $_SESSION["system_default_currency"] = $data;
            unset($data);
        }
        if (defined('ADMIN') && ADMIN == "1") {
            $_SESSION["currency_admin"] = $_SESSION["system_default_currency"];
            if (!$_SESSION["admin_template"]) {
                $_SESSION["admin_template"] = $config["admin_template"];
            }
            if ($selectadminlanguage) {
                $_SESSION["admin_language"] = $selectadminlanguage;
            }
            if (isset($_SESSION["admin_language"])) {
                if (file_exists(ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $_SESSION["admin_language"] . ".custom.txt")) {
                    include ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $_SESSION["admin_language"] . ".custom.txt";
                } else {
                    if (file_exists(ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $_SESSION["admin_language"] . ".txt")) {
                        include ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $_SESSION["admin_language"] . ".txt";
                    } else {
                        include ROOTDIR . "/" . $config["admin_directory"] . "/language/English.txt";
                    }
                }
            } else {
                if (file_exists(ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $config["admin_language"] . ".custom.txt")) {
                    include ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $config["admin_language"] . ".custom.txt";
                } else {
                    if (file_exists(ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $config["admin_language"] . ".txt")) {
                        include ROOTDIR . "/" . $config["admin_directory"] . "/language/" . $config["admin_language"] . ".txt";
                    } else {
                        include ROOTDIR . "/" . $config["admin_directory"] . "/language/English.txt";
                    }
                }
            }
        }
        $time_zone_id = isset($config["time_zone"]) ? $config["time_zone"] : "1";
        $time_zone = mysqli_fetch_assoc(dquery("SELECT * from `tbl_timezone_1`\n     WHERE `Time_zone_id`='" . $time_zone_id . "'"));
        $time_zone_name = isset($time_zone["Name"]) && $time_zone["Name"] ? $time_zone["Name"] : "UTC";
        date_default_timezone_set($time_zone_name);
        dquery("SET time_zone='+00:00'");
        unset($time_zone);
        $time = time();
        if (defined('CLIENT') && CLIENT == "1") {
            if (isset($_SESSION["uid"]) && $_SESSION["uid"]) {
                dquery("UPDATE `tblUsers` SET `online_status`='1',`current_login_time`='" . $time . "' WHERE `id`= '" . $_SESSION["uid"] . "'  ");
            }
            dquery("UPDATE `tblUsers` SET `online_status`='0' WHERE (`current_login_time`+120)<'" . $time . "' and `online_status`='1' ");
            dquery("UPDATE `tbl_admin` SET `online`='0' WHERE `online`='1' AND " . $time . ">(`online_time`+900) and `online`='1'");
        }
        if (defined("AUTOREFRESH") && AUTOREFRESH == "1") {
        }
        if (defined("CLIENT") && CLIENT == "1" && $_SESSION["uid"]) {
            if (1800 < time() - $_SESSION["USER_LAST_ACTIVITY"]) {
                unset($_SESSION["uid"]);
                unset($_SESSION["fingerprint"]);
                unset($_COOKIE["x-token"]);
                unset($_SESSION["USER_LAST_ACTIVITY"]);
            } else {
                $_SESSION["USER_LAST_ACTIVITY"] = time();
            }
            if (_getUserFingerPrint() !== $_SESSION["fingerprint"]) {
                unset($_SESSION["uid"]);
                unset($_SESSION["fingerprint"]);
                unset($_COOKIE["x-token"]);
                unset($_SESSION["USER_LAST_ACTIVITY"]);
            }
        }
        if (substr($PHP_SELF, -11, 11) != "notalow.php" && (!defined("API") || API != "1")) {
            $tbl_bannedips_exists = dquery("SHOW TABLES LIKE 'tbl_bannedips'");
            if ($tbl_bannedips_exists && mysqli_num_rows($tbl_bannedips_exists) > 0) {
                $result = full_query("DELETE FROM tbl_bannedips WHERE expires<now() \n        \t\tAND expires!=\"0000-00-00 00:00:00\" AND country=\"0\" ");
                $bannedipcheck = explode(".", $remote_ip);
                $remote_ip1 = $bannedipcheck[0] . "." . $bannedipcheck[1] . "." . $bannedipcheck[2] . ".*";
                $remote_ip2 = $bannedipcheck[0] . "." . $bannedipcheck[1] . ".*.*";
                $result = full_query("SELECT * FROM tbl_bannedips WHERE ip='" . db_escape_string($remote_ip) . "' OR ip='" . db_escape_string($remote_ip1) . "' OR ip='" . db_escape_string($remote_ip2) . "' ORDER BY id DESC");
                $data = mysqli_fetch_assoc($result);
                if ($current_country_code) {
                    $countryband = mysqli_fetch_assoc(dquery("select id from tbl_bannedips where ip='" . $current_country_code . "'"));
                }
                if ($data["id"] || $countryband["id"]) {
                    if ($username || $password) {
                        echo "redirect:notalow.php";
                        exit;
                    }
                    header("Location: " . $config["site_address"] . "/notalow.php");
                    exit;
                }
            }
        }
        if (file_exists(ROOTDIR . "/templates/" . $_SESSION["template"] . "/config.php")) {
            include ROOTDIR . "/templates/" . $_SESSION["template"] . "/config.php";
        }
    } else {
        if (defined("ADMIN") && ADMIN == "1") {
            header("Location: ../installer/index.php");
            exit;
        }
        echo "<strong>Critical Error C404</strong><br>Could not connect to the database";
        exit;
    }
}
if (!$passenc) {
    $passenc = "9486";
    $passencold = "9486";
}
if ($_SERVER["HTTP_HOST"] == "fusiondemo.dhru.com" && $remote_ip != "117.247.85.188" && $remote_ip != "117.247.85.151" && $remote_ip != "15.206.73.143" && $remote_ip != "150.107.254.230") {
    $DEMOMODE = true;
} else {
    $DEMOMODE = false;
}
if ($rowlog || $DEMOMODE) {
    $dolog = false;
    if ($rowlogfilter) {
        $rowlogfilter = explode(",", $rowlogfilter);
        foreach ($rowlogfilter as $k => $v) {
            foreach ($_REQUEST as $rk => $rv) {
                if ($v == $rk) {
                    $dolog = true;
                }
            }
        }
    } else {
        $dolog = true;
    }
    if ($dolog) {
        if (!is_dir(ROOTDIR . "/" . $config["admin_directory"] . "/tmp/rowlog/")) {
            mkdir(ROOTDIR . "/" . $config["admin_directory"] . "/tmp/rowlog/", 493);
        }
        if (!is_dir(ROOTDIR . "/../rowlog/" && $DEMOMODE)) {
            mkdir(ROOTDIR . "/../rowlog/", 493);
        }
        $fh = fopen(ROOTDIR . "/" . $config["admin_directory"] . "/tmp/rowlog/" . date("d_M") . ".log", "a") || exit("can't open rowlog");
        if ($DEMOMODE) {
            $fh2 = fopen(ROOTDIR . "/../rowlog/" . date("d_M") . ".log", "a") || exit("can't open rowlog2");
        }
        $stringData = "[ " . date("H:i:s A ") . " " . $remote_ip . " ] ";
        if ($_REQUEST) {
            foreach ($_REQUEST as $k => $v) {
                if ($k == "password") {
                    $v = "******";
                }
                $stringData .= $k . " => " . $v . " | ";
            }
            if ($_FILES) {
                foreach ($_FILES as $k => $v) {
                    $stringData .= $k . " => " . $v . " | ";
                }
            }
            foreach ($_SESSION as $k => $v) {
                $stringData .= $k . " =ses> " . $v . " | ";
            }
        }
        $stringData .= urldecode($_SERVER["REQUEST_URI"]) . "\n";
        fwrite($fh, $stringData);
        fclose($fh);
        if ($DEMOMODE) {
            fwrite($fh2, $stringData);
            fclose($fh2);
        }
    }
}

unset($WHERE);
unset($where);
unset($Where);
unset($_where);
unset($sql);
unset($cat);
unset($wheres);
unset($_addd_to_update);
chkMd5sum();
if (defined("ADMIN") && ADMIN == "1") {
    $_Content_Security_Policy = "Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.google-analytics.com *.slack.com *.jquery.com " . $Content_Security_Policy_Domains_Admin . " *.dhrusoft.com *.dhru.com ; img-src * data:; font-src * data: ";
} else {
    $_Content_Security_Policy = "Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.google-analytics.com *.google.co.in *.herokuapp.com *.ravepay.co *.flutterwave.com *.stripe.com *.atfawry.com *.google.com  *.facebook.net " . $Content_Security_Policy_Domains . " wss://*.citruspay.com:* wss://*.google.co:* *.citruspay.com wss://*.fawrystaging.com wss://*.atfawry.com wss://*.fawry.com wss://*.youtube.com:* *.youtube.com wss://*.tawk.to:* *.tawk.to *.facebook.com *.fawrystaging.com *.mastercard.com.au *.fawry.com atfawry.fawrystaging.com *.facebook.net *.mastercard.com *.razorpay.com *.google-analytics.com *.securecode.com  *.google.com *.dhru.com *.paypal.com *.googletagmanager.com ; img-src * data:; font-src * data: ";
}
header($_Content_Security_Policy);
header("X-Frame-Options: *");
header("X-Dhru-Core: DHRU FUSION");
header("X-XSS-Protection: 1; mode=block");

?>
