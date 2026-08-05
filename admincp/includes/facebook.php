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
include "../../comm.php";
require_once "../../includes/fun.inc.php";
require_once "../includes/fun.inc.php";
echo "<link rel=\"stylesheet\" href=\"css/main2.css\" />\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($autopost) {
    $md5id = md5($id);
    if ($link == "wholesale" || $service == "file") {
        $link = $admindirpath . "/productsandservices.php?action=getdetail&service=" . $md5id;
    } else {
        $link = $admindirpath . "/cart.php?group=" . $group_id . "&item=" . $md5id . "&service=" . $service;
    }
}
if ($comment) {
    $link = base64_decode($link);
}
require_once ROOTDIR . "/" . $admindirpath . "/includes/3rdparty/facebook/facebook.php";
$app_id = $config["appid"];
$app_secret = $config["app_secret"];
$user = NULL;
$facebook = new Facebook(["appId" => $config["appid"], "secret" => $config["app_secret"], "cookie" => true]);
$user = $facebook->getUser();
if ($user == 0) {
    $login_url = $facebook->getLoginUrl($params = ["scope" => "publish_stream"]);
    echo "<script> top.location.href='" . $login_url . "'</script>";
} else {
    try {
        $params = ["message" => $title, "name" => "", "description" => $comment, "link" => $link];
        $post = $facebook->api("/" . $user . "/feed", "POST", $params);
        echo "<div id='notification1' class='successbox'>Your post was successfully posted on facebook</div>";
    } catch (FacebookApiException $e) {
        $result = $e->getResult();
    }
}
echo "</div>\n</div>";

?>