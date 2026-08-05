<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Display Order";
$summary = "Update Display Order";
$description = $summary;
$operationId = "displayOrder";
$WithOutIDOptrion = true;
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$access["group"] = "Update Display Order";
$access["name"] = "Update Display Order";
$definitions["type"] = "object";
$definitions["required"][] = "displayorderarray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["productid"]["type"] = "integer";
$ITEMS["items"]["properties"]["order"]["type"] = "integer";
$ITEMS["items"]["example"]["productid"] = "1";
$ITEMS["items"]["example"]["order"] = "1";
$ITEMS["items"]["required"][] = "productid";
$definitions["properties"]["displayorderarrayput"] = $ITEMS;

?>