<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 258;
checkPagePermission($pageid);
$SENDMAIL_newusersignup = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_newusersignup'"));
$SENDMAIL_passwordresetlink = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_passwordresetlink'"));
$SENDMAIL_userpasswordchangeconfirm = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_userpasswordchangeconfirm'"));
$SENDMAIL_ordercanceledbyuser = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_ordercanceledbyuser'"));
$SENDMAIL_securityquestionchangeconfirm = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_securityquestionchangeconfirm'"));
$SENDMAIL_welcomemail = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_welcomemail'"));
$SENDMAIL_newordernotificationtoreseller = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_configer` WHERE `attribute`='SENDMAIL_newordernotificationtoreseller'"));
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["SENDMAIL_newusersignup"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_newusersignup\" value=\"1\" ";
if ($SENDMAIL_newusersignup["value"]) {
    echo "checked";
}
echo " id=\"en\" /><label for=\"en\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_newusersignup\" value=\"0\" ";
if (!$SENDMAIL_newusersignup["value"]) {
    echo "checked";
}
echo " id=\"dn\" /><label for=\"dn\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_passwordresetlink"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_passwordresetlink\" value=\"1\" ";
if ($SENDMAIL_passwordresetlink["value"]) {
    echo "checked";
}
echo " id=\"ep\" /><label for=\"ep\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_passwordresetlink\" value=\"0\" ";
if (!$SENDMAIL_passwordresetlink["value"]) {
    echo "checked";
}
echo " id=\"dp\" /><label for=\"dp\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_userpasswordchangeconfirm"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_userpasswordchangeconfirm\" value=\"1\" ";
if ($SENDMAIL_userpasswordchangeconfirm["value"]) {
    echo "checked";
}
echo " id=\"eu\" /><label for=\"eu\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_userpasswordchangeconfirm\" value=\"0\" ";
if (!$SENDMAIL_userpasswordchangeconfirm["value"]) {
    echo "checked";
}
echo " id=\"du\" /><label for=\"du\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_ordercanceledbyuser"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_ordercanceledbyuser\" value=\"1\" ";
if ($SENDMAIL_ordercanceledbyuser["value"]) {
    echo "checked";
}
echo " id=\"eo\" /><label for=\"eo\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_ordercanceledbyuser\" value=\"0\" ";
if (!$SENDMAIL_ordercanceledbyuser["value"]) {
    echo "checked";
}
echo " id=\"do\" /><label for=\"do\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_securityquestionchangeconfirm"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_securityquestionchangeconfirm\" value=\"1\" ";
if ($SENDMAIL_securityquestionchangeconfirm["value"]) {
    echo "checked";
}
echo " id=\"es\" /><label for=\"es\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_securityquestionchangeconfirm\" value=\"0\" ";
if (!$SENDMAIL_securityquestionchangeconfirm["value"]) {
    echo "checked";
}
echo " id=\"ds\" /><label for=\"ds\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_welcomemail"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_welcomemail\" value=\"1\" ";
if ($SENDMAIL_welcomemail["value"]) {
    echo "checked";
}
echo " id=\"ew\" /><label for=\"ew\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_welcomemail\" value=\"0\" ";
if (!$SENDMAIL_welcomemail["value"]) {
    echo "checked";
}
echo " id=\"dw\" /><label for=\"dw\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["SENDMAIL_newordernotificationtoreseller"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"SENDMAIL_newordernotificationtoreseller\" value=\"1\" ";
if ($SENDMAIL_newordernotificationtoreseller["value"]) {
    echo "checked";
}
echo " id=\"er\" /><label for=\"er\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"SENDMAIL_newordernotificationtoreseller\" value=\"0\" ";
if (!$SENDMAIL_newordernotificationtoreseller["value"]) {
    echo "checked";
}
echo " id=\"dr\" /><label for=\"dr\">";
echo $LNG["disable"];
echo "</label>\n\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> </td><td>\n   <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','mailsettingsend','#frm','#notification','true','#main_loader');\"/>\n    </td>\n</tr>\n</tbody>\n</table>\n\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>