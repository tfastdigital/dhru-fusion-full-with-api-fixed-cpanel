<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/serverservices.fun.php";
require_once "includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
$row = mysqli_fetch_assoc(dquery("select credit,promotiondis from tbl_server_log where id=" . $id));
if ($savecurrency) {
    checkDemoMode(false);
    if ($row["credit"] != $credit) {
        if ($credit - $row["promotiondis"] < 0) {
            dquery("UPDATE tbl_server_log set promotiondis='',happy_hours_start='',\n        happy_hours_end='',happy_hours_weekdays='' where id='" . $id . "'");
        }
        $data["credit"] = formatCurrency2($credit);
        $row = mysqli_fetch_assoc(dquery("select credit from tbl_server_log where id=" . $id));
        $data["prev_price"] = $row["credit"];
        $db->update("tbl_server_log", $data, "id=" . $id);
        $data = NULL;
        $cid = $_SESSION["system_default_currency"]["id"];
        $CIDS = dquery("select id from tbl_client_group");
        while ($RCID = mysqli_fetch_assoc($CIDS)) {
            $Gdet = mysqli_fetch_assoc(dquery("select discount from tbl_client_group_price\n         WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server' AND \n         currency_id='" . $cid . "'"));
            $disco = $Gdet["discount"] + $credit - $row["credit"];
            if (!$groupforce) {
                dquery("UPDATE `tbl_client_group_price` SET `discount` = '" . $disco . "' \n                WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server' \n                AND currency_id='" . $cid . "'");
            }
            if ($change && 0 < $Gdet["discount"]) {
                $cgroup[$RCID["id"]][$cid] = $credit;
                dquery("DELETE FROM tbl_client_group_price where \n               group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND \n               `service_type` ='server' AND currency_id='" . $cid . "'");
            }
            if ($groupforce) {
                dquery("update  tbl_client_group_price set discount='0' \nwhere `service_id` ='" . $id . "' AND `service_type` ='imei' AND \ncurrency_id='" . $cid . "'");
            }
        }
        $cid = NULL;
        $disco = NULL;
        if ($update == 1 || $change == 1) {
            if ($currency) {
                foreach ($currency as $key => $value) {
                    $get = mysqli_fetch_assoc(dquery("select credit from tbl_server_credit \n         where currency_id='" . $key . "' and service_id='" . $id . "'"));
                    if ($get["credit"] != $value) {
                        $changed[$key] = $value;
                        if (!$value) {
                            $remove[$key] = 1;
                        }
                    }
                }
            }
            if (!$groupforce) {
                changeSUserDiscount($id, $row["credit"], $credit, $changed, $remove, $change);
            }
        }
    } else {
        if ($update == 1 || $change == 1) {
            if ($currency) {
                foreach ($currency as $key => $value) {
                    $get = mysqli_fetch_assoc(dquery("select credit from \n                    tbl_server_credit  where currency_id='" . $key . "' and service_id='" . $id . "'"));
                    if ($get["credit"] != $value) {
                        $changed[$key] = $value;
                        if (!$value) {
                            $remove[$key] = 1;
                        }
                    }
                }
            }
            if (!$groupforce) {
                changeSUserDiscount($id, $row["credit"], $row["credit"], $changed, $remove, $change);
            }
        }
    }
    if ($currency) {
        foreach ($currency as $key => $value) {
            $data = NULL;
            $data["service_id"] = $id;
            $data["currency_id"] = $key;
            $data["credit"] = formatCurrency2($value);
            $numrows = mysqli_num_rows(dquery("select * from tbl_server_credit where\n          service_id='" . $id . "' and currency_id='" . $key . "'"));
            if ($numrows != "0" && 0 < $value) {
                $db->update("tbl_server_credit", $data, "service_id=" . $id . " and currency_id=" . $key);
                $cid = $key;
                $CIDS = dquery("select id from tbl_client_group");
                while ($RCID = mysqli_fetch_assoc($CIDS)) {
                    $Gdet = mysqli_fetch_assoc(dquery("select discount from tbl_client_group_price\n         WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server' AND\n          currency_id='" . $cid . "'"));
                    $disco = $Gdet["discount"] + $value - $row["credit"];
                    if (!$groupforce) {
                        dquery("UPDATE `tbl_client_group_price` SET `discount` = '" . $disco . "' \n         WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server' \n         AND currency_id='" . $cid . "'");
                    }
                }
                $cid = NULL;
                $disco = NULL;
            } else {
                if ($value == "0" || $value == "") {
                    dquery("delete from tbl_server_credit where service_id=" . $id . " and currency_id=" . $key);
                } else {
                    if (0 < $value) {
                        $db->insert("tbl_server_credit", $data);
                    }
                }
            }
        }
    }
    $discount = NULL;
    $data = NULL;
    if ($cgroup) {
        foreach ($cgroup as $c => $v) {
            logActivityGlobal("Server Client Group[" . $c . "] Price Update", "editservice", "", "admin");
            foreach ($v as $k => $p) {
                $quser = dquery("select id from tblUsers where client_group='" . $c . "' \n            and default_currency='" . $k . "' and usertype!='3'");
                $numrows = dquery("select * from tbl_server_credit \n where service_id='" . $id . "' and currency_id='" . $k . "'");
                if (mysqli_num_rows($numrows)) {
                    $d = mysqli_fetch_assoc($numrows);
                    $price = $d["credit"];
                } else {
                    $svp = mysqli_fetch_assoc(dquery("select credit from tbl_server_log where id='" . $id . "'"));
                    $price = convertCurrency($svp["credit"], $_SESSION["system_default_currency"]["id"], $k);
                }
                $pricy[$c][$k] = $price;
                $discount = $pricy[$c][$k] - $cgroup[$c][$k];
                while ($ruser = mysqli_fetch_assoc($quser)) {
                    $qdis = dquery("select * from tbl_discount_server_log \n                    where user_id='" . $ruser["id"] . "' and service_id='" . $id . "'");
                    if (mysqli_num_rows($qdis)) {
                        $ddis["discount"] = $discount;
                        $db->update("tbl_discount_server_log", $ddis, "user_id='" . $ruser["id"] . "' AND\n                    service_id='" . $id . "'");
                        $ddis = NULL;
                    } else {
                        $ddis["discount"] = $discount;
                        $ddis["user_id"] = $ruser["id"];
                        $ddis["service_id"] = $id;
                        $db->insert("tbl_discount_server_log", $ddis);
                        $ddis = NULL;
                    }
                }
                if (!$groupforce) {
                    $rows = mysqli_num_rows(dquery("select * from tbl_client_group_price where \n            `group_id` ='" . $c . "' AND `service_id` ='" . $id . "' AND service_type='server'\n             AND currency_id='" . $k . "'"));
                    if (!$rows) {
                        $data2["discount"] = $discount;
                        $data2["group_id"] = $c;
                        $data2["service_id"] = $id;
                        $data2["service_type"] = "server";
                        $data2["currency_id"] = $k;
                        $db->insert("tbl_client_group_price", $data2);
                        unset($data2);
                    } else {
                        dquery("UPDATE `tbl_client_group_price` SET `discount` = '" . $discount . "' \n                    WHERE `group_id` ='" . $c . "' AND `service_id` ='" . $id . "' AND `service_type` ='server'\n                    AND currency_id='" . $k . "'");
                    }
                } else {
                    dquery("DELETE FROM tbl_client_group_price where \n        group_id='" . $c . "' and `service_id` ='" . $id . "' AND \n        `service_type` ='server' AND currency_id='" . $k . "' and discount<0");
                }
            }
        }
    }
    if ($currency) {
        foreach ($currency as $key => $value) {
            $numrows = mysqli_num_rows(dquery("select * from tbl_server_credit where service_id='" . $id . "'\n          and currency_id='" . $key . "'"));
            if ($numrows != "0" && 0 < $value) {
                $cid = $key;
                $CIDS = dquery("select id from tbl_client_group");
                while ($RCID = mysqli_fetch_assoc($CIDS)) {
                    $Gdet = mysqli_fetch_assoc(dquery("select discount from tbl_client_group_price\n                    WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server' AND\n                    currency_id='" . $cid . "'"));
                    $disco = $Gdet["discount"] + $value - $row["credit"];
                    if ($change && 0 < $Gdet["discount"]) {
                        dquery("DELETE FROM tbl_client_group_price where \n                        group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND \n                        `service_type` ='server' AND currency_id='" . $cid . "'");
                    }
                    if ($groupforce && $value < $Gdet["discount"]) {
                        dquery("DELETE FROM tbl_client_group_price where \n                        group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND \n                        `service_type` ='server' AND currency_id='" . $cid . "'");
                    }
                }
                $cid = NULL;
                $disco = NULL;
            }
        }
    }
    $key = $_SESSION["system_default_currency"]["id"];
    $cid = $key;
    $CIDS = dquery("select id from tbl_client_group");
    while ($RCID = mysqli_fetch_assoc($CIDS)) {
        $Gdet = mysqli_fetch_assoc(dquery("select discount from tbl_client_group_price\n         WHERE group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND `service_type` ='server'\n          AND currency_id='" . $cid . "'"));
        $disco = $Gdet["discount"] + $value - $row["credit"];
        if ($change && 0 < $Gdet["discount"]) {
            dquery("DELETE FROM tbl_client_group_price where \n               group_id='" . $RCID["id"] . "' and `service_id` ='" . $id . "' AND \n               `service_type` ='server' AND currency_id='" . $cid . "'");
        }
    }
    if ($groupforce) {
        dquery("update tbl_client_group_price set discount='0' \n        where `service_id` ='" . $id . "' AND `service_type` ='server'");
    }
    $cid = NULL;
    $disco = NULL;
    echo "<div id=notification1 class=successbox>" . $LNG["datasavesuccessfully"] . " </div>";
}
$md5id = md5($id);
$serverDetails = getServerServices("", $md5id);
echo "<script>\nfunction checkset(obj){\n\n\n\tif(obj.id=='update'){\n\t\tdocument.getElementById('change').checked=false;\n        document.getElementById('groupforce').checked=false;\n\t}else if(obj.id=='groupforce'){\n\t\tdocument.getElementById('change').checked=false;\n        document.getElementById('update').checked=false;\n    }else{\n\t    document.getElementById('groupforce').checked=false;\n        document.getElementById('update').checked=false;\n\t}\n}\n</script>\n";
if ($row["promotiondis"]) {
    echo "<div id=\"notification1\" class=\"errorbox\">";
    echo $LNG["service"];
    echo " ";
    echo $LNG["under"];
    echo " ";
    echo $LNG["happy"];
    echo " ";
    echo $LNG["hours"];
    echo ". ";
    echo $LNG["reset"];
    echo " ";
    echo $LNG["discount"];
    echo " ";
    echo $LNG["after"];
    echo " ";
    echo $LNG["price"];
    echo " ";
    echo $LNG["change"];
    echo "</div>\n";
}
echo "<form id=\"frmnetwork\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n<input type=\"hidden\" value=\"true\" name=\"curs\" />\n";
echo generate_token("form");
echo "\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["service"];
echo " ";
echo $LNG["price"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\">\n\n<tr>\n<td class=\"fieldlabel\">";
echo $_SESSION["system_default_currency"]["code"];
echo "*</td><td class=\"fieldarea\"><input type='text'  style=\"float: left;\"\nname=\"credit\" value=\"";
echo $serverDetails["credit"];
echo "\" /></td>\n</tr>\n</table>\n\n</div></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
echo $LNG["manage"];
echo " ";
echo $LNG["other"];
echo " ";
echo $LNG["currency"];
echo "</span>\n\n  </h2>\n  <div class=\"groupstabescontant\">\n\n";
$default_currency = mysqli_fetch_assoc(dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default = '1'"));
$result = dquery("SELECT code, id FROM tbl_currencies WHERE tbl_currencies.default <> '1'");
echo "<table id=\"main_tbl\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["currency"];
echo "</th><th>";
echo $LNG["currency"];
echo "                ";
echo $LNG["value"];
echo "</th><th>";
echo $LNG["converted"];
echo " ";
echo $LNG["credit"];
echo "</th> <th></th>\n              </tr>\n            </thead>\n            <tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $credit = mysqli_fetch_assoc(dquery("select credit from tbl_server_credit where \n    service_id=" . $id . " and currency_id=" . $row["id"]));
    $numrows = mysqli_num_rows(dquery("select credit from tbl_server_credit where\n     service_id=" . $id . " and currency_id=" . $row["id"]));
    if ($numrows) {
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text  name=currency[" . $row["id"] . "] \n        value=" . $credit["credit"] . "></td><td></td><td></td></tr>";
    } else {
        $convertAmount = convertCurrency($serverDetails["credit_admin"], $default_currency["id"], $row["id"]);
        echo "<tr><td>" . $row["code"] . "</td><td><input type=text name=currency[" . $row["id"] . "]>\n        </td><td><span>" . $convertAmount . "</span></td><td></td></tr>";
    }
}
echo "<tr>\n<td   colspan=\"4\"  style=\"text-align: left !important;\"><input type='checkbox' id='update' onclick=\"checkset(this);\" checked=\"checked\" name='update' value='1' /><label for=\"update\"> Do not change custom discounted price.<small> (e.g. some user have special price for this service will not affected).</small></label>\n<br />\n<input type='checkbox' id='change' name='change'  onclick=\"checkset(this);\" value='1' /><label for=\"change\"> Auto update custom price if new price is lower then user's custom price or client group custom price. <small> (e.g. current user custom price is 50 and Service new price is 40 then auto update this user price to 40)</small></label>\n\n\n<br />\n<input type='checkbox' id='groupforce' name='groupforce'\nonclick=\"checkset(this);\" value='1' />\n<label for=\"groupforce\"> Auto update Client group price as\n per new price force fully</label>\n\n\n</td>\n</tr>\n</tbody></table>\n</div></div>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["clientgroup"];
echo " ";
echo $LNG["price"];
echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\">\n <thead>\n<tr>\n<th>&nbsp;</th>\n<th>";
echo $_SESSION["system_default_currency"]["code"];
echo "</th>\n";
$cn = dquery("select * from tbl_currencies where `default`!='1'");
while ($rd = mysqli_fetch_assoc($cn)) {
    echo "<th>";
    echo $rd["code"];
    echo "</th>\n";
}
echo "<th></th>\n</tr>\n</thead>\n ";
$cn = dquery("select * from tbl_client_group order by id asc");
while ($rd = mysqli_fetch_assoc($cn)) {
    $bprice = mysqli_fetch_assoc(dquery("select discount from \ntbl_client_group_price where service_type='server' and group_id='" . $rd["id"] . "' \nand service_id='" . $id . "' and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'"));
    echo "<tr>\n<td>";
    echo $rd["groupname"];
    echo "</td>\n<td>\n<input type=\"hidden\" name=\"pricy[";
    echo $rd["id"];
    echo "][";
    echo $_SESSION["system_default_currency"]["id"];
    echo "]\"\n value=\"";
    echo $serverDetails["credit"];
    echo "\" />\n<input type='text'  name=\"cgroup[";
    echo $rd["id"];
    echo "][";
    echo $_SESSION["system_default_currency"]["id"];
    echo "]\"\nvalue=\"";
    echo $serverDetails["credit"] - $bprice["discount"];
    echo "\" /></td>\n";
    $ct = dquery("select * from tbl_currencies where `default`!='1'");
    while ($rt = mysqli_fetch_assoc($ct)) {
        $credit = mysqli_fetch_assoc(dquery("select credit from \ntbl_server_credit where service_id='" . $id . "' and\ncurrency_id='" . $rt["id"] . "'"));
        if ($credit["credit"]) {
            $orig = $credit["credit"];
        } else {
            $orig = round($serverDetails["credit"] * $rt["rate"], 2);
        }
        $bprice = mysqli_fetch_assoc(dquery("select discount from \ntbl_client_group_price where service_type='server' and group_id='" . $rd["id"] . "' \nand service_id='" . $id . "' and currency_id='" . $rt["id"] . "'"));
        echo "<td>\n<input type=\"hidden\" name=\"pricy[";
        echo $rd["id"];
        echo "][";
        echo $rt["id"];
        echo "]\"\n value=\"";
        echo $orig;
        echo "\" />\n<input type='text'  name=\"cgroup[";
        echo $rd["id"];
        echo "][";
        echo $rt["id"];
        echo "]\"\nvalue=\"";
        echo $orig - $bprice["discount"];
        echo "\" /></td>\n";
    }
    echo "<td></td>\n</tr>\n";
}
echo "</table>\n\n\n</div></div>\n\n<p class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" name=\"savecurrency\" class=\"btn save\" id=\"btnedituser\"\n    class=\"submit\" type=\"submit\" />\n</p>\n\n</form>";
$fileverioncheck = "6.1.0";

?>