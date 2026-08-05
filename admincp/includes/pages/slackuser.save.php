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
$flagur = false;
if (strpos($config["site_address"], "https") !== false) {
    $flagur = true;
}
if (!$config["config_ssl_allow"] && !$flagur) {
    echo "error: Site SSL link required";
    exit;
}
if ($_POST["slack_usernotification"]) {
    $_POST["slack_usernotification"] = 1;
    $ULR = "https://api.telegram.org/bot" . $config["slacktokenuser"] . "/deleteWebhook";
    telegramCurl($ULR);
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $ULR = "https://api.telegram.org/bot" . $config["slacktokenuser"] . "/setWebhook?url=" . urlencode($siteaddress . "/api/index3.php?telegramtoken=" . md5($config["slacktokenuser"]));
    $return = telegramCurl($ULR);
    $return = json_decode($return, true);
    if ($return["ok"] && !$config["slack_usernotification"]) {
        echo "success: User side notification activated";
    }
} else {
    $_POST["slack_usernotification"] = 0;
}
if (!$config["slacktokenuser"]) {
    $_POST["slack_usernotification"] = 0;
}
foreach ($_POST as $key => $v) {
    saveSettings($key, $v);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>