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
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<style>\n    .firstDiv.no-tab{margin:0}\n    #subpageiframe{top:0;}\n    .firstDiv.no-tab {\n        margin: 0;\n        position: absolute;\n        right: 0;\n        left: 0;\n        top: 0;\n        bottom: 0;\n        height: 100%;\n    }\n</style>\n</head>\n<body>\n";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["info"] = html_entity_decode($tinyvalue);
    if ($db->update("tbl_services_file", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/fileservices.fun.php";
$md5id = md5($id);
$fileserviceDetails = getFileServices("", $md5id);
echo "\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<form id=\"frmbrand\" name=\"\" method=\"post\" class=\"full-editor\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n";
echo generate_token("form");
echo "\n <textarea name=\"info\" id=\"message\">";
echo $fileserviceDetails["info"];
echo "</textarea> \n\n\n<p class=\"fixedbtn\"><input class=\"btn save\" value=\"";
echo $LNG["save"];
echo "\" name=\"save\" id=\"btnedituser\" onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\" class=\"submit\" type=\"submit\" /></p>\n\n</form>\n</body>\n</html>";
$fileverioncheck = "6.1.0";

?>