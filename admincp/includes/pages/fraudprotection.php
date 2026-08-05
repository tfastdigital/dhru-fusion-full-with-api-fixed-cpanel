<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"\">\n";
$pageid = 534;
checkPagePermission($pageid);
echo "<script>\n    function showCg(){\n\n        \$(\".clientg\").show();\n    }\n    function hideCg(){\n        \$(\".clientg\").hide();\n    }\nfunction showChecked(on){\n    if(on){\n        \$(\"#showchk\").show();\n    }else{\n        \$(\"#showchk\").hide();\n    }\n}\n</script>\n<form id=\"frmd\" name=\"frmd\" method=\"post\">\n";
echo generate_token("form");
echo "\n    <div  class=\"groupstabes first\" >\n        <h2>\n            <span class=\"groupstabesheadertext\">Fraud Protection</span>\n        </h2>\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">Block Account</td>\n    <td class=\"fieldarea\">\n    <input name=\"autofraudclose\"    value=\"0\" type=\"radio\" id=\"trs\"\n    ";
if (!$config["autofraudclose"]) {
    echo "checked";
}
echo " />\n     <label for=\"trs\" >Yes</label>\n    <input name=\"autofraudclose\"  value=\"1\" type=\"radio\" id=\"tr1s\"\n    ";
if ($config["autofraudclose"] == 1) {
    echo "checked";
}
echo " />\n    <label for=\"tr1s\" >No</label>\n    <small>Auto Account block on new paypal unauthorised claim detect</small>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">Fraud Cage</td>\n    <td class=\"fieldarea\">\n    <input name=\"fraudcage\"    value=\"0\" type=\"radio\" id=\"trs\"\n    ";
if (!$config["fraudcage"]) {
    echo "checked";
}
echo " />\n     <label for=\"trs\" >Yes</label>\n    <input name=\"fraudcage\"  value=\"1\" type=\"radio\" id=\"tr1s\"\n    ";
if ($config["fraudcage"] == 1) {
    echo "checked";
}
echo " />\n    <label for=\"tr1s\" >No</label>\n    <small>Before Add Fund check black listed payer in FradCage database</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " PayPal Unverified\n        ";
echo $LNG["transaction"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type='checkbox'\n               class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n               name=\"directunverified\" value=\"1\" id=\"dsme\" ";
if ($config["directunverified"]) {
    echo "checked";
}
echo " />\n        <small>";
echo $LNG["allow"];
echo " ";
echo $LNG["paid"];
echo " ";
echo $LNG["but"];
echo " ";
echo $LNG["unverified"];
echo " ";
echo $LNG["transaction"];
echo "</small>\n    </td>\n</tr>\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["required"];
echo " ";
echo $LNG["phone"];
echo "    ";
echo $LNG["number"];
echo " ";
echo $LNG["verification"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input name=\"mobile_verification\"  onclick=\"showChecked(true)\"    value=\"1\" type=\"radio\" id=\"tr\"\n    ";
if ($config["mobile_verification"] == 1) {
    echo "checked";
}
echo " />\n     <label for=\"tr\" >Yes</label>\n    <input name=\"mobile_verification\"  onclick=\"showChecked(false)\"  value=\"0\" type=\"radio\" id=\"tr1\"\n    ";
if (!$config["mobile_verification"]) {
    echo "checked";
}
echo " />\n    <label for=\"tr1\" >No</label>\n        &nbsp;&nbsp;&nbsp;&nbsp;  <label><input type=\"checkbox\" value=\"1\"   ";
if ($config["autoverifycredits"]) {
    echo "checked";
}
echo " name=\"autoverifycredits\" /> Auto Verify using WhatsApp/Call credits</label>\n    </td>\n</tr>\n\n<!--\n<tr>\n    <td class=\"fieldlabel\"> Captcha\n         </td>\n    <td class=\"fieldarea\">\n        <input name=\"captchaonnewsletter\"    value=\"1\" type=\"radio\" id=\"ntr\"\n             />\n        <label for=\"ntr\" >Yes</label>\n        <input name=\"captchaonnewsletter\"    value=\"0\" type=\"radio\" id=\"ntr1\"\n             />\n        <label for=\"ntr1\" >No</label>\n    </td>\n</tr>-->\n\n<tr>\n    <td class=\"fieldlabel\">Paypal from email required to Invoice autopay</td>\n    <td class=\"fieldarea\">\n        <input name=\"paypalemailautopay\"    value=\"1\" type=\"radio\" id=\"sntr\"\n            ";
if ($config["paypalemailautopay"] == 1) {
    echo "checked";
}
echo " />\n        <label for=\"sntr\" >Yes</label>\n        <input name=\"paypalemailautopay\"    value=\"0\" type=\"radio\" id=\"sntr1\"\n            ";
if (!$config["paypalemailautopay"]) {
    echo "checked";
}
echo " />\n        <label for=\"sntr1\" >No</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["otpfordirect"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input name=\"otpfordirectfund\"    value=\"0\" type=\"radio\" id=\"tidv\"\n            ";
if (!$config["otpfordirectfund"]) {
    echo "checked";
}
echo " />\n        <label for=\"tidv\" >Yes</label>\n        <input name=\"otpfordirectfund\"    value=\"1\" type=\"radio\" id=\"tidvn\"\n            ";
if ($config["otpfordirectfund"]) {
    echo "checked";
}
echo " />\n        <label for=\"tidvn\" >No</label>\n        <small> ";
echo $LNG["paidbydirectpaypal"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">ID Verification/KYC</td>\n    <td class=\"fieldarea\">\n        <input name=\"idverification\" onclick=\"showCg()\"   value=\"1\" type=\"radio\" id=\"idv\"\n            ";
if ($config["idverification"] == 1) {
    echo "checked";
}
echo " />\n        <label for=\"idv\" >Yes</label>\n        <input name=\"idverification\"  onclick=\"hideCg()\"   value=\"0\" type=\"radio\" id=\"idvn\"\n            ";
if (!$config["idverification"]) {
    echo "checked";
}
echo " />\n        <label for=\"idvn\" >No</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">ID verification image helper</td>\n    <td class=\"fieldarea\">\n        <input name=\"idhelperimage\"    value=\"1\" type=\"radio\" id=\"hidv\"\n            ";
if ($config["idhelperimage"] == 1) {
    echo "checked";
}
echo " />\n        <label for=\"hidv\" >Yes</label>\n        <input name=\"idhelperimage\"   value=\"0\" type=\"radio\" id=\"hidvn\"\n            ";
if (!$config["idhelperimage"]) {
    echo "checked";
}
echo " />\n        <label for=\"hidvn\" >No</label>\n    </td>\n</tr>\n\n<tr class=\"clientg\" ";
if (!$config["idverification"]) {
    echo "style='display:none;'";
}
echo ">\n    <td class=\"fieldlabel\">ID Verification/KYC required for Add fund more than</td>\n    <td class=\"fieldarea\">\n            <input type=\"text\" name=\"addfundkyc\" value=\"";
echo $config["addfundkyc"];
echo "\" class=\"small\" /> ";
echo $_SESSION["currency"]["code"];
echo "    </td>\n</tr>\n\n<tr class=\"clientg\" ";
if (!$config["idverification"]) {
    echo "style='display:none;'";
}
echo ">\n    <td class=\"fieldlabel\">ID Verification/KYC required for Place Order</td>\n    <td class=\"fieldarea\">\n        <label><input type=\"checkbox\" ";
if ($config["defaultgroupverification"]) {
    echo "checked";
}
echo " name=\"clientgroup[9999]\" />Default</label>&nbsp;&nbsp;&nbsp;&nbsp;\n        <br />\n        ";
$qg = dquery("select id,groupname,idverification from tbl_client_group");
while ($rg = mysqli_fetch_assoc($qg)) {
    $checked = "";
    if ($rg["idverification"]) {
        $checked = "checked";
    }
    echo "            <label><input type=\"checkbox\" ";
    echo $checked;
    echo "                          name=\"clientgroup[";
    echo $rg["id"];
    echo "]\" />";
    echo $rg["groupname"];
    echo "</label>&nbsp;&nbsp;&nbsp;&nbsp;\n            <br />\n            ";
}
echo "\n    </td>\n</tr>\n\n<!--\n<tr id=\"showchk\" style=\"";
if ($config["mobile_verification"] != 1) {
    echo "display: none;";
}
echo "\" >\n    <td></td>\n    <td>\n\n    <span id=\"showbysms\" style=\"";
if (licince\reqaddon("SMS", true) != 1) {
    echo "display: none;";
}
echo "\">\n    <input type=\"checkbox\" name=\"mobverbysms\" ";
if ($config["mobverbysms"] == 1) {
    echo "checked='checked'";
}
echo " value=\"1\" id=\"mobverbysms\" />\n     <label for=\"mobverbysms\">";
echo $LNG["by"];
echo " SMS</label>\n    </span>\n     <input type=\"checkbox\" name=\"mobverbycall\" ";
if ($config["mobverbycall"] == 1) {
    echo "checked='checked'";
}
echo " value=\"1\" id=\"mobverbycall\" />\n     <label for=\"mobverbycall\">";
echo $LNG["by"];
echo " Call</label> <br /><br />\n\n     [<small>MaxMind ";
echo $LNG["gateway"];
echo " ";
echo $LNG["required"];
echo "</small>]\n    </td>\n</tr>\n\n\n<tr>\n    <td  class=\"fieldlabel\">Maxmind ";
echo $LNG["license"];
echo " ";
echo $LNG["key"];
echo "</td>\n    <td class=\"fieldarea\">\n\n<input type=\"text\" name=\"maxmindapikey\" value=\"";
echo $config["maxmindapikey"];
echo "\" />\n<small>\nRequired for automated telephone verification\nnot have key ? <br />\n<a target=\"_blank\" style=\"text-decoration: none;\" href=\"https://www.maxmind.com/en/telephone_buynow\">https://www.maxmind.com/en/telephone_buynow</a>\n</small>\n </td>\n</tr>\n-->\n\n</tbody>\n</table>\n\n    </div>\n<p align=\"center\" class=\"fixedbtn\"> <input value=\"";
echo $LNG["save"];
echo "\"\n id=\"btnaddgroup\" class=\"btn\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','settingfraud','#frmd','#notification','true','#main_loader');\"/>\n</p>\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>