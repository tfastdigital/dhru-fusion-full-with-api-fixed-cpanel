<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
$limit = 1000;
$WHERE = " user_id='" . $_SESSION["uid"] . "'";
if ($action == "getadvanceorder") {
    $limit = 2000;
}
if ($type == "server") {
    $server = 1;
    $WHERE .= " and `server`='" . $server . "'";
} else {
    if ($type == "remote") {
        $server = 2;
        $WHERE .= " and `server`='" . $server . "'";
    } else {
        if ($type == "imei") {
            $server = 0;
            $WHERE .= " and `server`='" . $server . "'";
        } else {
            $type = "all";
        }
    }
}
if ($startdate && $enddate) {
    $WHERE .= " and (`date` between  '" . $startdate . "' and '" . $enddate . "') ";
}
if ($imei) {
}
$RETURN = [];
$ServiceArr = [];
$q = dquery("select id,service_name from tbl_services_imei");
while ($r = mysqli_fetch_assoc($q)) {
    $ServiceArr[$r["id"]]["name"] = $r["service_name"];
    $CustomField = mysqli_fetch_assoc(dquery("select \ngroup_concat(id) as customs,\ngroup_concat(fieldname) as customnames\n    from tbl_customfields where relid='" . $r["id"] . "' and `type`='serviceimei'"));
    $ServiceArr[$r["id"]]["customid"] = explode(",", $CustomField["customs"]);
    $ServiceArr[$r["id"]]["customname"] = explode(",", $CustomField["customnames"]);
}
mysqli_free_result($q);
$q = dquery("select order_id,encnum,imei,reply,service_id,`server`,user_can_c,(credit-discount) as credit,qnt,`date`\n,`time`,reply from tbl_order_imei where  " . $WHERE . "\n    order by order_id desc limit " . $limit);
while ($row = mysqli_fetch_assoc($q)) {
    $row["time"] = date("h:i A", $row["time"]);
    $row["type"] = $row["server"] == 0 ? "IMEI" : ($row["server"] == 1 ? "Server" : "Remote");
    $row["service"] = $ServiceArr[$row["service_id"]]["name"];
    $row["status"] = $row["user_can_c"] == 0 ? "New" : ($row["user_can_c"] == 1 ? "In Process" : ($row["user_can_c"] == 4 ? "Replied" : "Cancelled"));
    $row["reply"] = $row["reply"];
    unset($row["user_can_c"]);
    $DATA["order_id"] = $config["encryptedorderid"] ? $row["encnum"] : $row["order_id"];
    $DATA["date"] = $row["date"];
    $DATA["time"] = $row["time"];
    $DATA["type"] = $row["type"];
    $DATA["service"] = $row["service"];
    $DATA["credit"] = $row["credit"];
    if ($type != "imei" || $type == "all") {
        $DATA["qnt"] = $row["qnt"];
    }
    $DATA["status"] = $row["status"];
    $CustomID = $ServiceArr[$row["service_id"]]["customid"];
    $CustomField = $ServiceArr[$row["service_id"]]["customname"];
    $CustomBuff = "";
    foreach ($CustomID as $k => $customfieldid) {
        $Cq = mysqli_fetch_assoc(dquery("select `value` from tbl_customfieldsvalues \nwhere fieldid='" . $customfieldid . "' and relid='" . $row["order_id"] . "'"));
        if ($Cq["value"]) {
            $CustomBuff .= $CustomField[$k] . "=>" . $Cq["value"] . ",";
        }
    }
    $DATA["custom"] = trim($CustomBuff, ",");
    if ($type == "imei" || $type == "all") {
        $DATA["imei"] = $row["imei"];
    }
    $DATA["reply"] = strip_tags($row["reply"]);
    $RETURN[] = $DATA;
}
mysqli_free_result($q);
$Header = [];
$Header[] = $lng_languag["orderid"];
$Header[] = $lng_languag["date"];
$Header[] = $lng_languag["time"];
$Header[] = $lng_languag["type"];
$Header[] = $lng_languag["service"];
$Header[] = $lng_languag["price"];
if ($type != "imei" || $type == "all") {
    $Header[] = "Qty";
}
$Header[] = $lng_languag["status"];
$Header[] = $lng_languag["custom"];
if ($type == "imei" || $type == "all") {
    $Header[] = "IMEI";
}
$Header[] = $lng_languag["reply"];
if (1 < count($RETURN)) {
    $OUT["status"] = "success";
    $OUT["message"] = "Order History";
    $OUT["header"] = $Header;
    $OUT["data"] = $RETURN;
} else {
    $OUT["status"] = "error";
    $OUT["message"] = "No Result Found";
}
echo _josnOUT($OUT);

?>