<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "post.config.php";
$summary = "Update Item Detail";
$description = $summary;
$operationId = "updateItem";
$WithOutIDOptrion = false;
$ITEMS["items"]["properties"]["itemid"]["type"] = "integer";
$ITEMS["items"]["example"]["itemid"] = "1";
$ITEMS["items"]["required"][] = "itemid";
$definitions["properties"]["itemarraypost"] = $ITEMS;
$definitions["properties"]["itemarrayput"] = $definitions["properties"]["itemarraypost"];
unset($definitions["properties"]["itemarraypost"]);

?>