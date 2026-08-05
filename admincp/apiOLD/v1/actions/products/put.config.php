<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Products";
$summary = "Update Product Detail";
$description = $summary;
$operationId = "updateProduct";
$WithOutIDOptrion = false;
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$parameters[] = ["name" => "telegram", "in" => "query", "type" => "string"];
$access["group"] = "Update Product";
$access["name"] = "Update Product";
$PriceType = ["Percentage", "Fixed"];
$definitions["type"] = "object";
$definitions["required"][] = "productarray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["productid"]["type"] = "integer";
$ITEMS["items"]["properties"]["resetcustomuserprice"]["type"] = "integer";
$PRICING["groupname"]["type"] = "string";
$CURRENCY[1]["id"]["type"] = "integer";
$CURRENCY[1]["price"]["type"] = "integer";
$PRICING["currency"] = $CURRENCY;
$ITEMS["items"]["properties"]["pricing"]["baseprice"] = $PRICING;
$PRICING["groupname"]["type"] = "string";
$CURRENCY[1]["id"]["type"] = "integer";
$CURRENCY[1]["price"]["type"] = "integer";
$PRICING["currency"] = $CURRENCY;
$ITEMS["items"]["properties"]["pricing"]["retailprice"] = $PRICING;
$ITEMS["items"]["properties"]["pricing"]["clientgroups"] = $PRICING;
$ITEMS["items"]["example"]["productid"] = "1";
$ITEMS["items"]["required"][] = "productid";
$definitions["properties"]["productarrayput"] = $ITEMS;

?>