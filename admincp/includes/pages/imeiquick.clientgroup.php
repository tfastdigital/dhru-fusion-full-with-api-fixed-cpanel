<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 365;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$admin_template = $config["admin_template"];
if ($server) {
    $wherecond = " where `server`=1";
} else {
    $wherecond = " where `server`=0";
}
echo "<style>\r\n    .convertedcurrency{\r\n        color: #7c6866;\r\n        font-size: 14px;\r\n    }\r\n    .rowdisabled input{\r\n\r\n    }\r\n\r\n</style>\r\n    <script>\r\n        function displayBox(id){\r\n\r\n            \$(\".curinfo_\"+id).hide();\r\n            \$(\"#pr_\"+id).show();\r\n        }\r\n        function checkDisabled(ids,obj){\r\n            if((\$(obj).is(':checked')))\r\n            {\r\n                \$(\"#\"+ids).removeClass('rowdisabled');\r\n                \$(\"#\"+ids).addClass('rowenabled');\r\n                \$(\".rowenabled input[type=text]\").each(function(i){\r\n                    \$(this).removeAttr(\"disabled\");\r\n                });\r\n            }else{\r\n                \$(\"#\"+ids).addClass('rowdisabled');\r\n                \$(\"#\"+ids).removeClass('rowenabled');\r\n                \$(\".rowdisabled input[type=text]\").each(function(i){\r\n                    \$(this).attr(\"disabled\", \"disabled\");\r\n                });\r\n            }\r\n            //\r\n        }\r\n\r\n        function arrangeOrder(groupid)\r\n        {\r\n            location.href='main2.php?page=imeiservice&p=1&arrange=1&defaultpage=imeiquick.clientgroup.php&grpid='+groupid;\r\n        }\r\n    </script>\r\n";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "imeiservice.head.php";
    echo "    <div id=\"tabcontent\"> ";
} else {
    if ($retail) {
        $sql = mysqli_fetch_assoc(dquery("select id from \r\n        tbl_imei_group " . $wherecond . " and id in (select group_id from tbl_services_imei\r\n        where retail=1) ORDER BY `display_order`"));
    } else {
        $sql = mysqli_fetch_assoc(dquery("select id from \r\n        tbl_imei_group " . $wherecond . " ORDER BY `display_order`"));
    }
    $groups = $sql["id"];
    $_GET["grpid"] = $sql["id"];
}
if ($retail) {
    $wretail = " and retail=1";
}
$pagelimit = 10000;
global $admin_template;
if ($grpid && $sort != "") {
    sortOrder("tbl_services_imei", "sort", "id", $sort, $type, " AND group_id='" . $grpid . "'");
}
$sql = dquery("SELECT * from `tbl_currencies` where `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    $othercurrency[] = $row;
}
if ($showallserv || $groups == "999999" || $groups == "999998" || $groups == "999997") {
    if ($groups == "999997") {
    }
    if ($retail) {
        $imeiServiceDetails = getIMEIServices("", "", "", "", "", "", true, "", "", "", "", "", "", "", "", "", "", "", "", "", $server ? 2 : "");
    } else {
        $imeiServiceDetails = getIMEIServices("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $server ? 2 : "");
    }
    if ($groups == "999997") {
        foreach ($imeiServiceDetails as $g => $igroup) {
            foreach ($igroup as $k => $imei) {
                if ($imei["API"]) {
                    if ($imei["flagprice"] == 0) {
                        unset($imeiServiceDetails[$g][$k]);
                    }
                } else {
                    unset($imeiServiceDetails[$g][$k]);
                }
            }
        }
    }
    if ($groups == "999999") {
        foreach ($imeiServiceDetails as $g => $igroup) {
            foreach ($igroup as $k => $imei) {
                if (!$imei["apicurrency"]) {
                    if ($imei["apicredit"] <= $imei["credit"]) {
                        unset($imeiServiceDetails[$g][$k]);
                    }
                } else {
                    $apiprice = convertCurrency($imei["apicredit"], $imei["apicurrency"], $_SESSION["system_default_currency"]["code"], "", "code");
                    if ($apiprice <= $imei["credit"]) {
                        unset($imeiServiceDetails[$g][$k]);
                    }
                }
            }
        }
    }
    if ($groups == "999998") {
        foreach ($imeiServiceDetails as $g => $igroup) {
            foreach ($igroup as $k => $imei) {
                $curflag = 0;
                foreach ($othercurrency as $cur) {
                    $d = mysqli_fetch_assoc(dquery("SELECT \r\n                           `credit` FROM `tbl_imei_credit`\r\n                            WHERE `service_id`='" . $imei["id"] . "' \r\n                            AND `currency_id`='" . $cur["id"] . "'"));
                    if ($d["credit"]) {
                        $defaultcurprice = convertCurrency($d["credit"], $cur["id"], $_SESSION["system_default_currency"]["id"]);
                        if ($defaultcurprice < $imei["credit"]) {
                            $imeiServiceDetails[$g][$k]["redbg"][$cur["id"]] = true;
                            $curflag = 1;
                        }
                    }
                }
                if (!$curflag) {
                    unset($imeiServiceDetails[$g][$k]);
                }
            }
        }
    }
} else {
    if ($retail) {
        $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", "", true, "", "", true, "", "", "", "", "", "", "", "", "", "", $server ? 2 : "");
    } else {
        if ($search) {
            $groups = "";
            $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", "", "", "", "", true, "", "", "", $arrange ? "namea" : "", $search, "", "", "", "", "", $server ? 2 : "");
        } else {
            $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", "", "", "", "", "", "", "", "", $arrange ? "namea" : "", "", "", "", "", "", "", $server ? 2 : "");
        }
    }
}
echo "    <style>\r\n        .glob {\r\n            background-color: #e9e9e9;\r\n            cursor: pointer;\r\n            display: inline-block;\r\n            height: 28px;\r\n            line-height: 26px;\r\n            vertical-align: middle;\r\n            width: 35px;\r\n            text-align: center;\r\n            font-size: 18px;\r\n        }\r\n    </style>\r\n    <script>\r\n        \$(function () {\r\n            SelectChildren = function (element) {\r\n                if(\$(\"#\"+element).is(':checked')){\r\n                    \$(\".\"+element).attr('checked',true);\r\n                }else{\r\n                    \$(\".\"+element).attr('checked',false);\r\n                }\r\n            }\r\n        });\r\n        function calc()\r\n        {\r\n            var mosi=\$(\"#mosi\").val();\r\n            var intr=15;\r\n            for(var i=1;i<=mosi;i++)\r\n            {\r\n                var ei=\$(\"#ei\").val();\r\n                var sum=parseFloat(\$(\"#sum\").val());\r\n                var tot=(sum+parseFloat(ei)).toFixed(0);\r\n                var pric=parseFloat(tot*intr/100).toFixed(0);\r\n                pric=(pric/12).toFixed(0);\r\n                var fin=parseFloat(sum)+parseFloat(ei)+parseFloat(pric);\r\n                \$(\"#sum\").val(fin);\r\n            }\r\n        }\r\n    </script>\r\n    <div id=\"notification\"></div>\r\n    <div id=\"notification1\"></div>\r\n    <div id=\"content\">\r\n        <div id=\"content_padded\">\r\n\r\n            <script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\r\n            <script>\r\n                function increase(id){\r\n                    var per=parseFloat(\$(\".incr\"+id).val());\r\n                    if(per>0){\r\n                        \$('.price'+id).each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$(this).val((iso+tso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n                function decrease(id){\r\n                    var per=parseFloat(\$(\".incr\"+id).val());\r\n                    if(per>0){\r\n                        \$('.price'+id).each(function() {\r\n                            var tso=parseFloat(\$(this).val());\r\n                            if(tso>0){\r\n                                var iso=(tso*per)/100;\r\n                                \$(this).val((tso-iso).toFixed(2));\r\n                            }\r\n                        });\r\n                    }\r\n                }\r\n                \$(document).ready(function() {\r\n                    \$('#main_tbl').tableDnD({\r\n                        onDrop: function(table, row) {\r\n                            var serialized= \$.tableDnD.serialize();\r\n                            \$.ajax({\r\n                                type: 'POST',\r\n                                url: \"includes/pages/imeiquick.order.save.php\",\r\n                                data: serialized,\r\n                                success: function(data) {\r\n                                    \$(\"#notification1\").addClass('successbox');\r\n                                    \$(\"#notification1\").html(data).show();\r\n                                }\r\n                            });\r\n                        }\r\n                    });\r\n                });\r\n                function checkRemove(val){\r\n                    if(val==15){\r\n                        \$(\"#removetype\").show();\r\n                    }else{\r\n                        \$(\"#removetype\").hide();\r\n                        \$(\"#remoption\").hide();\r\n                    }\r\n                    if(val==18){\r\n                        \$(\"#commission\").show();\r\n                    }else{\r\n                        \$(\"#commission\").hide();\r\n                    }\r\n                    if(val==21){\r\n                        \$(\"#notifyemail\").show();\r\n                    }else{\r\n                        \$(\"#notifyemail\").hide();\r\n                    }\r\n\r\n                }\r\n                function checkRemType(val){\r\n                    if(val==2){\r\n                        \$(\"#remoption\").show();\r\n                    }else{\r\n                        \$(\"#remoption\").hide();\r\n                    }\r\n                }\r\n            </script>\r\n            <form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\r\n                ";
if ($server) {
    echo "                    <input type=\"hidden\" value=\"1\" name=\"server\"/>\r\n                    ";
}
echo "                <input type=\"hidden\" name=\"defaultpage\" value=\"imeiquick.clientgroup.php\" />\r\n                <input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\r\n                <input type=\"hidden\" name=\"showall\" value=\"";
echo $showallserv;
echo "\" />\r\n                <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\r\n                ";
echo generate_token("form");
echo "\r\n\r\n\r\n                        <fieldset class=\"search-form\">\r\n                            <legend>Quick Search</legend>\r\n                            <div class=\"row\">\r\n                                ";
$GROUPNAME = "";
echo "                                <select name=\"groups\" class=\"chosen col\" onchange=\"javascript:reloadcurrent('imeiquick.clientgroup','&sel=imeiquick.clientgroup";
if ($server) {
    echo "&server=1";
}
echo "&grpid='+this.value+'&defaultpage=imeiquick.clientgroup.php";
if ($retail) {
    echo "&retail=1";
}
echo "')\">\r\n                                    ";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group " . $wherecond . " ORDER BY `display_order`,`group_name` asc");
while ($row = mysqli_fetch_assoc($sql)) {
    if (mysqli_num_rows(dquery("select id from tbl_services_imei where group_id='" . $row["id"] . "' " . $wretail))) {
        echo "                                            <option ";
        if ($_GET["grpid"] == $row["id"]) {
            $GROUPNAME = $row["group_name"];
            echo "selected";
        }
        echo " value=\"";
        echo $row["id"];
        echo "\">";
        echo html_entity_decode($row["group_name"]);
        echo "</option>\r\n                                            ";
    }
}
echo "                                </select>\r\n\r\n\r\n                                <input type=\"text\" name=\"search\" class=\"txt col\" placeholder=\"Search service from any group\" value=\"\" >\r\n                                <input value=\"Search\" type=\"submit\" class=\"button ml-1\" name=\"add\">\r\n\r\n                            </div>\r\n                        </fieldset>\r\n\r\n                ";
if ($search) {
    $GROUPNAME = "ALL";
}
echo "\r\n\r\n\r\n                <table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='quicksort quick'>\r\n                    <thead >\r\n                    <tr style=\"cursor: default !important;\" class=\"tsTitles\">\r\n                        <th  class=\"sorter-false\"> </th>\r\n                        <th style=\"width: 100%\">\r\n\r\n                            ";
echo $GROUPNAME;
echo "                        </th>\r\n                        <th  class=\"sorter-false\"></th>\r\n                        <th  class=\"sorter-false\">";
echo $LNG["time"];
echo "</th>\r\n                        <th class=\"sorter-false\">";
echo $LNG["api"];
echo "</th>\r\n                        <th  class=\"sorter-false\">";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo " <br/> [";
echo $_SESSION["system_default_currency"]["code"];
echo "]</th>\r\n\r\n                        <th  class=\"sorter-false\">";
echo $LNG["credit"];
echo " <br/> [";
echo $_SESSION["system_default_currency"]["code"];
echo "]</th>\r\n                        ";
$qc = dquery("select id,groupname from tbl_client_group order by displayorder,id asc");
while ($rcc = mysqli_fetch_assoc($qc)) {
    echo "                        <th  class=\"sorter-false\">\r\n                            <div>";
    echo $rcc["groupname"];
    echo " <br/> [";
    echo $_SESSION["system_default_currency"]["code"];
    echo "]</div>\r\n                        </th>\r\n                        ";
}
echo "                        <th class=\"hide\"  class=\"sorter-false\"></th>\r\n                    </tr>\r\n                    </thead>\r\n\r\n                        ";
$nocurrency = mysqli_fetch_assoc(dquery("SELECT count(*) from `tbl_currencies` where `default`='0'"));
$nocur = $nocurrency[0] + 6;
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
$i = 0;
foreach ($imeiServiceDetailsKey as $group) {
    if (0 < count($imeiServiceDetails[$group])) {
        if (mysqli_num_rows(dquery("SELECT id FROM tbl_imei_group WHERE group_name=\"" . $group . "\" and active='1'"))) {
            $selected = "checked";
        } else {
            $selected = "";
        }
        $e = 0;
        $flagauto = false;
        $sql = dquery("SELECT `id`,`code` from `tbl_client_group`\r\n                 order by `displayorder`,id desc");
        echo "\r\n                    <tbody class=\"tsGroup\">\r\n                    ";
        foreach ($imeiServiceDetails[$group] as $keys) {
            if ($keys["status"]) {
                $selected = "checked";
            } else {
                $selected = "";
            }
            $e++;
            echo "                        <tr id=\"";
            echo $keys["id"];
            echo "\" ";
            if (!$selected) {
                echo "class='rowdisabled'";
            }
            echo " >\r\n                            <td style=\"border-left: none\"><input  name=\"imei_check[";
            echo $keys["id"];
            echo "]\"\r\n                                                                  onclick=\"checkDisabled(";
            echo $keys["id"];
            echo ",this)\"\r\n                                      ";
            echo $selected;
            echo "                           value=\"";
            echo $keys["id"];
            echo "\" type=\"checkbox\" class=\"g_";
            echo $i;
            echo "\"/><label></label></td>\r\n                            <td style=\"width: 100%;border-left: none\">\r\n                                <span class=\"d-none\"> ";
            echo html_entity_decode($keys["service_name"]);
            echo " </span>\r\n                                <input type=\"text\" name=\"servicename[";
            echo $keys["id"];
            echo "]\"\r\n                                    ";
            if (!$selected) {
                echo "disabled='disabled'";
            }
            echo "                                value='";
            echo html_entity_decode($keys["service_name"]);
            echo "'\r\n                                style=\"max-width: 100%;\" />\r\n                            </td>\r\n                            <td style=\"border-left: none\">\r\n                                <span class=\"show-hover\">\r\n                                    <a class=\"default_dg_a2  editdata\" style=\"text-indent: unset\" href=\"javascript:load_fromsubpage('editimeiservice&id=";
            echo $keys["id"];
            echo "','";
            echo $keys["service_name"];
            echo "')\" >Edit</a>\r\n                                </span>\r\n                            </td>\r\n                            <td><input type=\"text\" style=\"min-width:120px;\" class=\"text-input\" name=\"times[";
            echo $keys["id"];
            echo "]\"\r\n                                    ";
            if (!$selected) {
                echo "disabled='disabled'";
            }
            echo "                                       value=\"";
            echo $keys["time"];
            echo "\"   /></td>\r\n                            <td>\r\n                                ";
            if ($groups == "999999") {
                echo "<span class='textred'>" . $keys["apicredit"] . $keys["apicurrency"] . "<span>";
            } else {
                if ($keys["apicredit"] != "") {
                    echo "<div class='tooltip'>" . $keys["apicredit"] . $keys["apicurrency"] . "<span class='tooltiptext'><strong>" . $keys["apigateway"] . "</strong><br />" . $keys["apiname"] . "</span></div>";
                }
            }
            echo "                            </td>\r\n                            <td><input type=\"text\" style=\"width:80px;\" class=\"text-input  alert-update\"\r\n                                    ";
            if (!$selected) {
                echo "disabled='disabled'";
            }
            echo "                                name=\"purchase[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["purchase_cost"];
            echo "\"   /></td>\r\n                            <td><div class=\"tooltip left\" align=\"left\"><input type=\"text\" style=\"width:80px;\"\r\n                                        ";
            if (!$selected) {
                echo "disabled='disabled'";
            }
            echo "                                                         class=\"text-input td-left alert-update price";
            echo $row["id"];
            echo " ";
            echo $BG;
            echo "\"\r\n                                                         name=\"credit[";
            echo $keys["id"];
            echo "]\"\r\n                                                         value=\"";
            echo $keys["credit"];
            echo "\" ";
            if ($keys["autoapi"]) {
                echo "readonly";
            }
            echo " />\r\n                                    ";
            if ($keys["autoapi"]) {
                echo "                                        <span class=\"tooltiptext\"><strong>Auto Update Price from APi</strong><br />\r\n            Base price increase by <br/> ";
                echo $keys["apiincrease"];
                echo " ";
                echo $keys["apiincreasetype"] == "Percentage" ? "%" : "Fixed";
                echo "            <br /><small class=\"textred\">** Can not edit</small>\r\n        </span>\r\n                                        ";
            }
            echo "                            ";
            $qc = dquery("select id,groupname from tbl_client_group order by displayorder,id asc");
            while ($rcc = mysqli_fetch_assoc($qc)) {
                $cgp = mysqli_fetch_assoc(dquery("select discount\r\n                                from tbl_client_group_price where group_id='" . $rcc["id"] . "'\r\n                                and service_type='imei' and service_id='" . $keys["id"] . "'\r\n                                and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'"));
                $cga = mysqli_fetch_assoc(dquery("select * from tbl_group_api_price\r\n                                where service_id='" . $keys["id"] . "' and group_id='" . $rcc["id"] . "'"));
                echo "                          <td>\r\n\r\n\r\n                                    <div  id=\"pr_";
                echo $keys["id"] . $rcc["id"];
                echo "\" ";
                if ($cgp["discount"] == 0 || !$cgp["discount"]) {
                    echo "style='display:none'";
                }
                echo " class=\"tooltip left\" align=\"left\">\r\n                                        <input type=\"text\" style=\"width:80px;\"\r\n                                               class=\"text-input td-left  alert-update price";
                echo $row["id"];
                echo " ";
                echo $BG;
                echo "\"\r\n                                               name=\"price[";
                echo $keys["id"];
                echo "][";
                echo $rcc["id"];
                echo "]\"\r\n                                            ";
                if (!$selected) {
                    echo "disabled='disabled'";
                }
                echo "                                               value=\"";
                echo $keys["credit"] - $cgp["discount"];
                echo "\" ";
                if ($keys["autoapi"]) {
                    echo "readonly";
                }
                echo " />\r\n                                        ";
                if ($keys["autoapi"]) {
                    echo "                                            <span class=\"tooltiptext\">\r\n                                          <strong>Auto Update Price from APi</strong><br/>\r\n                                          ";
                    if (0 < $cga["price"]) {
                        echo "                                              Group price increase by\r\n                                              <br/> ";
                        echo $cga["price"];
                        echo " ";
                        echo $cga["increaseby"] == "Percentage" ? "%" : "Fixed";
                        echo "                                                      <br/> ";
                    }
                    echo "            <small class=\"textred\">** Can not edit</small>\r\n\r\n\r\n                                      </span>\r\n                                        ";
                }
                echo "                                    </div>\r\n                                ";
                if ($cgp["discount"] == 0 || !$cgp["discount"]) {
                    echo "                                    <div class=\"tooltip left curinfo_";
                    echo $keys["id"] . $rcc["id"];
                    echo "\" ";
                    if (!$keys["autoapi"]) {
                        echo " onclick=\"displayBox(";
                        echo $keys["id"] . $rcc["id"];
                        echo ");\" ";
                    }
                    echo ">\r\n                                        <i class=\"convertedcurrency costing_";
                    echo $keys["id"];
                    echo " curup_";
                    echo $keys["id"] . $rcc["id"];
                    echo "\"\r\n                                           id=\"cur_";
                    echo $rcc["id"];
                    echo "\">";
                    echo $keys["credit"];
                    echo "</i>\r\n                                        <span class=\"tooltiptext\">\r\n                                             <strong>Auto Update Price from APi</strong><br/>\r\n                                        ";
                    if (0 < $cga["price"]) {
                        echo "                                              Group price increase by\r\n                                              <br/> ";
                        echo $cga["price"];
                        echo " ";
                        echo $cga["increaseby"] == "Percentage" ? "%" : "Fixed";
                        echo "                                                      <br/> ";
                    } else {
                        echo "                                              <small class=\"textred\">**\r\n                                                  Price increase not set taken from Base price\r\n                                              </small><br/>\r\n                                            ";
                    }
                    if (!$keys["autoapi"]) {
                        echo "                                            <small style=\"font-size: 14px;\">Click to set Custom Price</small>\r\n                                            ";
                    } else {
                        echo "<small class='textred'>** Can not edit</small>";
                    }
                    echo "                                        </span>\r\n                                    </div>\r\n                                    ";
                }
                echo "\r\n                            </td>\r\n                                ";
            }
            echo "                            <td class=\"hide\"></td>\r\n                        </tr>\r\n                    ";
        }
    }
    $i++;
}
$addon = licince\reqaddon("E-commerce", true);
echo "                    </tbody>\r\n                </table>\r\n                <img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin-left:5px; border:0px;\">\r\n\r\n                <select name=\"quickapply\" onchange=\"checkRemove(this.value);\">\r\n                    <option value=\"\">";
echo $LNG["select"];
echo "</option>\r\n                    <option value=\"1\">";
echo $LNG["disconnectapi"];
echo "</option>\r\n                    <option value=\"8\">";
echo $LNG["show"];
echo " ";
echo $LNG["on"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</option>\r\n                    <option value=\"9\">";
echo $LNG["remove"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</option>\r\n                    ";
if ($config["shoppingcart"] && $addon) {
    echo "                        <option value=\"18\">";
    echo $LNG["affiliate"];
    echo " Commision</option>\r\n                        <option value=\"2\">";
    echo $LNG["retail"];
    echo " ";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["enable"];
    echo "</option>\r\n                        <option value=\"3\">";
    echo $LNG["retail"];
    echo " ";
    echo $LNG["shop"];
    echo " ";
    echo $LNG["disable"];
    echo "</option>\r\n                    ";
}
echo "                    <option value=\"4\">";
echo $LNG["email"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["enable"];
echo "</option>\r\n                    <option value=\"5\">";
echo $LNG["email"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["disable"];
echo "</option>\r\n                    <option value=\"6\">";
echo $LNG["sms"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["enable"];
echo "</option>\r\n                    <option value=\"7\">";
echo $LNG["sms"];
echo " ";
echo $LNG["notification"];
echo " ";
echo $LNG["disable"];
echo "</option>\r\n                    <option value=\"10\">";
echo $LNG["reset"];
echo " ";
echo $LNG["user"];
echo " ";
echo $LNG["discount"];
echo "</option>\r\n                    <option value=\"11\">";
echo $LNG["review"];
echo " ";
echo $LNG["enable"];
echo "</option>\r\n                    <option value=\"12\">";
echo $LNG["review"];
echo " ";
echo $LNG["disable"];
echo "</option>\r\n                    <option value=\"13\">";
echo $LNG["tax"];
echo " ";
echo $LNG["enable"];
echo "</option>\r\n                    <option value=\"14\">";
echo $LNG["tax"];
echo " ";
echo $LNG["disable"];
echo "</option>\r\n                    <option value=\"15\">";
echo $LNG["remove"];
echo " ";
echo $LNG["service"];
echo "</option>\r\n                    <option value=\"19\">";
echo $LNG["enable"];
echo " ";
echo $LNG["service"];
echo "</option>\r\n                    <option value=\"20\">";
echo $LNG["disable"];
echo " ";
echo $LNG["service"];
echo "</option>\r\n                    <option value=\"21\">Email For Notification</option>\r\n                    ";
if (licince\reqaddon("E-commerce", true)) {
    echo "                        <option value=\"16\">Partner Site ";
    echo $LNG["enable"];
    echo "</option>\r\n                        <option value=\"17\">Partner Site ";
    echo $LNG["disable"];
    echo "</option>\r\n                        ";
}
echo "                    <option value=\"22\">Enable Manually verification for API</option>\r\n                    <option value=\"23\">Disable Manually verification for API</option>\r\n                    <option value=\"24\">Send Price change Notification forcefully</option>\r\n                </select>&nbsp;\r\n                <span id=\"commission\" style=\"display: none;\"><input type=\"text\" name=\"commisions\" value=\"0\" size=\"5\" placeholder=\"Commision\" />%</span>\r\n                <select name=\"removetype\" id=\"removetype\"  style=\"display: none; float: left;\" onchange=\"checkRemType(this.value);\">\r\n                    <option value=\"\">";
echo $LNG["select"];
echo "</option>\r\n                    <option value=\"1\">";
echo $LNG["soft"];
echo " ";
echo $LNG["delete"];
echo "</option>\r\n                    <option value=\"2\">";
echo $LNG["physically"];
echo " ";
echo $LNG["delete"];
echo "</option>\r\n                </select>\r\n                <span id=\"notifyemail\" style=\"display: none;\">\r\n Email : <input type=\"text\"  name=\"notification_mail\"\r\n                placeholder=\"Notification Email\"\r\n                value=\"\"  />\r\n</span>\r\n                &nbsp;\r\n                <div id=\"remoption\" style=\"display: none; float: left;  width: 200px; margin-left: 10px; \">\r\n                    <input type=\"checkbox\" name=\"remorder\" id=\"remorder\" value=\"1\" /> <label for=\"remorder\">";
echo $LNG["remove"];
echo " ";
echo $LNG["orders"];
echo "</label> <br />\r\n                    <input type=\"checkbox\" name=\"remclient\" id=\"remclient\" value=\"1\" /> <label for=\"remclient\">";
echo $LNG["remove"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["clientgroup"];
echo "</label>\r\n                </div>\r\n                &nbsp;\r\n\r\n                <input value=\"";
echo $LNG["applyonselected"];
echo "\" id=\"btnapply\" class=\"btn\"\r\n                       type=\"button\"  onclick=\"SubmitForm ('#btnapply','imeiquick.apply','#frmedituser','#notification','true','#main_loader');\"/>\r\n\r\n                <p align=\"center\" class=\"fixedbtn\">\r\n\r\n                    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\"\r\n                           class=\"btn\" type=\"button\"\r\n                           onclick=\"SubmitForm('#btnedituser1','imeiquick.clientgroup','#frmedituser','#notification','true','#main_loader');\"/>\r\n<lable><input type=\"checkbox\" checked name=\"annoucement\" value=\"1\" />Auto Generate Price Change Announcements and Telegram Channel</lable>\r\n                      </p>\r\n\r\n\r\n            </form>\r\n\r\n\r\n        </div></div>\r\n\r\n\r\n\r\n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Products---Services/?aid=30&pid=1&cid=5#pricing\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>