<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($save) {
    dquery("UPDATE `tbl_products` SET `download_id` = '" . $allowedid . "' WHERE `id` ='" . $id . "'");
}
$prod = mysqli_fetch_assoc(dquery("select download_id from tbl_products where id='" . $id . "'"));
echo "<link rel=\"stylesheet\" href=\"../../templates/";
echo $_SESSION["admin_template"];
echo "/x-main2.css\" />\n<script src=\"../js/jquery.js\"></script>\n<script>\n\$(document).ready(function() {\n    \$(\"#add\").click(function() {\n         \$('#file option:selected').appendTo('#allowed');\n         \n         \$('#allowed :selected').each(function(i, selected){ \n             var vals=\$(\"#allowedid\").val();\n             if(vals==\"\"){\n                \$(\"#allowedid\").val(\$(selected).val());\n             }else{\n                \$(\"#allowedid\").val(vals+\",\"+\$(selected).val());\n             } \n        });\n    });\n      \$(\"#remove\").click(function() {\n         \$('#allowed option:selected').appendTo('#file');\n         \$(\"#allowedid\").val(\"\");\n         \$('#allowed option').each(function(i, selected){ \n             var vals=\$(\"#allowedid\").val();\n             if(\$(selected).val()!=null){\n                 if(vals==\"\"){\n                    \$(\"#allowedid\").val(\$(selected).val());\n                 }else{\n                    \$(\"#allowedid\").val(vals+\",\"+\$(selected).val());\n                 } \n             }\n        });\n        \n    });\n});\n</script>\n<form method=\"post\" >\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Select Group</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\">\n<tr>\n<td>\n<select name=\"group\" style=\"min-width: 200px;\" onchange=\"location.href='downloadlist.php?id=";
echo $id;
echo "&group='+this.value\" >\n";
$gr = dquery("select * from tbl_downloadcat");
while ($rg = mysqli_fetch_assoc($gr)) {
    echo "<option ";
    if ($group == $rg["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $rg["id"];
    echo "\">";
    echo $rg["category"];
    echo "</option>\n";
}
echo "</select>\n</td>\n</tr></table>\n</div></div>\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Choose Files</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n<tr>\n<td width=\"210px\">\n\n";
if (!$group) {
    $group = mysqli_fetch_assoc(dquery("select id from tbl_downloadcat"));
    $group = $group["id"];
}
if ($prod["download_id"]) {
    $di = $prod["download_id"];
} else {
    $di = 0;
}
echo "<select name='file' id='file' multiple=\"multiple\" size=\"10\" style=\"min-width: 200px;\" >\n";
$sql = dquery("select id,filename from tbl_download WHERE group_id='" . $group . "' and forproduct='1'\n    AND id NOT IN(" . $di . ")");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value='" . $row["id"] . "'>" . $row["filename"] . "</option>";
}
echo "</select>\n</td>\n<td width=\"100px\" align=\"center\">\n<input type=\"button\" name=\"add\" value=\">>\" id=\"add\"   />\n<br /><br />\n<input type=\"button\" name=\"remove\" value=\"<<\" id=\"remove\" />\n</td>\n<td>\n<select name='allowed' id='allowed' multiple=\"multiple\" size=\"10\" style=\"min-width: 200px;\" >\n";
$s = dquery("select id,filename from tbl_download where id IN (" . $prod["download_id"] . ")");
while ($dg = mysqli_fetch_assoc($s)) {
    echo "    <option value=\"";
    echo $dg["id"];
    echo "\">";
    echo $dg["filename"];
    echo "</option>\n    ";
}
echo "</select>\n<input type=\"hidden\" name=\"allowedid\" id=\"allowedid\" value=\"";
echo $prod["download_id"];
echo "\" />\n</td>\n</tr>\n<tr>\n<td colspan=\"3\">\n<input type=\"submit\" class=\"btn save\" name=\"save\" value=\"";
echo $LNG["save"];
echo "\" />\n</td>\n</tr>\n</table>\n</div></div>\n</form>";
$fileverioncheck = "6.1.0";

?>