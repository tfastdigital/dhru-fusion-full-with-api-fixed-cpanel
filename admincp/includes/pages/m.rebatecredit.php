<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$id = $_GET["u"];
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
echo "\n\n\n<div id=\"notificationsd\"></div>\n <div class=\"content\">\n        <div class=\"panel\">\n\n  <form method=\"post\" id=\"frmrebate\">\n  <input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n            <h2>-Rebate Credit</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
echo $LNG["creditbalance"];
echo ":\n                        ";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>";
echo $LNG["rebate"];
echo " ";
echo $LNG["credit"];
echo " :\n                        <input name=\"rebatecredit\"  value=\"\" id=\"rebatecredit\" type=\"text\"  onKeyPress=\"blank('creditleft')\" onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n\n                        <a class=\"btn\" id=\"btnedituser\" onclick=\"SubmitForm ('#btnedituser','edituser.accountfinancial','#frmrebate','#notificationsd','false','');\" >";
echo $LNG["rebate"];
echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n\n\n\n\n\n";
if ($clientDetails["usertype"] == "1") {
    echo " <div class=\"content\">\n        <div class=\"panel\">\n\n  <form method=\"post\" id=\"frmsell\">\n  <input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n            <h2>-Rebate Sell Credit</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
    echo $LNG["sellcreditlimit"];
    echo ":\n                        ";
    echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
    echo "                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>";
    echo $LNG["rebate"];
    echo " ";
    echo $LNG["credit"];
    echo " :\n  <input name=\"rebatesellcredit\" id=\"rebatesellcredit\" value=\"\" type=\"text\" class=\"small_txt\" onKeyPress=\"blank('rebatesellcredit')\" onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>\n                        <a class=\"btn\" id=\"btnsell\" onclick=\"SubmitForm ('#btnsell','edituser.accountfinancial','#frmsell','#notificationsd','false','');\" >";
    echo $LNG["rebate"];
    echo "</a>\n                    </label>\n                </li>\n\n            </ol>\n   </form>\n        </div>\n</div>\n";
}
echo "\n\n\n\n\n\n\n";

?>