<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/support.fun.php";
$ticketDetails = getTicket(3);
echo "\n<div id=\"content\"> \n<div id=\"content_padded\">\n<div id=\"notification\"></div>\n<form id=\"newimeiorder\" name=\"\" method=\"post\">\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>                \n                <th >";
echo $LNG["ticket"];
echo " ";
echo $LNG["id"];
echo "</th>\n                <th><div align=\"center\">";
echo $LNG["user"];
echo "</div> </th>\n                <th><div align=\"center\">";
echo $LNG["department"];
echo "</div> </th>\n                <th><div align=\"center\">";
echo $LNG["priority"];
echo "</div> </th>\n                <th><div align=\"center\">";
echo $LNG["date"];
echo "</div> </th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
foreach ($ticketDetails as $key => $tick) {
    echo "<tr>\n<td>";
    echo $tick["tid"];
    echo "</td>\n<td align=\"center\">";
    if ($tick["user"]) {
        echo $tick["user"]["username"];
    } else {
        echo $tick["email"];
    }
    echo "</td>\n<td align=\"center\">";
    echo $tick["department"];
    echo "</td>\n<td align=\"center\">";
    echo $tick["priority"];
    echo "</td>\n<td align=\"center\">";
    echo $tick["date"];
    echo "</td>\n</tr>\n";
}
echo "\n</tbody></table>\n<p class=\"fixedbtn\">&nbsp;</p>\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>