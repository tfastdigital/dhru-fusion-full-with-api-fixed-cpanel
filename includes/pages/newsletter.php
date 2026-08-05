<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "newsletter";
$pagetitle = $lng_languag["newsletter"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"newsletter.php\">" . $lng_languag["newsletter"] . "</a>";
$templatefile = "newsletter";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$email = preg_replace("/[^0-9\\-a-zA-Z@._]/i", "", $email);
$va = preg_replace("/[^0-9\\-a-zA-Z@._]/i", "", $va);
if ($viewpop) {
    $templatefile = "client_newsletter";
    echo processSingleTemplate($templatefile);
    exit;
}
if ($va) {
    if (mysqli_num_rows(dquery("select * from tbl_newsletter where md5(id)='" . $va . "'\nand active=0"))) {
        dquery("UPDATE tbl_newsletter set active=1 where md5(id)='" . $va . "'");
        $tempalte_ver["notification"]["success"] = $lng_languag["email"] . " " . $lng_languag["verified"];
    } else {
        $tempalte_ver["notification"]["error"] = $lng_languag["wrong"] . " " . $lng_languag["link"];
    }
} else {
    if ($email) {
        checkDemoMode(false);
        $flagcaptcha = true;
        if ($captcha && $captcha != $_SESSION["varify"]) {
            $flagcaptcha = false;
        }
        if ($flagcaptcha) {
            if ($config["captchaonnewsletter"] && !$captcha) {
                $tempalte_ver["notification"]["error"] = "Captcha required";
            } else {
                if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
                    $tempalte_ver["notification"]["error"] = $lng_languag["clientareaerroremailinvalid"];
                } else {
                    $sql = dquery("select id from tbl_newsletter where `email`='" . $email . "'");
                    if (!mysqli_num_rows($sql)) {
                        $data = NULL;
                        $data["email"] = $email;
                        $data["IP"] = $remote_ip;
                        $data["active"] = 0;
                        $data["time"] = time();
                        $nic = $db->insert("tbl_newsletter", $data);
                        $data = NULL;
                        require_once ROOTDIR . "/includes/mail.fun.php";
                        $link = $config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"];
                        $link .= "newsletter.php?va=" . md5($nic);
                        $email_merge_fields["link"] = $link;
                        $toemails[]["to"] = $email;
                        sendMail(79, "", "", $email_merge_fields, "", "", "", "", $toemails);
                    }
                    $tempalte_ver["notification"]["success"] = $lng_languag["subscriptionsuccess"] . " " . $lng_languag["please"] . " " . $lng_languag["check"] . " " . $lng_languag["your"] . " " . $lng_languag["email"];
                }
            }
        } else {
            $tempalte_ver["notification"]["error"] = $lng_languag["wrong"] . " " . $lng_languag["verification"] . " " . $lng_languag["code"];
        }
    }
}
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>