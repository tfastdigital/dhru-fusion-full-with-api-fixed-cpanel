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
if ($_SESSION["uid"]) {
    dquery("UPDATE `tblUsers` SET `online_status`='0' WHERE `id`= '" . $_SESSION["uid"] . "' ");
    unset($_SESSION["uid"]);
    unset($_SESSION["currency"]);
    unset($_SESSION["webview"]);
    unset($_SESSION["fromapp"]);
    unset($_SESSION["allcurrency"]);
    unset($_SESSION["askcaptcha"]);
    unset($_SESSION["CANACTIVE"]);
    unset($_SESSION["gtoken"]);
    unset($_SESSION["gstoken"]);
    unset($_SESSION["username"]);
    unset($_COOKIE["x-token"]);
    unset($_SESSION["USER_LAST_ACTIVITY"]);
    unset($_SESSION["user_livechat_username"]);
    unset($_SESSION["u_logintime_enc_key"]);
    unset($_SESSION["chatHistory"]);
    unset($_SESSION["currency"]);
    unset($_SESSION["afterloginredirect"]);
    unset($_SESSION["shippingzip"]);
    unset($_SESSION["shippingstate"]);
    unset($_SESSION["shippingcountry"]);
    $pagetitle = $lng_languag["logout"];
    $_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / " . "<a href=\"logout.php\">" . $lng_languag["logout"] . "</a>";
    $templatefile = "client_logout";
    $pageicon = "";
    if ($_SESSION["template"] != "app") {
        unset($_SESSION["template"]);
        $_SESSION["template"] = $config["template"];
    }
    $data = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1' "));
    $_SESSION["currency"] = $data;
    if ($config["logout_page_redirect"] != "") {
        header("Location: " . $config["logout_page_redirect"]);
        exit;
    }
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $fileverioncheck = "6.1.0";
    DisplayOutput($templatefile);
} else {
    header("Location: index");
}
chkMd5sumsubpage();
class no
{
}

?>