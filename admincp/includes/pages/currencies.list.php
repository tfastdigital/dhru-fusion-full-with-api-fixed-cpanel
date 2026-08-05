<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include_once "../comm.php";
include_once "../includes/comm.inc.php";
require_once "../includes/fun.inc.php";
include_once "includes/currency.fun.php";
$pageid = 238;
checkPagePermission($pageid);
$formatarr = ["1" => "1000.99", "2" => "1,000.99", "3" => "1,000,99", "4" => "1,000"];
if ($resetprice) {
    dquery("DELETE from tbl_service_pricing WHERE currencyid!='" . $_SESSION["system_default_currency"]["id"] . "'");
    echo "    <script>\n        \$(\"#main_loader\").hide();\n    </script>\n    <div id=\"notification1\" class=\"successbox\">Price reset for other currency</div>\n    ";
}
if ($chprecision) {
    echo "    <script>\n        \$(\"#main_loader\").show();\n    </script>\n    ";
    if ($chprecision == 3) {
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='credit' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_order_imei` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL;");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='discount' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_order_imei` CHANGE `discount` `discount` DECIMAL(12,3) NULL DEFAULT NULL;");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='reseller_credit' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_order_imei` CHANGE `reseller_credit` `reseller_credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_imei where Field ='reseller_discount' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_order_imei` CHANGE `reseller_discount` `reseller_discount` DECIMAL(13,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='credit' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_order_file` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='discount' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_order_file` CHANGE `discount` `discount` DECIMAL(12,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='reseller_credit' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_order_file` CHANGE `reseller_credit` `reseller_credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_order_file where Field ='reseller_discount' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_order_file` CHANGE `reseller_discount` `reseller_discount` DECIMAL(13,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='credit' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_services_imei` CHANGE `credit` `credit` DECIMAL(13,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='retail_credit' and Type='decimal(15,2)'"))) {
            dquery("ALTER TABLE `tbl_services_imei` CHANGE `retail_credit` `retail_credit` DECIMAL(15,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='prev_price' and Type='decimal(20,2)'"))) {
            dquery("ALTER TABLE `tbl_services_imei` CHANGE `prev_price` `prev_price` DECIMAL(20,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_imei where Field ='apilower' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_services_imei` CHANGE `apilower` `apilower` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_services_file where Field ='credit' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tbl_services_file` CHANGE `credit` `credit` DECIMAL(12,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_discount_imei where Field ='discount' and Type='decimal(20,2)'"))) {
            dquery("ALTER TABLE `tbl_discount_imei` CHANGE `discount` `discount` DECIMAL(20,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_discount_file where Field ='discount' and Type='decimal(20,2)'"))) {
            dquery("ALTER TABLE `tbl_discount_file` CHANGE `discount` `discount` DECIMAL(20,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_imei_credit where Field ='credit' and Type='decimal(25,2)'"))) {
            dquery("ALTER TABLE `tbl_imei_credit` CHANGE `credit` `credit` DECIMAL(25,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_file_credit where Field ='credit' and Type='decimal(25,2)'"))) {
            dquery("ALTER TABLE `tbl_file_credit` CHANGE `credit` `credit` DECIMAL(25,3) NULL DEFAULT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_client_group_price where Field ='discount' and Type='decimal(15,2)'"))) {
            dquery("ALTER TABLE `tbl_client_group_price` CHANGE `discount` `discount` DECIMAL(15,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_reseller_price where Field ='price' and Type='decimal(25,2)'"))) {
            dquery("ALTER TABLE `tbl_reseller_price` CHANGE `price` `price` DECIMAL(25,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_left' and Type='decimal(25,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `credit_left` `credit_left` DECIMAL(25,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_used' and Type='decimal(30,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `credit_used` `credit_used` DECIMAL(30,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='credit_inprocess' and Type='decimal(25,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `credit_inprocess` `credit_inprocess` DECIMAL(25,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='sell_credit_limit' and Type='decimal(35,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `sell_credit_limit` `sell_credit_limit` DECIMAL(35,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='maxcredit' and Type='decimal(12,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `maxcredit` `maxcredit` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tblUsers where Field ='creditlimit' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tblUsers` CHANGE `creditlimit` `creditlimit` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_statement_user where Field ='amount' and Type='decimal(15,2)'"))) {
            dquery("ALTER TABLE `tbl_statement_user` CHANGE `amount` `amount` DECIMAL(15,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoiceitems where Field ='amount' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoiceitems` CHANGE `amount` `amount` DECIMAL(15,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='subtotal' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `subtotal` `subtotal` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='credit' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `credit` `credit` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='tax' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `tax` `tax` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='tax2' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `tax2` `tax2` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='shippingtax' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `shippingtax` `shippingtax` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='total' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `total` `total` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='taxrate' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `taxrate` `taxrate` DECIMAL(12,3) NOT NULL; ");
        }
        if (mysqli_num_rows(dquery("SHOW FIELDS FROM tbl_invoices where Field ='taxrate2' and Type='decimal(10,2)'"))) {
            dquery("ALTER TABLE `tbl_invoices` CHANGE `taxrate2` `taxrate2` DECIMAL(12,3) NOT NULL; ");
        }
    }
    saveSettings("precision", $chprecision);
    $config["precision"] = $chprecision;
    echo "    <script>\n        \$(\"#main_loader\").hide();\n    </script>\n    <div id=\"notification1\" class=\"successbox\">Precision changed successfully</div>\n    ";
}
if ($code && ($prefix || $suffix) && $rate) {
    $data["code"] = $code;
    $data["prefix"] = $prefix;
    $data["suffix"] = $suffix;
    $data["rate"] = $rate;
    $data["format"] = $format;
    if (!mysqli_num_rows(dquery("select * from tbl_currencies where code='" . $code . "'"))) {
        if ($db->insert("tbl_currencies", $data)) {
            unset($_SESSION["allcurrency"]);
            echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
        } else {
            echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
        }
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["currency"] . " " . $LNG["code"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
if ($btncurrency) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'> This function not enabled in demo mode .</div>";
    } else {
        foreach ($btncurrency as $key => $value) {
            $id = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` where id=" . $key));
            if ($id["default"] == "0") {
                $sql = dquery("select id from tblUsers where default_currency='" . $key . "'");
                if (!mysqli_num_rows($sql)) {
                    $sql = dquery("delete from tbl_currencies where id=" . $key);
                    echo "<div id=notification1 class=successbox>" . $LNG["currency"] . " " . $LNG["delete"] . " " . $LNG["successfully"] . "</div>";
                } else {
                    echo "<div id=notification1 class=errorbox>" . $LNG["cannotdelete"] . " " . $LNG["currency"] . " " . $LNG["because"] . " " . $LNG["assigned"] . " " . $LNG["to"] . " " . $LNG["user"] . "</div>";
                }
            } else {
                echo "<div id=notification1 class=errorbox>" . $LNG["you"] . " " . $LNG["can"] . " " . $LNG["not"] . " " . $LNG["delete"] . " " . $LNG["default"] . " " . $LNG["currency"] . "</div>";
            }
        }
    }
}
echo "<style>\n    .adddatarow{\n        background-color: #f1f1f1;\n    }\n</style>\n";
$CurrencyArr = [];
$cde = mysqli_fetch_assoc(dquery("select id from tbl_currencies where client='1'"));
$sql = dquery("SELECT * FROM `tbl_currencies`");
while ($row = mysqli_fetch_assoc($sql)) {
    $CurrencyArr[$row["code"]] = $row;
}
$CurrencyCurrentRate = getCurrencyRates("", true);
echo "<script>\n    function resetCurrencyPrice()\n    {\n        if(confirm('Are you sure want to Remove all other currency price from groups and services?')){\n            \$(\"#main_loader\").show();\n            location.href = 'main2.php?page=currencies.list&resetprice=1';\n\n        }\n    }\n    function callCurrencyPrecision(precision){\n        if(confirm('Please wait until you get success message. It may take long time.')) {\n            \$(\"#main_loader\").show();\n            location.href = 'main2.php?page=currencies.list&chprecision=' + precision;\n        }\n    }\n    function setPrefixSuffix(){\n        \$(\"#prefix\").val(\"\");\n        \$(\"#rateval\").val(\"\");\n        var value = \$('select#code option:selected').text();\n        var splt=value.split(\"-\");\n        \$(\"#prefix\").val(splt[1].trim())\n        var code=\$('select#code option:selected').val();\n        \$.post( \"includes/main.save.php?page=getcurrencyrate.save&code=\"+code, function( data ) {\n            \$('#rateval').val(data);\n        });\n\n    }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form action=\"\" method=\"post\">\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
echo $LNG["code"];
echo "</th>\n                <th>";
echo $LNG["prefix"];
echo " </th>\n                <th>";
echo $LNG["suffix"];
echo " </th>\n                <th>";
echo $LNG["format"];
echo " </th>\n                <th>";
echo $LNG["rate"];
echo " </th>\n                <th>";
echo $LNG["live"];
echo " </th>\n                 <th>";
echo $LNG["client"];
echo " ";
echo $LNG["default"];
echo "</th>\n                <th colspan=\"2\" align=\"right\">";
echo $LNG["action"];
echo " </th>\n              </tr>\n            </thead>\n            <tbody>\n<tr class=\"adddatarow\">\n\n<input type=\"hidden\" name=\"defaultpage\" value=\"addcurrency.php\" />\n";
echo generate_token("form");
echo "    <td>\n        <select id=\"code\" onchange=\"setPrefixSuffix()\" name=\"code\">\n            <option value=\"\">Select Currency</option>\n            ";
$CurrencyList = getCurrencyCodeList();
foreach ($CurrencyList as $code => $val) {
    if (!$CurrencyArr[$code]) {
        echo "                <option value=\"";
        echo $code;
        echo "\">";
        echo $val["name"];
        echo " - ";
        echo $val["symbol"];
        echo "</option>\n            ";
    }
}
echo "        </select>\n\n    </td>\n    <td>\n        <input type=\"text\"  class=\"txt small\" name=\"prefix\" id=\"prefix\" value=\"\" />\n    </td>\n    <td>\n        <input type=\"text\"  class=\"txt small\" name=\"suffix\" value=\"\" id=\"suffix\" />\n    </td>\n    <td>\n        <select name=\"format\">\n            <option value=\"1\">1000.99</option>\n            <option value=\"2\">1,000.99</option>\n            <option value=\"3\">1,000,99</option>\n            <option value=\"4\">1,000</option>\n        </select>\n    </td>\n    <td >\n\t   <input type=\"text\" id=\"rateval\"  class=\"txt small\" name=\"rate\" value=\"\" />\n    </td>\n    <td></td>\n    <td></td>\n<td colspan=\"2\"><div  align=\"right\">\n<input type=\"hidden\" name=\"defaultpage\" value=\"currencies.list.php\" />\n<input value=\"+ ";
echo $LNG["add"];
echo "\" name=\"save\" id=\"btnpost\" class=\"btn\" type=\"submit\"  /></div> </td>\n</tr>\n\n\n";
foreach ($CurrencyArr as $code => $row) {
    echo "<tr>\n<td>";
    if ($row["default"] == "1") {
        echo "<strong>" . $row["code"] . "</strong>";
    } else {
        echo $row["code"];
    }
    echo "    ";
    echo " - " . $CurrencyList[$code]["name"];
    echo "</td>\n<td>";
    echo $row["prefix"];
    echo "</td>\n<td>";
    echo $row["suffix"];
    echo "</td>\n<td>";
    echo $formatarr[$row["format"]];
    echo "</td>\n<td>";
    echo $row["rate"];
    echo "</td>\n<td>";
    echo round($CurrencyCurrentRate[$code], 5);
    echo "</td>\n<td>\n    ";
    if ($cde["id"]) {
        if ($cde["id"] == $row["id"]) {
            echo "<strong>Yes</strong>";
        }
    } else {
        if ($row["default"]) {
            echo "<strong>Yes</strong>";
        }
    }
    echo "</td>\n<td  align=\"right\">\n   <a class=\"default_dg_a2\" href=\"javascript: void(0)\" onclick=\"load_subpage('main2.php?page=editcurrency&edit=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["currency"];
    echo "'); return false;\">";
    echo $LNG["edit"];
    echo "</a>\n</td>\n<td align=\"right\">\n    ";
    if ($row["default"] != "1") {
        echo "<input type=\"submit\" onclick=\"javascript: return confirm('Are you sure want to remove Currency ?');\" class=\"button deletedata\" name=\"btncurrency[";
        echo $row["id"];
        echo "]\" value=\"";
        echo $LNG["delete"];
        echo "\"/>";
    } else {
        echo "<div class='blank'></div>";
    }
    echo "</td>\n<!--\n<td align=\"right\">";
    if ($row["default"] != "1") {
        echo "<input type=\"submit\" onclick=\"javascript: return confirm('Are you sure want to remove Currency ?');\" class=\"button_remove\" name=\"btncurrency[";
        echo $row["id"];
        echo "]\" value=\"";
        echo $LNG["delete"];
        echo "\"/> ";
    }
    echo "</td>\n-->\n</tr>\n";
}
echo "</tbody></table>\n</form>\n<br /><br />\n<div class=\"fixedbtn\" >\n<form id=\"updates\" name=\"\" method=\"post\">\n <input value=\"";
echo $LNG["upgrade"];
echo " ";
echo $LNG["exchange"];
echo " ";
echo $LNG["rate"];
echo "\" id=\"btnaddgroup\" class=\"button btn\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','updaterate','#updates','#notification','true','#main_loader','main2.php?page=currencies.list');\"/>\n\n\n\n\n\n    <!--\n   <input value=\"";
echo $LNG["upgrade"];
echo " ";
echo $LNG["service"];
echo " ";
echo $LNG["pricing"];
echo "\"  name=\"pricing\" class=\"btn\" type=\"submit\"  />\n   -->\n</form>\n</div>\n<br />\n";
if (isset($_POST["pricing"])) {
    echo "    <table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
    echo $LNG["service"];
    echo "</th>\n";
    $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
    while ($cur = mysqli_fetch_assoc($c)) {
        echo "<th>" . $cur["code"] . "</th>";
    }
    echo "\n              </tr>\n            </thead>\n            <tbody>\n ";
    $def = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1'"));
    $imei = dquery("SELECT `credit`,`service_name`,`id` FROM `tbl_services_imei`");
    while ($rows = mysqli_fetch_assoc($imei)) {
        echo " <tr><td>";
        echo $rows["service_name"];
        echo "</td>";
        $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
        while ($cur = mysqli_fetch_assoc($c)) {
            $amt = convertCurrency($rows["credit"], $def["id"], $cur["id"]);
            $get = mysqli_num_rows(dquery("SELECT * FROM `tbl_imei_credit` WHERE `service_id`='" . $rows["id"] . "' AND `currency_id`='" . $cur["id"] . "'"));
            if ($get) {
                $data["credit"] = $amt;
                $db->update("tbl_imei_credit", $data, "service_id='" . $rows["id"] . "' AND currency_id='" . $cur["id"] . "'");
                $data = NULL;
            } else {
                $data["credit"] = $amt;
                $data["service_id"] = $rows["id"];
                $data["currency_id"] = $cur["id"];
                $db->insert("tbl_imei_credit", $data);
                $data = NULL;
            }
            echo "<td>";
            echo $amt;
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "  </tbody></table>\n<br />\n   <table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
    echo $LNG["service"];
    echo "</th>\n";
    $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
    while ($cur = mysqli_fetch_assoc($c)) {
        echo "<th>" . $cur["code"] . "</th>";
    }
    echo "              </tr>\n            </thead>\n            <tbody>\n ";
    $def = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1'"));
    $imei = dquery("SELECT `credit`,`service_name`,`id` FROM `tbl_services_file`");
    while ($rows = mysqli_fetch_assoc($imei)) {
        echo " <tr><td>";
        echo $rows["service_name"];
        echo "</td>";
        $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
        while ($cur = mysqli_fetch_assoc($c)) {
            $amt = convertCurrency($rows["credit"], $def["id"], $cur["id"]);
            $get = mysqli_num_rows(dquery("SELECT * FROM `tbl_file_credit` WHERE `service_id`='" . $rows["id"] . "' AND `currency_id`='" . $cur["id"] . "'"));
            if ($get) {
                $data["credit"] = $amt;
                $db->update("tbl_file_credit", $data, "service_id='" . $rows["id"] . "' AND currency_id='" . $cur["id"] . "'");
                $data = NULL;
            } else {
                $data["credit"] = $amt;
                $data["service_id"] = $rows["id"];
                $data["currency_id"] = $cur["id"];
                $db->insert("tbl_file_credit", $data);
                $data = NULL;
            }
            echo "<td>";
            echo $amt;
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "  </tbody></table>\n<br />\n   <table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
    echo $LNG["service"];
    echo "</th>\n";
    $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
    while ($cur = mysqli_fetch_assoc($c)) {
        echo "<th>" . $cur["code"] . "</th>";
    }
    echo "              </tr>\n            </thead>\n            <tbody>\n ";
    $def = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1'"));
    $imei = dquery("SELECT `credit`,`service_name`,`id` FROM `tbl_server_log`");
    while ($rows = mysqli_fetch_assoc($imei)) {
        echo " <tr><td>";
        echo $rows["service_name"];
        echo "</td>";
        $c = dquery("SELECT `id`,`code` FROM `tbl_currencies` WHERE `default`!='1'");
        while ($cur = mysqli_fetch_assoc($c)) {
            $amt = convertCurrency($rows["credit"], $def["id"], $cur["id"]);
            $get = mysqli_num_rows(dquery("SELECT * FROM `tbl_server_credit` WHERE `service_id`='" . $rows["id"] . "' AND `currency_id`='" . $cur["id"] . "'"));
            if ($get) {
                $data["credit"] = $amt;
                $db->update("tbl_server_credit", $data, "service_id='" . $rows["id"] . "' AND currency_id='" . $cur["id"] . "'");
                $data = NULL;
            } else {
                $data["credit"] = $amt;
                $data["service_id"] = $rows["id"];
                $data["currency_id"] = $cur["id"];
                $db->insert("tbl_server_credit", $data);
                $data = NULL;
            }
            echo "<td>";
            echo $amt;
            echo "</td>";
        }
        echo "</tr>";
    }
    echo "  </tbody></table>\n  ";
}
echo "    <form method=\"post\">\n        <table class=\"form\">\n            <tr>\n <Td class=\"fieldlabel\" style=\"width:200px;\">Credit/Currency  Precision : </Td>\n<Td class=\"fieldarea\">\n    <select name=\"precision\" onchange=\"callCurrencyPrecision(this.value);\">\n        <option ";
if ($config["precision"] == 2 || !$config["precision"]) {
    echo "selected";
}
echo " value=\"2\">Two</option>\n        <option ";
if ($config["precision"] == 3) {
    echo "selected";
}
echo "  value=\"3\">Three</option>\n    </select></Td>\n            </tr>\n<tr>\n    <td class=\"fieldlabel\">Reset service pricing</td>\n    <td class=\"fieldarea\">\n        <input type=\"button\" onclick=\"resetCurrencyPrice();\" name=\"resetprice\" value=\"Reset Currency Price\" />\n        <div style=\"clear: both;\">\n        <span>Reset service pricing accordingly default currency </span>\n        </div>\n    </td>\n</tr>\n\n        </table>\n    </form>\n</div></div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Currencies/?aid=13&cid=2&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/>Wiki Help</a></div>";
}
$fileverioncheck = "6.1.0";

?>