<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
global $lng_languag;
global $author;
global $email;
global $comment;
global $captcha;
global $db;
global $config;
$comment = htmlspecialchars(strip_tags(html_entity_decode($comment)));
$author = htmlspecialchars(strip_tags(html_entity_decode($author)));
$captcha = md5($captcha);
if ($captcha != $_SESSION["varify"]) {
    $errormessage .= "<li>" . $lng_languag["wrongverify"] . "</li>";
} else {
    if ($author && $email && $comment) {
        if (30 < strlen($author)) {
            echo "error: " . $lng_languag["authorname"];
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "error: " . $lng_languag["clientareaerroremailinvalid"];
            } else {
                $data = NULL;
                $data["author"] = $author;
                $data["email"] = $email;
                $data["comment"] = $comment;
                $data["ip"] = $_SERVER["REMOTE_ADDR"];
                $data["date"] = date("Y-m-d");
                $data["status"] = "pending";
                $db->insert("tbl_testimonial", $data);
                echo "success: " . $lng_languag["thankcomment"];
            }
        }
    }
}
if (!$author || !$email || !$comment) {
    $errormessage .= "<li>" . $lng_languag["fieldblank"] . "</li>";
}
if ($errormessage) {
    echo "error: " . $errormessage;
    exit;
}

?>