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
echo "<script>\nfunction clearlisting()\n{\n    var answer = confirm('";
echo $LNG["areusureclearapi"];
echo "');\n    if(answer)\n    {\n        SubmitForm('#btnclean','utilities.clearapi','#frmcleanup','#notification','true','#main_loader');\n    }\n}\n</script>\n";
include_once ROOTDIR . "/includes/apiserver.fun.php";
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmcleanup\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n\n<table class=\"form\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["server"];
echo "</td>\n    <td class=\"fieldarea\">";
$sql = dquery("SELECT gateway, setting, value FROM \n    tbl_apiservers WHERE setting = 'name'");
echo "   <select name='api'>\n            <option value=\"\">";
echo $LNG["select"];
echo "</option>\n            ";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value='" . $row["gateway"] . "'>" . $row["value"] . "</option>";
}
echo "        </select> <input value=\"";
echo $LNG["clear"];
echo " ";
echo $LNG["listing"];
echo "\" \n        id=\"btnclean\" class=\"button_remove\" type=\"button\"  \n        onclick=\"clearlisting();\"  />\n   </td>\n</tr>\n\n</tbody></table>\n</form></div></div> \n";
$fileverioncheck = "6.1.0";

?>