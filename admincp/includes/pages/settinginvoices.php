<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 201;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div>\n      <h2>\n        <span class=\"groupstabesheadertext\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["settings"];
echo "</span>\n      </h2>\n      <div class=\"groupstabescontant\">\n\n\n<table  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\" class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["prefix"];
echo "</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" style=\"width: 120px;\" name=\"invoiceprefix\"\n    value=\"";
echo $config["invoiceprefix"];
echo "\" />\n\n    <small>";
echo $LNG["display"];
echo " ";
echo $LNG["client"];
echo " </small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["invoice"];
echo "  ";
echo $LNG["no"];
echo " Increment</td>\n    <td class=\"fieldarea\">\n <input type=\"text\" style=\"width: 40px;\" name=\"invoiceincrement\"\n    value=\"";
echo $config["invoiceincrement"] ? $config["invoiceincrement"] : 1;
echo "\" value=\"\" />\n\n    <small>";
echo $LNG["invoice"];
echo " ";
echo $LNG["no"];
echo " will increase by this value</small>\n    </td>\n</tr>\n\n  <tr>\n    <td class=\"fieldlabel\" width=\"250px\">";
echo $LNG["gateway"];
echo " ";
echo $LNG["change"];
echo " ";
echo $LNG["allow"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"can_change_invoice_gateway\" id=\"egs\" value=\"1\" ";
if ($config["can_change_invoice_gateway"]) {
    echo "checked";
}
echo "  /><label for=\"egs\"></label>\n     <small>";
echo $LNG["changegatewayinfo"];
echo "</small>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["invoicepayto"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <textarea name=\"invoicepayto\" class=\"textarea large\"\n    style=\"height: 100px;\">";
echo $config["invoicepayto"];
echo "</textarea></td>\n</tr>\n\n\n\n</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\"\nid=\"btnaddgroup\" class=\"btn\" type=\"button\"\nonclick=\"SubmitForm ('#btnaddgroup','settinginvoices','#frm','#notification','true','#main_loader');\"/>\n\n       </p>\n\n\n</div>\n</div>\n\n</form>";
$fileverioncheck = "6.1.0";

?>