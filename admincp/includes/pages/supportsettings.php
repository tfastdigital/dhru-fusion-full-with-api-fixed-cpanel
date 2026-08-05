<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$html = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='htmlcode'"));
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "\n    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\">\n            <form id=\"frm\" name=\"\" method=\"post\">\n                ";
echo generate_token("form");
echo "\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                    <tbody>\n\n\n                <tr>\n                    <td class=\"fieldlabel\">\n                        ";
echo $LNG["livehelp"];
echo "</td>\n                    <td class=\"fieldarea\">\n                        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n                               name=\"livehelpservice\" id=\"alove\" value=\"1\"\n                            ";
if ($config["livehelpservice"]) {
    echo "checked";
}
echo "  /><label for=\"alove\"></label>\n                    </td>\n                </tr>\n                    </tbody>\n                </table>\n                <p align=\"center\" class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\"\n       id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n       onclick=\"SubmitFormNew('#btnaddgroup','supportsettings','#frm','#notification','true','#main_loader');\"/>\n                </p>\n\n            </form>\n\n\n        </div></div>\n";
$fileverioncheck = "6.1.0";

?>