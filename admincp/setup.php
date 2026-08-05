<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace setup;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../comm.php";
if ($storeowner["id"]) {
    exit;
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<title>Dhru Fusion | Setup </title>\n\n<style type=\"text/css\"> \n<!--\n\nbody, td, th {\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\n\tfont-size: 12px;\n\tcolor: #888;\n}\nbody {\n\tbackground-color: #f9f9f9;\n\tmargin: 0;\n}\na, a:visited {\n\tcolor: #000066;\n\ttext-decoration: underline;\n}\na:hover {\n\ttext-decoration: none;\n}\nform {\n\tmargin: 0;\n\tpadding: 0;\n}\ninput, select, textarea {\n\tfont-family: Tahoma, Arial, Helvetica, sans-serif;\n\tfont-size: 11px;\n\tpadding: 3px;\n}\nfieldset {\n\tcolor: #333;\n\tbackground-color: #FFF;\n\ttext-align: left;\n\twidth: 100%;\t\n\tmargin: 20px auto 10px auto;\n\tborder: 5px solid #dedede;\n    border-radius:4px;-moz-border-radius:4px;\t-webkit-border-radius:4px;  \n    box-shadow:0 0 5px #DDDDDD;\n    border:1px solid #DDDDDD; \n    padding:10px 10px 0 10px;\n}\n\n#logo {\n\ttext-align: center;\n\tmargin: 0;\n\tpadding: 50px 0 0 0;\n}\nfieldset #login {\n\tbackground-color: #FFF;\n\ttext-align: left;\n\tmargin: 0;\n\tpadding: 10px ;\n}\nfieldset p{background: #f4f4f4;padding:5px;border-top:2px solid #DDDDDD;margin:10px -10px 0;padding:10px} \nfieldset #login_failed {\n    background-color: #FCF9D2;\n    text-align: center;\n    padding: 10px;\n    margin: 0 0 1px 0;\n}\nfieldset #extra_info {\n\tbackground-color: #083b6e;\n\ttext-align: left;\n\tpadding: 10px;\n\tmargin: 1px 0 0 0;\n}\n\ninput.button_save, .btn.active, .btn.save, .submit {\n    background: url(\"images/button_save1.png\") repeat-x scroll center center transparent !important;\n    border: 1px solid #50A355 !important;\n    border-radius: 3px 3px 3px 3px;\n    color: white !important;\n    font-size: 14px;\n    padding: 3px 10px;\n    text-shadow: 0 -1px 0 #3B7506;\n}\n\nlegend{display: none;}\n\ninput[type=\"submit\"],input[type=\"button\"],.prev,.next{\n    \tbackground: url(\"images/bg-btn.gif\") repeat-x 0px 0px rgb(221, 221, 221); border-width: 1px; border-style: solid; border-color: rgb(187, 187, 187) rgb(187, 187, 187) rgb(153, 153, 153); font: 12px/15px Helvetica Neue, Arial, \"Lucida Grande\", Sans-serif; margin: 0px; padding: 5px 9px; color: rgb(51, 51, 51) !important; overflow: hidden; display: inline-block; cursor: pointer; font-size-adjust: none; font-stretch: normal; box-shadow: 0px 1px 0px #f8f8f8;\n        border-radius: 4px; -moz-border-radius:2px;\t-webkit-border-radius:2px;text-decoration: none;\n}\ninput[type=\"submit\"]:hover,input[type=\"button\"]:hover,.prev:hover,.next:hover{\n\tbackground-position: 0px -6px; border-color: rgb(153, 153, 153) rgb(153, 153, 153) rgb(102, 102, 102); color: rgb(0, 0, 0); text-decoration: none;\n}\ninput[type=\"text\"],input[type=\"password\"],select,textarea{border: #DDD solid 1px;padding: 7px;}\ninput[type=\"text\"]:focus,input[type=\"password\"]:focus,select:focus{box-shadow: 0 0 8px #DDDDDD;}\ninput[type=\"text\"]:hover,input[type=\"password\"]:hover,select:hover,textarea:hover{border: #BBBABA solid 1px;}\n\n\n.prev:hover, .next:hover { background-color: black;  text-decoration:none;}\n.prev { float:left;}\n.next { float:right;}\n#steps { list-style:none; width:750px; overflow:hidden; margin:0px; padding:0px; text-align: center;margin-bottom: 20px;}\n#steps li {font-size:24px; padding:10px; color:#b0b1b3;display: inline-block;}\n#steps li span {font-size:11px; display:block;}\n#steps li.current { color:#000;}\n#makeWizard { background-color:#b0232a; color:#fff; padding:5px 10px; text-decoration:none; font-size:18px;}\n#makeWizard:hover { background-color:#000;}\n\n#notification {\n    border-radius: 2px 2px 2px 2px;\n    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;\n    cursor: pointer;\n    font-size: 12px;\n    margin: auto;\n    padding: 10px;\n    text-align: center;\n    width: 700px;\n}\n#notification li{list-style: none;}\n.errorbox {\n    background-color: #FAE2E2;\n    background-image: -moz-linear-gradient(#FFCDD1, #ECBCC0);\n    border: 1px solid #EEB7BA;\n    color: #BE4741;\n    text-shadow: 0 1px 1px #FFFFFF;\n}\n\n\nfieldset{border: none;}\n#step2Prev,#step3Prev{float: none;}\n\n-->\n</style>\n</head>\n<body>\n\n\n<br /><br /><br /><br /><br /><br /><br /><br /><br />\n";
require "includes/fun.inc.php";
require "../includes/fun.inc.php";
require "includes/comm.inc.php";
$admn = mysqli_num_rows(dquery("select * from tbl_admin"));
if ($admn && !isset($_SESSION["adminid"])) {
    echo "<script>location.href='index.php';</script> ";
}
$flag = true;
echo " \n\n     <script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js\"></script>\n    <script type=\"text/javascript\">\n        \$(document).ready(function(){\n            \$(\"#frm\").formToWizard({ submitButton: 'SaveAccount' })\n        });\n    </script>\n\n<script>\nfunction showsmtp(val) \n{\n    if(val=='php')\n    {\n        document.getElementById('smtp[0]').style.display='none';\n        document.getElementById('smtp[1]').style.display='none';\n        document.getElementById('smtp[2]').style.display='none';\n        document.getElementById('smtp[3]').style.display='none';\n        document.getElementById('smtp[4]').style.display='none';\n    }else{\n        document.getElementById('smtp[0]').style.display='';\n        document.getElementById('smtp[1]').style.display='';\n        document.getElementById('smtp[2]').style.display='';\n        document.getElementById('smtp[3]').style.display='';\n        document.getElementById('smtp[4]').style.display='';        \n    }\n}\nfunction validate(Ob){\n    \n    if(document.getElementById('path').value=='' || document.getElementById('path').value=='Admin' || document.getElementById('path').value=='admin'){\n        alert(\"Admin directory Path should not be common name or blank\");\n        return false;\n    }\n\tvar numericExpression = /^([a-zA-Z0-9_-]+)\$/;\n\tif(!document.getElementById('path').value.match(numericExpression)){\n\n\t\talert(\"Directory Name should not contain special character\");\n\t\treturn false;\n\t}\n\tif(!document.getElementById('download').value.match(numericExpression)){\n\n\t\talert(\"Directory Name should not contain special character\");\n\t\treturn false;\n\t}    \n     var nm;\nfor(i=1;i<Ob.length;i++){\n   \n    if(Ob[i].name!='undefine'){\n        if(!isNotEmpty(Ob[i].value)){\n            return false;\n        }\n    }\n}\n}\nfunction isNotEmpty(elem) {\n  var str = elem;\n    var re = /.+/;\n    if(!str.match(re)) {\n        alert(\"Please fill in the required field.\");\n        return false;\n    } else {\n        return true;\n    }\n}\n\n</script>   \n\n<div align=\"center\">\n \n<div id=\"content\">\n<div id=\"content_padded\">\n<div align=\"center\"> \n  <form id=\"frm\" style=\"width: 750px;\" method=\"post\">\n";
if (!$admn) {
    echo "       <fieldset>\n            <legend>Administrator Account</legend>\n            ";
    $msg = "";
    if ($saveall) {
        if ($path == "Admin" || $path == "admin") {
            $msg .= "<li>Admin Directory name should not common name</li>";
            $flag = false;
        }
        if (preg_match("/[^0-9a-zA-Z\\/]\$/", $path)) {
            $msg .= "<li>Admin Directory name should not contain special character</li>";
            $flag = false;
        }
        if (10 < strlen($path)) {
            $msg .= "<li>Admin Directory name should not more than 10 character</li>";
            $flag = false;
        }
        foreach ($_POST as $val) {
            if ($val == "") {
                $msg .= "<li>Field should not blank</li>";
                $flag = false;
                if (preg_match("/[^0-9a-zA-Z]\$/", $path) || preg_match("/[^0-9a-zA-Z]\$/", $download)) {
                    $msg .= "<li>Directory name should not contain special character</li>";
                    $flag = false;
                }
                if ($msg) {
                    echo "<div id='notification' class='errorbox'>" . $msg . "</div><br>";
                }
            }
        }
    }
    echo "            <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n            <tbody>\n            <tr><td width=\"35%\"><span>Administrator Username</span></td><td><input type=\"text\" name=\"username\" value=\"";
    if ($username) {
        echo $username;
    }
    echo "\" /></td></tr>\n            <tr><td><span>Administrator Password</span></td><td><input type=\"password\" name=\"password\" /></td></tr>\n            <tr><td><span>First Name</span></td><td><input type=\"text\" name=\"firstname\" value=\"";
    if ($firstname) {
        echo $firstname;
    }
    echo "\" /></td></tr>\n            <tr><td><span>Last Name</span></td><td><input type=\"text\" name=\"lastname\" value=\"";
    if ($lastname) {
        echo $lastname;
    }
    echo "\" /></td></tr>\n            <tr><td><span>Email</span></td><td><input type=\"text\" name=\"email\" value=\"";
    if ($email) {
        echo $email;
    }
    echo "\" /></td></tr>\n       \n                <input type=\"hidden\" name=\"admin_template\" value=\"default\" />   \n            \n            </tbody>\n            </table>\n            \n      </fieldset>\n    \n";
}
echo "  \n        <fieldset>\n            <legend>General Site Settings</legend>\n            <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n            <tbody>\n            <tr><td width=\"35%\"><span>Company Name</span></td><td><input type=\"text\" name=\"companyname\" value=\"";
if ($companyname) {
    echo $companyname;
} else {
    echo $config["companyname"];
}
echo "\" /></td></tr>\n            <tr><td><span>Site Link</span></td><td><input type=\"text\" name=\"site_address\" value=\"";
if ($site_address) {
    echo $site_address;
} else {
    echo $config["site_address"];
}
echo "\" /></td></tr>\n            <tr><td><span>ContactUs E-mail</span></td><td><input type=\"text\" name=\"contactus_mail\" value=\"";
if ($contactus_mail) {
    echo $contactus_mail;
} else {
    echo $config["contactus_mail"];
}
echo "\" /></td></tr>\n            <tr><td><span>Default Country</span></td><td>";
echo getCountriesDropDown($config["DefaultCountry"]);
echo "</td></tr>\n            <tr><td><span>Time Zone</span></td><td>\n            <select name=\"time_zone\">\n";
$sql = dquery("SELECT * FROM `tbl_timezone_1`");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <option value=\"";
    echo $row["Time_zone_id"];
    echo "\" ";
    if ($row["Time_zone_id"] == $config["time_zone"]) {
        echo "selected";
    }
    echo " >";
    echo $row["Name"];
    echo "</option>\n    ";
}
echo "    </select>\n</td></tr>\n            <tr><td><span>Character Set</span></td><td><input type=\"text\" name=\"charset\" value=\"";
if ($charset) {
    echo $charset;
} else {
    echo $config["charset"];
}
echo "\" /></td></tr>\n            <tr><td><span>Front-end Language</span></td><td>";
echo getLanguageDropdown2($config["language"]);
echo "</td></tr>\n            <tr><td><span>Front-end Template</span></td><td>\n<select name=\"template\">\n";
$myDirectory = opendir(ROOTDIR . "/templates/");
while ($dir = readdir($myDirectory)) {
    if ($dir != "." && $dir != ".." && $dir != "") {
        echo "        <option value=\"";
        echo $dir;
        echo "\" ";
        if ($config["template"] == $dir) {
            echo "selected";
        }
        echo " >";
        echo $dir;
        echo "</option>\n        ";
    }
}
closedir($myDirectory);
echo "    \n</select>            \n             </td></tr>\n            <tr><td><span>Default Currency</span></td><td>\n            \n            <select name=\"base_currency\">\n";
$sql = dquery("SELECT * FROM `tbl_currencies`");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <option value=\"";
    echo $row["code"];
    echo "\" ";
    if ($row["code"] == $config["base_currency"]) {
        echo "selected";
    }
    echo "  >";
    echo $row["code"];
    echo "</option>\n    ";
}
echo "    </select>            \n            </td></tr>\n            </tbody>\n            </table>\n        </fieldset>\n        <fieldset>\n            <legend>Mail Performance</legend>\n            <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n            <tbody>\n            <tr><td><span>System Mail</span></td><td><input type=\"text\" name=\"config_admin_mail\" value=\"";
if ($config_admin_mail) {
    echo $config_admin_mail;
} else {
    echo $config["config_admin_mail"];
}
echo "\" /> </td></tr>\n            <tr><td><span>System From Name</span></td><td><input type=\"text\" name=\"config_admin_name\" value=\"";
if ($config_admin_name) {
    echo $config_admin_name;
} else {
    echo $config["config_admin_name"];
}
echo "\" /> </td></tr>\n            <tr><td><span>Admin Singature</span></td><td><textarea cols=\"45\" name=\"signature\" >";
if ($signature) {
    echo $signature;
} else {
    echo $config["adminsignature"];
}
echo "</textarea></td></tr>\n            <tr><td><span>Mail Type</span></td><td>\n     <select name=\"mailtype\" onChange=\"showsmtp(this.value)\">\n    <option value=\"smtp\" ";
if ($config["mail_type"] == "smtp") {
    echo "selected";
}
echo " >";
echo $LNG["smtp"];
echo "</option>\n    <option value=\"php\" ";
if ($config["mail_type"] == "php") {
    echo "selected";
}
echo " >";
echo $LNG["php"];
echo "</option>\n    </select>\n            </td></tr>\n            \n\n<tr id=\"smtp[0]\">\n    <td><span>SMTP Port</span></td>\n    <td>   <input type=\"text\" name=\"smtp_port\" id=\"taxtype\" value=\"";
if ($smtp_port) {
    echo $smtp_port;
} else {
    echo $config["smtp_port"];
}
echo "\"  />    </td>\n</tr>\n\n<tr id=\"smtp[1]\" >\n    <td><span>SMTP Host</span></td>\n    <td><input type=\"text\" name=\"smtp_host\" value=\"";
if ($smtp_host) {
    echo $smtp_host;
} else {
    echo $config["smtp_host"];
}
echo "\" /> <input type=\"checkbox\" ";
if ($config["smtp_enc"] == 1) {
    echo "checked";
}
echo " value=\"1\" name=\"smtp_enc\"  />SMTP Enc  </td>\n</tr>\n\n\n<tr id=\"smtp[2]\" >\n    <td ><span>SMTP Username</span></td>\n    <td ><input type=\"text\" name=\"smtp_username\" value=\"";
if ($smtp_username) {
    echo $smtp_username;
} else {
    echo $config["smtp_username"];
}
echo "\" /> </td>\n</tr>\n\n<tr id=\"smtp[3]\" >\n    <td><span>SMTP Password</span></td>\n    <td > <input type=\"text\" name=\"smtp_password\" value=\"";
if ($smtp_password) {
    echo $smtp_password;
} else {
    echo $config["smtp_password"];
}
echo "\"  />  </td>\n</tr>\n            \n           </tbody>\n            </table>\n        </fieldset>\n        <fieldset>\n            <legend>Security Settings</legend>\n            <table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n            <tbody>\n            <tr><td width=\"36%\"><span>Admin Directory</span></td>\n            <td width=\"64%\"><input type=\"text\" id=\"path\" name=\"path\" value=\"";
if ($path) {
    echo $path;
} else {
    echo $admindirpath;
}
echo "\" /> <br /> Change Your Admin Directory ( e.g. MyAccess , ADMIN99 etc )</td></tr> \n            <tr><td width=\"36%\"><span>Download Path</span></td>\n            <td width=\"64%\"><input type=\"text\" id=\"download\" name=\"download\" value=\"";
if ($download) {
    echo $download;
} else {
    echo $donloaddirpath;
}
echo "\" /> </td></tr>\n            \n            \n            <tr><td width=\"36%\"><span></span></td>\n            <td width=\"64%\"><input id=\"SaveAccount\" name=\"saveall\" type=\"submit\" value=\"Save Settings\" /> </td></tr>\n            \n                         \n            </tbody>  \n            </table> \n            \n        </fieldset>\n     \n       \n                  \n  </form></div>\n</div></div>\n\n\n\n</div>\n\n  <script>\n(function(\$) {\n    \$.fn.formToWizard = function(options) {\n        options = \$.extend({  \n            submitButton: \"\" \n        }, options); \n        \n        var element = this;\n\n        var steps = \$(element).find(\"fieldset\");\n        var count = steps.length;\n        var submmitButtonName = \"#\" + options.submitButton;\n        \$(submmitButtonName).hide();\n\n        // 2\n        \$(element).before(\"<ul id='steps'></ul>\");\n\n        steps.each(function(i) {\n            \$(this).wrap(\"<div id='step\" + i + \"'></div>\");\n            \$(this).append(\"<p id='step\" + i + \"commands'></p>\");\n\n            // 2\n            var name = \$(this).find(\"legend\").html();\n            \$(\"#steps\").append(\"<li id='stepDesc\" + i + \"'>Step \" + (i + 1) + \"<span>\" + name + \"</span></li>\");\n\n            if (i == 0) {\n                createNextButton(i);\n                selectStep(i);\n            }\n            else if (i == count - 1) {\n                \$(\"#step\" + i).hide();\n                createPrevButton(i);\n            }\n            else {\n                \$(\"#step\" + i).hide();\n                createPrevButton(i);\n                createNextButton(i);\n            }\n        });\n\n        function createPrevButton(i) {\n            var stepName = \"step\" + i;\n            \$(\"#\" + stepName + \"commands\").append(\"<a href='#' id='\" + stepName + \"Prev' class='prev btn active'>< Back</a>\");\n              // \$(\"#\" + stepName + \"commands\").append(\"<input type='button' id='\" + stepName + \"Prev' class='prev' value='< Back' />\");\n                \n            \$(\"#\" + stepName + \"Prev\").bind(\"click\", function(e) {\n                \$(\"#\" + stepName).hide();\n                \$(\"#step\" + (i - 1)).show();\n                \$(submmitButtonName).hide();\n                selectStep(i - 1);\n            });\n        }\n\n        function createNextButton(i) {\n            var stepName = \"step\" + i;\n            \$(\"#\" + stepName + \"commands\").append(\"<a href='#' id='\" + stepName + \"Next' class='next btn active'>Next ></a><div style='clear:both'></div>\");\n            //\$(\"#\" + stepName + \"commands\").append(\"<input type='button' id='\" + stepName + \"Next' value='Next >' class='next' />\");\n            \n            \$(\"#\" + stepName + \"Next\").bind(\"click\", function(e) {\n                \$(\"#\" + stepName).hide();\n                \$(\"#step\" + (i + 1)).show();\n                if (i + 2 == count)\n                    \$(submmitButtonName).show();\n                selectStep(i + 1);\n            });\n        }\n\n        function selectStep(i) {\n            \$(\"#steps li\").removeClass(\"current\");\n            \$(\"#stepDesc\" + i).addClass(\"current\");\n        }\n\n    }\n})(jQuery); \n  </script>\n";
if ($saveall && $flag) {
    if (!$admn) {
        $password = trim($password);
        $data["username"] = $username;
        $data["password"] = md5(md5($password) . "9486");
        $data["group_id"] = 1;
        $data["status"] = 0;
        $data["language"] = $admin_language;
        $data["template"] = $admin_template;
        $data["firstname"] = $firstname;
        $data["lastname"] = $lastname;
        $data["email"] = $email;
        $db->insert("tbl_admin", $data);
        $data = NULL;
    }
    if (is_file("../configs/config.php")) {
        $fh = fopen("../configs/config.php", "r");
        $buf = "";
        while (!feof($fh)) {
            $buf .= fgets($fh);
        }
        $buf = str_replace("#\$admindirpath=\"\";", "\$admindirpath=\"" . $path . "\";", $buf);
        fclose($fh);
        $fh = fopen("../configs/config.php", "w");
        fwrite($fh, $buf);
        fclose($fh);
    }
    rename("../" . $config["admin_directory"], "../" . $path);
    saveSettings("mail_type", trim($mailtype));
    saveSettings("adminsignature", trim($signature));
    saveSettings("config_admin_mail", trim($config_admin_mail));
    saveSettings("config_admin_name", trim($config_admin_name));
    if ($mailtype == "smtp") {
        saveSettings("smtp_port", trim($smtp_port));
        saveSettings("smtp_host", trim($smtp_host));
        saveSettings("smtp_username", trim($smtp_username));
        saveSettings("smtp_password", trim($smtp_password));
        saveSettings("smtp_enc", trim($smtp_enc));
    }
    saveSettings("companyname", trim($companyname));
    saveSettings("site_address", trim($site_address));
    saveSettings("contactus_mail", trim($contactus_mail));
    saveSettings("DefaultCountry", trim($country));
    saveSettings("charset", trim($charset));
    saveSettings("language", trim($language));
    saveSettings("time_zone", trim($time_zone));
    saveSettings("template", trim($template));
    saveSettings("base_currency", trim($base_currency));
    saveSettings("download_path", trim($download));
    rename("../" . $donloaddirpath, "../" . $download);
    $CHAR = md5(rand(0, 99));
    rename("setup.php", "setup_" . $CHAR . ".php");
    echo "<script> location.href='";
    echo $site_address;
    echo "'+'/'+'";
    echo $path;
    echo "'+'/index.php';</script> ";
}
echo "\n</body>\n</html>";
class setup
{
}

?>