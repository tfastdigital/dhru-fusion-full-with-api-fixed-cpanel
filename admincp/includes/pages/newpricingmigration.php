<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (mysqli_num_rows(dquery("select id from tbl_services_imei")) != 0 && mysqli_num_rows(dquery("select pricingid from tbl_service_pricing")) == 0) {
    if ($submit && $agree) {
        dquery("TRUNCATE tbl_discount_imei");
        $q = dquery("select id,groupname from tbl_client_group");
        $ClientGroup = [];
        while ($r = mysqli_fetch_assoc($q)) {
            $ClientGroup[$r["id"]] = $r["id"];
        }
        $q = dquery("select credit,id,active,apiincrease,retailincrease,retailincreaseby,apiincreasetype,autoapi from tbl_services_imei");
        while ($r = mysqli_fetch_assoc($q)) {
            $DATA["groupid"] = "base";
            $DATA["price"] = $r["credit"];
            $DATA["serviceid"] = $r["id"];
            $DATA["currencyid"] = $_SESSION["system_default_currency"]["id"];
            $DATA["price"] = $r["credit"];
            $db->insert("tbl_service_pricing", $DATA);
            unset($DATA);
            if ($r["active"]) {
                if ($r["autoapi"]) {
                    if (0 < $r["apiincrease"]) {
                        $DATAG["service_id"] = $r["id"];
                        $DATAG["group_id"] = "base";
                        $DATAG["increaseby"] = $r["apiincreasetype"];
                        $DATAG["price"] = $r["apiincrease"];
                        $db->insert("tbl_group_api_price", $DATAG);
                        unset($DATAG);
                    }
                    if (0 < $r["retailincrease"]) {
                        $DATAG["service_id"] = $r["id"];
                        $DATAG["group_id"] = "retail";
                        $DATAG["increaseby"] = $r["retailincreaseby"];
                        $DATAG["price"] = $r["retailincrease"];
                        $db->insert("tbl_group_api_price", $DATAG);
                        unset($DATAG);
                    }
                }
                $DATAG["groupid"] = "base";
                $DATAG["serviceid"] = $r["id"];
                $DATAG["status"] = 1;
                $db->insert("tbl_service_status", $DATAG);
                unset($DATAG);
                $DATAG["groupid"] = "retail";
                $DATAG["serviceid"] = $r["id"];
                $DATAG["status"] = 1;
                $db->insert("tbl_service_status", $DATAG);
                unset($DATAG);
                foreach ($ClientGroup as $clientgroupid) {
                    $DATAG["groupid"] = $clientgroupid;
                    $DATAG["serviceid"] = $r["id"];
                    $DATAG["status"] = 1;
                    $db->insert("tbl_service_status", $DATAG);
                    unset($DATAG);
                    $CGp = mysqli_fetch_assoc(dquery("select discount from tbl_client_group_price\r\n                WHERE group_id='" . $clientgroupid . "' and service_id='" . $r["id"] . "'\r\n                and currency_id='" . $_SESSION["system_default_currency"]["id"] . "'\r\n                and service_type='imei'"));
                    unset($DATA);
                    if (0 < $r["credit"] - $CGp["discount"] && $r["autoapi"] == 0) {
                        $DATA["groupid"] = $clientgroupid;
                        $DATA["price"] = $r["credit"] - $CGp["discount"];
                        $DATA["serviceid"] = $r["id"];
                        $DATA["currencyid"] = $_SESSION["system_default_currency"]["id"];
                        $db->insert("tbl_service_pricing", $DATA);
                        unset($DATA);
                    }
                }
            }
        }
        echo "    <form method=\"post\" action=\"main.php\">\r\n        <h1>Migration successful</h1> <br />\r\n        <input type=\"submit\" name=\"continue\" value=\"Continue\" />\r\n    </form>\r\n    ";
        exit;
    }
    echo "<h1>  Pricing structure migration</h1> <br />\r\n<ul style=\"margin-left: 20px\">\r\n    <li> All current client group other than base currency pricing will be reset. </li>\r\n    <li>All custom clients price will be reset to base price. </li>\r\n    <li>All auto update pricing from APi margins will be reset. </li>\r\n</ul>\r\n\r\n<br/>\r\n<small>In short all other currency custom pricing will be reset to base price.</small>\r\n\r\n<br/>\r\n<br/>\r\n<form method=\"post\">\r\n    <lable><input type=\"checkbox\" name=\"agree\" value=\"1\" />Ok I Understand </lable>\r\n    <div style=\"margin: 15px 0\"> <input type=\"submit\" name=\"submit\" value=\"Click to Continue\" /></div>\r\n</form>\r\n";
} else {
    echo "<h2>You have already migrated</h2>";
    exit;
}

?>