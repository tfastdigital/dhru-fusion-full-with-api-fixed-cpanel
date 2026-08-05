<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 289;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
if ($stype == "remote") {
    $whereserv = " server=2";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " server=1";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " server=0";
        $commonwhere = " and useasserver=0";
    }
}
$sql = dquery("SELECT  service_id,colortag,service_name,API,API_ID,ebay\nFROM `tbl_order_imei` \nLEFT OUTER JOIN tbl_services_imei ON\n`tbl_order_imei`.service_id = tbl_services_imei.id \nWHERE user_can_c =0  AND " . $whereserv . "\ngroup by service_id\nORDER BY order_id DESC");
echo "    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n<div id=\"content\"> \n<div id=\"content_padded\">\n <h2>    \n    <span class=\"groupstabesheadertext\">Service wise accept</span>\n </h2>\n<br />\n<div id=\"notification\"></div>\n<script>\nfunction setCookies(val){\n  var c_name='AdmAuto';\n  var value=val;\n  var exdays=365;\n   if(val){\n        var exdate=new Date();\n        exdate.setDate(exdate.getDate() + exdays);\n        var c_value=escape(value) + ((exdays==null) ? \"\" : \"; expires=\"+exdate.toUTCString());\n        document.cookie=c_name + \"=\" + c_value;\n    }else{\n        var exdays=-1;\n        var exdate=new Date();\n        exdate.setDate(exdate.getDate() + exdays);\n        var c_value=escape(value) + ((exdays==null) ? \"\" : \"; expires=\"+exdate.toUTCString());\n        document.cookie=c_name + \"=\" + c_value;\n    }\n}\nfunction getCookie(c_name) {\n    var i,x,y,ARRcookies=document.cookie.split(\";\");\n    for (i=0;i<ARRcookies.length;i++)\n    {\n      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf(\"=\"));\n      y=ARRcookies[i].substr(ARRcookies[i].indexOf(\"=\")+1);\n      x=x.replace(/^\\s+|\\s+\$/g,\"\");\n      if (x==c_name)\n      {\n        return unescape(y);\n      }\n    }\n} \n\$(document).ready(function() {\n    var co=getCookie(\"AdmAuto\");\n    \$(\"#autorefresh\").val( co ).attr('selected',true);\n    if(co){\n        setTimeout(function() { \n           redirectedit(\"imeiorder&laoddefaultpage=imeiorder.new.php\");\n        }, 60000*co);\n    }\n});\n</script>\n<form id=\"newimeiorder\" name=\"\" method=\"post\">     \n<table id='main_tbl'>\n<thead>\n  <tr>\n    <th>";
echo $LNG["service"];
echo "</th>\n    <th>";
echo $LNG["apicon"];
echo "</th>\n    <th>";
echo $LNG["count"];
echo "</th>\n    <th align='right'>";
echo $LNG["action"];
echo "</th>\n  </tr>\n</thead>\n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<td><div class=\"boxes\" style=\"background-color: ";
    echo $row["colortag"];
    echo "\"></div>\n    ";
    $cnts = mysqli_num_rows(dquery("select order_id from tbl_order_imei\nwhere service_id='" . $row["service_id"] . "' and apierror!=''"));
    if ($cnts) {
        echo "<span style='color:orange'> <i class='fa fa-warning'></i></span>   ";
    }
    echo "    ";
    echo $row["service_name"];
    echo "</td>\n<td align=\"left\">";
    if ($row["API_ID"]) {
        $s = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n        where gateway='" . $row["API"] . "' and setting='name'"));
        $s3 = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n        where gateway='" . $row["API"] . "' and setting='customname'"));
        echo $s3["value"] ? $s3["value"] : $s["value"];
    } else {
        echo "NA";
    }
    echo "</td>\n<td align=\"left\">\n";
    echo mysqli_num_rows(dquery("SELECT order_id\nFROM `tbl_order_imei` WHERE user_can_c =0  and service_id='" . $row["service_id"] . "'"));
    echo "</td>\n<td align=\"right\"> \n";
    if ($row["API"]) {
        echo "<a class=\"\" onclick=\"if(confirm('This service is now connected to API. Do you want to Continue')) \n{ getContect('#tab','main2.php?page=viewimeiorder.new&stype=";
        echo $stype;
        echo "','";
        echo $row["service_id"];
        echo "','','#tabcontent',true,'#main_loader'); }\"  >";
        echo $LNG["vieworder"];
        echo "</a> \n";
    } else {
        echo "<a class=\"\" onclick=\"getContect('#tab','main2.php?page=viewimeiorder.new&stype=";
        echo $stype;
        echo "','";
        echo $row["service_id"];
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["vieworder"];
        echo "</a>   \n";
    }
    echo "</td> \n</tr>\n";
}
echo "    \n</table><br/>\n\n</form></div></div>\n \n<div class=\"fixedbtn\">\nAuto Refresh: \n<select name=\"autorefresh\" id=\"autorefresh\"\n         onchange=\"javascript: setCookies(this.value);\">\n    <option value=\"\">Disabled</option>\n    <option value=\"5\">5 Miniute</option>\n    <option value=\"10\">10 Miniute</option>\n    <option value=\"30\">30 Miniute</option>\n    <option value=\"60\">1 Hour</option>\n</select>\n</div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Orders/?aid=31&pid=1&cid=5#quick-accept\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div>";
}
$fileverioncheck = "6.1.0";

?>