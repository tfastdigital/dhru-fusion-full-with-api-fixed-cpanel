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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($Name && $apiid && $C_ID) {
    checkDemoMode(false);
    $data["Name"] = $Name;
    $data["api"] = $api;
    $data["C_ID"] = $C_ID;
    $data["apiid"] = $apiid;
    $data["mep_new"] = $mep_new;
    $data["mep_old"] = $mep_old;
    if ($db->update("tbl_provider", $data, "id='" . $id . "'")) {
        echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$cntr = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_provider WHERE ID='" . $id . "'"));
if ($other) {
    $cntr["api"] = $other;
}
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/js/x-main2.fun.js\" language=\"javascript\"></script>\n<div id=\"notification\"></div>\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $cntr["Name"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"api\" onchange=\"javascript:location.href='main2.php?page=editprovider&id=";
echo $id;
echo "&tiptop=true&other='+this.value\">\n<option value=\"\">";
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
echo "    \n</select> &nbsp; <a href=\"#\" data-target=\"apisetting\" data-target-header=\"";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "</a>  </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["provider"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"Name\" value=\"";
echo $cntr["Name"];
echo "\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"C_ID\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
$api = dquery("select * From tbl_provider_country WHERE api='" . $cntr["api"] . "'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "   <option value='";
    echo $rowapi["ID"];
    echo "' ";
    if ($cntr["C_ID"] == $rowapi["ID"]) {
        echo "selected";
    }
    echo " >\n   ";
    echo $rowapi["Name"];
    echo "</option>\n    ";
}
echo "    \n</select>    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["apiid"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"apiid\" value=\"";
echo $cntr["apiid"];
echo "\" /></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mepnew"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"mep_new\" value=\"";
echo $cntr["mep_new"];
echo "\" /></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["mepold"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"mep_old\" value=\"";
echo $cntr["mep_old"];
echo "\" /></td>\n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"submit\" />\n</div>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>