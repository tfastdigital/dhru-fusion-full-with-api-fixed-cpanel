<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getServiceStatus($groupid, $serviceid)
{
    global $conn;
    $q = $conn->query("select `status` from tbl_service_status\r\n    where groupid='" . $groupid . "' and serviceid='" . $serviceid . "'");
    $row = $q->fetch(PDO::FETCH_ASSOC);
    return $row["status"];
}
function updateServiceStatus($groupid, $productid, $status = "0")
{
    global $conn;
   
    $q = $conn->query("select servicestatusid from tbl_service_status\r\n    where groupid='" . $groupid . "' and serviceid='" . $productid . "'");
    $row = $q->fetch(PDO::FETCH_ASSOC);
    if (1==1) {
        $DATA["status"] = $status;
        updateData("tbl_service_status", $DATA, "groupid='" . $groupid . "' and serviceid='" . $productid . "'");
    } else {
        if ($groupid && $productid) {
            $DATA["groupid"] = $groupid;
            $DATA["serviceid"] = $productid;
            $DATA["status"] = $status;
            insertData("tbl_service_status", $DATA);
        }
    }
}
function getProductDetail($productid)
{
    global $conn;
    global $config;
    $CLIENTGROUPARR = getClientGroup();
    $CURRENCYARR = getCurrencies();
    $q = $conn->query("SELECT  id as productid,`sort`,purchase_cost,time,\r\n     (select value from tbl_apiservers\r\n    where gateway=API and setting='currency' limit 1) as apicurrencycode\r\n    ,(select value from tbl_apiservers\r\n    where gateway=API and setting='currency' limit 1) as apicurrencyid,\r\n    (select credits\r\n    from tbl_apiserversservices where tbl_apiserversservices.id=API_ID\r\n    and tbl_apiserversservices.gateway=API and \r\n    tbl_apiserversservices.type_id=API_TYPEID \r\n     and tbl_apiserversservices.type='Tool'\r\n    AND tbl_apiserversservices.useasserver=tbl_services_imei.useasserver limit 1 ) as apiprice\r\n    ,apiincrease,apiincreasetype\r\n    ,retailincrease,retailincreaseby,autoapi,service_name,retail,API\r\n     FROM tbl_services_imei where id='" . $productid . "'");
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $row["service_name"] = html_entity_decode($row["service_name"]);
    if ($row["apicurrencyid"]) {
        foreach ($_SESSION["currencyarr"] as $currencyid => $curdet) {
            if ($curdet["code"] == $row["apicurrencyid"]) {
                $row["apicurrencyid"] = $currencyid;
            }
        }
    }
    if (!$row["apicurrencyid"] || !$row["apiprice"]) {
        $row["cansetauto"] = true;
        
    } else {
        if ($row["apicurrencyid"] != $_SESSION["system_default_currency"]["id"]) {
            $row["apipriceinsystemcurrency"] = round($row["apiprice"] / $CURRENCYARR[$row["apicurrencyid"]]["rate"], 3);
        } else {
            $row["apipriceinsystemcurrency"] = round($row["apiprice"], 3);
        }
        $row["cansetauto"] = true;
    }
    $RETURN["product"] = $row;
    if ($row["autoapi"]) {
        $q = $conn->query("select * from tbl_pricing_qnt where \r\n         pricingqntid in (select distinct(pricingqntid) from tbl_group_api_price\r\n        where service_id='" . $productid . "')");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $r["display"] = $r["start"] . "-" . $r["end"];
            $RETURN["servicerange"][] = $r;
        }
    } else {
        $q = $conn->query("select * from tbl_pricing_qnt where \r\n        pricingqntid in (select distinct(pricingqntid) from tbl_service_pricing\r\n        where serviceid='" . $productid . "')");
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $r["display"] = $r["start"] . "-" . $r["end"];
            $RETURN["servicerange"][] = $r;
        }
    }
    $RETURN["sort"] = $row["sort"];
    foreach ($CURRENCYARR as $curid => $curdet) {
        $RETURN["pricing"][0]["base"]["currency"][$curid]["price"] = "";
        $RETURN["pricing"][0]["retail"]["currency"][$curid]["price"] = "";
    }
    foreach ($CLIENTGROUPARR as $grouparr) {
        $r["groupname"] = $grouparr["groupname"];
        $r["id"] = $grouparr["id"];
        foreach ($_SESSION["currencyarr"] as $curid => $curdet) {
            $RETURN["pricing"][0][$r["id"]]["currency"][$curid]["price"] = "";
        }
    }
    $qc = $conn->query("select * from tbl_service_pricing \r\n      where serviceid='" . $productid . "' and groupid='base'");
    $PricintArr = [];
    while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
        $RETURN["pricing"][$rc["pricingqntid"]]["base"]["currency"][$rc["currencyid"]]["price"] = $rc["price"];
        $PricintArr[$rc["pricingqntid"]] = $rc["pricingqntid"];
    }
    foreach ($CURRENCYARR as $curid => $curdet) {
        foreach ($PricintArr as $pricingqntid) {
            if (!$RETURN["pricing"][$pricingqntid]["retail"]["currency"][$curid]["price"]) {
                $RETURN["pricing"][$pricingqntid]["retail"]["currency"][$curid]["price"] = "";
            }
        }
    }
    $qc = $conn->query("select * from tbl_service_pricing \r\n      where serviceid='" . $productid . "' and groupid='retail'");
    $PricintArr = [];
    while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
        $RETURN["pricing"][$rc["pricingqntid"]]["retail"]["currency"][$rc["currencyid"]]["price"] = $rc["price"];
        $PricintArr[$rc["pricingqntid"]] = $rc["pricingqntid"];
    }
    foreach ($_SESSION["currencyarr"] as $curid => $curdet) {
        foreach ($PricintArr as $pricingqntid) {
            if (!$RETURN["pricing"][$pricingqntid]["base"]["currency"][$curid]["price"]) {
                $RETURN["pricing"][$pricingqntid]["base"]["currency"][$curid]["price"] = "";
            }
        }
    }
    if ($row["autoapi"]) {
        $qA = $conn->query("select value from tbl_apiservers\r\nWHERE gateway='" . $row["API"] . "' and setting='priceincrease'");
        $APIpricing = $qA->fetch(PDO::FETCH_ASSOC);
        if ($APIpricing["value"]) {
            $APIpricing = json_decode($APIpricing["value"], true);
        }
        $qc = $conn->query("select * from tbl_group_api_price \r\n    where service_id='" . $productid . "' and group_id in ('base','retail')");
        while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
            $groupapi = $conn->query("select price,increaseby from tbl_group_api_price\r\n                    WHERE service_id='" . $productid . "' and group_id='" . $rc["group_id"] . "'\r\n                     and pricingqntid='" . $rc["pricingqntid"] . "'");
            $groupapi = $groupapi->fetch(PDO::FETCH_ASSOC);
            $RETURN["pricing"][$rc["pricingqntid"]][$rc["group_id"]]["increment"]["value"] = $groupapi["price"];
            $RETURN["pricing"][$rc["pricingqntid"]][$rc["group_id"]]["increment"]["type"] = $groupapi["increaseby"];
        }
    }
    $RETURN["productids"] = $productid;
    $RETURN["basestatus"] = getservicestatus("base", $productid);
    $RETURN["retailstatus"] = getservicestatus("retail", $productid);
    $cnt = 1;
    foreach ($CLIENTGROUPARR as $grouparr) {
        $r["groupname"] = $grouparr["groupname"];
        $r["id"] = $grouparr["id"];
        $RETURN["clientgroup"][$r["id"]]["name"] = $r["groupname"];
        $RETURN["clientgroup"][$r["id"]]["status"] = getservicestatus($r["id"], $productid);
        $PricintArr = [];
        if ($row["autoapi"]) {
            $qc = $conn->query("select * from tbl_group_api_price \r\n           where service_id='" . $productid . "' and group_id='" . $r["id"] . "'");
            while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
                $groupapi = $conn->query("select price,increaseby from tbl_group_api_price                WHERE service_id='" . $productid . "' and group_id='" . $r["id"] . "'\r\n                 and pricingqntid='" . $rc["pricingqntid"] . "'");
                $groupapi = $groupapi->fetch(PDO::FETCH_ASSOC);
                $PricintArr[$rc["pricingqntid"]] = $rc["pricingqntid"];
                $RETURN["pricing"][$rc["pricingqntid"]][$r["id"]]["increment"]["value"] = $groupapi["price"];
                $RETURN["pricing"][$rc["pricingqntid"]][$r["id"]]["increment"]["type"] = $groupapi["increaseby"];
            }
            foreach ($PricintArr as $pricingqntid) {
                if (!$RETURN["pricing"][$pricingqntid][$r["id"]]["increment"]["value"]) {
                    $RETURN["pricing"][$pricingqntid][$r["id"]]["increment"]["value"] = "";
                    $RETURN["pricing"][$pricingqntid][$r["id"]]["increment"]["type"] = "";
                }
            }
        } else {
            $qc = $conn->query("select * from tbl_service_pricing \r\n      where serviceid='" . $productid . "' and groupid='" . $r["id"] . "'");
            while ($rc = $qc->fetch(PDO::FETCH_ASSOC)) {
                $RETURN["pricing"][$rc["pricingqntid"]][$r["id"]]["currency"][$rc["currencyid"]]["price"] = $rc["price"];
                $RETURN["pricing"][$rc["pricingqntid"]][$r["id"]]["display"] = $cnt++;
                $PricintArr[$rc["pricingqntid"]] = $rc["pricingqntid"];
            }
            foreach ($CURRENCYARR as $curid => $curdet) {
                foreach ($PricintArr as $pricingqntid) {
                    if (!$RETURN["pricing"][$pricingqntid][$r["id"]]["currency"][$curid]["price"]) {
                        $RETURN["pricing"][$pricingqntid][$r["id"]]["currency"][$curid]["price"] = "";
                    }
                }
            }
        }
    }
    $GROUPARR = array_merge($CLIENTGROUPARR, [["id" => "base"]], [["id" => "retail"]]);
    foreach ($GROUPARR as $groupdetail) {
        if (!$RETURN["pricing"][0][$groupdetail["id"]]["increment"]["value"] && $APIpricing[$groupdetail["id"]]["price"] && $APIpricing[$groupdetail["id"]]["increaseby"]) {
            $RETURN["pricing"][0][$groupdetail["id"]]["increment"]["value"] = $APIpricing[$groupdetail["id"]]["price"];
            $RETURN["pricing"][0][$groupdetail["id"]]["increment"]["type"] = $APIpricing[$groupdetail["id"]]["increaseby"];
            $RETURN["pricing"][0][$groupdetail["id"]]["increment"]["default"] = 1;
        }
    }
    return $RETURN;
}
function saveAPIIncreament($serviceid, $group, $price = "", $increaseby, $pricingqntid = 0)
{
    global $conn;
    $q = $conn->query("select id from tbl_group_api_price\r\n    where service_id='" . $serviceid . "' and group_id='" . $group . "'\r\n    and pricingqntid='" . $pricingqntid . "'");
    $row = $q->fetch(PDO::FETCH_ASSOC);
    if (0 < $row["id"]) {
        if (!$price) {
            $conn->query("DELETE from  tbl_group_api_price where id='" . $row["id"] . "'");
        } else {
            $DATA["price"] = $price;
            $DATA["increaseby"] = $increaseby;
            updateData("tbl_group_api_price", $DATA, "id='" . $row["id"] . "'");
            $LASTTIME["lastupdatedtime"] = time();
            updateData("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    } else {
        if ($price != "") {
            $DATA["service_id"] = $serviceid;
            $DATA["group_id"] = $group;
            $DATA["price"] = $price;
            $DATA["increaseby"] = $increaseby;
            $DATA["pricingqntid"] = $pricingqntid;
            insertData("tbl_group_api_price", $DATA);
            $LASTTIME["lastupdatedtime"] = time();
            $LASTTIME["prev_price"] = 1;
            updateData("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    }
}
function servicePricing($serviceid, $groupid, $price, $currencyid, $pricingqntid = "1")
{
    global $conn;
    global $config;
    global $tdata;
    $q = $conn->query("select pricingid,price from tbl_service_pricing where \r\n  groupid='" . $groupid . "' and serviceid='" . $serviceid . "' and currencyid='" . $currencyid . "'\r\n  and pricingqntid='" . $pricingqntid . "'");
    $row = $q->fetch(PDO::FETCH_ASSOC);
    if (0 < $row["pricingid"]) {
        if (!$price) {
            $DATA["serviceid"] = $serviceid;
            $DATA["currencyid"] = $currencyid;
            $DATA["groupid"] = $groupid;
            $DATA["price"] = $price;
            $DATA["pricingqntid"] = $pricingqntid;
            updateData("tbl_service_pricing", $DATA, "groupid='" . $groupid . "' and serviceid='" . $serviceid . "' and currencyid='" . $currencyid . "' and pricingqntid='" . $pricingqntid . "'");
            $LASTTIME["lastupdatedtime"] = time();
            $LASTTIME["prev_price"] = 1;
            updateData("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        } else {
            $DATA["serviceid"] = $serviceid;
            $DATA["currencyid"] = $currencyid;
            $DATA["groupid"] = $groupid;
            $DATA["price"] = $price;
            $DATA["pricingqntid"] = $pricingqntid;
            updateData("tbl_service_pricing", $DATA, "groupid='" . $groupid . "' and serviceid='" . $serviceid . "' and currencyid='" . $currencyid . "' and pricingqntid='" . $pricingqntid . "'");
            $LASTTIME["lastupdatedtime"] = time();
            $LASTTIME["prev_price"] = 1;
            updateData("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    } else {
        if ($price != "") {
            $DATA["serviceid"] = $serviceid;
            $DATA["currencyid"] = $currencyid;
            $DATA["groupid"] = $groupid;
            $DATA["price"] = $price;
            $DATA["pricingqntid"] = $pricingqntid;
            insertData("tbl_service_pricing", $DATA);
            $LASTTIME["lastupdatedtime"] = time();
            $LASTTIME["prev_price"] = 1;
            updateData("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    }
    if ($groupid == "base" && $currencyid == $_SESSION["system_default_currency"]["id"]) {
        $emojica = "💚";
        if ($row["price"] < $price) {
            $emojica = "🔺";
        }
        if ($config["slack_pricechange"] && $row["price"] != $price) {
            $servicename = $conn->query("select service_name from tbl_services_imei\r\nwhere id='" . $serviceid . "'");
            $servicename = $servicename->fetch(PDO::FETCH_ASSOC);
            $tdata .= "Service Price Update " . json_decode("\"" . $emojica . "\"") . "\n" . $servicename["service_name"] . "\nNew Price  <b>" . $price . "</b> " . $_SESSION["system_default_currency"]["code"] . "\n\n";
        }
    }
}
function sendTelegramFinalize()
{
    global $config;
    global $tdata;
    sendtoChannel($config["slack_pricechange"], urlencode($tdata) . "&parse_mode=html");
    unset($tdata);
}

?>