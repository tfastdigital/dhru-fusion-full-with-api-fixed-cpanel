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
    require ROOTDIR . "/includes/imeiservices.fun.php";
    $parameters["ID"] = trim(trim(descape(preg_replace("/[^0-9,]/i", "", $parameters["ID"])), ","), " ");
    if (strpos($parameters["ID"], ",") !== false) {
        $getorderDtl = dquery("SELECT `order_id`,`imei`,`user_can_c`,`reply`,`comments`             FROM `tbl_order_imei` WHERE (`order_id` in (" . $parameters["ID"] . ") ) and `user_id`='" . $_ClientsDetails["id"] . "'");
    } else {
        $getorderDtl = dquery("SELECT `order_id`,`imei`,`user_can_c`,`reply`,`comments` \n            FROM `tbl_order_imei` WHERE `order_id`='" . $parameters["ID"] . "' and `user_id`='" . $_ClientsDetails["id"] . "'");
    }
    if ($countresultes = mysqli_num_rows($getorderDtl)) {
        while ($row = mysqli_fetch_assoc($getorderDtl)) {
            if (($row["user_can_c"] == 4 || $row["user_can_c"] == 3) && $row["reply"] == "") {
                $row["user_can_c"] = 1;
            }
            $status = $row["user_can_c"];
            if ($countresultes == 1) {
                $apiresults["SUCCESS"][] = ["IMEI" => $row["imei"], "STATUS" => $status, "CODE" => $row["reply"], "COMMENTS" => $row["comments"]];
            } else {
                $apiresults["SUCCESS"][$row["order_id"]] = ["IMEI" => $row["imei"], "STATUS" => $status, "CODE" => $row["reply"], "COMMENTS" => $row["comments"]];
            }
        }
    } else {
        $apiresults["ERROR"][] = ["MESSAGE" => "NoResultFound"];
    }
    unset($NewServiceDetails);
    unset($ServiceDetails);
}

?>