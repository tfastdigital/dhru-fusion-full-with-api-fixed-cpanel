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
$fileverioncheck = "6.1.0";
if ($config["smsgateway"] && isset($_SESSION["CANACTIVE"])) {
    $currentpage = "activeuseraccount";
    $pagetitle = $lng_languag["active"] . " " . $lng_languag["user"] . " " . $lng_languag["account"];
    $_nav .= "<a href='activeuser.php' >" . $lng_languag["active"] . " " . $lng_languag["user"] . " " . $lng_languag["account"] . "</a> / ";
    $templatefile = "client_activeaccount";
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    if ($activate && isset($_SESSION["mduid"])) {
        $code = preg_replace("/[^0-9]/i", "", $code);
        $md5code = md5($code);
        $sql = dquery("select id from tblUsers where\nmd5(id)='" . $_SESSION["mduid"] . "' and (mobverify)='" . $md5code . "'");
        if (mysqli_num_rows($sql)) {
            dquery("update tblUsers set userstatus='0',`block_reason`='',login_failed_atoms='0',\n               canactive='0' where md5(id)='" . $_SESSION["mduid"] . "'");
            $tempalte_ver["notification"]["success"] = $lng_languag["actsuc"];
            $tempalte_ver["activated"] = true;
        } else {
            $tempalte_ver["notification"]["error"] = $lng_languag["wrongvericode"];
        }
    }
    if ($ver && $username && $mobile && $email) {
        $username = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $username);
        $mobile = preg_replace("/[^0-9]/i", "", $mobile);
        $email = preg_replace("/[^0-9\\-a-zA-Z@._]/i", "", $email);
        if (preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
            $sql = dquery("select * from tblUsers where \n                username='" . $username . "' and email='" . $email . "'\n                 and phonenumber='" . $mobile . "' and verified=1");
            if (mysqli_num_rows($sql)) {
                $det = mysqli_fetch_assoc($sql);
                $code = rand(100000, 999999);
                if (!function_exists(sendMail)) {
                    include ROOTDIR . "/includes/mail.fun.php";
                }
                $error = sendSMS($mobile, 3, "", ["CODE" => $code]);
                $md5code = md5($code);
                dquery("UPDATE tblUsers SET mobverify='" . $md5code . "',\n                    verified='0' WHERE id='" . $det["id"] . "'");
                $error = explode(":", $error);
                if (trim($error[0]) == "success") {
                    $tempalte_ver["notification"]["success"] = $lng_languag["condsentonmob"];
                    $tempalte_ver["sentverify"] = true;
                    $_SESSION["mduid"] = md5($det["id"]);
                } else {
                    $tempalte_ver["notification"]["error"] = $lng_languag["msgsendingfail"];
                }
            } else {
                $tempalte_ver["notification"]["error"] = $lng_languag["wrongdetail"];
            }
        } else {
            $tempalte_ver["notification"]["error"] = $lng_languag["wrongdetail"];
        }
    } else {
        if ($ver) {
            $tempalte_ver["notification"]["error"] = $lng_languag["blankfield"];
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    DisplayOutput($templatefile);
} else {
    header("Location: index.php");
}
chkMd5sumsubpage();
class no
{
}

?>