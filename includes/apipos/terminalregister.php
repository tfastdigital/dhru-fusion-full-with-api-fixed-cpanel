<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$Sql = dquery("select * from tbl_pos_terminal where serialno='" . $serialno . "' and userid='" . $userid . "'");
$PosTermial = mysqli_fetch_assoc($Sql);
if ($PosTermial["posterminalid"]) {
    $AccoutInfo["credit"] = formatCurrency($UserDetails["credit"]["credit"], $UserDetails["currency"]);
    $AccoutInfo["creditraw"] = round($UserDetails["credit"]["credit"], 3);
    $AccoutInfo["mail"] = $UserDetails["email"];
    $AccoutInfo["currency"] = $UserDetails["currency"]["code"];
    $AccoutInfo["terminalid"] = $PosTermial["posterminalid"];
    $AccoutInfo["company"] = $UserDetails["companyname"];
    $AccoutInfo["gcmid"] = $UserDetails["gcmid"];
    $AccoutInfo["clientgroup"] = $UserDetails["groupname"] ? $UserDetails["groupname"] : "Base";
    $AccoutInfo["rewardpoint"] = $config["rewardpoint"];
    $AccoutInfo["imei"] = $config["default_service_imei"];
    $AccoutInfo["server"] = $config["default_service_server"];
    $AccoutInfo["remote"] = $config["default_service_remote"];
    $AccoutInfo["voucher"] = $config["voucher"];
    if (!$UserDetails["access"]["imeiservice"]) {
        $AccoutInfo["imei"] = 0;
    }
    if (!$UserDetails["access"]["serverlogservice"]) {
        $AccoutInfo["server"] = 0;
    }
    if (!$UserDetails["access"]["remoteservice"]) {
        $AccoutInfo["remote"] = 0;
    }
    $Bal = mysqli_fetch_assoc(dquery("select sum(cr) as crs,sum(dr) as drs from\ntbl_statement_points where uid='" . $UserDetails["id"] . "'"));
    $CR = $Bal["crs"];
    $DR = $Bal["drs"];
    $AccoutInfo["balance"] = $DR < $CR ? $CR - $DR . "CR" : $DR - $CR . "DR";
    $apiresults["SUCCESS"][] = ["message" => "Your Terminal registered successfully.", "AccoutInfo" => $AccoutInfo];
} else {
    $DATA["serialno"] = $serialno;
    $DATA["devicename"] = $devicename;
    $DATA["userid"] = $userid;
    $DATA["date"] = date("Y-m-d");
    $terminalid = $db->insert("tbl_pos_terminal", $DATA);
    $AccoutInfo["credit"] = formatCurrency($UserDetails["credit"]["credit"], $UserDetails["currency"]);
    $AccoutInfo["creditraw"] = round($UserDetails["credit"]["credit"], 3);
    $AccoutInfo["mail"] = $UserDetails["email"];
    $AccoutInfo["company"] = $UserDetails["companyname"];
    $AccoutInfo["currency"] = $UserDetails["currency"]["code"];
    $AccoutInfo["terminalid"] = $terminalid;
    $AccoutInfo["gcmid"] = $UserDetails["gcmid"];
    $AccoutInfo["imei"] = $config["default_service_imei"];
    $AccoutInfo["server"] = $config["default_service_server"];
    $AccoutInfo["remote"] = $config["default_service_remote"];
    $Bal = mysqli_fetch_assoc(dquery("select sum(cr) as crs,sum(dr) as drs from\ntbl_statement_points where uid='" . $UserDetails["id"] . "'"));
    $CR = $Bal["crs"];
    $DR = $Bal["drs"];
    $AccoutInfo["balance"] = $DR < $CR ? $CR - $DR . "CR" : $DR - $CR . "DR";
    $AccoutInfo["clientgroup"] = $UserDetails["groupname"] ? $UserDetails["groupname"] : "Base";
    $AccoutInfo["rewardpoint"] = $config["rewardpoint"];
    if (!$UserDetails["access"]["imeiservice"]) {
        $AccoutInfo["imei"] = 0;
    }
    if (!$UserDetails["access"]["serverlogservice"]) {
        $AccoutInfo["server"] = 0;
    }
    if (!$UserDetails["access"]["remoteservice"]) {
        $AccoutInfo["remote"] = 0;
    }
    $AccoutInfo["voucher"] = $config["voucher"];
    $apiresults["SUCCESS"][] = ["message" => "Your Terminal registered successfully", "AccoutInfo" => $AccoutInfo];
}

?>