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
echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n\r\n\r\n        ";
if ($savetele && $telegramtoken && !$removeslack) {
    saveSettings("slacktoken", trim($telegramtoken));
    saveSettings("messenger", "telegram");
}
if ($removeslack) {
    saveSettings("slacktoken", "");
    saveSettings("messenger", "");
    dquery("UPDATE tbl_settings set value='' WHERE attribute='slackchannel'");
    $config["slacktoken"] = "";
}
if ($id && !$removeslack) {
    $decode = decrypt($id);
    if (stripos($decode, "xoxp") !== false && $decode != "") {
        saveSettings("slacktoken", $id);
        saveSettings("messenger", "slack");
        $config["slacktoken"] = $id;
    } else {
        saveSettings("slacktoken", "");
        saveSettings("messenger", "");
        $config["slacktoken"] = "";
        echo "                <div class=\"errorbox\" id=\"notification1\">Error Something Try again.</div>\r\n                ";
    }
}
if (!$config["slacktoken"]) {
    $siteaddress = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
    $callbackurl = $siteaddress . "/" . $admindirpath . "/main.php?pageurl=" . base64_encode("slack&id=" . $invoiceid) . "&title=" . base64_encode("Slack Integration");
    $state = "";
    $tmp[l] = str_replace("-", "", $licinfo["license_key"]);
    $tmp[callback] = $callbackurl;
    $state = urlencode(encrypt(json_encode($tmp)));
    echo "            <form method=\"post\" >\r\n                <table id=\"main_tbl\" style=\"width: 500px;\">\r\n                    <tr>\r\n                        <Td>\r\n                            <a target=\"_blank\" href=\"https://slack.com/oauth/authorize?client_id=321524302375.526105206615&scope=incoming-webhook,commands,chat:write:bot,channels:read,groups:read,im:read,mpim:read,usergroups:read,users:read&state=";
    echo $state;
    echo "\">\r\n                                <img alt=\"Add to Slack\" height=\"40\" width=\"139\" src=\"https://platform.slack-edge.com/img/add_to_slack.png\" srcset=\"https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x\" /></a>\r\n                        </Td>\r\n                        <td>\r\n                            OR\r\n                        </td>\r\n                        <td>\r\n                            Telegram Bot Token : <input type=\"text\" name=\"telegramtoken\" />\r\n                            <button class=\"btn\" name=\"savetele\" value=\"savetele\">Save</button>\r\n                            <br/>\r\n                            <a href=\"https://support.dhru.com/Dhru-Fusion/article/Telegram/?aid=45&cid=7&pid=1\" target=\"_blank\"> <i class=\"flaticon-info-1\"></i> <small>Create you own Bot, Just talk to @BotFather to get Token</small></a>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n            </form>\r\n            ";
} else {
    if ($config["messenger"] == "telegram") {
        $token = $config["slacktoken"];
        $botdetail = telegramCurl("https://api.telegram.org/bot" . $token . "/getMe");
        $botdetail = json_decode($botdetail, true);
        $BtnTelegram = "@" . $botdetail["result"]["username"];
        if (!$botdetail["result"]["username"]) {
            saveSettings("slacktoken", "");
            saveSettings("messenger", "");
            echo "<div id='notification1' class='errorbox'> Error: Invalid Token </div>";
        }
    }
    echo "            <form method=\"post\" action=\"#\">\r\n                <button type=\"submit\" name=\"removeslack\" value=\"1\" class=\"btn\" >";
    echo $config["messenger"] == "slack" ? "Remove Slack" : "Remove Telegram";
    echo " ";
    echo $BtnTelegram;
    echo "</button>\r\n            </form>\r\n            ";
}
$SlackArr = SlackGetChannels();
echo "        <div id=\"notification\"></div>\r\n        <div id=\"content\">\r\n            <div id=\"content_padded\">\r\n                <form id=\"frm\" name=\"\" method=\"post\">\r\n\r\n                    ";
echo generate_token("form");
echo "                    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\r\n                        <thead>\r\n                        <tr>\r\n                            <th class=\"fieldlabel\">";
echo $LNG["activity"];
echo "</th>\r\n                            <th class=\"fieldlabel\">";
echo $config["messenger"] == "slack" ? $LNG["channel"] : (string) $LNG["user"];
echo "</th>\r\n                        </tr>\r\n                        </thead>\r\n                        <tbody>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">\r\n                                <button name=\"sendtestmsg\" type=\"button\" id=\"btntest\" class=\"btn testbtn\"\r\n                                        onclick=\"SubmitForm ('#btntest','slacktest','#frm','#notification','true','#main_loader');\"                    >Send Test Message</button>\r\n                            </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_test\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_test"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["login"];
echo " ";
echo $LNG["failed"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_adminloginfailed\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_adminloginfailed"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Suspious ";
echo $LNG["admin"];
echo " ";
echo $LNG["page"];
echo " ";
echo $LNG["access"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_suspiousaccess\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_suspiousaccess"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <!--\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo " ";
echo $LNG["change"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_servicepricechange\">\r\n                                    <option value=\"\">Service Wise</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_servicepricechange"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        -->\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["new"];
echo " IMEI ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_ordernotification\">\r\n                                    <option value=\"\">Service Wise</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_ordernotification"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["new"];
echo " Server ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_serverordernotification\">\r\n                                    <option value=\"\">Service Wise</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_serverordernotification"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["shop"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["notification"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_shopordernotification\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_shopordernotification"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["add"];
echo "/";
echo $LNG["rebate"];
echo " ";
echo $LNG["credit"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_adminaddcredit\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_adminaddcredit"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["signup"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_newusersignup\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_newusersignup"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["auto"];
echo " ";
echo $LNG["invoice"];
echo " ";
echo $LNG["paid"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_invoicepaid\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_invoicepaid"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["manual"];
echo " ";
echo $LNG["invoice"];
echo " ";
echo $LNG["paid"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_manualinvoicepaid\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_manualinvoicepaid"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["manual"];
echo " ";
echo $LNG["process"];
echo " ";
echo $LNG["required"];
echo " for Fraud Protection</td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_fraudinvoice\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_fraudinvoice"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">";
echo $LNG["direct"];
echo " ";
echo $LNG["invoice"];
echo " ";
echo $LNG["status"];
echo " ";
echo $LNG["change"];
echo "</td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_directinvoicestatus\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_directinvoicestatus"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n\r\n\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">APi  ";
echo $LNG["not"];
echo " enough ";
echo $LNG["credit"];
echo "</td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_apilowcredit\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_apilowcredit"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Key selling  ";
echo $LNG["not"];
echo " enough key</td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <select name=\"slack_notenoughkey\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_notenoughkey"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">ID Verification/KYC Request  </td>\r\n                            <td class=\"fieldarea\">\r\n                                <select name=\"slack_idverification\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_idverification"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Fund Transfer   </td>\r\n                            <td class=\"fieldarea\">\r\n                                <select name=\"slack_fundtransfer\">\r\n                                    <option value=\"\">Select</option>\r\n                                    ";
foreach ($SlackArr["channels"] as $groupid => $groupdetail) {
    $selected = "";
    if ($groupid == $config["slack_fundtransfer"]) {
        $selected = "selected";
    }
    echo "                                        <option ";
    echo $selected;
    echo " value=\"";
    echo $groupid;
    echo "\">";
    echo $groupdetail["name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Service Notification(Add, Active, Inactive) <span class=\"textred\">Telegram</span></td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <input type=\"text\" name=\"slack_servicestat\" class=\"txt medium\" value=\"";
echo $config["slack_servicestat"];
echo "\" />\r\n                                <input type=\"button\" class=\"bts\" onclick=\"SubmitForm('#bts','servicestattest','#frm','#notification','true','#main_loader');\"\r\n                                       name=\"sendtest\" value=\"Send Test message to Channel\" />\r\n                                <div>Telegram Channel ID.</div> <br /><a target=\"_blank\" href=\"https://support.dhru.com/Dhru-Fusion/article/Telegram/?aid=45&cid=7&pid=1\">How to Connect Telegram Bot to Your channel</a>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td  class=\"fieldlabel\">Price Change Notification  <span class=\"textred\">Telegram</span></td>\r\n                            <td class=\"fieldarea\">\r\n\r\n                                <input type=\"text\" name=\"slack_pricechange\" class=\"txt medium\" value=\"";
echo $config["slack_pricechange"];
echo "\" />\r\n                                <input type=\"button\" class=\"bts\" onclick=\"SubmitForm('#bts','pricechangetest','#frm','#notification','true','#main_loader');\"\r\n                                       name=\"sendtest\" value=\"Send Test message to Channel\" />\r\n                                <div>Telegram Channel ID.</div> <br /><a target=\"_blank\" href=\"https://support.dhru.com/Dhru-Fusion/article/Telegram/?aid=45&cid=7&pid=1\">How to Connect Telegram Bot to Your channel</a>\r\n                            </td>\r\n                        </tr>\r\n\r\n                        </tbody>\r\n                    </table>\r\n                </form>\r\n\r\n            </div>\r\n        </div>\r\n    </div>\r\n\r\n    <p class=\"fixedbtn\">\r\n        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\r\n               class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','slackintegration','#frm','#notification','true','#main_loader');\"/>\r\n\r\n\r\n    </p>\r\n\r\n\r\n</div></div>\r\n";
$fileverioncheck = "6.1.0";

?>