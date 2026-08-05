<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<style>\n.list{\n    cursor: pointer;\n}\n.list:hover{\n    background-color: #E9E9E9;\n}\n#clientlist{\n    background: none repeat scroll 0 0 white;\n    border: 1px solid #F4F4F4;\n    box-shadow: 0 0 5px rgba(0,0,0,0.2);\n    padding: 5px;\n    width: 152px;\n    z-index:9;\n}\n#clientlist li{padding:5px;list-style: none;}\n</style>\n<script>\n\$(document).ready(function(){\t\n    \$('#cid').keyup(function() {\n        var search=\$(this).val();\n        if(search.length>2){\n            \$.post('includes/pages/pos.sales.product.php?directorder='+search, function(data) {\n                if(data){\n                     \$('#clientlist').show();\n                     \$('#clientlist').html(data);\n                 }\n            });\n        }\n    });\n});\nfunction setValse(vals){\n    var part;\n    part=vals.split(\"=\");\n    \$('#email').val(part[0]);\n    \$('#cid').val(part[1]);\n    \$('#clientlist').hide();\n}\n</script>\n";
$pageid = 536;
checkPagePermission($pageid);
echo "<div id=\"content\">\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["client"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"client\" id=\"cid\"\n           value=\"";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "\" autocomplete=\"off\"\n    onfocus=\"if(this.value=='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "')value='';\"\n onblur=\"if(this.value=='')this.value='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "';\" />\n    <div style=\"display: none;position: absolute;\" id=\"clientlist\"></div>            \n   </span>\n\n   </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["department"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"department\">\n        ";
$sql = dquery("select * from tbl_support_department");
while ($r = mysqli_fetch_assoc($sql)) {
    echo "        <option value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["department"];
    echo "</option>\n    ";
}
echo "        </select>\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["subject"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" class=\"txt large\" name=\"subject\" />\n   </td>\n</tr>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["message"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"message\" cols=\"50\" rows=\"5\"></textarea>\n   </td>\n</tr>\n\n<tr>\n<td></td>\n<td class=\"fieldarea\">\n<input value=\"";
echo $LNG["create"];
echo " ";
echo $LNG["ticket"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  \nonclick=\"SubmitForm ('#btnoverview','support.create','#frm','#notification','true','#main_loader','true');\"/>\n</td>\n</tr>\n</tbody>\n</table>\n\n\n\n</form>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>