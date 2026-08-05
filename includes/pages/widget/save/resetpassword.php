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
include_once ROOTDIR . "/includes/mail.fun.php";
$path = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
$OUT = [];
if ($_SESSION["__PASS_ACTIION"] == "reset") {
    global $lng_languag;
    global $users;
    global $config;
    global $db;
    if ($config["captcha_forget"]) {
        $enter = $captcha;
        $captcha = md5(strtoupper($captcha));
        if ($captcha != $_SESSION["forgetcaptcha"]) {
            $OUT["status"] = "error";
            $OUT["message"] = $lng_languag["wrongverify"];
            include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
            $NewsletterCaptcha = createVerification("forget");
            $OUT["divid"] = "#inputcaptcha_forget";
            $OUT["divcontent"] = "<img alt='verification image, type it in the box' class='captchacom' id='captchaimgs4' align='absbottom' src='data:image/jpg;base64," . $NewsletterCaptcha . "' />";
            echo _josnOUT($OUT);
            exit;
        }
    }
    if (!$users) {
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["wronguser"];
        echo _josnOUT($OUT);
        exit;
    }
    $username = descape($users);
    $sql = dquery("SELECT `id`,`username`,`question_id`,`question_answer`,`email`\n     FROM `tblUsers` WHERE `username`='" . $username . "' or email='" . $username . "'");
    $cnt = mysqli_num_rows($sql);
    if (mysqli_num_rows($sql) == 1) {
        $row = mysqli_fetch_assoc($sql);
        $data["reset_key"] = md5($row["id"] . $row["username"] . time());
        $db->update("tblUsers", $data, "id=" . $row["id"]);
        $link = _url("resetpassword/user/" . base64_encode(md5($row["id"])) . "/access/" . base64_encode($data["reset_key"]), true);
        $OUT["message"] = $lng_languag["linksend"];
        $email_merge_fields["username"] = $row["username"];
        $email_merge_fields["link"] = $link;
        sendMail(3, $row["id"], "", $email_merge_fields);
        $OUT["status"] = "success";
    } else {
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["wronguser"];
    }
    echo _josnOUT($OUT);
    exit;
}
if ($_SESSION["__PASS_ACTIION"] == "sendlink") {
    global $lng_languag;
    global $question;
    global $answer;
    global $config;
    global $db;
    $question = descape($question);
    $answer = descape($answer);
    $answer = enc($answer, "233");
    $sql = dquery("SELECT `id`,`username`,`question_id`,`question_answer`,`email` \n        FROM `tblUsers` WHERE `username`='" . $_SESSION["required_question"] . "' AND \n        `question_answer`='" . $answer . "'");
    if (mysqli_num_rows($sql) == 1) {
        $row = mysqli_fetch_assoc($sql);
        $data = NULL;
        $data["reset_key"] = md5($row["id"] . $row["username"] . time());
        $db->update("tblUsers", $data, "id=" . $row["id"]);
        $link = _url("/resetpassword/user/" . base64_encode(md5($row["id"])) . "/access/" . base64_encode($data["reset_key"]), true);
        $email_merge_fields["username"] = $row["username"];
        $email_merge_fields["link"] = $link;
        sendMail(3, $row["id"], "", $email_merge_fields);
        unset($_SESSION["required_question"]);
        $OUT["status"] = "success";
        $OUT["message"] = $lng_languag["linksend"];
    } else {
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["wrongans"];
    }
    echo _josnOUT($OUT);
} else {
    if ($_SESSION["__PASS_ACTIION"] == "password") {
        global $lng_languag;
        global $password;
        global $confirmation;
        global $config;
        global $db;
        global $passenc;
        if ($password == $confirmation) {
            $sql = dquery("SELECT `id`,`email`,`username` FROM `tblUsers`\n                 WHERE MD5(id)='" . $_SESSION["__PASS_USER_ID"] . "' AND `reset_key`='" . $_SESSION["__PASS_ACCESS"] . "'");
            if (mysqli_num_rows($sql) == 1) {
                if (strlen($password) < 4 || 20 < strlen($password)) {
                    $OUT["status"] = "error";
                    $OUT["message"] = $lng_languag["passlength"];
                    echo _josnOUT($OUT);
                    exit;
                }
                if ($config["passwordsecurity"] != "low") {
                    if (!preg_match("#[0-9]+#", $password)) {
                        $OUT["status"] = "error";
                        $OUT["message"] = $lng_languag["reqonenum"] ? $lng_languag["reqonenum"] : "One Number required";
                        echo _josnOUT($OUT);
                        exit;
                    }
                    if (!preg_match("#[A-Z]+#", $password)) {
                        $OUT["status"] = "error";
                        $OUT["message"] = $lng_languag["reqonecap"] ? $lng_languag["reqonecap"] : "One Capital letter required";
                        echo _josnOUT($OUT);
                        exit;
                    }
                    if (!preg_match("#[a-z]+#", $password)) {
                        $OUT["status"] = "error";
                        $OUT["message"] = $lng_languag["reqonesmall"] ? $lng_languag["reqonesmall"] : "One small letter required";
                        echo _josnOUT($OUT);
                        exit;
                    }
                }
                $row = mysqli_fetch_assoc($sql);
                $data = NULL;
                $data["password"] = md5(md5(trim($password)) . $passenc);
                $data["reset_key"] = "";
                $data["lastpassreset"] = time();
                $db->update("tblUsers", $data, "id=" . $row["id"]);
                $OUT["status"] = "success";
                $OUT["message"] = $lng_languag["updates"];
                echo _josnOUT($OUT);
                $email_merge_fields["username"] = $row["username"];
                sendMail(4, $row["id"], "", $email_merge_fields);
            }
        } else {
            $OUT["status"] = "error";
            $OUT["message"] = $lng_languag["notsame"];
            echo _josnOUT($OUT);
        }
    }
}
echo _josnOUT($OUT);
unset($_SESSION["__PASS_ACTIION"]);
unset($_SESSION["__PASS_USER_ID"]);
unset($_SESSION["__PASS_ACCESS"]);

?>