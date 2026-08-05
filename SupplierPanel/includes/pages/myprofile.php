<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[supid])) {
    exit;
}
echo "<style>\n    .form{margin-bottom: 4px !important;}\n</style>\n";
include ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($_SESSION["supid"]);
$id = $_SESSION["supid"];
echo "\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        <form id=\"frmeditsupplier\" name=\"\" method=\"post\">\n            <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n            ";
echo generate_token("form");
echo "            <table><tr><td width=\"50%\" valign=\"top\">\n                        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                            <tbody>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["username"];
echo "</td>\n                                <td class=\"fieldarea\"><span>";
echo $clientDetails["username"];
echo "</span></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["password"];
echo "</td>\n                                <td class=\"fieldarea\"><input name=\"password\" id=\"password\" value=\"\" type=\"text\" style=\"width: 130px;\"/> <!--<input type=\"button\" value=\"";
echo $LNG["resetpass"];
echo "\" name=\"resetpass\" id=\"btnedituserpass\" onclick=\"genpass();\"/>--></td>\n                            </tr>\n\n\n\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["firstname"];
echo "</td>\n                                <td class=\"fieldarea\"><input name=\"firstname\"  value=\"";
echo $clientDetails["first_name"];
echo "\" type=\"text\"/></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["lastname"];
echo "</td>\n                                <td class=\"fieldarea\"><input name=\"lastname\"  value=\"";
echo $clientDetails["last_name"];
echo "\" type=\"text\"/></td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["registeredemail"];
echo "</td>\n                                <td class=\"fieldarea\"><input name=\"email\"  value=\"";
echo $clientDetails["email"];
echo "\" type=\"text\"/></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["address"];
echo "</td>\n                                <td class=\"fieldarea\"><textarea name=\"address\">";
echo $clientDetails["address"];
echo "</textarea></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["country"];
echo "</td>\n                                <td class=\"fieldarea\">";
echo getCountriesDropDown($clientDetails["country"]);
echo "</td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel\" width=\"30%\">";
echo $LNG["payout"];
echo " ";
echo $LNG["notes"];
echo "</td>\n                                <td class=\"fieldarea\">\n                                    <textarea name=\"payoutnotes\" rows=\"5\">";
echo $clientDetails["payoutnotes"];
echo "</textarea>\n                                    <br />\n                                    <small>Update your payment details where you wish to receive payments.</small>\n                                </td>\n                            </tr>\n\n                            </tbody>\n                        </table>\n                    </td><td valign=\"top\">\n\n\n\n\n\n                    </td></tr></table>\n            <p align=\"left\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"button\" type=\"button\"\n                                   onclick=\"SubmitForm ('#btnedituser','myprofile','#frmeditsupplier','#notification','true','#main_loader');\"/></p>\n\n        </form>\n\n    </div>\n</div>";

?>