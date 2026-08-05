<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

ob_start();
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["retail_info"] = html_entity_decode($tinyvalue);
    if ($db->update("tbl_server_log", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
include_once ROOTDIR . "/includes/serverservices.fun.php";
$md5id = md5($id);
$serverserviceDetails = getServerServices("", $md5id);
echo "\n<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../js/jquery.js\"></script>\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<script type=\"text/javascript\" src=\"../3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "../3rdparty/editor/editor.php";
echo "<form id=\"frmbrand\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"><tbody><tr><td class=\"\">";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "</td></tr>\n<tr><td class=\"fieldarea\"><textarea name=\"info\" id=\"info\">";
echo $serverserviceDetails["retail_info"];
echo "</textarea></td></tr>\n</tbody></table>\n\n\n\n<p class=\"fixedbtn\"><input name=\"save\" value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('info').getContent();\" class=\"submit\" type=\"submit\" /></p>\n\n</form>\n";
$fileverioncheck = "6.1.0";

?>