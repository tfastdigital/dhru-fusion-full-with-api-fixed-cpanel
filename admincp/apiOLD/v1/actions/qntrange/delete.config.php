<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Qnt Range";
$summary = "Delete Qnt Range from Product";
$description = "Delete Qnt Range or its Products Pricing";
$WithOutIDOptrion = false;
$parameters[] = ["name" => "pricingqntid", "in" => "query", "required" => 1, "type" => "string"];
$parameters[] = ["name" => "productid", "in" => "query", "type" => "string"];

?>