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
if ($config["slack_pricechange"]) {
    $slacktoken = $config["slacktoken"];
    $chatbot = $config["slack_pricechange"];
    $telegramurl = "https://api.telegram.org/bot" . $slacktoken . "/sendMessage?chat_id=@" . $chatbot . "&text=Test message from Dhru Fusion";
    $return = telegramCurl($telegramurl);
    $result = json_decode($return, true);
    if ($result["ok"]) {
        echo "success: Test message sent ";
    } else {
        echo "error: Error " . $result["description"];
    }
}

?>