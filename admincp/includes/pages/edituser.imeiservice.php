<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 4;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($clientDetails["usertype"] == "3") {
    echo "<div id=notification1 class=info>" . $LNG["logineedres"] . "</div>";
    exit;
}
if ($newserver) {
    $wherecond = " where `server`=1";
    $FILTERFIELD = "alow_serverlogservices";
} else {
    $wherecond = " where `server`=0";
    $FILTERFIELD = "alow_imeiservices";
}
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "edituser.head.php";
    echo "    <div id=\"tabcontent\">";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_imei_group \n    " . $wherecond . " ORDER BY display_order"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
if ($newserver) {
    $wherecond = " where `server`=1";
    if ($clientDetails["usertype"] == "3") {
        $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", md5($id), "", "", "", true, "", "", "", "", "", "", "", "", "", "", 2);
    } else {
        $imeiServiceDetails = getIMEIServices($groups, "", $id, true, true, "", "", "", "", true, true, "", "", "", "", "", "", "", "", "", 2);
    }
} else {
    $wherecond = " where `server`=0";
    if ($clientDetails["usertype"] == "3") {
        $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", md5($id), "", "", "", true, "", "");
    } else {
        $imeiServiceDetails = getIMEIServices($groups, "", $id, true, true, "", "", "", "", true, true, "");
    }
}
$allowServices = explode(",", $clientDetails["access"][$FILTERFIELD]);
if ($newserver) {
    if ($clientDetails["access"]["serverlogservice"]) {
        $enable = "checked";
        $display = "table";
    } else {
        $disable = "checked";
        $display = "none";
    }
} else {
    if ($clientDetails["access"]["imeiservice"]) {
        $enable = "checked";
        $display = "table";
    } else {
        $disable = "checked";
        $display = "none";
    }
}
if (isset($_SESSION["uid"])) {
    echo "    <div id=\"notification1\" class=\"errorbox\">You cant set Price while you are login as a Client in same browser</div>\n    ";
    exit;
}
echo "   <script>\n        function resetDiscount(){\n            if(confirm('Are you sure want to reset Discount of All services?')){\n                SubmitForm ('#resetdiscount','edituser.resetdiscount','#frmedituser','#notification','true','#main_loader');\n            }\n        }\n        function enable_me(id)\n        {\n            document.getElementById(id).style.display='table';\n        }\n        function disable_me(id)\n        {\n            document.getElementById(id).style.display='none';\n        }\n\n        \$(document).ready(function(){\n            \$(\"#enable\")\n                .iButton({\n                    labelOn: \"Enable\"\n                    , labelOff: \"Disable\"\n                    , change: function (\$input){\n                        if(\$input.is(\":checked\")){\n                            \$('.imei-pricing,.imei-pricing-table').show();\n                        }\n                        else{\n                            \$('.imei-pricing,.imei-pricing-table').hide();\n                        }\n                    }\n                })\n                .trigger(\"change\");\n\n\n            \$('#alls').click(function(){\n                if(\$(this).is(':checked')){\n                    //\$('.imei-pricing-table').hide();\n                    \$('.check-all,input[class*=\"g_\"]').prop({'checked':true});\n                }\n                else{\n                    //\$('.imei-pricing-table').show();\n                    \$('.check-all,input[class*=\"g_\"]').prop({'checked':false});\n                }\n            })\n        });\n    </script>\n";
if ($clientDetails["userstatus"] != "0") {
    echo "    <div id=\"notification1\" class=\"info\">\n        ";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>\n";
}
echo "    <div id=\"notification\"></div>\n    <div id=\"content\">\n        <div id=\"content_padded\">\n\n\n            <form id=\"frmedituser\" name=\"\" method=\"post\">\n                <input type=\"hidden\" name=\"resetimei\" value=\"1\" />\n                ";
if ($newserver) {
    echo "                    <input type=\"hidden\" name=\"newserver\" value=\"1\" />\n                    ";
}
echo "                <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n                ";
echo generate_token("form");
echo "\n                <div>\n                    <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'} dontset\"\n                           name=\"access\"  value=\"1\" ";
echo $enable;
echo " id=\"enable\"/><label for=\"enable\"></label>\n\n                    <div class=\"imei-pricing\" style=\"text-align: right;\">\n                        <input type=\"checkbox\" class=\"dontset\" name=\"allservices\" value=\"1\" id=\"alls\" />\n                        <label for=\"alls\"> Assign All Services</label>\n                    </div>\n                    <table id=\"main_tbl\" class=\"imei-pricing-table\">\n                        <thead>\n                        <tr>\n                            <th>\n                                ";
if ($clientDetails["usertype"] != "3") {
    echo "                                    <input value=\"ALL\" class=\"check-all\" name=\"all_imei\"\n                                           onclick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" />\n                                ";
}
echo "</th>\n                            <th>\n                                                                <select class=\"chosen\"  name=\"groups\" onchange=\"javascript:reloadcurrent('edituser.imeiservice','&grpid='+this.value+'&id=";
echo $id;
echo "&laoddefaultpage=edituser.imeiservice.php";
if ($newserver) {
    echo "&newserver=1";
}
echo "')\">\n                                    ";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group \n" . $wherecond . " ORDER BY display_order");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                                        <option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo "                                                value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n                                        ";
}
echo "                                </select> </th>\n                            <th><div align=\"center\">";
echo $LNG["flage"];
echo "</div></th>\n                            <th>";
echo $LNG["servicecredit"];
echo "  <small>[";
echo $clientDetails["currency"]["code"];
echo "]</small></th>\n                            <th><div align=\"right\">";
echo $LNG["usercredit"];
echo "</div></th>\n                            <th></th>\n                        </tr>\n                        </thead>\n                        <tbody>\n                        <input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n                        ";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
$i = 0;
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        if (in_array($keys["id"], $allowServices) || $clientDetails["access"]["alow_imeiservices"] == "ALL") {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        $happyhours = getIMEIhappyhours($keys["id"]);
        if ($keys["credit"] - $keys["discount_admin"] != $keys["credit"]) {
            $classChange = "chcreditvsmall-input";
            $customdatachange = "changedatarow";
        } else {
            $classChange = "vsmall-input";
            $customdatachange = "";
        }
        $CountCredit = $keys["credit_admin"];
        if ($clientDetails["currency"]["id"] != $_SESSION["system_default_currency"]["id"]) {
            $qr = mysqli_fetch_assoc(dquery("select credit from tbl_imei_credit\nwhere service_id='" . $keys["id"] . "' and currency_id='" . $clientDetails["currency"]["id"] . "'"));
            if (0 < $qr["credit"]) {
                $CountCredit = $qr["credit"];
            } else {
                $CountCredit = convertCurrency($keys["credit_admin"], $_SESSION["system_default_currency"]["id"], $clientDetails["currency"]["id"]);
            }
        }
        echo "                                <tr class=\"";
        echo $customdatachange;
        echo "\">\n                                    <td><input name=\"imei_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\" class=\"g_";
        echo $i;
        echo "\"/><label></label> </td>\n                                    <td style='cursor:pointer'  onclick=\"javascript:load_fromsubpage('editimeiservice&id=";
        echo $keys["id"];
        echo "','";
        echo $keys["service_name"];
        echo "')\">";
        echo $keys["service_name"];
        echo "</td>\n                                    <td align=\"center\"  width=\"300px\">";
        if ($happyhours["promotiondis"] != 0) {
            echo "<a onclick=\"getContect('','main2.php?sid=";
            echo $keys["id"];
            echo "&page=editimeiservice.happyhours','";
            echo $keys["id"];
            echo "','','#tabcontent',true,'#main_loader');\" id=\"tab13\" >\n                                                <img src=\"images/red.gif\" title=\"Under Happy Hours\" /></a>";
        }
        echo "</td>\n                                    <td>";
        echo $keys["credit"];
        echo " <input type=\"hidden\" name=\"servicecredit[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $CountCredit;
        echo "\"/></td>\n                                    <td align=\"right\"><input name=\"user_credit[";
        echo $keys["id"];
        echo "]\" class=\"text-input ";
        echo $classChange;
        echo "\"\n                                                             value=\"";
        echo $keys["discount_admin"] ? $keys["credit"] - $keys["discount_admin"] : "";
        echo "\" type=\"text\" style=\"text-align: right;\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\" /></td>\n                                    <td></td>\n                                </tr>\n                            ";
    }
    $i++;
}
unset($keys);
echo "                        </tbody></table>\n\n                </div>\n\n                <p  class=\"fixedbtn\">\n\n\n                    <input value=\"";
echo $LNG["save"];
echo "\"\n                           id=\"btnedituser1\" class=\"btn\" type=\"button\"\n                           onclick=\"SubmitForm ('#btnedituser1','edituser.imeiservice','#frmedituser','#notification','true','#main_loader');\"/>\n\n                    <input class=\"btn btn-default floatright\" type=\"button\"  id=\"resetdiscount\" name=\"resetdiscount\" value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "\"\n                           onclick=\"javascript: resetDiscount();\"/>\n\n                </p>\n            </form></div></div>\n";
if (isset($_GET["grpid"])) {
    echo "    </div>";
}
$fileverioncheck = "6.1.0";

?>