<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">";
echo $LNG["security"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>\n\n<script>\nfunction resetEncKey()\n{\n    \$.post(\"includes/pages/checkKeyUser.php\", function( data ) {\n            if(data>0){\n                if(confirm('Some user has still old encrypted password if you continue these user will lost their password and have to reset it.'))\n                {\n                  SubmitForm ('#btnaddgroup','changekeyconfig','#frmchangekey','#notification','true','#main_loader');\n                }\n            }else{\n                SubmitForm ('#btnaddgroup','changekeyconfig','#frmchangekey','#notification','true','#main_loader');\n            }\n\n            \$('#keyc').hide(); \$('#changekey').show();\n             \$('#frmchangekey').reset();\n    });\n}\n</script>\n";
error_reporting(0);
$pageid = 147;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["maxloginfailed"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt small\" name=\"MaxLoginFailedAttempts\" value=\"";
echo $config["MaxLoginFailedAttempts"];
echo "\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["sitessl"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\"  class=\"txt large\" name=\"config_ssl_allow\"  value=\"";
echo $config["config_ssl_allow"];
echo "\" />\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["masterpin"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"masterpin\" value=\"1\" id=\"me\" ";
if ($config["masterpin"]) {
    echo "checked";
}
echo " /><label for=\"me\"></label>\n   </td>\n</tr>\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["user"];
    echo " ";
    echo $LNG["can"];
    echo " ";
    echo $LNG["reset"];
    echo " APi IP </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"userapiip\" value=\"1\"\n     id=\"ame\" ";
    if ($config["userapiip"]) {
        echo "checked";
    }
    echo " /><label for=\"ame\"></label>\n   </td>\n</tr>\n";
}
echo "\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["can"];
echo " ";
echo $LNG["tmppassword"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"usertmppassword\" value=\"1\" id=\"ute\" ";
if ($config["usertmppassword"]) {
    echo "checked";
}
echo " /><label for=\"ute\"></label>\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["password"];
echo " ";
echo $LNG["expired"];
echo "</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\"  class=\"txt small\" name=\"password_expired\" value=\"";
echo $config["password_expired"];
echo "\" /> ";
echo $LNG["days"];
echo " <small>0 ";
echo $LNG["for"];
echo "  ";
echo $LNG["neverexpired"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["blocked"];
echo " ";
echo $LNG["account"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"checkbox\" class=\"onoff {labelOn: 'Blocked', labelOff: 'Unblocked'}\" name=\"block_ac_on_country_mismatch\" value=\"1\" id=\"ac1\" ";
if ($config["block_ac_on_country_mismatch"]) {
    echo "checked";
}
echo " /><label for=\"ac1\"></label>\n     <small>";
echo $LNG["on"];
echo " ";
echo $LNG["country"];
echo " ";
echo $LNG["mismatch"];
echo "</small>\n    </td>\n</tr>\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\">";
echo $LNG["requiredcaptcha"];
echo " ";
echo $LNG["on"];
echo "  ";
echo $LNG["login"];
echo "  </td>\n    <td class=\"fieldarea\">\n        <input name=\"captcha_login\"  value=\"1\" id=\"yess\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" ";
if ($config["captcha_login"]) {
    echo "checked";
}
echo " /> <label for=\"yess\"></label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Send Email on Country mismatch </td>\n    <td class=\"fieldarea\">\n   <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"sendcountrymail\" value=\"1\"\n    id=\"ac1s\" ";
if ($config["sendcountrymail"]) {
    echo "checked";
}
echo " />\n    <label for=\"ac1s\"></label>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["email"];
echo " ";
echo $LNG["notification"];
echo " on ";
echo $LNG["blocked"];
echo " ";
echo $LNG["account"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n   name=\"adminblocknotice\" value=\"1\" id=\"anb\" ";
if ($config["adminblocknotice"]) {
    echo "checked";
}
echo " /><label for=\"anb\"></label>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["allowed"];
echo " ";
echo $LNG["ip"];
echo "</td>\n    <td class=\"fieldarea\">\n    ";
if (file_exists(".htaccess")) {
    $file = file(".htaccess");
    foreach ($file as $f) {
        if (stripos($f, "Allow from") !== false) {
            $f = str_replace("Allow from", "", $f);
            $ips = explode(" ", $f);
        }
    }
    $ips = implode(" ", $ips);
}
echo "    <input type='text' name='allowed' value='";
echo $ips;
echo "' class=\"txt large\"/> <small>";
echo $LNG["adminloginip"];
echo "</small>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo " ";
echo $LNG["security"];
echo "</td>\n    <td class=\"fieldarea\">\n        <select name=\"passwordsecurity\">\n            <option ";
if ($config["passwordsecurity"] == "high") {
    echo "selected";
}
echo " >high</option>\n            <option ";
if ($config["passwordsecurity"] == "low") {
    echo "selected";
}
echo ">low</option>\n        </select>\n      </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">Automatic ";
echo $LNG["security"];
echo " Check</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" size=\"80\" value=\"/usr/bin/wget -O - -q -t 1 ";
echo $config["site_address"];
echo "includes/cron2.php?action=security\" readonly=\"true\" />\n        <small>Setup cron job to run once or twice a day</small>\n\n\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"securityemails\" value=\"1\" id=\"ses\" ";
if ($config["securityemails"]) {
    echo "checked";
}
echo " /><label for=\"ses\"></label>\n\n\n    </td>\n\n\n</tr>\n\n\n\n</form>\n\n\n<form id=\"frmchangekey\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<tr>\n    <td  class=\"fieldlabel\">Encryption Key </td>\n    <td class=\"fieldarea\">\n    <span id=\"changekey\"\n    onclick=\"\$('#keyc').show(); \$('#changekey').hide();\" style=\"cursor: pointer\">Change Key</span>\n\n    <span id=\"keyc\" style=\"display: none;\">\n    <input type=\"text\" name=\"encrykey\" style=\"width: 300px;\" value=\"\" />\n    <input type=\"button\" name=\"changekey\" value=\"Update Key\" onclick=\"resetEncKey();\" />\n    </span>\n\n    </td>\n\n</tr>\n</tbody>\n</table>\n</form>\n\n\n<p class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\"\nclass=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','securitysetting','#frm','#notification','true','#main_loader');\"/>\n\n    <!--\n<input value=\"";
echo $LNG["check"];
echo " ";
echo $LNG["security"];
echo "\" id=\"btnaddgroup\"\nclass=\"button \" style=\"float: right;\" type=\"button\"\nonclick=\"load_subpage('main2.php?page=checksecurity','Security Check');\"  />\n-->\n</p>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>