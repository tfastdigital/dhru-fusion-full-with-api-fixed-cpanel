<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$checkParameter[] = "ID";
$apiresults = checkParameters($checkParameter);
if (!$apiresults["ERROR"]) {
    $parameters = $apiresults;
    $IMEI = descape($parameters["ID"]);
    $getorderDtl = dquery("SELECT `order_id`,`file`,`user_can_c`,`reply`,`comments` FROM `tbl_order_file` WHERE `order_id`='" . $parameters["ID"] . "' and `user_id`='" . $_ClientsDetails["id"] . "'");
    if (mysqli_num_rows($getorderDtl)) {
        while ($row = mysqli_fetch_assoc($getorderDtl)) {
            $apiresults["SUCCESS"][] = ["FILE NAME" => $row["file"], "STATUS" => $row["user_can_c"], "CODE" => $row["reply"], "COMMENTS" => $row["comments"]];
        }
    } else {
        $apiresults["ERROR"][] = ["MESSAGE" => "NoResultFound"];
    }
    unset($NewServiceDetails);
    unset($ServiceDetails);
}
echo " ";

?>