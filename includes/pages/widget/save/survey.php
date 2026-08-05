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
require_once "../../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
require_once ROOTDIR . "/includes/mail.fun.php";
$ids = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $ids);
if (!$_SESSION["uid"]) {
    global $captcha;
    $captcha = md5($captcha);
    if (!$name) {
        echo "error: " . $lng_languag["name"] . " " . $lng_languag["isrequired"];
        exit;
    }
    if (!preg_match("/^([a-zA-Z0-9\\._-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
        echo "error: " . $lng_languag["clientareaerroremailinvalid"];
        exit;
    }
}
$surd = mysqli_fetch_assoc(dquery("select captcha from tbl_survey where md5(id)='" . $ids . "'"));
if ($surd["captcha"] && $captcha != $_SESSION["varify"]) {
    echo "error: " . $lng_languag["wrongverify"];
    exit;
}
if ($error = checkCustomFields($customfield)) {
    echo "error: " . $error;
    exit;
}
if ($_SESSION["uid"]) {
    $sur = dquery("select id from tbl_survey_detail where md5(srid)='" . $ids . "' AND uid='" . $_SESSION["uid"] . "'");
} else {
    $sur = dquery("select id from tbl_survey_detail where md5(srid)='" . $ids . "' AND email='" . $email . "'");
}
if (mysqli_num_rows($sur)) {
    echo "error: " . $lng_languag["onlyoncesurvey"];
    exit;
}
$sur = mysqli_fetch_assoc(dquery("select id,title from tbl_survey where md5(id)='" . $ids . "'"));
if ($sur["id"]) {
    $data["srid"] = $sur["id"];
    if ($_SESSION["uid"]) {
        $user = mysqli_fetch_assoc(dquery("select username,email from tblUsers where \n            id='" . $_SESSION["uid"] . "'"));
        $name = $user["username"];
        $email = $user["email"];
        $data["uid"] = $_SESSION["uid"];
    }
    $data["name"] = $name;
    $data["email"] = $email;
    $data["ip"] = $remote_ip;
    $data["date"] = date("Y-m-d");
    $unique = $db->insert("tbl_survey_detail", $data);
}
if ($unique) {
    saveCustomFields($unique, $customfield);
}
foreach ($customfield as $k => $v) {
    $sql = mysqli_fetch_assoc(dquery("select fieldname from tbl_customfields where id='" . $k . "'"));
    if ($v) {
        $buff .= $sql["fieldname"] . " : " . $v . " <br />";
    }
}
$send = [$config["config_admin_mail"]];
$here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("viewsurvey&id=" . $unique) . "&title=" . base64_encode("Survey Detail") . "'>here</a>";
$adminmessage = "\n    Survey About - " . $sur["title"] . "<br />\n    ---------------------------<br />\n    Client : " . $name . " [" . $email . "]<br />\n    Survey Details : <br />\n    -----------------------------<br />\n    " . $buff . "\n    <br /><br />\n    Click " . $here . " to view survey details\n    ";
sendNotification("system", "Survey - " . $sur["title"], nl2br($adminmessage), $send);
echo "success: " . $lng_languag["your"] . " " . $lng_languag["survey"] . " " . $lng_languag["completed"];

?>