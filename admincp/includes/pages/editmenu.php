<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n<script>\nfunction setLangValue(val,vals){\n    \$(\"#languagevar\").val(val);\n    \$('#finded').html(val);\n    \$(\"#search\").hide();\n    \$(\"#find\").val(vals);\n}\n\t\$(document).ready(function(){\n\t \t\$(\"#find\").keyup(function(){\n\t        \n            if(\$(this).val().length>2){\n                \$(\"#search\").show();\n    \t\t    \$.post( \"includes/pages/searchlang.php\",{val: \$(this).val()}, function( data ) {\n                    \$(\"#search\").html( data );\n                });\n            }else{\n                \$(\"#search\").html('');\n                \$(\"#search\").hide();\n            }\n            \n\t\t});  \n    });\n</script>\n<link href=\"../includes/icons/menu-icon.css\" rel=\"stylesheet\" />\n";
$pageid = 381;
checkPagePermission($pageid);
if ($page == "editmenu") {
    $nav = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_navigation` WHERE `id`='" . $id . "'"));
    echo "<div id=\"tabcontent\"> ";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"\">\n<form id=\"frm\" name=\"\" method=\"post\">\n ";
if ($nav["locked"]) {
    echo " <input type=\"hidden\" name=\"locked\" value=\"1\" />\n ";
}
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"10%\">";
echo $LNG["name"];
echo " </td>\n    <td  class=\"fieldarea\" width=\"35%\"><input  name=\"name\" id=\"find\"  value=\"";
echo $nav["name"];
echo "\" type=\"text\"/>\n    <input  name=\"languagevar\" id=\"languagevar\" \n     value=\"";
echo $nav["languagevar"];
echo "\" type=\"hidden\"/><span id=\"finded\"> ";
echo $nav["languagevar"];
echo "</span>\n    <div id=\"search\"></div> \n      </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["link"];
echo " </td>\n    <td class=\"fieldarea\"><input ";
if ($nav["locked"]) {
    echo "disabled";
}
echo " \n    name=\"link\" id=\"link\"  value=\"";
if ($config["cms_seofriendly"] == "off" && $nav["locked"]) {
    echo $nav["linkphp"];
} else {
    echo $nav["link"];
}
echo "\" type=\"text\"/>\n    <span >";
echo $LNG["or"];
echo "</span> \n    <select name=\"url\" onChange=\"generatelink(this.value)\"  ";
if ($nav["locked"]) {
    echo "disabled";
}
echo ">\n    <option value=\"\">\nSelect\n</option>\n    ";
$sql = dquery("SELECT `id`,`urlname` FROM tbl_cms_pages");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <option value=\"";
    if ($config["cms_seofriendly"] == "on") {
        echo $row["urlname"] . "-1";
    } else {
        echo $row["id"] . "-0";
    }
    echo "\">\n";
    echo $row["urlname"];
    echo "</option>\n    ";
}
echo "</select></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"external\" ";
if ($nav["external"]) {
    echo "checked='checked'";
}
echo "  value=\"1\" id=\"line\" /> <label for=\"line\">";
echo $LNG["linkexternal"];
echo "</label></td>\n    <td></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"openinnew\" ";
if ($nav["newwindow"]) {
    echo "checked='checked'";
}
echo " value=\"1\" id=\"open\" /> <label for=\"open\">";
echo $LNG["openinnew"];
echo "</label></td>\n    <td></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " </td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <input type=\"radio\" name=\"display\" id=\"edi\" value=\"1\" ";
if ($nav["display"]) {
    echo "checked";
}
echo " /><label for=\"edi\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"display\" id=\"ddi\" value=\"0\" ";
if (!$nav["display"]) {
    echo "checked";
}
echo " /><label for=\"ddi\">";
echo $LNG["no"];
echo "</label>    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["dontshowifloged"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n<input type=\"checkbox\" name=\"afterloginshow\"  id=\"addi\" value=\"1\"  ";
if (!$nav["afterloginshow"]) {
    echo "checked";
}
echo " /> <label for=\"addi\"></label>  </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["login"];
echo " ";
echo $LNG["required"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <input type=\"radio\" name=\"req_login\" ";
if ($nav["locked"]) {
    echo "disabled";
}
echo " id=\"rdi1\" value=\"1\" ";
if ($nav["req_login"]) {
    echo "checked";
}
echo " /><label for=\"rdi1\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"req_login\" ";
if ($nav["locked"]) {
    echo "disabled";
}
echo " id=\"rdi2\" value=\"0\" ";
if (!$nav["req_login"]) {
    echo "checked";
}
echo " /><label for=\"rdi2\">";
echo $LNG["no"];
echo "</label>    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["icon"];
echo " ";
echo $LNG["link"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"2\">\n    <i class=\"icon ";
echo $nav["icon"];
echo "\" id=\"view-icon\" \n    style=\"vertical-align:middle;height:60px;width:60px;\"></i>\n    <input type=\"hidden\" name=\"icon\" id=\"icon\" value=\"";
echo $nav["icon"];
echo "\" />\n      <a style=\"text-decoration: none;\" class=\"default_dg_a2\" href=\"javascript: void(0)\" \n       onclick=\"window.open('includes/pages/iconlink.php', \n\t  'windowname1', \n\t  'scrollbars=yes,width=500, height=400'); \n\t   return false;\">";
echo $LNG["pickfromicongallery"];
echo "</a>\n    </td>\n </tr>\n -->\n  \n \n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\"\n type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editmenu','#frm','#notification','true','#main_loader');\"/>  \n</div>\n \n</form>\n</div></div>\n<script>\nfunction generatelink(val){\n\n    ARR=val.split(\"-\");\n    if(true){\n        document.getElementById('link').value='";
echo _url("pages/");
echo "'+ARR[0];\n    }else{\n        document.getElementById('link').value='cms.php?pageid='+ARR[0];\n    }\n}\n</script>\n";
if ($id) {
    echo " </div> ";
}
$fileverioncheck = "6.1.0";

?>