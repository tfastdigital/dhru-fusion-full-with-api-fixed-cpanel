<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "../lib/nusoap.php";
require_once "../lib/class.wsdlcache.php";
$proxyhost = isset($_POST["proxyhost"]) ? $_POST["proxyhost"] : "";
$proxyport = isset($_POST["proxyport"]) ? $_POST["proxyport"] : "";
$proxyusername = isset($_POST["proxyusername"]) ? $_POST["proxyusername"] : "";
$proxypassword = isset($_POST["proxypassword"]) ? $_POST["proxypassword"] : "";
$method = isset($_GET["method"]) ? $_GET["method"] : "ItemSearch";
$SubscriptionId = "Your AWS subscription id";
$wsdlurl = "http://webservices.amazon.com/AWSECommerceService/US/AWSECommerceService.wsdl";
$cache = new wsdlcache(".", 120);
$wsdl = $cache->get($wsdlurl);
if (is_null($wsdl)) {
    $wsdl = new wsdl($wsdlurl, $proxyhost, $proxyport, $proxyusername, $proxypassword);
    $cache->put($wsdl);
} else {
    $wsdl->debug_str = "";
    $wsdl->debug("Retrieved from cache");
}
$client = new nusoap_client($wsdl, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
}
$client->soap_defencoding = "UTF-8";
if ($method == "ItemLookup") {
    $result = $client->call("ItemLookup", ["body" => getitemlookupparams()]);
} else {
    if ($method == "ItemSearch") {
        $result = $client->call("ItemSearch", ["body" => getitemsearchparams()]);
    } else {
        if ($method == "ItemSearch2") {
            $result = $client->call("ItemSearch", ["body" => getitemsearchparams2()]);
        } else {
            if ($method == "ListLookup") {
                $result = $client->call("ListLookup", ["body" => getlistlookupparams()]);
            } else {
                if ($method == "ListSearch") {
                    $result = $client->call("ListSearch", ["body" => getlistsearchparams()]);
                } else {
                    if ($method == "CartCreate") {
                        $result = $client->call("CartCreate", ["body" => getcartcreateparams()]);
                    } else {
                        echo "Unsupported method " . $method;
                        exit;
                    }
                }
            }
        }
    }
}
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
} else {
    $err = $client->getError();
    if ($err) {
        echo "<h2>Error</h2><pre>" . $err . "</pre>";
    } else {
        echo "<h2>Result</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
}
echo "<h2>Request</h2><pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2><pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";
function GetCartCreateParams()
{
    global $SubscriptionId;
    $item = [];
    $item[0] = ["ASIN" => "0596004206", "Quantity" => "1"];
    $item[1] = ["ASIN" => "0596003277", "Quantity" => "2"];
    $items = ["Item" => $item];
    $request = ["Items" => $items, "ResponseGroup" => "CartSimilarities"];
    $cartCreate = ["SubscriptionId" => $SubscriptionId, "Request" => $request];
    return $cartCreate;
}
function GetItemLookupParams()
{
    global $SubscriptionId;
    $itemLookupRequest[] = ["ItemId" => "B0002IQML6", "IdType" => "ASIN", "Condition" => "All", "ResponseGroup" => "Large"];
    $itemLookupRequest[] = ["ItemId" => "0486411214", "IdType" => "ASIN", "Condition" => "New", "ResponseGroup" => "Small"];
    $itemLookup = ["SubscriptionId" => $SubscriptionId, "Request" => $itemLookupRequest];
    return $itemLookup;
}
function GetItemSearchParams()
{
    global $SubscriptionId;
    $itemSearchRequest = ["BrowseNode" => "53", "ItemPage" => 1, "SearchIndex" => "Books", "Sort" => "salesrank"];
    $itemSearch = ["SubscriptionId" => $SubscriptionId, "Request" => [$itemSearchRequest]];
    return $itemSearch;
}
function GetItemSearchParams2()
{
    global $SubscriptionId;
    $request = ["Keywords" => "postal stamps", "SearchIndex" => "Books"];
    $itemSearch = ["SubscriptionId" => $SubscriptionId, "Request" => $request];
    return $itemSearch;
}
function GetListLookupParams()
{
    global $SubscriptionId;
    $listLookupRequest[] = ["ListId" => "1L0ZL7Y9FL4U0", "ListType" => "WishList", "ProductPage" => 1, "ResponseGroup" => "ListFull", "Sort" => "LastUpdated"];
    $listLookupRequest[] = ["ListId" => "1L0ZL7Y9FL4U0", "ListType" => "WishList", "ProductPage" => 2, "ResponseGroup" => "ListFull", "Sort" => "LastUpdated"];
    $listLookup = ["SubscriptionId" => $SubscriptionId, "Request" => $listLookupRequest];
    return $listLookup;
}
function GetListSearchParams()
{
    global $SubscriptionId;
    $listSearchRequest[] = ["FirstName" => "Scott", "LastName" => "Nichol", "ListType" => "WishList"];
    $listSearch = ["SubscriptionId" => $SubscriptionId, "Request" => $listSearchRequest];
    return $listSearch;
}

?>