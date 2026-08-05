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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($mep && $apiid != "") {
    checkDemoMode(false);
    $data["mep"] = $mep;
    $data["api"] = $api;
    $data["apiid"] = $apiid;
    if ($db->update("tbl_mep", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_mep WHERE id='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"http://code.jquery.com/jquery-latest.min.js\"  type=\"text/javascript\"></script> <script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n  \n  <div class=\"groupstabescontant\">\n  \n<div id=\"content\">\n<div id=\"content_padded\" style=\"padding:20px\">\n\n<h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $cntr["mep"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  \n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mep"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"mep\" value=\"";
echo $cntr["mep"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"api\">\n<option value=\"\">";
echo $LNG["none"];
echo "</option>\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "<option value='";
    echo $rowapi["gateway"];
    echo "' ";
    if ($cntr["api"] == $rowapi["gateway"]) {
        echo "selected";
    }
    echo " >";
    echo $rowapi["value"];
    echo "</option>\n  ";
}
echo "    \n</select>   </td>\n</tr>\n\n<tr>\n    <td   class=\"fieldlabel\">";
echo $LNG["apiid"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" name=\"apiid\" value=\"";
echo $cntr["apiid"];
echo "\" /></td>\n</tr>\n\n \n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>