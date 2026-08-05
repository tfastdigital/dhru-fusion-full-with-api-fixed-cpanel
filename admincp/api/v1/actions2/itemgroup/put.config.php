<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "post.config.php";
$summary = "Update Item Group Detail";
$description = $summary;
$operationId = "updateItemGroup";
$WithOutIDOptrion = false;
$ITEMS["items"]["properties"]["itemgroupid"]["type"] = "integer";
$ITEMS["items"]["example"]["itemgroupid"] = "1";
$ITEMS["items"]["required"][] = "itemgroupid";
$definitions["properties"]["itemgrouparraypost"] = $ITEMS;
$definitions["properties"]["itemgrouparrayput"] = $definitions["properties"]["itemgrouparraypost"];
unset($definitions["properties"]["itemgrouparraypost"]);

?>