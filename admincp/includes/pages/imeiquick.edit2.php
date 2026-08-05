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
echo "<script>\n    function displayBox(id){\n            \$(\".curinfo_\"+id).hide();\n            \$(\"#pr_\"+id).show();\n    }\n    function checkDisabled(ids,obj){\n        if((\$(obj).is(':checked')))\n        {\n            \$(\"#\"+ids).removeClass('rowdisabled');\n            \$(\"#\"+ids).addClass('rowenabled');\n            \$(\".rowenabled input[type=text]\").each(function(i){\n                \$(this).removeAttr(\"disabled\");\n            });\n        }else{\n            \$(\"#\"+ids).addClass('rowdisabled');\n            \$(\"#\"+ids).removeClass('rowenabled');\n            \$(\".rowdisabled input[type=text]\").each(function(i){\n                    \$(this).attr(\"disabled\", \"disabled\");\n            });\n        }\n       //\n    }\n\n</script>\n<style>\n    .convertedcurrency{\n          color: #7c6866;\n          font-size: 14px;\n      }\n    .rowdisabled input{\n\n    }\n\n</style>\n<script>\nfunction arrangeOrder(groupid)\n{\n    location.href='main2.php?page=imeiservice&p=1&arrange=1&defaultpage=imeiquick.edit2.php&grpid='+groupid;\n}\n</script>\n";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "imeiservice.head.php";
    echo "<div id=\"tabcontent\"> ";
} else {
    if ($retail) {
        $sql = mysqli_fetch_assoc(dquery("select id from \n        tbl_imei_group " . $wherecond . " and id in (select group_id from tbl_services_imei\n        where retail=1) ORDER BY `display_order`"));
    } else {
        $sql = mysqli_fetch_assoc(dquery("select id from \n        tbl_imei_group " . $wherecond . " ORDER BY `display_order`"));
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
        $imeiServiceDetails = getIMEIServices("", "", "", "", "", "", "", "", "", "", "", "", "", $arrange ? "service_name" : "", "", "", "", "", "", "", $server ? 2 : "");
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
                    $d = mysqli_fetch_assoc(dquery("SELECT \n                           `credit` FROM `tbl_imei_credit`\n                            WHERE `service_id`='" . $imei["id"] . "' \n                            AND `currency_id`='" . $cur["id"] . "'"));
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
        if ($searchkey) {
            unset($groups);
        }
        $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", "", "", "", "", false, "", "", "", $arrange ? "namea" : "", $searchkey, "", "", "", "", "", $server ? 2 : "");
    }
}
echo "<style>\n.glob {\n    background-color: #e9e9e9;\n    cursor: pointer;\n    display: inline-block;\n    height: 28px;\n    line-height: 26px;\n    vertical-align: middle;\n    width: 35px;\n    text-align: center;\n    font-size: 18px;\n}\n</style>\n<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }\n    }\n});\nfunction calc()\n{\n   var mosi=\$(\"#mosi\").val();\n   var intr=15;\n   for(var i=1;i<=mosi;i++)\n   {\n\n     var ei=\$(\"#ei\").val();\n     var sum=parseFloat(\$(\"#sum\").val());\n     var tot=(sum+parseFloat(ei)).toFixed(0);\n     var pric=parseFloat(tot*intr/100).toFixed(0);\n     pric=(pric/12).toFixed(0);\n\n         var fin=parseFloat(sum)+parseFloat(ei)+parseFloat(pric);\n         \$(\"#sum\").val(fin);\n\n   }\n}\n</script>\n<div id=\"notification\"></div>\n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\nfunction increase(id){\n    var per=parseFloat(\$(\".incr\"+id).val());\n    if(per>0){\n        \$('.price'+id).each(function() {\n            var tso=parseFloat(\$(this).val());\n            if(tso>0){\n                var iso=(tso*per)/100;\n                \$(this).val((iso+tso).toFixed(2));\n            }\n        });\n    }\n}\nfunction decrease(id){\n    var per=parseFloat(\$(\".incr\"+id).val());\n    if(per>0){\n        \$('.price'+id).each(function() {\n            var tso=parseFloat(\$(this).val());\n            if(tso>0){\n                var iso=(tso*per)/100;\n                \$(this).val((tso-iso).toFixed(2));\n            }\n        });\n    }\n}\n\$(document).ready(function() {\n    //currencyprices\n    \$('#main_tbl').tableDnD({\n        onDrop: function(table, row) {\n           var serialized= \$.tableDnD.serialize();\n            \$.ajax({\n    \t\t\ttype: 'POST',\n    \t\t\turl: \"includes/pages/imeiquick.order.save.php\",\n    \t\t\tdata: serialized,\n    \t\t\tsuccess: function(data) {\n    \t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t}\n    \t\t});\n        }\n    });\n});\nfunction checkRemove(val){\n    if(val==15){\n        \$(\"#removetype\").show();\n    }else{\n        \$(\"#removetype\").hide();\n        \$(\"#remoption\").hide();\n    }\n    if(val==18){\n        \$(\"#commission\").show();\n    }else{\n        \$(\"#commission\").hide();\n    }\n    if(val==21){\n        \$(\"#notifyemail\").show();\n    }else{\n        \$(\"#notifyemail\").hide();\n    }\n}\nfunction checkRemType(val){\n    if(val==2){\n        \$(\"#remoption\").show();\n    }else{\n        \$(\"#remoption\").hide();\n    }\n}\n</script>\n\n\n\n    <form method=\"post\" id=\"frmsearch\">\n\n        <fieldset class=\"search-form\">\n            <legend>Quick Search</legend>\n            <div class=\"row\">\n                <select name=\"groups\" class=\"chosen\" onchange=\"javascript:reloadcurrent('imeiquick.edit2','&sel=imeiquick.edit2";
if ($server) {
    echo "&server=1";
}
echo "&grpid='+this.value+'&defaultpage=imeiquick.edit2.php";
if ($retail) {
    echo "&retail=1";
}
echo "')\">\n                    <option value=\"999997\" ";
if ($groups == "999997") {
    echo "selected";
}
echo " style=\"color: red;\">API Price Changed</option>\n                    <option value=\"999999\" ";
if ($groups == "999999") {
    echo "selected";
}
echo " style=\"color: red;\">Price < API Price</option>\n                    <option value=\"999998\" ";
if ($groups == "999998") {
    echo "selected";
}
echo " style=\"color: red;\">Other currency price < ";
echo $_SESSION["system_default_currency"]["code"];
echo "</option>\n                    ";
$groupname = "";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group " . $wherecond . " ORDER BY `display_order`,`group_name` asc");
while ($row = mysqli_fetch_assoc($sql)) {
    if (mysqli_num_rows(dquery("select id from tbl_services_imei where group_id='" . $row["id"] . "' " . $wretail))) {
        echo "                            <option ";
        if ($_GET["grpid"] == $row["id"]) {
            $groupname = $row["group_name"];
            echo "selected";
        }
        echo " value=\"";
        echo $row["id"];
        echo "\">";
        echo html_entity_decode($row["group_name"]);
        echo "</option>\n                            ";
    }
}
echo "                </select>\n\n                <input type=\"text\" name=\"searchkey\" class=\"txt col\" placeholder=\"Search service from any group\" value=\"\" >\n                <input value=\"Search\" type=\"submit\" class=\"button ml-1\" name=\"add\">\n            </div>\n        </fieldset>\n        <input type=\"hidden\" name=\"defaultpage\" value=\"imeiquick.edit2.php\" />\n    </form>\n<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n";
if ($server) {
    echo " <input type=\"hidden\" value=\"1\" name=\"server\"/>\n ";
}
echo "<input type=\"hidden\" name=\"defaultpage\" value=\"imeiquick.edit2.php\" />\n<input type=\"hidden\" value=\"";
echo $groups;
echo "\" name=\"groups\"/>\n<input type=\"hidden\" name=\"showall\" value=\"";
echo $showallserv;
echo "\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\"  class='quicksort quick'>\n            <thead>\n              <tr style=\"cursor: default !important;\">\n                <th style=\"border-left: none\" class=\"sorter-false\">\n\n                </th>\n                <th>\n                ";
$gorupid = 0;
foreach ($imeiServiceDetails[$group] as $p => $b) {
    if ($b["group_id"]) {
        $gorupid = $b["group_id"];
        if ($searchkey) {
            echo "Filter '" . $searchkey . "' - <a href='javascript: \$(\"#frmsearch\").submit();'>Clear Filter</a>";
        } else {
            echo (string) $groupname;
        }
        echo "</th>\n                  <th class=\"sorter-false\"></th>\n                 <th class=\"sorter-false\">";
        echo $LNG["time"];
        echo "</th>\n                 <th class=\"sorter-false\">";
        echo $LNG["api"];
        echo "</th>\n                 <th class=\"sorter-false\">";
        echo $LNG["purchase"];
        echo " ";
        echo $LNG["cost"];
        echo " <br/> [";
        echo $_SESSION["system_default_currency"]["code"];
        echo "] </th>\n                 <th class=\"sorter-false\">";
        echo $LNG["servicecredit"];
        echo " <br/> [";
        echo $_SESSION["currency_admin"]["code"];
        echo "]</th>\n";
        foreach ($othercurrency as $cur) {
            echo "                <th class=\"sorter-false\"><div>";
            echo $cur["code"];
            echo "</div></th>\n";
        }
        echo "\n              </tr>\n          </thead>\n    <!--\n<tr>\n    <td colspan=\"5\" style=\"border-left: none\"></td>\n";
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
                foreach ($imeiServiceDetails[$group] as $keys) {
                    if ($keys["autoapi"]) {
                        $flagauto = true;
                    }
                }
                $sql = dquery("SELECT `id`,`code` from `tbl_currencies`\n        order by `default` desc");
                while ($row = mysqli_fetch_assoc($sql)) {
                    echo "        <td>\n           <div class=\"d-flex justify-content-between w-100\" style=\"margin-bottom: 5px\">\n           <span class=\"glob rounded\" onclick=\"increase(";
                    echo $row["id"];
                    echo ");\">+</span>\n            <span class=\"glob rounded\" onclick=\"decrease(";
                    echo $row["id"];
                    echo ");\">-</span>\n           </div>\n           <input  style=\"width:40px;text-align: center;\" type=\"text\"\n           name=\"perc[";
                    echo $row["id"];
                    echo "]\" class=\"incr";
                    echo $row["id"];
                    echo " alert-update\" value=\"0\"\n           ";
                    if ($flagauto) {
                        echo "readonly";
                    }
                    echo " />\n\n        </td>\n        ";
                }
                echo "\n </tr>\n-->\n<tbody>\n";
                foreach ($imeiServiceDetails[$group] as $keys) {
                    $happyhours = getIMEIhappyhours($keys["id"]);
                    if ($keys["status"]) {
                        $selected = "checked";
                    } else {
                        $selected = "";
                    }
                    $e++;
                    echo "\n<tr id=\"";
                    echo $keys["id"];
                    echo "\" title=\"";
                    echo html_entity_decode($keys["service_name"]);
                    echo "\" ";
                    if (!$selected) {
                        echo "class='rowdisabled'";
                    }
                    echo " >\n <td style=\"border-left: none\"><input  name=\"imei_check[";
                    echo $keys["id"];
                    echo "]\" onclick=\"checkDisabled(";
                    echo $keys["id"];
                    echo ",this)\" ";
                    echo $selected;
                    echo " value=\"";
                    echo $keys["id"];
                    echo "\" type=\"checkbox\" class=\"g_";
                    echo $i;
                    echo "\"/><label></label></td>\n <td class=\"w-100\">\n     <span class=\"d-none\">";
                    echo html_entity_decode($keys["service_name"]);
                    echo "</span>\n     <input type=\"text\" name=\"servicename[";
                    echo $keys["id"];
                    echo "]\"\n            ";
                    if (!$selected) {
                        echo "disabled='disabled'";
                    }
                    echo " value='";
                    echo html_entity_decode($keys["service_name"]);
                    echo "' style=\"width: 100%;\" />\n\n </td>\n    <td style=\"border-left: none\">\n                                <span class=\"show-hover\">\n                                    <a class=\"default_dg_a2  editdata\" style=\"text-indent: unset\" href=\"javascript:load_fromsubpage('editimeiservice&id=";
                    echo $keys["id"];
                    echo "','";
                    echo $keys["service_name"];
                    echo "')\" >Edit</a>\n                                </span>\n    </td>\n  <td><input type=\"text\" style=\"width:120px;\" class=\"text-input\"\n          ";
                    if (!$selected) {
                        echo "disabled='disabled'";
                    }
                    echo "             name=\"times[";
                    echo $keys["id"];
                    echo "]\" value=\"";
                    echo $keys["time"];
                    echo "\"   /></td>\n  <td>\n";
                    if ($groups == "999999") {
                        echo "<span class='textred'>" . $keys["apicredit"] . $keys["apicurrency"] . "<span>";
                    } else {
                        if ($keys["apicredit"] != "") {
                            echo "<div class='tooltip'>" . $keys["apicredit"] . $keys["apicurrency"] . "<span class='tooltiptext'><strong>" . $keys["apigateway"] . "</strong><br />" . $keys["apiname"] . "</span></div>";
                        }
                    }
                    echo "  </td>\n<td><input type=\"text\" class=\"text-input alert-update\"\n        ";
                    if (!$selected) {
                        echo "disabled='disabled'";
                    }
                    echo "           name=\"purchase_cost[";
                    echo $keys["id"];
                    echo "]\" value=\"";
                    echo $keys["purchase_cost"];
                    echo "\"   /></td>\n<td align=\"left\">\n\n    <div  class=\"tooltip\">\n    <input type=\"text\"\n       onkeyup=\"changeAutoPrice(";
                    echo $keys["id"];
                    echo ",this.value)\"\n    ";
                    if (!$selected) {
                        echo "disabled='disabled'";
                    }
                    echo "       class=\"text-input alert-update\n       price";
                    echo $_SESSION["system_default_currency"]["id"];
                    echo "\"  name=\"servicecredit[";
                    echo $keys["id"];
                    echo "]\" value=\"";
                    echo $keys["credit_admin"];
                    echo "\" ";
                    if ($keys["autoapi"]) {
                        echo "readonly";
                    }
                    echo " />\n    ";
                    if ($keys["autoapi"]) {
                        echo "     <span class=\"tooltiptext\"><strong>Auto Update Price from APi</strong><br />\n            Base price increase by <br/> ";
                        echo $keys["apiincrease"];
                        echo " ";
                        echo $keys["apiincreasetype"] == "Percentage" ? "%" : "Fixed";
                        echo "            <br /><small class=\"textred\">** Can not edit</small>\n        </span>\n\n        ";
                    }
                    echo "    </div>\n</td>\n";
                    foreach ($othercurrency as $row) {
                        $d = mysqli_fetch_assoc(dquery("SELECT `credit` FROM `tbl_imei_credit` WHERE `service_id`='" . $keys["id"] . "' AND `currency_id`='" . $row["id"] . "'"));
                        $BG = "";
                        if ($keys["redbg"][$row["id"]]) {
                            $BG = "textred bold";
                        }
                        echo "\n<td>\n    <div ";
                        if (!$keys["autoapi"]) {
                            echo " onclick=\"displayBox(";
                            echo $keys["id"] . $row["id"];
                            echo ");\" ";
                        }
                        echo " class=\"convertedcurrency tooltip left curinfo_";
                        echo $keys["id"] . $row["id"];
                        echo "\">\n        <i class=\"costing_";
                        echo $keys["id"];
                        echo " curup_";
                        echo $keys["id"] . $row["id"];
                        echo "\" id=\"cur_";
                        echo $row["id"];
                        echo "_";
                        echo $row["rate"];
                        echo "\">";
                        echo round($keys["credit"] * $row["rate"], $precision);
                        echo "</i>\n        <span class=\"tooltiptext\"><strong>1 ";
                        echo $_SESSION["system_default_currency"]["code"];
                        echo " = ";
                        echo $row["rate"];
                        echo " ";
                        echo $row["code"];
                        echo "</strong><br />\n            ";
                        if (!$keys["autoapi"]) {
                            echo "                <small style=\"font-size: 11px;\">Click to set Custom Price</small>\n                ";
                        } else {
                            echo "<small  class='textred'>** Can not edit</small>";
                        }
                        echo "        </span>\n    </div>\n    <div align=\"left\" class=\"currencyprices\" id=\"pr_";
                        echo $keys["id"] . $row["id"];
                        echo "\" >\n\n\n            <input type=\"text\"\n                   class=\"text-input alert-update td-left   price";
                        echo $keys["id"] . $row["id"];
                        echo " ";
                        echo $BG;
                        echo "\"\n                   name=\"";
                        echo $row["code"];
                        echo "[";
                        echo $keys["id"];
                        echo "]\"\n                ";
                        if (!$selected) {
                            echo "disabled='disabled'";
                        }
                        echo "                   value=\"";
                        echo $d["credit"];
                        echo "\" ";
                        if ($keys["autoapi"]) {
                            echo "readonly";
                        }
                        echo " />\n\n </div></td>\n";
                    }
                    echo "\n</tr>\n";
                }
            }
            $i++;
        }
        $addon = licince\reqaddon("E-commerce", true);
        echo "\n</tbody>\n\n</table>\n\n<img width=\"38\" height=\"22\" title=\"\" alt=\"With selected\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" style=\"padding:0px; margin-left:5px; border:0px;\">\n\n<select name=\"quickapply\" onchange=\"checkRemove(this.value);\">\n<option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n<option value=\"1\">";
        echo $LNG["disconnectapi"];
        echo "</option>\n<option value=\"8\">";
        echo $LNG["show"];
        echo " ";
        echo $LNG["on"];
        echo " ";
        echo $LNG["home"];
        echo " ";
        echo $LNG["page"];
        echo "</option>\n<option value=\"9\">";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["from"];
        echo " ";
        echo $LNG["home"];
        echo " ";
        echo $LNG["page"];
        echo "</option>\n";
        if ($config["shoppingcart"] && $addon) {
            echo "<option value=\"18\">";
            echo $LNG["affiliate"];
            echo " Commision</option>\n<option value=\"2\">";
            echo $LNG["retail"];
            echo " ";
            echo $LNG["shop"];
            echo " ";
            echo $LNG["enable"];
            echo "</option>\n<option value=\"3\">";
            echo $LNG["retail"];
            echo " ";
            echo $LNG["shop"];
            echo " ";
            echo $LNG["disable"];
            echo "</option>\n";
        }
        echo "<option value=\"4\">";
        echo $LNG["email"];
        echo " ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["enable"];
        echo "</option>\n<option value=\"5\">";
        echo $LNG["email"];
        echo " ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["disable"];
        echo "</option>\n<option value=\"6\">";
        echo $LNG["sms"];
        echo " ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["enable"];
        echo "</option>\n<option value=\"7\">";
        echo $LNG["sms"];
        echo " ";
        echo $LNG["notification"];
        echo " ";
        echo $LNG["disable"];
        echo "</option>\n<option value=\"10\">";
        echo $LNG["reset"];
        echo " ";
        echo $LNG["user"];
        echo " ";
        echo $LNG["discount"];
        echo "</option>\n<option value=\"11\">";
        echo $LNG["review"];
        echo " ";
        echo $LNG["enable"];
        echo "</option>\n<option value=\"12\">";
        echo $LNG["review"];
        echo " ";
        echo $LNG["disable"];
        echo "</option>\n<option value=\"13\">";
        echo $LNG["tax"];
        echo " ";
        echo $LNG["enable"];
        echo "</option>\n<option value=\"14\">";
        echo $LNG["tax"];
        echo " ";
        echo $LNG["disable"];
        echo "</option>\n<option value=\"15\">";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["service"];
        echo "</option>\n<option value=\"19\">";
        echo $LNG["enable"];
        echo " ";
        echo $LNG["service"];
        echo "</option>\n<option value=\"20\">";
        echo $LNG["disable"];
        echo " ";
        echo $LNG["service"];
        echo "</option>\n<option value=\"21\">Email For Notification</option>\n";
        if (licince\reqaddon("E-commerce", true)) {
            echo "<option value=\"16\">Partner Site ";
            echo $LNG["enable"];
            echo "</option>\n<option value=\"17\">Partner Site ";
            echo $LNG["disable"];
            echo "</option>\n";
        }
        echo "<option value=\"22\">Enable Manually verification for API</option>\n<option value=\"23\">Disable Manually verification for API</option>\n<option value=\"24\">Send Price change Notification forcefully</option>\n</select>&nbsp;\n<span id=\"commission\" style=\"display: none;\"><input type=\"text\" name=\"commisions\" value=\"0\" size=\"5\" placeholder=\"Commision\" />%</span>\n<select name=\"removetype\" id=\"removetype\"  style=\"display: none; float: left;\" onchange=\"checkRemType(this.value);\">\n<option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n<option value=\"1\">";
        echo $LNG["soft"];
        echo " ";
        echo $LNG["delete"];
        echo "</option>\n<option value=\"2\">";
        echo $LNG["physically"];
        echo " ";
        echo $LNG["delete"];
        echo "</option>\n</select>\n<span id=\"notifyemail\" style=\"display: none;\">\n Email : <input type=\"text\"  name=\"notification_mail\"\n  placeholder=\"Notification Email\"\nvalue=\"\"  />\n</span>\n&nbsp;\n<div id=\"remoption\" style=\"display: none; float: left;  width: 200px; margin-left: 10px; \">\n<input type=\"checkbox\" name=\"remorder\" id=\"remorder\" value=\"1\" /> <label for=\"remorder\">";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["orders"];
        echo "</label> <br />\n<input type=\"checkbox\" name=\"remclient\" id=\"remclient\" value=\"1\" /> <label for=\"remclient\">";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["from"];
        echo " ";
        echo $LNG["clientgroup"];
        echo "</label>\n</div>\n&nbsp;\n\n<input value=\"";
        echo $LNG["applyonselected"];
        echo "\" id=\"btnapply\" class=\"btn\"\ntype=\"button\"  onclick=\"SubmitForm ('#btnapply','imeiquick.apply','#frmedituser','#notification','true','#main_loader');\"/>\n\n\n<span class=\"td-right\">\n\n\n</span>\n\n<br/>\n\n<p align=\"center\" class=\"fixedbtn\">\n\n<input value=\"";
        echo $LNG["save"];
        echo "\" id=\"btnedituser1\"\nclass=\"btn\" type=\"button\"\nonclick=\"SubmitForm('#btnedituser1','imeiquick.edit','#frmedituser','#notification','true','#main_loader');\"/>\n\n<input type=\"checkbox\" checked=\"checked\" name=\"annoucements\" id=\"ansc\" />\n<label for=\"ansc\">";
        echo $LNG["auto"];
        echo " ";
        echo $LNG["generate"];
        echo " ";
        echo $LNG["price"];
        echo " ";
        echo $LNG["change"];
        echo " ";
        echo $LNG["announcements"];
        echo "</label>\n\n<input type=\"button\" style=\"float: right;\" name=\"allapisync\"\nvalue=\"Fetch Pricing from all API\"\nonclick=\"load_subpage('main2.php?page=syncallapi','Fetch Pricing from All API');\"  />\n<br />\n    <span style=\"color: red; font-size: 12px;\">This Price change will effect on Group Price accordingly. e.g. if you increase price by 2 it will increase group  price by 2 also</span>\n</p>\n\n\n</form>\n\n<form method=\"post\" id=\"frmjson\">\n    ";
        if ($server) {
            echo "        <input type=\"hidden\" value=\"1\" name=\"server\"/>\n      ";
        }
        echo "    <input type=\"hidden\" name=\"defaultpage\" value=\"imeiquick.edit2.php\" />\n    <input type=\"hidden\" value=\"";
        echo $groups;
        echo "\" name=\"groups\"/>\n    <input type=\"hidden\" name=\"showall\" value=\"";
        echo $showallserv;
        echo "\" />\n    <input type=\"hidden\" value=\"";
        echo $id;
        echo "\" name=\"id\"/>\n    ";
        echo generate_token("form");
        echo "    <input type=\"hidden\" name=\"fulljson\" id=\"fulljson\" value=\"\" />\n</form>\n\n</div></div>\n\n    <style>\n        table#main_tbl td input[type=\"text\"]{\n            width: 100%;\n            min-width: 80px;\n        }\n    </style>\n\n\n";
        if (isset($_GET["grpid"])) {
            echo "</div>";
        }
        echo "\n\n\n\n";
        if (!$fusionlite && $config["wikihelp"]) {
            echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Products---Services/?aid=30&pid=1&cid=5#edit-imei-service\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
        }
        $fileverioncheck = "6.1.0";
        echo "<script>\n    function changeAutoPrice(id,credit){\n\n        \$('.costing_'+id).each(function(i){\n\n            var ids=\$(this).attr('id');\n            var curid=ids.split(\"_\");\n            var converted=(parseFloat(credit)*parseFloat(curid[2])).toFixed(";
        echo $precision;
        echo ");\n            if(isNaN(converted)){\n\n            }else {\n                \$(\".curup_\" + id + curid[1]).html(converted);\n            }\n\n        });\n    }\n    \$(document).ready(function() {\n        \$(\".currencyprices\").each(function(i){\n            var ids=\$(this).attr('id');\n            var orig=ids.split(\"_\");\n            if(!\$(\".price\"+orig[1]).val()){\n                \$(this).hide();\n                \$(\".curinfo_\"+orig[1]).show();\n            }else{\n                \$(\".curinfo_\"+orig[1]).hide();\n                \$(this).show();\n            }\n        });\n\n\n        \$(\"table.quicksort\").tablesorter();\n\n    });\n</script>\n";
    }
}

?>