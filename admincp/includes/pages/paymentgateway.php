<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n\n<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" onclick=\"getContect('#tab2','main2.php?page=paymentgateway','','','#tabcontent',true,'#main_loader');\" id=\"tab2\">Payment Gateways</a></li>\n\n    <li><a onclick=\"getContect('#tab22','main2.php?page=inactivegateway','','','#tabcontent',true,'#main_loader');\"\n           id=\"tab22\">+Add Gateways</a></li>\n\n    <div style=\"clear: both;\"></div>\n</ul>\n";
$pageid = 63;
checkPagePermission($pageid);
if ($_POST["action"] == "save" && isset($_POST["Deactivate"])) {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_paymentgateways` WHERE `gateway` = '" . $_POST["gateway"] . "'");
    echo "<p class=\"notification success\" >Payment Gateway Deactivated</p>";
}
$data_query = dquery("SELECT * FROM `tbl_paymentgateways`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $GatewayValues[$data["gateway"]][$data["setting"]] = $data["value"];
}
$data_query = NULL;
$data_query = dquery("SELECT * FROM `tbl_currencies`");
while ($data = mysqli_fetch_assoc($data_query)) {
    $currencies[$data["id"]] = $data["code"];
}
$data_query = NULL;
$dh = opendir("../modules/gateways/");
while (false !== ($file = readdir($dh))) {
    if (substr($file, -4, 4) == ".php" && is_file("../modules/gateways/" . $file) && $file != "index.php" && $file != "") {
        $_getdirname = explode(".", $file);
        $gwv_modulename = $_getdirname[0];
        require_once "../modules/gateways/" . $file;
        if ($GatewayValues[$gwv_modulename]["active"]) {
            $ActiveGateways[] = $gwv_modulename;
        } else {
            $DisabledGateways[] = $gwv_modulename;
            asort($DisabledGateways);
        }
        if (function_exists($gwv_modulename . "_config")) {
            $GatewayConfig[$gwv_modulename] = call_user_func($gwv_modulename . "_config");
        } else {
            $GatewayFieldDefines = [];
            $GatewayFieldDefines["name"] = ["Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "visiblename"]];
            if ($GATEWAYMODULE[$gwv_modulename . "notes"]) {
                $GatewayFieldDefines["notes"] = ["Type" => "System", "Value" => $GATEWAYMODULE[$gwv_modulename . "notes"]];
            }
            call_user_func($gwv_modulename . "_activate");
            $GatewayConfig[$gwv_modulename] = $GatewayFieldDefines;
        }
    }
}
closedir($dh);
if ($_POST["action"] == "activate") {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_paymentgateways` WHERE `gateway` = '" . $gateway . "'");
    $data["gateway"] = $gateway;
    $data["setting"] = "active";
    $data["value"] = 1;
    $data["order"] = 0;
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "visible";
    $data["value"] = 1;
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "curcode";
    $data["value"] = "";
    $db->insert("tbl_paymentgateways", $data);
    $data["setting"] = "convertto";
    $data["value"] = "";
    $db->insert("tbl_paymentgateways", $data);
    foreach ($GatewayConfig[$gateway] as $key => $val) {
        $data["setting"] = $key;
        if ($key == "name" || $key == "notes") {
            $data["value"] = $val["Value"];
        } else {
            $data["value"] = "";
        }
        $db->insert("tbl_paymentgateways", $data);
    }
    $data = NULL;
    echo "<p class=notification success>" . $LNG["payment"] . " " . $LNG["gateway"] . " " . $LNG["activated"] . "</p>";
    exit;
} else {
    if ($_POST["action"] == "save" && isset($_POST["Save"])) {
        $_POST["field"]["convertto"] = $_POST["field"]["curcode"];
        $_POST["field"]["curcode"] = $currencies[$_POST["field"]["curcode"]];
        foreach ($_POST["field"] as $setting => $value) {
            dquery("UPDATE `tbl_paymentgateways` SET `value`= '" . $value . "' WHERE `setting`= '" . $setting . "' AND `gateway`= '" . $_POST["gateway"] . "'");
        }
        echo "<p class=notification success>" . $LNG["payment"] . " " . $LNG["gateway"] . " " . $LNG["save"] . " " . $LNG["successfully"] . "</p>";
    }
    echo "<div id=\"content\" class=\"mt-2\">\n\n<div  class=\"groupstabes\">\n\n  <div class=\"groupstabescontant\">\n";
    echo "<table id=\"main_tbl\">\n      <thead>\n      <tr>\n          <th>" . $LNG["api"] . " " . $LNG["server"] . " " . $LNG["name"] . "</th>\n          <th align=\"right\"><div align=\"right\">" . $LNG["action"] . "</div></th>\n      </tr>\n      </thead> \n      <tbody>";
    $data = NULL;
    $data_query = dquery("SELECT * FROM `tbl_paymentgateways` WHERE `setting`='name' ORDER BY `order`");
    while ($data = mysqli_fetch_assoc($data_query)) {
        echo "<tr><td>" . $data["value"] . "</td><td align=\"right\"><div align=\"right\"><a class=\"default_dg_a2 editdata\" href=\"javascript:load_subpage('main2.php?page=paymentgateway.edit&id=" . $data["gateway"] . "','" . $LNG["edit"] . " " . $LNG["gateway"] . "')\" >" . $LNG["edit"] . "</a></div></td></tr>";
    }
    $data_query = NULL;
    echo "</tbody></table></div></div>\n";
    $fileverioncheck = "6.1.0";
}
function GatewayField($gateway, $type, $name, $defaultvalue, $friendlyname, $size, $description = "")
{
    global $GatewayFieldDefines;
    if ($type == "dropdown") {
        $options = $description;
        $description = "";
    } else {
        $options = "";
    }
    $GatewayFieldDefines[$name] = ["FriendlyName" => $friendlyname, "Type" => $type, "Size" => $size, "Description" => $description, "Value" => $defaultvalue, "Options" => $options];
}

?>