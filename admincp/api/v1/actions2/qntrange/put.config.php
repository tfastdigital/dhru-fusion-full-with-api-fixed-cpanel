<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "post.config.php";
$summary = "Update Qnt Range";
$description = $summary;
$operationId = "updateRangw";
$WithOutIDOptrion = false;
$ITEMS["items"]["properties"]["pricingqntid"]["type"] = "integer";
$ITEMS["items"]["example"]["pricingqntid"] = "1";
$ITEMS["items"]["required"][] = "pricingqntid";
$definitions["properties"]["qntrangearraypost"] = $ITEMS;
$definitions["properties"]["qntrangearrayput"] = $definitions["properties"]["qntrangearraypost"];
unset($definitions["properties"]["qntrangearraypost"]);

?>