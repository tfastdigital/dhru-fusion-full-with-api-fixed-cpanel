<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

ob_start();
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<style>\n    .firstDiv.no-tab{margin:0}\n    #subpageiframe{top:0;}\n    .firstDiv.no-tab {\n        margin: 0;\n        position: absolute;\n        right: 0;\n        left: 0;\n        top: 0;\n        bottom: 0;\n        height: 100%;\n    }\n</style>\n</head>\n<body>\n";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["info"] = html_entity_decode($tinyvalue);
    $data["acceptterms"] = $acceptterms;
    if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "\n<script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<form id=\"frmbrand\" name=\"\" method=\"post\" class=\"full-editor\">\n<div id=\"notification\"></div>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" base64encode=\"true\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n";
echo generate_token("form");
echo "     <div style=\"padding: 10px;\">\n        <input type=\"checkbox\"\n            ";
if ($imeiserviceDetails["acceptterms"]) {
    echo "checked='checked'";
}
echo "               name=\"acceptterms\" value=\"1\" />\n        <label>Accept Terms & Conditions on place order</label>\n\n    </div>\n</form>\n<br/><br/><br/>\n\n <textarea name=\"info\"  \nid=\"message\">";
echo $imeiserviceDetails["info"];
echo "</textarea>\n \n\n \n<p class=\"fixedbtn\">\n    <button name=\"submit\" value=\"submit\" id=\"btnedituser2\" class=\"btn save\"\n    onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();SubmitFormNew('#btnedituser2','editimeiservice.info','#frmbrand','#notification','true','#main_loader');\">";
echo $LNG["save"];
echo " </button>\n\n\n</p>\n\n\n</body>\n</html>";
$fileverioncheck = "6.1.0";
echo "\n";

?>