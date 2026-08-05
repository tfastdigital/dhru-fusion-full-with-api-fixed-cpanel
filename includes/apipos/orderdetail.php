<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$checkParameter[] = "ID";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $orderid = $parameters["ID"];
    $orderdetail = mysqli_fetch_assoc(dquery("select order_id as orderid,(select howtoinfo\nfrom tbl_services_imei where id=service_id) as howtoinfo,qnt,note,imei,points,time,date,(select service_name\n    from tbl_services_imei where id=service_id) as service,service_id,credit,discount,user_can_c,reply as code from \n    tbl_order_imei where order_id='" . $orderid . "' and user_id='" . $UserDetails["id"] . "'"));
    $soldkey = mysqli_fetch_assoc(dquery("select expiredon from tbl_swkey\nwhere tbl_swkey.id=(select keyid from tbl_used_key where orderid='" . $orderid . "' limit 1)"));
    $Custom = getCustomFields("serviceimei", $orderdetail["service_id"], $orderid);
    $orderdetail["custom"] = $Custom;
    $orderdetail["qnt"] = $orderdetail["qnt"];
    $orderdetail["expiredon"] = $soldkey["expiredon"];
    $orderdetail["note"] = $orderdetail["note"];
    $orderdetail["howtoinfo"] = $orderdetail["howtoinfo"];
    $orderdetail["time"] = date("h:i A", $orderdetail["time"]);
    $orderdetail["price"] = round($orderdetail["credit"] - $orderdetail["discount"], 2);
    if ($orderdetail["user_can_c"] == 0) {
        $orderdetail["user_can_c"] = "New";
    } else {
        if ($orderdetail["user_can_c"] == 1) {
            $orderdetail["user_can_c"] = "In-Process";
        } else {
            if ($orderdetail["user_can_c"] == 3) {
                $orderdetail["user_can_c"] = "Cancelled";
            } else {
                if ($orderdetail["user_can_c"] == 4) {
                    $orderdetail["user_can_c"] = "Completed";
                }
            }
        }
    }
    $orderdetail["code"] = strip_tags($orderdetail["code"]);
    if ($orderdetail["orderid"]) {
        $apiresults["SUCCESS"][] = ["message" => "Order Detail", "Order" => $orderdetail];
    } else {
        $apiresults["ERROR"][] = ["message" => "Wrong Order number"];
    }
}

?>