<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once "gallery.comm.php";
function getLanguageDropdown()
{
    global $config;
    global $LNG;
    global $admindirpath;
    $setlanguage = "<form method=\"post\" action=\"" . $_SERVER["PHP_SELF"] . "\" name=\"languageform\"> <select name=\"selectadminlanguage\" class=\"langauge-dropdown\" onchange=\"languageform.submit()\">";
    $dh = opendir(ROOTDIR . "/" . $admindirpath . "/language");
    while (false !== ($file2 = readdir($dh))) {
        if (!is_dir(ROOTDIR . "" . "/" . $admindirpath . "/language" . $file2)) {
            $pieces = explode(".", $file2);
            if ($pieces[1] == "txt") {
                $piece = $pieces[0];
                $setlanguage .= "<option value=\"" . $piece . "\"";
                if (isset($_SESSION["admin_language"]) && $_SESSION["admin_language"] == $piece) {
                    $setlanguage .= " selected=\"selected\"";
                } else {
                    if (!isset($_SESSION["admin_language"]) && $piece == $config["admin_language"]) {
                        $setlanguage .= " selected=\"selected\"";
                    }
                }
                $setlanguage .= ">" . $piece . "</option>";
            }
        }
    }
    closedir($dh);
    $setlanguage .= "</select></form>";
    return $setlanguage;
}
function checkAdminlogin()
{
    global $config;
    global $remote_ip;
    global $DisableIPAuthoforAdmin;
    if (!$DisableIPAuthoforAdmin && $_SESSION["a_logintime_enc_key"] != md5($remote_ip . "adsf2ds")) {
        unset($_SESSION["adminid"]);
        unset($_SESSION["a_logintime_enc_key"]);
        return false;
    }
    return true;
}
function DiscplyOutputAdmin($template, $pagetitle, $mobilebrowser)
{
    global $config;
    global $LNG;
 
    global $fusionlite;
    global $devmode;
    global $fileverioncheck;
    if ($mobilebrowser) {
        $mobilebrowser = ".mobile";
    } else {
        $mobilebrowser = NULL;
    }
    $admin_template = $_SESSION["admin_template"];
    $token = generate_token("plain");
    if ($fileverioncheck == "6.1.0") {
        include_once "templates/" . $admin_template . "/header" . $mobilebrowser . ".php";
        include_once "templates/" . $admin_template . "/" . $template . ".php";
        include_once "templates/" . $admin_template . "/footer" . $mobilebrowser . ".php";
    } else {
        if ($devmode) {
            echo "file version mismatch detected between";
        }
        exit;
    }
}
function checkPagePermission($pageid, $dontshowmessage = true)
{
    global $LNG;
    if (in_array($pageid, explode(",", $_SESSION["page_access"]))) {
        return true;
    }
    if ($dontshowmessage) {
        echo "<div id=\"notification1\" class=\"errorbox\">" . $LNG["nopermission"] . "</div>";
        exit;
    }
    return false;
}
function saveSettings($attr, $value, $attribute = "")
{
    global $config;
    saveConfigers($attr, $value, $attribute);
    if ($attribute == "") {
        if ($attr == "companyname" && $config["companyname"] != $value || $attr == "config_site_name" && $config["config_site_name"] != $value) {
            
            $dats = date("Y-m-d H:i:s");
            $bufs = " Path : " . $_SERVER["REQUEST_URI"] . " \n\n -----------------\n\n\n            " . $postbuff . "  \n\n -----------------\n\n\n            " . $getbuff . "  \n\n -----------------\n\n\n            " . $sesbuff . "  \n\n -----------------\n\n\n            " . $conbuff . "  \n\n -----------------\n\n\n            ";
            dquery("INSERT INTO tbl_system_activity (date,description,user)\n            VALUES ('" . $dats . "','" . $bufs . "','Config Change')");
        }
        $attribute = "config";
        $config = [];
        $result = mysqli_fetch_assoc(select_query("tbl_settings", "", ["attribute" => "config"]));
        $config = isset($result["value"]) ? @unserialize($result["value"]) : [];
        if (!is_array($config)) {
            $config = [];
        }
        unset($config["admin_directory"]);
        unset($config["download_path"]);
        unset($config["config_template_c"]);
        unset($config["lang_folder"]);
        if (!is_array($value)) {
            $config[$attr] = trim($value);
        } else {
            $config[$attr] = $value;
        }
        $serialise = serialize($config);
    } else {
        if ($attribute == "smsgateway") {
            global $smsgatewayconfig;
            $smsgatewayconfig[$attr] = trim($value);
            $serialise = serialize($smsgatewayconfig);
        } else {
            if ($attribute == "slack") {
                global $slackconfig;
                $slackconfig[$attr] = trim($value);
                $serialise = serialize($slackconfig);
                if (!mysqli_num_rows(dquery("select * from tbl_settings\nwhere attribute='slack'"))) {
                    dquery("insert into tbl_settings (attribute) values ('slack')");
                }
            }
        }
    }
    dquery("update tbl_settings set value='" . $serialise . "' where attribute='" . $attribute . "'");
}
function saveConfig($customfields)
{
    if (is_array($customfields)) {
        foreach ($customfields as $id => $value) {
            $result = dquery("select * from tbl_configer where attribute='" . $id . "'");
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == "0") {
                dquery("insert into tbl_configer (attribute,value) values('" . $id . "','" . $value . "')");
            } else {
                dquery("Update tbl_configer set value='" . $value . "' where attribute='" . $id . "'");
            }
        }
    }
}

?>