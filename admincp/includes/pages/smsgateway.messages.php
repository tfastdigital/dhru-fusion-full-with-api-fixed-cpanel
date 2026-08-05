<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n\n</style>\n";
licince\reqaddon("SMS");
$pageid = 549;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["message"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\" >\n<tbody>\n";
$req = dquery("SELECT * FROM tbl_smstemplate");
while ($data = mysqli_fetch_assoc($req)) {
    echo "  <tr><td><a class='default_dg_a2'\n   href=\"javascript:load_subpage('main2.php?page=smstemplate.edit&id=";
    echo $data["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["template"];
    echo "')\">";
    echo $data["name"];
    echo "</a></td><td>\n  <div align=\"right\" ><a class='default_dg_a2 editdata'\n   href=\"javascript:load_subpage('main2.php?page=smstemplate.edit&id=";
    echo $data["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["template"];
    echo "')\">";
    echo $LNG["edit"];
    echo " </a></div></td></tr>\n  ";
}
echo "</tbody>\n</table></div></div>\n</div></div>";
$fileverioncheck = "6.1.0";

?>