<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "directDeals" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adexchangebuyerService = new Google_AdexchangebuyerService(...);
 *   $directDeals = $adexchangebuyerService->directDeals;
 *  </code>
 */
class Google_DirectDealsServiceResource extends Google_ServiceResource
{
    public function listDirectDeals($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_DirectDealsList($data);
        }
        return $data;
    }
    public function get($id, $optParams = [])
    {
        $params = ["id" => $id];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_DirectDeal($data);
        }
        return $data;
    }
}
/**
 * The "accounts" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adexchangebuyerService = new Google_AdexchangebuyerService(...);
 *   $accounts = $adexchangebuyerService->accounts;
 *  </code>
 */
class Google_AccountsServiceResource extends Google_ServiceResource
{
    public function patch($id, Google_Account $postBody, $optParams = [])
    {
        $params = ["id" => $id, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_Account($data);
        }
        return $data;
    }
    public function listAccounts($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_AccountsList($data);
        }
        return $data;
    }
    public function update($id, Google_Account $postBody, $optParams = [])
    {
        $params = ["id" => $id, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_Account($data);
        }
        return $data;
    }
    public function get($id, $optParams = [])
    {
        $params = ["id" => $id];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Account($data);
        }
        return $data;
    }
}
/**
 * The "creatives" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adexchangebuyerService = new Google_AdexchangebuyerService(...);
 *   $creatives = $adexchangebuyerService->creatives;
 *  </code>
 */
class Google_CreativesServiceResource extends Google_ServiceResource
{
    public function insert(Google_Creative $postBody, $optParams = [])
    {
        $params = ["postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Creative($data);
        }
        return $data;
    }
    public function listCreatives($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_CreativesList($data);
        }
        return $data;
    }
    public function get($accountId, $buyerCreativeId, $adgroupId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "buyerCreativeId" => $buyerCreativeId, "adgroupId" => $adgroupId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Creative($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Adexchangebuyer (v1).
 *
 * <p>
 * Lets you manage your Ad Exchange Buyer account.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/ad-exchange/buyer-rest" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_AdexchangebuyerService extends Google_Service
{
    public $directDeals = NULL;
    public $accounts = NULL;
    public $creatives = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "adexchangebuyer/v1/";
        $this->version = "v1";
        $this->serviceName = "adexchangebuyer";
        $client->addService($this->serviceName, $this->version);
        $this->directDeals = new Google_DirectDealsServiceResource($this, $this->serviceName, "directDeals", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"path\": \"directdeals\", \"response\": {\"\$ref\": \"DirectDealsList\"}, \"id\": \"adexchangebuyer.directDeals.list\", \"httpMethod\": \"GET\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"format\": \"int64\"}}, \"id\": \"adexchangebuyer.directDeals.get\", \"httpMethod\": \"GET\", \"path\": \"directdeals/{id}\", \"response\": {\"\$ref\": \"DirectDeal\"}}}}", true));
        $this->accounts = new Google_AccountsServiceResource($this, $this->serviceName, "accounts", json_decode("{\"methods\": {\"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Account\"}, \"response\": {\"\$ref\": \"Account\"}, \"httpMethod\": \"PATCH\", \"path\": \"accounts/{id}\", \"id\": \"adexchangebuyer.accounts.patch\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"path\": \"accounts\", \"response\": {\"\$ref\": \"AccountsList\"}, \"id\": \"adexchangebuyer.accounts.list\", \"httpMethod\": \"GET\"}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"request\": {\"\$ref\": \"Account\"}, \"response\": {\"\$ref\": \"Account\"}, \"httpMethod\": \"PUT\", \"path\": \"accounts/{id}\", \"id\": \"adexchangebuyer.accounts.update\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"id\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"id\": \"adexchangebuyer.accounts.get\", \"httpMethod\": \"GET\", \"path\": \"accounts/{id}\", \"response\": {\"\$ref\": \"Account\"}}}}", true));
        $this->creatives = new Google_CreativesServiceResource($this, $this->serviceName, "creatives", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"request\": {\"\$ref\": \"Creative\"}, \"response\": {\"\$ref\": \"Creative\"}, \"httpMethod\": \"POST\", \"path\": \"creatives\", \"id\": \"adexchangebuyer.creatives.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"1\", \"type\": \"integer\", \"maximum\": \"1000\", \"format\": \"uint32\"}}, \"response\": {\"\$ref\": \"CreativesList\"}, \"httpMethod\": \"GET\", \"path\": \"creatives\", \"id\": \"adexchangebuyer.creatives.list\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adexchange.buyer\"], \"parameters\": {\"adgroupId\": {\"required\": true, \"type\": \"string\", \"location\": \"query\", \"format\": \"int64\"}, \"buyerCreativeId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"integer\", \"location\": \"path\", \"format\": \"int32\"}}, \"id\": \"adexchangebuyer.creatives.get\", \"httpMethod\": \"GET\", \"path\": \"creatives/{accountId}/{buyerCreativeId}\", \"response\": {\"\$ref\": \"Creative\"}}}}", true));
    }
}
class Google_Account extends Google_Model
{
    public $kind = NULL;
    public $maximumTotalQps = NULL;
    protected $__bidderLocationType = "Google_AccountBidderLocation";
    protected $__bidderLocationDataType = "array";
    public $bidderLocation = NULL;
    public $cookieMatchingNid = NULL;
    public $id = NULL;
    public $cookieMatchingUrl = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setMaximumTotalQps($maximumTotalQps)
    {
        $this->maximumTotalQps = $maximumTotalQps;
    }
    public function getMaximumTotalQps()
    {
        return $this->maximumTotalQps;
    }
    public function setBidderLocation($bidderLocation)
    {
        $this->assertIsArray($bidderLocation, "Google_AccountBidderLocation", "Google_Account::setBidderLocation");
        $this->bidderLocation = $bidderLocation;
    }
    public function getBidderLocation()
    {
        return $this->bidderLocation;
    }
    public function setCookieMatchingNid($cookieMatchingNid)
    {
        $this->cookieMatchingNid = $cookieMatchingNid;
    }
    public function getCookieMatchingNid()
    {
        return $this->cookieMatchingNid;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setCookieMatchingUrl($cookieMatchingUrl)
    {
        $this->cookieMatchingUrl = $cookieMatchingUrl;
    }
    public function getCookieMatchingUrl()
    {
        return $this->cookieMatchingUrl;
    }
}
class Google_AccountBidderLocation extends Google_Model
{
    public $url = NULL;
    public $maximumQps = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setMaximumQps($maximumQps)
    {
        $this->maximumQps = $maximumQps;
    }
    public function getMaximumQps()
    {
        return $this->maximumQps;
    }
}
class Google_AccountsList extends Google_Model
{
    protected $__itemsType = "Google_Account";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Account", "Google_AccountsList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_Creative extends Google_Model
{
    public $productCategories = NULL;
    public $advertiserName = NULL;
    public $adgroupId = NULL;
    public $videoURL = NULL;
    public $width = NULL;
    public $attribute = NULL;
    public $kind = NULL;
    public $height = NULL;
    public $advertiserId = NULL;
    public $HTMLSnippet = NULL;
    public $status = NULL;
    public $buyerCreativeId = NULL;
    public $clickThroughUrl = NULL;
    public $vendorType = NULL;
    public $disapprovalReasons = NULL;
    public $sensitiveCategories = NULL;
    public $accountId = NULL;
    public function setProductCategories($productCategories)
    {
        $this->productCategories = $productCategories;
    }
    public function getProductCategories()
    {
        return $this->productCategories;
    }
    public function setAdvertiserName($advertiserName)
    {
        $this->advertiserName = $advertiserName;
    }
    public function getAdvertiserName()
    {
        return $this->advertiserName;
    }
    public function setAdgroupId($adgroupId)
    {
        $this->adgroupId = $adgroupId;
    }
    public function getAdgroupId()
    {
        return $this->adgroupId;
    }
    public function setVideoURL($videoURL)
    {
        $this->videoURL = $videoURL;
    }
    public function getVideoURL()
    {
        return $this->videoURL;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }
    public function getAttribute()
    {
        return $this->attribute;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }
    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }
    public function setHTMLSnippet($HTMLSnippet)
    {
        $this->HTMLSnippet = $HTMLSnippet;
    }
    public function getHTMLSnippet()
    {
        return $this->HTMLSnippet;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setBuyerCreativeId($buyerCreativeId)
    {
        $this->buyerCreativeId = $buyerCreativeId;
    }
    public function getBuyerCreativeId()
    {
        return $this->buyerCreativeId;
    }
    public function setClickThroughUrl($clickThroughUrl)
    {
        $this->clickThroughUrl = $clickThroughUrl;
    }
    public function getClickThroughUrl()
    {
        return $this->clickThroughUrl;
    }
    public function setVendorType($vendorType)
    {
        $this->vendorType = $vendorType;
    }
    public function getVendorType()
    {
        return $this->vendorType;
    }
    public function setDisapprovalReasons($disapprovalReasons)
    {
        $this->disapprovalReasons = $disapprovalReasons;
    }
    public function getDisapprovalReasons()
    {
        return $this->disapprovalReasons;
    }
    public function setSensitiveCategories($sensitiveCategories)
    {
        $this->sensitiveCategories = $sensitiveCategories;
    }
    public function getSensitiveCategories()
    {
        return $this->sensitiveCategories;
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
class Google_CreativesList extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Creative";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Creative", "Google_CreativesList::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
}
class Google_DirectDeal extends Google_Model
{
    public $advertiser = NULL;
    public $kind = NULL;
    public $currencyCode = NULL;
    public $fixedCpm = NULL;
    public $startTime = NULL;
    public $endTime = NULL;
    public $sellerNetwork = NULL;
    public $id = NULL;
    public $accountId = NULL;
    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;
    }
    public function getAdvertiser()
    {
        return $this->advertiser;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }
    public function setFixedCpm($fixedCpm)
    {
        $this->fixedCpm = $fixedCpm;
    }
    public function getFixedCpm()
    {
        return $this->fixedCpm;
    }
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }
    public function getStartTime()
    {
        return $this->startTime;
    }
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }
    public function getEndTime()
    {
        return $this->endTime;
    }
    public function setSellerNetwork($sellerNetwork)
    {
        $this->sellerNetwork = $sellerNetwork;
    }
    public function getSellerNetwork()
    {
        return $this->sellerNetwork;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
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
class Google_DirectDealsList extends Google_Model
{
    public $kind = NULL;
    protected $__directDealsType = "Google_DirectDeal";
    protected $__directDealsDataType = "array";
    public $directDeals = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDirectDeals($directDeals)
    {
        $this->assertIsArray($directDeals, "Google_DirectDeal", "Google_DirectDealsList::setDirectDeals");
        $this->directDeals = $directDeals;
    }
    public function getDirectDeals()
    {
        return $this->directDeals;
    }
}

?>