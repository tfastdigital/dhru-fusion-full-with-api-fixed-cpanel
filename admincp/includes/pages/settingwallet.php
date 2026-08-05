<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 32;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($config["addfundpoints"]) {
    $Groupwise = json_decode($config["addfundpoints"], true);
}
getAllCurrency();
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <form id=\"frm\" name=\"\" method=\"post\">\n            ";
echo generate_token("form");
echo "            <div  class=\"groupstabes\" >\n                <h2>\n                    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                    <span class=\"groupstabesheadertext\">";
echo $LNG["transfer"];
echo " ";
echo $LNG["settings"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                </h2>\n                <div class=\"groupstabescontant\">\n\n                    <table class=\"form\">\n\n                        <tr>\n                            <td class=\"fieldlabel\">";
echo $LNG["transfer"];
echo "  ";
echo $LNG["fee"];
echo "</td>\n                            <td class=\"fieldarea\">\n                              <input type=\"text\" name=\"walletfee\" class=\"\"\n                                     value=\"";
echo $config["walletfee"];
echo "\"\n                                     style=\"size: 10px !important;\" /> %\n                            </td>\n                        </tr>\n\n                    </table>\n\n\n                </div>\n            </div>\n\n\n\n\n        </form>\n        <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\n                                                  id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n                                                  onclick=\"SubmitForm ('#btnaddgroup','settingwallet','#frm','#notification','true','#main_loader');\"/></p>\n    </div></div>";
$fileverioncheck = "6.1.0";

?>