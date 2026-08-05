<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 32;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<div>\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["cart"];
echo " Configuration</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n  <table class=\"form\">\n";
if (licince\reqaddon("E-commerce", true)) {
    echo "        <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["shopping"];
    echo "  ";
    echo $LNG["cart"];
    echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n            name=\"shoppingcart1\" value=\"1\" id=\"hs\" ";
    if ($config["shoppingcart1"] == 0) {
        echo "checked";
    }
    echo "            /><label for=\"hs\"></label>\n            </td>\n        </tr>\n        <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["retail"];
    echo "  ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["menu"];
    echo "</td>\n            <td class=\"fieldarea\">\n                <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n          name=\"retailmenu\" value=\"1\" id=\"hrs\"\n              ";
    if (!$config["retailmenu"]) {
        echo "checked";
    }
    echo "                /><label for=\"hrs\"></label>\n            </td>\n        </tr>\n        ";
}
echo "  </table>\n\n         <table  class=\"form\">\n  ";
if (licince\reqaddon("E-commerce", true) && licince\reqaddon("Reseller Store", true)) {
    echo "        <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["shopping"];
    echo "  ";
    echo $LNG["cart"];
    echo " for ";
    echo $LNG["reseller"];
    echo " ";
    echo $LNG["store"];
    echo " </td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n            name=\"cartforstore\" value=\"1\" id=\"teesc\" ";
    if ($config["cartforstore"] == 1) {
        echo "checked";
    }
    echo "            /><label for=\"teesc\"></label>\n            </td>\n        </tr>\n";
}
echo "        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["shipping"];
echo " ";
echo $LNG["cost"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"shippingcost\" id=\"she\" value=\"1\" ";
if ($config["shippingcost"]) {
    echo "checked";
}
echo "  /><label for=\"she\"></label>\n            </td>\n        </tr>\n\n<tr>\n    <td class=\"fieldlabel\">Compare ";
echo $LNG["product"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"compareproduct\" id=\"comps\" value=\"1\" ";
if ($config["compareproduct"]) {
    echo "checked";
}
echo "  /><label for=\"comps\"></label>\n    </td>\n</tr>\n\n\n        <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["display"];
echo " ";
echo $LNG["type"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"radio\" name=\"displayproducttype\"\n            ";
if (!$config["displayproducttype"] || $config["displayproducttype"] == 1) {
    echo "checked='checked'";
}
echo "  value=\"1\" id=\"defas\" /> <label for=\"defas\">";
echo $LNG["default"];
echo "</label>\n            <input type=\"radio\" name=\"displayproducttype\"\n            ";
if ($config["displayproducttype"] == 2) {
    echo "checked='checked'";
}
echo "             value=\"2\" id=\"slider\" /> <label for=\"slider\">Slider</label>\n              </td>\n        </tr>\n\n         <tr style=\"display: none;\">\n            <td class=\"fieldlabel\">";
echo $LNG["default"];
echo " ";
echo $LNG["product"];
echo " ";
echo $LNG["display"];
echo " ";
echo $LNG["view"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"radio\" name=\"defaultproductview\" checked='checked'\n            ";
if (!$config["defaultproductview"] || $config["defaultproductview"] == 1) {
    echo "checked='checked'";
}
echo "  value=\"1\" id=\"defasv\" />\n            <label for=\"defasv\">Grid ";
echo $LNG["view"];
echo "</label>\n\n            <input type=\"radio\" name=\"defaultproductview\"\n            ";
if ($config["defaultproductview"] == 2) {
    echo "checked='checked'";
}
echo "             value=\"2\" id=\"sliderv\" />\n             <label for=\"sliderv\">";
echo $LNG["list"];
echo " ";
echo $LNG["view"];
echo "</label>\n            </td>\n        </tr>\n\n\n      <tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["cart"];
echo " ";
echo $LNG["style"];
echo "</td>\n    <td class=\"fieldarea\">\n<select name=\"carttpl\" id=\"carttpl\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
$myDirectory = opendir(ROOTDIR . "/templates/" . $config["template"] . "/cart/");
while ($dir = readdir($myDirectory)) {
    if (is_dir(ROOTDIR . "/templates/" . $config["template"] . "/cart/" . $dir) && $dir != "." && $dir != ".." && $dir != "") {
        echo "                 <option value=\"";
        echo $dir;
        echo "\" ";
        if ($config["carttpl"] == $dir) {
            echo "selected";
        }
        echo " >";
        echo $dir;
        echo "</option>  ";
    }
}
closedir($myDirectory);
echo "</select>\n<small>PayPal Express Checkout available in only default cart style</small>\n\n\n </td>\n\n</tr>\n\n<tr>\n    <td>\n\n    </td>\n    <td class=\"fieldarea\">\n        <div id=\"templateimagecart\"><img\nsrc=\"../templates/";
echo $config["template"];
echo "/cart/";
echo $config["carttpl"];
echo "/cartstylepreview.png\" style=\"border: #222 solid 1px;\"/></div>\n\n    </td>\n</tr>\n              </table>\n  </div>\n</div>\n\n\n\n\n</form>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settingshop','#frm','#notification','true','#main_loader');\"/></p>\n</div></div>";
$fileverioncheck = "6.1.0";

?>