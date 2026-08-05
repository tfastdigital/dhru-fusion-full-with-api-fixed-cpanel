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
echo "\n\n<div id=\"tabcontent\">\n\n\n    <ul id=\"tabmenu\">\n\n        <li class=\"tabmenu-header\"><span>Submenu</span></li>\n\n        <li><a ";
if ($defaultloadpage != "apisetting.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\"\n                 id=\"tab\">APi</a></li>\n        <li><a onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab22\">+Add APi</a></li>\n        <li><a onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab2\">Cron Settings</a></li>\n        <li><a onclick=\"getContect('#tab4','main2.php?page=croninstall','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab4\">Cron Auto Install</a></li>\n        <li><a onclick=\"getContect('#tab3','main2.php?page=apisynchistory','','','#tabcontent',true,'#main_loader');\"\n               id=\"tab3\">APi Sync ";
echo $LNG["history"];
echo "</a></li>\n\n        <div style=\"clear: both;\"></div>\n\n    </ul>\n\n    ";
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
    echo "\n\n    <div class=\"mt-2\">\n\n    <div id=\"notification1\" class=\"info\">\n        To enable APi automation features to run, make sure you set up a cron job, Click here to find <a\n                onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\"\n                id=\"tab2\">Cron Settings</a></div>\n\n    <div id=\"notification\"></div>\n\n    <div  class=\"groupstabes\">\n\n        <div class=\"groupstabescontant\">\n\n            ";
    $data = NULL;
    $data_query = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name' ORDER BY `order`");
    if (!mysqli_num_rows($data_query)) {
        echo "                <div id=\"notification1\"  class=\"info d-flex p-2\">You do not have any activated APi. <a onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\">Click here</a> to Add APi</div>\n                ";
    }
    if (mysqli_num_rows($data_query)) {
        echo "<table id=\"main_tbl\" class=\"accordian1 form\" style=\"width:100%\">\n      <thead>\n      <tr>\n          <th>             \n            <input type=\"text\"   class=\"searchservicebox1\" placeholder=\"search APi server\" />\n          </th>\n          <th class=\"center\" >Services</th>\n          <th align=\"left\" >Add New Service</th>\n          <th align=\"right\" ><div align=\"right\" >" . $LNG["action"] . "</div></th>   </tr>  </thead>\n      <tbody>";
        while ($data = mysqli_fetch_assoc($data_query)) {
            $customname = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='customname' AND `gateway`='" . $data["gateway"] . "' "));
            $instant = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='instant' AND `gateway`='" . $data["gateway"] . "' ");
            $instantS = mysqli_fetch_assoc($instant);
            include_once "../modules/apiserver/" . $data["gateway"] . ".php";
            $lasterror = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='LastError' AND `gateway`='" . $data["gateway"] . "' "));
            if ($customname) {
                $customname = " (" . $customname["value"] . ") ";
            }
            $_show = false;
            if ($lite) {
                if (in_array($data["gateway"], $alowapis)) {
                    $_show = true;
                }
            } else {
                $_show = true;
            }
            $ConnectedService = mysqli_num_rows(dquery("select * from\n     tbl_services_imei\n    where API='" . $data["gateway"] . "' and API_ID!=''"));
            if ($_show) {
                echo "<tr><td> <span class=\"searchme\"> " . $data["value"] . $customname . "<small class='textred'>" . ($lasterror["value"] ? "<br />" . $lasterror["value"] . " <a href=\"main2.php?page=apisetting&gateway=" . $data["gateway"] . "&clear=true\"> - Forget Error</a>" : "") . "</small> </span>";
                if ($instantS["value"]) {
                    echo " <span class='badge badge-success'>instant</span>";
                } else {
                    if ($APIMODULE[$data["gateway"] . "instant"]) {
                        echo " <span class='badge badge-secondary'>instant supported</span>";
                    }
                }
                if ($APIMODULE[$data["gateway"] . "verified"]) {
                    echo " <span class='badge badge-warning'>verified</span>";
                }
                echo "</td>";
                echo "<td class=\"center\" ><a class=\"default_dg_a2\" href=\"javascript:load_subpage('main2.php?page=apisetting.edit&loadstatus=1&id=" . $data["gateway"] . "','" . $LNG["edit"] . "  " . $LNG["setting"] . " & " . $LNG["synchronize"] . "')\" >" . ($ConnectedService ? $ConnectedService : 0) . "</a></td>\n        <td class=\"center\"><a class=\"default_dg_a2\" href=\"javascript:load_subpage('main2.php?page=apisetting.edit&loadnew=1&id=" . $data["gateway"] . "','" . $LNG["edit"] . "  " . $LNG["setting"] . " & " . $LNG["synchronize"] . "')\" >" . $LNG["quick"] . " " . $LNG["add"] . " " . $LNG["service"] . "</a></td>\n        <td align=\"right\" ><a class=\"default_dg_a2\" href=\"javascript:load_subpage('main2.php?page=apisetting.edit&id=" . $data["gateway"] . "','" . $LNG["edit"] . "  " . $LNG["setting"] . " & " . $LNG["synchronize"] . "')\" >" . $LNG["edit"] . " " . $LNG["setting"] . " & " . $LNG["synchronize"] . "</a></td></tr>";
            }
            $instantS = NULL;
        }
        $data_query = NULL;
        echo "</tbody></table></div></div>";
    }
    echo "            <div  class=\"groupstabes\">\n\n                <div class=\"groupstabescontant\">\n                    ";
}
echo "  </div>\n            </div>\n        </div>\n    </div>\n</div>  ";
$fileverioncheck = "6.1.0";
echo "\n\n<script>\n    (function (\$) {\n        \$.fn.extend({\n            searchService: function (options) {\n                var defaults = {\n                    searchBox: '#searchlistbox',\n                    searchObj: '.searchme'\n                };\n                var options = \$.extend(defaults, options);\n                this.each(function () {\n                    var o = options;\n                    var obj = \$(this);\n                    \$(o.searchBox).keyup(function () {\n                        searchWord = \$(this).val();\n                        if (searchWord.length >= 1) {\n                            \$(o.searchObj, obj).each(function () {\n                                text = \$(this).text();\n                                if (text.match(RegExp(searchWord, 'i'))) {\n                                    \$(this).parents('tr').css({'display': 'table-row'}).addClass('block');\n                                } else {\n                                    \$(this).parents('tr').css({'display': 'none'}).removeClass('block');\n                                }\n                            });\n                        } else {\n                            \$('tr', obj).css({'display': 'table-row'}).addClass('block');\n                        }\n                    });\n                });\n            }\n        });\n    })(jQuery);\n    \$(document).ready(function () {\n        \$('.accordian1').searchService({searchBox: '.searchservicebox1'});\n        \$('.accordian2').searchService({searchBox: '.searchservicebox2'});\n    });\n</script>\n</div>\n";
class no1
{
}

?>