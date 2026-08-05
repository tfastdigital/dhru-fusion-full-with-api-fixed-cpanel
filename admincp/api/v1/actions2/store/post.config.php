<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Store Purchase";
$summary = "Purchase From Store";
$description = "Store Banner Purchase";
$operationId = "store";
$parameters[] = ["name" => "action", "description" => "Action Purchase/Install", "in" => "query", "type" => "string"];
$parameters[] = ["name" => "store_item_id", "description" => "Item ID", "in" => "query", "type" => "string"];
$parameters[] = ["name" => "banner_link", "description" => "Base 64 encoded link", "in" => "query", "type" => "string"];

?>