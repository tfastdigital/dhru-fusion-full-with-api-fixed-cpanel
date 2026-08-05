<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n    \$('#main_tbl').tableDnD({\n        onDrop: function(table, row) {\n            var serialized= \$.tableDnD.serialize();\n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/customfield.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t alert(data);\n    \t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\nfunction shower(ob){\n    if(ob.checked){\n        document.getElementById('donot').style.display='';\n    }else{\n        document.getElementById('donot').style.display='none';\n    }\n}\n\nfunction showHide(id){\n\tif(id.checked==false)\n\t{\n\t\tdocument.getElementById('customlength').style.display='none';\n\t\tdocument.getElementById('customimeiname').style.display='none';\n\t\tdocument.getElementById('customimeiinfo').style.display='none';\n\t}\n\telse\n\t{\n\t\tdocument.getElementById('customlength').style.display='table-row';\n\t\tdocument.getElementById('customimeiname').style.display='table-row';\n\t\tdocument.getElementById('customimeiinfo').style.display='table-row';\n\t}\n}\nfunction DeleteCustom(cid){\n    var answer = confirm('Are you sure to delete this item?');\n    if(answer)\n    {\n        DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n        \$(\"#\"+cid).hide();\n    }\n}\n\n</script>\n";
$pageid = 182;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($config["registration_type"] == 3) {
    echo "     <script>\n         \$(\".noreg\").hide();\n     </script>\n     ";
}
echo "<script>\nfunction changeexp(ids)\n{\n    \$(\".noreg\").show();\n    if(ids==4)\n    {\n        \$(\".noreg\").hide();\n    }else\n    if(ids)\n    {\n        document.getElementById('regexp').style.display='';\n    }else{\n        document.getElementById('regexp').style.display='none';\n    }\n}\nfunction paymentGat(val){\n\n    if(val==1){\n        \$(\".payg\").show();\n    }else{\n        \$(\".payg\").hide();\n    }\n}\nfunction showtab(ids){\n    \$(\"#show_\"+ids).toggle();\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<div>\n  <h2>\n    <span class=\"groupstabesheadertext\">Profile/Registration</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n          <table class=\"form\">\n              <tr>\n                  <td class=\"fieldlabel\">";
echo $LNG["registration"];
echo "</td>\n                  <td class=\"fieldarea form-radio-block\">\n                          <input name=\"registration_type\"  value=\"1\" type=\"radio\" onclick=\"changeexp(1)\" id=\"man\"   ";
if ($config["registration_type"] == 1) {
    echo "checked";
}
echo " /><label for=\"man\">";
echo $LNG["activation"];
echo " By Admin</label><br/>\n                          <input name=\"registration_type\"  value=\"2\" type=\"radio\" onclick=\"changeexp(0)\" id=\"aut\"  ";
if ($config["registration_type"] == 2) {
    echo "checked";
}
echo " /><label for=\"aut\">";
echo $LNG["activation"];
echo " By Email</label><br/>\n                          <input name=\"registration_type\"  value=\"4\" type=\"radio\" onclick=\"changeexp(0)\" id=\"auta\"  ";
if ($config["registration_type"] == 4) {
    echo "checked";
}
echo " /><label for=\"auta\">Auto ";
echo $LNG["activation"];
echo "</label><br/>\n                          <input name=\"registration_type\"  value=\"3\" type=\"radio\" onclick=\"changeexp(4)\" id=\"dis\"  ";
if ($config["registration_type"] == 3) {
    echo "checked";
}
echo "  /><label for=\"dis\">";
echo $LNG["disabled"];
echo " ";
echo $LNG["registration"];
echo "</label>\n                      <small>";
echo $LNG["manualreginfo"];
echo "</small>\n                      <small>";
echo $LNG["automaticinfo"];
echo "</small>\n                  </td>\n              </tr>\n<tr class=\"noreg\">\n    <td  class=\"fieldlabel\">";
echo $LNG["lockfields"];
echo "</td>\n    <td class=\"fieldarea\">\n<input name=\"lock_username\" value=\"username\" id=\"use\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "username") {
        echo "checked";
    }
}
echo "  /><label for=\"use\">";
echo $LNG["username"];
echo "</label>\n<input name=\"lock_email\" value=\"email\" id=\"ema\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "email") {
        echo "checked";
    }
}
echo " /><label for=\"ema\">";
echo $LNG["email"];
echo "</label>\n<input name=\"lock_first_name\" id=\"fir\" value=\"firstname\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "firstname") {
        echo "checked";
    }
}
echo " /><label for=\"fir\">";
echo $LNG["firstname"];
echo "</label>\n<input name=\"lock_last_name\" id=\"las\" value=\"lastname\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "lastname") {
        echo "checked";
    }
}
echo " /><label for=\"las\">";
echo $LNG["lastname"];
echo "</label>\n\n<input name=\"lock_address\" id=\"las2\" value=\"address\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "address") {
        echo "checked";
    }
}
echo " /><label for=\"las2\">";
echo $LNG["address"];
echo " 1</label>\n<input name=\"lock_address2\" id=\"las3\" value=\"address2\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "address2") {
        echo "checked";
    }
}
echo " /><label for=\"las3\">";
echo $LNG["address"];
echo " 2</label>\n<input name=\"lock_city\" id=\"las4\" value=\"city\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "city") {
        echo "checked";
    }
}
echo " /><label for=\"las4\">";
echo $LNG["city"];
echo "</label>\n<input name=\"lock_state\" id=\"las5\" value=\"state\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "state") {
        echo "checked";
    }
}
echo " /><label for=\"las5\">";
echo $LNG["state"];
echo "</label>\n<input name=\"lock_country\" id=\"las6\" value=\"country\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "country") {
        echo "checked";
    }
}
echo " /><label for=\"las6\">";
echo $LNG["country"];
echo "</label>\n<input name=\"lock_zip\" id=\"las7\" value=\"zip\" type=\"checkbox\" ";
$locks = explode(",", $config["registration_lockfields"]);
foreach ($locks as $l) {
    if (trim($l) == "zip") {
        echo "checked";
    }
}
echo " /><label for=\"las7\">";
echo $LNG["pin"];
echo "</label>\n\n    </td>\n</tr>\n\n\n<tr class=\"noreg\">\n  <td class=\"fieldlabel\">";
echo $LNG["minimum"];
echo " ";
echo $LNG["registration"];
echo "  ";
echo $LNG["fields"];
echo "  </td>\n  <td class=\"fieldarea\">\n      <input name=\"minregistration\"  value=\"1\" id=\"yes\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" ";
if ($config["minregistration"]) {
    echo "checked";
}
echo " /> <label for=\"yes\"></label>\n      <small>";
echo $LNG["email"];
echo " , ";
echo $LNG["password"];
echo ", ";
echo $LNG["firstname"];
echo ", ";
echo $LNG["lastname"];
echo ", ";
echo $LNG["country"];
echo ", ";
echo $LNG["termscond"];
echo "</small>\n  </td>\n</tr>\n\n  <tr class=\"noreg\">\n      <td class=\"fieldlabel\">";
echo $LNG["display"];
echo "   ";
echo $LNG["username"];
echo "   </td>\n      <td class=\"fieldarea\">\n          <input name=\"displayusername\"  value=\"1\" id=\"yes\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" ";
if ($config["displayusername"]) {
    echo "checked";
}
echo " /> <label for=\"yes\"></label>\n      </td>\n  </tr>\n\n<tr class=\"noreg\">\n  <td class=\"fieldlabel\">";
echo $LNG["phone"];
echo " ";
echo $LNG["no"];
echo "  ";
echo $LNG["required"];
echo "  </td>\n  <td class=\"fieldarea\">\n      <input name=\"phonerequired\"  value=\"1\" id=\"yes\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" ";
if ($config["phonerequired"]) {
    echo "checked";
}
echo " /> <label for=\"yes\"></label>\n  </td>\n</tr>\n\n\n              <tr class=\"noreg\">\n                  <td class=\"fieldlabel\">Allow registration from Telegram</td>\n                  <td class=\"fieldarea\">\n                      <input name=\"allowtelegramreg\"  value=\"1\" id=\"yes\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\" ";
if ($config["allowtelegramreg"]) {
    echo "checked";
}
echo " /> <label for=\"yes\"></label>\n                  </td>\n              </tr>\n\n<tr class=\"noreg\" id=\"regexp\" style=\"display: ";
if ($mode["value"] == 1) {
    echo "none";
}
echo ";\">\n    <td class=\"fieldlabel\">";
echo $LNG["registrationexp"];
echo " </td>\n    <td class=\"fieldarea\">\n<input type=\"text\" name=\"registration_expire\" class=\"txt small\"\n value=\"";
echo $config["registration_expire"];
echo "\"\n style=\"width: 60px !important\"/> ";
echo $LNG["days"];
echo "<br /><small>";
echo $LNG["regidaysinfo"];
echo "</small>\n    </td>\n</tr>\n\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\">";
echo $LNG["currency"];
echo " </td>\n    <td class=\"fieldarea\">\n<select name=\"registration_currency\">\n<option ";
if ($config["registration_currency"] == "" || !$config["registration_currency"]) {
    echo "selected";
}
echo " value=\"\">User can Select</option>\n";
$CurrencyList = getCurrencyCodeList();
$cs = dquery("select * from tbl_currencies");
while ($rc = mysqli_fetch_assoc($cs)) {
    echo "    <option ";
    if ($config["registration_currency"] == $rc["id"]) {
        echo "selected";
    }
    echo "     value=\"";
    echo $rc["id"];
    echo "\">";
    echo $rc["code"];
    echo " - ";
    echo $CurrencyList[$rc["code"]]["name"];
    echo "</option>\n    ";
}
echo "</select>\n\n    </td>\n</tr>\n<!--\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\">";
echo $LNG["usercansign"];
echo " </td>\n    <td class=\"fieldarea\">\n<input name=\"google\"  value=\"google\" id=\"gog\" type=\"checkbox\" ";
$locks = explode(",", $config["usercan_signup"]);
foreach ($locks as $l) {
    if (trim($l) == "google") {
        echo "checked";
    }
}
echo "  /><label for=\"gog\">";
echo $LNG["google"];
echo " Plus </label>\n<input name=\"yahoo\"  value=\"\" id=\"yah\" type=\"hidden\" />\n\n<input name=\"yahoo\"  value=\"yahoo\" id=\"yah\" type=\"checkbox\" ";
$locks = explode(",", $config["usercan_signup"]);
foreach ($locks as $l) {
    if (trim($l) == "yahoo") {
        echo "checked";
    }
}
echo " /><label for=\"yah\">";
echo $LNG["yahoo"];
echo "</label>\n<input name=\"mygsm\"  value=\"mygsm\" id=\"myg\" type=\"checkbox\" ";
$locks = explode(",", $config["usercan_signup"]);
foreach ($locks as $l) {
    if (trim($l) == "mygsm") {
        echo "checked";
    }
}
echo " /><label for=\"myg\">";
echo $LNG["mygsm"];
echo "</label>\n\n<input name=\"facebook\"  value=\"facebook\" id=\"fah\" type=\"checkbox\" ";
$locks = explode(",", $config["usercan_signup"]);
foreach ($locks as $l) {
    if (trim($l) == "facebook") {
        echo "checked";
    }
}
echo " /><label for=\"fah\">Facebook</label>\n    </td>\n</tr>\n-->\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["newsletter"];
echo " ";
echo $LNG["enable"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input name=\"newsletter_registration\"  value=\"1\" id=\"nyes\"\n    type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\"\n     ";
if ($config["newsletter_registration"]) {
    echo "checked";
}
echo " /> <label for=\"nyes\"></label>\n    </td>\n</tr>\n-->\n<!--<tr class=\"noreg\">\n    <td class=\"fieldlabel\">     </td>\n    <td class=\"fieldarea\">\n    <input name=\"captcha_registration\"  value=\"1\" id=\"yes\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\"  /> <label for=\"yes\"></label>\n    </td>\n</tr>-->\n\n   <!--\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\">   forgot   </td>\n    <td class=\"fieldarea\">\n    <input name=\"captcha_forget\"  value=\"1\" id=\"yesss\" type=\"checkbox\" class=\"onoff {labelOn: 'On', labelOff: 'Off'}\"  /> <label for=\"yesss\"></label>\n    </td>\n</tr>-->\n\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\">";
echo $LNG["requiredterms"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input name=\"registration_terms\"  value=\"true\" type=\"checkbox\"\n    class=\"onoff {labelOn: 'On', labelOff: 'Off'}\"\n    id=\"tr\" ";
if ($config["registration_terms"]) {
    echo "checked";
}
echo " />\n    <label for=\"tr\"></label> <small><a\n    onclick=\"load_subpage('main2.php?page=editpage&id=4&up=4','Edit Terms and condition');\">";
echo $LNG["edit"];
echo "&nbsp;";
echo $LNG["termscond"];
echo "</a> </small>\n    </td>\n</tr>\n\n<!--\n<tr class=\"noreg\">\n    <td class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\">\n    <a class=\"default_dg_a2\" href=\"javascript: void(0)\" onclick=\"load_subpage('main2.php?page=changequestion', '";
echo $LNG["change"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "');\n      return false;\" >\n     ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "</a>\n     </td>\n</tr>\n-->\n\n      <tr class=\"payg\" style=\"";
if ($config["signupgateway"] != 1) {
    echo "display:none";
}
echo "\" >\n          <td class=\"fieldlabel\"></td>\n          <td class=\"fieldarea\">\n              ";
$qp = dquery("select gateway,value from tbl_paymentgateways\nwhere setting='name' group by gateway");
$selgateway = explode(",", $config["defaultgateway"]);
while ($rq = mysqli_fetch_assoc($qp)) {
    echo "            <label><input type=\"checkbox\"\n            name=\"gateway[";
    echo $rq["gateway"];
    echo "]\"\n              ";
    if (in_array($rq["gateway"], $selgateway)) {
        echo "checked";
    }
    echo "            value=\"";
    echo $rq["gateway"];
    echo "\" />";
    echo $rq["value"];
    echo "</label>\n              ";
}
echo "\n          </td>\n      </tr>\n         </table>\n\n  </div>\n  </div>\n<!--\n  <div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["google"];
echo "+ ";
echo $LNG["signup"];
echo "    <a target=\"_blank\"\nhref=\"https://kb.dhru.com/article/262/Creating_Google_Plus_Client_ID_and_Web_API/Dhru_Fusion\">(How to get access ?)</a></span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table class=\"form\">\n<tbody>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["account"];
echo " ";
echo $LNG["client"];
echo " ID</td>\n<td class=\"fieldarea\"><textarea class=\"textarea large\"\n name=\"googleclientid\">";
echo $config["googleclientid"];
echo "</textarea></td>\n</tr>\n\n <tr>\n<td class=\"fieldlabel\">";
echo $LNG["client"];
echo " Secret</td>\n<td class=\"fieldarea\"><input  type=\"text\" name=\"googleclientsecret\"\nvalue=\"";
echo $config["googleclientsecret"];
echo "\" class=\"txt large\" /></td>\n</tr>\n\n</tbody>\n</table>\n</div>\n</div>\n-->\n\n    <!--\n  <div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["facebook"];
echo " ";
echo $LNG["signup"];
echo "    <a target=\"_blank\" href=\"https://kb.dhru.com/article/263/Create_Facebook_Access/Dhru_Fusion\">(How to get access ?)</a></span>\n  </h2>\n  <div class=\"groupstabescontant\">\n        <table class=\"form\">\n     <tbody>\n<tr>\n<td class=\"fieldlabel\">App ID</td>\n<td class=\"fieldarea\"><input  type=\"text\" name=\"facebookappid\"\nvalue=\"";
echo $config["facebookappid"];
echo "\" class=\"txt large\" /></td>\n</tr>\n\n <tr>\n<td class=\"fieldlabel\">App Secret</td>\n<td class=\"fieldarea\"><input  type=\"text\" name=\"facebookappsecret\"\nvalue=\"";
echo $config["facebookappsecret"];
echo "\" class=\"txt large\" /></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["access"];
echo " ";
echo $LNG["token"];
echo "</td>\n<td class=\"fieldarea\"><textarea class=\"textarea large\"\n name=\"facebookaccesstoken\">";
echo $config["facebookaccesstoken"];
echo "</textarea></td>\n</tr>\n\n</tbody>\n</table>\n</div>\n</div>\n-->\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Default Signup Values</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n          <table class=\"form\">\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["api"];
    echo " ";
    echo $LNG["access"];
    echo " </td>\n    <td class=\"fieldarea\">\n    <input name=\"registration_api\"  value=\"1\" type=\"checkbox\"\n    class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"ae\"\n     ";
    if ($config["registration_api"] == 1) {
        echo "checked";
    }
    echo " />\n     <label for=\"ae\"></label>\n    </td>\n</tr>\n";
}
echo "<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["affiliate"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input name=\"registration_affiliate\"  value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"fe\" ";
if ($config["registration_affiliate"] == 1) {
    echo "checked";
}
echo " /><label for=\"fe\"></label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["customize"];
echo " ";
echo $LNG["email"];
echo "</td>\n    <td class=\"fieldarea\">\n<input name=\"customize_email\"  value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"cste\" ";
if ($config["customize_email"] == 1) {
    echo "checked";
}
echo " /><label for=\"cste\"></label>\n    <small>Note: Cient can customize order reply and success mail</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["fraudprotection"];
echo " </td>\n    <td class=\"fieldarea\">\n<input type='checkbox' class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" id=\"frauds\" name='fraud_protection' value='1' ";
if ($config["fraud_protection"]) {
    echo "checked='checked'";
}
echo " /> <label for=\"frauds\"></label>\n<small>Tick to enable fraud protection on registration</small>\n     </td>\n</tr>\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["defaultsignupgroup"];
    echo "</td>\n    <td class=\"fieldarea\">\n    <select name=\"default_signupgroup\">\n       <option value=\"0\">";
    echo $LNG["default"];
    echo "</option>\n       ";
    $sql = dquery("select * from tbl_client_group ORDER by displayorder asc");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<option ";
        if ($row["id"] == $config["default_signupgroup"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["groupname"];
        echo "</option>";
    }
    echo "    </select> &nbsp; <a href=\"#\" data-target=\"clientgroup\" data-target-header=\"";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["client"];
    echo " ";
    echo $LNG["group"];
    echo "\" onclick=\"AddnewInpopup(this);\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["new"];
    echo " ";
    echo $LNG["client"];
    echo " ";
    echo $LNG["group"];
    echo "</a> <small>";
    echo $LNG["signupgroupinfo"];
    echo "</small>\n    </td>\n</tr>\n    ";
}
echo "    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["retail"];
echo " ";
echo $LNG["checkout"];
echo " ";
echo $LNG["group"];
echo "</td>\n        <td class=\"fieldarea\">\n            <select name=\"retailclientgroup\">\n                <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n                ";
$sql = dquery("select * from tbl_client_group ORDER by displayorder asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($row["id"] == $config["retailclientgroup"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo "            </select>\n            <small>";
echo $LNG["autosetgroup"];
echo "</small>\n        </td>\n    </tr>\n\n\n              <tr><td class=\"fieldlabel\"> Transfer Credit</td>\n                  <td class=\"fieldarea\">\n                      <input  type=\"checkbox\" name=\"allowtransfer\" value=\"1\" onclick=\"shower(this)\" id=\"allowtransfer\" ";
if ($config["allowtransfer"] == "1") {
    echo "checked";
}
echo "/><label for=\"allowtransfer\">Allow</label>   <br>\n                      <span id=\"donot\"\n     ";
if ($config["allowtransfer"] != "1") {
    echo "style='display:none';";
}
echo " ><br />\n        <input  type=\"checkbox\" name=\"notdiscounteduser\" value=\"1\" id=\"donotdiscount\" ";
if ($config["notdiscounteduser"] == "1") {
    echo "checked";
}
echo "/><label for=\"donotdiscount\">";
echo $LNG["donotdiscounted"];
echo "</label>\n       <br /> </span>\n\n                  </td>\n              </tr>\n              <tr >\n                  <td class=\"fieldlabel\">";
echo $LNG["allow"];
echo " ";
echo $LNG["payment"];
echo " ";
echo $LNG["gateway"];
echo "</td>\n                  <td class=\"fieldarea\">\n                      <label><input type=\"radio\" onclick=\"paymentGat(this.value)\" name=\"signupgateway\" ";
if (!$config["signupgateway"]) {
    echo "checked";
}
echo " value=\"0\" />";
echo $LNG["all"];
echo "</label>\n                      &nbsp;&nbsp;&nbsp;\n                      <label><input type=\"radio\" onclick=\"paymentGat(this.value)\" name=\"signupgateway\" ";
if ($config["signupgateway"] == 1) {
    echo "checked";
}
echo " value=\"1\" />";
echo $LNG["selected"];
echo "</label>\n                      &nbsp;&nbsp;&nbsp;\n                      <label><input type=\"radio\" onclick=\"paymentGat(this.value)\" name=\"signupgateway\" ";
if ($config["signupgateway"] == 2) {
    echo "checked";
}
echo " value=\"2\" />None</label>\n                  </td>\n              </tr>\n\n\n         </table>\n  </div>\n</div>\n\n";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("regis", $id);
echo "\n\n\n\n<div class=\"groupstabes\"  style=\"position: relative;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Custome Fields</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\">\n<thead>\n<tr>\n<th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n<th>";
echo $LNG["name"];
echo "</th>\n<th>";
echo $LNG["description"];
echo "</th>\n<th>";
echo $LNG["fieldoptions"];
echo "</th>\n<th>";
echo $LNG["validation"];
echo "</th>\n<th>";
echo $LNG["required"];
echo "</th>\n<th align=\"right\">";
echo $LNG["action"];
echo "</th>\n</tr>\n</thead>\n\n    <tr class=\"adddatarow nocheckboxchecked\">\n        <input type=\"hidden\" value=\"regis\" name=\"customfield[-1][type]\"/>\n        <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n        <td>\n        <select class=\"customfield\" name=\"customfield[-1][fieldtype]\">\n            <option value=\"text\">";
echo $LNG["text"];
echo "</option>\n            <option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option>\n            <option value=\"radio\">";
echo $LNG["radio"];
echo "</option>\n            <option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option>\n            <option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option>\n            <option value=\"encrypted\">";
echo $LNG["encrypted"];
echo "</option>\n        </select> </td>\n        <td><input name=\"customfield[-1][fieldname]\" value=\"\" type=\"text\"/>   </td>\n        <td><input name=\"customfield[-1][description]\" value=\"\" type=\"text\" /></td>\n        <td><input class='fieldoptions' name=\"customfield[-1][fieldoptions]\" disabled=\"disabled\" value=\"\" type=\"text\"/><br /> <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n        <td><input class='regexpr' name=\"customfield[-1][regexpr]\" value=\"\" type=\"text\" /><br />  <small>";
echo $LNG["regularexpression"];
echo "  <a href=\"javascript:void(0)\">Help</a> </small></td>\n        <td><input value=\"on\" name=\"customfield[-1][required]\" id=\"required\" checked=\"checked\" type=\"checkbox\" /> <label for=\"required\"></label></td>\n        <td><span class=\"datagridbtn\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"button add\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','registrationsetting','#frm','#notification','true','#main_loader');\"/> </span> </td>\n    </tr>\n\n";
if ($row) {
    foreach ($row as $key => $value) {
        echo "    <tr class=\"nocheckboxchecked\" id=\"";
        echo $key;
        echo "\">\n        <td>";
        echo $row[$key]["fieldtype"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldname"];
        echo "</td>\n        <td>";
        echo $row[$key]["description"];
        echo "</td>\n        <td>";
        echo $row[$key]["fieldoptions"];
        echo "</td>\n        <td>";
        echo $row[$key]["regexpr"];
        echo "</td>\n        <td>";
        echo $row[$key]["required"];
        echo "</td>\n        <td align=\"right\">\n        <div align=\"right\"><input value=\"";
        echo $LNG["delete"];
        echo "\"\n        id=\"";
        echo $key;
        echo "\" class=\"button delete deletedata\" type=\"button\"\n         onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></div>\n        </td>\n    </tr>\n    ";
    }
}
echo "</table>\n  </div>\n</div>\n\n</div>\n<p align=\"center\" class=\"fixedbtn\">   <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\"\n type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','registrationsetting','#frm','#notification','true','#main_loader');\"/>\n</p>\n</div>\n\n</form>";
$fileverioncheck = "6.1.0";

?>