<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit;
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n\n\n<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n\n \$(\"#type\").change(function () {\n\n      \$.post('includes/pages/getAffiliate.php',{type: \$(this).val()}, function(data) {\n          \$('#groups').html(data);\n      });\n});\n\n     \$(\"#group\").change(function () {\n      var t=\$(\"#type\").val();\n          \$.post('includes/pages/getAffiliate.php',{group: \$(this).val(),types: t}, function(data) {\n              \$('#services').html(data);\n          });\n    });\n</script>\n\n\n\n\n          <div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Banner</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form method=\"post\" id=\"frm\">\n<table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" class=\"form\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["title"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"name\" value=\"\" />\n    </span>\n    <small>e.g Left Side 100 X 400 </small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["banner"];
echo " ";
echo $LNG["size"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt small\"  name=\"width\" value=\"\" /> X\n    <input type=\"text\"  class=\"txt small\"  name=\"height\" value=\"\" />\n    </span>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["bannerimg"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\"  class=\"txt medium\" name=\"banner\" id=\"banner\" /> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onclick=\"newWindow('includes/gallery.php?id=banner', 'windowname1')\" />\n    </span>\n\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["product"];
echo " ";
echo $LNG["group"];
echo " or ";
echo $LNG["product"];
echo "</td>\n    <td class=\"fieldarea\"><div>\n   <select id=\"type\" name=\"type\">\n   <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
if ($IsFileOnly) {
    echo "    <option value=\"file\">File</option>\n    ";
} else {
    echo "       ";
    if (!$OnlyEcommerce) {
        echo "       <option value=\"imei\">IMEI</option>\n       <option value=\"file\">File</option>\n       <option value=\"server\">Server</option>\n       ";
    }
    echo "       <option value=\"product\">Product</option>\n   ";
}
echo "   </select></div>\n   <div id=\"groups\"><span id=\"group\"></span></div>\n   <div id=\"services\"></div>\n\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Alt Tag</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"alttag\" value=\"\" />\n    </span>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\"  class=\"txt medium\" name=\"description\" value=\"\" />\n    </span>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><span>\n<input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"\n onclick=\"SubmitForm ('#btnoverview','affiliate.banner','#frm','#notification','true','#main_loader');\"/>\n    </span></td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n</div></div>\n\n\n\n\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th>";
echo $LNG["title"];
echo "</th>\n        <th>";
echo $LNG["image"];
echo " </th>\n        <th align=\"center\">";
echo $LNG["action"];
echo " </th>\n\n  </tr>\n</thead>\n<tbody>\n\n\n";
if (isset($delete)) {
    dquery("delete from tbl_affiliate_banner where id='" . $id . "'");
}
$bann = dquery("SELECT * FROM tbl_affiliate_banner");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "\n\n    <tr>\n        <td>";
    echo $row["name"];
    echo "</td>\n        <td>";
    echo $row["banner"];
    echo "</td>\n        <td>\n        <form method=\"post\" onsubmit=\"return confirm('Are you sure want to remove affiliate banner ?');\"><input type=\"hidden\" name=\"id\" value=\"";
    echo $row["id"];
    echo "\" /><input type=\"submit\" class=\"button deletedata\" name=\"delete\" value=\"";
    echo $LNG["delete"];
    echo "\" /></form> </td>\n        <div style=\"clear: both;\"></div>\n    </tr>\n\n    ";
}
echo "\n</tbody></table>\n</div></div>\n\n";
$fileverioncheck = "6.1.0";

?>