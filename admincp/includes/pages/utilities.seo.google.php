<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n";
$pageid = 505;
checkPagePermission($pageid);
if ($generate) {
}
echo " \n\n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" action=\"includes/pages/dl.php\" method=\"post\">\n<input type=\"hidden\" name=\"downloadxml\" value=\"1\" />\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"utilities.seo.google.php\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td width=\"10px\" class=\"\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input type=\"submit\" name=\"generate\" value=\"";
echo $LNG["generate"];
echo " google base Feed\" />\n     </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>