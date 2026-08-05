<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
unset($_SESSION["deviceid"]);
require "includes/fun.inc.php";
require "../includes/fun.inc.php";
require "includes/comm.inc.php";
require "../includes/mail.fun.php";
include_once ROOTDIR . "/includes/mobiledevice.inc.php";
require_once "includes/3rdparty/googleauth.php";
$lite = $WhiteLabel = $liteplus = $versioncatch = false;
$addons = [];
try {
    $licinfo = [
        "status" => "Active",
        "item_id" => "",
        "addons" => [],
        "version" => ["release" => "1"]
    ];
    if ($debug_output) {
        echo "<textarea cols=100 rows=20>";
        print_r($licinfo);
        echo "</textarea>";
    }
    if ($licinfo["status"] === "Active") {
        
        $_server_ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
      
        if ($licinfo["item_id"] === "06d2db89-494c-463b-9e21-289991a74952") {
            $lite = true;
        } else {
            if ($licinfo["item_id"] === "43") {
                $liteplus = true;
            }
        }
        foreach ($licinfo["addons"] as $k => $addondetail) {
            if ($addondetail["name"] == "White Label" && $addondetail["status"] == "Active") {
                $WhiteLabel = true;
            }
        }
        if ($licinfo["addons"]) {
            $addons = $licinfo["addons"];
        }
        if ($devmode) {
            $versioncatch = md5(time());
        } else {
            $versioncatch = $licinfo["version"]["release"];
        }
    } else {
         $versioncatch = $licinfo["version"]["release"];
    }
} catch (\Exception $e) {
   
}
$sessionExpired = $_GET["sessexp"];
$mobilebrowser = mobile_device_detect();
$time = time();
dquery("UPDATE `tbl_admin` SET `online`='0' WHERE `online`='1' AND " . $time . ">(`online_time`+900) and `online`='1'");
if (!isset($_COOKIE["device"]) && !isset($_SESSION["deviceid"])) {
    $deviceid = uniqid("DhruFusion", true);
    $_SESSION["deviceid"] = $deviceid;
} else {
    $deviceid = preg_replace("/[^0-9\\-a-zA-Z.]/i", "", $_COOKIE["device"]);
    $_SESSION["deviceid"] = $deviceid;
}
if (function_exists("loginDevices") && !loginDevices($_SESSION["deviceid"], "", true) && !isset($_POST["username"]) && $config["slack_suspiousaccess"]) {
    $_cols[0]["titel"] = "IP";
    $_cols[0]["text"] = "<https://tools.keycdn.com/geo?host=" . $remote_ip . "|" . $remote_ip . ">";
    SlackSendMsg($config["slack_suspiousaccess"], "Suspicious admin page access found!", "danger", $_cols, false);
}
$admn = mysqli_num_rows(dquery("select * from tbl_admin"));
if (!$admn) {
    header("Location: setup.php");
    echo "<script>location.href='setup.php';</script> Admin setup required, <a href=\"setup.php\">Click here to run</a> ";
    exit;
}
if (checkAdminlogin() && $_SESSION["adminid"]) {
    header("Location:main.php");
}
if ($reset) {
    if ($uname != "" && $email != "" && $license != "") {
        $uname = preg_replace("/[^A-Za-z0-9]/", "", $uname);
        $email = preg_replace("/[^a-zA-Z0-9\\/:@\\.\\+-s]/", "", $email);
        $license = preg_replace("/[^a-zA-Z0-9\\-]/", "", $license);
        $sql = dquery("SELECT * FROM tbl_admin where username='" . $uname . "' and email='" . $email . "'");
        if (mysqli_num_rows($sql)) {
            $license = enc(str_replace("-", "", $license));
            $lic = dquery("SELECT * FROM tbl_license where `license_key`='" . $license . "'");
            if (mysqli_num_rows($lic)) {
                $admn = mysqli_fetch_assoc($sql);
                $_PASS = PassGen();
                $encrypt = md5(md5($_PASS) . "9486");
                dquery("UPDATE tbl_admin set password='" . $encrypt . "' \n                where id='" . $admn["id"] . "'");
                $here = "<a href='" . $config["site_address"] . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("editadmin&admn=" . $admn["id"]) . "&title=" . base64_encode("My Account") . "'>here</a>";
                $adminmessage = "Your Requested new password. <br><br>\n                                Username : " . $admn["username"] . "<br>\n                                Password : " . $_PASS . "<br><br>\n                                " . $config["site_address"] . " \n                                <br /><br />\n                                Click " . $here . " to manage your account ";
                sendNotification("other", "Your New Password", $adminmessage, [$admn["email"]]);
                echo "                <script> alert(\"Password reset successfully !\");</script>\n                <META HTTP-EQUIV=\"Refresh\" Content=\"0; URL=index.php\">";
                exit;
            }
            $date = date("d/m/Y H:i:s");
            $ip = $_SERVER["REMOTE_ADDR"];
            $adminmessage = "A recent Reset password failed. <br><br>\n                                Date/Time: " . $date . "<br>\n                                Username: " . $uname . "<br>\n                                IP Address: " . $ip . "<br><br>\n                                " . $config["site_address"];
            sendNotification("system", "Admin Failed reset password", $adminmessage, []);
            echo "                <script> alert(\"Wrong Information !\"); </script>\n                ";
        } else {
            $date = date("d/m/Y H:i:s");
            $ip = $_SERVER["REMOTE_ADDR"];
            $adminmessage = "A recent Reset password failed. <br><br>\n                           Date/Time: " . $date . "<br>\n                           Username: " . $uname . "<br>\n                           IP Address: " . $ip . "<br><br>\n                           " . $config["site_address"];
            sendNotification("system", "Admin Failed reset password", $adminmessage, []);
            echo "            <script> alert(\"Wrong Information !\"); </script>\n        ";
        }
    } else {
        echo "        <script> alert(\"All field required !\"); </script>\n        ";
    }
}
$FlagforEntry = true;
$failedattempt = (int) $config["loginfailed"];
if (($username || $password) && $FlagforEntry) {
    if (check_token()) {
        $loginsuccess = false;
        $username = trim($username);
        $password = trim($password);
        $tmppass = $password;
        $tmpuser = $username;
        $_SESSION["tmp_p"] = $password;
        $err_output = NULL;
        if ($username) {
            if ($password) {
                $username = descape($username);
                $password = descape($password);
                $password = md5(md5($password) . "9486");
                $result = dquery("SELECT tbl_admin.*,tbl_admin_access_group.access,tbl_admin_access_group.group_name FROM `tbl_admin`,`tbl_admin_access_group`\n                 WHERE `username`='" . $username . "' and `password`='" . $password . "' and `status`='0' and tbl_admin.group_id=tbl_admin_access_group.id");
                $data = mysqli_fetch_assoc($result);
                if ($data) {
                    if ($data["ip_range"]) {
                        $ipvalidation = checkIPinList($data["ip_range"], $remote_ip);
                    } else {
                        $ipvalidation = false;
                    }
                    if ($data["google"] && !$ipvalidation) {
                        $checkotp = true;
                        $_SESSION["tmp_u"] = $username;
                    }
                    if ($otp) {
                        if (\Google2FA::verify_key($data["seclogin"], $otp)) {
                            $checkotp = false;
                        } else {
                            echo "                            <script>alert(\"Wrong OTP\");</script>\n                            ";
                        }
                    }
                    if (!$checkotp) {
                        unset($_SESSION["tmp_u"]);
                        unset($_SESSION["tmp_p"]);
                        $ins = NULL;
                        $ins["username"] = $username;
                        $ins["userid"] = $data["id"];
                        $ins["ip"] = $remote_ip;
                        $ins["time"] = time();
                        $db->insert("tbl_loginlog_admin", $ins);
                        $ins = NULL;
                        $_SESSION["a_logintime_enc_key"] = md5($remote_ip . "adsf2ds");
                        $_SESSION["adminid"] = $data["id"];
                        $_SESSION["adminrole"] = $data["group_name"];
                        $_SESSION["adminname"] = $data["username"];
                        $_SESSION["rejectorderbyadmin"] = $data["rejectorder"];
                        $_SESSION["admwid"] = $data["mywarehouse"];
                        $_SESSION["admintheme"] = $data["theme"];
                        $_SESSION["livechat_username"] = $data["username"];
                        $htacess = file_get_contents(".htaccess");
                        if (strpos($htacess, "AuthUserFile") !== false) {
                            $_SESSION["ADprotect"] = true;
                        }
                        $time = time();
                        if ($config["online_status"] == "offline") {
                            saveSettings("online_status", "online");
                        }
                        saveSettings("live_chat_online_time", $time);
                        saveSettings("live_chat_online_time", $time);
                        saveSettings("live_chat_online_username", $data["username"]);
                        dquery("UPDATE `tbl_admin` SET `online` = '1',`online_time`='" . $time . "' WHERE `id` ='" . $data["id"] . "'");
                        if ($data["language"]) {
                            $_SESSION["admin_language"] = $data["language"];
                        }
                        include_once ROOTDIR . "/includes/mobiledevice.inc.php";
                        if ($data["template"]) {
                            $_SESSION["admin_template"] = "default2";
                        }
                        $_SESSION["page_access"] = $data["access"];
                        if ($data["support_department"]) {
                            $_SESSION["department"] = $data["support_department"];
                        }
                        if ($rememberme) {
                            setcookie("FUSION_ADM", $tmpuser, time() + 31536000);
                            setcookie("FUSION_ADPW", $tmppass, time() + 31536000);
                        } else {
                            setcookie("FUSION_ADM", $tmpuser, time() - 90);
                            setcookie("FUSION_ADPW", $tmppass, time() - 90);
                        }
                        saveSettings("loginfailed", 0);
                        loginDevices($_SESSION["deviceid"], $_SESSION["adminid"]);
                        if ($_SESSION["admin_afterlogin_re"]) {
                            header("Location:" . $_SESSION["admin_afterlogin_re"]);
                            echo "<script>location.href='" . $_SESSION["admin_afterlogin_re"] . "';</script> ";
                        } else {
                            header("Location:main.php");
                            echo "<script>location.href='main.php';</script> ";
                        }
                    }
                } else {
                    $date = date("d/m/Y H:i:s");
                    $ip = $_SERVER["REMOTE_ADDR"];
                    $adminmessage = "A recent login attempt failed. Details of the attempt are below. <br><br>\n                                    Date/Time: " . $date . "<br>\n                                    Username: " . $username . "<br>\n                                    IP Address: " . $ip . "<br><br>\n                                    " . $config["site_address"];
                    $loginfailed = $config["loginfailed"] ? $config["loginfailed"] : 1;
                    saveSettings("loginfailed", $loginfailed + 1);
                    sendNotification("system", "Admin Failed Login Attempt", $adminmessage, []);
                    if ($config["slack_adminloginfailed"]) {
                        $_cols[0]["titel"] = "IP";
                        $_cols[0]["text"] = "<https://tools.keycdn.com/geo?host=" . $remote_ip . "|" . $remote_ip . ">";
                        $_cols[1]["titel"] = $username;
                        $_cols[1]["text"] = substr($password, 0, 2, "**");
                        SlackSendMsg($config["slack_adminloginfailed"], "Invalid administrator login attempt!", "danger", $_cols, true);
                    }
                    echo "                    <script> alert('";
                    echo $LNG["invaliduserpass"];
                    echo "');</script>\n                    ";
                }
            } else {
                echo "                <script> alert('";
                echo $LNG["passreq"];
                echo "');</script>\n                ";
            }
        } else {
            echo "            <script> alert('";
            echo $LNG["usernamereq"];
            echo "');</script>\n            ";
        }
    } else {
        echo "        <script> alert('";
        echo $LNG["invalidtoken"];
        echo "');</script>\n        ";
    }
}
if ($err_output) {
    echo $err_output;
}
echo "\n\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    <meta http-equiv=\"content-type\"\n          content=\"text/html;charset=";
echo $config["admincharset"];
echo "\"/>\n\n\n    <title>\n        ";
if (!$WhiteLabel) {
    echo "            Dhru Fusion Pro\n            ";
} else {
    echo "ADMINCP";
}
echo "        ";
echo $lite ? " lite" : "";
echo $liteplus ? " lite plus" : "";
echo " | Login</title>\n\n\n    ";
if ($WhiteLabel) {
    echo "        <link rel=\"icon\" type=\"image/png\" href=\"admincp-favicon-32x32.png\" sizes=\"32x32\"/>\n        <link rel=\"icon\" type=\"image/png\" href=\"admincp-favicon-16x16.png\" sizes=\"16x16\"/>\n        ";
} else {
    echo "        <link rel=\"icon\" type=\"image/png\" href=\"includes/images/ic_logo.png\" />\n        ";
}
echo "\n\n    <meta name=\"ROBOTS\" content=\"noindex, nofollow\"/>\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">\n    <script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\n\n\n    <link href=\"includes/css/bootstrap.min.css\" rel=\"stylesheet\"\n          integrity=\"sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3\" crossorigin=\"anonymous\">\n\n    <script src=\"includes/js/bootstrap.bundle.min.js\"\n            integrity=\"sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p\"\n            crossorigin=\"anonymous\"></script>\n\n\n    <script src=\"templates/default/js/keyboard.js\" type=\"text/javascript\"></script>\n    <style type=\"text/css\">\n        * {\n            -webkit-appearance: none\n        }\n\n        body, html {\n            height: 100%;\n        }\n\n        a {\n            color: #0f1e41;\n            text-decoration: none;\n        }\n\n        .center {\n            justify-content: center;\n            align-items: center;\n            display: flex;\n        }\n\n        .form-control {\n            color: #495057;\n            background-color: #fff;\n            outline: 0;\n            padding: 12px;\n            height: auto;\n        }\n\n        .form-control:focus {\n            border-color: transparent;\n            box-shadow: inset 0 0 0 2px #0f1e41;\n        }\n\n        .form-group label {\n            display: inline-block;\n            font-weight: 500;\n            padding: 15px 0 2px;\n            margin-bottom: 0;\n        }\n\n        .btn-primary {\n            background: #27AC7B;\n            border-color: #27AC7B;\n        }\n        .btn-primary:hover,.btn-primary:active{\n            background: #27AC7B !important;\n            border-color: #27AC7B !important;\n        }\n\n        [type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {\n            cursor: pointer;\n            height: 45px;\n        }\n\n        .langauge-dropdown {\n            border: none;\n            font-size: 14px;\n        }\n        .langauge-dropdown:focus,.langauge-dropdown:hover {\n             box-shadow: none;\n        }\n\n    </style>\n\n    <script language=\"javascript\">\n        function sf() {\n            document.getElementById('username').focus();\n        }\n    </script>\n    <link href=\"templates/default/css/keyboard.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\"/>\n\n</head>\n\n\n<body onload=\"sf()\">\n\n<div class=\"d-flex h-100\">\n\n    <div class=\"d-flex w-100 h-100\" style=\"background: rgb(34, 44, 84);\">\n        ";
if (!$sessionExpired) {
    echo "        <div class=\"d-none d-lg-block\" style=\"min-width: 600px; max-width: 500px; position: relative;\">\n            <div class=\"d-flex h-100\" style=\"flex-direction: column;\"><img src=\"includes/svg/Side_Bar_Bg.svg\"\n                                                                           alt=\"sidebar\"\n                                                                           style=\"position: absolute; bottom: 0px;\">\n                <div class=\"w-100\" style=\"padding: 2rem; text-align: left; position: absolute; top: 0px;\"><img\n                            src=\"includes/svg/2020_logo_svg_tp.svg\" alt=\"logo\" style=\"width: 80px;\"></div>\n                <div class=\"w-100\" style=\"text-align: right; position: absolute; top: 103px; right: 30px;\"><img\n                            src=\"includes/svg/Clouds.svg\" alt=\"cloud\" style=\"width: 300px;\"></div>\n                <div class=\"h-100\">\n                    <div class=\"center h-100\">\n                        <div style=\"z-index: 11; margin-top: -200px;\"><h1\n                                    class=\"text-white text-left w-100 m-0\"\n                                    style=\"opacity: 1; font-size: 100px; padding: 0px 3rem; font-weight: 300;\">\n                                Welcome,</h1>\n                            <h3 class=\"text-white text-left w-100\"\n                                style=\"opacity: 1; font-size: 30px; padding: 0px 3rem; font-weight: 300;  margin-left: 10px;\">\n                                Back! login to your account</h3></div>\n                    </div>\n                </div>\n                <div class=\"mt-auto w-100 p-4 text-white\" style=\"position: absolute; bottom: 0px;\">\n                    <div class=\"left\" style=\"font-size: 13px;opacity: 0.7\"><small> &copy; <a class=\"text-white\"\n                                                                                             href=\"https://www.dhru.com/\">Dhru\n                                Cloud Pvt Ltd</a>&nbsp; 2022.</small></div>\n                </div>\n            </div>\n        </div>\n        ";
}
echo "        <div class=\"center  bg-white h-100  w-100\">\n            <div style=\"max-width: 380px\">\n                <div class=\"m-auto\">\n\n                    <div class=\"position-absolute\" style=\"right: 0;top: 0;padding: 10px;display: flex;justify-content: center;align-items: center;opacity: 0.7\">\n                        ";
echo getLanguageDropdown();
echo "                        <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>\n                    </div>\n\n                    <div>\n                        <h2>Sign in to ";
echo $config["companyname"];
echo "</h2>\n                        ";
if ($WhiteLabel) {
    echo "                                <div class=\"text-logo\">ADMIN<span>CP</span></div>\n                                ";
}
echo "                    </div>\n\n                    <div class=\"mt-4\">\n\n\n                        <div  class=\"groupstabes\">\n                            <div class=\"groupstabescontant\">\n\n                                ";
if ($action == "remind") {
    echo "                                    <div id=\"login\">\n                                        <form action=\"\" method=\"post\" name=\"frmlogin\" id=\"frmlogin\">\n                                            ";
    echo generate_token("form");
    echo "\n\n                                            <div class=\"form-group\">\n                                                <label>Username</label>\n                                                <input value=\"";
    echo $LNG["username"];
    echo "\"\n                                                       class=\"form-control\"\n                                                       onfocus=\"if (this.value =='";
    echo $LNG["username"];
    echo "') {this.value = '';}\"\n                                                       onblur=\"if (this.value == '') {this.value = '";
    echo $LNG["username"];
    echo "';}\"\n                                                       type=\"text\" value=\"\" name=\"uname\" size=\"30\"/>\n                                            </div>\n\n\n                                            <div class=\"form-group\">\n                                                <label>Password</label>\n                                                <input class=\"form-control\"\n                                                       value=\"";
    echo $LNG["email"];
    echo "\"\n                                                       onfocus=\"if (this.value =='";
    echo $LNG["email"];
    echo "') {this.value = '';}\"\n                                                       onblur=\"if (this.value == '') {this.value = '";
    echo $LNG["email"];
    echo "';}\"\n                                                       type=\"text\" name=\"email\" size=\"30\"/>\n                                            </div>\n\n                                            <div class=\"form-group\">\n                                                <label>License Key</label>\n                                                <input value=\"";
    echo $LNG["licensekey"];
    echo "\"\n                                                       class=\"form-control\"\n                                                       onfocus=\"if (this.value =='";
    echo $LNG["licensekey"];
    echo "') {this.value = '';}\"\n                                                       onblur=\"if (this.value == '') {this.value = '";
    echo $LNG["licensekey"];
    echo "';}\"\n                                                       type=\"text\" name=\"license\" size=\"30\"/>\n                                            </div>\n\n                                            <div class=\"mt-4\">\n                                                <button type=\"submit\" tabindex=\"3\" name=\"reset\"\n                                                        class=\"btn btn-primary w-100\">\n                                                    ";
    echo $LNG["resetpass"];
    echo "                                                </button>\n                                            </div>\n\n                                        </form>\n                                    </div>\n                                    ";
} else {
    $Token = generate_token("form");
    echo "                                    <div id=\"login\">\n                                        <form action=\"\" method=\"post\" name=\"frmlogin\" id=\"frmlogin\" autocomplete=\"off\"\n                                              spellcheck=\"false\"\n                                              autocorrect=\"off\" autocapitalize=\"off\">\n                                            ";
    echo $Token;
    echo "\n\n                                            ";
    if ($checkotp) {
        echo "\n                                                <input value=\"\" placeholder=\"Enter OTP\" type=\"password\" name=\"otp\"\n                                                       size=\"30\"/></td>\n                                                <input type=\"hidden\" value=\"";
        echo $_SESSION["tmp_u"];
        echo "\" name=\"username\"\n                                                       size=\"30\"\n                                                       class=\"username\"/>\n                                                <input type=\"hidden\" value=\"";
        echo $_SESSION["tmp_p"];
        echo "\" name=\"password\"\n                                                       size=\"30\"\n                                                       class=\"username\"/>\n\n                                                ";
    } else {
        echo "                                                <div class=\"form-group\">\n                                                    <label>Username</label>\n                                                    <input type=\"text\" placeholder=\"Username\" autocomplete=\"off\"\n                                                           class=\"form-control\"\n                                                           id=\"username\" autocomplete=\"off\" value=\"\" tabindex=\"1\"\n                                                           value=\"";
        echo $_COOKIE["FUSION_ADM"];
        echo "\" name=\"username\"\n                                                           size=\"30\"\n                                                    />\n                                                </div>\n                                                <div class=\"form-group\">\n                                                    <label>Password</label>\n                                                    <input type=\"password\" autocomplete=\"off\" tabindex=\"2\"\n                                                           placeholder=\"Password\"\n                                                           autocomplete=\"off\"\n                                                           name=\"password\" size=\"30\" value=\"\"\n                                                           class=\"form-control\"/>\n\n                                                    <div align=\"right\"><a href=\"index.php?action=remind\"\n                                                                          tabindex=\"4\">";
        echo $LNG["forgotpass"];
        echo "</a>\n                                                    </div>\n\n                                                </div>\n\n\n                                                ";
        include_once ROOTDIR . "/" . $admindirpath . "/includes/verifyadmin.php";
        $LoginCaptcha = createVerificationA("fa", "", ROOTDIR);
        echo "\n                                                ";
        $failedattempt = (int) $config["loginfailed"];
    }
    echo "\n                                            <div class=\"my-4\">\n\n                                                <div class=\"form-check\">\n                                                    <input class=\"form-check-input\" tabindex=\"5\" type=\"checkbox\"\n                                                           value=\"\" id=\"flexCheckDefault\" ";
    if (isset($_COOKIE["FUSION_ADM"])) {
        echo "checked";
    }
    echo ">\n                                                    <label class=\"form-check-label\" for=\"flexCheckDefault\">\n                                                        ";
    echo $LNG["remberme"];
    echo "                                                    </label>\n                                                </div>\n                                            </div>\n\n                                            <button type=\"submit\" tabindex=\"3\" class=\"btn btn-primary w-100\">\n                                                ";
    echo $LNG["login"];
    echo "                                            </button>\n\n                                        </form>\n\n                                    </div>\n\n                                    ";
}
echo "                                <script>\n                                    \$('input').attr({'autocomplete': 'off'});\n                                </script>\n                                ";
echo "\n                            </div>\n                        </div>\n                    </div>\n\n\n                </div>\n            </div>\n        </div>\n    </div>\n\n</div>\n\n\n</body>\n</html>\n";
class indexxx
{
}
function PassGen()
{
    $length = 8;
    $characters = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    $string = "";
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

?>
