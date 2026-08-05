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
$currentpage = "support";
$pagetitle = $lng_languag["support"] . " " . $lng_languag["ticket"];
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"" . _url("support") . "\">" . $lng_languag["support"] . " " . $lng_languag["ticket"] . "</a>";
$templatefile = "support";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$step = preg_replace("/[^0-9]/i", "", $step);
$department = preg_replace("/[^0-9a-z-\\_]/i", "", $department);
if (isset($_SESSION["WLANG"])) {
    $lang = $_SESSION["WLANG"];
} else {
    $lang = $config["language"];
}
$lang = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $lang);
$cont = mysqli_fetch_assoc(dquery("select content  from tbl_custom_page where type='contact'\nand language='" . $lang . "'"));
$tempalte_ver["content"] = htmlspecialchars_decode($cont["content"]);
$smarty->assign("step", 1);
if ($step == 2) {
    $smarty->assign("step", 2);
    if ($department) {
        $_SESSION["department"] = $department;
    }
    $smarty->assign("department", "<input type='hidden' name='department' value='" . $_SESSION["department"] . "'>");
    $smarty->assign("subject", "<input type='text'  class='form-control'  name='subject'>");
    if (!isset($_SESSION["uid"])) {
        $smarty->assign("name", "<input type='text'  class='form-control' placeholder='" . $lng_languag["name"] . "'  name='name'>");
        $smarty->assign("email", "<input type='text'  class='form-control' placeholder='" . $lng_languag["email"] . "'  name='email'>");
    } else {
        global $_ClientsDetails;
        $smarty->assign("name", $_ClientsDetails["firstname"] . " " . $_ClientsDetails["lastname"]);
        $smarty->assign("email", $_ClientsDetails["email"]);
    }
    $smarty->assign("message", "<textarea name='message' class='form-control h-100' cols='50' rows='5' onkeyup='getKnowledgebaseSearch(this.value);'></textarea>");
    $smarty->assign("action_link", "widget/save/support");
    $sql = dquery("select * from tbl_support_priority");
    while ($row = mysqli_fetch_assoc($sql)) {
        $priority[$row["id"]] = $row["priority"];
    }
    $smarty->assign("priority", $priority);
    if (!isset($_SESSION["uid"])) {
        include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
        $LoginCaptcha = createVerification("support");
        $tempalte_ver["captcha"] = "<span id='inputcaptcha_support'><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n            <input type='text' class='form-control' name='captcha'>";
    }
} else {
    if (!isset($_SESSION["uid"])) {
        $where = " where login=0";
    } else {
        $where = " where 1=1";
    }
    $where .= " and status='1'";
    $sql = dquery("select * from tbl_support_department " . $where);
    if (mysqli_num_rows($sql)) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $row["seo"] = _url("support/step/2/department/" . $row["id"]);
            $departmentf[$row["id"]] = $row;
        }
        $smarty->assign("department", $departmentf);
        $smarty->assign("action_link", _url("support/step/2"));
    } else {
        $templatefile = "client_accessdenied";
        $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
    }
}
$tempalte_ver["voucher"] = $config["voucher"];
if (!$uid) {
    include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
    $LoginCaptcha = createVerification("support");
    $tempalte_ver["captcha"] = "<span id='inputcaptcha_support'><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n                <input type='text' class='form-control' name='captcha'>";
}
if (!$config["supportticketservice"]) {
    $templatefile = "client_accessdenied";
    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
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