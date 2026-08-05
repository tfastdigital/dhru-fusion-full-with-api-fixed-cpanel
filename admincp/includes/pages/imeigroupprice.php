<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n\$(function () {\n    SelectChildren = function (element) {\n       if(\$(\"#\"+element).is(':checked')){\n            \$(\".\"+element).attr('checked',true);\n       }else{\n            \$(\".\"+element).attr('checked',false);\n       }      \n    }\n});\n</script>\n";
$pageid = 406;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    echo "<ul id=\"tabmenu\">  \n\n    <li><a id=\"tab1\"   class='tabmenu_active' onclick=\"getContect('#tab1','main2.php?page=imeigroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["imeiserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab2\"  onclick=\"getContect('#tab2','main2.php?page=filegroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["fileserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab3\"  onclick=\"getContect('#tab3','main2.php?page=servergroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["serverlogserviceprising"];
    echo "</a></li>\n    <li><a id=\"tab4\"   onclick=\"getContect('#tab4','main2.php?page=productgroupprice','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"  >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["pricing"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_imei_group where server=0 order by display_order,group_name asc limit 1"));
    $groups = $sql["id"];
    $_GET["grpid"] = $groups;
}
$pagelimit = 10000;
if ($groups != "999999" && $groups != "999998") {
    $imeiServiceDetails = getIMEIServices($groups, "", "", "", "", "", "", "", "", "", "", "", 999);
} else {
    $imeiServiceDetails = getIMEIServices();
}
$sql = dquery("SELECT * from `tbl_currencies`\n             where `default`='0'");
while ($row = mysqli_fetch_assoc($sql)) {
    $othercurrency[] = $row;
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
                $d = mysqli_fetch_assoc(dquery("SELECT \n                   `discount` FROM `tbl_client_group_price`\n                    WHERE `service_id`='" . $imei["id"] . "' \n                    and group_id='" . $id . "'\n                    and service_type='imei'\n                    AND `currency_id`='" . $cur["id"] . "'"));
                if ($d["discount"]) {
                    $dc = mysqli_fetch_assoc(dquery("SELECT \n   `discount` FROM `tbl_client_group_price`\n    WHERE `service_id`='" . $imei["id"] . "' \n    and group_id='" . $id . "'\n    and service_type='imei'\n    AND `currency_id`='" . $_SESSION["system_default_currency"]["id"] . "'"));
                    $defaultcurprice = convertCurrency($imei["credit"] - $dc["discount"], $_SESSION["system_default_currency"]["id"], $cur["id"]);
                    $appliedPrice = convertCurrency($imei["credit"], $_SESSION["system_default_currency"]["id"], $cur["id"]);
                    if ($defaultcurprice < $appliedPrice) {
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
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>\n                  <th style=\"width: 20px !important;\"></th>\n                <th >\n\n                <select class=\"chosen\" name=\"groups\" style=\"width: 300px !important;\"  onchange=\"javascript:reloadsubpageiframe('imeigroupprice&grpid='+this.value+'&id=";
echo $id;
echo "&loaddefaultpage=imeigroupprice.php','";
echo $id;
echo "');\">\n<option value=\"999999\" ";
if ($groups == "999999") {
    echo "selected";
}
echo " style=\"color: red;\">Price < API Price</option>\n<option value=\"999998\" ";
if ($groups == "999998") {
    echo "selected";
}
echo " style=\"color: red;\">Other currency price < ";
echo $_SESSION["system_default_currency"]["code"];
echo "</option>\n\n                    ";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group \n                    WHERE `server`='0' order by display_order,group_name asc");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                    <option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " \n                    value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n                    ";
}
echo "                    </select>\n                </th>\n                  <th>";
echo $LNG["custom"];
echo " ";
echo $LNG["price"];
echo " ";
echo $LNG["user"];
echo "</th>\n\n";
$sql = dquery("SELECT * from `tbl_currencies` ORDER BY `default` DESC");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "                        \n                <th><div align=\"center\">";
    echo $row["code"];
    echo "</div></th> \n";
}
echo "                \n            <th></th>  </tr>\n            </thead>\n            <tbody>  \n                \n";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
$i = 0;
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $selected = "";
        $sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_client_group_price\n      WHERE group_id='" . $id . "' AND service_type='imei'\n      AND service_id='" . $keys["id"] . "'"));
        if ($sql["service_id"]) {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        if ($keys["status"]) {
            $ApiCredit = mysqli_fetch_assoc(dquery("select credits from tbl_apiserversservices\n where gateway='" . $keys["API"] . "' and id='" . $keys["API_ID"] . "' and type_id='" . $keys["API_TYPEID"] . "'"));
            $APiCurrency = mysqli_fetch_assoc(dquery("select value from \n      `tbl_apiservers` WHERE `gateway` LIKE '" . $keys["API"] . "' and setting='currency'"));
            echo "\n<tr>\n\n<input type=\"hidden\" name=\"servicecredit[";
            echo $keys["id"];
            echo "]\" value=\"";
            echo $keys["credit_admin"];
            echo "\"/>\n<td style=\"width: 20px !important;\" ><input name=\"imei_check[";
            echo $keys["id"];
            echo "]\" ";
            echo $selected;
            echo " value=\"";
            echo $keys["id"];
            echo "\" type=\"checkbox\" id=\"g_";
            echo $i;
            echo "\"/><label for=\"g_";
            echo $i;
            echo "\"></label> </td>\n\n<td align=\"left\" >";
            echo $keys["service_name"];
            echo "    ";
            if ($keys["autoapi"]) {
                echo "<br ><span style='color: red;'>Auto Price From APi " . $keys["API"] . " [" . round($ApiCredit[credits], $precision) . " " . $APiCurrency["value"] . "]</span> ";
            } else {
                echo "<br ><span>APi " . $keys["API"] . " [" . round($ApiCredit[credits], $precision) . " " . $APiCurrency["value"] . "]</span> ";
            }
            echo "</td>\n    <td><a href=\"#\" data-target=\"clientgroupusers\"\n       data-target-header=\"Discounted Users of ";
            echo $keys["service_name"];
            echo "\"\n       onclick=\"AddnewInpopup(this,'";
            echo $keys["id"] . "_" . $id;
            echo "');\"><i class=\"flaticon-edit\">&nbsp;</i> ";
            echo $LNG["list"];
            echo " ";
            echo $LNG["users"];
            echo "</a>\n    </td>\n\n";
            $row = mysqli_fetch_assoc(dquery("select credit,API,API_ID,promotiondis \nfrom tbl_services_imei where id='" . $keys["id"] . "'"));
            $gate = mysqli_fetch_assoc(dquery("select * from tbl_apiserversservices\nwhere gateway='" . $row["API"] . "' and id='" . $row["API_ID"] . "'"));
            $apis = mysqli_fetch_assoc(dquery("select value from \ntbl_apiservers where gateway='" . $row["API"] . "' and setting='currency'"));
            $sql1 = dquery("SELECT * from `tbl_currencies`  ORDER BY `default` DESC");
            while ($row1 = mysqli_fetch_assoc($sql1)) {
                $data = mysqli_fetch_assoc(dquery("SELECT * from \n        tbl_client_group_price where group_id='" . $id . "'\n        AND service_type='imei' AND service_id='" . $keys["id"] . "'\n        and currency_id='" . $row1["id"] . "'"));
                $icredt = mysqli_fetch_assoc(dquery("select credit from \ntbl_imei_credit where service_id='" . $keys["id"] . "' and currency_id='" . $row1["id"] . "'"));
                if (0 < $icredt["credit"]) {
                    $orig = $icredt["credit"];
                } else {
                    $orig = round($keys["credit"] * $row1["rate"], $precision);
                }
                if ($data["discount"] != "") {
                    $credit = $orig - $data["discount"];
                } else {
                    $credit = "";
                }
                if ($credit != 0) {
                    $classChange = "chcreditvsmall-input";
                } else {
                    $classChange = "vsmall-input";
                }
                $gps = mysqli_fetch_assoc(dquery("SELECT * \n        from tbl_client_group_price where group_id='" . $id . "' AND service_type='imei' AND service_id='" . $keys["id"] . "' \n        AND currency_id='" . $row1["id"] . "'"));
                $sp = mysqli_fetch_assoc(dquery("select credit from \n        tbl_services_imei where id='" . $keys["id"] . "'"));
                if (!$row1["default"]) {
                    $orig = $sp["credit"] - $gps["discount"];
                    $convcur = mysqli_fetch_assoc(dquery("select credit\n           from tbl_imei_credit where service_id='" . $keys["id"] . "'\n           and currency_id='" . $row1["id"] . "'"));
                    if (0 < $convcur["credit"]) {
                        $orig = $convcur["credit"];
                    } else {
                        $orig = round($keys["credit"] * $row1["rate"], $precision);
                    }
                } else {
                    $orig = "";
                }
                $BG = "";
                if ($keys["redbg"][$row1["id"]]) {
                    $BG = "textred bold";
                }
                echo "        \n<td align=\"center\">\n    ";
                if ($row1["default"]) {
                    echo "        <small style=\"display: block;\">";
                    echo $keys["credit"];
                    echo "</small>\n        ";
                }
                echo "\n    <input type=\"hidden\" name=\"";
                echo $row1["code"] . $row1["id"];
                echo "[";
                echo $keys["id"];
                echo "]\" value=\"";
                echo $orig;
                echo "\" />\n\n    <small style=\"display: block;\">";
                echo $orig;
                echo "</small><input  style=\"width: 100px;text-align:center;\" name=\"";
                echo $row1["code"];
                echo "[";
                echo $keys["id"];
                echo "]\" align=\"right\" class=\"text-input ";
                echo $classChange;
                echo " ";
                echo $BG;
                echo "\" value=\"";
                echo $credit;
                echo "\" type=\"text\" size=\"5\"\n            ";
                if ($keys["autoapi"]) {
                    echo "readonly";
                }
                echo "  /></td>\n";
            }
            echo "<td></td></tr>\n";
        }
    }
    $i++;
}
unset($keys);
echo "</tbody></table>\n<br />\n<input type=\"checkbox\" checked=\"checked\" name=\"allprice\" id=\"ue\" />\n<label for=\"ue\">";
echo $LNG["updatealluser"];
echo "</label><br>\n[<small>Tick this to apply price and service \nchanges to this group owner now</small>]\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser1\" \nclass=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser1','clientgroup.imei','#frmedituser','#notification','true','#main_loader');\"/></p>\n<hr />\n<br />\n<input type=\"checkbox\" checked=\"checked\" name=\"annoucements\" id=\"ansc\" />\n<label for=\"ansc\">";
echo $LNG["auto"];
echo " ";
echo $LNG["generate"];
echo " ";
echo $LNG["price"];
echo " ";
echo $LNG["change"];
echo " ";
echo $LNG["announcements"];
echo "</label>\n</form></div></div> \n";
if (isset($_GET["grpid"])) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>