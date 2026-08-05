<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 400;
checkPagePermission($pageid);
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n<form method=\"post\" id=\"frms\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["genrechargecode"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"nos\" id=\"nos\" style=\"width: 50px;\" size=\"10\" />&nbsp;<input type=\"button\" name=\"generate\" value=\"Generate\" class=\"addFromgallery\" onclick=\"gencode()\" /></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["codelist"];
echo "</td>\n<td class=\"fieldarea\">\n<textarea name=\"code\" id=\"code\" cols=\"50\" rows=\"5\"></textarea>\n<small>";
echo $LNG["morethanonekey"];
echo "</small>\n</td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["credit"];
echo " ";
echo $LNG["amount"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"credit\"   /></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["currency"];
echo "</td>\n<td class=\"fieldarea\">\n<select name=\"currency\">\n";
$currency = dquery("SELECT code, id FROM tbl_currencies");
while ($row = mysqli_fetch_assoc($currency)) {
    echo " <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["code"];
    echo "</option>\n ";
}
echo "</select>\n\n    <label><input type=\"checkbox\" name=\"fixcurrency\" value=\"1\" /> Fix Currency </label>\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["noofuse"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"used\"   /> <small>";
echo $LNG["noofuseinfo"];
echo "</small></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["validity"];
echo "</td>\n<td class=\"fieldarea\"><input type=\"text\" class=\"datepicker\"  autocomplete=\"off\" name=\"from\"\n   id=\"from\" /> ";
echo $LNG["to"];
echo " <input  class=\"datepicker\"  autocomplete=\"off\"  type=\"text\" name=\"to\" id=\"to\" /></td>\n</tr>\n\n</tbody></table>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','recharge','#frms','#notification','true','#main_loader');\"/></p>\n\n</form>\n<br /><br />\n\n</div>\n</div>\n<script>\nfunction gencode(){\n\n    var cnt=document.getElementById('nos').value;\n\n    var length=20;\n    var buf='';\n    var chars = '123456789ABCDEFGHIJKLMNPQRSTUVWXTZ'.split('');\n    for(var j=0;j<cnt;j++){\n\n        if (! length) {\n            length = Math.floor(Math.random() * chars.length);\n        }\n\n        var str = '';\n        for (var i = 0; i < length; i++) {\n            str += chars[Math.floor(Math.random() * chars.length)];\n        }\n          if(buf!=''){\n            buf=buf+\"\\r\\n\"+str;\n          }else { buf=str; }\n\n    }\n\n    document.getElementById('code').value=buf;\n\n\n}\n</script>";
$fileverioncheck = "6.1.0";

?>