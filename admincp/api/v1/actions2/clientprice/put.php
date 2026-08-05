<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */


    $itemid = $input["itemid"];
    $clientid = $input["clientid"];
    $price = $input["price"];
    updateClientPrice($clientid, $itemid, $price);

$RETURN["status"] = "success";
$RETURN["msg"] = "Client Price Updated";
return $RETURN;

?>