<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "  \n";
$pageid = 419;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getProducts("", $md5id);
echo "  \n<script> \n\nfunction mask(str,textbox,loc,delim){\n    var locs = loc.split(',');\n    for (var i = 0; i <= locs.length; i++){\n        for (var k = 0; k <= str.length; k++){\n            if (k == locs[i]){\n                if (str.substring(k, k+1) != delim){\n                    str = str.substring(0,k) + delim + str.substring(k,str.length);\n                }\n            }\n        }\n    }\n    textbox.value = str;    \n}\n\n\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Subscription</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n    <tr>\n<td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n<td class=\"fieldarea\" ><span>\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"  id=\"hs\" name=\"status\" value=\"1\" ";
if ($imeiserviceDetails["subscribe"]) {
    echo "checked";
}
echo "/><label for=\"hs\"></label></span>\n</td>\n</tr>\n</table>\n\n\n<table class=\"form hs\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n<tr id=\"credit\">\n<td class=\"fieldlabel\"> ";
echo $LNG["price"];
echo "</td>\n<td class=\"fieldarea\"> <input name=\"credit\"  type=\"text\"  class=\"txt small\" value=\"";
echo $imeiserviceDetails["subscribe_credit"];
echo "\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> <span class=\"preforms\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</span> &nbsp;&nbsp;&nbsp; \n<span class=\"textgreen\"><a onclick=\"load_subpage('includes/pages/editproduct.subscribecurrency.php?id=";
echo $id;
echo "','";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "');\">";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "</a></span></td>\n</tr>\n\n<tr id=\"credit\">\n<td class=\"fieldlabel\">";
echo $LNG["subscription"];
echo " ";
echo $LNG["period"];
echo "</td>\n<td class=\"fieldarea\"><input id=\"\" name=\"days\"  value=\"";
echo $imeiserviceDetails["subscribe_days"];
echo "\" type=\"text\"  class=\"txt small\" /> ";
echo $LNG["days"];
echo "</td>\n</tr>\n\n\n<tr id=\"credit\">\n<td class=\"fieldlabel\">";
echo $LNG["subscription"];
echo " ";
echo $LNG["order"];
echo "  ";
echo $LNG["limit"];
echo "</td>\n<td class=\"fieldarea\"><input id=\"\" name=\"subscriptionorderlimit\"  value=\"";
echo $imeiserviceDetails["subscriptionorderlimit"];
echo "\" type=\"text\"  class=\"txt small\" /> \n&nbsp;<small>";
echo $LNG["0means"];
echo "</small></td>\n</tr>\n\n\n</tbody>\n</table>\n\n</div></div>\n\n\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnsubscribe\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnsubscribe','editproduct.subscribe','#frm','#notification','true','#main_loader');\"/> </p>\n\n</form>\n</div></div>\n \n<div id=\"page_info\" class=\"page_info\">\n\t<li>Subscription package settings.Create product/service subscription with package price and no of days</li>\n</div> ";
$fileverioncheck = "6.1.0";

?>