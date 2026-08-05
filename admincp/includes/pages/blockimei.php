<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 167;
checkPagePermission($pageid);
echo "\r\n    <div id=\"notification\"></div>\r\n\r\n    <div id=\"content\" style=\"width: 100%;!important \">\r\n    <div id=\"content_padded\" style=\"width: 100%;!important \">\r\n\r\n\r\n        <div  class=\"groupstabes\" >\r\n            <h2>\r\n                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\r\n                <span class=\"groupstabesheadertext\">Add IMEIs</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n            </h2>\r\n            <div class=\"groupstabescontant\">\r\n                <form method=\"post\" id=\"frms\">\r\n                    <table class=\"form\">\r\n                        <tbody>\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">";
echo $LNG["add"];
echo " IMEI </td>\r\n                            <td class=\"fieldarea\"><textarea name=\"imei\" style=\"height: 150px;\" rows=\"5\"></textarea>\r\n                                <small>each imei new line e.g. 111111111111119#REASON </small> </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td class=\"fieldlabel\">IMEI ";
echo $LNG["service"];
echo " </td>\r\n                            <td class=\"fieldarea\">\r\n                                <select name=\"imeiservice\" class=\"chosen\">\r\n                                    <option value=\"\">";
echo $LNG["select"];
echo "</option>\r\n                                    ";
$q = dquery("select id,service_name from tbl_services_imei where useasserver=0 order by service_name asc");
while ($r = mysqli_fetch_assoc($q)) {
    echo "                                        <option value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["service_name"];
    echo "</option>\r\n                                        ";
}
echo "                                </select>\r\n                            </td>\r\n                        </tr>\r\n                        </tbody></table>\r\n                    <p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\r\n    onclick=\"SubmitForm('#btnaddgroup','blockimei','#frms','#notification','true','#main_loader','','',1);\"/></p>\r\n                </form>\r\n            </div></div>\r\n\r\n\r\n    </div>\r\n    </div>";
$fileverioncheck = "6.1.0";

?>