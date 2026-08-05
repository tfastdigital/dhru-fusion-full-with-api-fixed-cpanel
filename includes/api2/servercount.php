<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$qnew = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='0'"));
$qacc = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='1'"));
$qver = mysqli_num_rows(dquery("select order_id from tbl_order_server where `user_can_c`='4' AND `verified`='1'"));
$reply["STATUS"] = "SUCCESS";
$reply["DATA"] = $qnew . "-" . $qacc . "-" . $qver;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>