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
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
$userid = $_SESSION["uid"];
$search = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $search);
$RETURN = [];
$q = dquery("select order_id,(select service_name from tbl_services_imei \r\nwhere id=service_id) as service,user_can_c as status,qnt,credit,discount,imei,comments,reply,reply_date,date,time \r\nfrom tbl_order_imei \r\nwhere (order_id='" . $search . "' or imei like '%" . $search . "%')\r\n and `server`=0 and user_id='" . $userid . "'  order by order_id desc limit 5");
while ($r = mysqli_fetch_assoc($q)) {
    $r["time"] = date("h:i A", $r["time"]);
    $r["status"] = $r["status"] == 0 ? "New" : ($r["status"] == 1 ? "Accepted" : ($r["status"] == 3 ? "Cancelled" : "Completed"));
    $RETURN["imei"][$r["order_id"]] = $r;
}
$q = dquery("select order_id,(select service_name from tbl_services_imei \r\nwhere id=service_id) as service,user_can_c as status,qnt,credit,discount,imei,comments,reply,reply_date,date,time \r\nfrom tbl_order_imei \r\nwhere (order_id='" . $search . "') and `server`=1 and user_id='" . $userid . "'  order by order_id desc limit 5");
while ($r = mysqli_fetch_assoc($q)) {
    $r["time"] = date("h:i A", $r["time"]);
    $r["status"] = $r["status"] == 0 ? "New" : ($r["status"] == 1 ? "Accepted" : ($r["status"] == 3 ? "Cancelled" : "Completed"));
    $RETURN["server"][$r["order_id"]] = $r;
}
$q = dquery("select order_id,(select service_name from tbl_services_file \r\nwhere id=service_id) as service,user_can_c as status,file,credit,discount,comments,reply,reply_date,date,time \r\nfrom tbl_order_file \r\nwhere (order_id='" . $search . "' or file like '%" . $search . "%')  and user_id='" . $userid . "' order by order_id desc limit 5");
while ($r = mysqli_fetch_assoc($q)) {
    $r["time"] = date("h:i A", $r["time"]);
    $r["status"] = $r["status"] == 0 ? "New" : ($r["status"] == 1 ? "Accepted" : ($r["status"] == 3 ? "Cancelled" : "Completed"));
    $RETURN["server"][$r["order_id"]] = $r;
}
if (count($RETURN)) {
    echo json_encode($RETURN);
}

?>