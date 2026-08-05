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
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["retail_info"] = html_entity_decode($tinyvalue);
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<form id=\"frmbrand\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"><tbody><tr>\n<td>";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "</td></tr>\n<tr><td class=\"fieldarea\">\n<textarea name=\"info\" id=\"message\">";
echo $imeiserviceDetails["retail_info"];
echo "</textarea></td></tr>\n</tbody></table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" \nonclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\"\n class=\"btn save\" type=\"submit\" name=\"save\"/></p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>