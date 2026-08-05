<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 461;
checkPagePermission($pageid);
echo "\r\n<div id=\"notification\"></div>\r\n\r\n<div id=\"content\" style=\"width: 100%;!important \">\r\n    <div id=\"content_padded\" style=\"width: 100%;!important \">\r\n\r\n\r\n        <div  class=\"groupstabes\" >\r\n            <form method=\"post\" id=\"frmsc\">\r\n                <table class=\"form\">\r\n                    <tbody>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">Zone ID</td>\r\n                        <td class=\"fieldarea\"><input type=\"text\" name=\"cloudflarezoneid\"\r\n                                                     value=\"";
echo $config["cloudflarezoneid"];
echo "\"/> </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "</td>\r\n                        <td class=\"fieldarea\"><input type=\"text\" name=\"cloudflareemail\"  value=\"";
echo $config["cloudflareemail"];
echo "\"/> </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["key"];
echo "</td>\r\n                        <td class=\"fieldarea\"><input type=\"text\" name=\"cloudflareapikey\"  value=\"";
echo $config["cloudflareapikey"];
echo "\"/> </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td></td>\r\n                        <td>\r\n                            <p class=\"fixedbtn\">\r\n                            <input type=\"button\" id=\"btnaddgroup\"\r\n                                   onclick=\"SubmitForm ('#btnaddgroup','cloudflareapi','#frmsc','#notification','true','#main_loader');\"\r\n                                   value=\"";
echo $LNG["save"];
echo "\"    />\r\n                            </p>\r\n                        </td>\r\n                    </tr>\r\n                    </tbody>\r\n                </table>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>\r\n\r\n";
$fileverioncheck = "6.1.0";

?>