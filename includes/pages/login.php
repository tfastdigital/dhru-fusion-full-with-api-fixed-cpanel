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
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
global $globalid;
if ($globalid) {
    $_SESSION["uid"] = $globalid;
}
if ($action != "clientlogin") {
    header("Location: ./main");
}
check_token();
$loginsuccess = false;
$username = preg_replace("/[^0-9\\-a-zA-Z@._]/i", "", $username);
$username = trim($username);
$password = trim($password);
$seckey = (int) $seckey;
if ($_SESSION["adminid"]) {
    $loginpasskey = trim($loginpasskey);
} else {
    if ($loginpasskey && $orig) {
        if (strpos($config["site_address"], "www") !== false && $orig == 2) {
            $siteurl = str_replace("www.", "", $config["site_address"]);
            header("Location: " . $siteurl . "/login.php?loginpasskey=" . $loginpasskey . "&action=clientlogin&orig=3");
        } else {
            if ($config["config_ssl_allow"]) {
                $siteurl = str_replace("https://", "https://www.", $config["config_ssl_allow"]);
            } else {
                if (strpos($config["site_address"], "https") !== false) {
                    $siteurl = str_replace("https://", "https://www.", $config["config_ssl_allow"]);
                } else {
                    $siteurl = str_replace("http://", "http://www.", $config["site_address"]);
                }
            }
            header("Location: " . $siteurl . "/login.php?loginpasskey=" . $loginpasskey . "&action=clientlogin&orig=2");
        }
    } else {
        if ($loginpasskey) {
            header("Location: " . $config["site_address"] . "/login.php?loginpasskey=" . $loginpasskey . "&action=clientlogin&orig=1");
        }
    }
    $loginpasskey = NULL;
}
if (!$username && !$loginpasskey) {
    if ($action == "clientlogin") {
        $_SESSION["askcaptcha"] = 1;
    }
    $err_output .= "<li>" . $lng_languag["usernamereq"] . "</li>";
}
if (!($password || $_SESSION["adminid"])) {
    if ($action == "clientlogin") {
        $_SESSION["askcaptcha"] = 1;
    }
    $err_output .= "<li>" . $lng_languag["passreq"] . "</li>";
}
$fromadmins = 1;
if ($_SESSION["adminid"] && $loginpasskey) {
    $loginpasskey = explode(",", base64_decode($loginpasskey));
    $fromadmins = 0;
    list($username, $password) = $loginpasskey;
}
$block_accout = false;
$canactive = false;
if ($username && $password) {
    if (!$_SESSION["adminid"]) {
        $where = "  ";
    }
    if ($storeowner["id"]) {
        $where .= " AND  (`storeownerid`='" . $storeowner["id"] . "'\r\n         or `reseller_id`='" . $storeowner["id"] . "' ) ";
    } else {
        $where .= " AND (usertype!='3' or (select a.reseller_can_setupstore from tblUsers as a \r\n        where a.id=tblUsers.reseller_id)='0' )";
    }
    $flag = 1;
    if ($fromapp || $viewinvoice) {
        unset($config["captcha_login"]);
    }
    if ($config["captcha_login"] && $fromadmins == 1) {
        $captcha = md5($verification);
        if (strtolower($captcha) != strtolower($_SESSION["varify"]) && strtolower($captcha) != strtolower($_SESSION["fromlogin"])) {
            echo "error:<li>" . $lng_languag["wrongverify"];
            $flag = 0;
        }
    }
    $_SESSION["varify"] = rand(3312, 89999);
    $_SESSION["fromlogin"] = rand(111, 9999);
    if ($flag) {
        $username = descape($username);
        $result = dquery("SELECT * FROM `tblUsers` WHERE (`username`='" . $username . "' or `email`='" . $username . "') " . $where);
        $data = mysqli_fetch_assoc($result);
        if (!$payment && isset($_SESSION["merchantemail"]) && $_SESSION["merchantemail"] == $data["email"]) {
            echo "error:" . $lng_languag["yourloginseller"];
        }
        if ($data["id"]) {
            if (!$data["themesettings"]) {
                $ThemeSettings = "{\"orderstyle\":\"\",\"mode\":\"\",\"column\":{\"orderid\":true,\"credit\":true,\"date\":true,\"action\":true,\"compaq\":true}}";
                dquery("update tblUsers set themesettings='" . $ThemeSettings . "' where id='" . $data["id"] . "'");
            }
            $validIp[] = $data["ip_range1"];
            $validIp[] = $data["ip_range2"];
            $validIp[] = $data["ip_range3"];
            $validIp[] = $data["ip_range4"];
            $validIp[] = $data["ip_range5"];
            if ($data["lastpassreset"] == "1111111111") {
                $_pass_enc = $passencold;
                $_force_chnage = true;
                $_SESSION["afterloginredirect"] = "settings.php?action=password&msg=1";
                $_SESSION["forcepasschnage"] = true;
            } else {
                $_pass_enc = $passenc;
            }
            if (trim($data["tmp_password"]) == md5($password) && $data["tmp_pass_time"] + 3600 < time()) {
                $_SESSION["askcaptcha"] = 1;
                $err_output .= "<li>" . $lng_languag["passexipred"] . "</li>";
            } else {
                if ($data["password"] != md5(md5($password) . $_pass_enc) && trim($data["tmp_password"]) != md5($password) && !$_SESSION["adminid"]) {
                    $_SESSION["askcaptcha"] = 1;
                    $err_output .= "<li>" . $lng_languag["passnotmatch"] . "</li>";
                    dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 \r\n                   WHERE `id`= '" . $data["id"] . "'");
                    $mail_ver["blockreson"] = "Automatically block (" . $config["MaxLoginFailedAttempts"] . " failed login attempts) from IP -" . $remote_ip;
                    $config["MaxLoginFailedAttempts"] = $config["MaxLoginFailedAttempts"] - 1;
                    $login_attempts = mysqli_fetch_assoc(dquery("SELECT `login_failed_atoms` FROM `tblUsers` WHERE `id`='" . $data["id"] . "' AND `login_failed_atoms` > '" . $config["MaxLoginFailedAttempts"] . "' "));
                    if ($login_attempts) {
                        dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                        if (!isWhiteIP($remote_ip)) {
                            blockIP($remote_ip, $mail_ver["blockreson"], 15);
                        }
                        require_once ROOTDIR . "/includes/mail.fun.php";
                        sendMail(5, $data["id"], "", $mail_ver);
                        if ($config["adminblocknotice"]) {
                            $adminmessage = " " . $data["username"] . " [#" . $data["id"] . "] Account blocked<Br />\r\n                    Email: " . $data["email"] . " <br />\r\n                    Country : " . $data["country"] . " <br />                    \r\n                    " . $mail_ver["blockreson"] . " ";
                            sendNotification("system", "Client Account blocked", $adminmessage, $mailto);
                        }
                    }
                } else {
                    if ($data["userstatus"] != "0") {
                        if ($data["canactive"] && $config["smsgateway"]) {
                            $_SESSION["CANACTIVE"] = true;
                            $varac = "<br />To active your account<strong><a href='activeuser.php'> click here</a></strong>";
                        }
                        $err_output .= "<li>" . $lng_languag["accoutnotact"] . " " . $data["block_reason"] . $varac . " </li>";
                    } else {
                        if ($loginpasskey) {
                            unset($data["sndlogin"]);
                        }
                        if ($data["sndlogin"] && !$seckey) {
                            $succ_output .= "showdiv:.onetimepass";
                        } else {
                            $nextstep = true;
                            if ($seckey) {
                                $nextstep = false;
                                require "includes/loginsec.fun.php";
                                if (Google2FA::verify_key($data["sndlogin"], $seckey)) {
                                    $nextstep = true;
                                } else {
                                    $nextstep = false;
                                }
                            }
                            if ($nextstep) {
                                $ipvalidation = false;
                                if ($data["ip_range"]) {
                                    $ipvalidation = checkIPinList($data["ip_range"], $remote_ip);
                                } else {
                                    $ipvalidation = true;
                                }
                                if ($ipvalidation) {
                                    include_once ROOTDIR . "/includes/geo.fun.php";
                                    $login_country_code = ipToCountry($remote_ip);
                                    $login_country = $login_country_code;
                                    $_addd_to_update = "";
                                    $CountryMatch = true;
                                    $LoginCountry = json_decode($data["allowedcountry"], true);
                                    if (trim($data["allowedcountry"])) {
                                        $CountryMatch = false;
                                    }
                                    foreach ($LoginCountry as $lcountry) {
                                        if ($lcountry == trim($login_country_code)) {
                                            $CountryMatch = true;
                                        }
                                    }
                                    if ($data["login_country"] && trim($login_country_code)) {
                                        if (($data["country"] != $login_country_code || !$CountryMatch) && !$development && trim($data["tmp_password"]) != md5($password)) {
                                            if ($config["sendcountrymail"]) {
                                                $mail_ver["loginip"] = $remote_ip;
                                                $mail_ver["logincountry"] = $login_country;
                                                $mail_ver["logincountrycode"] = $login_country_code;
                                                require_once ROOTDIR . "/includes/mail.fun.php";
                                                sendMail(51, $data["id"], "", $mail_ver);
                                            }
                                            if ($config["block_ac_on_country_mismatch"] && !isWhiteIP($remote_ip) && !$data["allowcountry"]) {
                                                require_once ROOTDIR . "/includes/mail.fun.php";
                                                $mail_ver["blockreson"] = "Login from " . $login_country . "(" . $login_country_code . ") " . $remote_ip;
                                                dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`='1',`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                                                blockIP($remote_ip, $mail_ver["blockreson"], 15);
                                                sendMail(5, $data["id"], "", $mail_ver);
                                                $block_accout = true;
                                                if ($config["adminblocknotice"]) {
                                                    $adminmessage = " Client [#" . $data["id"] . "] Account blocked<Br />                    \r\n                                                " . $mail_ver["blockreson"] . " ";
                                                    sendNotification("system", "Client Account blocked", $adminmessage, $mailto);
                                                }
                                            }
                                        }
                                    } else {
                                        $_addd_to_update = " , `login_country`='" . $login_country_code . "'";
                                    }
                                    geoip_close($gi);
                                    $lastlogin = time();
                                    $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
                                    $session = session_id();
                                    $time = time();
                                    dquery("UPDATE `tblUsers` SET `enc_login`= '" . $encdata . "',`last_login`='" . $lastlogin . "',\r\n                    `last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\r\n                    `current_login_time`='" . $time . "',`online_status`='1' " . $_addd_to_update . ",\r\n                    `login_failed_atoms`='0'\r\n                    WHERE `id`= '" . $data["id"] . "' ");
                                    $ins = NULL;
                                    $ins["username"] = $username;
                                    $ins["userid"] = $data["id"];
                                    $ins["ip"] = $remote_ip;
                                    $ins["time"] = time();
                                    $db->insert("tbl_loginlog_user", $ins);
                                    $ins = NULL;
                                    $ua = getBrowser();
                                    sendTelegramMessage("@" . $username . " logged in from " . $remote_ip . " " . $ua["name"] . ", " . $login_country, $data["messengerid"]);
                                    if ($rememberme && isset($_COOKIE["DHRUFUSION_euFunc"])) {
                                        setcookie("FUSION_UID", $username, time() + 31536000);
                                        setcookie("FUSION_PW", $password, time() + 31536000);
                                    }
                                    if (!$block_accout) {
                                        $_SESSION["askcaptcha"] = 0;
                                        $_SESSION["uid"] = $data["id"];
                                        $_SESSION["fingerprint"] = _getUserFingerPrint();
                                        setcookie("x-token", sha1(date("d") . "-" . $_SERVER["HTTP_USER_AGENT"]), time() + 2592000, "/", "." . $_SERVER["HTTP_HOST"], false, true);
                                        $_SESSION["USER_LAST_ACTIVITY"] = time();
                                        $_SESSION["username"] = $data["username"];
                                        $_SESSION["fullname"] = $data["first_name"] . " " . $data["last_name"];
                                        dquery("DELETE FROM `tbl_chat_visitor` \r\n                                WHERE `username`= '" . $_SESSION["user_livechat_username"] . "'");
                                        $_SESSION["user_livechat_username"] = $data["username"];
                                        $_SESSION["USERLANG"] = $data["language"];
                                        $_SESSION["currency"] = $data["default_currency"];
                                        $_SESSION["shippingzip"] = $data["zip"];
                                        $_SESSION["shippingstate"] = $data["state"];
                                        $_SESSION["shippingcountry"] = $data["country"];
                                        if ($config["afterlogin_apply"] && $config["template_afterlogin"] != "") {
                                            $_SESSION["template"] = $config["template_afterlogin"];
                                        } else {
                                            if ($data["default_theme"]) {
                                                $_SESSION["template"] = $data["default_theme"];
                                            } else {
                                                $_SESSION["template"] = $config["template_afterlogin"];
                                            }
                                        }
                                        $_SESSION["encdata"] = $encdata;
                                    }
                                    $_SESSION["last_login"] = $data["last_login"] . "," . $data["last_login_ip"];
                                    $days = $data["lastpassreset"] + $config["password_expired"] * 86400;
                                    if ($days < time() && 0 < $config["password_expired"] && !$_SESSION["CART"]) {
                                        $_SESSION["afterloginredirect"] = "settings.php?action=password&msg=1";
                                    }
                                    if (isset($_SESSION["CART"])) {
                                        foreach ($_SESSION["CART"] as $key => $_subtotal) {
                                            if ($_SESSION["CART"][$key]["orderdetail"]["promotion"]) {
                                                $promocode = $_SESSION["CART"][$key]["orderdetail"]["promotion"];
                                                $code = enc($promocode, "9486");
                                                $ql = mysqli_fetch_assoc(dquery("select * from tbl_promotion \r\n                                where code='" . $code . "'"));
                                                if ($ql["newsignup"]) {
                                                    unset($_SESSION["CART"][$key]["orderdetail"]["promotion"]);
                                                }
                                            }
                                        }
                                        if ($_SESSION["CARTPROMOTION"]) {
                                            $promocode = $_SESSION["CARTPROMOTION"];
                                            $code = enc($promocode, "9486");
                                            $ql = mysqli_fetch_assoc(dquery("select * from tbl_promotion \r\n                            where code='" . $code . "'"));
                                            if ($ql["newsignup"]) {
                                                unset($_SESSION["CARTPROMOTION"]);
                                            }
                                        }
                                    }
                                    if ($viewinvoice) {
                                        $_SESSION["frominv"] = $viewinvoice;
                                        $_SESSION["afterloginredirect"] = "viewinvoice.php?id=" . $viewinvoice;
                                        $SiteAddress = $config["site_address"];
                                        if ($config["config_ssl_allow"]) {
                                            $SiteAddress = $config["config_ssl_allow"];
                                        }
                                        $SiteAddress = substr($SiteAddress, 0, -1);
                                        echo "                                    <script>\r\n                                        location.href='";
                                        echo $SiteAddress . "/viewinvoice/id/" . md5($viewinvoice);
                                        echo "';\r\n                                    </script>\r\n                                    ";
                                        exit;
                                    }
                                    if ($fromapp) {
                                        $_SESSION["fromapp"] = 1;
                                        $_SESSION["afterloginredirect"] = _url("addfunds");
                                        $SiteAddress = $config["site_address"];
                                        if ($config["config_ssl_allow"]) {
                                            $SiteAddress = $config["config_ssl_allow"];
                                        }
                                        $SiteAddress = substr($SiteAddress, 0, -1);
                                        echo "                                    <script>\r\n                                        location.href='";
                                        echo _url("addfunds", true);
                                        echo "';\r\n                                    </script>\r\n";
                                        exit;
                                    }
                                    if ($_SESSION["afterloginredirect"]) {
                                        if (stripos($_SESSION["afterloginredirect"], "http") !== false) {
                                            $ste_addr = str_replace("http://", "", $_SESSION["afterloginredirect"]);
                                            $ste_addr = str_replace("https://", "", $ste_addr);
                                            $succ_output .= "redirectto: " . $ste_addr;
                                        } else {
                                            $succ_output .= "redirect: " . $_SESSION["afterloginredirect"];
                                        }
                                        unset($_SESSION["afterloginredirect"]);
                                    } else {
                                        if ($nextreg) {
                                            $succ_output .= "redirect: " . _url("index/login/nextreg");
                                            header("Location:" . _url("index/login/nextreg", true));
                                        } else {
                                            if ($payment) {
                                                $succ_output .= "redirect: index?login=success";
                                                header("Location:" . _url("index/login/success", true));
                                            } else {
                                                $succ_output .= "redirect: " . _url("main?login=success", true);
                                                header("Location:" . _url("main/login/success", true));
                                            }
                                        }
                                        exit;
                                    }
                                } else {
                                    $_SESSION["askcaptcha"] = 1;
                                    $_SESSION["validIp"] = $_SESSION["validIp"] + 1;
                                    if (2 < $_SESSION["validIp"]) {
                                        dquery("UPDATE `tblUsers` SET `block_reason`='Automatically block (login tried from IP-" . $remote_ip . ")',`userstatus`='1' WHERE `id`='" . $data["id"] . "'");
                                        unset($_SESSION["validIp"]);
                                    }
                                    $err_output .= "<li>" . $lng_languag["ipnotmatch"] . " (" . $remote_ip . ")</li>";
                                }
                            } else {
                                $_SESSION["askcaptcha"] = 1;
                                $err_output .= "<li>invalid One time password</li>";
                            }
                        }
                    }
                }
            }
        } else {
            $_SESSION["askcaptcha"] = 1;
            $err_output .= "<li>" . $lng_languag["userincorrect"] . "</li>";
        }
    }
}
if ($err_output) {
    if ($loginshare) {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<loginshare>\r\n    <result>0</result>\r\n    <message>Invalid Username or Password</message>\r\n</loginshare>";
        exit;
    }
    echo "error:" . $err_output;
}
if ($succ_output) {
    if ($loginshare) {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n        <loginshare>\r\n            <result>1</result>\r\n            <user>\r\n                <usergroup>Registered</usergroup>\r\n                <fullname>" . $_SESSION["fullname"] . "</fullname>\r\n                <emails>\r\n                    <email>" . $data["email"] . "</email>\r\n                </emails>\r\n                <phone>" . $data["phone"] . "</phone>\r\n            </user>\r\n        </loginshare>";
        exit;
    }
    if ($_SESSION["adminid"] && $loginpasskey) {
        header("Location: ./main");
        echo "<script>location.href='./main';</script> ";
        exit;
    }
    echo $succ_output;
}
chkMd5sumsubpage();
function validIp($iprange)
{
    global $remote_ip;
    foreach ($iprange as $_ip) {
        if ($_ip) {
            $ipr = explode(",", $_ip);
            if (abs(ip2long($ipr[0])) <= abs(ip2long($remote_ip)) && abs(ip2long($remote_ip)) <= abs(ip2long($ipr[1]))) {
                return true;
            }
            return false;
        }
    }
    return true;
}

?>