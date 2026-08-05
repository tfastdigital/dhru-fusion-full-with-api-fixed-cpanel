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
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
if ($config["support_email"] != "" && !$storeowner["id"]) {
    header("Location: " . $config["site_address"] . "/support.php?step=2&department=" . $config["support_email"] . "&parentid=1004");
}
$currentpage = "contact";
$pagetitle = $lng_languag["contact"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"contact.php\">" . $lng_languag["contact"] . "</a>";
$templatefile = "w_contactus";
$item = preg_replace("/[^0-9a-zA-Z]/i", "", $item);
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if (isset($_SESSION["WLANG"])) {
    $lang = $_SESSION["WLANG"];
} else {
    $lang = $config["language"];
}
$lang = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $lang);
$cont = mysqli_fetch_assoc(dquery("select content  from tbl_custom_page where type='contact' and language='" . $lang . "'"));
$tempalte_ver["content"] = htmlspecialchars_decode($cont["content"]);
if (!$config["contactus"]) {
    $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
    echo processSingleTemplate($templatefile);
    exit;
}
if (isset($_SESSION["uid"])) {
    $_MAIL = "value='" . $_ClientsDetails["email"] . "' readonly=''";
    if ($_ClientsDetails["firstname"] || $_ClientsDetails["lastname"]) {
        $_NAME = "value='" . $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"] . "' readonly=''";
    }
}
if ($item != "") {
    $s = dquery("select id,service_name from tbl_products where md5(id)='" . $item . "'");
    if (mysqli_num_rows($s)) {
        $pagetitle = $lng_languag["callforpricing"] . " - " . $lng_languag["inquiry"];
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $s = mysqli_fetch_assoc($s);
        $smarty->assign("itemname", $s["service_name"]);
        $smarty->assign("inquiry", $item);
    } else {
        header("Location: index.php");
    }
}
$smarty->assign("name", "<input type='text' name='name' " . $_NAME . " />");
$smarty->assign("email", "<input type='text' name='email' " . $_MAIL . " >");
$smarty->assign("query", "<textarea name='query' cols='50' rows='5'></textarea>");
$smarty->assign("action_link", "includes/contact.send.php");
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$customfields = getCustomFields("contactus", "", $userid, "on");
foreach ($customfields as $value) {
    $tempalte_ver["customfields"][$value["name"]] = $value;
}
if (!$uid) {
    $tempalte_ver["captcha"] = "<img src='widget/verificationimage.php' alt='verification image, type it in the box' align='absbottom' />\r\n            <input type='text' name='captcha'>";
}
echo processSingleTemplate($templatefile);

?>