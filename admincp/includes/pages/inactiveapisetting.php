<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns1;

if ($lite) {
    $alowapis = $licinfo["apis"];
    if (!$alowapis) {
        echo "No api activated for this license";
        exit;
    }
}
echo "<div id=\"tabcontent\">\n    <ul id=\"tabmenu\">\n        <li class=\"tabmenu-header\"><span>Submenu</span></li>\n        <li><a ";
if ($defaultloadpage != "apisetting.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\"\n                 id=\"tab\">APi</a></li>\n        <li><a   onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab22\">+Add APi</a></li>\n        <li><a onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab2\">Cron Settings</a></li>\n        <li><a onclick=\"getContect('#tab4','main2.php?page=croninstall','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab4\">Cron Auto Install</a></li>\n        <li><a onclick=\"getContect('#tab3','main2.php?page=apisynchistory','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab3\">APi Sync ";
echo $LNG["history"];
echo "</a></li>\n        <div style=\"clear: both;\"></div>\n    </ul>\n\n    ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    $pageid = 134;
    checkPagePermission($pageid);
    include_once "apisetting.comm.php";
    if ($deactive && $action != "activate") {
        echo "<div id=\"notification1\" class=\"successbox\">" . $LNG["apideactivated"] . "</div><br />";
    }
    if ($clear) {
        dquery("DELETE FROM `tbl_apiservers` WHERE `gateway` = '" . $gateway . "'\n    and setting='LastError'");
    }
    if ($action == "activate") {
        if ($DEMOMODE) {
            echo "error: This function not enabled in demo mode .";
            exit;
        }
        dquery("DELETE FROM `tbl_apiservers` WHERE `gateway` = '" . $gateway . "'");
        $data["gateway"] = $gateway;
        $data["setting"] = "active";
        $data["value"] = 1;
        $data["order"] = 0;
        $db->insert("tbl_apiservers", $data);
        foreach ($GatewayConfig[$gateway] as $key => $val) {
            $data = NULL;
            $data["gateway"] = $gateway;
            $data["setting"] = $key;
            $data["value"] = $val["Value"];
            $db->insert("tbl_apiservers", $data);
            $data = NULL;
        }
        $data = NULL;
        echo "<div id=\"notification1\" class=\"successbox\" >" . $LNG["api"] . " " . $LNG["service"] . " " . $LNG["activated"] . "</div>";
    }
    $APIArrList = [];
    if (0 < count($DisabledGateways)) {
        foreach ($DisabledGateways as $modulename) {
            $_show = false;
            $_Verifiyeddd = false;
            if ($lite) {
                if (in_array($modulename, $alowapis)) {
                    $_show = true;
                }
            } else {
                $_show = true;
            }
            include_once "../modules/apiserver/" . $modulename . ".php";
            if ($_show && $GatewayConfig[$modulename]["name"]["Value"]) {
                $APIArrList[$modulename]["name"] = $GatewayConfig[$modulename]["name"]["Value"];
                $APIArrList[$modulename]["instant"] = $APIMODULE[$modulename . "instant"];
                $APIArrList[$modulename]["verified"] = $APIMODULE[$modulename . "verified"];
            }
        }
    }
    $price = array_column($APIArrList, "verified");
    array_multisort($price, SORT_DESC, $APIArrList);
    echo "\n    <div class=\"mt-2\">\n\n    <div id=\"notification\"></div>\n\n    <div  class=\"groupstabes\">\n\n        <div class=\"groupstabescontant\">\n\n\n            <div  class=\"groupstabes\">\n\n                <div class=\"groupstabescontant\">\n                    ";
    echo "<table id=\"main_tbl\" class=\"form accordian2\" style=\"width:100%\">\n      <thead>\n      <tr>\n          <th>             \n            <input type=\"text\"   class=\"searchservicebox2\" placeholder=\"search APi server\" />\n          </th>\n          \n          <th align=\"right\" ><div align=\"right\" >" . $LNG["action"] . "</div></th>   </tr>  </thead>\n      <tbody>";
    foreach ($APIArrList as $modulename => $row) {
        $_show = false;
        $_Verifiyeddd = false;
        if ($lite) {
            if (in_array($modulename, $alowapis)) {
                $_show = true;
            }
        } else {
            $_show = true;
        }
        include_once "../modules/apiserver/" . $modulename . ".php";
        if ($_show && $row["name"]) {
            echo "<tr><td> <span class=\"searchme\"> " . $row["name"] . "</span>";
            if ($row["instant"]) {
                echo " <span class='badge badge-secondary'>instant supported</span>";
            }
            if ($row["verified"]) {
                echo " <span class='badge badge-warning'>verified</span>";
            }
            echo "</td><td align=\"right\" >\n         <form  method=\"post\" ><input type=\"hidden\" name=\"action\" value=\"activate\">\n            <input type=\"hidden\" name=\"gateway\" value=\"" . $modulename . "\">\n<input type=\"submit\" class=\"btn btn-success btn-sm\" value=\"" . $LNG["active"] . "\"></form>\n\n</td></tr>";
            echo "";
        }
    }
    echo "</tbody></table>\n                    ";
}
echo "  </div>\n            </div>\n        </div>\n    </div>\n</div>  ";
$fileverioncheck = "6.1.0";
echo "\n</div>\n\n<script>\n    (function (\$) {\n        \$.fn.extend({\n            searchService: function (options) {\n                var defaults = {\n                    searchBox: '#searchlistbox',\n                    searchObj: '.searchme'\n                };\n                var options = \$.extend(defaults, options);\n                this.each(function () {\n                    var o = options;\n                    var obj = \$(this);\n                    \$(o.searchBox).keyup(function () {\n                        searchWord = \$(this).val();\n                        if (searchWord.length >= 1) {\n                            \$(o.searchObj, obj).each(function () {\n                                text = \$(this).text();\n                                if (text.match(RegExp(searchWord, 'i'))) {\n                                    \$(this).parents('tr').css({'display': 'table-row'}).addClass('block');\n                                } else {\n                                    \$(this).parents('tr').css({'display': 'none'}).removeClass('block');\n                                }\n                            });\n                        } else {\n                            \$('tr', obj).css({'display': 'table-row'}).addClass('block');\n                        }\n                    });\n                });\n            }\n        });\n    })(jQuery);\n    \$(document).ready(function () {\n        \$('.accordian1').searchService({searchBox: '.searchservicebox1'});\n        \$('.accordian2').searchService({searchBox: '.searchservicebox2'});\n    });\n</script>\n";
class no1
{
}

?>