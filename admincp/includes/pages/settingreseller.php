<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 188;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["reseller_can_setup_store"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"reseller_can_setup_store\" id=\"sto\" value=\"1\" ";
if ($config["reseller_can_setup_store"]) {
    echo "checked";
}
echo " /><label for=\"sto\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"reseller_can_setup_store\" id=\"stod\" value=\"0\" ";
if (!$config["reseller_can_setup_store"]) {
    echo "checked";
}
echo " /><label for=\"stod\">";
echo $LNG["disable"];
echo "</label>\n    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["supplier_order_reminder"];
echo "  </td>\n    <td class=\"fieldarea\">\n<input type=\"text\" name=\"supplier_order_reminder\" value=\"";
echo $supplier_order_reminder["value"];
echo "\" /> ";
echo $LNG["hrs"];
echo "   </td>\n</tr>\n-->\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settingreseller','#frm','#notification','true','#main_loader');\"/>\n</p>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>