<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 167;
checkPagePermission($pageid);
echo "\n<div id=\"notification\"></div>\n\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add IPs</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<form method=\"post\" id=\"frms\">\n<table class=\"form\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["ip"];
echo " </td>\n<td class=\"fieldarea\"><textarea name=\"ips\" style=\"height: 150px;\" rows=\"5\"></textarea> <small>";
echo $LNG["iplistmessage"];
echo "</small> </td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["country"];
echo " </td>\n<td class=\"fieldarea\">";
echo getCountriesDropDown(" ");
echo " </td>\n</tr>\n</tbody></table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','blockedip','#frms','#notification','true','#main_loader');\"/></p>\n</form>\n</div></div>\n\n<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th>";
echo $LNG["ip"];
echo "/";
echo $LNG["country"];
echo "</th>\n        <th>";
echo $LNG["reason"];
echo " </th>\n        <th><div align=\"right\">";
echo $LNG["action"];
echo "</div> </th>\n\n  </tr>\n</thead>\n<tbody>\n\n\n";
if (isset($delete)) {
    dquery("delete from tbl_bannedips where id='" . $id . "'");
}
$bann = dquery("SELECT * FROM tbl_bannedips");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "        <tr>\n        <td>";
    echo $row["ip"];
    echo " ";
    if ($row["country"]) {
        echo "       <img style=\"vertical-align: middle;\" src=\"images/flags/";
        echo strtolower($row["ip"]);
        echo ".png\" alt=\"";
        echo $row["ip"];
        echo "\" border=\"0\" />\n       ";
    }
    echo "       </td>\n        <td>";
    echo $row["reason"];
    echo "</td>\n        <td align=\"right\">\n        <form method=\"post\"><input type=\"hidden\" name=\"id\" value=\"";
    echo $row["id"];
    echo "\" />\n        <input type=\"submit\" onclick=\"return confirm('Are you sure want to Remove ?');\"  name=\"delete\" class=\"button deletedata\" value=\"";
    echo $LNG["delete"];
    echo "\" />\n        </form> </td>\n\n    </tr>\n\n    ";
}
echo "</tbody></table>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>