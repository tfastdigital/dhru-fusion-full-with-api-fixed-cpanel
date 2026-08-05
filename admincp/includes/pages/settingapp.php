<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"groupstabescontant\">\n\n<form id=\"frmd\" name=\"frmd\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td  class=\"fieldlabel\">Dhru GCM APi Key</td>\n    <td class=\"fieldarea\">\n    \n<input class=\"txt large\" type=\"text\" name=\"googlegcm\" \nvalue=\"";
echo $config["googlegcm"];
echo "\" />\n    <small>Get your Cloude messaging API key from http://cp.dhru.com for instant notification</small>\n </td>\n</tr>\n<!--\n<tr>\n    <td  class=\"fieldlabel\">Google Project ID/Sender ID</td>\n    <td class=\"fieldarea\">\n    <input class=\"txt large\" type=\"text\" name=\"googlesenderid\" \n    value=\"";
echo $config["googlesenderid"];
echo "\" />\n </td>\n</tr>\n-->\n";
if (licince\reqaddon("Custom mobile app", true)) {
    echo "<tr>\n    <td  class=\"fieldlabel\">Android Application Play Store Path</td>\n    <td class=\"fieldarea\">\n    \n<input class=\"txt large\" type=\"text\" name=\"androidlink\" \nvalue=\"";
    echo $config["androidlink"];
    echo "\" />\n </td>\n</tr>\n";
}
echo "</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\"\n id=\"btnaddgroup\" class=\"btn\" type=\"button\"  \n onclick=\"SubmitForm ('#btnaddgroup','settingapp','#frmd','#notification','true','#main_loader');\"/> \n</p>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>