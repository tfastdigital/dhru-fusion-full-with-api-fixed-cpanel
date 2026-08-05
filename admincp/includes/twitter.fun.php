<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function twitter_post($msg)
{
    global $config;
    global $admindirpath;
    require_once ROOTDIR . "/" . $admindirpath . "/includes/3rdparty/twitter/TwitterAPIExchange.php";
    $settings = ["oauth_access_token" => trim($config["access_token"]), "oauth_access_token_secret" => trim($config["token_secret"]), "consumer_key" => trim($config["consumer_key"]), "consumer_secret" => trim($config["consumer_secret"])];
    $url = "https://api.twitter.com/1.1/statuses/update.json";
    if (140 < strlen($msg)) {
        $msg = substr($msg, 0, 140);
    }
    $requestMethod = "POST";
    $postfields = ["status" => $msg];
    $twitter = new TwitterAPIExchange($settings);
    $twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest();
}

?>