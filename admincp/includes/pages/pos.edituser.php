<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 220;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
$custom = getCustomFields("regis", "", $id);
$exp = explode(",", $_SESSION["page_access"]);
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["verified"];
echo "\" name=\"verified\"/>\n<input type=\"hidden\" value=\"";
echo $clientDetails["phonenumber"];
echo "\" name=\"phonenumber\"/>\n";
echo generate_token("form");
echo "\n<div>\n<div  class=\"groupstabes\">\n<h2>\n\n<span class=\"groupstabesheadertext\">";
echo $LNG["profile"];
echo " <a style=\"float: right;\" href=\"javascript:load_fromsubpage('edituser.invoice&id=";
echo $id;
echo "','View Invoice','clients')\">View Invoice</a></span>\n</h2>\n <div class=\"groupstabescontant\">\n    <table width=\"100%\" class=\"form\">\n<tbody>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"0\" ";
if ($clientDetails["userstatus"] == "0") {
    echo "checked";
}
echo "/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\" id=\"inactive\" value=\"2\" ";
if ($clientDetails["userstatus"] == "2") {
    echo "checked";
}
echo "/><label for=\"inactive\">";
echo $LNG["inactive"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\"  id=\"blocked\" value=\"1\" ";
if ($clientDetails["userstatus"] == "1") {
    echo "checked";
}
echo "/><label for=\"blocked\">";
echo $LNG["blocked"];
echo " </label></span>\n    </td>\n</tr>\n<script>\n\$('#blocked').click(function() {\n    \$('#showblock').show();\n});\n\$('#active').click(function() {\n    \$('#showblock').hide();\n});\n\$('#inactive').click(function() {\n    \$('#showblock').hide();\n});\n</script>\n<tr id=\"showblock\" style=\"display:";
if ($clientDetails["userstatus"] != "1") {
    echo "none";
}
echo "\">\n    <td class=\"fieldlabel\">";
echo $LNG["bloack"];
echo " ";
echo $LNG["reason"];
echo "</td>\n    <td class=\"fieldarea\">\n    <textarea name=\"block_reason\">";
echo $clientDetails["block_reason"];
echo "</textarea>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo "</td>\n    <td><span>";
echo $clientDetails["username"];
echo "</span></td>\n    <input type=\"hidden\" name=\"username\" value=\"";
echo $clientDetails["username"];
echo "\" />\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"password\" id=\"password\" value=\"\" type=\"text\"  class=\"txt\" style=\"width: 100px;\"/> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["resetpass"];
echo "\" name=\"resetpass\" id=\"btnedituserpass\" onclick=\"genpass();\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["firstname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"firstname\"  value=\"";
echo $clientDetails["firstname"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["lastname"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"lastname\"  value=\"";
echo $clientDetails["lastname"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["registeredemail"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"";
echo $clientDetails["email"];
echo "\" type=\"text\"  class=\"txt medium\" onblur=\"checkEmail(this.value)\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["company"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"company\"  value=\"";
echo $clientDetails["companyname"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo " line 1</td>\n    <td class=\"fieldarea\"><textarea name=\"address\">";
echo $clientDetails["address1"];
echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo " line 2</td>\n    <td class=\"fieldarea\"><textarea name=\"address2\">";
echo $clientDetails["address2"];
echo "</textarea></td>\n</tr>\n<tr>\n\t\t<td class=\"fieldlabel\">";
echo $LNG["state"];
echo "</td>\n\t\t<td class=\"fieldarea\"><input name=\"state\"  value=\"";
echo $clientDetails["state"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["city"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"city\"  value=\"";
echo $clientDetails["city"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["zip"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"zip\"  value=\"";
echo $clientDetails["zip"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown($clientDetails["country"]);
echo "</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phonenumber"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input style=\"float:  left;\" name=\"phonenumber\"\n    value=\"";
echo $clientDetails["phonenumber"];
echo "\"\n    type=\"text\"  class=\"txt medium\"/><span style=\"float:  left;left: 100px;\"><input type=\"checkbox\"\n    class=\"onoff {labelOn: 'Verified', labelOff: 'Unverified'}\"\n         id=\"verifeds\" name=\"verifiedm\" value=\"1\" ";
if ($clientDetails["verified"] == "1") {
    echo "checked";
}
echo "/><label for=\"verifeds\"></label></span>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getLanguageDropdown2($clientDetails["language"]);
echo "</td>\n</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["theme"];
echo "</td>\n    <td class=\"fieldarea\">\n   ";
echo getTemplatesDropDown($clientDetails["template"], "template", false, false);
echo "</td>\n</tr>\n\n\n";
if ($custom) {
    echo "\n\n\n    ";
    foreach ($custom as $val) {
        echo "        <tr><td class=\"fieldlabel\">";
        echo $val["name"];
        echo "</td><td class=\"fieldarea\"><span>";
        echo $val["input"];
        echo "</span></td></tr>\n    ";
    }
    echo "\n\n";
}
echo "\n<tr><td> </td> <td><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','edituser.profile','#frmedituser','#notification','true','#main_loader');\"/></td> </tr>\n</tbody>\n    </table>\n\n\n<p align=\"right\" class=\"clear\">\n\n\n\n<input type=\"button\" class=\"button_remove\" name=\"ccinfo\"\nvalue=\"";
echo $LNG["remove"];
echo " Credit Card\" id=\"btncc\"\nonclick=\"SubmitForm ('#btncc','edituser.removecc','#frmedituser','#notification','true','#main_loader');\" />\n";
if (in_array(55, $exp)) {
    echo "<input type=\"button\" class=\"button_remove\" name=\"note\" value=\"";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo "\" id=\"btnclose\"\nonclick=\"load_subpage('main2.php?page=edituser.closeaccount&id=";
    echo $id;
    echo "','";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo "')\" />\n";
}
echo "</p>\n\n\n\n\n<div class=\"clear\"></div>\n</div>\n</div> </div>\n\n</form>\n</div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>