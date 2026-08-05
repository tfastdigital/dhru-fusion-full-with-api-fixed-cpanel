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
$orderid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $orderid);
$type = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $type);
if ($orderid && $type) {
    if ($type == "imei" || $type == "server") {
        if (is_numeric($orderid)) {
            $orderdetail = mysqli_fetch_assoc(dquery("select order_id,service_id,encnum\r\n,user_can_c,reply,reply_time,time,(select avgdeliverytime from tbl_services_imei\r\nwhere id=service_id) as avgdeliverytime,note,comments,model_id,provider_id,provider_c_id\r\n,mep,PIN,KBH,PRD,SN,SecRo,ebay,Type\r\n        from tbl_order_imei where (order_id='" . $orderid . "'  ) and user_id='" . $_SESSION["uid"] . "'"));
        } else {
            $orderdetail = mysqli_fetch_assoc(dquery("select order_id,service_id,encnum\r\n,user_can_c,reply,reply_time,time,(select avgdeliverytime from tbl_services_imei\r\nwhere id=service_id) as avgdeliverytime,note,comments,model_id,provider_id,provider_c_id\r\n,mep,PIN,KBH,PRD,SN,SecRo,ebay,Type\r\n        from tbl_order_imei where (encnum='" . $orderid . "'  ) and user_id='" . $_SESSION["uid"] . "'"));
        }
    } else {
        if ($type == "file") {
            $orderdetail = mysqli_fetch_assoc(dquery("select order_id,user_can_c,reply,reply_time\r\n        from tbl_order_file where order_id='" . $orderid . "' and user_id='" . $_SESSION["uid"] . "'"));
        }
    }
    if ($orderdetail["order_id"]) {
        require_once ROOTDIR . "/includes/customfield.fun.inc.php";
        $cust = getCustomFields("serviceimei", $orderdetail["service_id"], $orderdetail["order_id"]);
        $REPLY = [];
        $REPLY["custom"] = $cust;
        $REPLY["order_id"] = $orderdetail["order_id"];
        $REPLY["encnum"] = $orderdetail["encnum"];
        $REPLY["status"] = $orderdetail["user_can_c"] == 0 ? "Pending" : ($orderdetail["user_can_c"] == 1 ? "Accepted" : ($orderdetail["user_can_c"] == 3 ? "Cancelled" : "Replied"));
        $REPLY["code"] = $orderdetail["reply"];
        $REPLY["comments"] = $orderdetail["comments"];
        $REPLY["note"] = $orderdetail["note"];
        $REPLY["replytime"] = date("h:i A", $orderdetail["reply_time"]);
        $REPLY["avgdeliverytime"] = $orderdetail["time"] + $orderdetail["avgdeliverytime"];
        if ($orderdetail["model_id"]) {
            $serv = mysqli_fetch_assoc(dquery("SELECT `Name`,`B_ID` FROM `tbl_mobile` WHERE `ID`='" . $orderdetail["model_id"] . "' "));
            $REPLY["model_id"] = $orderdetail["model_id"];
            $REPLY["model"] = $serv["Name"];
            $serv1 = mysqli_fetch_assoc(dquery("SELECT `Name` FROM `tbl_model_brand` WHERE `ID`='" . $serv["B_ID"] . "' "));
            $REPLY["brand_id"] = $serv["B_ID"];
            $REPLY["brand"] = $serv1["Name"];
        }
        if ($orderdetail["provider_id"]) {
            $serv = mysqli_fetch_assoc(dquery("SELECT `Name` FROM `tbl_provider` WHERE `ID`='" . $orderdetail["provider_id"] . "' "));
            $REPLY["provider_id"] = $orderdetail["provider_id"];
            $REPLY["provider"] = $serv["Name"];
        }
        if ($orderdetail["provider_c_id"]) {
            $serv = mysqli_fetch_assoc(dquery("SELECT `Name`,`ID` FROM `tbl_provider_country` WHERE `ID`='" . $orderdetail["provider_c_id"] . "' "));
            $REPLY["providercountry_id"] = $serv["ID"];
            $REPLY["providercountry"] = $serv["Name"];
        }
        if ($orderdetail["mep"]) {
            $serv = mysqli_fetch_assoc(dquery("SELECT `mep` FROM \r\n            `tbl_mep` WHERE `id`='" . $orderdetail["mep"] . "' "));
            $REPLY["mep"] = $serv["mep"];
            $REPLY["mep_id"] = $orderdetail["mep"];
        }
        $REPLY["pin"] = $orderdetail["PIN"];
        $REPLY["kbh"] = $orderdetail["KBH"];
        $REPLY["prd"] = $orderdetail["PRD"];
        $REPLY["sn"] = $orderdetail["SN"];
        $REPLY["secro"] = $orderdetail["SecRO"];
        $REPLY["ebay"] = $orderdetail["ebay"];
        $REPLY["type"] = $orderdetail["Type"];
        echo json_encode($REPLY);
    }
}

?>