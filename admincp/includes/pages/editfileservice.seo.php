<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include_once "../../../comm.php";
require_once "../../includes/fun.inc.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<script src=\"../js/jquery.js\" type=\"text/javascript\"></script>\n<script src=\"../js/jquery.ui.min.js\"></script>\n\n</head>\n<body>\n";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save && $seo_description) {
    checkDemoMode(false);
    $data["seo_title"] = $seo_title;
    $data["seo_description"] = $seo_description;
    $db->update("tbl_services_file", $data, "id=" . $id);
    echo "<div id='notification1' class='successbox'>" . $LNG["datasavesuccessfully"] . "</div>";
} else {
    if ($save) {
        echo "<div id='notification1' class='errorbox'>" . $LNG["description"] . " " . $LNG["fieldblank"] . "</div>";
    }
}
if ($autopost) {
    checkDemoMode(false);
    require_once "../../includes/twitter.fun.php";
    $md5id = md5($id);
    twitter_post($title . " " . $config["site_address"] . "productsandservices.php?currenttab=fileservice&action=file");
    echo "<div id='notification1' class='successbox'>" . $LNG["twitter"] . " " . $LNG["post"] . " " . $LNG["successfull"] . "</div>";
}
if ($autopostfacebook) {
    echo "<script>\nwindow.open('";
    echo $config["site_address"];
    echo $admindirpath;
    echo "/includes/facebook.php?autopost=true&id=";
    echo $id;
    echo "&service=";
    echo $service;
    echo "&link=";
    echo $link;
    echo "&grop_id=";
    echo $group_id;
    echo "','mywindow','width=500,height=300');\n</script> \n";
}
$sql = mysqli_fetch_assoc(dquery("select seo_title,service_name,group_id,seo_description from tbl_services_file where id='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" style=\"padding: 30px;\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["seo"];
echo " ";
echo $LNG["title"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"seo_title\" value=\"";
echo $sql["seo_title"];
echo "\" /><br />\n    <small>Leave blank to use Service Name as SEO title</small>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["seo"];
echo " ";
echo $LNG["description"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"seo_description\" class=\"textarea large\">";
echo $sql["seo_description"];
echo "</textarea>\n    </td>\n</tr>\n<tr>\n    <td>&nbsp;</td>\n    <td class=\"fieldarea\"><input type=\"submit\" name=\"save\" class=\"btn save\" value=\"";
echo $LNG["save"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n<br />\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"group_id\" value=\"";
echo $sql["group_id"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["twitter"];
echo " ";
echo $LNG["autopost"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"title\" value=\"New Product Added (";
echo $sql["service_name"];
echo ")\" />\n     </td>\n</tr>\n<tr>\n    <td>&nbsp;</td>\n    <td class=\"fieldarea\"><input type=\"submit\" class=\"btn save\" name=\"autopost\" value=\"";
echo $LNG["post"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n<br />\n<form id=\"frm\" name=\"\"  method=\"post\" >\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"service\" value=\"file\" />\n<input type=\"hidden\" name=\"group_id\" value=\"";
echo $sql["group_id"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">Facebook ";
echo $LNG["autopost"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt large\" name=\"title\" value=\"New Product Added (";
echo $sql["service_name"];
echo ")\" />\n     </td>\n</tr>\n<tr>\n    <td>&nbsp;</td>\n    <td class=\"fieldarea\"><input type=\"submit\" class=\"btn save\" name=\"autopostfacebook\" value=\"";
echo $LNG["post"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n</form>\n</body>\n</html>    ";
$fileverioncheck = "6.1.0";

?>