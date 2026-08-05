<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$UID = $UserDetails["id"];
$lstart = $parameters["start"];
$type = $parameters["type"];
$next = 50;
if (!$lstart) {
    $lstart = 0;
}
$orderid = $parameters["ID"];
$WHERE = " user_id='" . $UID . "'";
if ($type == "server") {
    $WHERE .= " and `server`='1'";
} else {
    if ($type == "remote") {
        $WHERE .= " and `server`='2'";
    } else {
        $WHERE .= " and `server`='0'";
    }
}
if ($orderid) {
    $WHERE .= " and (order_id='" . $orderid . "' or imei like '%" . $orderid . "%')";
}
$start = $parameters["startdate"];
$end = $parameters["enddate"];
if ($start && $end) {
    $WHERE .= " and (`date` between '" . $start . "' and '" . $end . "')";
}
$total = mysqli_num_rows(dquery("select (credit-discount) as credit,date,order_id as orderid,(select service_name\n from tbl_services_imei where id=service_id) as service,time,user_can_c\n from tbl_order_imei where " . $WHERE));
$q = dquery("select (credit-discount) as credit,date,order_id as orderid,(select service_name\n from tbl_services_imei where id=service_id) as service,time,user_can_c\n from tbl_order_imei where " . $WHERE . " LIMIT " . $lstart . "," . $next);
for ($cnt = 0; $r = mysqli_fetch_assoc($q); $cnt++) {
    $Status = "New";
    if ($r["user_can_c"] == 1) {
        $Status = "In Process";
    } else {
        if ($r["user_can_c"] == 4) {
            $Status = "Completed";
        } else {
            if ($r["user_can_c"] == 3) {
                $Status = "Rejected";
            }
        }
    }
    $r["time"] = date("h:i A", $r["time"]);
    $r["status"] = $Status;
    $OUT[] = $r;
}
$apiresults["SUCCESS"][] = ["message" => "Search Result", "start" => $start, "total" => $total, "statement" => $OUT];

?>