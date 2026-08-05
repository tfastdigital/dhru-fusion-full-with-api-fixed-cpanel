<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
ob_start();
require_once "includes/fun.inc.php";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>  \n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n\n\n<script  type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "includes/3rdparty/editor/editor.php";
echo "</head>\n<body>\n";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["info"] = html_entity_decode($tinyvalue);
    if ($db->update("tbl_server_log", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/serverservices.fun.php";
$md5id = md5($id);
$serverserviceDetails = getServerServices("", $md5id);
echo "\n<form id=\"frmbrand\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"><tbody><tr><td class=\"fieldlabel\">";
echo $LNG["information"];
echo "</td>\n<td class=\"fieldarea\"><textarea name=\"info\" id=\"message\">";
echo $serverserviceDetails["info"];
echo "</textarea></td></tr>\n</tbody></table>\n\n\n\n<p class=\"fixedbtn\"><input class=\"btn save\" value=\"";
echo $LNG["save"];
echo "\" name=\"save\" id=\"btnedituser\" onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\" class=\"submit\" type=\"submit\" /></p>\n\n</form>\n</body>\n</html>\n";
$fileverioncheck = "6.1.0";

?>