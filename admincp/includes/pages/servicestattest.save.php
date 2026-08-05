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
if ($telegramchannel) {
    $slack_servicestat = $telegramchannel;
}
if ($config["slack_servicestat"]) {
    $slacktoken = $config["slacktoken"];
    $chatbot = $slack_servicestat;
    $telegramurl = "https://api.telegram.org/bot" . $slacktoken . "/sendMessage";
    $post["chat_id"] = "@" . $chatbot;
    $post["text"] = "Test message from Dhru Fusion";
    $return = telegramCurl($telegramurl, $post);
    $result = json_decode($return, true);
    if ($result["ok"]) {
        echo "success: Test message sent ";
    } else {
        echo "error: Error " . str_replace(":", " - ", $result["description"]);
    }
}

?>