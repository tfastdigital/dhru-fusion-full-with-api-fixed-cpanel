<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameters = $apiresults;
require ROOTDIR . "/includes/imeiservices.fun.php";
$IMEI = descape($parameters["ID"]);
$getorderDtl = dquery("SELECT `order_id`,`imei`,\n    (select service_name from tbl_services_imei \n    where id=service_id) as service,date,`user_can_c`,`reply`,`comments` \n    FROM `tbl_order_imei` WHERE  `user_id`='" . $_ClientsDetails["id"] . "' ORDER BY order_id DESC");
if (mysqli_num_rows($getorderDtl)) {
    while ($row = mysqli_fetch_assoc($getorderDtl)) {
        $status = $row["user_can_c"];
        $apiresults["SUCCESS"][] = ["ID" => $row["order_id"], "DATE" => $row["date"], "SERVICE" => $row["service"], "IMEI" => $row["imei"], "CODE" => $row["reply"], "STATUS" => $status, "COMMENTS" => $row["comments"]];
    }
} else {
    $apiresults["ERROR"][] = ["MESSAGE" => "NoResultFound"];
}
unset($NewServiceDetails);
unset($ServiceDetails);
echo " ";

?>