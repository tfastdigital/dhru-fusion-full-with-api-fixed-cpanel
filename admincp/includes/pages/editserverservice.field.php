<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script src=\"includes/js/jquery.ui.min.js\"></script>\n<link href=\"includes/css/ui/style.css\" rel=\"stylesheet\"/>\n<script>\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editserverservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n        \$(\"#\"+cid).hide();\n    }\n}\n\$(document).ready(function(){\n\t\$(\".toggle_container\").hide();\n\t\$(\"input.trigger\").click(function(){\n\t\t\$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n\t});\n});\n\n\n</script>\n\n";
$pageid = 273;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_server_log WHERE id='" . $id . "' "));
include_once ROOTDIR . "/includes/serverservices.fun.php";
$md5id = md5($id);
$serverserviceDetails = getServerServices("", $md5id);
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("serviceserver", $id);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<div class=\"groupstabes\"  style=\"position: relative;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Extra Fields</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " ";
echo $LNG["qnt"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"checkbox\"\n    class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\"\n    id=\"active\" name=\"qnt\" value=\"1\"\n    ";
if ($serverserviceDetails["qnt"] == "1") {
    echo "checked";
}
echo "/>\n    <label for=\"active\"></label></span>\n    </td>\n</tr>\n</table>\n  </div>\n</div>\n\n<div class=\"groupstabes\"  style=\"position: relative;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Custome Fields</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\">\n<thead>\n<tr>\n<th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n<th>";
echo $LNG["name"];
echo "</th>\n<th>";
echo $LNG["description"];
echo "</th>\n<th>";
echo $LNG["fieldoptions"];
echo "</th>\n<th>";
echo $LNG["validation"];
echo "</th>\n<th>";
echo $LNG["required"];
echo "</th>\n<th align=\"right\">";
echo $LNG["action"];
echo "</th>\n</tr>\n</thead>\n\n\n    <tr  class=\"adddatarow nocheckboxchecked\">\n        <input type=\"hidden\" value=\"serviceserver\" name=\"customfield[-1][type]\"/>\n        <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n        <td><select class=\"customfield\" name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"radio\">";
echo $LNG["radio"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option></select></td>\n        <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/> * </td>\n        <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n        <td><input  class='fieldoptions' name=\"customfield[-1][fieldoptions]\" disabled=\"disabled\" value=\"\" type=\"text\"/><br /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n        <td><input  class='regexpr' name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\" /><br />  <small>";
echo $LNG["regularexpression"];
echo "  <a href=\"javascript:void(0)\">Help</a> </small></td>\n        <td><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\" type=\"checkbox\" /> <label for=\"required\"></label></td>\n        <td><span class=\"datagridbtn\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"button add\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','editserverservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editserverservice.field','";
echo $id;
echo "');\"/> </span> </td>\n    </tr>\n\n";
if ($row) {
    foreach ($row as $key => $value) {
        echo "    <tr class=\"nocheckboxchecked\" id=\"";
        echo $key;
        echo "\">\n        <td>";
        echo $row[$key]["fieldtype"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldname"];
        echo "</td>\n        <td>";
        echo $row[$key]["description"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldoptions"];
        echo "</td>\n        <td>";
        echo $row[$key]["regexpr"];
        echo "</td>\n        <td>";
        echo $row[$key]["required"];
        echo "</td>\n        <td align=\"right\"><div align=\"right\"><input value=\"";
        echo $LNG["delete"];
        echo "\" id=\"";
        echo $key;
        echo "\" class=\"button delete deletedata\" type=\"button\"  onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></div> </td>\n    </tr>\n    ";
    }
}
echo "</table>\n\n  </div>\n</div>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editserverservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editserverservice.field','";
echo $id;
echo "');\"/></p>\n\n</div>\n</div>\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>