<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
if ($UserDetails["id"]) {
    $q = dquery("select id,`date`,total from tbl_invoices where userid='" . $UserDetails["id"] . "' order by id desc limit 50");
    while ($row = mysqli_fetch_assoc($q)) {
        $OUT[] = $row;
    }
    $apiresults["SUCCESS"][] = ["message" => "Invoice Detail", "Invoice Details" => $OUT];
}

?>