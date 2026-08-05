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
echo "<div id=\"tabcontent\">\n    <ul id=\"tabmenu\">\n        <li class=\"tabmenu-header\"><span>Submenu</span></li>\n        <li><a  onclick=\"getContect('#tab1','main2.php?page=apisetting.edit','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >Synchronize</a></li>\n        <li><a  class=\"tabmenu_active\" onclick=\"getContect('#tab3','main2.php?page=apisetting.status','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["status"];
echo "</a></li>\n        <li><a onclick=\"getContect('#tab4','main2.php?page=apisetting.quickadd','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["quick"];
echo " ";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["service"];
echo "</a></li>\n      <li><a onclick=\"getContect('#tab5','main2.php?page=apiautomation','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["pricing"];
echo " ";
echo $LNG["automation"];
echo "</a></li>\n    </ul>\n    <div  class=\"groupstabes\">\n        <div class=\"groupstabescontant\">\n            <style>\n                .glob {\n                    background-color: #ebebeb;\n                    border-radius: 50%;\n                    cursor: pointer;\n                    display: inline-block;\n                    font-size: 22px;\n                    height: 30px;\n                    line-height: 25px;\n                    text-align: center;\n                    vertical-align: middle;\n                    width: 30px;\n                }\n                .default_dg_table tr td, #main_tbl tr td{\n                    white-space:normal\n                }\n            </style>\n            <script>\n                function showConnected(ob)\n                {\n                    if(ob.checked){\n                        \$(\".ALLSERVICE\").hide();\n                        \$(\".SERVICE_1\").show();\n                    }else{\n                        \$(\".ALLSERVICE\").show();\n                    }\n                }\n                function disconnectAPI(serviceid)\n                {\n                    \$(\"#serviceid\").val(serviceid);\n                    SubmitForm ('#btnedituser','apisetting.disconnect','#frmdisconnect','#notification','true','#main_loader');\n                }\n                function increase(){\n                    var per=parseFloat(\$(\".incr\").val());\n\n                    if(per>0){\n\n                        \$('.price').each(function() {\n                            var tso=parseFloat(\$(this).val());\n                            var theClass = \$(this).attr(\"class\").match(/get_[\\w-]*\\b/).toString();\n                            cid=theClass.split(\"_\");\n                            if(tso>0){\n                                var iso=(tso*per)/100;\n                                \$('.apply_'+cid[1]).val((tso+iso).toFixed(2));\n                            }\n                        });\n                    }\n                }\n                function decrease(){\n                    var per=parseFloat(\$(\".incr\").val());\n                    if(per>0){\n                        \$('.price').each(function() {\n                            var tso=parseFloat(\$(this).val());\n                            var theClass = \$(this).attr(\"class\").match(/get_[\\w-]*\\b/).toString();\n                            cid=theClass.split(\"_\");\n                            if(tso>0){\n                                var iso=(tso*per)/100;\n                                \$('.apply_'+cid[1]).val((tso-iso).toFixed(2));\n                            }\n                        });\n                    }\n                }\n            </script>\n            ";
$apc = mysqli_fetch_assoc(dquery("select value from \ntbl_apiservers where gateway='" . $id . "' and setting='currency'"));
$autos = mysqli_num_rows(dquery("select id from tbl_services_imei where autoapi=1\nand API='" . $id . "'"));
echo "            <form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n                <div id=\"notification\"></div>\n                <label><input type=\"checkbox\" name=\"show\" value=\"1\"\n                              onclick=\"javascript: showConnected(this);\"/>Show Only Connected Services</label>\n                <table id=\"main_tbl\"  >\n                    <thead>\n                    <tr>\n                        <th style=\"width:50%;word-wrap: break-all;\" >API ";
echo $LNG["service"];
echo " ";
echo $LNG["name"];
echo "</th>\n                        <th>API <br /><strong>";
echo $apc["value"];
echo "</strong></th>\n                       <!-- <th style=\"text-align: center;\">";
echo $LNG["price"];
echo " <br />\n                            <div style=\"width: 120px;\"> <span class=\"glob\" style=\"float: left;margin-right:10px\" onclick=\"javascript:increase();\">+</span>\n                                <input  style=\"width:30px !important; float: left;text-align:center;margin-right:10px\" type=\"text\" ";
if ($autos) {
    echo "readonly";
}
echo "                                        name=\"perc\" class=\"incr\" value=\"0\"  />\n                                <span  class=\"glob\" style=\"float: left;\" onclick=\"javascript:decrease();\">-</span>\n                            </div>   </th>-->\n                        <th style=\"width: auto !important; word-wrap: break-word;\">";
echo $LNG["service"];
echo " Connected ";
echo $LNG["to"];
echo "</th>\n                        <th style=\"width: auto !important;\">";
echo $LNG["action"];
echo "</th>\n                    </tr>\n                    </thead>\n                    <tbody>\n                    ";
$q = dquery("select * from tbl_apiserversservices \nwhere (gateway='" . $id . "' ) and type='Group'");
while ($r = mysqli_fetch_assoc($q)) {
    echo "                        <tr class=\"ALLSERVICE\">\n                            <th colspan=\"4\">\n\n                                <strong>";
    echo $r["name"];
    echo "</strong>\n\n                                <strong> - ";
    if ($r["useasserver"]) {
        echo "                                        Server\n                                        ";
    } else {
        echo "                                        IMEI\n                                        ";
    }
    echo "</strong>\n\n\n                            </th>\n                            <th></th>\n                        </tr>\n                        ";
    $s = dquery("select * from tbl_apiserversservices where\n    (\n   \n       `group`='" . str_replace("\\\"", "\\\"", html_entity_decode($r["id"])) . "'\n         or `group`='" . $r["id"] . "'\n           or `group`='" . str_replace("\\\"", "\\\"", html_entity_decode($r[name])) . "'\n         or guiid=" . $r[apiserverid] . "\n\n    ) and gateway='" . $id . "' and\n    type='Tool' and servicetype!='file'");
    while ($rs = mysqli_fetch_assoc($s)) {
        $sc = dquery("select id,service_name,credit,autoapi from tbl_services_imei\n          where API_ID='" . $rs["id"] . "' and API='" . $rs["gateway"] . "'");
        if (mysqli_num_rows($sc)) {
            while ($scredit = mysqli_fetch_assoc($sc)) {
                if ($scredit["credit"] < $rs["credits"]) {
                    $class = "textred";
                } else {
                    $class = "";
                }
                echo "                                    <tr  class=\"ALLSERVICE SERVICE_";
                echo $scredit["service_name"] ? "1" : "0";
                echo "\">\n                                        <td class=\"textorange\" >";
                echo $rs["name"];
                echo "</td>\n                                        <td>";
                echo $rs["credits"];
                echo "<input type=\"hidden\" name=\"price";
                echo $rs["id"];
                echo "\"\n                                                                      value=\"";
                echo $scredit["credit"];
                echo "\" class=\"price get_";
                echo $rs["id"];
                echo "\"\n                                            /></td>\n                                       <!-- <td><input  type=\"text\" size=\"8\" class=\" apply_\"\n                                                    name=\"service[]\"                                                     value=\"\" /></td>-->\n                                        <td>";
                echo $scredit["service_name"] ? $scredit["service_name"] : "Service Not Connected";
                echo "</td>\n                                        <td>\n                                            <input value=\"";
                echo $LNG["disconnectapi"];
                echo "\"\n                                                   name=\"disconnect\" class=\"button_remove\" type=\"button\"\n                                                   onclick=\"disconnectAPI('";
                echo $scredit["id"];
                echo "');\"/>\n                                        </td>\n                                    </tr>\n                                    ";
            }
        } else {
            echo "                                <tr  class=\"ALLSERVICE SERVICE_";
            echo $scredit["service_name"] ? "1" : "0";
            echo "\">\n                                    <td >";
            echo $rs["name"];
            echo "</td>\n<!--                                    <td>--><!--<input type=\"hidden\" name=\"price--><!--\"-->\n<!--                                                                  value=\"--><!--\" class=\"price get_--><!--\" /></td>-->\n                                    <td></td>\n                                    <td style=\"white-space: nowrap;\">Service Not Connected</td>\n                                    <td></td>\n                                </tr>\n                                ";
        }
    }
}
echo "                    </tbody>\n                </table>\n               <!-- <p class=\"fixedbtn\">\n    <span ><input value=\"\" id=\"btnedituser\" class=\"button_save\" type=\"button\"\n                  onclick=\"SubmitForm ('#btnedituser','apisetting.status','#frmedituser','#notification','true','#main_loader');\"/></span>\n                </p>-->\n            </form>\n        </div></div> </div>\n    <form method=\"post\" id=\"frmdisconnect\">\n        <input type=\"hidden\"  name=\"serviceid\" id=\"serviceid\" value=\"\" />\n\n    </form>\n";
$fileverioncheck = "6.1.0";

?>