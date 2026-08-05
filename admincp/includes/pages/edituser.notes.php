<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
require_once "includes/fun.inc.php";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "\n";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
if ($btnnotes) {
    checkDemoMode(false);
    $data["note"] = $notes;
    $data["message"] = $message;
    $data["messagedate"] = $date;
    if ($db->update("tblUsers", $data, "id=" . $id)) {
        echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
    }
}
$clientDetails = getClientsDetails($id);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<table class=\"form\" cellpadding=\"5\">\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["notes"];
echo "</td>\n<td class=\"fieldarea\"><textarea name=\"notes\" style=\"height: 150px; width:99%\">";
echo $clientDetails["note"];
echo "</textarea></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["message"];
echo "</td>\n<td class=\"fieldarea\"><textarea name=\"message\" style=\"height: 150px; width:99%\">";
echo $clientDetails["message"];
echo "</textarea></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["user"];
echo "  ";
echo $LNG["notification"];
echo " ";
echo $LNG["display"];
echo " till</td>\n<td class=\"fieldarea\">\n    <input type=\"text\" name=\"date\" id=\"date\"    placeholder=\"yyyy-mm-dd\" size=\"12\" value=\"";
echo $clientDetails["messagedate"];
echo "\" class=\"datepicker\"  autocomplete=\"off\" />\n</td>\n</tr>\n\n\n</table>\n\n\n\n\n <div class=\"fixedbtn\">\n     <input onClick=\"SubmitForm ('#savac','edituser.notes','#frmedituser','#notification','true','#main_loader');\" type=\"button\" name=\"savan\" class=\"btn btn-primary\" id=\"savan\" value=\"";
echo $LNG["save"];
echo "\"  />\n </div>\n\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>