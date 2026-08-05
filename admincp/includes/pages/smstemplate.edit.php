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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save && $message) {
    checkDemoMode(false);
    if ($files != "English") {
        $el = dquery("select id from tbl_smstemplate_language where template_id='" . $id . "'\n        and language='" . $files . "'");
        if (mysqli_num_rows($el)) {
            $dat["message"] = $message;
            $db->update("tbl_smstemplate_language", $dat, "template_id='" . $id . "' and language='" . $files . "'");
            $dat = NULL;
        } else {
            $dat["language"] = $files;
            $dat["template_id"] = $id;
            $dat["message"] = $message;
            $db->insert("tbl_smstemplate_language", $dat);
            $dat = NULL;
        }
    } else {
        if ($message) {
            $data["message"] = $message;
        }
    }
    $data["status"] = $status;
    $db->update("tbl_smstemplate", $data, "id='" . $id . "'");
    $data = NULL;
    echo "<div id='notification1' class='successbox'>" . $LNG["templateupdate"] . "</div>";
}
$templatedetail = mysqli_fetch_assoc(dquery("select * from tbl_smstemplate where id='" . $id . "'"));
echo " \n\n<script>\nfunction translator(lang){\n     \$(\"#main_loader\").show();\n   \$.post(\"includes/pages/smstemplate.lang.php\", {language: lang,id: ";
echo $id;
echo "},\n        function(data){\n        if(data){\n                document.getElementById('message').innerHTML=data;\n        }else{\n            alert(\"Translation Failed !\");\n        }\n         \$(\"#main_loader\").hide();\n      \n   });\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<ul id=\"tabmenu\"> \n";
$handle = opendir("../" . $languagedirectorypath);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && $file != "") {
        $file = explode(".", $file);
        if ($file[0] && $file[1] == "txt") {
            echo "<li><a href=\"javascript: redirectedit('smstemplate.edit','";
            echo $id;
            echo "&oid=";
            echo $oid;
            echo "&files=";
            echo $file[0];
            echo "');\"\n id=\"tab1\" ";
            if ($file[0] == $files) {
                echo "class='tabmenu_active'";
            } else {
                if ($file[0] == "English" && $files == "") {
                    echo "class='tabmenu_active'";
                }
            }
            echo ">";
            echo $file[0];
            echo "</a></li>\n ";
        }
    }
}
echo "<div style=\"clear: both;\"></div>\n</ul>\n";
if ($files != "English" && $files != "") {
    $ds = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_smstemplate_language`\n    WHERE `template_id`='" . $id . "' and language='" . $files . "'"));
    $templatedetail["message"] = $ds["message"];
}
echo "<div id=\"content_padded\"> \n<form method=\"post\" name=\"frmeditemailtemplate\" id=\"frmeditemailtemplate\">\n    ";
echo generate_token("form");
echo "  \n    <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n    <input type=\"hidden\" name=\"files\" value=\"";
echo $files != "" ? $files : "English";
echo "\" />\n    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\"> ";
echo $templatedetail["name"];
echo "</td></tr>\n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n<input type=\"radio\" name=\"status\" value=\"1\" id='se' ";
if ($templatedetail["status"]) {
    echo "checked";
}
echo " /><label for='se'>";
echo $LNG["enable"];
echo "</label>\n<input type=\"radio\" name=\"status\" value=\"0\" id='sd' ";
if (!$templatedetail["status"]) {
    echo "checked";
}
echo "  /><label for='sd'>";
echo $LNG["disable"];
echo "</label>\n    </td></tr>\n        \n    <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["message"];
echo "</td>\n    <td class=\"fieldarea\">\n<textarea cols=\"45\" name=\"message\" id=\"message\" rows=\"4\" >";
echo $templatedetail["message"];
echo "</textarea>\n<span style=\"float: right;\">\n  ";
if ($config["googlelanguageapi"]) {
    echo " \n    \n<input style=\"float: right; right: 5px !important; margin: 0 !important;  \" type=\"button\" name=\"google\" onclick=\"translator('";
    echo $files;
    echo "');\" \nvalue=\"";
    echo $LNG["translate"];
    echo " ";
    echo $LNG["from"];
    echo " ";
    echo $LNG["google"];
    echo "\" />\n      ";
}
echo "</span>\n    </td></tr>\n    <tr>\n        <td></td>\n        <td class=\"fieldarea\"><input type='submit' name='save' class=\"btn save\" value=\"";
echo $LNG["save"];
echo "\" /></td>\n    </tr>\n    </tbody>\n</table>\n<p align='center'></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>