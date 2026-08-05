<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n";
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../comm.php";
require_once "../includes/fun.inc.php";
require ROOTDIR . "/includes/countries.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (isset($save)) {
    checkDemoMode(false);
    $data["language"] = $language;
    if ($db->update("tbl_country_language", $data, "country_id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . "</div>";
    }
}
echo "\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Country Language</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<form id=\"frmcountrylanguage\" name=\"\" method=\"post\">\n<table class=\"form\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n<tr><td class=\"fieldlabel\"><span>";
echo $countries[$id];
echo "</span></td><td class=\"fieldarea\"><span>";
echo getLanguageDropdown2($lid);
echo "</span></td> \n<tr><td  class=\"fieldlabel\"></td><td class=\"fieldarea\"><span><input value=\"";
echo $LNG["save"];
echo "\" id=\"countylanguage\" class=\"btn save\" name=\"save\" type=\"submit\" /></span></td></tr> \n</td></tr>\n</table>\n</form>\n</div></div> \n";
$fileverioncheck = "6.1.0";

?>