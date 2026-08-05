<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 440;
checkPagePermission($pageid);
echo "\n";
$result = dquery("select * from tbl_swkey where id=" . $id);
$row = mysqli_fetch_assoc($result);
echo "<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n<form method=\"post\" id=\"frms\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $row["id"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["softwarekey"];
echo "</td>\n<td class=\"fieldarea\"><textarea name=\"key\" rows=\"5\">";
echo $row["key"];
echo "</textarea> [<small>more then 1 key seperated by new line</small>]</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n";
if ($row["status"] == 0) {
    $enable = "checked=checked";
} else {
    $disable = "checked=checked";
}
echo "<td class=\"fieldarea\"><input type=\"radio\" name=\"status\" value=\"1\" id=\"s_yes\" ";
if ($row["status"] == 1) {
    echo "checked=checked";
}
echo "/><label for=\"s_yes\">";
echo $LNG["enable"];
echo "</label> &nbsp;<input type=\"radio\" name=\"status\" value=\"0\" id=\"y_no\" ";
if ($row["status"] == 0) {
    echo "checked=checked";
}
echo "/><label for=\"y_no\">";
echo $LNG["disable"];
echo "</label></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["start"];
echo " ";
echo $LNG["date"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" class=\"datepicker\"  autocomplete=\"off\" name=\"from\" id=\"from\" value=\"";
echo $row["date"];
echo "\" style=\"width: 100px;\"/>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["expired"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" class=\"datepicker\"  autocomplete=\"off\" name=\"to\" id=\"to\" value=\"";
echo $row["expiredon"];
echo "\" style=\"width: 100px;\"/>\n</td>\n</tr>\n\n</tbody></table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','editsoftwarekey','#frms','#notification','true','#main_loader');\"/></p>\n\n</form>\n<br /><br />\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>