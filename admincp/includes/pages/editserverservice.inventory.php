<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 261;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/serverservices.fun.php";
$md5id = md5($id);
$serverserviceDetails = getServerServices("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Inventory</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n     <td class=\"fieldlabel\">";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo " ";
echo $LNG["perunit"];
echo "</td>\n   <td class=\"fieldarea\"><input disabled=\"true\" type=\"text\"  class=\"txt small\" value=\"";
echo $serverserviceDetails["purchase_cost"];
echo "\" name=\"purchasecost\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/><span class=\"preforms\">";
echo $_SESSION["system_default_currency"]["code"];
echo "</span>    <a href=\"javascript: load_subpage('main2.php?page=editserverservice.purchasecost&id=";
echo $serverserviceDetails["id"];
echo "','Purhcase Cost');\">";
echo $LNG["set"];
echo " ";
echo $LNG["pricing"];
echo "</a></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["current"];
echo " ";
echo $LNG["stock"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\"  class=\"txt small\" value=\"";
echo $serverserviceDetails["stock"];
echo "\" name=\"currentstock\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["stock"];
echo " ";
echo $LNG["calculation"];
echo "</td>\n   <td class=\"fieldarea\"><input ";
if ($serverserviceDetails["stock_allow"] == "1") {
    echo "checked=checked";
}
echo " name=\"calculation\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"calculation1\"/><label for=\"calculation1\"></label></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editserverservice.inventory','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>