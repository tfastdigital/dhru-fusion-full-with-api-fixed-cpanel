<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 284;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID,key_selling FROM tbl_products WHERE id='" . $id . "' "));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">API Connection</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["key"];
echo " ";
echo $LNG["selling"];
echo "</td>\n    <td class=\"fieldarea\">\n     <select name=\"key_selling\">\n     <option value=\"\">";
echo $LNG["none"];
echo "</option>\n            ";
$sql = dquery("select * from tbl_keygroup");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <option value=\"";
    echo $row["id"];
    echo "\"\n                ";
    if ($row["id"] == $serviceDetails["key_selling"]) {
        echo "selected";
    }
    echo ">";
    echo $row["group"];
    echo "</option>\n            ";
}
echo "     </select>\n     <small>Select Key group when user place order of this service if any key available from this group then user will get automatically reply of key</small>\n    </td>\n</tr>\n</tbody>\n</table>\n</div></div>\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnapiconnection\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnapiconnection','editproduct.api','#frmapi','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>