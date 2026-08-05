<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($languagedirectorypath != $lang_folder) {
    rename("../../" . $languagedirectorypath, "../../" . $lang_folder);
}
if ($config["config_template_c"] != $config_template_c) {
    rename("../../" . $config["config_template_c"], "../../" . $config_template_c);
}
if ($config["download_path"] != $download_path) {
    rename("../../" . $config["download_path"], "../../" . $download_path);
}
if ($_POST["masterpin"]) {
    $_POST["masterpin"] = 1;
} else {
    $_POST["masterpin"] = 0;
}
if ($_POST["securityemails"]) {
    $_POST["securityemails"] = 1;
} else {
    $_POST["securityemails"] = 0;
}
if ($_POST["userapiip"]) {
    $_POST["userapiip"] = 1;
} else {
    $_POST["userapiip"] = 0;
}
if ($_POST["captcha_login"]) {
    $_POST["captcha_login"] = 1;
} else {
    $_POST["captcha_login"] = 0;
}
if ($_POST["sendcountrymail"]) {
    $_POST["sendcountrymail"] = 1;
} else {
    $_POST["sendcountrymail"] = 0;
}
if ($_POST["usertmppassword"]) {
    $_POST["usertmppassword"] = 1;
} else {
    $_POST["usertmppassword"] = 0;
}
if ($_POST["adminblocknotice"]) {
    $_POST["adminblocknotice"] = 1;
} else {
    $_POST["adminblocknotice"] = 0;
}
if ($_POST["block_ac_on_country_mismatch"]) {
    $_POST["block_ac_on_country_mismatch"] = 1;
} else {
    $_POST["block_ac_on_country_mismatch"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
if ($allowed) {
    $allowed = trim($allowed);
    if (file_exists("../.htaccess")) {
        $fh = fopen("../.htaccess", "r");
        $theData = fread($fh, filesize("../.htaccess"));
        fclose($fh);
        if (stripos($theData, "Order Deny,Allow\nDeny from all\nAllow from") !== false) {
            $file = file("../.htaccess");
            $buff = "";
            foreach ($file as $f) {
                if (stripos($f, "Allow from") !== false) {
                    $buff .= "Allow from " . $allowed;
                } else {
                    $buff .= "\n" . $f;
                }
            }
            $fh = fopen("../.htaccess", "w");
            fwrite($fh, $buff);
            fclose($fh);
        } else {
            $fh = fopen("../.htaccess", "a");
            $stringData = "\nOrder Deny,Allow\nDeny from all\nAllow from {IP}";
            $stringData = str_replace("{IP}", $allowed, $stringData);
            fwrite($fh, $stringData);
            fclose($fh);
        }
    } else {
        $Data = "Order Deny,Allow\nDeny from all\nAllow from {IP}";
        $Data = str_replace("{IP}", $allowed, $Data);
        $fh = fopen("../.htaccess", "w");
        fwrite($fh, $Data);
        fclose($fh);
    }
}
include_once "../includes/fun.inc.php";
saveConfig($configcustom);
echo "success:" . $LNG["datasavesuccessfully"];

?>