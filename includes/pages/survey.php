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
$survey = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $survey);
$s = mysqli_fetch_assoc(dquery("select title from tbl_survey where md5(id)='" . $survey . "'"));
$currentpage = "survey";
$pagetitle = $lng_languag["survey"] . " - " . $s["title"];
$_nav = "<a href='index.php'>" . $lng_languag["home"] . " </a> / ";
$_nav .= "<a href='survey.php?survey=" . $survey . "' >" . $lng_languag["survey"] . "</a> / ";
$templatefile = "client_survey";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$sur = dquery("select * from tbl_survey where md5(id)='" . $survey . "' and status='0'");
if (mysqli_num_rows($sur)) {
    $sur = mysqli_fetch_assoc($sur);
    $tempalte_ver["title"] = $sur["title"];
    $tempalte_ver["detail"] = $sur["detail"];
    $tempalte_ver["ids"] = $survey;
    if (!function_exists("getCustomFields")) {
        require ROOTDIR . "/includes/customfield.fun.inc.php";
    }
    $customfields = getCustomFields("survey_" . $sur["id"], "", $userid, "on");
    foreach ($customfields as $value) {
        $tempalte_ver["customfields"][$value["name"]] = $value;
    }
    if ($sur["captcha"]) {
        $tempalte_ver["captcha"] = "<img src='widget/verificationimage.php'\n             alt='verification image, type it in the box' align='absbottom' />\n                    <input type='text' name='captcha'>";
    }
} else {
    $templatefile = "client_accessdenied";
    $tempalte_ver["notification"]["info"] = $lng_languag["survey"] . " " . $lng_languag["completed"] . ". " . $lng_languag["thankyou"];
}
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>