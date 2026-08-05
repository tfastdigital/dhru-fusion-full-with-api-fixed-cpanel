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
$currentpage = "testimonial";
$pagetitle = $lng_languag["testimonial"];
$link = _url("testimonial/addtestimonial/true");
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"" . _url("testimonial") . "\">" . $lng_languag["testimonial"] . "</a>";
$pageicon = "";
$templatefile = "testimonial";
installclient($pagetitle, $pageicon, $_nav);
global $cmslink;
if (!$config["testimonial"]) {
    $tempalte_ver["block"] = true;
    $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
    $fileverioncheck = "6.1.0";
    DisplayOutput("notallow");
    exit;
}
$allpagesquery = "SELECT * FROM tbl_testimonial  WHERE status='published' ";
for ($allpagesresult = dquery($allpagesquery); $allpagesrow = mysqli_fetch_assoc($allpagesresult); $i++) {
    $allpages[$i]["id"] = $allpagesrow["id"];
    $allpages[$i]["author"] = $allpagesrow["author"];
    $allpages[$i]["email"] = $allpagesrow["email"];
    if ($cmslink["testimonial"][$allpagesrow["id"]]) {
        $allpages[$i]["comment"] = nl2br($allpagesrow["comment"]) . "&nbsp; &nbsp; &nbsp;\n<span style='float: right;'><a target='_blank' href='" . $cmslink["testimonial"][$allpagesrow["id"]] . "'>Edit Page</a></span>";
    } else {
        $allpages[$i]["comment"] = nl2br($allpagesrow["comment"]);
    }
    $allpages[$i]["comment"] = html_entity_decode($allpages[$i]["comment"]);
    $allpages[$i]["date"] = $allpagesrow["date"];
}
$smarty->assign("allpages", $allpages);
$smarty->assign("link", $link);
if ($addtestimonial) {
    $tempalte_ver["author"] = "<input class='form-control' type='text' name='author' />";
    $tempalte_ver["email"] = "<input class='form-control' type='text' name='email' value='' />";
    $tempalte_ver["comment"] = "<textarea class='form-control' name='comment' rows='7' cols='50'></textarea>";
    $LoginCaptcha = NULL;
    include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
    $LoginCaptcha = createVerification("res");
    $tempalte_ver["captcha"] = "<span id='inputcaptcha_testimonial'><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' align='absbottom' /></span>\n            <input type='text' class='form-control' name='captcha'>";
    $tempalte_ver["action_link"] = "widget/save/testimonial?actions=save";
    $smarty->assign("addtestimonial", true);
}
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
if ($standalone) {
    echo processSingleTemplate($templatefile);
} else {
    DisplayOutput($templatefile);
}
class no
{
}

?>