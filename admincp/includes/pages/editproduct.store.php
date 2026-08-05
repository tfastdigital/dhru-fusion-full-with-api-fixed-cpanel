<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 348;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Reseller Store</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " ";
echo $LNG["for"];
echo " Partner Site</td>\n    <td class=\"fieldarea\"><input ";
if ($productDetails["store"] == "1") {
    echo "checked=checked";
}
echo " name=\"store\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hs\"/><label for=\"hs\"></label>\n    <small>Allow Product to use in reseller store</small></td>\n</tr>\n\n<tr class=\"hs\">\n     <td class=\"fieldlabel\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["commission"];
echo " [ ";
echo $LNG["in"];
echo " % ] </td>\n     <td class=\"fieldarea\"><input type=\"text\" class=\"txt small\" value=\"";
echo $productDetails["resellerdisc"];
echo "\" name=\"resellerdisc\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">%</span>\n     <small>Commission per product selling</small></td>\n</tr>\n\n\n</tbody>\n</table>\n</div></div>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editproduct.store','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>