<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$tag = "Items";
$summary = "Items List";
$description = "Create Item";
$operationId = "createItem";
$parameters[] = ["name" => "body", "description" => "Created user object", "in" => "body", "required" => true];
$access["group"] = "Create Item";
$access["name"] = "Create Item";
$definitions["type"] = "object";
$definitions["required"][] = "itemarray";
$ITEMS = [];
$ITEMS["type"] = "array";
$ITEMS["items"]["type"] = "object";
$ITEMS["items"]["properties"]["itemname"]["type"] = "string";
$ITEMS["items"]["properties"]["itemtype"]["type"] = "enum";
$ITEMS["items"]["properties"]["itemtype"]["enum"] = itemTypesKeys();
$ITEMS["items"]["properties"]["itemgroupid"]["type"] = "integer";
$ITEMS["items"]["properties"]["itemdescription"]["type"] = "string";
$ITEMS["items"]["properties"]["itemstatus"]["type"] = "string";
$ITEMS["items"]["properties"]["itemdisplayorder"]["type"] = "integer";
$ITEMS["items"]["properties"]["itemconfig"]["type"] = "string";
$ITEMS["items"]["properties"]["pricingtype"]["type"] = "enum";
$ITEMS["items"]["properties"]["pricingtype"]["enum"] = ["free", "onetime", "subscription"];
$ITEMS["items"]["properties"]["itemmasterid"]["type"] = "integer";
$ITEMS["items"]["properties"]["itemupgradewith"]["type"] = "string";
$ITEMS["items"]["properties"]["allowmultipleorders"]["type"] = "integer";
$PRICING["pricing"] = "decimal";
$PRICING["pricingtemplateid"] = "integer";
$PRICING["pricingmon"] = "decimal";
$PRICING["pricingqua"] = "decimal";
$PRICING["pricingsemi"] = "decimal";
$PRICING["pricingann"] = "decimal";
$PRICING["pricingbia"] = "decimal";
$PRICING["pricingtria"] = "decimal";
$PRICING["pricingdays"] = "decimal";
$PRICING["customdays"] = "integer";
$ITEMS["items"]["properties"]["pricing"]["currencyid"] = $PRICING;
$ITEMS["items"]["example"]["itemname"] = "Product 1";
$ITEMS["items"]["example"]["itemtype"] = "licencing";
$ITEMS["items"]["example"]["itemgroupid"] = "1";
$ITEMS["items"]["example"]["itemmasterid"] = "0";
$ITEMS["items"]["example"]["itemdescription"] = "Product 1 description";
$ITEMS["items"]["example"]["itemstatus"] = "1";
$PRICING["pricing"] = "10.00";
$PRICING["pricingmon"] = "10.00";
$PRICING["pricingqua"] = "10.00";
$PRICING["pricingsemi"] = "10.00";
$PRICING["pricingbia"] = "10.00";
$PRICING["pricingann"] = "10.00";
$PRICING["pricingtria"] = "10.00";
$PRICING["pricingdays"] = "10.00";
$PRICING["customdays"] = "30";
$PRICING["pricingtemplateid"] = "1";
$ITEMS["items"]["example"]["pricing"][1] = $PRICING;
$ITEMS["items"]["required"][] = "itemname";
$ITEMS["items"]["required"][] = "itemtype";
$ITEMS["items"]["required"][] = "itemgroupid";
$definitions["properties"]["itemarraypost"] = $ITEMS;

?>