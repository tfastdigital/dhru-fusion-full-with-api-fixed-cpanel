<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Items";
$summary = "Items Group List";
$description = "Create Group";
$operationId = "createItemGroup";
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$access["group"] = "Create Item Group";
$access["name"] = "Create Item Group";
$definitions["type"] = "object";
$definitions["required"][] = "itemgrouparray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["itemgroupname"]["type"] = "string";
$ITEMS["items"]["properties"]["itemgroupmid"]["type"] = "integer";
$ITEMS["items"]["example"]["itemgroupname"] = "Software License";
$ITEMS["items"]["example"]["itemgroupmid"] = "0";
$ITEMS["items"]["required"][] = "itemgroupname";
$definitions["properties"]["itemgrouparraypost"] = $ITEMS;

?>