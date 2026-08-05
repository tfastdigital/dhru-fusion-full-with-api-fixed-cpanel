<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "advertisers" collection of methods.
 * Typical usage is:
 *  <code>
 *   $ganService = new Google_GanService(...);
 *   $advertisers = $ganService->advertisers;
 *  </code>
 */
class Google_AdvertisersServiceResource extends Google_ServiceResource
{
    public function listAdvertisers($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Advertisers($data);
        }
        return $data;
    }
    public function get($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Advertiser($data);
        }
        return $data;
    }
}
/**
 * The "ccOffers" collection of methods.
 * Typical usage is:
 *  <code>
 *   $ganService = new Google_GanService(...);
 *   $ccOffers = $ganService->ccOffers;
 *  </code>
 */
class Google_CcOffersServiceResource extends Google_ServiceResource
{
    public function listCcOffers($publisher, $optParams = [])
    {
        $params = ["publisher" => $publisher];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_CcOffers($data);
        }
        return $data;
    }
}
/**
 * The "events" collection of methods.
 * Typical usage is:
 *  <code>
 *   $ganService = new Google_GanService(...);
 *   $events = $ganService->events;
 *  </code>
 */
class Google_EventsServiceResource extends Google_ServiceResource
{
    public function listEvents($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Events($data);
        }
        return $data;
    }
}
/**
 * The "links" collection of methods.
 * Typical usage is:
 *  <code>
 *   $ganService = new Google_GanService(...);
 *   $links = $ganService->links;
 *  </code>
 */
class Google_LinksServiceResource extends Google_ServiceResource
{
    public function insert($role, $roleId, Google_Link $postBody, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Link($data);
        }
        return $data;
    }
    public function listLinks($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Links($data);
        }
        return $data;
    }
    public function get($role, $roleId, $linkId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId, "linkId" => $linkId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Link($data);
        }
        return $data;
    }
}
/**
 * The "publishers" collection of methods.
 * Typical usage is:
 *  <code>
 *   $ganService = new Google_GanService(...);
 *   $publishers = $ganService->publishers;
 *  </code>
 */
class Google_PublishersServiceResource extends Google_ServiceResource
{
    public function listPublishers($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Publishers($data);
        }
        return $data;
    }
    public function get($role, $roleId, $optParams = [])
    {
        $params = ["role" => $role, "roleId" => $roleId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Publisher($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Gan (v1beta1).
 *
 * <p>
 * Lets you have programmatic access to your Google Affiliate Network data.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://code.google.com/apis/gan/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_GanService extends Google_Service
{
    public $advertisers = NULL;
    public $ccOffers = NULL;
    public $events = NULL;
    public $links = NULL;
    public $publishers = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "gan/v1beta1/";
        $this->version = "v1beta1";
        $this->serviceName = "gan";
        $client->addService($this->serviceName, $this->version);
        $this->advertisers = new Google_AdvertisersServiceResource($this, $this->serviceName, "advertisers", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"relationshipStatus\": {\"enum\": [\"approved\", \"available\", \"deactivated\", \"declined\", \"pending\"], \"type\": \"string\", \"location\": \"query\"}, \"minSevenDayEpc\": {\"type\": \"number\", \"location\": \"query\", \"format\": \"double\"}, \"advertiserCategory\": {\"type\": \"string\", \"location\": \"query\"}, \"minNinetyDayEpc\": {\"type\": \"number\", \"location\": \"query\", \"format\": \"double\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"100\", \"format\": \"uint32\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"minPayoutRank\": {\"location\": \"query\", \"minimum\": \"1\", \"type\": \"integer\", \"maximum\": \"4\", \"format\": \"int32\"}}, \"id\": \"gan.advertisers.list\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/advertisers\", \"response\": {\"\$ref\": \"Advertisers\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"advertiserId\": {\"type\": \"string\", \"location\": \"query\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}}, \"id\": \"gan.advertisers.get\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/advertiser\", \"response\": {\"\$ref\": \"Advertiser\"}}}}", true));
        $this->ccOffers = new Google_CcOffersServiceResource($this, $this->serviceName, "ccOffers", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"advertiser\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"projection\": {\"enum\": [\"full\", \"summary\"], \"type\": \"string\", \"location\": \"query\"}, \"publisher\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"gan.ccOffers.list\", \"httpMethod\": \"GET\", \"path\": \"publishers/{publisher}/ccOffers\", \"response\": {\"\$ref\": \"CcOffers\"}}}}", true));
        $this->events = new Google_EventsServiceResource($this, $this->serviceName, "events", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"orderId\": {\"type\": \"string\", \"location\": \"query\"}, \"sku\": {\"type\": \"string\", \"location\": \"query\"}, \"eventDateMax\": {\"type\": \"string\", \"location\": \"query\"}, \"type\": {\"enum\": [\"action\", \"charge\", \"transaction\"], \"type\": \"string\", \"location\": \"query\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"linkId\": {\"type\": \"string\", \"location\": \"query\"}, \"status\": {\"enum\": [\"active\", \"canceled\"], \"type\": \"string\", \"location\": \"query\"}, \"eventDateMin\": {\"type\": \"string\", \"location\": \"query\"}, \"memberId\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"100\", \"format\": \"uint32\"}, \"advertiserId\": {\"type\": \"string\", \"location\": \"query\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"productCategory\": {\"type\": \"string\", \"location\": \"query\"}, \"chargeType\": {\"enum\": [\"credit\", \"debit\", \"monthly_minimum\", \"other\", \"slotting_fee\", \"tier_bonus\"], \"type\": \"string\", \"location\": \"query\"}, \"modifyDateMin\": {\"type\": \"string\", \"location\": \"query\"}, \"modifyDateMax\": {\"type\": \"string\", \"location\": \"query\"}, \"publisherId\": {\"type\": \"string\", \"location\": \"query\"}}, \"id\": \"gan.events.list\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/events\", \"response\": {\"\$ref\": \"Events\"}}}}", true));
        $this->links = new Google_LinksServiceResource($this, $this->serviceName, "links", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\"], \"parameters\": {\"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}}, \"request\": {\"\$ref\": \"Link\"}, \"response\": {\"\$ref\": \"Link\"}, \"httpMethod\": \"POST\", \"path\": \"{role}/{roleId}/link\", \"id\": \"gan.links.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"linkType\": {\"enum\": [\"banner\", \"text\"], \"type\": \"string\", \"location\": \"query\"}, \"startDateMin\": {\"type\": \"string\", \"location\": \"query\"}, \"assetSize\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"relationshipStatus\": {\"enum\": [\"approved\", \"available\"], \"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"100\", \"format\": \"uint32\"}, \"advertiserCategory\": {\"repeated\": true, \"enum\": [\"apparel_accessories\", \"appliances_electronics\", \"auto_dealer\", \"automotive\", \"babies_kids\", \"blogs_personal_sites\", \"books_magazines\", \"computers\", \"dating\", \"department_stores\", \"education\", \"employment\", \"financial_credit_cards\", \"financial_other\", \"flowers_gifts\", \"grocery\", \"health_beauty\", \"home_garden\", \"hosting_domain\", \"internet_providers\", \"legal\", \"media_entertainment\", \"medical\", \"movies_games\", \"music\", \"nonprofit\", \"office_supplies\", \"online_games\", \"outdoor\", \"pets\", \"real_estate\", \"restaurants\", \"sport_fitness\", \"telecom\", \"ticketing\", \"toys_hobbies\", \"travel\", \"utilities\", \"wholesale_relationship\", \"wine_spirits\"], \"type\": \"string\", \"location\": \"query\"}, \"advertiserId\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\", \"format\": \"int64\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"startDateMax\": {\"type\": \"string\", \"location\": \"query\"}, \"promotionType\": {\"repeated\": true, \"enum\": [\"buy_get\", \"coupon\", \"free_gift\", \"free_gift_wrap\", \"free_shipping\", \"none\", \"ongoing\", \"percent_off\", \"price_cut\", \"product_promotion\", \"sale\", \"sweepstakes\"], \"type\": \"string\", \"location\": \"query\"}, \"authorship\": {\"enum\": [\"advertiser\", \"publisher\"], \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"gan.links.list\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/links\", \"response\": {\"\$ref\": \"Links\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"linkId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"format\": \"int64\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"gan.links.get\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/link/{linkId}\", \"response\": {\"\$ref\": \"Link\"}}}}", true));
        $this->publishers = new Google_PublishersServiceResource($this, $this->serviceName, "publishers", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"publisherCategory\": {\"type\": \"string\", \"location\": \"query\"}, \"relationshipStatus\": {\"enum\": [\"approved\", \"available\", \"deactivated\", \"declined\", \"pending\"], \"type\": \"string\", \"location\": \"query\"}, \"minSevenDayEpc\": {\"type\": \"number\", \"location\": \"query\", \"format\": \"double\"}, \"minNinetyDayEpc\": {\"type\": \"number\", \"location\": \"query\", \"format\": \"double\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"100\", \"format\": \"uint32\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"minPayoutRank\": {\"location\": \"query\", \"minimum\": \"1\", \"type\": \"integer\", \"maximum\": \"4\", \"format\": \"int32\"}}, \"id\": \"gan.publishers.list\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/publishers\", \"response\": {\"\$ref\": \"Publishers\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/gan\", \"https://www.googleapis.com/auth/gan.readonly\"], \"parameters\": {\"role\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"advertisers\", \"publishers\"]}, \"publisherId\": {\"type\": \"string\", \"location\": \"query\"}, \"roleId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"gan.publishers.get\", \"httpMethod\": \"GET\", \"path\": \"{role}/{roleId}/publisher\", \"response\": {\"\$ref\": \"Publisher\"}}}}", true));
    }
}
class Google_Advertiser extends Google_Model
{
    public $category = NULL;
    public $contactEmail = NULL;
    public $kind = NULL;
    public $siteUrl = NULL;
    public $contactPhone = NULL;
    public $description = NULL;
    public $payoutRank = NULL;
    public $defaultLinkId = NULL;
    protected $__epcSevenDayAverageType = "Google_Money";
    protected $__epcSevenDayAverageDataType = "";
    public $epcSevenDayAverage = NULL;
    public $commissionDuration = NULL;
    public $status = NULL;
    protected $__epcNinetyDayAverageType = "Google_Money";
    protected $__epcNinetyDayAverageDataType = "";
    public $epcNinetyDayAverage = NULL;
    public $allowPublisherCreatedLinks = NULL;
    protected $__itemType = "Google_Advertiser";
    protected $__itemDataType = "";
    public $item = NULL;
    public $joinDate = NULL;
    public $logoUrl = NULL;
    public $id = NULL;
    public $productFeedsEnabled = NULL;
    public $name = NULL;
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }
    public function getContactEmail()
    {
        return $this->contactEmail;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;
    }
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    }
    public function getContactPhone()
    {
        return $this->contactPhone;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setPayoutRank($payoutRank)
    {
        $this->payoutRank = $payoutRank;
    }
    public function getPayoutRank()
    {
        return $this->payoutRank;
    }
    public function setDefaultLinkId($defaultLinkId)
    {
        $this->defaultLinkId = $defaultLinkId;
    }
    public function getDefaultLinkId()
    {
        return $this->defaultLinkId;
    }
    public function setEpcSevenDayAverage(Google_Money $epcSevenDayAverage)
    {
        $this->epcSevenDayAverage = $epcSevenDayAverage;
    }
    public function getEpcSevenDayAverage()
    {
        return $this->epcSevenDayAverage;
    }
    public function setCommissionDuration($commissionDuration)
    {
        $this->commissionDuration = $commissionDuration;
    }
    public function getCommissionDuration()
    {
        return $this->commissionDuration;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setEpcNinetyDayAverage(Google_Money $epcNinetyDayAverage)
    {
        $this->epcNinetyDayAverage = $epcNinetyDayAverage;
    }
    public function getEpcNinetyDayAverage()
    {
        return $this->epcNinetyDayAverage;
    }
    public function setAllowPublisherCreatedLinks($allowPublisherCreatedLinks)
    {
        $this->allowPublisherCreatedLinks = $allowPublisherCreatedLinks;
    }
    public function getAllowPublisherCreatedLinks()
    {
        return $this->allowPublisherCreatedLinks;
    }
    public function setItem(Google_Advertiser $item)
    {
        $this->item = $item;
    }
    public function getItem()
    {
        return $this->item;
    }
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
    }
    public function getJoinDate()
    {
        return $this->joinDate;
    }
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;
    }
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setProductFeedsEnabled($productFeedsEnabled)
    {
        $this->productFeedsEnabled = $productFeedsEnabled;
    }
    public function getProductFeedsEnabled()
    {
        return $this->productFeedsEnabled;
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
class Google_Advertisers extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Advertiser";
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
        $this->assertIsArray($items, "Google_Advertiser", "Google_Advertisers::setItems");
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
class Google_CcOffer extends Google_Model
{
    public $luggageInsurance = NULL;
    public $creditLimitMin = NULL;
    public $cardName = NULL;
    public $creditLimitMax = NULL;
    public $gracePeriodDisplay = NULL;
    public $offerId = NULL;
    public $rewardUnit = NULL;
    public $minPurchaseRate = NULL;
    public $cardBenefits = NULL;
    protected $__rewardsType = "Google_CcOfferRewards";
    protected $__rewardsDataType = "array";
    public $rewards = NULL;
    public $offersImmediateCashReward = NULL;
    public $travelInsurance = NULL;
    public $returnedPaymentFee = NULL;
    public $kind = NULL;
    public $issuer = NULL;
    public $maxPurchaseRate = NULL;
    public $minimumFinanceCharge = NULL;
    public $existingCustomerOnly = NULL;
    public $annualFeeDisplay = NULL;
    public $initialSetupAndProcessingFee = NULL;
    public $issuerId = NULL;
    public $purchaseRateAdditionalDetails = NULL;
    public $prohibitedCategories = NULL;
    public $fraudLiability = NULL;
    public $cashAdvanceTerms = NULL;
    public $landingPageUrl = NULL;
    public $introCashAdvanceTerms = NULL;
    public $rewardsExpire = NULL;
    public $introPurchaseTerms = NULL;
    protected $__defaultFeesType = "Google_CcOfferDefaultFees";
    protected $__defaultFeesDataType = "array";
    public $defaultFees = NULL;
    public $extendedWarranty = NULL;
    public $emergencyInsurance = NULL;
    public $firstYearAnnualFee = NULL;
    public $trackingUrl = NULL;
    public $latePaymentFee = NULL;
    public $overLimitFee = NULL;
    public $cardType = NULL;
    public $approvedCategories = NULL;
    public $rewardPartner = NULL;
    public $introBalanceTransferTerms = NULL;
    public $foreignCurrencyTransactionFee = NULL;
    public $annualFee = NULL;
    public $issuerWebsite = NULL;
    public $variableRatesUpdateFrequency = NULL;
    public $carRentalInsurance = NULL;
    public $additionalCardBenefits = NULL;
    public $ageMinimum = NULL;
    public $balanceComputationMethod = NULL;
    public $aprDisplay = NULL;
    public $additionalCardHolderFee = NULL;
    public $variableRatesLastUpdated = NULL;
    public $network = NULL;
    public $purchaseRateType = NULL;
    public $statementCopyFee = NULL;
    public $rewardsHaveBlackoutDates = NULL;
    public $creditRatingDisplay = NULL;
    public $flightAccidentInsurance = NULL;
    public $annualRewardMaximum = NULL;
    public $balanceTransferTerms = NULL;
    protected $__bonusRewardsType = "Google_CcOfferBonusRewards";
    protected $__bonusRewardsDataType = "array";
    public $bonusRewards = NULL;
    public $imageUrl = NULL;
    public $ageMinimumDetails = NULL;
    public $disclaimer = NULL;
    public function setLuggageInsurance($luggageInsurance)
    {
        $this->luggageInsurance = $luggageInsurance;
    }
    public function getLuggageInsurance()
    {
        return $this->luggageInsurance;
    }
    public function setCreditLimitMin($creditLimitMin)
    {
        $this->creditLimitMin = $creditLimitMin;
    }
    public function getCreditLimitMin()
    {
        return $this->creditLimitMin;
    }
    public function setCardName($cardName)
    {
        $this->cardName = $cardName;
    }
    public function getCardName()
    {
        return $this->cardName;
    }
    public function setCreditLimitMax($creditLimitMax)
    {
        $this->creditLimitMax = $creditLimitMax;
    }
    public function getCreditLimitMax()
    {
        return $this->creditLimitMax;
    }
    public function setGracePeriodDisplay($gracePeriodDisplay)
    {
        $this->gracePeriodDisplay = $gracePeriodDisplay;
    }
    public function getGracePeriodDisplay()
    {
        return $this->gracePeriodDisplay;
    }
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;
    }
    public function getOfferId()
    {
        return $this->offerId;
    }
    public function setRewardUnit($rewardUnit)
    {
        $this->rewardUnit = $rewardUnit;
    }
    public function getRewardUnit()
    {
        return $this->rewardUnit;
    }
    public function setMinPurchaseRate($minPurchaseRate)
    {
        $this->minPurchaseRate = $minPurchaseRate;
    }
    public function getMinPurchaseRate()
    {
        return $this->minPurchaseRate;
    }
    public function setCardBenefits($cardBenefits)
    {
        $this->cardBenefits = $cardBenefits;
    }
    public function getCardBenefits()
    {
        return $this->cardBenefits;
    }
    public function setRewards($rewards)
    {
        $this->assertIsArray($rewards, "Google_CcOfferRewards", "Google_CcOffer::setRewards");
        $this->rewards = $rewards;
    }
    public function getRewards()
    {
        return $this->rewards;
    }
    public function setOffersImmediateCashReward($offersImmediateCashReward)
    {
        $this->offersImmediateCashReward = $offersImmediateCashReward;
    }
    public function getOffersImmediateCashReward()
    {
        return $this->offersImmediateCashReward;
    }
    public function setTravelInsurance($travelInsurance)
    {
        $this->travelInsurance = $travelInsurance;
    }
    public function getTravelInsurance()
    {
        return $this->travelInsurance;
    }
    public function setReturnedPaymentFee($returnedPaymentFee)
    {
        $this->returnedPaymentFee = $returnedPaymentFee;
    }
    public function getReturnedPaymentFee()
    {
        return $this->returnedPaymentFee;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }
    public function getIssuer()
    {
        return $this->issuer;
    }
    public function setMaxPurchaseRate($maxPurchaseRate)
    {
        $this->maxPurchaseRate = $maxPurchaseRate;
    }
    public function getMaxPurchaseRate()
    {
        return $this->maxPurchaseRate;
    }
    public function setMinimumFinanceCharge($minimumFinanceCharge)
    {
        $this->minimumFinanceCharge = $minimumFinanceCharge;
    }
    public function getMinimumFinanceCharge()
    {
        return $this->minimumFinanceCharge;
    }
    public function setExistingCustomerOnly($existingCustomerOnly)
    {
        $this->existingCustomerOnly = $existingCustomerOnly;
    }
    public function getExistingCustomerOnly()
    {
        return $this->existingCustomerOnly;
    }
    public function setAnnualFeeDisplay($annualFeeDisplay)
    {
        $this->annualFeeDisplay = $annualFeeDisplay;
    }
    public function getAnnualFeeDisplay()
    {
        return $this->annualFeeDisplay;
    }
    public function setInitialSetupAndProcessingFee($initialSetupAndProcessingFee)
    {
        $this->initialSetupAndProcessingFee = $initialSetupAndProcessingFee;
    }
    public function getInitialSetupAndProcessingFee()
    {
        return $this->initialSetupAndProcessingFee;
    }
    public function setIssuerId($issuerId)
    {
        $this->issuerId = $issuerId;
    }
    public function getIssuerId()
    {
        return $this->issuerId;
    }
    public function setPurchaseRateAdditionalDetails($purchaseRateAdditionalDetails)
    {
        $this->purchaseRateAdditionalDetails = $purchaseRateAdditionalDetails;
    }
    public function getPurchaseRateAdditionalDetails()
    {
        return $this->purchaseRateAdditionalDetails;
    }
    public function setProhibitedCategories($prohibitedCategories)
    {
        $this->prohibitedCategories = $prohibitedCategories;
    }
    public function getProhibitedCategories()
    {
        return $this->prohibitedCategories;
    }
    public function setFraudLiability($fraudLiability)
    {
        $this->fraudLiability = $fraudLiability;
    }
    public function getFraudLiability()
    {
        return $this->fraudLiability;
    }
    public function setCashAdvanceTerms($cashAdvanceTerms)
    {
        $this->cashAdvanceTerms = $cashAdvanceTerms;
    }
    public function getCashAdvanceTerms()
    {
        return $this->cashAdvanceTerms;
    }
    public function setLandingPageUrl($landingPageUrl)
    {
        $this->landingPageUrl = $landingPageUrl;
    }
    public function getLandingPageUrl()
    {
        return $this->landingPageUrl;
    }
    public function setIntroCashAdvanceTerms($introCashAdvanceTerms)
    {
        $this->introCashAdvanceTerms = $introCashAdvanceTerms;
    }
    public function getIntroCashAdvanceTerms()
    {
        return $this->introCashAdvanceTerms;
    }
    public function setRewardsExpire($rewardsExpire)
    {
        $this->rewardsExpire = $rewardsExpire;
    }
    public function getRewardsExpire()
    {
        return $this->rewardsExpire;
    }
    public function setIntroPurchaseTerms($introPurchaseTerms)
    {
        $this->introPurchaseTerms = $introPurchaseTerms;
    }
    public function getIntroPurchaseTerms()
    {
        return $this->introPurchaseTerms;
    }
    public function setDefaultFees($defaultFees)
    {
        $this->assertIsArray($defaultFees, "Google_CcOfferDefaultFees", "Google_CcOffer::setDefaultFees");
        $this->defaultFees = $defaultFees;
    }
    public function getDefaultFees()
    {
        return $this->defaultFees;
    }
    public function setExtendedWarranty($extendedWarranty)
    {
        $this->extendedWarranty = $extendedWarranty;
    }
    public function getExtendedWarranty()
    {
        return $this->extendedWarranty;
    }
    public function setEmergencyInsurance($emergencyInsurance)
    {
        $this->emergencyInsurance = $emergencyInsurance;
    }
    public function getEmergencyInsurance()
    {
        return $this->emergencyInsurance;
    }
    public function setFirstYearAnnualFee($firstYearAnnualFee)
    {
        $this->firstYearAnnualFee = $firstYearAnnualFee;
    }
    public function getFirstYearAnnualFee()
    {
        return $this->firstYearAnnualFee;
    }
    public function setTrackingUrl($trackingUrl)
    {
        $this->trackingUrl = $trackingUrl;
    }
    public function getTrackingUrl()
    {
        return $this->trackingUrl;
    }
    public function setLatePaymentFee($latePaymentFee)
    {
        $this->latePaymentFee = $latePaymentFee;
    }
    public function getLatePaymentFee()
    {
        return $this->latePaymentFee;
    }
    public function setOverLimitFee($overLimitFee)
    {
        $this->overLimitFee = $overLimitFee;
    }
    public function getOverLimitFee()
    {
        return $this->overLimitFee;
    }
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
    }
    public function getCardType()
    {
        return $this->cardType;
    }
    public function setApprovedCategories($approvedCategories)
    {
        $this->approvedCategories = $approvedCategories;
    }
    public function getApprovedCategories()
    {
        return $this->approvedCategories;
    }
    public function setRewardPartner($rewardPartner)
    {
        $this->rewardPartner = $rewardPartner;
    }
    public function getRewardPartner()
    {
        return $this->rewardPartner;
    }
    public function setIntroBalanceTransferTerms($introBalanceTransferTerms)
    {
        $this->introBalanceTransferTerms = $introBalanceTransferTerms;
    }
    public function getIntroBalanceTransferTerms()
    {
        return $this->introBalanceTransferTerms;
    }
    public function setForeignCurrencyTransactionFee($foreignCurrencyTransactionFee)
    {
        $this->foreignCurrencyTransactionFee = $foreignCurrencyTransactionFee;
    }
    public function getForeignCurrencyTransactionFee()
    {
        return $this->foreignCurrencyTransactionFee;
    }
    public function setAnnualFee($annualFee)
    {
        $this->annualFee = $annualFee;
    }
    public function getAnnualFee()
    {
        return $this->annualFee;
    }
    public function setIssuerWebsite($issuerWebsite)
    {
        $this->issuerWebsite = $issuerWebsite;
    }
    public function getIssuerWebsite()
    {
        return $this->issuerWebsite;
    }
    public function setVariableRatesUpdateFrequency($variableRatesUpdateFrequency)
    {
        $this->variableRatesUpdateFrequency = $variableRatesUpdateFrequency;
    }
    public function getVariableRatesUpdateFrequency()
    {
        return $this->variableRatesUpdateFrequency;
    }
    public function setCarRentalInsurance($carRentalInsurance)
    {
        $this->carRentalInsurance = $carRentalInsurance;
    }
    public function getCarRentalInsurance()
    {
        return $this->carRentalInsurance;
    }
    public function setAdditionalCardBenefits($additionalCardBenefits)
    {
        $this->additionalCardBenefits = $additionalCardBenefits;
    }
    public function getAdditionalCardBenefits()
    {
        return $this->additionalCardBenefits;
    }
    public function setAgeMinimum($ageMinimum)
    {
        $this->ageMinimum = $ageMinimum;
    }
    public function getAgeMinimum()
    {
        return $this->ageMinimum;
    }
    public function setBalanceComputationMethod($balanceComputationMethod)
    {
        $this->balanceComputationMethod = $balanceComputationMethod;
    }
    public function getBalanceComputationMethod()
    {
        return $this->balanceComputationMethod;
    }
    public function setAprDisplay($aprDisplay)
    {
        $this->aprDisplay = $aprDisplay;
    }
    public function getAprDisplay()
    {
        return $this->aprDisplay;
    }
    public function setAdditionalCardHolderFee($additionalCardHolderFee)
    {
        $this->additionalCardHolderFee = $additionalCardHolderFee;
    }
    public function getAdditionalCardHolderFee()
    {
        return $this->additionalCardHolderFee;
    }
    public function setVariableRatesLastUpdated($variableRatesLastUpdated)
    {
        $this->variableRatesLastUpdated = $variableRatesLastUpdated;
    }
    public function getVariableRatesLastUpdated()
    {
        return $this->variableRatesLastUpdated;
    }
    public function setNetwork($network)
    {
        $this->network = $network;
    }
    public function getNetwork()
    {
        return $this->network;
    }
    public function setPurchaseRateType($purchaseRateType)
    {
        $this->purchaseRateType = $purchaseRateType;
    }
    public function getPurchaseRateType()
    {
        return $this->purchaseRateType;
    }
    public function setStatementCopyFee($statementCopyFee)
    {
        $this->statementCopyFee = $statementCopyFee;
    }
    public function getStatementCopyFee()
    {
        return $this->statementCopyFee;
    }
    public function setRewardsHaveBlackoutDates($rewardsHaveBlackoutDates)
    {
        $this->rewardsHaveBlackoutDates = $rewardsHaveBlackoutDates;
    }
    public function getRewardsHaveBlackoutDates()
    {
        return $this->rewardsHaveBlackoutDates;
    }
    public function setCreditRatingDisplay($creditRatingDisplay)
    {
        $this->creditRatingDisplay = $creditRatingDisplay;
    }
    public function getCreditRatingDisplay()
    {
        return $this->creditRatingDisplay;
    }
    public function setFlightAccidentInsurance($flightAccidentInsurance)
    {
        $this->flightAccidentInsurance = $flightAccidentInsurance;
    }
    public function getFlightAccidentInsurance()
    {
        return $this->flightAccidentInsurance;
    }
    public function setAnnualRewardMaximum($annualRewardMaximum)
    {
        $this->annualRewardMaximum = $annualRewardMaximum;
    }
    public function getAnnualRewardMaximum()
    {
        return $this->annualRewardMaximum;
    }
    public function setBalanceTransferTerms($balanceTransferTerms)
    {
        $this->balanceTransferTerms = $balanceTransferTerms;
    }
    public function getBalanceTransferTerms()
    {
        return $this->balanceTransferTerms;
    }
    public function setBonusRewards($bonusRewards)
    {
        $this->assertIsArray($bonusRewards, "Google_CcOfferBonusRewards", "Google_CcOffer::setBonusRewards");
        $this->bonusRewards = $bonusRewards;
    }
    public function getBonusRewards()
    {
        return $this->bonusRewards;
    }
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    public function setAgeMinimumDetails($ageMinimumDetails)
    {
        $this->ageMinimumDetails = $ageMinimumDetails;
    }
    public function getAgeMinimumDetails()
    {
        return $this->ageMinimumDetails;
    }
    public function setDisclaimer($disclaimer)
    {
        $this->disclaimer = $disclaimer;
    }
    public function getDisclaimer()
    {
        return $this->disclaimer;
    }
}
class Google_CcOfferBonusRewards extends Google_Model
{
    public $amount = NULL;
    public $details = NULL;
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function setDetails($details)
    {
        $this->details = $details;
    }
    public function getDetails()
    {
        return $this->details;
    }
}
class Google_CcOfferDefaultFees extends Google_Model
{
    public $category = NULL;
    public $maxRate = NULL;
    public $minRate = NULL;
    public $rateType = NULL;
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setMaxRate($maxRate)
    {
        $this->maxRate = $maxRate;
    }
    public function getMaxRate()
    {
        return $this->maxRate;
    }
    public function setMinRate($minRate)
    {
        $this->minRate = $minRate;
    }
    public function getMinRate()
    {
        return $this->minRate;
    }
    public function setRateType($rateType)
    {
        $this->rateType = $rateType;
    }
    public function getRateType()
    {
        return $this->rateType;
    }
}
class Google_CcOfferRewards extends Google_Model
{
    public $category = NULL;
    public $minRewardTier = NULL;
    public $maxRewardTier = NULL;
    public $expirationMonths = NULL;
    public $amount = NULL;
    public $additionalDetails = NULL;
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setMinRewardTier($minRewardTier)
    {
        $this->minRewardTier = $minRewardTier;
    }
    public function getMinRewardTier()
    {
        return $this->minRewardTier;
    }
    public function setMaxRewardTier($maxRewardTier)
    {
        $this->maxRewardTier = $maxRewardTier;
    }
    public function getMaxRewardTier()
    {
        return $this->maxRewardTier;
    }
    public function setExpirationMonths($expirationMonths)
    {
        $this->expirationMonths = $expirationMonths;
    }
    public function getExpirationMonths()
    {
        return $this->expirationMonths;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAdditionalDetails($additionalDetails)
    {
        $this->additionalDetails = $additionalDetails;
    }
    public function getAdditionalDetails()
    {
        return $this->additionalDetails;
    }
}
class Google_CcOffers extends Google_Model
{
    protected $__itemsType = "Google_CcOffer";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_CcOffer", "Google_CcOffers::setItems");
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
class Google_Event extends Google_Model
{
    protected $__networkFeeType = "Google_Money";
    protected $__networkFeeDataType = "";
    public $networkFee = NULL;
    public $advertiserName = NULL;
    public $kind = NULL;
    public $modifyDate = NULL;
    public $type = NULL;
    public $orderId = NULL;
    public $publisherName = NULL;
    public $memberId = NULL;
    public $advertiserId = NULL;
    public $status = NULL;
    public $chargeId = NULL;
    protected $__productsType = "Google_EventProducts";
    protected $__productsDataType = "array";
    public $products = NULL;
    protected $__earningsType = "Google_Money";
    protected $__earningsDataType = "";
    public $earnings = NULL;
    public $chargeType = NULL;
    protected $__publisherFeeType = "Google_Money";
    protected $__publisherFeeDataType = "";
    public $publisherFee = NULL;
    protected $__commissionableSalesType = "Google_Money";
    protected $__commissionableSalesDataType = "";
    public $commissionableSales = NULL;
    public $publisherId = NULL;
    public $eventDate = NULL;
    public function setNetworkFee(Google_Money $networkFee)
    {
        $this->networkFee = $networkFee;
    }
    public function getNetworkFee()
    {
        return $this->networkFee;
    }
    public function setAdvertiserName($advertiserName)
    {
        $this->advertiserName = $advertiserName;
    }
    public function getAdvertiserName()
    {
        return $this->advertiserName;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setModifyDate($modifyDate)
    {
        $this->modifyDate = $modifyDate;
    }
    public function getModifyDate()
    {
        return $this->modifyDate;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }
    public function getOrderId()
    {
        return $this->orderId;
    }
    public function setPublisherName($publisherName)
    {
        $this->publisherName = $publisherName;
    }
    public function getPublisherName()
    {
        return $this->publisherName;
    }
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }
    public function getMemberId()
    {
        return $this->memberId;
    }
    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;
    }
    public function getChargeId()
    {
        return $this->chargeId;
    }
    public function setProducts($products)
    {
        $this->assertIsArray($products, "Google_EventProducts", "Google_Event::setProducts");
        $this->products = $products;
    }
    public function getProducts()
    {
        return $this->products;
    }
    public function setEarnings(Google_Money $earnings)
    {
        $this->earnings = $earnings;
    }
    public function getEarnings()
    {
        return $this->earnings;
    }
    public function setChargeType($chargeType)
    {
        $this->chargeType = $chargeType;
    }
    public function getChargeType()
    {
        return $this->chargeType;
    }
    public function setPublisherFee(Google_Money $publisherFee)
    {
        $this->publisherFee = $publisherFee;
    }
    public function getPublisherFee()
    {
        return $this->publisherFee;
    }
    public function setCommissionableSales(Google_Money $commissionableSales)
    {
        $this->commissionableSales = $commissionableSales;
    }
    public function getCommissionableSales()
    {
        return $this->commissionableSales;
    }
    public function setPublisherId($publisherId)
    {
        $this->publisherId = $publisherId;
    }
    public function getPublisherId()
    {
        return $this->publisherId;
    }
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }
    public function getEventDate()
    {
        return $this->eventDate;
    }
}
class Google_EventProducts extends Google_Model
{
    protected $__networkFeeType = "Google_Money";
    protected $__networkFeeDataType = "";
    public $networkFee = NULL;
    public $sku = NULL;
    public $categoryName = NULL;
    public $skuName = NULL;
    protected $__publisherFeeType = "Google_Money";
    protected $__publisherFeeDataType = "";
    public $publisherFee = NULL;
    protected $__earningsType = "Google_Money";
    protected $__earningsDataType = "";
    public $earnings = NULL;
    protected $__unitPriceType = "Google_Money";
    protected $__unitPriceDataType = "";
    public $unitPrice = NULL;
    public $categoryId = NULL;
    public $quantity = NULL;
    public function setNetworkFee(Google_Money $networkFee)
    {
        $this->networkFee = $networkFee;
    }
    public function getNetworkFee()
    {
        return $this->networkFee;
    }
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    public function getSku()
    {
        return $this->sku;
    }
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }
    public function getCategoryName()
    {
        return $this->categoryName;
    }
    public function setSkuName($skuName)
    {
        $this->skuName = $skuName;
    }
    public function getSkuName()
    {
        return $this->skuName;
    }
    public function setPublisherFee(Google_Money $publisherFee)
    {
        $this->publisherFee = $publisherFee;
    }
    public function getPublisherFee()
    {
        return $this->publisherFee;
    }
    public function setEarnings(Google_Money $earnings)
    {
        $this->earnings = $earnings;
    }
    public function getEarnings()
    {
        return $this->earnings;
    }
    public function setUnitPrice(Google_Money $unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
}
class Google_Events extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Event";
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
        $this->assertIsArray($items, "Google_Event", "Google_Events::setItems");
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
class Google_Link extends Google_Model
{
    public $isActive = NULL;
    public $linkType = NULL;
    public $kind = NULL;
    public $endDate = NULL;
    public $description = NULL;
    public $name = NULL;
    public $startDate = NULL;
    public $createDate = NULL;
    public $imageAltText = NULL;
    public $id = NULL;
    public $advertiserId = NULL;
    public $impressionTrackingUrl = NULL;
    public $promotionType = NULL;
    public $duration = NULL;
    public $authorship = NULL;
    public $availability = NULL;
    public $clickTrackingUrl = NULL;
    public $destinationUrl = NULL;
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
    }
    public function getLinkType()
    {
        return $this->linkType;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
    public function getEndDate()
    {
        return $this->endDate;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    public function getStartDate()
    {
        return $this->startDate;
    }
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }
    public function getCreateDate()
    {
        return $this->createDate;
    }
    public function setImageAltText($imageAltText)
    {
        $this->imageAltText = $imageAltText;
    }
    public function getImageAltText()
    {
        return $this->imageAltText;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setAdvertiserId($advertiserId)
    {
        $this->advertiserId = $advertiserId;
    }
    public function getAdvertiserId()
    {
        return $this->advertiserId;
    }
    public function setImpressionTrackingUrl($impressionTrackingUrl)
    {
        $this->impressionTrackingUrl = $impressionTrackingUrl;
    }
    public function getImpressionTrackingUrl()
    {
        return $this->impressionTrackingUrl;
    }
    public function setPromotionType($promotionType)
    {
        $this->promotionType = $promotionType;
    }
    public function getPromotionType()
    {
        return $this->promotionType;
    }
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setAuthorship($authorship)
    {
        $this->authorship = $authorship;
    }
    public function getAuthorship()
    {
        return $this->authorship;
    }
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }
    public function getAvailability()
    {
        return $this->availability;
    }
    public function setClickTrackingUrl($clickTrackingUrl)
    {
        $this->clickTrackingUrl = $clickTrackingUrl;
    }
    public function getClickTrackingUrl()
    {
        return $this->clickTrackingUrl;
    }
    public function setDestinationUrl($destinationUrl)
    {
        $this->destinationUrl = $destinationUrl;
    }
    public function getDestinationUrl()
    {
        return $this->destinationUrl;
    }
}
class Google_Links extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Link";
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
        $this->assertIsArray($items, "Google_Link", "Google_Links::setItems");
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
class Google_Money extends Google_Model
{
    public $amount = NULL;
    public $currencyCode = NULL;
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }
}
class Google_Publisher extends Google_Model
{
    public $status = NULL;
    public $kind = NULL;
    public $name = NULL;
    public $classification = NULL;
    protected $__epcSevenDayAverageType = "Google_Money";
    protected $__epcSevenDayAverageDataType = "";
    public $epcSevenDayAverage = NULL;
    public $payoutRank = NULL;
    protected $__epcNinetyDayAverageType = "Google_Money";
    protected $__epcNinetyDayAverageDataType = "";
    public $epcNinetyDayAverage = NULL;
    protected $__itemType = "Google_Publisher";
    protected $__itemDataType = "";
    public $item = NULL;
    public $joinDate = NULL;
    public $sites = NULL;
    public $id = NULL;
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setClassification($classification)
    {
        $this->classification = $classification;
    }
    public function getClassification()
    {
        return $this->classification;
    }
    public function setEpcSevenDayAverage(Google_Money $epcSevenDayAverage)
    {
        $this->epcSevenDayAverage = $epcSevenDayAverage;
    }
    public function getEpcSevenDayAverage()
    {
        return $this->epcSevenDayAverage;
    }
    public function setPayoutRank($payoutRank)
    {
        $this->payoutRank = $payoutRank;
    }
    public function getPayoutRank()
    {
        return $this->payoutRank;
    }
    public function setEpcNinetyDayAverage(Google_Money $epcNinetyDayAverage)
    {
        $this->epcNinetyDayAverage = $epcNinetyDayAverage;
    }
    public function getEpcNinetyDayAverage()
    {
        return $this->epcNinetyDayAverage;
    }
    public function setItem(Google_Publisher $item)
    {
        $this->item = $item;
    }
    public function getItem()
    {
        return $this->item;
    }
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;
    }
    public function getJoinDate()
    {
        return $this->joinDate;
    }
    public function setSites($sites)
    {
        $this->sites = $sites;
    }
    public function getSites()
    {
        return $this->sites;
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
class Google_Publishers extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_Publisher";
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
        $this->assertIsArray($items, "Google_Publisher", "Google_Publishers::setItems");
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

?>