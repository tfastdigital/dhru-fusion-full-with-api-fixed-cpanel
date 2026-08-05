<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 438;
checkPagePermission($pageid);
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<div id=\"notification\"></div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["create"];
echo " ";
echo $LNG["auto"];
echo " ";
echo $LNG["reply"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n<form method=\"post\" id=\"frms\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["inventory"];
echo " ";
echo $LNG["group"];
echo "</td>\n<td class=\"fieldarea\">\n        <select name=\"group\">\n            ";
$sql = dquery("select * from tbl_keygroup");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group"];
    echo "</option>\n            ";
}
echo "        </select>\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["digital"];
echo " ";
echo $LNG["code"];
echo " ";
echo $LNG["reply"];
echo "</td>\n<td class=\"fieldarea\">\n    <table>\n        <tr><td>\n    <textarea name=\"key\" cols=\"50\" rows=\"5\"></textarea> <small>";
echo $LNG["morethanonekey"];
echo "</small>\n            </td>\n            <td>\n                <textarea name=\"code2\" cols=\"50\" rows=\"5\"></textarea> <small>";
echo $LNG["morethanonekey"];
echo "</small>\n            </td>\n        </tr>\n    </table>\n        </td>\n\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["expired"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"to\" class=\"datepicker\"  autocomplete=\"off\" id=\"to\" style=\"width: 100px;\"/> <small>";
echo $LNG["leaveblankneverexp"];
echo "</small>\n</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["purchase"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"purchase\" id=\"purchase\" style=\"width: 100px;\"/>\n        <strong>";
echo $_SESSION["system_default_currency"]["code"];
echo "</strong>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["available"];
echo " ";
echo $LNG["stock"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"qnt\" style=\"width: 100px;\" value=\"1\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        <label><input type=\"checkbox\" value=\"1\" name=\"ignore\">Ignore Duplicates</label>\n    </td>\n</tr>\n</tbody></table>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','softwarekey','#frms','#notification','true','#main_loader','','',1);\"/></p>\n\n</form>\n\n</div>\n</div></div>\n</div>";
$fileverioncheck = "6.1.0";

?>