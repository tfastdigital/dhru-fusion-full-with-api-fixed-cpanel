<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
licince\chklite();
$pageid = 413;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$group = getIMEIServiceGroup();
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<script>\n\nfunction mask(str,textbox,loc,delim){\n    var locs = loc.split(',');\n    for (var i = 0; i <= locs.length; i++){\n        for (var k = 0; k <= str.length; k++){\n            if (k == locs[i]){\n                if (str.substring(k, k+1) != delim){\n                    str = str.substring(0,k) + delim + str.substring(k,str.length);\n                }\n            }\n        }\n    }\n    textbox.value = str;\n}\n\n\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Subscription</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n    <tr>\n<td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n<td class=\"fieldarea\" ><span>\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"hs\" name=\"status\" value=\"1\" ";
if ($imeiserviceDetails["subscribe"]) {
    echo "checked";
}
echo "/><label for=\"hs\"></label></span>\n</td>\n</tr>\n</table>\n\n<table class=\"form hs\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n\n\n\n<tr id=\"credit\">\n<td class=\"fieldlabel\"> ";
echo $LNG["credit"];
echo "</td>\n<td class=\"fieldarea\"> <input name=\"credit\"  type=\"text\"  class=\"txt small\" value=\"";
echo $imeiserviceDetails["subscribe_credit"];
echo "\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> <span class=\"preforms\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</span> &nbsp;&nbsp;&nbsp;\n<span class=\"textgreen\" style=\"font-weight: bold;\"><a\nonclick=\"load_subpage('main2.php?page=editimeiservice.subscribecurrency&id=";
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
echo "\" type=\"text\"  class=\"txt small\"/> ";
echo $LNG["days"];
echo "</td>\n</tr>\n\n\n<tr id=\"credit\">\n<td class=\"fieldlabel\">";
echo $LNG["subscription"];
echo " ";
echo $LNG["order"];
echo "  ";
echo $LNG["limit"];
echo "</td>\n<td class=\"fieldarea\"><input id=\"\" name=\"subscriptionorderlimit\"  value=\"";
echo $imeiserviceDetails["subscriptionorderlimit"];
echo "\" type=\"text\"  class=\"txt small\"/>\n&nbsp;<small>";
echo $LNG["0means"];
echo "</small>\n</td>\n</tr>\n\n</tbody>\n</table>\n<p class=\"fixedbtn\">\n    <span ><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnsubscribe\" class=\"button_save\" type=\"button\"  onclick=\"SubmitForm ('#btnsubscribe','editimeiservice.subscribe','#frm','#notification','true','#main_loader');\"/>  </span>\n</p>\n</div></div>\n</form>\n</div></div>\n\n <div id=\"page_info\" classs=\"page_info\">\n\t<li>This page allows you to subscribe this imei service for user</li>\n</div>";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$( document ).ready(function() {\n        \$(\".colorpicker\").hide();\n    });\n\n</script>\n\n";

?>