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
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script>\nfunction makekey()\n{\n    var text = \"\";\n    var possible = \"ABCDEFGHIJKLMNPQRSTUVWXYZ123456789STUVWXYZ1234567STUVWXYZ1234567STUVWXYZ1234567STUVWXYZ1234567STUVWXYZ1234567\";\n\n    for( var i=0; i < 265; i++ )\n        text += possible.charAt(Math.floor(Math.random() * possible.length));\n\n    return text;\n}\nfunction resetKey()\n{\n     var nk=makekey();\n    \$(\"#dhrubackupkey\").html(nk);\n}\nfunction showOption(ob)\n{\n\n    if(ob.checked){\n        \$('#backupo').show();\n        var key=\$(\"#dhrubackupkey\").html();\n\n       if(!key){\n            var nk=makekey();\n            \$(\"#dhrubackupkey\").html(nk);\n       }\n    }else{\n        \$('#backupo').hide();\n    }\n}\n</script>\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"reset\" id=\"reset\" value=\"0\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["backup"];
echo " ";
echo $LNG["option"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" onclick=\"javascript: showOption(this);\"\n    name=\"dhrubackupoption\"\nvalue=\"1\" id=\"ame\" ";
if ($config["dhrubackupoption"]) {
    echo "checked";
}
echo " /><label for=\"ame\"></label>\n   </td>\n</tr>\n\n\n<tr id=\"backupo\" style=\"";
if (!$config["dhrubackupoption"]) {
    echo "display: none;";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["backup"];
echo " ";
echo $LNG["key"];
echo "</td>\n    <td class=\"fieldarea\">\n             <textarea cols=\"100\" name=\"dhrubackupkey\" rows=\"6\"\n             id=\"dhrubackupkey\" >";
echo $dhrubackupserviceaccesskey;
echo "</textarea>\n    </td>\n</tr>\n\n\n\n</tbody>\n</table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\"\nonclick=\"javascript:\nSubmitForm ('#btnaddgroup','dhrubackup','#frm','#notification','true','#main_loader');\"/>\n\n<input value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["key"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\"\nonclick=\"javascript:\nresetKey();\nSubmitForm ('#btnaddgroup','dhrubackup','#frm','#notification','true','#main_loader');\"/>\n</p>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>