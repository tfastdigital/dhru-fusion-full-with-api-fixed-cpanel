<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Reseller store</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["reseller"];
echo " ";
echo $LNG["store"];
echo "</td>\n    <td class=\"fieldarea\"><input ";
if ($imeiserviceDetails["store"] == "1") {
    echo "checked=checked";
}
echo " name=\"store\" value=\"1\" type=\"radio\" id=\"calculation1\"/><label for=\"calculation1\">";
echo $LNG["yes"];
echo "</label>\n    <input ";
if ($imeiserviceDetails["store"] == "0") {
    echo "checked=checked";
}
echo " name=\"store\" value=\"0\" type=\"radio\" id=\"calculation0\"/><label for=\"calculation0\">";
echo $LNG["no"];
echo "</label>\n    <small>Allow Product to use in reseller store</small></td>\n</tr>\n\n<tr>\n     <td class=\"fieldlabel\">";
echo $LNG["reseller"];
echo " ";
echo $LNG["discount"];
echo " [ ";
echo $LNG["in"];
echo " % ] </td>\n     <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $imeiserviceDetails["resellerdisc"];
echo "\" name=\"resellerdisc\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/> %\n     <small>Discount per product selling</small></td>\n</tr>\n\n\n</tbody>\n</table>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editimeiservice.store','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</div></div>\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>