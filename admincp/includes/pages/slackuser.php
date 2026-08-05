<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ((isset($_POST) || $removeslack) && $DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($savetele && $telegramtoken && !$removeslack) {
    if ($telegramtoken != $config["slacktoken"]) {
        saveSettings("slacktokenuser", trim($telegramtoken));
    } else {
        echo "        <div class=\"errorbox\" id=\"notification1\">Token should not same as Admin Bot</div>\r\n        ";
    }
}
if ($removeslack) {
    saveSettings("slacktokenuser", "");
    saveSettings("slack_usernotification", "");
    saveSettings("telegramuserbot", "");
    $config["slacktokenuser"] = "";
    $config["slack_usernotification"] = "";
}
if ($id && !$removeslack) {
    $decode = decrypt($id);
    if (stripos($decode, "xoxp") !== false && $decode != "") {
        saveSettings("slacktokenuser", $id);
        $config["slacktokenuser"] = $id;
    } else {
        saveSettings("slacktokenuser", "");
        $config["slacktokenuser"] = "";
        echo "        <div class=\"errorbox\" id=\"notification1\">Error Something Try again.</div>\r\n        ";
    }
}
echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n        ";
if (!$config["slacktokenuser"]) {
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $callbackurl = $siteaddress . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("slack&id=" . $invoiceid) . "&title=" . base64_encode("Slack Integration");
    $state = "";
    $tmp[l] = str_replace("-", "", $licinfo["license_key"]);
    $tmp[callback] = $callbackurl;
    $state = urlencode(encrypt(json_encode($tmp)));
    echo "    <form method=\"post\" action=\"main2.php?page=slack&loaddefault=slackuser.php\">\r\n        <table id=\"main_tbl\" style=\"width: 500px;\">\r\n            <tr>\r\n\r\n                <td>\r\n                    Telegram Bot Token : <input type=\"text\" name=\"telegramtoken\"/>\r\n                    <button class=\"btn\" name=\"savetele\" value=\"savetele\">Save</button>\r\n                    <br/>\r\n\r\n                    <a href=\"https://support.dhru.com/Dhru-Fusion/article/Telegram/?aid=45&cid=7&pid=1\" target=\"_blank\">\r\n                        <i class=\"flaticon-info-1\"></i>\r\n                        <small>Create you own Bot, Just talk to @BotFather to get Token</small>\r\n                    </a>\r\n                </td>\r\n            </tr>\r\n        </table>\r\n    </form>\r\n    ";
} else {
    $token = $config["slacktokenuser"];
    if ($config["telegramuserbot"]) {
        $BtnTelegram = "@" . $config["telegramuserbot"];
        $URL = "https://api.telegram.org/bot" . $token . "/getWebhookInfo";
        $botdetail = telegramCurl($URL);
        $botdetail = json_decode($botdetail, true);
        if (trim($botdetail["result"]["last_error_message"])) {
            echo "                <div id=\"notification1\" class=\"errorbox\">";
            echo $botdetail["result"]["last_error_message"];
            echo "</div>\r\n                ";
        }
    } else {
        $URL = "https://api.telegram.org/bot" . $token . "/getMe";
        $botdetail = telegramCurl($URL);
        $botdetail = json_decode($botdetail, true);
        saveSettings("telegramuserbot", $botdetail["result"]["username"]);
        $BtnTelegram = "@" . $botdetail["result"]["username"];
        if (!$botdetail["result"]["username"]) {
            saveSettings("slacktokenuser", "");
            saveSettings("slack_usernotification", "");
            saveSettings("telegramuserbot", "");
            $config["slacktokenuser"] = "";
            $config["slack_usernotification"] = "";
            echo "<div id='notification1' class='errorbox'> Error: Invalid Token </div>";
        }
    }
    echo "    <form method=\"post\" action=\"main2.php?page=slack&loaddefault=slackuser.php\">\r\n        <button type=\"submit\" name=\"removeslack\" value=\"1\"\r\n                class=\"btn\">";
    echo $config["messenger"] == "slack" ? "Remove Slack" : "Remove Telegram";
    echo " ";
    echo $BtnTelegram;
    echo "</button>\r\n    </form>\r\n    ";
}
echo "    <div id=\"notification\"></div>\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n            <form id=\"frm\" name=\"\" method=\"post\">\r\n\r\n                ";
echo generate_token("form");
echo "                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n                    <thead>\r\n                    <tr>\r\n                        <th class=\"fieldlabel\">";
echo $LNG["activity"];
echo "</th>\r\n                        <th class=\"fieldlabel\">";
echo $config["messenger"] == "slack" ? $LNG["channel"] : (string) $LNG["user"];
echo "</th>\r\n                    </tr>\r\n                    </thead>\r\n\r\n\r\n                    <tbody>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">\r\n                            User side notification</td>\r\n                        <td class=\"fieldarea\">\r\n\r\n                            <input name=\"slack_usernotification\"  value=\"1\" id=\"nyes\"\r\n                                   type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\r\n                                ";
if ($config["slack_usernotification"]) {
    echo "checked='checked'";
}
echo " /> <label for=\"nyes\"></label>\r\n\r\n                        </td>\r\n                    </tr>\r\n\r\n\r\n                    </tbody>\r\n                </table>\r\n            </form>\r\n        </div>\r\n\r\n        <p class=\"fixedbtn\">\r\n            <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\r\n                   class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','slackuser','#frm','#notification','true','#main_loader');\"/>\r\n\r\n\r\n        </p>\r\n\r\n\r\n    </div>\r\n\r\n    </div>\r\n</div>\r\n\r\n";
$fileverioncheck = "6.1.0";

?>