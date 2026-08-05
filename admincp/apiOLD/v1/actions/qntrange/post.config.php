<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Qnt Range";
$summary = "Qnt Range List";
$description = "Create  Range";
$operationId = "createRange";
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$access["group"] = "Create Range";
$access["name"] = "Create Range";
$definitions["type"] = "object";
$definitions["required"][] = "qntrangearray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["start"]["type"] = "integer";
$ITEMS["items"]["properties"]["end"]["type"] = "integer";
$ITEMS["items"]["example"]["start"] = "1";
$ITEMS["items"]["example"]["end"] = "50";
$ITEMS["items"]["required"][] = "start";
$ITEMS["items"]["required"][] = "end";
$definitions["properties"]["qntrangearraypost"] = $ITEMS;

?>