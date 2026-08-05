<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Access";
$summary = "Get Access List";
$description = "Get Access list";
$WithOutIDOptrion = false;
$operationId = "updateAccess";
$parameters[] = ["name" => "groupid", "description" => "Access Group ID", "in" => "path", "required" => 1, "type" => "integer", "default" => "1"];
$parameters[] = ["name" => "body", "description" => "Access object", "in" => "body", "required" => true];
$definitions["type"] = "object";
$definitions["required"][] = "accessarray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["action"]["type"] = "string";
$ITEMS["items"]["properties"]["method"]["type"] = "string";
$ITEMS["items"]["properties"]["method"]["enum"] = ["get", "post", "put", "delete"];
$ITEMS["items"]["properties"]["value"]["type"] = "number";
$ITEMS["items"]["properties"]["days"]["type"] = "number";
$ITEMS["items"]["example"]["action"] = "staff";
$ITEMS["items"]["example"]["method"] = "get";
$ITEMS["items"]["example"]["value"] = "1";
$ITEMS["items"]["example"]["days"] = "0";
$ITEMS["items"]["required"][] = "action";
$ITEMS["items"]["required"][] = "method";
$ITEMS["items"]["required"][] = "value";
$definitions["properties"]["accessarray"] = $ITEMS;
include_once "access.php";

?>