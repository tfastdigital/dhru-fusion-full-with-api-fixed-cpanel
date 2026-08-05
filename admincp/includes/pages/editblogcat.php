<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<div id=\"tabcontent\">\n\n";
$pageid = 244;
checkPagePermission($pageid);
$blog = mysqli_fetch_assoc(dquery("Select * from tbl_blogcats where id='" . $id . "'"));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $blog["id"];
echo "\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["category"];
echo " ";
echo $LNG["name"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["category"];
echo " ";
echo $LNG["name"];
echo "*</td>\n    <td class=\"fieldarea\"><input name=\"name\"  value=\"";
echo $blog["name"];
echo "\" type=\"text\" class=\"medium txt\"/></td>\n</tr>\n\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','editblogcat','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n\n</div></div>\n</form>\n</div></div>\n </div>";
$fileverioncheck = "6.1.0";

?>