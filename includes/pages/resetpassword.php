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
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "resetpassword";
$_nav = "<a href=\"" . _url("main") . "\">" . $lng_languag["resetpassword"] . "</a> / ";
$pagetitle = $lng_languag["resetpassword"];
$_nav .= "<a href='" . _url("resetpassword") . "' >" . $lng_languag["resetpassword"] . "</a> / ";
$templatefile = "client_resetpass";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if (isset($user) && isset($access)) {
    $id = descape(base64_decode($user));
    $access = descape(base64_decode($access));
    $id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
    $access = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $access);
    $sql = dquery("SELECT `id` FROM `tblUsers` WHERE MD5(id)='" . $id . "' \n    AND `reset_key`='" . $access . "' AND `reset_key`!=''");
    if (mysqli_num_rows($sql) == 1) {
        $tempalte_ver["newpassword"] = "<input class='form-control' type='password' name='password' value='' />";
        $tempalte_ver["confirmation"] = "<input  class='form-control'  type='password' name='confirmation' value='' />";
        $_SESSION["__PASS_ACCESS"] = $access;
        $_SESSION["__PASS_USER_ID"] = $id;
        $_SESSION["__PASS_ACTIION"] = "password";
        $tempalte_ver["action_link"] = "widget/save/resetpassword";
        $tempalte_ver["requiredusername"] = 1;
    } else {
        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
        $templatefile = "client_accessdenied";
    }
} else {
    if (isset($_SESSION["required_question"])) {
        $user = $_SESSION["required_question"];
        $sql = mysqli_fetch_assoc(dquery("SELECT `question_id` FROM `tblUsers` WHERE username='" . $user . "' "));
        $sql = mysqli_fetch_assoc(dquery("SELECT `question` FROM `tbl_security_question` WHERE id='" . $sql["question_id"] . "' "));
        $tempalte_ver["question"] = $sql["question"] . "<input type='hidden' name='question' value ='" . $qid . "'>";
        $tempalte_ver["answer"] = "<input type='text'  class='form-control'  name='answer' value='' />";
        $_SESSION["__PASS_ACTIION"] = "sendlink";
        $tempalte_ver["action_link"] = "widget/save/resetpassword";
    } else {
        $_SESSION["__PASS_ACTIION"] = "reset";
        $tempalte_ver["username"] = "<input type='text'  class='form-control'  name='users' value='' />";
        $tempalte_ver["action_link"] = "widget/save/resetpassword";
    }
}
if ($standalone) {
    $tempalte_ver["standalone"] = true;
    echo processSingleTemplate($templatefile);
    exit;
}
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>