<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 125;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "<style>\n#default,#server1,#server2{\n    margin-right:15px\n}\n#default h2,#server1 h2,#server2 h2{\n    cursor: n-resize;\n}\n.groupstabescontant{padding:0;}\n.groupstabes#server1,.groupstabes#server2,.groupstabes#server3,.groupstabes#default{}\n\n</style>\n<script>\nfunction showsmtp(val)\n{\n    if(val=='sendgrid')\n    {\n        document.getElementById('smtp[0]').style.display='none';\n        document.getElementById('smtp[1]').style.display='none';\n        document.getElementById('smtp[2]').style.display='none';\n        document.getElementById('smtp[3]').style.display='none';\n        document.getElementById('smtp[4]').style.display='none';\n        document.getElementById('smtp[5]').style.display='';\n        document.getElementById('smtp[6]').style.display='none';\n\n    }else if(val=='mailgun')\n    {\n        document.getElementById('smtp[0]').style.display='none';\n        document.getElementById('smtp[1]').style.display='none';\n        document.getElementById('smtp[2]').style.display='none';\n        document.getElementById('smtp[3]').style.display='none';\n        document.getElementById('smtp[4]').style.display='none';\n        document.getElementById('smtp[5]').style.display='';\n        document.getElementById('smtp[6]').style.display='';\n    }else if(val=='aggregator' ){\n        document.getElementById('smtp[0]').style.display='none';\n        document.getElementById('smtp[1]').style.display='none';\n        document.getElementById('smtp[2]').style.display='none';\n        document.getElementById('smtp[3]').style.display='none';\n        document.getElementById('smtp[4]').style.display='';\n        document.getElementById('smtp[5]').style.display='';\n        document.getElementById('smtp[6]').style.display='none';\n\n    }else if(val=='php')\n    {\n        document.getElementById('smtp[0]').style.display='none';\n        document.getElementById('smtp[1]').style.display='none';\n        document.getElementById('smtp[2]').style.display='none';\n        document.getElementById('smtp[3]').style.display='none';\n        document.getElementById('smtp[4]').style.display='none';\n        document.getElementById('smtp[5]').style.display='none';\n        document.getElementById('smtp[6]').style.display='none';\n\n    }else{\n        document.getElementById('smtp[0]').style.display='';\n        document.getElementById('smtp[1]').style.display='';\n        document.getElementById('smtp[2]').style.display='';\n        document.getElementById('smtp[3]').style.display='';\n        document.getElementById('smtp[4]').style.display='none';\n        document.getElementById('smtp[5]').style.display='none';\n        document.getElementById('smtp[6]').style.display='none';\n\n    }\n}\nfunction showsmtp1(val)\n{\n    if(val=='php')\n    {\n        document.getElementById('smtp1[0]').style.display='none';\n        document.getElementById('smtp1[1]').style.display='none';\n        document.getElementById('smtp1[2]').style.display='none';\n        document.getElementById('smtp1[3]').style.display='none';\n        document.getElementById('smtp1[4]').style.display='none';\n    }else{\n        document.getElementById('smtp1[0]').style.display='';\n        document.getElementById('smtp1[1]').style.display='';\n        document.getElementById('smtp1[2]').style.display='';\n        document.getElementById('smtp1[3]').style.display='';\n        document.getElementById('smtp1[4]').style.display='';\n    }\n}\nfunction showsmtp2(val)\n{\n    if(val=='php')\n    {\n        document.getElementById('smtp2[0]').style.display='none';\n        document.getElementById('smtp2[1]').style.display='none';\n        document.getElementById('smtp2[2]').style.display='none';\n        document.getElementById('smtp2[3]').style.display='none';\n        document.getElementById('smtp2[4]').style.display='none';\n    }else{\n        document.getElementById('smtp2[0]').style.display='';\n        document.getElementById('smtp2[1]').style.display='';\n        document.getElementById('smtp2[2]').style.display='';\n        document.getElementById('smtp2[3]').style.display='';\n        document.getElementById('smtp2[4]').style.display='';\n    }\n}\nfunction checkShed(val){\n    if(val==2){\n        document.getElementById('shedult').style.display='none';\n    }else{\n        document.getElementById('shedult').style.display='';\n    }\n}\n\$( document ).ready(function() {\n    \$('#mail-server input[type=\"radio\"]').click(function(){\n        \$('.groupstabes9').removeClass('active');\n        \$('#'+\$(this).val()).addClass('active');\n    })\n});\n</script>\n\n<style>\n    .groupstabes9{display: none;}\n    .groupstabes9.active{display: block;}\n</style>\n\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n<div class=\"groupstabes first\" >\n<div class=\"\">\n<div id=\"content\">\n<div id=\"\">\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["email"];
echo " ";
echo $LNG["settings"];
echo "</span>\n  </h2>\n\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["mail"];
echo " ";
echo $LNG["sendingtype"];
echo " </td>\n        <td class=\"fieldarea\">\n        <input type=\"radio\" name=\"mail_sending_type\" value=\"1\" id=\"sheduled\" onclick=\"checkShed(this.value);\"\n        ";
if ($config["mail_sending_type"] == "1") {
    echo "checked='checked'";
}
echo " /> <label for=\"sheduled\">";
echo $LNG["sheduled"];
echo "</label>\n        <input type=\"radio\" name=\"mail_sending_type\" value=\"2\" id=\"instant\"\n         onclick=\"checkShed(this.value);\"\n        ";
if ($config["mail_sending_type"] == "2" || !$config["mail_sending_type"]) {
    echo "checked='checked'";
}
echo " /><label for=\"instant\">";
echo $LNG["instant"];
echo "</label>\n        </td>\n    </tr>\n\n    <tr id=\"shedult\" style=\"";
if ($config["mail_sending_type"] == "2" || !$config["mail_sending_type"]) {
    echo "display:none;";
}
echo "\" >\n        <td class=\"fieldlabel\">";
echo $LNG["sheduled"];
echo " ";
echo $LNG["settings"];
echo " [Beta]</td>\n        <td class=\"fieldarea\">\n    <input type=\"text\" name=\"mailperbatch\" value=\"";
if ($config["mailperbatch"]) {
    echo $config["mailperbatch"];
} else {
    echo "50";
}
echo "\" size=\"5\" /> <span style=\"font-size:10px !important;\">No. of mail per batch</span>   <br /> <br />\n    <div style=\"padding:  10px 0;\">\n    * If you want to send some email instant then go to edit mail template to change type scheduled or instant <br />\n    ";
echo $LNG["enablesheduleautomation"];
echo " ";
echo $LNG["createcron"];
echo "   <br /> <a target=\"_blank\" href=\"http://dhru.com/knowledgebase/999147/How-to-setup-a-Cron-job.html\" style=\"text-decoration: none;color:#888\">How to setup a Cron job in cPanel</a><br /><div>/usr/bin/wget -O - -q -t 1 ";
echo $config["site_address"];
echo "includes/sheduledmail.php";
echo $config["cronpassword"] ? "?cronpasscode=" . $config["cronpassword"] : "";
echo "</div>\n    </div>\n        </td>\n    </tr>\n\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["systemmail"];
echo "  </td>\n        <td class=\"fieldarea\">\n       <input type=\"text\" name=\"config_admin_mail\" value=\"";
echo $config["config_admin_mail"];
echo "\" class=\"txt large\"/> <small> The default sender address used for emails sent by DhruFusion</small>\n        </td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">BCC ";
echo $LNG["email"];
echo " </td>\n        <td class=\"fieldarea\">\n       <input type=\"text\" name=\"BCC_Messages\"\n       value=\"";
echo $config["BCC_Messages"];
echo "\" class=\"txt large\"/>\n       <small> Blind Carbon Copy for all emails of Users. Only set if you want to receive copy for all emails sent to User.</small>\n        </td>\n    </tr>\n\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["systemfromname"];
echo "  </td>\n        <td class=\"fieldarea\">\n       <input type=\"text\" name=\"config_admin_name\" value=\"";
echo $config["config_admin_name"];
echo "\" class=\"txt medium\"/>\n        </td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["adminsignature"];
echo "  </td>\n        <td class=\"fieldarea\">\n       <textarea name=\"adminsignature\" base64encode=\"true\" class=\"txt medium\">";
echo $config["adminsignature"];
echo "</textarea>\n        </td>\n    </tr>\n\n    </tbody>\n</table>\n</div></div></div></div>\n\n <div id=\"mail-server\">\n\n<div>\n<input type=\"radio\" name=\"ds\" value=\"s1\" checked=\"\"/> <label>";
echo $LNG["default"];
echo " ";
echo $LNG["settings"];
echo "</label>\n<input type=\"radio\" name=\"ds\" value=\"s2\"/> <label>Mail Server 1</label>\n<input type=\"radio\" name=\"ds\" value=\"s3\"/> <label>Mail Server 2</label>\n</div>\n\n<hr />\n\n<div id=\"content\" class=\"default\">\n\n<div class=\"ms groupstabes9 active\" id=\"s1\">\n\n  <div  class=\"groupstabescontant\">\n\n\n<div id=\"\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mailtype"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"mail_type\" onchange=\"showsmtp(this.value)\">\n        <option value=\"smtp\" ";
if ($config["mail_type"] == "smtp") {
    echo "selected";
}
echo " >";
echo $LNG["smtp"];
echo "</option>\n        <option value=\"php\"  ";
if ($config["mail_type"] == "php") {
    echo "selected";
}
echo " >";
echo $LNG["php"];
echo "</option>\n        ";
if ($aggregator) {
    echo "        <option value=\"aggregator\"  ";
    if ($config["mail_type"] == "aggregator") {
        echo "selected";
    }
    echo " >Aggregator</option>\n        ";
}
echo "        <option value=\"mailgun\" ";
if ($config["mail_type"] == "mailgun") {
    echo "selected";
}
echo " >MailGun</option>\n        <option value=\"sendgrid\" ";
if ($config["mail_type"] == "sendgrid") {
    echo "selected";
}
echo " >SendGrid</option>\n    </select>\n\n    </td>\n</tr>\n\n<tr id=\"smtp[0]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "aggregator" || $config["mail_type"] == "mailgun" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpport"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_port\" id=\"taxtype\" class=\"txt small\" value=\"";
echo $config["smtp_port"];
echo "\" />\n    </td>\n</tr>\n<tr id=\"smtp[1]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "aggregator" || $config["mail_type"] == "mailgun" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtphost"];
echo "</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_host\" value=\"";
echo $config["smtp_host"];
echo "\" />&nbsp;&nbsp;&nbsp;\n    <input type=\"checkbox\" value=\"1\" name=\"smtp_enc\"\n    id=\"smtp_enc\" ";
if ($config["smtp_enc"]) {
    echo "checked";
}
echo "  /><label for=\"smtp_enc\">";
echo $LNG["smtpenc"];
echo "</label>\n    </td>\n</tr>\n\n\n<tr id=\"smtp[2]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "aggregator" || $config["mail_type"] == "mailgun" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpusername"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_username\" value=\"";
echo $config["smtp_username"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr id=\"smtp[3]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "aggregator" || $config["mail_type"] == "mailgun" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtppassword"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_password\" value=\"";
echo $config["smtp_password"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n\n<tr id=\"smtp[4]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "smtp" || $config["mail_type"] == "mailgun" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">Aggregator Link </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"aggregatorlink\" value=\"";
echo $config["aggregatorlink"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr id=\"smtp[6]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "smtp" || $config["mail_type"] == "aggregator" || $config["mail_type"] == "sendgrid") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">Domain Name </td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"mailgundomain\" value=\"";
echo $config["mailgundomain"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr id=\"smtp[5]\" style=\"display:  ";
if ($config["mail_type"] == "php" || $config["mail_type"] == "smtp") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">API Key </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"aggregatorapi\" value=\"";
echo $config["aggregatorapi"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n<tr >\n    <td class=\"fieldlabel\">Test To </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"testtoemail\" value=\"\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"> <input value=\"";
echo $LNG["sendtestmail"];
echo "\" id=\"testmail\" class=\"btn\"\n    type=\"button\"\n    onclick=\"SubmitForm ('#testmail','testmail','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n\n\n\n</div></div></div></div>\n\n\n\n<div class=\"ms groupstabes9\" id=\"s2\">\n\n  <div class=\"groupstabescontant\">\n<div id=\"content\" class=\"server1\">\n<div id=\"\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mailtype"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"mail_type1\" onchange=\"showsmtp1(this.value)\">\n    <option value=\"smtp\" ";
if ($config["mail_type1"] == "smtp") {
    echo "selected";
}
echo " >";
echo $LNG["smtp"];
echo "</option>\n    <option value=\"php\" ";
if ($config["mail_type1"] == "php") {
    echo "selected";
}
echo " >";
echo $LNG["php"];
echo "</option>\n    </select>\n\n    </td>\n</tr>\n\n<tr id=\"smtp1[0]\" style=\"display:  ";
if ($config["mail_type1"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpport"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_port1\" id=\"taxtype\" class=\"txt small\" value=\"";
echo $config["smtp_port1"];
echo "\" />\n    </td>\n</tr>\n<tr id=\"smtp1[1]\" style=\"display:  ";
if ($config["mail_type1"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtphost"];
echo "</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_host1\" value=\"";
echo $config["smtp_host1"];
echo "\" />&nbsp;&nbsp;&nbsp;\n    <input type=\"checkbox\" value=\"1\" name=\"smtp_enc1\" id=\"smtp_enc1\" ";
if ($config["smtp_enc1"]) {
    echo "checked";
}
echo "  /><label for=\"smtp_enc1\">";
echo $LNG["smtpenc"];
echo "</label>\n    </td>\n</tr>\n\n\n<tr id=\"smtp1[2]\" style=\"display:  ";
if ($config["mail_type1"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpusername"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_username1\" value=\"";
echo $config["smtp_username1"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr id=\"smtp1[3]\" style=\"display:  ";
if ($config["mail_type1"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtppassword"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_password1\" value=\"";
echo $config["smtp_password1"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td  class=\"fieldarea\"> <input value=\"";
echo $LNG["sendtestmail"];
echo "\" id=\"testmail1\" class=\"btn\"\n    type=\"button\"  onclick=\"SubmitForm ('#testmail1','testmailserver1','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n\n</div></div></div></div>\n\n\n\n\n<div class=\"ms groupstabes9\" id=\"s3\">\n\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\" class=\"server2\">\n<div id=\"\">\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mailtype"];
echo " </td>\n    <td class=\"fieldarea\">\n    <select name=\"mail_type2\" onchange=\"showsmtp2(this.value)\">\n    <option value=\"smtp\" ";
if ($config["mail_type2"] == "smtp") {
    echo "selected";
}
echo " >";
echo $LNG["smtp"];
echo "</option>\n    <option value=\"php\" ";
if ($config["mail_type2"] == "php") {
    echo "selected";
}
echo " >";
echo $LNG["php"];
echo "</option>\n    </select>\n\n    </td>\n</tr>\n\n<tr id=\"smtp2[0]\" style=\"display:  ";
if ($config["mail_type2"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpport"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_port2\" id=\"taxtype\" class=\"txt small\" value=\"";
echo $config["smtp_port2"];
echo "\" />\n    </td>\n</tr>\n<tr id=\"smtp2[1]\" style=\"display:  ";
if ($config["mail_type2"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtphost"];
echo "</td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_host2\" value=\"";
echo $config["smtp_host2"];
echo "\" />&nbsp;&nbsp;&nbsp;\n    <input type=\"checkbox\" value=\"1\" name=\"smtp_enc2\" id=\"smtp_enc2\"\n    ";
if ($config["smtp_enc2"]) {
    echo "checked";
}
echo "  /><label for=\"smtp_enc2\">";
echo $LNG["smtpenc"];
echo "</label>\n    </td>\n</tr>\n\n\n<tr id=\"smtp2[2]\" style=\"display:  ";
if ($config["mail_type2"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtpusername"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_username2\" value=\"";
echo $config["smtp_username2"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n\n<tr id=\"smtp[3]\" style=\"display:  ";
if ($config["mail_type2"] == "php") {
    echo "none";
}
echo " ;\">\n    <td class=\"fieldlabel\">";
echo $LNG["smtppassword"];
echo "  </td>\n    <td class=\"fieldarea\">\n   <input type=\"text\" name=\"smtp_password2\" value=\"";
echo $config["smtp_password2"];
echo "\" class=\"txt medium\"/>\n    </td>\n</tr>\n<tr>\n    <td></td>\n    <td  class=\"fieldarea\"> <input value=\"";
echo $LNG["sendtestmail"];
echo "\" id=\"testmail2\"\n    class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#testmail2','testmailserver2','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n\n\n</div></div></div></div>\n\n</div>\n<br /><br />\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn btn-primary\" type=\"button\"\n onclick=\"SubmitFormNew ('#btnaddgroup','basicmail','#frm','#notification','true','#main_loader');\"/>\n</p>\n</form>\n ";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Email-Settings/?aid=6&cid=2&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>