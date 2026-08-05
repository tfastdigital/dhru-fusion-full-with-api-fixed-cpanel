<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "products" collection of methods.
 * Typical usage is:
 *  <code>
 *   $shoppingService = new Google_ShoppingService(...);
 *   $products = $shoppingService->products;
 *  </code>
 */
class Google_ProductsServiceResource extends Google_ServiceResource
{
    public function listProducts($source, $optParams = [])
    {
        $params = ["source" => $source];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Products($data);
        }
        return $data;
    }
    public function get($source, $accountId, $productIdType, $productId, $optParams = [])
    {
        $params = ["source" => $source, "accountId" => $accountId, "productIdType" => $productIdType, "productId" => $productId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Product($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Shopping (v1).
 *
 * <p>
 * Lets you search over product data.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/shopping/search/v1/getting_started.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_ShoppingService extends Google_Service
{
    public $products = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "shopping/search/v1/";
        $this->version = "v1";
        $this->serviceName = "shopping";
        $client->addService($this->serviceName, $this->version);
        $this->products = new Google_ProductsServiceResource($this, $this->serviceName, "products", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/shoppingapi\"], \"parameters\": {\"facets.include\": {\"type\": \"string\", \"location\": \"query\"}, \"plusOne.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"plusOne.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"facets.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"relatedQueries.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"promotions.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"channels\": {\"type\": \"string\", \"location\": \"query\"}, \"currency\": {\"type\": \"string\", \"location\": \"query\"}, \"startIndex\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"facets.discover\": {\"type\": \"string\", \"location\": \"query\"}, \"categoryRecommendations.category\": {\"type\": \"string\", \"location\": \"query\"}, \"availability\": {\"type\": \"string\", \"location\": \"query\"}, \"crowdBy\": {\"type\": \"string\", \"location\": \"query\"}, \"spelling.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"taxonomy\": {\"type\": \"string\", \"location\": \"query\"}, \"spelling.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"source\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"useCase\": {\"type\": \"string\", \"location\": \"query\"}, \"location\": {\"type\": \"string\", \"location\": \"query\"}, \"maxVariants\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"categories.include\": {\"type\": \"string\", \"location\": \"query\"}, \"boostBy\": {\"type\": \"string\", \"location\": \"query\"}, \"safe\": {\"type\": \"boolean\", \"location\": \"query\"}, \"categories.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"maxResults\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"facets.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"categories.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"plusOne.styles\": {\"type\": \"string\", \"location\": \"query\"}, \"attributeFilter\": {\"type\": \"string\", \"location\": \"query\"}, \"clickTracking\": {\"type\": \"boolean\", \"location\": \"query\"}, \"categoryRecommendations.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"thumbnails\": {\"type\": \"string\", \"location\": \"query\"}, \"language\": {\"type\": \"string\", \"location\": \"query\"}, \"categoryRecommendations.include\": {\"type\": \"string\", \"location\": \"query\"}, \"country\": {\"type\": \"string\", \"location\": \"query\"}, \"rankBy\": {\"type\": \"string\", \"location\": \"query\"}, \"restrictBy\": {\"type\": \"string\", \"location\": \"query\"}, \"q\": {\"type\": \"string\", \"location\": \"query\"}, \"redirects.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"redirects.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"relatedQueries.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"categoryRecommendations.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"promotions.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}}, \"id\": \"shopping.products.list\", \"httpMethod\": \"GET\", \"path\": \"{source}/products\", \"response\": {\"\$ref\": \"Products\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/shoppingapi\"], \"parameters\": {\"categories.include\": {\"type\": \"string\", \"location\": \"query\"}, \"recommendations.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"thumbnails\": {\"type\": \"string\", \"location\": \"query\"}, \"plusOne.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"source\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"taxonomy\": {\"type\": \"string\", \"location\": \"query\"}, \"productIdType\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"categories.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"plusOne.styles\": {\"type\": \"string\", \"location\": \"query\"}, \"recommendations.include\": {\"type\": \"string\", \"location\": \"query\"}, \"categories.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"location\": {\"type\": \"string\", \"location\": \"query\"}, \"plusOne.enabled\": {\"type\": \"boolean\", \"location\": \"query\"}, \"attributeFilter\": {\"type\": \"string\", \"location\": \"query\"}, \"recommendations.useGcsConfig\": {\"type\": \"boolean\", \"location\": \"query\"}, \"productId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"uint32\"}}, \"id\": \"shopping.products.get\", \"httpMethod\": \"GET\", \"path\": \"{source}/products/{accountId}/{productIdType}/{productId}\", \"response\": {\"\$ref\": \"Product\"}}}}", true));
    }
}
class Google_Product extends Google_Model
{
    public $selfLink = NULL;
    public $kind = NULL;
    protected $__productType = "Google_ShoppingModelProductJsonV1";
    protected $__productDataType = "";
    public $product = NULL;
    public $requestId = NULL;
    protected $__recommendationsType = "Google_ShoppingModelRecommendationsJsonV1";
    protected $__recommendationsDataType = "array";
    public $recommendations = NULL;
    protected $__debugType = "Google_ShoppingModelDebugJsonV1";
    protected $__debugDataType = "";
    public $debug = NULL;
    public $id = NULL;
    protected $__categoriesType = "Google_ShoppingModelCategoryJsonV1";
    protected $__categoriesDataType = "array";
    public $categories = NULL;
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setProduct(Google_ShoppingModelProductJsonV1 $product)
    {
        $this->product = $product;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }
    public function getRequestId()
    {
        return $this->requestId;
    }
    public function setRecommendations($recommendations)
    {
        $this->assertIsArray($recommendations, "Google_ShoppingModelRecommendationsJsonV1", "Google_Product::setRecommendations");
        $this->recommendations = $recommendations;
    }
    public function getRecommendations()
    {
        return $this->recommendations;
    }
    public function setDebug(Google_ShoppingModelDebugJsonV1 $debug)
    {
        $this->debug = $debug;
    }
    public function getDebug()
    {
        return $this->debug;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCategories($categories)
    {
        $this->assertIsArray($categories, "Google_ShoppingModelCategoryJsonV1", "Google_Product::setCategories");
        $this->categories = $categories;
    }
    public function getCategories()
    {
        return $this->categories;
    }
}
class Google_Products extends Google_Model
{
    protected $__promotionsType = "Google_ProductsPromotions";
    protected $__promotionsDataType = "array";
    public $promotions = NULL;
    public $selfLink = NULL;
    public $kind = NULL;
    protected $__storesType = "Google_ProductsStores";
    protected $__storesDataType = "array";
    public $stores = NULL;
    public $currentItemCount = NULL;
    protected $__itemsType = "Google_Product";
    protected $__itemsDataType = "array";
    public $items = NULL;
    protected $__facetsType = "Google_ProductsFacets";
    protected $__facetsDataType = "array";
    public $facets = NULL;
    public $itemsPerPage = NULL;
    public $redirects = NULL;
    public $nextLink = NULL;
    public $relatedQueries = NULL;
    public $totalItems = NULL;
    public $startIndex = NULL;
    public $etag = NULL;
    public $requestId = NULL;
    protected $__categoryRecommendationsType = "Google_ShoppingModelRecommendationsJsonV1";
    protected $__categoryRecommendationsDataType = "array";
    public $categoryRecommendations = NULL;
    protected $__debugType = "Google_ShoppingModelDebugJsonV1";
    protected $__debugDataType = "";
    public $debug = NULL;
    protected $__spellingType = "Google_ProductsSpelling";
    protected $__spellingDataType = "";
    public $spelling = NULL;
    public $previousLink = NULL;
    public $id = NULL;
    protected $__categoriesType = "Google_ShoppingModelCategoryJsonV1";
    protected $__categoriesDataType = "array";
    public $categories = NULL;
    public function setPromotions($promotions)
    {
        $this->assertIsArray($promotions, "Google_ProductsPromotions", "Google_Products::setPromotions");
        $this->promotions = $promotions;
    }
    public function getPromotions()
    {
        return $this->promotions;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setStores($stores)
    {
        $this->assertIsArray($stores, "Google_ProductsStores", "Google_Products::setStores");
        $this->stores = $stores;
    }
    public function getStores()
    {
        return $this->stores;
    }
    public function setCurrentItemCount($currentItemCount)
    {
        $this->currentItemCount = $currentItemCount;
    }
    public function getCurrentItemCount()
    {
        return $this->currentItemCount;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Product", "Google_Products::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setFacets($facets)
    {
        $this->assertIsArray($facets, "Google_ProductsFacets", "Google_Products::setFacets");
        $this->facets = $facets;
    }
    public function getFacets()
    {
        return $this->facets;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setRedirects($redirects)
    {
        $this->assertIsArray($redirects, "Google_string", "Google_Products::setRedirects");
        $this->redirects = $redirects;
    }
    public function getRedirects()
    {
        return $this->redirects;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setRelatedQueries($relatedQueries)
    {
        $this->assertIsArray($relatedQueries, "Google_string", "Google_Products::setRelatedQueries");
        $this->relatedQueries = $relatedQueries;
    }
    public function getRelatedQueries()
    {
        return $this->relatedQueries;
    }
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }
    public function getRequestId()
    {
        return $this->requestId;
    }
    public function setCategoryRecommendations($categoryRecommendations)
    {
        $this->assertIsArray($categoryRecommendations, "Google_ShoppingModelRecommendationsJsonV1", "Google_Products::setCategoryRecommendations");
        $this->categoryRecommendations = $categoryRecommendations;
    }
    public function getCategoryRecommendations()
    {
        return $this->categoryRecommendations;
    }
    public function setDebug(Google_ShoppingModelDebugJsonV1 $debug)
    {
        $this->debug = $debug;
    }
    public function getDebug()
    {
        return $this->debug;
    }
    public function setSpelling(Google_ProductsSpelling $spelling)
    {
        $this->spelling = $spelling;
    }
    public function getSpelling()
    {
        return $this->spelling;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCategories($categories)
    {
        $this->assertIsArray($categories, "Google_ShoppingModelCategoryJsonV1", "Google_Products::setCategories");
        $this->categories = $categories;
    }
    public function getCategories()
    {
        return $this->categories;
    }
}
class Google_ProductsFacets extends Google_Model
{
    public $count = NULL;
    public $displayName = NULL;
    public $name = NULL;
    protected $__bucketsType = "Google_ProductsFacetsBuckets";
    protected $__bucketsDataType = "array";
    public $buckets = NULL;
    public $property = NULL;
    public $type = NULL;
    public $unit = NULL;
    public function setCount($count)
    {
        $this->count = $count;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setBuckets($buckets)
    {
        $this->assertIsArray($buckets, "Google_ProductsFacetsBuckets", "Google_ProductsFacets::setBuckets");
        $this->buckets = $buckets;
    }
    public function getBuckets()
    {
        return $this->buckets;
    }
    public function setProperty($property)
    {
        $this->property = $property;
    }
    public function getProperty()
    {
        return $this->property;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
    public function getUnit()
    {
        return $this->unit;
    }
}
class Google_ProductsFacetsBuckets extends Google_Model
{
    public $count = NULL;
    public $minExclusive = NULL;
    public $min = NULL;
    public $max = NULL;
    public $value = NULL;
    public $maxExclusive = NULL;
    public function setCount($count)
    {
        $this->count = $count;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function setMinExclusive($minExclusive)
    {
        $this->minExclusive = $minExclusive;
    }
    public function getMinExclusive()
    {
        return $this->minExclusive;
    }
    public function setMin($min)
    {
        $this->min = $min;
    }
    public function getMin()
    {
        return $this->min;
    }
    public function setMax($max)
    {
        $this->max = $max;
    }
    public function getMax()
    {
        return $this->max;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setMaxExclusive($maxExclusive)
    {
        $this->maxExclusive = $maxExclusive;
    }
    public function getMaxExclusive()
    {
        return $this->maxExclusive;
    }
}
class Google_ProductsPromotions extends Google_Model
{
    protected $__productType = "Google_ShoppingModelProductJsonV1";
    protected $__productDataType = "";
    public $product = NULL;
    public $description = NULL;
    public $imageLink = NULL;
    public $destLink = NULL;
    public $customHtml = NULL;
    protected $__customFieldsType = "Google_ProductsPromotionsCustomFields";
    protected $__customFieldsDataType = "array";
    public $customFields = NULL;
    public $type = NULL;
    public $name = NULL;
    public function setProduct(Google_ShoppingModelProductJsonV1 $product)
    {
        $this->product = $product;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;
    }
    public function getImageLink()
    {
        return $this->imageLink;
    }
    public function setDestLink($destLink)
    {
        $this->destLink = $destLink;
    }
    public function getDestLink()
    {
        return $this->destLink;
    }
    public function setCustomHtml($customHtml)
    {
        $this->customHtml = $customHtml;
    }
    public function getCustomHtml()
    {
        return $this->customHtml;
    }
    public function setCustomFields($customFields)
    {
        $this->assertIsArray($customFields, "Google_ProductsPromotionsCustomFields", "Google_ProductsPromotions::setCustomFields");
        $this->customFields = $customFields;
    }
    public function getCustomFields()
    {
        return $this->customFields;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}
class Google_ProductsPromotionsCustomFields extends Google_Model
{
    public $name = NULL;
    public $value = NULL;
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
}
class Google_ProductsSpelling extends Google_Model
{
    public $suggestion = NULL;
    public function setSuggestion($suggestion)
    {
        $this->suggestion = $suggestion;
    }
    public function getSuggestion()
    {
        return $this->suggestion;
    }
}
class Google_ProductsStores extends Google_Model
{
    public $storeCode = NULL;
    public $name = NULL;
    public $storeName = NULL;
    public $storeId = NULL;
    public $telephone = NULL;
    public $location = NULL;
    public $address = NULL;
    public function setStoreCode($storeCode)
    {
        $this->storeCode = $storeCode;
    }
    public function getStoreCode()
    {
        return $this->storeCode;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setStoreName($storeName)
    {
        $this->storeName = $storeName;
    }
    public function getStoreName()
    {
        return $this->storeName;
    }
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }
    public function getStoreId()
    {
        return $this->storeId;
    }
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    public function getTelephone()
    {
        return $this->telephone;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
}
class Google_ShoppingModelCategoryJsonV1 extends Google_Model
{
    public $url = NULL;
    public $shortName = NULL;
    public $parents = NULL;
    public $id = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }
    public function getShortName()
    {
        return $this->shortName;
    }
    public function setParents($parents)
    {
        $this->assertIsArray($parents, "Google_string", "Google_ShoppingModelCategoryJsonV1::setParents");
        $this->parents = $parents;
    }
    public function getParents()
    {
        return $this->parents;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_ShoppingModelDebugJsonV1 extends Google_Model
{
    public $searchRequest = NULL;
    public $rdcResponse = NULL;
    public $facetsRequest = NULL;
    public $searchResponse = NULL;
    public $elapsedMillis = NULL;
    public $facetsResponse = NULL;
    protected $__backendTimesType = "Google_ShoppingModelDebugJsonV1BackendTimes";
    protected $__backendTimesDataType = "array";
    public $backendTimes = NULL;
    public function setSearchRequest($searchRequest)
    {
        $this->searchRequest = $searchRequest;
    }
    public function getSearchRequest()
    {
        return $this->searchRequest;
    }
    public function setRdcResponse($rdcResponse)
    {
        $this->rdcResponse = $rdcResponse;
    }
    public function getRdcResponse()
    {
        return $this->rdcResponse;
    }
    public function setFacetsRequest($facetsRequest)
    {
        $this->facetsRequest = $facetsRequest;
    }
    public function getFacetsRequest()
    {
        return $this->facetsRequest;
    }
    public function setSearchResponse($searchResponse)
    {
        $this->searchResponse = $searchResponse;
    }
    public function getSearchResponse()
    {
        return $this->searchResponse;
    }
    public function setElapsedMillis($elapsedMillis)
    {
        $this->elapsedMillis = $elapsedMillis;
    }
    public function getElapsedMillis()
    {
        return $this->elapsedMillis;
    }
    public function setFacetsResponse($facetsResponse)
    {
        $this->facetsResponse = $facetsResponse;
    }
    public function getFacetsResponse()
    {
        return $this->facetsResponse;
    }
    public function setBackendTimes($backendTimes)
    {
        $this->assertIsArray($backendTimes, "Google_ShoppingModelDebugJsonV1BackendTimes", "Google_ShoppingModelDebugJsonV1::setBackendTimes");
        $this->backendTimes = $backendTimes;
    }
    public function getBackendTimes()
    {
        return $this->backendTimes;
    }
}
class Google_ShoppingModelDebugJsonV1BackendTimes extends Google_Model
{
    public $serverMillis = NULL;
    public $hostName = NULL;
    public $name = NULL;
    public $elapsedMillis = NULL;
    public function setServerMillis($serverMillis)
    {
        $this->serverMillis = $serverMillis;
    }
    public function getServerMillis()
    {
        return $this->serverMillis;
    }
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }
    public function getHostName()
    {
        return $this->hostName;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setElapsedMillis($elapsedMillis)
    {
        $this->elapsedMillis = $elapsedMillis;
    }
    public function getElapsedMillis()
    {
        return $this->elapsedMillis;
    }
}
class Google_ShoppingModelProductJsonV1 extends Google_Model
{
    public $queryMatched = NULL;
    public $gtin = NULL;
    protected $__imagesType = "Google_ShoppingModelProductJsonV1Images";
    protected $__imagesDataType = "array";
    public $images = NULL;
    protected $__inventoriesType = "Google_ShoppingModelProductJsonV1Inventories";
    protected $__inventoriesDataType = "array";
    public $inventories = NULL;
    protected $__authorType = "Google_ShoppingModelProductJsonV1Author";
    protected $__authorDataType = "";
    public $author = NULL;
    public $score = NULL;
    public $condition = NULL;
    public $providedId = NULL;
    public $internal8 = NULL;
    public $description = NULL;
    public $gtins = NULL;
    public $internal1 = NULL;
    public $brand = NULL;
    public $internal3 = NULL;
    protected $__internal4Type = "Google_ShoppingModelProductJsonV1Internal4";
    protected $__internal4DataType = "array";
    public $internal4 = NULL;
    public $internal6 = NULL;
    public $internal7 = NULL;
    public $link = NULL;
    public $mpns = NULL;
    protected $__attributesType = "Google_ShoppingModelProductJsonV1Attributes";
    protected $__attributesDataType = "array";
    public $attributes = NULL;
    public $totalMatchingVariants = NULL;
    protected $__variantsType = "Google_ShoppingModelProductJsonV1Variants";
    protected $__variantsDataType = "array";
    public $variants = NULL;
    public $modificationTime = NULL;
    public $categories = NULL;
    public $language = NULL;
    public $country = NULL;
    public $title = NULL;
    public $creationTime = NULL;
    public $internal14 = NULL;
    public $internal12 = NULL;
    public $internal13 = NULL;
    public $internal10 = NULL;
    public $plusOne = NULL;
    public $googleId = NULL;
    public $internal15 = NULL;
    public function setQueryMatched($queryMatched)
    {
        $this->queryMatched = $queryMatched;
    }
    public function getQueryMatched()
    {
        return $this->queryMatched;
    }
    public function setGtin($gtin)
    {
        $this->gtin = $gtin;
    }
    public function getGtin()
    {
        return $this->gtin;
    }
    public function setImages($images)
    {
        $this->assertIsArray($images, "Google_ShoppingModelProductJsonV1Images", "Google_ShoppingModelProductJsonV1::setImages");
        $this->images = $images;
    }
    public function getImages()
    {
        return $this->images;
    }
    public function setInventories($inventories)
    {
        $this->assertIsArray($inventories, "Google_ShoppingModelProductJsonV1Inventories", "Google_ShoppingModelProductJsonV1::setInventories");
        $this->inventories = $inventories;
    }
    public function getInventories()
    {
        return $this->inventories;
    }
    public function setAuthor(Google_ShoppingModelProductJsonV1Author $author)
    {
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setScore($score)
    {
        $this->score = $score;
    }
    public function getScore()
    {
        return $this->score;
    }
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }
    public function getCondition()
    {
        return $this->condition;
    }
    public function setProvidedId($providedId)
    {
        $this->providedId = $providedId;
    }
    public function getProvidedId()
    {
        return $this->providedId;
    }
    public function setInternal8($internal8)
    {
        $this->assertIsArray($internal8, "Google_string", "Google_ShoppingModelProductJsonV1::setInternal8");
        $this->internal8 = $internal8;
    }
    public function getInternal8()
    {
        return $this->internal8;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setGtins($gtins)
    {
        $this->assertIsArray($gtins, "Google_string", "Google_ShoppingModelProductJsonV1::setGtins");
        $this->gtins = $gtins;
    }
    public function getGtins()
    {
        return $this->gtins;
    }
    public function setInternal1($internal1)
    {
        $this->assertIsArray($internal1, "Google_string", "Google_ShoppingModelProductJsonV1::setInternal1");
        $this->internal1 = $internal1;
    }
    public function getInternal1()
    {
        return $this->internal1;
    }
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
    public function getBrand()
    {
        return $this->brand;
    }
    public function setInternal3($internal3)
    {
        $this->internal3 = $internal3;
    }
    public function getInternal3()
    {
        return $this->internal3;
    }
    public function setInternal4($internal4)
    {
        $this->assertIsArray($internal4, "Google_ShoppingModelProductJsonV1Internal4", "Google_ShoppingModelProductJsonV1::setInternal4");
        $this->internal4 = $internal4;
    }
    public function getInternal4()
    {
        return $this->internal4;
    }
    public function setInternal6($internal6)
    {
        $this->internal6 = $internal6;
    }
    public function getInternal6()
    {
        return $this->internal6;
    }
    public function setInternal7($internal7)
    {
        $this->internal7 = $internal7;
    }
    public function getInternal7()
    {
        return $this->internal7;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setMpns($mpns)
    {
        $this->assertIsArray($mpns, "Google_string", "Google_ShoppingModelProductJsonV1::setMpns");
        $this->mpns = $mpns;
    }
    public function getMpns()
    {
        return $this->mpns;
    }
    public function setAttributes($attributes)
    {
        $this->assertIsArray($attributes, "Google_ShoppingModelProductJsonV1Attributes", "Google_ShoppingModelProductJsonV1::setAttributes");
        $this->attributes = $attributes;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    public function setTotalMatchingVariants($totalMatchingVariants)
    {
        $this->totalMatchingVariants = $totalMatchingVariants;
    }
    public function getTotalMatchingVariants()
    {
        return $this->totalMatchingVariants;
    }
    public function setVariants($variants)
    {
        $this->assertIsArray($variants, "Google_ShoppingModelProductJsonV1Variants", "Google_ShoppingModelProductJsonV1::setVariants");
        $this->variants = $variants;
    }
    public function getVariants()
    {
        return $this->variants;
    }
    public function setModificationTime($modificationTime)
    {
        $this->modificationTime = $modificationTime;
    }
    public function getModificationTime()
    {
        return $this->modificationTime;
    }
    public function setCategories($categories)
    {
        $this->assertIsArray($categories, "Google_string", "Google_ShoppingModelProductJsonV1::setCategories");
        $this->categories = $categories;
    }
    public function getCategories()
    {
        return $this->categories;
    }
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    public function getLanguage()
    {
        return $this->language;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;
    }
    public function getCreationTime()
    {
        return $this->creationTime;
    }
    public function setInternal14($internal14)
    {
        $this->internal14 = $internal14;
    }
    public function getInternal14()
    {
        return $this->internal14;
    }
    public function setInternal12($internal12)
    {
        $this->internal12 = $internal12;
    }
    public function getInternal12()
    {
        return $this->internal12;
    }
    public function setInternal13($internal13)
    {
        $this->internal13 = $internal13;
    }
    public function getInternal13()
    {
        return $this->internal13;
    }
    public function setInternal10($internal10)
    {
        $this->assertIsArray($internal10, "Google_string", "Google_ShoppingModelProductJsonV1::setInternal10");
        $this->internal10 = $internal10;
    }
    public function getInternal10()
    {
        return $this->internal10;
    }
    public function setPlusOne($plusOne)
    {
        $this->plusOne = $plusOne;
    }
    public function getPlusOne()
    {
        return $this->plusOne;
    }
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }
    public function getGoogleId()
    {
        return $this->googleId;
    }
    public function setInternal15($internal15)
    {
        $this->internal15 = $internal15;
    }
    public function getInternal15()
    {
        return $this->internal15;
    }
}
class Google_ShoppingModelProductJsonV1Attributes extends Google_Model
{
    public $type = NULL;
    public $value = NULL;
    public $displayName = NULL;
    public $name = NULL;
    public $unit = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
    public function getUnit()
    {
        return $this->unit;
    }
}
class Google_ShoppingModelProductJsonV1Author extends Google_Model
{
    public $name = NULL;
    public $accountId = NULL;
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }
    public function getAccountId()
    {
        return $this->accountId;
    }
}
class Google_ShoppingModelProductJsonV1Images extends Google_Model
{
    public $status = NULL;
    public $link = NULL;
    protected $__thumbnailsType = "Google_ShoppingModelProductJsonV1ImagesThumbnails";
    protected $__thumbnailsDataType = "array";
    public $thumbnails = NULL;
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setThumbnails($thumbnails)
    {
        $this->assertIsArray($thumbnails, "Google_ShoppingModelProductJsonV1ImagesThumbnails", "Google_ShoppingModelProductJsonV1Images::setThumbnails");
        $this->thumbnails = $thumbnails;
    }
    public function getThumbnails()
    {
        return $this->thumbnails;
    }
}
class Google_ShoppingModelProductJsonV1ImagesThumbnails extends Google_Model
{
    public $content = NULL;
    public $width = NULL;
    public $link = NULL;
    public $height = NULL;
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }
}
class Google_ShoppingModelProductJsonV1Internal4 extends Google_Model
{
    public $node = NULL;
    public $confidence = NULL;
    public function setNode($node)
    {
        $this->node = $node;
    }
    public function getNode()
    {
        return $this->node;
    }
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
    }
    public function getConfidence()
    {
        return $this->confidence;
    }
}
class Google_ShoppingModelProductJsonV1Inventories extends Google_Model
{
    public $installmentPrice = NULL;
    public $installmentMonths = NULL;
    public $distance = NULL;
    public $price = NULL;
    public $storeId = NULL;
    public $tax = NULL;
    public $shipping = NULL;
    public $currency = NULL;
    public $salePrice = NULL;
    public $originalPrice = NULL;
    public $distanceUnit = NULL;
    public $saleStartDate = NULL;
    public $availability = NULL;
    public $channel = NULL;
    public $saleEndDate = NULL;
    public function setInstallmentPrice($installmentPrice)
    {
        $this->installmentPrice = $installmentPrice;
    }
    public function getInstallmentPrice()
    {
        return $this->installmentPrice;
    }
    public function setInstallmentMonths($installmentMonths)
    {
        $this->installmentMonths = $installmentMonths;
    }
    public function getInstallmentMonths()
    {
        return $this->installmentMonths;
    }
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }
    public function getDistance()
    {
        return $this->distance;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }
    public function getStoreId()
    {
        return $this->storeId;
    }
    public function setTax($tax)
    {
        $this->tax = $tax;
    }
    public function getTax()
    {
        return $this->tax;
    }
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    }
    public function getShipping()
    {
        return $this->shipping;
    }
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    public function getCurrency()
    {
        return $this->currency;
    }
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;
    }
    public function getSalePrice()
    {
        return $this->salePrice;
    }
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;
    }
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }
    public function setDistanceUnit($distanceUnit)
    {
        $this->distanceUnit = $distanceUnit;
    }
    public function getDistanceUnit()
    {
        return $this->distanceUnit;
    }
    public function setSaleStartDate($saleStartDate)
    {
        $this->saleStartDate = $saleStartDate;
    }
    public function getSaleStartDate()
    {
        return $this->saleStartDate;
    }
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }
    public function getAvailability()
    {
        return $this->availability;
    }
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }
    public function getChannel()
    {
        return $this->channel;
    }
    public function setSaleEndDate($saleEndDate)
    {
        $this->saleEndDate = $saleEndDate;
    }
    public function getSaleEndDate()
    {
        return $this->saleEndDate;
    }
}
class Google_ShoppingModelProductJsonV1Variants extends Google_Model
{
    protected $__variantType = "Google_ShoppingModelProductJsonV1";
    protected $__variantDataType = "";
    public $variant = NULL;
    public function setVariant(Google_ShoppingModelProductJsonV1 $variant)
    {
        $this->variant = $variant;
    }
    public function getVariant()
    {
        return $this->variant;
    }
}
class Google_ShoppingModelRecommendationsJsonV1 extends Google_Model
{
    protected $__recommendationListType = "Google_ShoppingModelRecommendationsJsonV1RecommendationList";
    protected $__recommendationListDataType = "array";
    public $recommendationList = NULL;
    public $type = NULL;
    public function setRecommendationList($recommendationList)
    {
        $this->assertIsArray($recommendationList, "Google_ShoppingModelRecommendationsJsonV1RecommendationList", "Google_ShoppingModelRecommendationsJsonV1::setRecommendationList");
        $this->recommendationList = $recommendationList;
    }
    public function getRecommendationList()
    {
        return $this->recommendationList;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
}
class Google_ShoppingModelRecommendationsJsonV1RecommendationList extends Google_Model
{
    protected $__productType = "Google_ShoppingModelProductJsonV1";
    protected $__productDataType = "";
    public $product = NULL;
    public function setProduct(Google_ShoppingModelProductJsonV1 $product)
    {
        $this->product = $product;
    }
    public function getProduct()
    {
        return $this->product;
    }
}

?>