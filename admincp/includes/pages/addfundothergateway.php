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
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
$gatewaywise = json_decode($config["otherfundlimit"], true);
echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n        <form method=\"post\" name=\"\" id=\"frsb\">\r\n            ";
echo generate_token("form");
echo "            <table  id=\"main_tbl\"  >\r\n                <tr>\r\n                    <th>";
echo $LNG["gateway"];
echo "</th>\r\n                    <th>\r\n                        ";
if ($min) {
    echo "                            ";
    echo $LNG["minimum"];
    echo "                        ";
} else {
    echo "                            ";
    echo $LNG["maximum"];
    echo "                        ";
}
echo " ";
echo $LNG["limit"];
echo "</th>\r\n                </tr>\r\n                <tbody>\r\n                ";
$pg = dquery("select gateway,value from tbl_paymentgateways\r\nwhere setting='name' group by gateway");
while ($rpg = mysqli_fetch_assoc($pg)) {
    echo "                <tr>\r\n                    <td >";
    echo $rpg["value"];
    echo " </td>\r\n                    <td >\r\n                        ";
    if ($min) {
        echo "                            <input type=\"text\" class=\"txt small\"\r\n                                   name=\"fundmin[";
        echo $rpg["gateway"];
        echo "]\"\r\n                                   value=\"";
        echo $gatewaywise[$rpg["gateway"]]["minlimit"];
        echo "\"/>\r\n                            ";
    } else {
        echo "                            <input type=\"text\" class=\"txt small\"\r\n                                   name=\"fundmax[";
        echo $rpg["gateway"];
        echo "]\"\r\n                                   value=\"";
        echo $gatewaywise[$rpg["gateway"]]["maxlimit"];
        echo "\"/>\r\n                            ";
    }
    echo "                    </td>\r\n                </tr>\r\n                ";
}
echo "\r\n\r\n                </tbody>\r\n            </table>\r\n        </form>\r\n        <p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\r\nid=\"btnaddgroup\" class=\"btn\" type=\"button\"\r\nonclick=\"SubmitForm ('#btnaddgroup','addfundother','#frsb','#notification','true','#main_loader');\"/></p>\r\n\r\n    </div>\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>