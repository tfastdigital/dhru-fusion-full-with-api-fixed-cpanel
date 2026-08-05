<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Client Price";
$summary = "Client Price";
$operationId = "createItem";
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$access["group"] = "Client Price";
$access["name"] = "Client Price";
$definitions["type"] = "object";
$definitions["required"][] = "itemarray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["clientid"]["type"] = "integer";
$ITEMS["items"]["properties"]["itemid"]["type"] = "integer";
$ITEMS["items"]["properties"]["price"]["type"] = "integer";
$ITEMS["items"]["example"]["itemid"] = "1";
$ITEMS["items"]["example"]["clientid"] = "1";
$ITEMS["items"]["example"]["price"] = "100.00";
$ITEMS["items"]["required"][] = "itemid";
$ITEMS["items"]["required"][] = "clientid";
$definitions["properties"]["clientarrayput"] = $ITEMS;

?>