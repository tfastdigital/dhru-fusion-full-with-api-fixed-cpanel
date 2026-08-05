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
require "../comm.php";
require "fun.inc.php";
require "client.area.inc.php";
include ROOTDIR . "/includes/mail.fun.php";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
global $lng_languag;
global $name;
global $email;
global $query;
global $config;
$inquiry = preg_replace("/[^0-9a-zA-Z]/i", "", $inquiry);
$adminmessage = "Name: " . $name . " <br /> Email: " . $email . " <br /> Query: " . $query;
if (!isset($_SESSION["uid"])) {
    global $captcha;
    $captcha = md5($captcha);
    if ($captcha != $_SESSION["registervarify"] && $config["captchaoncontact"]) {
        echo "error: " . $lng_languag["wrongverify"];
        $_SESSION["registervarify"] = rand(33, 8888);
    } else {
        if ($config["contactus_mail"]) {
            $send = [$config["contactus_mail"]];
        } else {
            $send = [$config["config_admin_mail"]];
        }
        if ($name == "" || $email == "" || $query == "") {
            echo "error: " . $lng_languag["blankfield"];
        } else {
            if ($inquiry) {
                $customfield = NULL;
                if ($phone == "") {
                    echo "error: " . $lng_languag["blankfield"];
                    exit;
                }
                $adminmessage = $adminmessage . " <br /> Phone Number : " . $phone;
            }
            if ($error = checkCustomFields($customfield)) {
                echo "error: " . $error;
                exit;
            }
            if (!preg_match("/^([a-zA-Z0-9\\._-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
                echo "error: " . $lng_languag["clientareaerroremailinvalid"];
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
                echo "success: " . $lng_languag["senddetail"];
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
        echo "error: " . $lng_languag["blankfield"];
    } else {
        if ($inquiry) {
            $customfield = NULL;
            if ($phone == "") {
                echo "error: " . $lng_languag["blankfield"];
                exit;
            }
            $adminmessage = $adminmessage . " <br /> Phone Number : " . $phone;
        }
        if ($error = checkCustomFields($customfield)) {
            echo "error: " . $error;
            exit;
        }
        if (!preg_match("/^([a-zA-Z0-9\\._-])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
            echo "error: " . $lng_languag["clientareaerroremailinvalid"];
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
            echo "success: " . $lng_languag["senddetail"];
        }
    }
}

?>