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
require_once "comm.php";
require_once "includes/fun.inc.php";
require_once "includes/client.area.inc.php";
$templatefile = "client_mobileverify";
if (!file_exists(ROOTDIR . "/templates/" . $_SESSION["template"] . "/client_mobileverify.tpl")) {
    copy(ROOTDIR . "/templates/default/client_mobileverify.tpl", ROOTDIR . "/templates/" . $_SESSION["template"] . "/client_mobileverify.tpl");
}
$prefix = preg_replace("/[^0-9]/i", "", $prefix);
$mobile = preg_replace("/[^0-9]/i", "", $mobile);
installclient($pagetitle, $pageicon, $breadcrumbnav);
if (isset($_SESSION["uid"])) {
    $su = mysqli_fetch_assoc(dquery("select verified,phonenumber,mobverify from tblUsers where id='" . $_SESSION["uid"] . "'"));
    if (!$su["verified"]) {
        $tempalte_ver["phone"] = $su["phonenumber"];
        $tempalte_ver["prefix"] = $prefix;
        if ($codesave && $code) {
            if ($su["mobverify"] == $code) {
                dquery("UPDATE tblUsers SET verified='1' \n            WHERE id='" . $_SESSION["uid"] . "'");
                header("Location: main.php");
                echo "                <script>location.href='main.php';</script>\n                ";
            } else {
                $tempalte_ver["notification"]["error"] = "Wrong verification code !";
            }
        } else {
            if ($codesave) {
                $tempalte_ver["notification"]["error"] = "All fields are required";
            }
        }
        if (isset($sms) && $mobile && $prefix) {
            dquery("update tblUsers set phonenumber='" . $mobile . "' where id='" . $_SESSION["uid"] . "'");
            require_once "includes/mail.fun.php";
            $RAND = rand(1000, 9999);
            $error = sendSMS($mobile, 3, "", ["CODE" => $RAND], $_SESSION["uid"]);
            dquery("UPDATE tblUsers SET mobverify='" . $RAND . "',verified='0' \n            WHERE id='" . $_SESSION["uid"] . "'");
            $error = explode(":", $error);
            if (trim($error[0]) == "success") {
                $tempalte_ver["smssuccess"] = true;
            } else {
                $tempalte_ver["notification"]["error"] = $lng_languag["msgsendingfail"];
            }
        } else {
            if (isset($call) && $mobile && $prefix) {
                dquery("update tblUsers set phonenumber='" . $mobile . "' where id='" . $_SESSION["uid"] . "'");
                $RAND = rand(1000, 9999);
                dquery("UPDATE tblUsers SET mobverify='" . $RAND . "',verified='0' \n            WHERE id='" . $_SESSION["uid"] . "'");
                $_responce = initCurl("https://www.maxmind.com/app/telephone_http?l=" . $config["maxmindapikey"] . "&phone=%2B" . $prefix . $mobile . "&verify_code=" . $RAND);
                $_responce = explode("=", $_responce);
                if ($_responce[0] == "err") {
                    $tempalte_ver["notification"]["error"] = "Unable to call";
                } else {
                    $tempalte_ver["callsuccess"] = true;
                }
            } else {
                if (isset($call) || isset($sms)) {
                    $tempalte_ver["notification"]["error"] = "All fields are required";
                }
            }
        }
        $fileverioncheck = "6.1.0";
        DisplayOutput($templatefile);
    } else {
        header("Location: main.php");
        echo "                <script>location.href='main.php';</script>\n                ";
    }
} else {
    header("Location: login.php");
    echo "    <script>location.href='login.php';</script>\n    ";
}
chkMd5sumsubpage();
class no
{
}

?>