<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "START";
$start = 0;
if ($parameters["START"]) {
    $start = $parameters["START"];
}
$type = $parameters["type"];
$OUT = [];
$limit = 10;
if ($type == "imei") {
    $server = 0;
} else {
    if ($type == "remote") {
        $server = 2;
    } else {
        $server = 1;
    }
}
$Total = mysqli_num_rows(dquery("select order_id as orderid,credit,discount,date,time,reply as code,(select service_name from tbl_services_imei where id=service_id) as service \n    from tbl_order_imei where user_id='" . $UserDetails["id"] . "' and `server`='" . $server . "'"));
$o = dquery("select order_id as orderid,user_can_c,date,verifydata,credit,discount,time,reply as code,(select service_name from tbl_services_imei where id=service_id) as service \n    from tbl_order_imei where user_id='" . $UserDetails["id"] . "' and `server`='" . $server . "'\n     order by order_id desc limit " . $start . "," . $limit);
$OUT["total"] = $Total;
while ($r = mysqli_fetch_assoc($o)) {
    $r["time"] = date("h:i A", $r["time"]);
    if ($r["verifydata"]) {
        $r["codearr"] = json_decode($r["verifydata"], true);
    }
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
    $r["status"] = $Status;
    $OUT["order"][] = $r;
}
$apiresults["SUCCESS"][] = ["message" => "Orders History", "Orders" => $OUT];

?>