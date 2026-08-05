<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 172;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
dquery("CREATE TABLE IF NOT EXISTS `tbl_services_imei_api` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `sid` int(11) NOT NULL,  `api_server` varchar(150) NOT NULL,  `api_server_id` varchar(50) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
if ($remove) {
    dquery("delete from tbl_services_imei_api where id='" . $remove . "'");
}
if ($resync) {
    $api = dquery("select distinct(api_server) as api_server\n    from tbl_services_imei_api where sid='" . $id . "'");
    while ($rapi = mysqli_fetch_assoc($api)) {
        $gateway = $rapi["api_server"];
        if ($gateway != "" && mysqli_num_rows(dquery("select * from tbl_apiservers\n            where gateway='" . $gateway . "' and setting='username'"))) {
            $apisaveddetails = loadApiModule($gateway, false);
            require_once ROOTDIR . "/modules/apiserver/" . $gateway . ".php";
            syncApi($gateway, false, "services", "");
        }
    }
    echo "    <div id=\"notification1\" class=\"successbox\">\n    Synchronize Success</div>\n    ";
}
if ($upapi) {
    $ad = mysqli_fetch_assoc(dquery("select * from tbl_services_imei_api\n    where id='" . $upapi . "'"));
    dquery("update tbl_services_imei set API='" . $ad["api_server"] . "',API_TYPEID='" . $ad["api_server_typeid"] . "'\n    where id=" . $id);
    dquery("update tbl_services_imei set  API_ID='" . $ad["api_server_id"] . "' where id=" . $id);
}
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,rejectqnt,verifyforreject,service_name,apiserverid,apilower,API_TYPEID,useasserver,manualverification,\n  API_ID,key_selling FROM tbl_services_imei WHERE id='" . $id . "' "));
echo "<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function(){\n    var selectedCountry = \$(\".apiservs option:selected\").val();\n    getCreditofAPI(selectedCountry);\n    \$(\"select.apiservs\").change(function(){\n        var selectedCountry = \$(\".apiservs option:selected\").val();\n        getCreditofAPI(selectedCountry);\n    });\n    \$( \"#apiservers\" ).change(function() {\n        SubmitForm ('#btnapiconnection','editimeiservice.apiconnection','#frmapi','#notification','true','#main_loader');\n        setTimeout(function() {\n            getContect('#tab3', 'main2.php?page=editimeiservice.apiconnection', '";
echo $id;
echo "', '', '#tabcontent', true, '#main_loader');\n        },300);\n    });\n});\nfunction reloading(){\n    setTimeout(function() {\n        getContect('#tab3', 'main2.php?page=editimeiservice.apiconnection', '";
echo $id;
echo "', '', '#tabcontent', true, '#main_loader');\n    },500);\n}\nfunction getCreditofAPI(apiid)\n{\n    \$.post(\"includes/pages/getcredit.php?apiid=\"+apiid, function(data, status){\n       var curval=\$(\"#apilower\").val();\n       if(!curval)\n       {\n            \$(\"#apilower\").val(data);\n       }\n    });\n}\nfunction loadCustom(ids,serviceid){\n    \$.post(\"includes/pages/getcustomapi.php?apidet=\"+ids+\"&serviceid=\"+serviceid+\"&gateway=\"+\$('#apiservers').val(), function(data, status){\n        \$(\".customdisp\").html(data);\n    });\n}\n";
if ($serviceDetails["API_ID"]) {
    echo "    loadCustom('";
    echo $serviceDetails["API_ID"];
    echo "_";
    echo $serviceDetails["API_TYPEID"];
    echo "', '";
    echo $id;
    echo "');\n";
}
echo "</script>\n<div id=\"notification\"></div>\n    <form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n        <h3><strong>";
echo $serviceDetails["service_name"];
echo "</strong></h3>\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n    <div  class=\"groupstabes first\" >\n    <h2>\n    <span class=\"groupstabesheadertext\">API Connection (Primary)</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n    <input type=\"hidden\" name=\"defaultapi\" value=\"";
echo $serviceDetails["API"];
echo "\" />\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["connect"];
echo " ";
echo $LNG["api"];
echo "</td>\n    <td class=\"fieldarea\">";
echo apiServerDropdown($serviceDetails["API"], "API", "", $serviceDetails["useasserver"]);
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["services"];
echo "</td>\n    ";
$script = "onchange='loadCustom(this.value," . $id . ");'";
echo "    <td class=\"fieldarea\"><div id=\"apiservicedropdown\" style=\"display: none;\"></div><span id=\"onloadapiservicedropdown\">";
echo apiServicesDropdown($serviceDetails["API"], $serviceDetails["API_ID"], "API_ID", "", $serviceDetails["useasserver"], $serviceDetails["API_TYPEID"], $script);
echo "</span>\n        <div class=\"customdisp\"></div>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" name=\"manualverification\"\n            ";
if ($serviceDetails["manualverification"]) {
    echo "checked='checked'";
}
echo " value=\"1\" id=\"manv\" />\n        <label for=\"manv\">Manually verify before send to supplier</label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        <input type=\"checkbox\" name=\"verifyforreject\"\n            ";
if ($serviceDetails["verifyforreject"]) {
    echo "checked='checked'";
}
echo " value=\"1\" id=\"manvr\" />\n        <label for=\"manvr\">Manually verify rejected orders before send to Users</label>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["auto"];
echo " ";
echo $LNG["reply"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n     <select name=\"key_selling\" class=\"chosen\">\n                <option value=\"\">";
echo $LNG["none"];
echo "</option>\n            ";
$sql = dquery("select * from tbl_keygroup order by `group` asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                <option value=\"";
    echo $row["id"];
    echo "\" ";
    if ($row["id"] == $serviceDetails["key_selling"]) {
        echo "selected";
    }
    echo ">";
    echo $row["group"];
    echo "</option>\n                ";
}
echo "      </select>\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n        <label><input type=\"checkbox\" name=\"rejectqnt\" ";
if ($serviceDetails["rejectqnt"]) {
    echo "checked";
}
echo " value=\"1\" />Reject order if Qnt finished </label>\n    </td>\n</tr>\n\n\n</tbody>\n</table>\n\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnapiconnection\"\n    class=\"button_save\" type=\"button\"\n    onclick=\"SubmitForm ('#btnapiconnection','editimeiservice.apiconnection','#frmapi','#notification','true','#main_loader');reloading();\"/>\n    <input type=\"button\" style=\"float:right;\"   onclick=\"SubmitForm ('#btns','editimeiservice.apiconnectionresync','#frmapi','#notification','true','#main_loader','main2.php?page=editimeiservice.apiconnection','";
echo $id;
echo "');        \" value=\"Synchronize Price with API Server\" />\n</p>\n\n\n<script>\n\$(document).ready(function() {\n    \$('#apitable').tableDnD({\n        onDrop: function(table, row) {\n           var serialized= \$.tableDnD.serialize();\n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/imeiapi.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t\t \$(\"#notification\").addClass('successbox');\n    \t\t\t     \$(\"#notification\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\n</script>\n</div>\n</div>\n\n\n\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Secondary API Connections ( If primary API reject order )\n    </span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n\n\n\n    <input type=\"hidden\" name=\"defaultapi\" value=\"";
echo $serviceDetails["API"];
echo "\" />\n\n      <div id=\"main_tbl\">\n\n    <table id=\"apitable\" style=\"width: 100%\" class=\"sortable form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" >\n\n        </thead>\n<tbody style=\"width:100%\">\n";
$api = dquery("select * from tbl_services_imei_api where sid='" . $id . "'\n\n and auto=1 order by sort asc");
$last = "";
while ($rapi = mysqli_fetch_assoc($api)) {
    $apiname = mysqli_fetch_assoc(dquery("select value from \n    tbl_apiservers where gateway='" . $rapi["api_server"] . "' and setting='name'"));
    $apiserv = mysqli_fetch_assoc(dquery("select `name`,credits from \n    tbl_apiserversservices where id='" . $rapi["api_server_id"] . "' \n    and gateway='" . $rapi["api_server"] . "'\n     and type_id='" . $rapi["api_server_typeid"] . "' and useasserver='" . $serviceDetails["useasserver"] . "'"));
    $CustomName = "";
    if ($CustomName = mysqli_fetch_assoc(dquery("select * from\n        `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \n        AND setting='customname'"))) {
        $CustomName = " (" . $CustomName["value"] . ")";
    }
    $Currency = mysqli_fetch_assoc(dquery("select * from\n    `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \n    AND setting='currency'"));
    if (trim($apiname["value"])) {
        echo "<tr id=\"";
        echo $rapi["id"];
        echo "\">\n\n    <td style=\"padding: 0 10px;\">&#10606;</td>\n\n    <td>";
        echo $apiname["value"];
        echo " ";
        echo $CustomName;
        echo "        ";
        echo $apiserv["name"];
        echo " <strong>(";
        echo $apiserv["credits"];
        echo " ";
        echo $Currency["value"];
        echo ")</strong></td>\n    <td></td>\n\n    <td style=\"text-align: right;\">\n  Auto connect if ";
        echo $last ? $last : "Primary";
        echo " failed\n\n    </td>\n</tr>\n";
        $last = $apiname["value"];
    }
}
echo "</tbody>\n</table>\n\n      </div>\n\n<li>Drag and Drop to change APi auto connect order</li>\n\n      <h2>\n          <span class=\"groupstabesheadertext\">Connection History</span></h2>\n          <input type=\"hidden\" name=\"defaultapi\" value=\"";
echo $serviceDetails["API"];
echo "\" />\n\n      <div id=\"main_tbl\">\n\n          <table id=\"apitable\" style=\"width: 100%\" class=\" form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" >\n            <thead>\n            <tr>\n                <th style=\"text-align: left;\">Secondary</th>\n                <th style=\"text-align: left;\">Server</th>\n                <th style=\"text-align: left;\">API service</th>\n                <th></th>\n            </tr>\n              </thead>\n              <tbody style=\"width:100%\">\n              ";
$api = dquery("select * from tbl_services_imei_api where sid='" . $id . "'\n order by sort asc");
while ($rapi = mysqli_fetch_assoc($api)) {
    $apiname = mysqli_fetch_assoc(dquery("select value from \n    tbl_apiservers where gateway='" . $rapi["api_server"] . "' and setting='name'"));
    $apiserv = mysqli_fetch_assoc(dquery("select id,`name`,credits from \n    tbl_apiserversservices where gateway='" . $rapi["api_server"] . "'\n    and id='" . $rapi["api_server_id"] . "' and type_id='" . $rapi["api_server_typeid"] . "' and useasserver='" . $serviceDetails["useasserver"] . "'"));
    $CustomName = "";
    if ($CustomName = mysqli_fetch_assoc(dquery("select * from\n        `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \n        AND setting='customname'"))) {
        $CustomName = " (" . $CustomName["value"] . ")";
    }
    $Currency = mysqli_fetch_assoc(dquery("select * from\n    `tbl_apiservers` WHERE `gateway`='" . $rapi["api_server"] . "' \n    AND setting='currency'"));
    if (trim($apiname["value"]) && trim($apiserv["name"])) {
        echo "                      <tr id=\"";
        echo $rapi["id"];
        echo "\">\n\n                          <td>\n                              <label><input type=\"checkbox\"\n                                      ";
        if ($rapi["auto"]) {
            echo "checked";
        }
        echo " value=\"";
        echo $rapi["id"];
        echo "\"\n                                            name=\"auto[";
        echo $rapi["id"];
        echo "]\" /></label>\n                          </td>\n                          <td>";
        echo $apiname["value"];
        echo " ";
        echo $CustomName;
        echo "</td>\n                          <td>";
        echo $apiserv["name"];
        echo " (";
        echo $apiserv["credits"];
        echo " ";
        echo $Currency["value"];
        echo ")</td>\n\n\n                          <td style=\"text-align: right;\">\n\n<a onclick=\"getContect('#tab3','main2.php?page=editimeiservice.apiconnection&upapi=";
        echo $rapi["id"];
        echo "','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\">\n    ";
        if ($serviceDetails["API_ID"] == $apiserv["id"]) {
            echo "        Connected To Primary\n        ";
        } else {
            echo "        Connect to Primary\n        ";
        }
        echo "        </a>\n\n<a onclick=\"return confirm('Are you sure want to remove?');\"  href=\"javascript:reloadcurrent('editimeiservice','";
        echo $id;
        echo "&defaultloadpage=editimeiservice.apiconnection.php&remove=";
        echo $rapi["id"];
        echo "')\"\nclass=\"deletedata\">";
        echo $LNG["delete"];
        echo "</a>\n                          </td>\n                      </tr>\n                      ";
    }
}
echo "              </tbody>\n          </table>\n\n      </div>\n</div>\n</div>\n\n\n</div>\n</div>\n    </form>\n\n";
$fileverioncheck = "6.1.0";
echo "<script>\n    \$( document ).ready(function() {\n        \$(\".colorpicker\").hide();\n    });\n\n</script>\n";

?>