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
require_once "../fun.inc.php";
require_once "../client.area.inc.php";
require_once ROOTDIR . "/includes/mail.fun.php";
require_once ROOTDIR . "/includes/support.fun.php";
global $lng_languag;
global $subject;
global $email;
global $name;
global $message;
global $department;
global $config;
global $priority;
global $storeowner;
global $db;
if ($name != "" && $email != "" && $price != "") {
    $_serviceid = preg_replace("/[^0-9]/i", "", $_serviceid);
    $pro = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $_serviceid . "'"));
    if (md5($captcha) != $_SESSION["varify"] && !isset($_SESSION["uid"])) {
        echo "<div class='errorbox'>" . $lng_languag["wrongverify"] . "</div>";
    } else {
        if (is_numeric($price)) {
            if (!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)+/", $email)) {
                echo "<div class='errorbox'>" . $lng_languag["clientareaerroremailinvalid"] . "</div>";
            } else {
                $cur = $_SESSION["currency"]["code"];
                $adminmessage = "Name : " . $name . " <br> Email: " . $email . " <br> Price: " . $price . " " . $cur . " <br> Comments: " . $comment;
                sendNotification("system", "Suggested Price for " . $pro["service_name"], nl2br($adminmessage), "");
                echo "success:" . $lng_languag["senddetail"];
                exit;
            }
        }
    }
}
if ($department && $subject && $message) {
    $pri = mysqli_fetch_assoc(dquery("select * from tbl_support_priority where id='" . $priority . "'"));
    $dt = date("d-m-Y H:i:s");
    if (!isset($_SESSION["uid"])) {
        if ($email && $name) {
            if (!preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email)) {
                echo "error: <li>" . $lng_languag["clientareaerroremailinvalid"];
            } else {
                global $captcha;
                $captcha = md5($captcha);
                if ($captcha != $_SESSION["varify"]) {
                    echo "error: " . $lng_languag["wrongverify"];
                } else {
                    $ticket["subject"] = $subject;
                    $ticket["message"] = $message;
                    $tid = ticket("", "", "", $name, $email, $department, $priority, $ticket);
                    echo "success: " . $lng_languag["ticket"] . " " . $lng_languag["submitedsuccess"] . ":select";
                }
            }
        } else {
            echo "error: " . $lng_languag["filefield"];
        }
    } else {
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        global $_ClientsDetails;
        $email = $_ClientsDetails["email"];
        $ticket["subject"] = $subject;
        $ticket["message"] = $message;
        $tid = ticket("", $_ClientsDetails["id"], "", "", "", $department, $priority, $ticket);
        echo "success: " . $lng_languag["ticket"] . " " . $lng_languag["submitedsuccess"] . ":select";
    }
} else {
    echo "error: " . $lng_languag["filefield"];
}

?>