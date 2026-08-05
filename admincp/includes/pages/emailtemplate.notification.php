<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 471;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div  class=\"groupstabes first\" >\n\n      <div class=\"groupstabescontant\">\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>\n        <span class=\"groupstabesheadertext\">";
echo $LNG["system"];
echo " ";
echo $LNG["notification"];
echo " </span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n      </h2>\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo " <table class=\"form\">\n<tr>\n            <td class=\"fieldlabel\">";
echo $LNG["all"];
echo " ";
echo $LNG["notification"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminnotice\" id=\"ae\" value=\"1\" ";
if ($config["adminnotice"]) {
    echo "checked";
}
echo "  /><label for=\"ae\"></label>\n            </td>\n</tr>\n <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["invoice"];
echo " ";
echo $LNG["generate"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_newinvoice\" id=\"sqe\" value=\"1\" ";
if ($config["adminotice_newinvoice"]) {
    echo "checked";
}
echo "  /><label for=\"sqe\"></label>\n            </td>\n</tr>\n\n <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_neworder\" id=\"nqe\" value=\"1\" ";
if ($config["adminotice_neworder"]) {
    echo "checked";
}
echo "  /><label for=\"nqe\"></label>\n            </td>\n</tr>\n";
if (!$OnlyEcommerce) {
    echo " <tr>\n            <td class=\"fieldlabel\">";
    echo $LNG["verification"];
    echo " ";
    echo $LNG["order"];
    echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_verifyorder\" id=\"vqe\" value=\"1\" ";
    if ($config["adminotice_verifyorder"]) {
        echo "checked";
    }
    echo "  /><label for=\"vqe\"></label>\n            </td>\n</tr>\n";
}
echo " <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["signup"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_newuser\" id=\"ue\" value=\"1\" ";
if ($config["adminotice_newuser"]) {
    echo "checked";
}
echo "  /><label for=\"ue\"></label>\n            </td>\n</tr>\n <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["user"];
echo " ";
echo $LNG["profile"];
echo " ";
echo $LNG["changed"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_userprofile\" id=\"pe\" value=\"1\" ";
if ($config["adminotice_userprofile"]) {
    echo "checked";
}
echo "  /><label for=\"pe\"></label>\n            </td>\n</tr>\n\n <tr>\n            <td class=\"fieldlabel\">";
echo $LNG["voucher"];
echo " ";
echo $LNG["coupon"];
echo " ";
echo $LNG["used"];
echo "</td>\n            <td class=\"fieldarea\">\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" name=\"adminotice_rechargevoucher\" id=\"cqe\" value=\"1\" ";
if ($config["adminotice_rechargevoucher"]) {
    echo "checked";
}
echo "  /><label for=\"cqe\"></label>\n            </td>\n</tr>\n\n\n  </table>\n</form>\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','emailtemplate.notification','#frm','#notification','true','#main_loader');\"/></p>\n</div></div></div></div>";
$fileverioncheck = "6.1.0";

?>