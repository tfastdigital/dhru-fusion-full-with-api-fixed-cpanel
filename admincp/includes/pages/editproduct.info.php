<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

ob_start();
echo "\n<script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n\n";
if (is_file("includes/fun.inc.php")) {
    require_once "includes/fun.inc.php";
} else {
    define("DEFINE_MY_ACCESS", true);
    define("DEFINE_DHRU_FILE", true);
    define("ADMIN", true);
    require_once "../../../comm.php";
    require_once "../../../includes/fun.inc.php";
    require_once "../../includes/fun.inc.php";
    if (!checkAdminlogin() || !$_SESSION["adminid"]) {
        echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
        $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
        exit;
    }
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n<style>\n    .firstDiv.no-tab{margin:0}\n    #subpageiframe{top:0;}\n    .firstDiv.no-tab {\n        margin: 0;\n        position: absolute;\n        right: 0;\n        left: 0;\n        top: 0;\n        bottom: 0;\n        height: 100%;\n    }\n</style>\n</head>\n<body>\n";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id='notification' class='errorbox'> This function not enabled in demo mode .</div>";
        exit;
    }
    $data["short_info"] = html_entity_decode($shortvalue);
    $data["retail_info"] = html_entity_decode($tinyvalue);
    if ($db->update("tbl_products", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
echo "\n<script  type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<form id=\"frmbrand\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<input type=\"hidden\" value=\"\" name=\"shortvalue\" id=\"shortvalue\"/>\n";
echo generate_token("form");
echo "\n \n \n <div style=\"padding: 10px;\">\n ";
echo $LNG["short"];
echo " ";
echo $LNG["information"];
echo " (<small>";
echo $LNG["seonote"];
echo "</small>)\n\n <textarea style=\"height: 50 !important;\" rows=\"4\" name=\"short_info\" id=\"short_info\">\n ";
echo $productDetails["short_info"];
echo "</textarea> \n </div>\n \n \n \n  <div style=\"padding: 10px;\"> ";
echo $LNG["information"];
echo "  \n   <textarea name=\"info\" id=\"message\">";
echo $productDetails["retail_info"];
echo "</textarea>\n </div>   \n \n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" name=\"save\" class=\"btn save\"\n onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('message').getContent();\n document.getElementById('shortvalue').value=tinyMCE.get('short_info').getContent();\n\t \" class=\"submit\" type=\"submit\" /></p>\n\n</form>\n<br /><br />\n</body>\n</html>\n";
$fileverioncheck = "6.1.0";

?>