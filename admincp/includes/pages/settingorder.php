<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 231;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
echo "\n<div id=\"notification\"></div>\n\n<div  class=\"groupstabes first\" >\n\n      <div class=\"groupstabescontant\">\n          <script>\n              function setval(val)\n              {\n                  if(val){\n                      document.getElementById('cancelinmin').value=10;\n                  }\n              }\n          </script>\n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>\n        <span class=\"groupstabesheadertext\">";
echo $LNG["orders"];
echo "</span>\n      </h2>\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td width=\"200px\"   class=\"fieldlabel\">";
    echo $LNG["defaultservices"];
    echo " </td>\n    <td class=\"fieldarea\">\n    ";
    if (!$IsFileOnly) {
        echo "    <input name=\"default_service_imei\"  value=\"1\" id=\"imei\" type=\"checkbox\" ";
        if ($config["default_service_imei"]) {
            echo "checked";
        }
        echo "   /><label for=\"imei\">";
        echo $LNG["imei"];
        echo "</label>\n    ";
    }
    echo "    <input name=\"default_service_file\"  value=\"1\" id=\"file\" type=\"checkbox\" ";
    if ($config["default_service_file"]) {
        echo "checked";
    }
    echo "  /><label for=\"file\">";
    echo $LNG["file"];
    echo "</label>\n    ";
    if (!$IsFileOnly) {
        echo "    <input name=\"default_service_server\"  value=\"1\" id=\"serv\" type=\"checkbox\" ";
        if ($config["default_service_server"]) {
            echo "checked";
        }
        echo "  /><label for=\"serv\">";
        echo $LNG["server"];
        echo "</label>\n    ";
    }
    echo "    <input name=\"default_service_remote\"  value=\"1\" id=\"remot\" type=\"checkbox\" ";
    if ($config["default_service_remote"]) {
        echo "checked";
    }
    echo "  /><label for=\"remot\">";
    echo $LNG["remote"];
    echo "</label>\n\n\n        <br />\n    <small>Default service automatically enabled when user signup</small>\n    <!--<input name=\"default_service_shop\"  value=\"1\" id=\"sho\" type=\"checkbox\" ";
    if ($config["value"]) {
        echo "checked";
    }
    echo "  /><label for=\"sho\">";
    echo $LNG["shop"];
    echo "</label>-->\n    </td>\n</tr>\n";
}
echo "\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usercancalcelorder"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"config_self_cancel\" onclick=\"setval(this.value)\" value=\"1\" id=\"cae\" ";
if ($config["config_self_cancel"]) {
    echo "checked";
}
echo " />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usercancancelwithin"];
echo "  </td>\n    <td class=\"fieldarea\">\n<input type=\"text\" name=\"usercan_cancel_order_within_min\" id=\"cancelinmin\"  class=\"txt small\" value=\"";
echo $config["usercan_cancel_order_within_min"];
echo "\" />\n [ ";
echo $LNG["inminiute"];
echo " ]\n   </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["usersendverification"];
echo "  </td>\n    <td class=\"fieldarea\">\n<input type=\"text\" name=\"usercan_verify_order_within_min\" id=\"verifyinmin\" class=\"txt small\" value=\"";
echo $config["usercan_verify_order_within_min"];
echo "\" />\n [ ";
echo $LNG["inminiute"];
echo " ]\n   </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> Show \"<span class=\"badge badge-orange\">NEW</span>\" Tag till</td>\n    <td class=\"fieldarea\">\n<input type=\"text\" name=\"showimeiupdate\" id=\"showimeiupdate\"\nclass=\"txt small\" value=\"";
echo $config["showimeiupdate"];
echo "\" />\n [Hours]\n        <small>";
echo $LNG["shownewtaginfo"];
echo "</small>\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["check"];
echo " ";
echo $LNG["duplicate"];
echo " ";
echo $LNG["imei"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"duplicateimei\" value=\"1\" id=\"due\" ";
if ($config["duplicateimei"]) {
    echo "checked";
}
echo " />\n        <small>Prevent duplicate order place for same services and same user</small>\n    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["happyhours"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"happyhours\" value=\"1\" id=\"hae\" ";
if ($config["happyhours"]) {
    echo "checked";
}
echo " />\n   </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["tooltip"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"tooltip\" value=\"1\" id=\"te\" ";
if ($config["tooltip"]) {
    echo "checked";
}
echo " />\n   </td>\n</tr>-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["masterpin"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\" name=\"masterpin\" value=\"1\" id=\"me\" ";
if ($config["masterpin"]) {
    echo "checked";
}
echo " />\n   </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["placeorder"];
echo " ";
echo $LNG["notes"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"ordernotes\" value=\"1\" id=\"ordn\"\n     ";
if ($config["ordernotes"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["placeorder"];
echo " ";
echo $LNG["comments"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"ordercomments\" value=\"1\" id=\"ordc\"\n     ";
if ($config["ordercomments"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["placeorder"];
echo " ";
echo $LNG["response"];
echo " ";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"orderemail\" value=\"1\" id=\"ordc\"\n     ";
if ($config["orderemail"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["placeorder"];
echo " ";
echo $LNG["response"];
echo " ";
echo $LNG["mobile"];
echo " ";
echo $LNG["no"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"orderno\" value=\"1\" id=\"ordc\"\n     ";
if ($config["orderno"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["show"];
echo " ";
echo $LNG["average"];
echo " ";
echo $LNG["delivery"];
echo " ";
echo $LNG["time"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"averagedeliverytime\" value=\"1\" id=\"avdt\" ";
if ($config["averagedeliverytime"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["new"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["alert"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"clientorderalert\" value=\"1\" id=\"soatc\"\n      ";
if ($config["clientorderalert"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["placeordertype"];
echo "  </td>\n    <td class=\"fieldarea\">\n\n    <input type='radio' value=\"1\" name=\"placeordertype\"  ";
if ($config["placeordertype"] == 1 || !$config["placeordertype"]) {
    echo "checked";
}
echo " id=\"pote\" /><label for=\"pote\">";
echo $LNG["default"];
echo "</label>\n\n    <input type='radio' value=\"2\" name=\"placeordertype\"\n     ";
if ($config["placeordertype"] == 2) {
    echo "checked";
}
echo "     id=\"potd\" /><label for=\"potd\">";
echo $LNG["group"];
echo " ";
echo $LNG["wise"];
echo "</label>\n\n   </td>\n</tr>-->\n\n<tr>\n    <td class=\"fieldlabel\">\n        ";
echo $LNG["allow"];
echo " ";
echo $LNG["overdrive"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n               name=\"allowoverdrive\" id=\"alove\" value=\"1\"\n            ";
if ($config["allowoverdrive"]) {
    echo "checked";
}
echo "  /><label for=\"alove\"></label>\n    </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["information"];
echo " ";
echo $LNG["position"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type='radio' value=\"1\" name=\"infopos\"  ";
if ($config["infopos"] == 1 || !$config["infopos"]) {
    echo "checked";
}
echo " id=\"infoe\" /><label for=\"infoe\">";
echo $LNG["top"];
echo "</label>\n\n    <input type='radio' value=\"2\" name=\"infopos\"  ";
if ($config["infopos"] == 2) {
    echo "checked";
}
echo "    id=\"infod\" /><label for=\"infod\">";
echo $LNG["bottom"];
echo "</label>\n    <small>Not for default and default3 template</small>\n   </td>\n</tr>\n-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["subscription"];
echo " ";
echo $LNG["reminder"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"subscribe_reminder\" class=\"txt small\"\n     value=\"";
echo $config["subscribe_reminder"];
echo "\" /> ";
echo $LNG["days"];
echo "    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["direct"];
echo " IMEI ";
echo $LNG["order"];
echo " ";
echo $LNG["info"];
echo "</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"directorderinfo\" cols=\"80\"\n    rows=\"7\">";
echo base64_decode($config["directorderinfo"]);
echo "</textarea>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["predefinedrepl"];
echo "</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"orderreplyword\" cols=\"80\"\n    rows=\"7\">";
echo $config["orderreplyword"];
echo "</textarea>\n     </td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " ";
echo $LNG["order"];
echo "  </td>\n    <td class=\"fieldarea\">\n    <input type='radio' value=\"2\" name=\"orderdisplay\"  ";
if ($config["orderdisplay"] == 2) {
    echo "checked";
}
echo " id=\"dote\" /><label for=\"dote\">Ascending</label>\n\n    <input type='radio' value=\"1\" name=\"orderdisplay\"\n     ";
if ($config["orderdisplay"] == 1 || !$config["orderdisplay"]) {
    echo "checked";
}
echo "      id=\"totd\" /><label for=\"totd\">Descending</label>\n\n   </td>\n</tr>\n-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["show"];
echo " ";
echo $LNG["encrypted"];
echo " ";
echo $LNG["order"];
echo "  ID</td>\n    <td class=\"fieldarea\">\n    <input type='checkbox'\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable', easing: 'easeOutBounce', duration: 500}\"\n     name=\"encryptedorderid\" value=\"1\" id=\"encs\"\n     ";
if ($config["encryptedorderid"]) {
    echo "checked";
}
echo " />\n     </td>\n</tr>\n<!--\n       <tr>\n            <td class=\"fieldlabel\" width=\"250px\"> ";
echo $LNG["quick"];
echo " ";
echo $LNG["checkout"];
echo "</td>\n            <td class=\"fieldarea\">\n<select name=\"quick_checkout\">\n\n\n<option value=\"4\" ";
if ($config["quick_checkout"] == 4) {
    echo "selected='selected'";
}
echo ">Default Model wise</option>\n<option value=\"5\" ";
if ($config["quick_checkout"] == 5) {
    echo "selected='selected'";
}
echo ">Service dropdown</option>\n<option value=\"disable\" ";
if ($config["quick_checkout"] == "disable") {
    echo "selected='selected'";
}
echo ">Disable</option>\n</select>\n            </td>\n        </tr>\n-->\n<tr>\n    <td class=\"fieldlabel\" width=\"250px\">ebay Paypal Username</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"ebaypaypaluser\" class=\"txt large\"\n               value=\"";
echo $config["ebaypaypaluser"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"250px\">ebay Paypal Password</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"ebaypaypalpass\" class=\"txt large\"\n               value=\"";
echo $config["ebaypaypalpass"];
echo "\" />\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"250px\">ebay Paypal Signature</td>\n    <td class=\"fieldarea\">\n        <input type=\"text\" name=\"ebaypaypalsignature\" class=\"txt large\"\n               value=\"";
echo $config["ebaypaypalsignature"];
echo "\" />\n    </td>\n</tr>\n</tbody>\n</table>\n\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','settingorder','#frm','#notification','true','#main_loader');\"/>\n</p>\n\n</form>\n\n\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>