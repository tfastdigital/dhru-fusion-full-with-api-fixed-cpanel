<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace changelic;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
require "includes/fun.inc.php";
require "../includes/fun.inc.php";
require "includes/comm.inc.php";
$msg = nl2br($msg);
if ($results["addons"]) {
    $addons = $results["addons"];
}
if ($debug_output) {
    echo "<textarea cols=100 rows=20>";
    print_r($results);
    echo "</textarea>";
}
if (isset($_GET)) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = preg_replace("/[^a-z^A-Z^0-9s|^.^,^=^@^_^#^-^\\-^\\?^\\&^\\ ^\\/^\\r^\\n]*/", "", $value);
    }
}
if ($_GET["key"] == "true") {
    dquery("UPDATE `tbl_license` SET `license_key`=''");
    echo "key is udpated now !";
    exit;
}
$licensekey = str_replace("-", "", $licensekey);
$licensekey = trim($licensekey);
if ($username || $password || $licensekey) {
    if (check_token()) {
        $loginsuccess = false;
        $username = trim($username);
        $password = trim($password);
        $err_output = NULL;
        if ($username) {
            if ($password) {
                $username = descape($username);
                $password = descape($password);
                $password = md5(md5($password) . "9486");
                $result = dquery("SELECT tbl_admin.*,tbl_admin_access_group.access FROM `tbl_admin`,`tbl_admin_access_group` WHERE `username`='" . $username . "' and `password`='" . $password . "' and `status`='0' and tbl_admin.group_id=tbl_admin_access_group.id");
                $data = mysqli_fetch_assoc($result);
                if ($data) {
                    $results = mainChd19k521($licensekey, "", true);
                    if ($debug_output) {
                        echo "<textarea cols=100 rows=20>";
                        print_r($results);
                        echo "</textarea>";
                    }
                    if ($results["status"] == "Active") {
                        $licensekey = enc($licensekey);
                        dquery("UPDATE `tbl_license` SET `license_key`='" . $licensekey . "'");
                        echo "<br /><br /><br /><br /><br /><br /><div align=\"center\">License key update successful <a href=\"index.php\">Click Here to login </a></div><br /><br /><br /><br />";
                        exit;
                    }
                    $msg = "Your license key is " . $results["status"] . " ";
                    $errorid = "";
                } else {
                    echo " <script> alert('";
                    echo $LNG["invaliduserpass"];
                    echo "');</script>  ";
                }
            } else {
                echo " <script> alert('";
                echo $LNG["passreq"];
                echo "');</script>  ";
            }
        } else {
            echo " <script> alert('";
            echo $LNG["usernamereq"];
            echo "');</script>  ";
        }
    } else {
        echo " <script> alert('";
        echo $LNG["invalidtoken"];
        echo "');</script>  ";
    }
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>Dhru Fusion | License</title>\n\n<script src=\"includes/js/jquery.js\" type=\"text/javascript\"></script>\n<style type=\"text/css\">\n\nbody {\n    color: #333333;\n    font-family: arial;\n    font-size: 11px;\n    padding-top: 200px;\n}\nbody {\n    background-color: white;\n    margin: 0;\n}\na, a:visited {\n    color: #50A355;\n    text-decoration: none;\n}\na:hover {\n    text-decoration: none;\n}\nform {\n    margin: 0;\n    padding: 0;\n}\ntd strong {\n    color: #888888;\n}\n.groupstabes {\n    border-radius: 0 0 0 0;\n    margin-bottom: 5px;\n}\n.groupstabescontant {\n}\n.groupstabes h2 {\n    background: none repeat scroll 0 0 #FAFAFA;\n    border-bottom: 1px solid #EEEEEE;\n    border-radius: 5px 5px 0 0;\n    color: black;\n    font-size: 16px;\n    font-weight: normal;\n    margin-top: 0;\n    padding: 10px;\n}\n.groupstabescontant table td, .form td {\n    padding: 7px 0;\n}\n.groupstabescontant table tr:hover td small, .form tr:hover td small, .form tr:hover td a {\n    color: black;\n}\n.groupstabescontant table tr:last-child td, .form tr:last-child td {\n    border-bottom: medium none;\n}\ninput[type=\"text\"], input[type=\"password\"] {\n    border: 1px solid #DDDDDD;\n    color: #575757;\n    font-family: arial;\n    outline: 0 none;\n    padding: 15px 4%;\n    width: 92%;\n}\ninput[type=\"text\"]:focus, select:focus, input[type=\"password\"]:focus, textarea:focus {\n    border: 1px solid #C9C9C9;\n}\ninput[type=\"text\"]:hover, select:hover, textarea:hover, input[type=\"password\"]:hover {\n    border: 1px solid #BBBABA;\n}\ninput[type=\"checkbox\"] {\n    vertical-align: middle;\n}\n.btn-primary, input.button_save, input.greenclass {\n    background: url(\"images/button_save1.png\") repeat scroll center center #50a355 !important;\n    border: 1px solid #50A355 !important;\n    color: white !important;\n}\n.add {\n    background: url(\"images/button_gallery_bg.png\") repeat scroll center center #50a355 !important;\n    border: 1px solid #0667B6 !important;\n    color: white !important;\n    text-shadow: 0 -1px 0 #3B7506;\n}\ninput.button_save, .btn.active, .btn.save, .submit {\n    background: url(\"images/button_save1.png\") repeat-x scroll center center #50a355 !important;\n    border: 1px solid #50A355 !important;\n    border-radius: 3px 3px 3px 3px;\n    color: white !important;\n    font-size: 14px;\n    padding: 3px 10px;\n    text-shadow: 0 -1px 0 #3B7506;\n}\n#login_container {\n    background: none repeat scroll 0 0 white;\n    border-radius: 10px 10px 10px 10px;\n    margin: 20px auto 10px;\n    text-align: left;\n    width: 330px;\n}\n#logo {\n    margin: 0;\n    padding: 50px 0 0;\n    text-align: center;\n}\n#login_container #login {\n    padding: 0 20px;\n    text-align: left;\n}\n#login_container #login_failed {\n    background-color: #FCF9D2;\n    margin: 0 0 1px;\n    padding: 10px;\n    text-align: center;\n}\n#extra_info {\n    background-color: white;\n    font-size: 13px;\n    margin-top: 20px;\n    text-align: left;\n}\n.username {\n    background: url(\"images/login_username.png\") no-repeat scroll right center white;\n    border-radius: 10px 10px 0 0;\n}\n.passwordd, .passwordo {\n    background: url(\"images/login_password.png\") no-repeat scroll right center white;       \n}\n.checkbox input[type=\"checkbox\"], .radio input[type=\"radio\"] {\n    margin: 0 0 5px;\n    opacity: 0;\n    position: absolute;\n    z-index: -9999;\n}\n.checkbox label, .radio label {\n    cursor: pointer;\n    height: 17px;\n    line-height: 17px;\n    margin-left: -5px;\n    margin-right: 10px;\n    padding: 7px 0 6px 25px;\n    z-index: 1;\n}\n.checkbox input[type=\"checkbox\"]:checked + label, .radio input[type=\"radio\"]:checked + label {\n    background-position: -14px -214px;\n}\n.checkbox label, .radio label {\n    background-position: -14px -14px;\n}\n.checkbox label:hover, .radio label:hover, .checkbox label:focus, .radio label:focus {\n    background-position: -14px -114px;\n}\n.checkbox label {\n    background: url(\"images/checkbox.png\") no-repeat scroll -14px -14px transparent;\n}\n\n</style>\n<script language=\"javascript\">\n\$(document).ready(function(){      \n   \$('.passwordd').focus(function(){\n        \$(this).hide();\n        \$('.passwordo').show();\n        document.frmlogin.password.focus();\n   }); \n   \n   \$('.passwordo').blur(function(){\n        if(\$(this).val()==''){\n            \$('.passwordd').show();\n            \$('.passwordo').hide();            \n        }\n   });\n});\n \nfunction sf(){ document.frmlogin.username.focus(); }\n</script>\n\n</head>\n<body onload=\"sf()\" >\n\n\n\n\t<div style=\"margin: auto;\"  align=\"center\">\n\n            \n<img title=\"Dhru Fusion by dhru.com\"  src=\"data:image/jpg;base64,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\"/>\n\n\n\t</div>\n\n\n<div id=\"login_container\">\n      \n";
if ($msg) {
    echo "                      <div id=\"\" class=\"msg\" style=\"background: #F4F4F4;padding:13px;\"> \n                        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >\n                        <tr>\n                            <td align=\"center\" style=\"font-size: 14px;\">\n";
    if ($errorid == "1") {
        echo "You neeed to reissue your license from the dhru.com CustomerHub. <a href=\"http://dhru.com/images/help/reissue-license.jpg\" target=\"_blank\">Click here to Help?</a>";
    } else {
        if ($errorid != "2") {
            echo $msg;
        }
    }
    echo "  </td>\n                        </tr>\n                        </table>\n                      </div>\n                      \n  \n              ";
}
echo "  \n  \n\n  <div id=\"login\">\n    <form action=\"\" method=\"post\" name=\"frmlogin\" id=\"frmlogin\">\n ";
echo generate_token("form");
echo "<input type=\"text\" value=\"";
echo $LNG["username"];
echo "\" onfocus=\"if (this.value =='";
echo $LNG["username"];
echo "') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '";
echo $LNG["username"];
echo "';}\"  name=\"username\" size=\"30\" class=\"username\"/>\n\n    <input type=\"text\" value=\"";
echo $LNG["password"];
echo "\" onfocus=\"if(this.value =='";
echo $LNG["password"];
echo "') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '";
echo $LNG["password"];
echo "';}\"  name=\"passwordd\" size=\"30\" class=\"passwordd\"/>\n     <input type=\"password\"  name=\"password\" size=\"30\" class=\"passwordo\" style=\"display: none;\" />\n    \n    <input style=\"border-radius: 0 0 10px 10px;\" type=\"text\" value=\"";
echo $LNG["licensekey"];
echo "\" onfocus=\"if (this.value =='";
echo $LNG["licensekey"];
echo "') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '";
echo $LNG["licensekey"];
echo "';}\"  name=\"licensekey\" size=\"30\" class=\"licensekey\"/> \n     <div align=\"center\"> <a target=\"_blank\" href=\"http://kb.dhru.com/Dhru_Fusion/Customer_Hub/How_to_get_license_key\">How to get license key?</a> <br /><br /> <input type=\"submit\" value=\"Update Key\" class=\"btn save\"/> </div>           \n    </form>\n  </div> \n</div>\n\n\n</body></html>";
class changelic
{
}

?>