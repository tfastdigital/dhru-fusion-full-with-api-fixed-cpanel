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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/customfield.fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if (isset($_SESSION["uid"])) {
    $name = $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"];
    $email = $_ClientsDetails["email"];
} else {
    if (md5(strtoupper($captcha)) != $_SESSION["reviewcaptcha"]) {
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["wrongverify"];
        include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
        $NewsletterCaptcha = createVerification("review");
        $OUT["divid"] = "#inputcaptcha_review";
        $OUT["divcontent"] = "<img alt='verification image, type it in the box' class='captchacom' id='captchaimgs4' align='absbottom' src='data:image/jpg;base64," . $NewsletterCaptcha . "' />";
        echo _josnOUT($OUT);
        exit;
    }
}
if ($name == "" || $email == "" || $comment == "") {
    $OUT["status"] = "error";
    $OUT["message"] = $lng_languag["filefield"];
    echo _josnOUT($OUT);
    exit;
}
if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
    $OUT["status"] = "error";
    $OUT["message"] = $lng_languag["clientareaerroremailinvalid"];
    echo _josnOUT($OUT);
    exit;
}
$data["name"] = $name;
$data["email"] = $email;
$data["comment"] = nl2br($comment);
$data["rate"] = $estart;
$data["date"] = date("d-m-Y");
if ($imei) {
    $data["sid"] = $sid;
} else {
    if ($lid) {
        $data["lid"] = $lid;
    } else {
        $data["pid"] = $pid;
    }
}
$db->insert("tbl_review", $data);
$OUT["status"] = "success";
$OUT["message"] = $lng_languag["thankscomments"];
echo _josnOUT($OUT);
exit;

?>