<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<style>\n    img{margin-left:10px;margin-top:10px}\n</style>\n";
if ($generate) {
    $style = "style='width: " . $width . "px; height: " . $height . "px;'";
}
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Generate Code</a></li>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody> \n<tr>\n    <td colspan=\"2\">\n        <form method=\"post\" action=\"main2.php?page=codegenerator\" >\n            Width : <input type=\"text\" name=\"width\" id=\"width\"  />\n              &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;\n            Height : <input type=\"text\" name=\"height\" id=\"height\"  />\n              &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;\n            <input type=\"submit\" name=\"generate\" value=\"Generate\" />\n        </form>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldarea\">\n    <label for='rs'><strong>Login</strong></label> <br />\n    <textarea id=\"login\" style=\"width: 100%;\" rows=\"5\" >\n    \n      <div id=\"logindiv\" ";
echo $style;
echo " >\n         <form  method=\"post\" action=\"";
echo $config["site_address"];
echo "login.php\">\n              Username : <input type=\"text\"  name=\"username\" size=\"25\" /><em>*</em>\n       <br /> Password :<input type=\"password\" name=\"password\"  size=\"25\" /><em>*</em> \n        </form>\n      </div>   \n   \n    </textarea>\n    </td>\n</tr>\n \n\n\n</tbody>\n\n</table>\n\n\n</div>";
$fileverioncheck = "6.1.0";

?>