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
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "testimonial";
$pagetitle = $lng_languag["testimonial"];
if ($config["cms_seofriendly"] == "on") {
    $link = "<a href='add-testimonial.html' style='text-decoration:none;'>" . $lng_languag["your"] . " " . $lng_languag["testimonial"] . "</a>";
} else {
    $link = "<a href='testimonial.php?addtestimonial=true' style='text-decoration:none;'>" . $lng_languag["your"] . " " . $lng_languag["testimonial"] . "</a>";
}
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a> / ";
$_nav .= "<a href=\"testimonial.php\">" . $lng_languag["testimonial"] . "</a>";
$pageicon = "";
$templatefile = "testimonial";
installclient($pagetitle, $pageicon, $_nav);
if (!$config["testimonial"]) {
    $tempalte_ver["block"] = true;
    $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
    output($templatefile);
    exit;
}
$allpagesquery = "SELECT * FROM tbl_testimonial  WHERE status='published' ";
for ($allpagesresult = dquery($allpagesquery); $allpagesrow = mysqli_fetch_assoc($allpagesresult); $i++) {
    $allpages[$i]["id"] = $allpagesrow["id"];
    $allpages[$i]["author"] = $allpagesrow["author"];
    $allpages[$i]["email"] = $allpagesrow["email"];
    $allpages[$i]["comment"] = nl2br($allpagesrow["comment"]);
    $allpages[$i]["date"] = $allpagesrow["date"];
}
$smarty->assign("allpages", $allpages);
$smarty->assign("link", $link);
if ($addtestimonial) {
    $tempalte_ver["author"] = "<input type='text' name='author' />";
    $tempalte_ver["email"] = "<input type='text' name='email' value='' />";
    $tempalte_ver["comment"] = "<textarea name='comment' rows='7' cols='50'></textarea>";
    $tempalte_ver["captcha"] = "<img src='widget/verificationimage.php?res' alt='verification image, type it in the box' align='absbottom' />\n\n            <input type='text' name='captcha'>";
    $tempalte_ver["action_link"] = "includes/getdata/testimonial.save.php?action=save";
    $smarty->assign("addtestimonial", true);
}
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);

?>