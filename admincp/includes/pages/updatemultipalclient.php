<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "client.head.php";
licince\chklite();
licince\chkLitePlus();
$pageid = 421;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
include_once ROOTDIR . "/includes/countries.php";
if ($clear) {
    unset($_SESSION["clgroup"]);
    unset($_SESSION["seleusers"]);
}
echo "<script>\n    function checkAll()\n    {\n        \$('.gateways').prop('checked', true);\n    }\n    function uncheckAll()\n    {\n        \$('.gateways').prop('checked', false);\n    }\n    function paymentGat(ob)\n    {\n        if(ob.checked)\n        {\n            \$(\"#paymentgat\").show();\n        }else{\n            \$(\"#paymentgat\").hide();\n        }\n    }\n</script>\n <style>\n.li_code{\n    float: left;list-style: none;\n    border-right: #eee solid 1px;\n    border-bottom: #eee solid 1px;\n}\n.li_code span {\n    display: block;\n    width: 90px;\n    text-align: center;\n    font-size: 12px;\n    font-size: 15px;\n    border-left: #eee solid 1px;\n    border-top: #eee solid 1px;\n    padding: 10px;\n}\n.span-select::after{\n    display: none;\n}\nfieldset legend {\n    color: #888888;\n    display: block;\n    font-weight: normal;\n    line-height: 24px;\n    margin-left: 5px;\n    padding: 10px;\n    width: 100%;\n    background: #fafafa;\n}\n.popup-content {\n    background: #ffffff none repeat scroll 0 0;\n    border-radius: 3px;\n    bottom: 5%;\n    box-shadow: 0 0 20px 2px #cccccc;\n    left: 5%;\n    position: fixed;\n    right: 5%;\n    top: 5%;\n    z-index: 999;\n}\n </style>\n\n<script>\n    function setString(obj){\n        if(\$(obj).next('input[type=\"hidden\"]').length==0){\n            \$(obj).after('<input type=\"hidden\" name=\"'+\$(obj).attr('name')+'s\">');\n        }\n        \$('input[name='+\$(obj).attr('name')+'s]').val(\$(obj).val().join(','));\n    }\n    function getResult(obj){\n        parent.showLoader();\n        console.log(\$(obj).serialize());\n        \$.post('includes/pages/getmultipalclient.php',\$(obj).serialize() , function (data, textStatus) {\n            \$('#result').html(data);\n            parent.hideLoader();\n        });\n    }\n    function getCheckbox(obj){\n       var str='';\n       \$('#result :checkbox:checked').each(function(){\n            str+=\$(this).val()+',';\n       });\n       \$('#users').val(str);\n   }\n\n   function selectall(obj){\n        if(\$(obj).is(':checked')){\n            \$('#result :checkbox').each(function(){\n                \$(this).attr('checked',true);\n                \$(this).attr('disabled',true);\n            });\n        }\n        else{\n            \$('#result :checkbox').each(function(){\n                \$(this).attr('checked',false);\n                \$(this).attr('disabled',false);\n            });\n        }\n   }\n\n   function getPrices(val,obj){\n\n        \$.post( \"includes/pages/getServiceByPrice.php?\"+obj+\"=\"+val, function( data ) {\n            if(data){\n              \$( \"#loade\"+obj ).html( data );\n            }\n        });\n   }\n\n   function setCountry(val){\n        \$(\"#idcountry\").val(val);\n   }\n   function setGroup(val){\n        \$(\"#idgroup\").val(val);\n   }\n   function setStatus(val){\n        \$(\"#idstatuss\").val(val);\n   }\n\n    function setResellers(val){\n        \$(\"#idresellers\").val(val);\n    }\n   function setReseller(val){\n     \$(\"#idreseller\").val(val);\n   }\n   function setCheckAll(val){\n        if(\$('#check').is(\":checked\"))\n        {\n            \$(\"#idcheckall\").val(1);\n        }else{\n            \$(\"#idcheckall\").val(0);\n        }\n   }\n</script>\n\n\n<div id=\"notification\"></div>\n\n       <div>\n           <form method=\"post\" id=\"frmsparam2\" >\n               <div id=\"content\" class=\"mt-2\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\" >\n\n                        <div style=\"float: left;\">\n                            <select name=\"group\" class=\"mselect\" onchange=\"setString(this); setGroup(this.value);\" multiple=\"true\">\n                                <option value=\"\">- All Group -</option>\n                                <option value=\"0\">";
echo $LNG["default"];
echo "</option>\n                                ";
$sql = dquery("select * from tbl_client_group");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["groupname"];
    echo "</option>";
}
echo "                            </select>\n                        </div>\n                        <div style=\"float: left;\">\n        <select name=\"type\"  class=\"mselect\" onchange=\"setString(this); setResellers(this.value);\" multiple=\"true\">\n            <option value=\"\">- All User Type -</option>\n            <option value=\"0\">User</option>\n            <option value=\"1\">Reseller</option>\n            <option value=\"3\">Reseller's User</option>\n        </select>\n                        </div>\n                        <div style=\"float: left;\">\n            <select name=\"status\"  class=\"mselect\" onchange=\"setString(this); setStatus(this.value);\" multiple=\"true\">\n                <option value=\"\">- All Status -</option>\n                <option value=\"0\">Active</option>\n                <option value=\"1\">In Active</option>\n                <option value=\"2\">New Registered</option>\n            </select>\n                        </div>\n                        <div style=\"float: left;\">\n        <select name=\"reseller\"  class=\"mselect\" onchange=\"setString(this); setReseller(this.value);\" multiple=\"true\">\n            <option value=\"\">- All Reseller -</option>\n            ";
$sql = dquery("select username,id from tblUsers where usertype=1");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["username"];
    echo "</option>";
}
echo "        </select>\n                         </div>\n    <div style=\"float: left;\">\n        <select name=\"country\" class=\"mselect\" onchange=\"setString(this); setCountry(this.value);\" multiple=\"true\">\n            <option value=\"\">- All Country -</option>\n            ";
require ROOTDIR . "/includes/countries.php";
foreach ($countries as $countriesvalue1 => $countriesvalue2) {
    echo "                <option value=\"";
    echo $countriesvalue1;
    echo "\">";
    echo $countriesvalue2;
    echo "</option>\n                ";
}
echo "        </select>\n    </div>\n                        <div style=\"float: left;margin:3px;padding:30px 0\">\n                           <input type=\"hidden\" name=\"search\" value=\"search\"/>\n                           <input type=\"button\" value=\"search\"  name=\"search-btn\" onclick=\"getResult('#frmsparam');\$('.action-btn').show()\" />\n                        </div>\n\n                    <div style=\"clear: both;\"></div>\n\n                <br />\n                <div style=\"height: 600px;overflow-y: auto;\">\n                    <table id=\"main_tbl\">\n                        <thead>\n              <tr><th><label> <input type=\"checkbox\" class=\"default-checkbox\"  name=\"checkall\" id=\"check\"\n               value=\"1\" onclick=\"selectall(this); setCheckAll(this);\"/> User Name </label></th>\n<th>Email</th><th>Credit Left</th><th></th></tr>\n                        </thead>\n                        <tbody id=\"result\"></tbody>\n                    </table>\n                 </div>\n                 <p class=\"fixedbtn action-btn\"  style=\"display: none;\">\n<input type=\"button\" class=\"btn\" value=\"Action\"\nname=\"action-btn\"\nonclick=\"inlinePopup('#updatemultiple','Update Multiple Client');\" />\n                 </p>\n                 </div></div></div>\n\n                 </form>\n                </div>\n\n                <div id=\"updatemultiple\"  style=\"display: none\">\n    <form action=\"\" id=\"frmsparam\" style=\"position: relative;\">\n    <input type=\"hidden\" name=\"countrys\" id=\"idcountry\" value=\"\" />\n    <input type=\"hidden\" name=\"group\" id=\"idgroup\" value=\"\" />\n    <input type=\"hidden\" name=\"statuss\" id=\"idstatuss\" value=\"\" />\n    <input type=\"hidden\" name=\"resellers\" id=\"idresellers\" value=\"\" />\n    <input type=\"hidden\" name=\"reseller\" id=\"idreseller\" value=\"\" />\n    <input type=\"hidden\" name=\"checkall\" id=\"idcheckall\" value=\"\" />\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<div  class=\"groupstabes\">\n\n        <div class=\"floatleft\">\n\n\n\n\n<small>Change general settings value of selected  clients from list</small>\n\n\n <table cellspacing=\"0\" cellpadding=\"0\" class=\"form\">\n";
if (mysqli_num_rows(dquery("select id from tblUsers\nwhere default_currency not in (select id from tbl_currencies)"))) {
    echo "<tr>\n<td  class=\"fieldlabel\"></td>\n<td  class=\"fieldarea\">\n<input type=\"button\" id=\"setcurrency\" name=\"setcurrency\"\nvalue=\"";
    echo $LNG["set"];
    echo " ";
    echo $LNG["currency"];
    echo " if ";
    echo $LNG["not"];
    echo " ";
    echo $LNG["assigned"];
    echo "\"\nonclick=\"SubmitForm ('#assign_template','multipalaccount.currency','#frmsparam','#notification','true','#main_loader');\"/>\n</td></tr>\n";
}
echo "\n            <tr>\n                <td  class=\"fieldlabel\">";
echo $LNG["template"];
echo "</td><td   class=\"fieldarea\">";
echo getTemplatesDropDown();
echo "                <input type=\"button\" id=\"assign_template\" name=\"assign_template\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["template"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#assign_template','multipalaccount.template','#frmsparam','#notification','true','#main_loader');\"/></td></tr>\n\n\n            <tr>\n                <td   class=\"fieldlabel\">";
echo $LNG["language"];
echo "</td><td   class=\"fieldarea\">";
echo getLanguageDropdown2();
echo "                <input type=\"button\" id=\"assign_language\" name=\"assign_language\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["language"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#assign_language','multipalaccount.language','#frmsparam','#notification','true','#main_loader');\"/></td>\n            </tr>\n\n     <tr>\n         <td   class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td><td   class=\"fieldarea\">\n             <select name=\"country\" style=\"width: 180px;\">\n            ";
foreach ($countries as $cid => $cname) {
    echo "                    <option value=\"";
    echo $cid;
    echo "\">";
    echo $cname;
    echo "</option>\n            ";
}
echo "             </select>\n             <input type=\"button\" id=\"assign_country\" name=\"assign_country\"\n                    value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["country"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#assign_language','multipalaccount.country','#frmsparam','#notification','true','#main_loader');\"/></td>\n     </tr>\n\n     <tr>\n                <td  class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["password"];
echo "</td><td   class=\"fieldarea\"><input type=\"checkbox\" name=\"sendmail\" id=\"sendmail\" value=\"1\"/> <label for=\"sendmail\">";
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
echo "</label> <input type=\"button\" id=\"assign_password\"  value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["password"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#assign_password','multipalaccount.resetpassword','#frmsparam','#notification','true','#main_loader');\"/></td></tr>\n            <tr>\n\n    <td   class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "</td><td   class=\"fieldarea\">\n   <input type=\"button\" id=\"resetsecu\"\nvalue=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "\"\nonclick=\"getCheckbox();SubmitForm('#resetsecu','multipalaccount.resetquestion','#frmsparam','#notification','true','#main_loader');\"/></td>\n            </tr>\n\n            <tr>\n                <td class=\"fieldlabel\">";
echo $LNG["reset"];
echo " ";
echo $LNG["master"];
echo " ";
echo $LNG["pin"];
echo "</td><td   class=\"fieldarea\"><input type=\"checkbox\" name=\"sendmailpin\" id=\"sendmailpin\" value=\"1\"/> <label for=\"sendmailpin\">";
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
echo "</label> <input type=\"button\" id=\"assign_pin\"  value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["pin"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#assign_pin','multipalaccount.resetpin','#frmsparam','#notification','true','#main_loader');\"/></td>\n            </tr>\n     <tr>\n                <td   class=\"fieldlabel\"> ";
echo $LNG["user"];
echo " ";
echo $LNG["status"];
echo "</td><td   class=\"fieldarea\"><input type=\"radio\" name=\"status\" value=\"0\" checked=\"checked\" id=\"ac\"/><label for=\"ac\"> ";
echo $LNG["active"];
echo " </label><input type=\"radio\" name=\"status\" value=\"1\" id=\"in\"/><label for=\"in\">Block</label> <input type=\"button\" id=\"status\" name=\"status\"\nvalue=\"";
echo $LNG["update"];
echo " ";
echo $LNG["status"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#status','multipalaccount.userstatus','#frmsparam','#notification','true','#main_loader');\"/></td></tr>\n    ";
if (!$OnlyEcommerce) {
    echo "            <tr>\n                <td class=\"fieldlabel\"> ";
    echo $LNG["api"];
    echo " ";
    echo $LNG["access"];
    echo "</td>\n                <td class=\"fieldarea\"><input type=\"radio\" name=\"api\" value=\"1\"\n                    checked=\"checked\" id=\"ae\"/><label for=\"ae\"> ";
    echo $LNG["enable"];
    echo " </label>\n                    <input type=\"radio\" name=\"api\" value=\"0\" id=\"ad\"/>\n                    <label for=\"ad\">";
    echo $LNG["disable"];
    echo "</label>\n                    <input type=\"button\" id=\"apis\" name=\"apis\"\n                    value=\"";
    echo $LNG["update"];
    echo " ";
    echo $LNG["api"];
    echo "\"\n                    onclick=\"getCheckbox();SubmitForm ('#apis','multipalaccount.api','#frmsparam','#notification','true','#main_loader');\"/></td>\n            </tr>\n            <tr>\n    ";
}
echo "                <td   class=\"fieldlabel\"> ";
echo $LNG["affiliate"];
echo "</td><td   class=\"fieldarea\"><input type=\"radio\" name=\"affiliate\" value=\"1\" checked=\"checked\" id=\"fe\"/><label for=\"fe\"> ";
echo $LNG["enable"];
echo " </label><input type=\"radio\" name=\"affiliate\" value=\"0\" id=\"fd\"/><label for=\"fd\">";
echo $LNG["disable"];
echo "</label> <input type=\"button\" id=\"affiliates\" name=\"affiliates\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["affiliate"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#affiliates','multipalaccount.affiliate','#frmsparam','#notification','true','#main_loader');\"/></td></tr>\n<tr>\n<td class=\"fieldlabel\"> ";
echo $LNG["newsletter"];
echo "</td>\n<td class=\"fieldarea\">\n    <input type=\"radio\" name=\"news_letter\" value=\"1\" checked=\"checked\" id=\"nsse\"/>\n    <label for=\"nsse\"> ";
echo $LNG["enable"];
echo " </label>\n    <input type=\"radio\" name=\"news_letter\" value=\"0\" id=\"sfd\"/>\n    <label for=\"sfd\">";
echo $LNG["disable"];
echo "</label> <input type=\"button\" id=\"news\" name=\"news\" value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["newsletter"];
echo "\" onclick=\"getCheckbox();SubmitForm ('#news','multipalaccount.newsletter','#frmsparam','#notification','true','#main_loader');\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"> ";
echo $LNG["fraudprotection"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"fraudprotection\" value=\"1\" checked=\"checked\" id=\"fsse\"/>\n    <label for=\"fsse\"> ";
echo $LNG["enable"];
echo " </label>\n    <input type=\"radio\" name=\"fraudprotection\" value=\"0\" id=\"fsfd\"/>\n    <label for=\"fsfd\">";
echo $LNG["disable"];
echo "</label>\n    <input type=\"button\" id=\"news\" name=\"news\"\n    value=\"";
echo $LNG["update"];
echo " ";
echo $LNG["fraudprotection"];
echo "\"\n    onclick=\"getCheckbox();SubmitForm ('#news','multipalaccount.fraudprotection','#frmsparam','#notification','true','#main_loader');\"/></td>\n</tr>\n\n<tr>\n<td class=\"fieldlabel\">Place order SMS Notification</td>\n<td class=\"fieldarea\">\n    <input type=\"radio\" name=\"ordersms\" value=\"1\" checked=\"checked\"\n    id=\"posms\"/>\n    <label for=\"posms\"> ";
echo $LNG["enable"];
echo " </label>\n    <input type=\"radio\" name=\"ordersms\" value=\"0\" id=\"pisms\"/>\n    <label for=\"pisms\">";
echo $LNG["disable"];
echo "</label>\n\n    <input type=\"button\" id=\"news\" name=\"news\"\n    value=\"";
echo $LNG["update"];
echo "\"\n    onclick=\"getCheckbox();SubmitForm ('#news','multipalaccount.smsorder','#frmsparam','#notification','true','#main_loader');\"/></td>\n</tr>\n\n\n<tr>\n<td class=\"fieldlabel\">\n";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "</td>\n<td class=\"fieldarea\">\n\n  <select name=\"profilemail\">\n    <option value=\"\">";
echo $LNG["select"];
echo "</option>\n ";
$d = dquery("select type from tbl_emailtemplates where type='general'\n  or type='other' or type='newsletter' group by type");
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
echo " </select>\n <input type=\"button\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\"\n id=\"btnpsail\"\n onclick=\"getCheckbox();SubmitForm ('#btnpsail','edituser.sendmultimail','#frmsparam','#notification','true','#main_loader');\" /></td>\n</tr>\n\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n<td   class=\"fieldlabel\">\n";
    echo $LNG["client"];
    echo " ";
    echo $LNG["group"];
    echo "</td>\n<td   class=\"fieldarea\">\n        <select name=\"clientgroup\">\n           <option value=\"0\">";
    echo $LNG["default"];
    echo "</option>\n           ";
    $sql = dquery("select * from tbl_client_group ");
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
    echo "        </select>\n <input type=\"button\" name=\"btnclientgr\" value=\"";
    echo $LNG["update"];
    echo " ";
    echo $LNG["client"];
    echo " ";
    echo $LNG["group"];
    echo "\"\n id=\"btnclientgr\"\n onclick=\"getCheckbox();SubmitForm ('#btnclientgr','multipalaccount.clientgroup','#frmsparam','#notification','true','#main_loader');\" />\n\n<br/>\n<span style=\"color: red;\">If you change group client discount reset for all services</span>\n\n</td>\n\n\n</tr>\n\n\n";
}
echo "\n<div class=\"clear\"></div>\n  <tr>\n                <td   class=\"fieldlabel\">";
echo $LNG["set"];
echo " ";
echo $LNG["master"];
echo " ";
echo $LNG["pin"];
echo "  </td>\n\n                <td   class=\"fieldarea\">\n                <input type=\"text\" name=\"setpin\"  id=\"setpin\" size=\"4\" value=\"\" />\n                <input type=\"checkbox\" name=\"sendmailpins\" id=\"sendmailpins\" value=\"1\"/>\n                <label for=\"sendmailpins\">";
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
echo "</label>\n                  <input type=\"button\" id=\"assign_pin2\"\n                 value=\"";
echo $LNG["set"];
echo " ";
echo $LNG["pin"];
echo "\" onclick=\"getCheckbox();\n                 SubmitForm ('#assign_pin2','multipalaccount.setpin','#frmsparam','#notification','true','#main_loader');\"/></td>\n            </tr>\n\n\n\n\n\n\n</table>\n\n\n</div>\n<script>\n function getMY(){\n  var selectedValues = [];\n    \$(\"#users :selected\").each(function(){\n        selectedValues.push(\$(this).val());\n    });\n    return selectedValues;\n}\n</script>\n<div class=\"floatright\">\n\n\n";
if (!$OnlyEcommerce) {
    $result = dquery("select id,service_name from tbl_services_imei where useasserver=0\norder by service_name asc");
    while ($rowi = mysqli_fetch_assoc($result)) {
        $imeiService[$rowi["id"]] = html_entity_decode($rowi["service_name"]);
    }
    $result = dquery("select id,service_name from tbl_services_file\norder by service_name asc");
    while ($rowf = mysqli_fetch_assoc($result)) {
        $fileService[$rowf["id"]] = html_entity_decode($rowf["service_name"]);
    }
    $result = dquery("select id,service_name from tbl_services_imei where useasserver=1\norder by service_name asc");
    while ($rows = mysqli_fetch_assoc($result)) {
        $serverService[$rows["id"]] = html_entity_decode($rows["service_name"]);
    }
    $result = dquery("select id,service_name from tbl_services_imei where useasserver=2\norder by service_name asc");
    while ($rows = mysqli_fetch_assoc($result)) {
        $remoteService[$rows["id"]] = html_entity_decode($rows["service_name"]);
    }
    $default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
    if (!$IsFileOnly) {
        echo "\n\n <fieldset style=\"padding: 10px;\">\n\t<legend>\n\n\t\t<select id=\"imei_service_id\" name=\"imei_service_id\"  style=\"width: 300px;\"\n        onchange=\"javascript: getPrices(this.value,'imei');\">\n\n            <option value=\"ALL\">All IMEI Service</option>\n         \t\t";
        foreach ($imeiService as $key => $value) {
            if ($imei == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
        echo "</select>\n       <!-- <input type=\"button\" class=\"addFromgallery\"\nid=\"imeiservice\" name=\"assign_imei\"\nvalue=\" \"\nonClick=\"getCheckbox();SubmitForm ('#imeiservice','multipalaccount.imeiassignservice','#frmsparam','#notification','true','#main_loader');\"/>\n-->\n   <!--     <input type=\"button\" class=\"addFromgallery\"\n               id=\"imeiservice2\" name=\"assign_imei\"\n               value=\" \"\n               onClick=\"getCheckbox();SubmitForm ('#imeiservice2','multipalaccount.imeiremoveservice','#frmsparam','#notification','true','#main_loader');\"/>\n-->\t</legend>\n<li class=\"li_code\">\n<!--<span></span>\n<span> </span>\n<span> </span></li>-->\n<div id=\"loadeimei\">\n";
        if ($imei) {
            $imeiprice = mysqli_fetch_assoc(dquery("select credit \n    from tbl_services_imei where id='" . $imei . "'"));
        }
        echo "<!--\n   <li class=\"li_code\"><span><input type=\"hidden\" name=\"imei_hidden_dis[]\" value=\"\"/></span><span></span>\n       <span><input type=\"text\" style=\"width: 40px;\" name=\"imei_discount[]\"/></span></li>\n        <li class=\"li_code\"><span><input type=\"hidden\" name=\"imei_hidden_dis[]\" value=\"\"/></span>\n   <span></span>\n   <span><input type=\"text\" style=\"width: 40px;\" name=\"imei_discount[]\"/></span></li>\n--></div>\n<p align=\"left\" class=\"clear\"> <br />\n<!--<input type=\"button\" id=\"imeidiscount\"  class=\"btn btn-primary\"\n value=\"     \" onclick=\"getCheckbox();SubmitForm ('#imeidiscount','multipalaccount.imeiresetdiscount','#frmsparam','#notification','true','#main_loader');\"/>\n-->\n <input type=\"button\" id=\"imeiresetdisc\"  class=\"btn btn-default\"\n value=\"";
        echo $LNG["reset"];
        echo " IMEI ";
        echo $LNG["discount"];
        echo "\"\n onclick=\"getCheckbox();SubmitForm ('#imeiresetdisc','multipalaccount.resetimeidiscount','#frmsparam','#notification','true','#main_loader');\"/>\n\n</p>\n</fieldset>\n<br />\n";
    }
    echo "<fieldset style=\"padding: 10px;\">\n\t<legend>\n\t\t<select id=\"file_service_id\" name=\"file_service_id\"\n        onchange=\"javascript: getPrices(this.value,'file');\">\n         <option value=\"ALL\">All File Service</option>\n      \t";
    foreach ($fileService as $key => $value) {
        if ($file == $key) {
            echo "<option value=" . $key . " selected>" . $value . "</option>";
        } else {
            echo "<option value=" . $key . ">" . $value . "</option>";
        }
    }
    echo "</select>\n        <!--\n        <input class=\"addFromgallery\" type=\"button\" id=\"fileservice\" name=\"assign_file\" value=\" \" onClick=\"getCheckbox();SubmitForm ('#fileservice','multipalaccount.fileassignservice','#frmsparam','#notification','true','#main_loader');\"/>\n        <input type=\"button\" class=\"addFromgallery\"\n               id=\"fileservice2\" name=\"assign_imei\"\n               value=\" \"\n               onClick=\"getCheckbox();SubmitForm ('#fileservice2','multipalaccount.fileremoveservice','#frmsparam','#notification','true','#main_loader');\"/>\n\n    </legend>-->\n<!--<li class=\"li_code\">\n<span></span>\n<span> </span>\n<span> </span></li>-->\n<!--<div id=\"loadefile\">\n        <li class=\"li_code\"><span><input type=\"hidden\" name=\"file_hidden_dis[]\" value=\"\"/></span><span></span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[]\"/></span></li>\n        <li class=\"li_code\"><span><input type=\"hidden\" name=\"file_hidden_dis[]\" value=\"\"/></span><span></span><span><input type=\"text\" style=\"width: 50px;\" name=\"file_discount[]\"/></span></li>\n</div>-->\n<p align=\"left\" class=\"clear\"> <br />\n\n\n<!--<input type=\"button\" id=\"filediscount\"  class=\"btn btn-primary\"\n value=\"     \" onclick=\"getCheckbox();SubmitForm ('#filediscount','multipalaccount.fileresetdiscount','#frmsparam','#notification','true','#main_loader');\"/>\n-->\n  <input type=\"button\" id=\"fileresetdisc\"  class=\"btn btn-default\"\n value=\"";
    echo $LNG["reset"];
    echo " ";
    echo $LNG["file"];
    echo " ";
    echo $LNG["discount"];
    echo "\"\n onclick=\"getCheckbox();SubmitForm ('#fileresetdisc','multipalaccount.resetfilediscount','#frmsparam','#notification','true','#main_loader');\"/>\n\n</p>\n</fieldset>\n\n<br />\n";
    if (!$IsFileOnly) {
        echo "\n<fieldset style=\"padding: 10px;\">\n\t<legend>\n\t\t<select id=\"server_service_id\" name=\"server_service_id\"\n        onchange=\"javascript: getPrices(this.value,'server');\" >\n      <option value=\"ALL\">All Server Service</option>\n      \t";
        foreach ($serverService as $key => $value) {
            if ($server == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
        echo "</select>\n\n\n    </legend>\n\n\n<div id=\"loadeserver\">\n\n</div>\n<p align=\"left\" class=\"clear\"> <br />\n\n\n<input type=\"button\" id=\"serverresetdisc\" class=\"btn btn-default\"\nvalue=\"";
        echo $LNG["reset"];
        echo " ";
        echo $LNG["server"];
        echo " ";
        echo $LNG["discount"];
        echo "\"\nonclick=\"getCheckbox();SubmitForm ('#serverresetdisc','multipalaccount.resetserverdiscount','#frmsparam','#notification','true','#main_loader');\"/>\n\n</p>\n</fieldset>\n\n\n\n    <fieldset style=\"padding: 10px;\">\n        <legend>\n            <select id=\"remote_service_id\" name=\"remote_service_id\"\n                    onchange=\"javascript: getPrices(this.value,'remote');\" >\n                <option value=\"ALL\">All Remote Service</option>\n                ";
        foreach ($remoteService as $key => $value) {
            if ($server == $key) {
                echo "<option value=" . $key . " selected>" . $value . "</option>";
            } else {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
        echo "</select>\n        </legend>\n        <p align=\"left\" class=\"clear\"> <br />\n<input type=\"button\" id=\"remoteresetdisc\" class=\"btn btn-default\"\nvalue=\"";
        echo $LNG["reset"];
        echo " ";
        echo $LNG["remote"];
        echo " ";
        echo $LNG["discount"];
        echo "\"\nonclick=\"getCheckbox();SubmitForm ('#remoteresetdisc','multipalaccount.resetremotediscount','#frmsparam','#notification','true','#main_loader');\"/>\n        </p>\n\n    </fieldset>\n\n\n\n    <fieldset style=\"padding: 10px;\">\n       Assing Services :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"assignservices[imei]\" value=\"imei\">IMEI </label>\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"assignservices[file]\" value=\"file\">File </label>\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"assignservices[server]\" value=\"server\">Server </label>\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"assignservices[remote]\" value=\"remote\">Remote </label>\n        <p align=\"left\" class=\"clear\"> <br />\n            <input type=\"button\" id=\"assingservice\" class=\"btn btn-default\"\n                   value=\"";
        echo $LNG["assign"];
        echo " ";
        echo $LNG["services"];
        echo "\"\n                   onclick=\"getCheckbox();SubmitForm ('#assingservice','multipalaccount.assignservices','#frmsparam','#notification','true','#main_loader');\"/>\n        </p>\n\n    </fieldset>\n";
    }
}
echo "    <fieldset style=\"padding: 10px;\">\n        <label>\n\n             <input type=\"checkbox\"\n\n                                      onclick=\"javascript: paymentGat(this);\" id=\"usecustomgateway\" name=\"usecustomgateway\" value=\"1\" />\n\n            Use Custom Payment Gateway </label>\n        <br/><br/>\n\n            <input type=\"button\" id=\"remoteresetdisc\" class=\"btn btn-default\"\n                   value=\"";
echo $LNG["save"];
echo " ";
echo $LNG["custom"];
echo " ";
echo $LNG["gateway"];
echo "\"\n                   onclick=\"getCheckbox();SubmitForm ('#remoteresetdisc','multipalaccount.customgateway','#frmsparam','#notification','true','#main_loader');\"/>\n        <br />\n        <div id=\"paymentgat\" style=\"display:none\">\n            <label>\n                <a href=\"javascript: checkAll();\">Check All</a>/<a href=\"javascript: uncheckAll();\">Uncheck All</a>\n            </label>\n            <br/><br/>\n            ";
$gq = dquery("select * from tbl_paymentgateways where setting='name'\n                group by gateway");
while ($rg = mysqli_fetch_assoc($gq)) {
    $selected = "";
    if (mysqli_num_rows(dquery("select  id from tbl_user_gateway \n                    where userid='" . $id . "' and payment='" . $rg["gateway"] . "'"))) {
        if ($rg["value"] == "PayPal") {
            echo "                <script>\n                    \$('#paypalacc').show();\n                </script>\n            ";
        }
        $selected = "checked='checked'";
    }
    echo "                <label style=\"display: block;\"><input class=\"gateways\"\n                        ";
    if ($rg["value"] == "PayPal") {
        echo "                            onclick=\"showPaypal(this)\"\n                            ";
    }
    echo "                                                      type=\"checkbox\" ";
    echo $selected;
    echo "                                                      name=\"gateway[";
    echo $rg["gateway"];
    echo "]\" style=\"vertical-align: middle;\" />";
    echo $rg["value"];
    echo "</label>\n                ";
}
echo "        </div>\n\n    </fieldset>\n\n<div style=\"text-align: center;margin-top:20px;\">\n\n <input class=\"button_remove\"  type=\"button\" name=\"removeotp\" id=\"removeotp\"\n onclick=\"getCheckbox();SubmitForm ('#removeotp','multipalaccount.otp','#frmsparam','#notification','true','#main_loader');\"\nvalue=\"";
echo $LNG["remove"];
echo " OTP\" />\n\n <input class=\"button_remove\"  type=\"button\" name=\"removeclient\" id=\"removeclient\"\n  onclick=\"\n  if(confirm('Are you sure want to remove User account ?')){\n   var vals=getMY();\n load_subpage('main2.php?page=closeaccount&uid='+vals,'Close Account');\n   }\"\nvalue=\"";
echo $LNG["remove"];
echo " ";
echo $LNG["client"];
echo "\" />\n\n</div>\n\n</div>\n\n\n</div>\n</div>\n</div>\n\n                    <input type=\"hidden\" name=\"user\" id=\"users\"/>\n                    \t</form>\n                </div>\n\n\n</div>\n\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Clients---Suppliers/?aid=29&pid=1&cid=5#update-multiple-account\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>