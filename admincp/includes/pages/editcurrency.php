<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"content-type\" content=\"text/html; charset=";
echo $config["charset"];
echo "\" />\n</head>\n<body>\n";
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
require_once "includes/currency.fun.php";
if ($save) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode.</div>";
        exit;
    }
    $def1 = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1'"));
    $data["code"] = $code;
    $data["prefix"] = html_entity_decode($prefix);
    $data["suffix"] = html_entity_decode($suffix);
    $data["rate"] = $rate;
    $data["format"] = $format;
    if ($dontupdate) {
        $data["dontupdate"] = 1;
    } else {
        $data["dontupdate"] = 0;
    }
    if ($client) {
        dquery("update tbl_currencies set client='0' where client='1'");
        $data["client"] = $client;
    }
    if ($default) {
        $data["default"] = $default;
        saveSettings("base_currency", $code);
    }
    if ($db->update("tbl_currencies", $data, "id=" . $edit)) {
        logActivityGlobal("Currency Updated Rate : " . $rate, "currency", "", "admin");
        if ($default == 1) {
            dquery("UPDATE `tbl_currencies` SET `default`='1' WHERE `id`='" . $edit . "'");
            dquery("UPDATE `tbl_currencies` SET `default`='0' WHERE `id`!='" . $edit . "'");
            dquery("UPDATE `tbl_currencies` SET `rate`='1' WHERE `id`='" . $edit . "'");
            dquery("UPDATE `tbl_currencies` SET `rate`='0' WHERE `id`!='" . $edit . "'");
            getCurrencyRates();
            $def = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies` WHERE `default`='1'"));
            $imei = dquery("SELECT `credit`,`service_name`,`id`,`promotiondis` FROM `tbl_services_imei`");
            while ($rows = mysqli_fetch_assoc($imei)) {
                $data = NULL;
                if ($rows["promotiondis"]) {
                    $promo = convertCurrency($rows["promotiondis"], $def1["id"], $def["id"]);
                    $data["promotiondis"] = $promo;
                }
                $amt = convertCurrency($rows["credit"], $def1["id"], $def["id"]);
                $data["credit"] = $amt;
                $db->update("tbl_services_imei", $data, "id='" . $rows["id"] . "'");
                $data = NULL;
            }
            $imei = dquery("SELECT `credit`,`service_name`,`id`,`promotiondis` FROM `tbl_services_file`");
            while ($rows = mysqli_fetch_assoc($imei)) {
                $data = NULL;
                if ($rows["promotiondis"]) {
                    $promo = convertCurrency($rows["promotiondis"], $def1["id"], $def["id"]);
                    $data["promotiondis"] = $promo;
                }
                $amt = convertCurrency($rows["credit"], $def1["id"], $def["id"]);
                $data["credit"] = $amt;
                $db->update("tbl_services_file", $data, "id='" . $rows["id"] . "'");
                $data = NULL;
            }
            $imei = dquery("SELECT `credit`,`service_name`,`id`,`promotiondis` FROM `tbl_server_log`");
            while ($rows = mysqli_fetch_assoc($imei)) {
                $data = NULL;
                if ($rows["promotiondis"]) {
                    $promo = convertCurrency($rows["promotiondis"], $def1["id"], $def["id"]);
                    $data["promotiondis"] = $promo;
                }
                $amt = convertCurrency($rows["credit"], $def1["id"], $def["id"]);
                $data["credit"] = $amt;
                $db->update("tbl_server_log", $data, "id='" . $rows["id"] . "'");
                $data = NULL;
            }
            $imei = dquery("SELECT `credit`,`service_name`,`id`,`promotiondis` FROM `tbl_products`");
            while ($rows = mysqli_fetch_assoc($imei)) {
                $data = NULL;
                if ($rows["promotiondis"]) {
                    $promo = convertCurrency($rows["promotiondis"], $def1["id"], $def["id"]);
                    $data["promotiondis"] = $promo;
                }
                $amt = convertCurrency($rows["credit"], $def1["id"], $def["id"]);
                $data["credit"] = $amt;
                $db->update("tbl_products", $data, "id='" . $rows["id"] . "'");
                $data = NULL;
            }
            dquery("DELETE FROM tbl_imei_credit WHERE currency_id='" . $def["id"] . "' ");
            dquery("DELETE FROM tbl_file_credit WHERE currency_id='" . $def["id"] . "' ");
            dquery("DELETE FROM tbl_server_credit WHERE currency_id='" . $def["id"] . "' ");
            dquery("DELETE FROM tbl_product_credit WHERE currency_id='" . $def["id"] . "' ");
        }
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
}
$sql = mysqli_fetch_assoc(dquery("SELECT * FROM tbl_currencies WHERE id='" . $edit . "'"));
echo "\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmbrand\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/> \n";
echo generate_token("form");
echo " \n\n<table class='form' style=\"display: table;\"> \n<tbody>\n<tr><td class=\"fieldlabel\">";
echo $LNG["code"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"code\" value=\"";
echo $sql["code"];
echo "\" /> </td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["prefix"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"prefix\" value=\"";
echo $sql["prefix"];
echo "\" /> </td></tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["suffix"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"suffix\" value=\"";
echo $sql["suffix"];
echo "\" /> </td></tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["format"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n        <select name=\"format\">\n            <option value=\"1\" ";
if ($sql["format"] == 1) {
    echo "selected";
}
echo ">1000.99</option>\n            <option value=\"2\" ";
if ($sql["format"] == 2) {
    echo "selected";
}
echo ">1,000.99</option>\n            <option value=\"3\" ";
if ($sql["format"] == 3) {
    echo "selected";
}
echo ">1,000,99</option>\n            <option value=\"4\" ";
if ($sql["format"] == 4) {
    echo "selected";
}
echo ">1,000</option>\n        </select>\n    </span></td>\n</tr>\n\n<tr><td class=\"fieldlabel\">";
echo $LNG["rate"];
echo "</td><td class=\"fieldarea\"><input type=\"text\" name=\"rate\" value=\"";
echo $sql["rate"];
echo "\" /> </td></tr>\n";
if ($sql["default"] == 0) {
    echo "<tr><td class=\"fieldlabel\">";
    echo $LNG["default"];
    echo "</td><td class=\"fieldarea\">\n\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"default\" value=\"1\" ";
    if ($sql["default"] == 1) {
        echo "checked";
    }
    echo " id=\"default\" /><label for=\"default\"></label> \n\n</tr>\n    <tr><td class=\"fieldlabel\">";
    echo $LNG["client"];
    echo " ";
    echo $LNG["default"];
    echo "</td><td class=\"fieldarea\">\n\n            <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"client\" value=\"1\" ";
    if ($sql["client"] == 1) {
        echo "checked";
    }
    echo " id=\"defaults\" /><label for=\"defaults\"></label>\n\n    </tr>\n";
}
echo "</tr>\n<tr><td class=\"fieldlabel\">";
echo $LNG["do"];
echo " ";
echo $LNG["not"];
echo " ";
echo $LNG["auto"];
echo " ";
echo $LNG["update"];
echo " ";
echo $LNG["exchange"];
echo " ";
echo $LNG["rate"];
echo "</td><td class=\"fieldarea\">\n\n        <input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"dontupdate\" value=\"1\" ";
if ($sql["dontupdate"] == 1) {
    echo "checked";
}
echo " id=\"ddefaults\" /><label for=\"ddefaults\"></label>\n\n</tr>\n </tbody></table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" type=\"submit\" name=\"save\"  class=\"btn save\"/>\n</div>\n\n</form> \n</div></div>\n</body>\n</html>";
$fileverioncheck = "6.1.0";

?>