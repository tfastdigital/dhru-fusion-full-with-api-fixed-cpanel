<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n<script>\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n    }\n}\n\$(document).ready(function(){\n\t\$(\".toggle_container\").hide();\n\t\$(\"input.trigger\").click(function(){\n\t\t\$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n\t});\n});\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$survey = mysqli_fetch_assoc(dquery("select * from tbl_survey where id='" . $id . "'"));
echo "\n<form method=\"post\" id=\"frms\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table  class=\"form\" >\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["survey"];
echo " ";
echo $LNG["title"];
echo " </td>\n<td class=\"fieldarea\"><input type=\"text\" name=\"title\"  value=\"";
echo $survey["title"];
echo "\" /></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["survey"];
echo " ";
echo $LNG["detail"];
echo " </td>\n<td class=\"fieldarea\"><textarea name=\"detail\">";
echo $survey["detail"];
echo "</textarea>\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["status"];
echo " </td>\n<td class=\"fieldarea\">\n<input type=\"radio\" name=\"status\" value=\"0\"\n";
if (!$survey["status"]) {
    echo "checked='checked'";
}
echo " id=\"se\" /><label for=\"se\">";
echo $LNG["pending"];
echo "</label>\n<input type=\"radio\" name=\"status\" value=\"1\"\n";
if ($survey["status"]) {
    echo "checked='checked'";
}
echo " id=\"sd\" /><label for=\"sd\">";
echo $LNG["completed"];
echo "</label>\n</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["requiredcaptcha"];
echo " </td>\n<td class=\"fieldarea\">\n<input type=\"radio\"\n";
if ($survey["captcha"]) {
    echo "checked='checked'";
}
echo "  name=\"captcha\" value=\"1\" id=\"ec\" /> <label for=\"ec\">";
echo $LNG["yes"];
echo "</label>\n<input type=\"radio\"\n";
if (!$survey["captcha"]) {
    echo "checked='checked'";
}
echo "  name=\"captcha\" value=\"0\" id=\"ed\" /> <label for=\"ed\">";
echo $LNG["no"];
echo "</label>\n</td>\n</tr>\n<tr>\n<td class=\"fieldarea\">&nbsp;</td>\n<td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','editsurvey','#frms','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody></table>\n\n\n</form>\n<br /><br />\n";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("survey_" . $id, $id);
echo "<form id=\"frmedituser\" name=\"\" method=\"post\">\n<div  class=\"groupstabes\" >\n          <h2>\n            <span class=\"groupstabesheadertext\">";
echo $LNG["survey"];
echo " ";
echo $LNG["field"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n\n\n<input type=\"button\" style=\"float: right; width: 150px;\" class=\"trigger\"  value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["survey"];
echo " ";
echo $LNG["field"];
echo "\"/>\n<div class=\"toggle_container clear\">\n<input type=\"hidden\" value=\"";
echo "survey_" . $id;
echo "\" name=\"customfield[-1][type]\"/>\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n <div style=\"margin: 2px;\">\n        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\">\n        <tbody>\n        <tr><td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["name"];
echo "</td><td class=\"fieldarea\"><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\" /> * </td></tr>\n        <tr><td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td><td class=\"fieldarea\"><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td></tr>\n        <tr><td class=\"fieldlabel\">";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</td><td class=\"fieldarea\"><select name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option><option value=\"radio\">";
echo $LNG["radio"];
echo "</option></select></td></tr>\n        <tr><td class=\"fieldlabel\">";
echo $LNG["fieldoptions"];
echo "</td><td class=\"fieldarea\"><input name=\"customfield[-1][fieldoptions]\" value=\"\" type=\"text\" /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td> </tr>\n        <tr><td class=\"fieldlabel\">";
echo $LNG["validation"];
echo "</td><td class=\"fieldarea\"><input name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\" /> <small>";
echo $LNG["regularexpression"];
echo "</small></td></tr>\n        <tr><td class=\"fieldlabel\">";
echo $LNG["required"];
echo "</td><td class=\"fieldarea\"><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\" type=\"checkbox\" /> ";
echo $LNG["survey"];
echo " ";
echo $LNG["field"];
echo " ";
echo $LNG["required"];
echo "</td></tr>\n        <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\">\n        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"\n        onclick=\"SubmitForm ('#btnedituser','editsurvey','#frmedituser','#notification','true','#main_loader');\"/> </td></tr>\n        </tbody>\n        </table>\n    </div>\n</div>\n<div class=\"clear\"></div>\n\n\n          </h2>\n          <div class=\"groupstabescontant\">\n\n\n";
if ($row) {
    foreach ($row as $key => $value) {
        echo "    <div style=\"width: 49.5%; float: left; margin: 2px;\" id=\"table_";
        echo $key;
        echo "\">\n        <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\"><tbody>\n        <tr><td class=\"fieldlabel\" width=\"30%\">";
        echo $LNG["name"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["fieldname"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\">";
        echo $LNG["description"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["description"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\">";
        echo $LNG["field"];
        echo " ";
        echo $LNG["type"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["fieldtype"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\">";
        echo $LNG["fieldoptions"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["fieldoptions"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\">";
        echo $LNG["validation"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["regexpr"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\">";
        echo $LNG["required"];
        echo "</td><td class=\"fieldarea\">";
        echo $row[$key]["required"];
        echo " ";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["field"];
        echo " ";
        echo $LNG["required"];
        echo "</td></tr>\n        <tr><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input value=\"";
        echo $LNG["delete"];
        echo "\" id=\"";
        echo $key;
        echo "\" class=\"button_remove\" type=\"button\"  onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></td></tr>\n        </tbody></table>\n    </div>\n    ";
    }
}
echo "<div class=\"clear\"></div>\n\n    </div>\n</div>\n\n<div class=\"fixedbtn\">\n     <input value=\"";
echo $LNG["save"];
echo " ";
echo $LNG["all"];
echo "\"\n     id=\"btnedituser\" class=\"button_save\" type=\"button\"\n     onclick=\"SubmitForm ('#btnedituser','editsurvey','#frmedituser','#notification','true','#main_loader');\"/>\n    <div class=\"clear\"></div>\n</div>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>