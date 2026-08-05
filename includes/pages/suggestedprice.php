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
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/mail.fun.php";
$currentpage = "Suggest Price";
$pagetitle = "Suggested Price";
$templatefile = "suggestedprice";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$_serviceid = preg_replace("/[^0-9]/i", "", $_serviceid);
$pro = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $_serviceid . "'"));
$tempalte_ver["serviceid"] = $_serviceid;
$tempalte_ver["product"] = $pro["service_name"];
if (isset($send)) {
    if ($name != "" && $email != "" && $price != "") {
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
                    echo "<div class='successbox'>" . $lng_languag["senddetail"] . "</div>";
                }
            }
        }
    } else {
        echo "<div class='errorbox'>" . $lng_languag["blankfield"] . "</div>";
    }
}
if (!$uid) {
    $tempalte_ver["captcha"] = "<img src='widget/verificationimage.php' alt='verification image, type it in the box' align='absbottom' />\n            <input type='text' class='form-control' name='captcha'>";
}
$tempalte_ver["_serviceid"] = $_serviceid;
chkMd5sumsubpage();
echo processSingleTemplate($templatefile);
class no
{
}

?>