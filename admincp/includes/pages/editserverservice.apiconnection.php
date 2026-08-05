<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 263;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID,key_selling FROM tbl_server_log WHERE id='" . $id . "' "));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">API Connection</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["connect"];
echo " ";
echo $LNG["api"];
echo "</td>\n    <td class=\"fieldarea\">";
echo apiServerDropdown($serviceDetails["API"], "API");
echo "</td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["services"];
echo "</td>\n    <td class=\"fieldarea\"><div id=\"apiservicedropdown\" style=\"display: none;\"></div><span id=\"onloadapiservicedropdown\">";
echo apiServicesDropdown($serviceDetails["API"], $serviceDetails["API_ID"], "API_ID");
echo "</span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["key"];
echo " ";
echo $LNG["selling"];
echo "</td>\n    <td class=\"fieldarea\">\n     <select name=\"key_selling\">\n            <option value=\"\">";
echo $LNG["none"];
echo "</option>\n            ";
$sql = dquery("select * from tbl_keygroup");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <option value=\"";
    echo $row["id"];
    echo "\" ";
    if ($row["id"] == $serviceDetails["key_selling"]) {
        echo "selected";
    }
    echo ">";
    echo $row["group"];
    echo "</option>\n            ";
}
echo "        </select>\n    </td>\n</tr>\n</tbody>\n</table>\n\n</div></div>\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnapiconnection\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnapiconnection','editserverservice.apiconnection','#frmapi','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>