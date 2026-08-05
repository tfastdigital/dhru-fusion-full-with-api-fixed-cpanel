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
echo "<script>\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('customlength').style.display='none';\n\t\tdocument.getElementById('customimeiname').style.display='none';\n\t\tdocument.getElementById('customimeiinfo').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('customlength').style.display='table-row';\n\t\tdocument.getElementById('customimeiname').style.display='table-row';\n\t\tdocument.getElementById('customimeiinfo').style.display='table-row';\n\t}\n}\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n    }\n}\n\$(document).ready(function(){\n\t\$(\".toggle_container\").hide();\n\t\$(\"input.trigger\").click(function(){\n\t\t\$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n\t});\n});\n</script>\n\n<script>\nfunction changeexp(ids)\n{\n    if(ids)\n    {\n        document.getElementById('regexp').style.display='';\n    }else{\n        document.getElementById('regexp').style.display='none';\n    }\n\n}\nfunction showtab(ids){\n    \$(\"#show_\"+ids).toggle();\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<br />\n";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("contactus", $id);
echo "\n<input type=\"hidden\" value=\"contactus\" name=\"customfield[-1][type]\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n\n        <table id=\"main_tbl\">\n        <thead>\n            <tr>\n                <th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n                <th>";
echo $LNG["name"];
echo "</th>\n                <th>";
echo $LNG["fieldoptions"];
echo " <br /> <small style=\"font-size: 11px;\">";
echo $LNG["seperatedbycommas"];
echo "</small>  </th>\n                <th>Description</th>\n                <th>";
echo $LNG["validation"];
echo "</th>\n                <th> Required </th>\n                <th>Action</th>\n            </tr>\n        </thead>\n        <tbody>\n        <tr class=\"adddatarow\">\n            <td><select name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option></select></td>\n            <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/>  </td>\n            <td><input name=\"customfield[-1][fieldoptions]\" value=\"\" type=\"text\" /> </td>\n            <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n            <td><input name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\" /> </td>\n            <td><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\" type=\"checkbox\" /> </td>\n            <td><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','registrationsetting','#frm','#notification','true','#main_loader');\"/> </td>\n        </tr>\n\n        ";
if ($row) {
    foreach ($row as $key => $value) {
        echo "        <tr>\n        <td>";
        echo $row[$key]["fieldtype"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldname"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldoptions"];
        echo "</td>\n        <td>";
        echo $row[$key]["description"];
        echo "</td>\n        <td>";
        echo $row[$key]["regexpr"];
        echo "</td>\n        <td>";
        echo $row[$key]["required"];
        echo "  </td>\n        <td><input value=\"";
        echo $LNG["delete"];
        echo "\" id=\"";
        echo $key;
        echo "\"  type=\"button\"  onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></td></tr>\n    ";
    }
}
echo "\n\n\n        </tbody>\n        </table>\n\n\n\n</div>\n<p class=\"fixedbtn\">   <input value=\"";
echo $LNG["save"];
echo " ";
echo $LNG["all"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','customsettings','#frm','#notification','true','#main_loader');\"/>\n</p>\n\n</form>\n</div>";
$fileverioncheck = "6.1.0";

?>