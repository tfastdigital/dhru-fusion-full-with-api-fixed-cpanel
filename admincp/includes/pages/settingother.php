<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$html = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='htmlcode'"));
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<script>\nfunction converttoBase64()\n{\n    \$(\"#otherhtmlcode\").val( window.btoa( \$('#otherhtmlcode').val().trim() ) );\n    setTimeout(function(){ \$(\"#otherhtmlcode\").val(\n       window.atob(\$('#otherhtmlcode').val().trim()) );\n    }, 2000);\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n\n\n\n";
echo generate_token("form");
$verioninfo = initCurl("http://broadcast.dhru.com/");
$verioninfo = new SimpleXMLElement($verioninfo);
$verioninfo = (array) $verioninfo;
$verioninfo = (array) $verioninfo["geodatabse"];
if ($verioninfo["date"] != $config["geodate"]) {
    echo "\n     <div  class=\"groupstabes first\" >\n         <h2>\n             <span class=\"groupstabesheadertext\">Other</span>\n         </h2>\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr><td class=\"fieldlabel\">&nbsp;</td><td class=\"fieldarea\">\n <div id=\"notification1\" class=\"alert\">";
    echo $LNG["updatefoundforgeo"];
    echo "   <a href=\"javascript:SubmitForm ('#btnaddgroup','settinggeo','#frm','#notification','true','#main_loader');\">";
    echo $LNG["click"];
    echo " ";
    echo $LNG["here"];
    echo "</a> ";
    echo $LNG["to"];
    echo " ";
    echo $LNG["update"];
    echo ".\n   </div>\n</td>\n</tr>\n</tbody>\n</table>\n\n    </div>\n";
}
if (in_array(527, explode(",", $_SESSION["page_access"]))) {
    echo "<div class=\"groupstabes first\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
    echo $LNG["export"];
    echo " to Excel</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n            <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n            <input value=\"";
    echo $LNG["export"];
    echo " ";
    echo $LNG["client"];
    echo " to Excel\"\n            id=\"btnaddgroup\" onclick=\"javascript: location.href='includes/download.php?exportclient=1'\" class=\"btn\" type=\"button\"  />  &nbsp; &nbsp;\n            <input value=\"";
    echo $LNG["export"];
    echo " ";
    echo $LNG["statement"];
    echo "  to Excel\"\n            onclick=\"javascript: location.href='includes/download.php?exportstatement=1'\"\n            id=\"btnaddgroup\" class=\"btn\" type=\"button\"  />\n            </td>\n            </tr>\n        </table>\n    </div>\n</div>\n";
}
echo "\n    <!--\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Dhru Avatar APi</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n            <tr>\n            <td class=\"fieldlabel\">Dhru APi ";
echo $LNG["key"];
echo " for Avatar</td><td class=\"fieldarea\">\n            <input type=\"text\" value=\"";
echo $config["avatarapi"];
echo "\"\n            name=\"avatarapi\" class=\"txt large\"/></td>\n            </tr>\n        </table>\n    </div>\n</div>\n-->\n    <!--\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">GCM ";
echo $LNG["notification"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n            <tr><td class=\"fieldlabel\">Dhru APi ";
echo $LNG["key"];
echo " for GCM</td><td class=\"fieldarea\">\n                <input type=\"text\" value=\"";
echo $config["gcmapikey"];
echo "\"\n                name=\"gcmapikey\" class=\"txt large\"/></td>\n            </tr>\n            <tr><td class=\"fieldlabel\">GCM ";
echo $LNG["notification"];
echo "s</td><td class=\"fieldarea\">\n                <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n                name=\"gcmnotification\" value=\"1\" id=\"see\" ";
if ($config["gcmnotification"] == "1") {
    echo "checked";
}
echo " /><label for=\"gse\"></label>\n            </td>\n            </tr>\n        </table>\n    </div>\n</div>\n-->\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["google"];
echo " ";
echo $LNG["analytics"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n            <tr><td class=\"fieldlabel\">";
echo $LNG["tracking"];
echo " ";
echo $LNG["code"];
echo "</td><td class=\"fieldarea\">\n            <input type=\"text\" value=\"";
echo $config["tracking_code"];
echo "\" name=\"tracking_code\" class=\"txt large\"/></td>\n            </tr>\n            <tr><td class=\"fieldlabel\">";
echo $LNG["analytics"];
echo " For eCommerce</td><td class=\"fieldarea\">\n\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n             name=\"analyticsecommerce\" value=\"1\" id=\"see\" ";
if ($config["analyticsecommerce"] == "1") {
    echo "checked";
}
echo " /><label for=\"see\"></label>\n\n            </td>\n            </tr>\n        </table>\n    </div>\n</div>\n\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["google"];
echo " GCM</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n<tr><td class=\"fieldlabel\">";
echo $LNG["google"];
echo " GCM Key</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["gcmkey"];
echo "\" name=\"gcmkey\" class=\"txt large\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">Android App ID</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["gcmappid"];
echo "\" name=\"gcmappid\" class=\"txt large\"/></td>\n</tr>\n        </table>\n </div>\n</div>\n\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["geo"];
echo " ";
echo $LNG["provider"];
echo "</span>\n  </h2>\n    <div class=\"groupstabescontant\">\n       <table class=\"form\">\n        <tr>\n    <td class=\"fieldlabel\" width=\"250px\">";
echo $LNG["iplocation"];
echo " </td>\n    <td class=\"fieldarea\"> <input type=\"text\" name=\"ip_location\" value=\"";
echo $config["ip_location"];
echo "\" class=\"txt large\"/> <small>";
echo $LNG["urlipinfo"];
echo " </small></td>\n        </tr>\n      </table>\n    </div>\n</div>\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["social"];
echo " ";
echo $LNG["networking"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n\n<tr><td class=\"fieldlabel\">";
echo $LNG["twitter"];
echo " [";
echo $LNG["username"];
echo "]</td><td class=\"fieldarea\"><input type=\"text\" class=\"txt medium\" value=\"";
echo $config["twitter"];
echo "\" name=\"twitter\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["facebook"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" class=\"txt medium\" value=\"";
echo $config["facebook_link"];
echo "\" name=\"facebook_link\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["linkedln"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" value=\"";
echo $config["linkedln"];
echo "\" name=\"linkedln\" class=\"txt medium\"/></td>\n</tr>\n            <tr><td class=\"fieldlabel\">Instagram</td><td class=\"fieldarea\"><input type=\"text\" value=\"";
echo $config["instagram"];
echo "\" name=\"instagram\" class=\"txt medium\"/></td>\n            </tr>\n</table>\n    </div>\n</div>\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["twitter"];
echo " ";
echo $LNG["application"];
echo "  ";
echo $LNG["access"];
echo " <a target=\"_blank\" href=\"https://support.dhru.com/Dhru-Fusion/article/General-Settings/?aid=5&pid=1&cid=2#other\">(How to get access ?)</a></span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tr><td class=\"fieldlabel\">";
echo $LNG["consumer"];
echo " ";
echo $LNG["key"];
echo "</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["consumer_key"];
echo "\" name=\"consumer_key\" class=\"txt large\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["consumer"];
echo " ";
echo $LNG["secret"];
echo "</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["consumer_secret"];
echo "\" name=\"consumer_secret\" class=\"txt large\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["access"];
echo " ";
echo $LNG["token"];
echo "</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["access_token"];
echo "\" name=\"access_token\" class=\"txt large\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["token"];
echo " ";
echo $LNG["secret"];
echo "</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["token_secret"];
echo "\" name=\"token_secret\" class=\"txt large\"/></td>\n</tr>\n</table>\n    </div>\n</div>\n<!--\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["facebook"];
echo " ";
echo $LNG["api"];
echo "  ";
echo $LNG["access"];
echo " <a target=\"_blank\"\nhref=\"http://wiki.dhru.com/Common_Troubleshooting_Tips#How_to_get_Facebook_Application_Access_.28App_ID.2FAPI_Key_and_App_Secret.29_.3F\">(How to get access ?)</a></span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tr><td class=\"fieldlabel\">App ID/API Key</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["appid"];
echo "\" name=\"appid\" class=\"txt large\"/></td>\n</tr>\n<tr><td class=\"fieldlabel\">App ";
echo $LNG["secret"];
echo "</td><td class=\"fieldarea\">\n<input type=\"text\" value=\"";
echo $config["app_secret"];
echo "\" name=\"app_secret\" class=\"txt large\"/></td>\n</tr>\n</table>\n    </div>\n</div>\n-->\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Google ";
echo $LNG["map"];
echo " ";
echo $LNG["api"];
echo " </span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n\n    <tr>\n<td class=\"fieldlabel\" width=\"250px\">Google ";
echo $LNG["map"];
echo " ";
echo $LNG["api"];
echo "  ";
echo $LNG["key"];
echo "</td>\n<td class=\"fieldarea\"> <input type=\"text\" name=\"googlelanguageapi\" value=\"";
echo $config["googlelanguageapi"];
echo "\" class=\"txt large\"/> </td>\n </tr>\n\n</table>\n</div></div>\n\n\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["other"];
echo " ";
echo $LNG["detail"];
echo " </span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n\n<tr>\n<td class=\"fieldlabel\" width=\"250px\">";
echo $LNG["otherhtmlcode"];
echo "</td>\n<td class=\"fieldarea\"><textarea class=\"textarea large\" id=\"otherhtmlcode\" base64encode=\"true\" name=\"otherhtmlcode\">";
echo base64_decode($html["value"]);
echo "</textarea>\n<span id=\"result\"></span>\n</td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n\n\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["mobile"];
echo " App ";
echo $LNG["download"];
echo " ";
echo $LNG["link"];
echo " </span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n\n<tr>\n<td class=\"fieldlabel\" width=\"250px\">Android</td>\n<td class=\"fieldarea\">\n <input type=\"text\" value=\"";
echo $config["androidlink"];
echo "\" name=\"androidlink\" class=\"txt large\"/>\n\n</td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n\n\n<p align=\"center\" class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnaddgroup\" class=\"btn\" type=\"button\"\nonclick=\"SubmitFormNew('#btnaddgroup','settingother','#frm','#notification','true','#main_loader');\"/>\n </p>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>