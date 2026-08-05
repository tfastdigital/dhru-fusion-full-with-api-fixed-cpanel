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
echo "<div id=\"content\">\n";
$pg = dquery("select * from tbl_paymentgateways where\nsetting='active' and value=1");
if ($btnedituser) {
    $arr = implode(",", $gateway);
    dquery("update tbl_client_group \n    set paymentgateway='" . $arr . "' where id='" . $id . "'");
}
$clientgroup = mysqli_fetch_assoc(dquery("select * from tbl_client_group\nwhere id='" . $id . "'"));
$selectedg = explode(",", $clientgroup["paymentgateway"]);
echo "<form method=\"post\">\n<table id=\"main_tbl\">\n      <thead>\n      <tr>\n          <th style=\"text-align: left !important;\">";
echo $LNG["payment"];
echo " ";
echo $LNG["gateway"];
echo "</th>          \n      </tr>\n      </thead> \n      <tbody>\n";
while ($rpg = mysqli_fetch_assoc($pg)) {
    $selected = "";
    if (in_array($rpg["gateway"], $selectedg)) {
        $selected = "checked";
    }
    $gats = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n     where gateway='" . $rpg["gateway"] . "' and setting='name'"));
    echo " <tr>\n    <td style=\"text-align: left !important;\">\n    <input type=\"checkbox\"  ";
    echo $selected;
    echo " value=\"";
    echo $rpg["gateway"];
    echo "\" \n    name=\"gateway[";
    echo $rpg["gateway"];
    echo "]\" /> <label>";
    echo $gats["value"];
    echo "</label></td>\n </tr>\n ";
}
echo "      </tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\">\n<input name=\"btnedituser\" value=\"";
echo $LNG["save"];
echo "\" \nid=\"btnedituser\" class=\"btn save\" type=\"submit\" /></p>\n\n</form>\n</div>\n";
$fileverioncheck = "6.1.0";

?>