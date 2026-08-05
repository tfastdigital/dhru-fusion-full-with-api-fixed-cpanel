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
$id = $_GET["u"];
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
echo "  <div id=\"notificationdt\"></div>\n\n<div class=\"content\">\n        <div class=\"panel\">\n\n  <form method=\"post\" id=\"frmadd\">\n  <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n            <h2>+Add Credit</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
echo $LNG["creditbalance"];
echo ":\n                        ";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>";
echo $LNG["add"];
echo " ";
echo $LNG["credit"];
echo " :\n                        <input type=text id=creditleft name=\"creditleft\"  onkeypress=\"blank('rebatecredit')\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\">\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n                        <input type=\"checkbox\" checked=\"checked\" id=\"geninvoice\" name=\"geninvoice\"/> ";
echo $LNG["geninvoice"];
echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n                        <input type=\"checkbox\"  id=\"paid\" name=\"paid\"/> ";
echo $LNG["paid"];
echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n\n                        <a class=\"btn\" id=\"btnedituser\" onclick=\"SubmitForm ('#btnedituser','edituser.accountfinancial','#frmadd','#notificationdt','false','');\" >";
echo $LNG["add"];
echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n\n\n\n";
if ($clientDetails["usertype"] == "1") {
    echo "<div class=\"content\">\n        <div class=\"panel\">\n  <form method=\"post\" id=\"frmsell\">\n  <input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n            <h2>Sell Credit Limit</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
    echo $LNG["sellcreditlimit"];
    echo ":\n                        ";
    echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
    echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>";
    echo $LNG["add"];
    echo " ";
    echo $LNG["credit"];
    echo " :\n                        <input name=\"sellcreditlimit\" id=\"sellcreditlimit\" value=\"\" type=\"text\" onKeyPress=\"blank('rebatesellcredit')\" onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n                    </label>\n                </li>\n\n                <li class=\"field\">\n                    <label>\n\n                        <a id=\"btnsell\" onclick=\"SubmitForm ('#btnsell','edituser.accountfinancial','#frmsell','#notificationdt','false','');\" class=\"btn\">";
    echo $LNG["add"];
    echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n\n\n\n";
}
echo "\n\n\n\n\n";

?>