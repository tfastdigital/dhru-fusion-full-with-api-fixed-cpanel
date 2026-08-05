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
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
include ROOTDIR . "/includes/mail.fun.php";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
global $lng_languag;
global $name;
global $email;
global $query;
global $config;
$inquiry = preg_replace("/[^0-9a-zA-Z]/i", "", $inquiry);
$OUT = [];
$adminmessage = "Name: " . $name . " <br /> Email: " . $email . " <br /> Query: " . $query;
if (!isset($_SESSION["uid"])) {
    global $captcha;
    $captcha = md5(strtoupper($captcha));
    if ($captcha != $_SESSION["registervarify"] && $config["captchaoncontact"]) {
        include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["wrongverify"];
        $NewsletterCaptcha = createVerification("onregistration");
        $OUT["divid"] = "#inputcaptcha_contact";
        $OUT["divcontent"] = "<img alt='verification image, type it in the box' class='captchacom' id='captchaimgs4' align='absbottom' src='data:image/jpg;base64," . $NewsletterCaptcha . "' />";
    } else {
        if ($config["contactus_mail"]) {
            $send = [$config["contactus_mail"]];
        } else {
            $send = [$config["config_admin_mail"]];
        }
        if ($name == "" || $email == "" || $query == "") {
            $OUT["status"] = "error";
            $OUT["message"] = $lng_languag["blankfield"];
        } else {
            if ($inquiry) {
                $customfield = NULL;
                if ($phone == "") {
                    $OUT["status"] = "error";
                    $OUT["message"] = $lng_languag["blankfield"];
                    echo _josnOUT($OUT);
                    exit;
                }
                $adminmessage = $adminmessage . " <br /> Phone Number : " . $phone;
            }
            if ($error = checkCustomFields($customfield)) {
                $OUT["status"] = "error";
                $OUT["message"] = $error;
                echo _josnOUT($OUT);
                exit;
            }
            if (!preg_match("/^([a-zA-Z0-9\\._-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
                $OUT["status"] = "error";
                $OUT["message"] = $lng_languag["clientareaerroremailinvalid"];
            } else {
                if ($customfield) {
                    foreach ($customfield as $k => $v) {
                        $sql = mysqli_fetch_assoc(dquery("select fieldname from tbl_customfields where id='" . $k . "'"));
                        if ($v) {
                            $buff .= $sql["fieldname"] . " : " . $v . " <br />";
                        }
                    }
                }
                if ($buff) {
                    $adminmessage = $adminmessage . " <br /><br />Custom Details : <br />" . $buff;
                }
                if ($inquiry) {
                    $s = mysqli_fetch_assoc(dquery("select service_name,id from tbl_products \n                    where md5(id)='" . $inquiry . "'"));
                    $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editproduct&id=" . $s["id"]) . "&title=" . base64_encode("Edit " . $s["service_name"]) . "'>here</a>";
                    $adminmessage = "Call for Pricing - " . $s["service_name"] . " <br /><br /> " . $adminmessage . "\n                    <br /><br />\n                    Click " . $here . " to view product";
                    sendNotification("other", "Call for Pricing inquiry - " . $s["service_name"], nl2br($adminmessage), $send, $config["companyname"], "", "", $email);
                } else {
                    sendNotification("other", "Contact Us Inquiry", nl2br($adminmessage), $send, $config["companyname"], "", "", $email);
                }
                $OUT["status"] = "success";
                $OUT["hidediv"] = "#contact";
                $OUT["message"] = $lng_languag["senddetail"];
            }
        }
    }
} else {
    if ($config["contactus_mail"]) {
        $send = [$config["contactus_mail"]];
    } else {
        $send = [$config["config_admin_mail"]];
    }
    if ($name == "" || $email == "" || $query == "") {
        $OUT["status"] = "error";
        $OUT["message"] = $lng_languag["blankfield"];
    } else {
        if ($inquiry) {
            $customfield = NULL;
            if ($phone == "") {
                $OUT["status"] = "error";
                $OUT["message"] = $lng_languag["blankfield"];
                echo _josnOUT($OUT);
                exit;
            }
            $adminmessage = $adminmessage . " <br /> Phone Number : " . $phone;
        }
        if ($error = checkCustomFields($customfield)) {
            $OUT["status"] = "error";
            $OUT["message"] = $error;
            echo _josnOUT($OUT);
            exit;
        }
        if (!preg_match("/^([a-zA-Z0-9\\._-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
            $OUT["status"] = "error";
            $OUT["message"] = $lng_languag["clientareaerroremailinvalid"];
        } else {
            if ($customfield) {
                foreach ($customfield as $k => $v) {
                    $sql = mysqli_fetch_assoc(dquery("select fieldname from tbl_customfields where id='" . $k . "'"));
                    if ($v) {
                        $buff .= $sql["fieldname"] . " : " . $v . " <br />";
                    }
                }
            }
            if ($buff) {
                $adminmessage = $adminmessage . " <br /><br />Custom Details : <br />" . $buff;
            }
            if ($inquiry) {
                $s = mysqli_fetch_assoc(dquery("select service_name,id from tbl_products \n            where md5(id)='" . $inquiry . "'"));
                $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editproduct&id=" . $s["id"]) . "&title=" . base64_encode("Edit " . $s["service_name"]) . "'>here</a>";
                $adminmessage = "Call for Pricing - " . $s["service_name"] . " <br /><br /> " . $adminmessage . "\n                    <br /><br />\n                    Click " . $here . " to view product";
                sendNotification("other", "Call for Pricing inquiry - " . $s["service_name"], nl2br($adminmessage), $send, "", "", "", $email);
            } else {
                sendNotification("other", "Contact Us Inquiry", nl2br($adminmessage), $send, "", "", "", $email);
            }
            $OUT["status"] = "success";
            $OUT["hidediv"] = "#contact";
            $OUT["message"] = $lng_languag["senddetail"];
        }
    }
}
echo _josnOUT($OUT);

?>