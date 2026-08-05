<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction newWindow(file,window)\n{  msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n}\nvar flag=0;\nfunction checkRetail(val,credit){\n    if(val<credit && flag==0){\n        flag=1;\n        alert('Retail Price is lower than credit');\n        \$(\".retailp\").focus();\n    }else{\n        flag=0;\n    }\n}\n</script>\n";
licince\reqaddon("E-commerce");
$pageid = 60;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Retail Purchase</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n  <table class=\"form\">\n    <tr>\n       <td class=\"fieldlabel\">";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo "</td>\n       <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["retail"] == "1") {
    echo "checked=checked";
}
echo " name=\"retail\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"hsop\"/><label for=\"hsop\"></label> </td>\n    </tr>\n  </table>\n\n\n <div class=\"hsop\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n   <td class=\"fieldlabel\">";
echo $LNG["servicename"];
echo "</td>\n   <td class=\"fieldarea\"><input name=\"retail_name\"\n   value=\"";
echo $imeiserviceDetails["retail_name"];
echo "\"  type=\"text\"/>\n\n   <small>Name will display to User for retail purchase</small>\n    </td>\n</tr>\n<tr>\n   <td class=\"fieldlabel\">SKU</td>\n   <td class=\"fieldarea\"><input name=\"sku\"\n   value=\"";
echo $imeiserviceDetails["sku"];
echo "\" size=\"20\" type=\"text\"/>\n\n   <small>Unique product code</small>\n    </td>\n</tr>\n\n\n\n<input name=\"retail_original\" size=\"5\" value=\"";
echo $imeiserviceDetails["retail_credit"];
echo "\" type=\"hidden\"\n class=\"txt small\" id=\"ret1\"/>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["tax"];
echo " Applicable</td>\n    <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["taxed"] == "1") {
    echo "checked=checked";
}
echo " name=\"taxed\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"te\"/><label for=\"te\"></label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" value=\"";
echo $imeiserviceDetails["image_link"];
echo "\" name=\"imagelink\" id=\"imagelink\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" class=\"addFromgallery\" type=\"button\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname1')\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " for ";
echo $LNG["hotdeals"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" value=\"";
echo $imeiserviceDetails["image_hotdeal"];
echo "\" name=\"image_hotdeal\" id=\"image_hotdeal\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" class=\"addFromgallery\" type=\"button\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=image_hotdeal', 'windowname1')\"/> <small>Max 685px width of Hot deals banner for default template</small> </td>\n</tr>\n<tr>\n     <td class=\"fieldlabel\" >";
echo $LNG["affiliate"];
echo " ";
echo $LNG["commission"];
echo "</td>\n   <td class=\"fieldarea\">\n<input name=\"affiliate_comission\"  value=\"";
echo $imeiserviceDetails["affiliate_comission"];
echo "\"\ntype=\"text\"  class=\"txt small\" id=\"ret1\"/> <span class=\"preforms\">%</span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">is ";
echo $LNG["best"];
echo " ";
echo $LNG["selling"];
echo " ?</td>\n   <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["hot"] == "1") {
    echo "checked=checked";
}
echo " name=\"hot\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hot1\"/><label for=\"hot1\"></label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["showhomepage"];
echo " </td>\n   <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["show_onhome"] == "1") {
    echo "checked=checked";
}
echo " name=\"showhomepage\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hote\"/><label for=\"hote\"></label><small>Show Product at main index page</small></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Customer ";
echo $LNG["review"];
echo " </td>\n   <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["review"] == "1") {
    echo "checked=checked";
}
echo " name=\"review\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"reve\"/><label for=\"reve\"></label><small>Customer can post that review</small></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> ";
echo $LNG["custom"];
echo " html</td>\n   <td class=\"fieldarea\"><textarea name=\"customhtml\" cols=\"55\" >";
echo $imeiserviceDetails["customhtml"];
echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n   <td class=\"fieldarea\"><span class=\"textgreen\" style=\"font-weight: bold;\"><a onclick=\"load_subpage('main2.php?page=editimeiservice.retailinfo&id=";
echo $id;
echo "','";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "');\">";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "</a></span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Partner Site</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " ";
echo $LNG["for"];
echo " Partner site</td>\n    <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["store"] == "1") {
    echo "checked=checked";
}
echo " name=\"store\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hs\"/><label for=\"hs\"></label>\n    <small>Allow Product to use in reseller store</small></td>\n</tr>\n\n<tr class=\"hs\">\n     <td class=\"fieldlabel\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["commission"];
echo " [ ";
echo $LNG["in"];
echo " % ] </td>\n     <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $imeiserviceDetails["resellerdisc"];
echo "\" name=\"resellerdisc\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">%</span>\n     <small>Commission per product selling</small></td>\n</tr>\n\n\n</tbody>\n</table>\n\n</div>\n</div></div></div></div>\n\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"button_save\" type=\"button\"\n    onclick=\"SubmitForm ('#btnedituser','editimeiservice.retailpurchase','#frmedituser','#notification','true','#main_loader');\"/>\n\n</p>\n\n</form>\n\n</div>\n</div>\n\n<div id=\"page_info\" classs=\"page_info\">\n<li>Set product for retail purchase</li>\n<li>Change tax settings,image link and retail information</li>\n<li>Also you can set this imei service as a best selling service and set to home page</li>\n</div>";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$( document ).ready(function() {\n        \$(\".colorpicker\").hide();\n    });\n\n</script>\n\n";

?>