<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "client.head.php";
echo "\n<script>\nfunction selectall(id){\n\n                  var ref = document.getElementById('users');\n                    if(id.checked){\n                        for(i=0; i<ref.options.length; i++)\n                        {\n                            ref.options[i].selected = true;\n                        }\n                    }else{\n                        for(i=0; i<ref.options.length; i++)\n                        {\n                            ref.options[i].selected = false;\n                        }\n                    }\n  var selectedArray = new Array();\n  var selObj = document.getElementById('users');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n\n  \$.post('includes/pages/pos.sales.product.php?groupselected='+ selectedArray, function(data) {\n\n  });\n\n}\nfunction loopSelected()\n{\n  var txtSelectedValuesObj = document.getElementById('usrs');\n  var selectedArray = new Array();\n  var selObj = document.getElementById('users');\n  var i;\n  var count = 0;\n  for (i=0; i<selObj.options.length; i++) {\n    if (selObj.options[i].selected) {\n      selectedArray[count] = selObj.options[i].value;\n      count++;\n    }\n  }\n  txtSelectedValuesObj.value = selectedArray;\n  \$.post('includes/pages/pos.sales.product.php?groupselected='+ txtSelectedValuesObj.value, function(data) {\n\n  });\n}\nfunction getmyUser(val){\nif(val==\"\"){\n    \$.post('includes/pages/pos.sales.product.php?multipleclient=reset', function(data) {\n            if(data){\n                 \$('#users').html(data);\n            }\n    });\n}else{\n  \$.post('includes/pages/pos.sales.product.php?clientgrp='+val, function(data) {\n        \$('#users').html(data);\n  });\n }\n}\n\$(document).ready(function(){\n     \$('#client').keyup(function() {\n            var search=\$(this).val();\n            if(search==''){\n                \$.post('includes/pages/pos.sales.product.php?multipleclient=reset', function(data) {\n                    if(data){\n                         \$('#users').html(data);\n                     }\n                });\n\n            }else{\n                \$.post('includes/pages/pos.sales.product.php?multipleclient='+search, function(data) {\n                    if(data){\n                         \$('#users').html(data);\n                     }\n                });\n            }\n    });\n});\n</script>\n";
licince\chklite();
licince\chkLitePlus();
$pageid = 421;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($clear) {
    unset($_SESSION["clgroup"]);
    unset($_SESSION["seleusers"]);
}
echo "<style>\n.form{margin-bottom: 4px !important;}\ntable select{width: 250px!important;}\n#users{width: 100% !important; border: none;}\n.li_code{float: left;list-style: none;}\n.li_code span{display: block;width: 90px;text-align: center;font-size:11px}\n</style>\n\n\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n\n<div  class=\"groupstabes\" >\n          <div class=\"groupstabescontant\">\n<div class=\"left\" style=\"width: 27%; margin-top: 50px;\">\n<table class=\"form\"><tr><td>\n<div align=\"center\"><!--getmyUser(this.value);-->\n<input type=\"text\" name=\"client\" style=\"float:left; width: 45% !important;\nfont-size: 14px; color: #B7B7B7; margin-bottom: 10px;\"\n onfocus=\"if(this.value=='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "')value='';\"\n onblur=\"if(this.value=='')this.value='";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "';\"\n value=\"";
echo $LNG["search"];
echo " ";
echo $LNG["client"];
echo "\" id=\"client\" />\n ";
if ($clientgrp == "0") {
    unset($_SESSION["clgroup"]);
    unset($_SESSION["seleusers"]);
}
if ($clientgrp) {
    $_SESSION["clgroup"] = $clientgrp;
    unset($_SESSION["seleusers"]);
}
if (isset($_SESSION["clgroup"])) {
    $clientgrp = $_SESSION["clgroup"];
}
if (isset($_SESSION["seleusers"])) {
    $userd = explode(",", $_SESSION["seleusers"]);
    $clientgrp = NULL;
    unset($_SESSION["clgroup"]);
}
echo " <select style=\"float: left; margin-left:10px; width: 45% !important;\" name=\"clientgrp\"\n onchange=\"location.href='main2.php?page=updatemultipalclient&clientgrp='+this.value\" >\n  <option value=\"\">";
echo $LNG["select_"];
echo " ";
echo $LNG["group"];
echo "</option>\n  <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n   ";
$sql = dquery("select * from tbl_client_group");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($clientgrp == $row["id"]) {
        echo "selected='selected'";
    }
    echo "        value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo " </select>\n\n </div>\n ";
if ($clientgrp) {
    $whrcond = " client_group='" . $clientgrp . "' ";
} else {
    $whrcond = " 1=1 ";
}
echo "    <select name=\"user[]\" multiple size=\"40\" id=\"users\"\n    onchange=\"loopSelected();\" style=\"border: #ccc solid 1px;\">\n    ";
$result = dquery("select id,username,credit_left,email,(select code from tbl_currencies where \n    id=default_currency) as currency from tblUsers where (usertype=0 or usertype=1 ) and (" . $whrcond . ") ORDER BY username ASC");
while ($row = mysqli_fetch_assoc($result)) {
    if (is_array($userd)) {
        if (is_array($userd) && in_array($row["id"], $userd)) {
            echo "<option value=" . $row["id"] . " selected=selected> " . $row["username"] . " &nbsp;|&nbsp; " . $row["credit_left"] . " " . $row["currency"] . " &nbsp;|&nbsp; " . $row["email"] . " </option>";
        }
    } else {
        if (is_array($user) && in_array($row["id"], $user)) {
            echo "<option value=" . $row["id"] . " selected=selected> " . $row["username"] . " &nbsp;|&nbsp; " . $row["credit_left"] . " " . $row["currency"] . " &nbsp;|&nbsp; " . $row["email"] . " </option>";
        } else {
            echo "<option value=" . $row["id"] . "> " . $row["username"] . " &nbsp;|&nbsp; " . $row["credit_left"] . " " . $row["currency"] . " &nbsp;|&nbsp; " . $row["email"] . " </option>";
        }
    }
}
echo "</select></td></tr></table>\n\n</div>\n<form method=\"post\" id=\"frms\">\n<div style=\" position: absolute; left: 40px;\">\n<input type=\"checkbox\"  name=\"checkall\" id=\"check\" value=\"1\"\nonclick=\"selectall(this);\"/><label for=\"check\">";
echo $LNG["select_"];
echo " ";
echo $LNG["all"];
echo "</label>\n<br /><small>Press ctrl key to select multipal user </small>\n</div>\n<input type=\"hidden\" name=\"user\" id=\"usrs\" />\n<div class=\"left\" style=\"width: 72%;\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">General Settings</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table cellspacing=\"0\" cellpadding=\"0\" class=\"form\">\n            <tr>\n                <td  width=\"200px\">";
echo $LNG["template"];
echo "</td><td >";
echo getTemplatesDropDown();
echo " </td>\n                <td align=\"right\"><input type=\"button\" id=\"assign_template\" name=\"assign_template\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["template"];
echo "\" onclick=\"SubmitForm ('#assign_template','multipalaccount.template','#frms','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n                <td >";
echo $LNG["language"];
echo "</td><td >";
echo getLanguageDropdown2();
echo " </td>\n                <td align=\"right\"><input type=\"button\" id=\"assign_language\" name=\"assign_language\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["language"];
echo "\" onclick=\"SubmitForm ('#assign_language','multipalaccount.language','#frms','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n                <td >";
echo $LNG["reset"];
echo " ";
echo $LNG["password"];
echo "</td><td ><input type=\"checkbox\" name=\"sendmail\" id=\"sendmail\" value=\"1\"/> <label for=\"sendmail\">";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["with"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["password"];
echo "</label></td>\n                <td align=\"right\"> <input type=\"button\" id=\"assign_password\"  value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["password"];
echo "\" onclick=\"SubmitForm ('#assign_password','multipalaccount.resetpassword','#frms','#notification','true','#main_loader');\"/></td></tr>\n\n            <tr>\n\n    <td >";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "</td><td >\n    <td align=\"right\"> <input type=\"button\" id=\"resetsecu\"\nvalue=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "\"\nonclick=\"SubmitForm('#resetsecu','multipalaccount.resetquestion','#frms','#notification','true','#main_loader');\"/></td>\n            </tr>\n\n            <tr>\n                <td >";
echo $LNG["reset"];
echo " ";
echo $LNG["master"];
echo " ";
echo $LNG["pin"];
echo "</td><td ><input type=\"checkbox\" name=\"sendmailpin\" id=\"sendmailpin\" value=\"1\"/> <label for=\"sendmailpin\">";
echo $LNG["send"];
echo " ";
echo $LNG["mail"];
echo " ";
echo $LNG["to"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["with"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["pin"];
echo "</label></td>\n                <td align=\"right\"> <input type=\"button\" id=\"assign_pin\"  value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["pin"];
echo "\" onclick=\"SubmitForm ('#assign_pin','multipalaccount.resetpin','#frms','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n                <td > ";
echo $LNG["user"];
echo " ";
echo $LNG["status"];
echo "</td><td ><input type=\"radio\" name=\"status\" value=\"0\" checked=\"checked\" id=\"ac\"/><label for=\"ac\"> ";
echo $LNG["active"];
echo " </label><input type=\"radio\" name=\"status\" value=\"2\" id=\"in\"/><label for=\"in\">";
echo $LNG["inactive"];
echo "</label></td>\n                <td align=\"right\"><input type=\"button\" id=\"status\" name=\"status\"\nvalue=\"";
echo $LNG["update"];
echo " ";
echo $LNG["status"];
echo "\" onclick=\"SubmitForm ('#status','multipalaccount.userstatus','#frms','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n                <td > ";
echo $LNG["api"];
echo " ";
echo $LNG["access"];
echo "</td><td ><input type=\"radio\" name=\"api\" value=\"1\" checked=\"checked\" id=\"ae\"/><label for=\"ae\"> ";
echo $LNG["enable"];
echo " </label><input type=\"radio\" name=\"api\" value=\"0\" id=\"ad\"/><label for=\"ad\">";
echo $LNG["disable"];
echo "</label></td>\n                <td align=\"right\"><input type=\"button\" id=\"apis\" name=\"apis\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["api"];
echo "\" onclick=\"SubmitForm ('#apis','multipalaccount.api','#frms','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n                <td > ";
echo $LNG["affiliate"];
echo "</td><td ><input type=\"radio\" name=\"affiliate\" value=\"1\" checked=\"checked\" id=\"fe\"/><label for=\"fe\"> ";
echo $LNG["enable"];
echo " </label><input type=\"radio\" name=\"affiliate\" value=\"0\" id=\"fd\"/><label for=\"fd\">";
echo $LNG["disable"];
echo "</label></td>\n                <td align=\"right\"><input type=\"button\" id=\"affiliates\" name=\"affiliates\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["affiliate"];
echo "\" onclick=\"SubmitForm ('#affiliates','multipalaccount.affiliate','#frms','#notification','true','#main_loader');\"/></td></tr>\n<tr>\n<td > ";
echo $LNG["newsletter"];
echo "</td>\n<td >\n<input type=\"radio\" name=\"news_letter\" value=\"1\" checked=\"checked\" id=\"nsse\"/>\n<label for=\"nsse\"> ";
echo $LNG["enable"];
echo " </label>\n<input type=\"radio\" name=\"news_letter\" value=\"0\" id=\"sfd\"/>\n<label for=\"sfd\">";
echo $LNG["disable"];
echo "</label></td>\n<td align=\"right\"><input type=\"button\" id=\"news\" name=\"news\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["newsletter"];
echo "\" onclick=\"SubmitForm ('#news','multipalaccount.newsletter','#frms','#notification','true','#main_loader');\"/></td>\n</tr>\n<tr>\n<td > ";
echo $LNG["fraudprotection"];
echo "</td>\n<td >\n<input type=\"radio\" name=\"fraudprotection\" value=\"1\" checked=\"checked\" id=\"fsse\"/>\n<label for=\"fsse\"> ";
echo $LNG["enable"];
echo " </label>\n<input type=\"radio\" name=\"fraudprotection\" value=\"0\" id=\"fsfd\"/>\n<label for=\"fsfd\">";
echo $LNG["disable"];
echo "</label></td>\n<td align=\"right\">\n<input type=\"button\" id=\"news\" name=\"news\"\nvalue=\"";
echo $LNG["update"];
echo " ";
echo $LNG["fraudprotection"];
echo "\"\nonclick=\"SubmitForm ('#news','multipalaccount.fraudprotection','#frms','#notification','true','#main_loader');\"/></td>\n</tr>\n\n<tr>\n<td>\n";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "</td>\n<td>\n\n  <select name=\"profilemail\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='general'\n  or type='other'\n  or type='newsletter'\n  \n  group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "  <optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n ";
    $s = dquery("select id,name,type from tbl_emailtemplates WHERE type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "    <option  style=\"background-color: #FFF;\" value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["name"];
        echo "</option>\n ";
    }
    echo "    </optgroup>\n";
}
echo " </select>\n </td>\n <td align=\"right\"><input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\"\n id=\"btnpsail\"\n onclick=\"SubmitForm ('#btnpsail','edituser.sendmultimail','#frms','#notification','true','#main_loader');\" /></td>\n</tr>\n\n<tr>\n<td>\n";
echo $LNG["client"];
echo " ";
echo $LNG["group"];
echo "</td>\n<td>\n        <select name=\"clientgroup\">\n           <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n           ";
$sql = dquery("select * from tbl_client_group where fee='' or fee='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($row["id"] == $clientDetails["client_group"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo "        </select>\n </td>\n <td align=\"right\"><input type=\"button\" name=\"btnclientgr\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["client"];
echo " ";
echo $LNG["group"];
echo "\"\n id=\"btnclientgr\"\n onclick=\"SubmitForm ('#btnclientgr','multipalaccount.clientgroup','#frms','#notification','true','#main_loader');\" /></td>\n</tr>\n<tr>\n<td>\n&nbsp;\n</td>\n<td>\n<input type=\"checkbox\" name=\"groupforce\" id=\"groupforce\"/><label for=\"groupforce\"> ";
echo $LNG["updateclientgroupinfo"];
echo "</label>\n </td>\n <td>&nbsp;</td>\n</tr>\n<tr>\n<td>\n&nbsp;\n</td>\n<td>&nbsp;\n </td>\n <script>\n function getMY(){\n  var selectedValues = [];\n    \$(\"#users :selected\").each(function(){\n        selectedValues.push(\$(this).val());\n    });\n    return selectedValues;\n}\n </script>\n <!-- -->\n <td align=\"right\">\n  <input class=\"button_remove\" type=\"button\" name=\"removeotp\" id=\"removeotp\"\n onclick=\"SubmitForm ('#removeotp','multipalaccount.otp','#frms','#notification','true','#main_loader');\"\nvalue=\"";
echo $LNG["remove"];
echo " OTP\" />\n\n\n <input class=\"button_remove\" type=\"button\" name=\"removeclient\" id=\"removeclient\"\n  onclick=\"\n  if(confirm('Are you sure want to remove User account ?')){\n   var vals=getMY();\n load_subpage('main2.php?page=closeaccount&uid='+vals,'Close Account');\n   }\"\nvalue=\"";
echo $LNG["remove"];
echo " ";
echo $LNG["client"];
echo "\" />\n\n\n</td>\n</tr>\n<!--\nSubmitForm ('#removeclient','multipalaccount.removeclient','#frms','#notification','true','#main_loader');\n-->\n</table>\n</div></div>\n<br />\n";
if (!$OnlyEcommerce) {
    $result = dquery("select id,service_name from tbl_services_imei");
    while ($rowi = mysqli_fetch_assoc($result)) {
        $imeiService[$rowi["id"]] = $rowi["service_name"];
    }
    echo "\n";
    $result = dquery("select id,service_name from tbl_services_file");
    while ($rowf = mysqli_fetch_assoc($result)) {
        $fileService[$rowf["id"]] = $rowf["service_name"];
    }
    echo "\n";
    $result = dquery("select id,service_name from tbl_server_log");
    while ($rows = mysqli_fetch_assoc($result)) {
        $serverService[$rows["id"]] = $rows["service_name"];
    }
    $default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
    if (!$IsFileOnly) {
        echo " <fieldset style=\"padding: 10px;\">\n\t<legend style=\"border: 0;padding:0\">\n\t\t<select id=\"imei_service_id\" name=\"imei_service_id\"  style=\"width: 300px;\"\n        onchange=\"javascript:location='main2.php?imei='+this.value+'&page=updatemultipalclient'\">\n\t\t<option value=\"\">";
        echo $LNG["select_"];
        echo " ";
        echo $LNG["imei"];
        echo " ";
        echo $LNG["service"];
        echo " </option>\n            <option ";
        if ($imei == "ALL") {
            echo "selected";
        }
        echo " value=\"ALL\">";
        echo $LNG["all"];
        echo "</option>\n\t\t";
        foreach ($imeiService as $key => $value) {
            if ($imei == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
        echo "</select>\n        <input type=\"button\" class=\"addFromgallery\" id=\"imeiservice\" name=\"assign_imei\" value=\"";
        echo $LNG["assign"];
        echo " ";
        echo $LNG["service"];
        echo "\" onClick=\"SubmitForm ('#imeiservice','multipalaccount.imeiassignservice','#frms','#notification','true','#main_loader');\"/>\n\t</legend>\n<li class=\"li_code\"><span>";
        echo $LNG["code"];
        echo "</span><span>";
        echo $LNG["service"];
        echo " ";
        echo $LNG["credit"];
        echo "</span><span>";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["credit"];
        echo "</span></li>\n ";
        if ($imei) {
            $imeiprice = mysqli_fetch_assoc(dquery("select credit from tbl_services_imei where id='" . $imei . "'"));
        }
        $result = dquery("select code,id from tbl_currencies");
        while ($imeicredit = mysqli_fetch_assoc($result)) {
            $priceset = mysqli_fetch_assoc(dquery("select credit from tbl_imei_credit where service_id='" . $imei . "' and currency_id='" . $imeicredit["id"] . "'"));
            if ($priceset["credit"]) {
                echo "   <li class=\"li_code\"><span>";
                echo $imeicredit["code"];
                echo "<input type=\"hidden\" name=\"imei_hidden_dis[";
                echo $imeicredit["id"];
                echo "]\" value=\"";
                echo $priceset["credit"];
                echo "\"/></span><span>";
                echo $priceset["credit"];
                echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"imei_discount[";
                echo $imeicredit["id"];
                echo "]\"/></span></li>\n    ";
            } else {
                echo "    <li class=\"li_code\"><span>";
                echo $imeicredit["code"];
                echo "<input type=\"hidden\" name=\"imei_hidden_dis[";
                echo $imeicredit["id"];
                echo "]\" value=\"";
                echo convertCurrency($imeiprice["credit"], $default_currency["id"], $imeicredit["id"]);
                echo "\"/></span><span>";
                echo convertCurrency($imeiprice["credit"], $default_currency["id"], $imeicredit["id"]);
                echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"imei_discount[";
                echo $imeicredit["id"];
                echo "]\"/></span></li>\n";
            }
        }
        echo "<p align=\"left\" class=\"clear\"> <br />\n<input type=\"button\" id=\"imeidiscount\" value=\"";
        echo $LNG["update"];
        echo " ";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["credit"];
        echo " ";
        echo $LNG["of"];
        echo " ";
        echo $LNG["this"];
        echo " ";
        echo $LNG["service"];
        echo "\" onclick=\"SubmitForm ('#imeidiscount','multipalaccount.imeiresetdiscount','#frms','#notification','true','#main_loader');\"/>\n</p>\n</fieldset>\n<br />\n";
    }
    echo "<fieldset style=\"padding: 10px;\">\n\t<legend style=\"border: 0;padding:0\">\n\t\t<select id=\"file_service_id\" name=\"file_service_id\" onchange=\"javascript:location='main2.php?file='+this.value+'&page=updatemultipalclient'\">\n\t\t<option value=\"\">";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["file"];
    echo " ";
    echo $LNG["service"];
    echo " </option>\n        <option ";
    if ($file == "ALL") {
        echo "selected";
    }
    echo " value=\"ALL\">";
    echo $LNG["all"];
    echo "</option>\n\t\t";
    foreach ($fileService as $key => $value) {
        if ($file == $key) {
            echo "<option value=" . $key . " selected>" . $value . "</option>";
        } else {
            echo "<option value=" . $key . ">" . $value . "</option>";
        }
    }
    echo "</select>\n        <input class=\"addFromgallery\" type=\"button\" id=\"fileservice\" name=\"assign_file\" value=\"";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["service"];
    echo "\" onClick=\"SubmitForm ('#fileservice','multipalaccount.fileassignservice','#frms','#notification','true','#main_loader');\"/>\n\t</legend>\n<li class=\"li_code\"><span>";
    echo $LNG["code"];
    echo "</span><span>";
    echo $LNG["service"];
    echo " ";
    echo $LNG["credit"];
    echo "</span><span>";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["credit"];
    echo "</span></li>\n ";
    if ($file) {
        $fileprice = mysqli_fetch_assoc(dquery("select credit from tbl_services_file where id='" . $file . "'"));
    }
    $result = dquery("select code,id from tbl_currencies");
    while ($filecredit = mysqli_fetch_assoc($result)) {
        $priceset = mysqli_fetch_assoc(dquery("select credit from tbl_file_credit where service_id='" . $file . "' and currency_id='" . $filecredit["id"] . "'"));
        if ($priceset["credit"]) {
            echo "        <li class=\"li_code\"><span>";
            echo $filecredit["code"];
            echo "<input type=\"hidden\" name=\"file_hidden_dis[";
            echo $filecredit["id"];
            echo "]\" value=\"";
            echo $priceset["credit"];
            echo "\"/></span><span>";
            echo $priceset["credit"];
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[";
            echo $filecredit["id"];
            echo "]\"/></span></li>\n    ";
        } else {
            echo "    <li class=\"li_code\"><span>";
            echo $filecredit["code"];
            echo "<input type=\"hidden\" name=\"file_hidden_dis[";
            echo $filecredit["id"];
            echo "]\" value=\"";
            echo convertCurrency($fileprice["credit"], $default_currency["id"], $filecredit["id"]);
            echo "\"/></span><span>";
            echo convertCurrency($fileprice["credit"], $default_currency["id"], $filecredit["id"]);
            echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[";
            echo $filecredit["id"];
            echo "]\"/></span></li>\n";
        }
    }
    echo "<p align=\"left\" class=\"clear\"> <br />\n<input type=\"button\" id=\"filediscount\" value=\"";
    echo $LNG["update"];
    echo " ";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["credit"];
    echo " ";
    echo $LNG["of"];
    echo " ";
    echo $LNG["this"];
    echo " ";
    echo $LNG["service"];
    echo "\" onclick=\"SubmitForm ('#filediscount','multipalaccount.fileresetdiscount','#frms','#notification','true','#main_loader');\"/>\n</p>\n</fieldset>\n\n<br />\n";
    if (!$IsFileOnly) {
        echo "\n<fieldset style=\"padding: 10px;\">\n\t<legend style=\"border: 0;padding:0\">\n\t\t<select id=\"server_service_id\" name=\"server_service_id\" onchange=\"javascript:location='main2.php?server='+this.value+'&page=updatemultipalclient'\">\n\t\t<option value=\"\">";
        echo $LNG["select_"];
        echo " ";
        echo $LNG["server"];
        echo " ";
        echo $LNG["service"];
        echo " </option>\n        <option ";
        if ($server == "ALL") {
            echo "selected";
        }
        echo " value=\"ALL\">";
        echo $LNG["all"];
        echo "</option>\n\t\t";
        foreach ($serverService as $key => $value) {
            if ($server == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
        echo "</select>\n        <input type=\"button\" class=\"addFromgallery\" id=\"serverservice\" name=\"assign_server\" value=\"";
        echo $LNG["assign"];
        echo " ";
        echo $LNG["service"];
        echo "\" onClick=\"SubmitForm ('#serverservice','multipalaccount.serverassignservice','#frms','#notification','true','#main_loader');\"/>\n\t</legend>\n\n<li class=\"li_code\"><span>";
        echo $LNG["code"];
        echo "</span><span>";
        echo $LNG["service"];
        echo " ";
        echo $LNG["credit"];
        echo "</span><span>";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["credit"];
        echo "</span></li>\n ";
        if ($server) {
            $result = dquery("select credit from tbl_server_log where id='" . $server . "'");
            $numberrows = mysqli_num_rows($result);
            if ($numberrows) {
                $serverprice = mysqli_fetch_assoc($result);
            }
        }
        $result = dquery("select code,id from tbl_currencies");
        while ($servercredit = mysqli_fetch_assoc($result)) {
            $priceset = mysqli_fetch_assoc(dquery("select credit from tbl_server_credit where service_id='" . $server . "' and currency_id='" . $servercredit["id"] . "'"));
            if ($priceset["credit"]) {
                echo "        <li class=\"li_code\"><span>";
                echo $servercredit["code"];
                echo "<input type=\"hidden\" name=\"server_hidden_dis[";
                echo $servercredit["id"];
                echo "]\" value=\"";
                echo $priceset["credit"];
                echo "\"/></span><span>";
                echo $priceset["credit"];
                echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"server_discount[";
                echo $servercredit["id"];
                echo "]\"/></span></li>\n    ";
            } else {
                echo "    <li class=\"li_code\"><span>";
                echo $servercredit["code"];
                echo "<input type=\"hidden\" name=\"server_hidden_dis[";
                echo $servercredit["id"];
                echo "]\" value=\"";
                echo convertCurrency($serverprice["credit"], $default_currency["id"], $servercredit["id"]);
                echo "\"/></span><span>";
                echo convertCurrency($serverprice["credit"], $default_currency["id"], $servercredit["id"]);
                echo "</span><span><input type=\"text\" style=\"width: 50px;\" name=\"server_discount[";
                echo $servercredit["id"];
                echo "]\"/></span></li>\n";
            }
        }
        echo "<p align=\"left\" class=\"clear\"> <br />\n<input type=\"button\" id=\"serverdiscount\" value=\"";
        echo $LNG["update"];
        echo " ";
        echo $LNG["custom"];
        echo " ";
        echo $LNG["credit"];
        echo " ";
        echo $LNG["of"];
        echo " ";
        echo $LNG["this"];
        echo " ";
        echo $LNG["service"];
        echo "\" onclick=\"SubmitForm ('#serverdiscount','multipalaccount.serverresetdiscount','#frms','#notification','true','#main_loader');\"/>\n</p>\n</fieldset>\n";
    }
}
echo "</div>\n</form>\n<div class=\"clear\"></div>\n</div>\n</div>\n\n</div>\n</div>\n<div id=\"page_info\" class=\"page_info\">\n\t<li>Change multiple clients details like service access, language , password , pin number.</li>\n</div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"http://kb.dhru.com/Dhru_Fusion/Clients/Manage_multiple_accounts\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>