<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "\r\n<div id=\"tabcontent\">\r\n\r\n    <ul id=\"tabmenu\">\r\n        <li class=\"tabmenu-header\"><span>Submenu</span></li>\r\n        <li><a  onclick=\"getContect('#tab1','main2.php?page=apisetting.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Synchronize</a></li>\r\n        <li><a  class=\"tabmenu_active\" onclick=\"getContect('#tab3','main2.php?page=apisetting.status','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["status"];
echo "</a></li>\r\n        <li><a onclick=\"getContect('#tab4','main2.php?page=apisetting.quickadd','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["service"];
echo "</a></li>\r\n        <li><a onclick=\"getContect('#tab5','main2.php?page=apiautomation','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["pricing"];
echo " ";
echo $LNG["automation"];
echo "</a></li>\r\n    </ul>\r\n\r\n    <div  class=\"groupstabes\">\r\n\r\n        <div class=\"groupstabescontant\">\r\n            <style>\r\n                DIV.table\r\n                {\r\n                    display:table;\r\n                }\r\n                FORM.tr, DIV.tr\r\n                {\r\n                    display:table-row;\r\n                }\r\n                SPAN.td\r\n                {\r\n                    display:table-cell;\r\n                    padding:5px;\r\n                }\r\n                .c1{\r\n                    width:100px;\r\n                    white-space:nowrap;\r\n                }\r\n                .c2{\r\n\r\n                }\r\n                .c3{\r\n                    width:100px;\r\n                    white-space:nowrap;\r\n                }\r\n                .c4{\r\n                    width:200px;\r\n                    white-space:nowrap;\r\n                }\r\n            </style>\r\n            <style>\r\n                .glob {\r\n                    background-color: #ebebeb;\r\n                    border-radius: 50%;\r\n                    cursor: pointer;\r\n                    display: inline-block;\r\n                    font-size: 22px;\r\n                    height: 30px;\r\n                    line-height: 25px;\r\n                    text-align: center;\r\n                    vertical-align: middle;\r\n                    width: 30px;\r\n                }\r\n            </style>\r\n\r\n            <script>\r\n                \$(document).ready(function(){\r\n                    \$("#quickSearch").on("keyup", function() {\r\n                        var value = \$(this).val().toLowerCase();\r\n                        \$(".groupstabescontant .tr").filter(function() {\r\n                            if(\$(this).find(".c2 strong").length > 0) {\r\n                                \$(this).toggle(\$(this).text().toLowerCase().indexOf(value) > -1);\r\n                            }\r\n                        });\r\n                    });\r\n                });\r\n\r\n                function increase(){\r\n                    var per=parseFloat(\$(\".incr\").val());\r\n                    if(per>0){\r\n                        \$('.price').each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            var theClass = \$(this).attr(\"class\").match(/get_[\\w-]*\\b/).toString();\r\n                            cid=theClass.split(\"_\");\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$('.apply_'+cid[1]).val((tso+iso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n                function decrease(){\r\n                    var per=parseFloat(\$(\".incr\").val());\r\n                    if(per>0){\r\n                        \$('.price').each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            var theClass = \$(this).attr(\"class\").match(/get_[\\w-]*\\b/).toString();\r\n                            cid=theClass.split(\"_\");\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$('.apply_'+cid[1]).val((tso-iso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n            </script>\r\n            ";
$apc = mysqli_fetch_assoc(dquery("select value from \r\n    tbl_apiservers where gateway='" . $id . "' and setting='currency'"));
echo "\r\n            <div id=\"notification\"></div>\r\n            <label><input type=\"checkbox\" name=\"assign[base]\" value=\"1\" />";
echo $LNG["assign"];
echo " ";
echo $LNG["to"];
echo " base</label>\r\n            &nbsp;&nbsp;&nbsp;\r\n            <label><input type=\"checkbox\" name=\"assign[retail]\" value=\"1\" />";
echo $LNG["assign"];
echo " ";
echo $LNG["to"];
echo " retail</label>\r\n            &nbsp;&nbsp;\r\n            ";
$qds = dquery("select id,groupname from tbl_client_group");
while ($rd = mysqli_fetch_assoc($qds)) {
    echo "                <label><input type=\"checkbox\" name=\"assign[";
    echo $rd["id"];
    echo "]\" value=\"1\"/>";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["to"];
    echo "                    ";
    echo $rd["groupname"];
    echo "</label>&nbsp;&nbsp;\r\n                ";
}
echo "\r\n\r\n\r\n            <div class=\"table\">\r\n\r\n\r\n\r\n                <div class=\"tr\">\r\n                    <span class=\"td c1\"></span>\r\n                    <span class=\"td c2\">API ";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</span>\r\n                    <span class=\"td c3\">API <br /><strong>";
echo $apc["value"];
echo "</strong></span>\r\n                    <span class=\"td c4\">";
echo $LNG["group"];
echo "</strong></span>\r\n                </div>\r\n                ";
$gq = dquery("select * from tbl_imei_group where active=1 and server=0");
while ($rq = mysqli_fetch_assoc($gq)) {
    $GROUPARR[] = $rq;
}
$gq = dquery("select * from tbl_imei_group where active=1 and server=1");
while ($rq = mysqli_fetch_assoc($gq)) {
    $GROUPARRSERVER[] = $rq;
}
$gq = dquery("select * from tbl_imei_group where active=1 and server=2");
while ($rq = mysqli_fetch_assoc($gq)) {
    $GROUPARREMOTE[] = $rq;
}
$q = dquery("select * from tbl_apiserversservices \r\nwhere gateway='" . $id . "' and `type`='Group'");
while ($r = mysqli_fetch_assoc($q)) {
    echo "                    <div class=\"tr\">\r\n                        <span class=\"td c1\"></span>\r\n                        <span class=\"td c2\"><strong>";
    echo $r["name"];
    echo "</strong> <strong> - ";
    if ($r["useasserver"] == 2) {
        echo "                                    Remote\r\n                                    ";
    } else {
        if ($r["useasserver"] == 1) {
            echo "                                        Server\r\n                                        ";
        } else {
            echo "                                        IMEI <br />\r\n\r\n                                        ";
        }
    }
    echo "</strong> </span>\r\n                        <span class=\"td c3\"></span>\r\n                        <span class=\"td c4\"></span>\r\n                    </div>\r\n\r\n                    ";
    $s = dquery("select *,(select service_name from tbl_services_imei    where API=tbl_apiserversservices.gateway    and API_ID=tbl_apiserversservices.id limit 1) as services from tbl_apiserversservices where    (`group`='" . $r["id"] . "' or SUBSTRING(`group`,1,100)='" . $r["id"] . "' ) and gateway='" . $id . "' and type='Tool' and servicetype!='file' ");
    while ($rs = mysqli_fetch_assoc($s)) {
        echo "\r\n\r\n                        <form class=\"tr\" id=\"frmedituser";
        echo $rs["id"];
        echo "\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                            <input type=\"hidden\" name=\"gateway\" value=\"";
        echo $id;
        echo "\" />\r\n                            <input type=\"hidden\" name=\"k\" value=\"";
        echo $rs["id"] . "_" . $rs["type_id"];
        echo "\" />\r\n                            <input type=\"hidden\" name=\"midd\" value=\"";
        echo $rs["id"] . "_" . $rs["type_id"];
        echo "\" />\r\n\r\n                            <span class=\"td c1\"> <input type=\"button\" class=\"btn\" id=\"btnedituser";
        echo $rs["id"];
        echo "\" value=\"Add\" name=\"add\"\r\n                                                        onclick=\"SubmitForm ('#btnedituser";
        echo $rs["id"];
        echo "','apisetting.quickadd','#frmedituser";
        echo $rs["id"];
        echo "','#notification','true','#main_loader');\"/>\r\n                </span>\r\n                            <span class=\"td c2\">\r\n                    <input type=\"text\"  style=\"width: 90%;padding: 7px !important;font-size: 16px\" name=\"service[";
        echo $rs["id"] . "_" . $rs["type_id"];
        echo "]\" value=\"";
        echo $rs["name"];
        echo "\" />\r\n              <br />\r\n              <small style=\"font-size: 11px !important;color: #ccc;\">\r\n              ";
        echo $rs["services"];
        echo "              </small>\r\n            </span>\r\n                            <span class=\"td c3\">\r\n                    <input type=\"text\" name=\"credit[";
        echo $rs["id"] . "_" . $rs["type_id"];
        echo "]\" style=\"width: 90%;padding: 7px !important;font-size: 16px\" size=\"5\" value=\"";
        echo $rs["credits"];
        echo "\" />\r\n                    <input type=\"hidden\" name=\"price";
        echo $rs["id"];
        echo "\" value=\"";
        echo $rs["credits"];
        echo "\"  class=\"price get_";
        echo $rs["id"];
        echo "\" />\r\n                </span>\r\n                            <span class=\"td c4\">\r\n                    <select name=\"groups[";
        echo $rs["id"] . "_" . $rs["type_id"];
        echo "]\">\r\n";
        if ($rs["useasserver"] == 2) {
            foreach ($GROUPARREMOTE as $g) {
                echo "        <option value=\"";
                echo $g["id"];
                echo "\">";
                echo $g["group_name"];
                echo "</option>\r\n        ";
            }
        } else {
            if ($rs["useasserver"] == 1) {
                foreach ($GROUPARRSERVER as $g) {
                    echo "            <option value=\"";
                    echo $g["id"];
                    echo "\">";
                    echo $g["group_name"];
                    echo "</option>\r\n            ";
                }
            } else {
                foreach ($GROUPARR as $g) {
                    echo "            <option value=\"";
                    echo $g["id"];
                    echo "\">";
                    echo $g["group_name"];
                    echo "</option>\r\n            ";
                }
            }
        }
        echo "        </select>\r\n\r\n                </span>\r\n                        </form>\r\n\r\n                        ";
    }
}
echo "            </div>\r\n\r\n\r\n        </div></div> </div>\r\n<form method=\"post\" id=\"frmdisconnect\">\r\n    <input type=\"hidden\"  name=\"serviceid\" id=\"serviceid\" value=\"\" />\r\n\r\n</form>\r\n";
$fileverioncheck = "6.1.0";

?>