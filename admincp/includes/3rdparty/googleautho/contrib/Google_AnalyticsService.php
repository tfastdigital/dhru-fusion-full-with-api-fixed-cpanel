<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "management" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $management = $analyticsService->management;
 *  </code>
 */
class Google_ManagementServiceResource extends Google_ServiceResource
{
}
/**
 * The "webproperties" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $webproperties = $analyticsService->webproperties;
 *  </code>
 */
class Google_ManagementWebpropertiesServiceResource extends Google_ServiceResource
{
    public function listManagementWebproperties($accountId, $optParams = [])
    {
        $params = ["accountId" => $accountId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Webproperties($data);
        }
        return $data;
    }
}
/**
 * The "segments" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $segments = $analyticsService->segments;
 *  </code>
 */
class Google_ManagementSegmentsServiceResource extends Google_ServiceResource
{
    public function listManagementSegments($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Segments($data);
        }
        return $data;
    }
}
/**
 * The "accounts" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $accounts = $analyticsService->accounts;
 *  </code>
 */
class Google_ManagementAccountsServiceResource extends Google_ServiceResource
{
    public function listManagementAccounts($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Accounts($data);
        }
        return $data;
    }
}
/**
 * The "goals" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $goals = $analyticsService->goals;
 *  </code>
 */
class Google_ManagementGoalsServiceResource extends Google_ServiceResource
{
    public function listManagementGoals($accountId, $webPropertyId, $profileId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "webPropertyId" => $webPropertyId, "profileId" => $profileId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Goals($data);
        }
        return $data;
    }
}
/**
 * The "profiles" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $profiles = $analyticsService->profiles;
 *  </code>
 */
class Google_ManagementProfilesServiceResource extends Google_ServiceResource
{
    public function listManagementProfiles($accountId, $webPropertyId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "webPropertyId" => $webPropertyId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Profiles($data);
        }
        return $data;
    }
}
/**
 * The "data" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $data = $analyticsService->data;
 *  </code>
 */
class Google_DataServiceResource extends Google_ServiceResource
{
}
/**
 * The "mcf" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $mcf = $analyticsService->mcf;
 *  </code>
 */
class Google_DataMcfServiceResource extends Google_ServiceResource
{
    public function get($ids, $start_date, $end_date, $metrics, $optParams = [])
    {
        $params = ["ids" => $ids, "start-date" => $start_date, "end-date" => $end_date, "metrics" => $metrics];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_McfData($data);
        }
        return $data;
    }
}
/**
 * The "ga" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_AnalyticsService(...);
 *   $ga = $analyticsService->ga;
 *  </code>
 */
class Google_DataGaServiceResource extends Google_ServiceResource
{
    public function get($ids, $start_date, $end_date, $metrics, $optParams = [])
    {
        $params = ["ids" => $ids, "start-date" => $start_date, "end-date" => $end_date, "metrics" => $metrics];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_GaData($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Analytics (v3).
 *
 * <p>
 * View and manage your Google Analytics data
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/analytics" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_AnalyticsService extends Google_Service
{
    public $management_webproperties = NULL;
    public $management_segments = NULL;
    public $management_accounts = NULL;
    public $management_goals = NULL;
    public $management_profiles = NULL;
    public $data_mcf = NULL;
    public $data_ga = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "analytics/v3/";
        $this->version = "v3";
        $this->serviceName = "analytics";
        $client->addService($this->serviceName, $this->version);
        $this->management_webproperties = new Google_ManagementWebpropertiesServiceResource($this, $this->serviceName, "webproperties", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"analytics.management.webproperties.list\", \"httpMethod\": \"GET\", \"path\": \"management/accounts/{accountId}/webproperties\", \"response\": {\"\$ref\": \"Webproperties\"}}}}", true));
        $this->management_segments = new Google_ManagementSegmentsServiceResource($this, $this->serviceName, "segments", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"response\": {\"\$ref\": \"Segments\"}, \"httpMethod\": \"GET\", \"path\": \"management/segments\", \"id\": \"analytics.management.segments.list\"}}}", true));
        $this->management_accounts = new Google_ManagementAccountsServiceResource($this, $this->serviceName, "accounts", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}}, \"response\": {\"\$ref\": \"Accounts\"}, \"httpMethod\": \"GET\", \"path\": \"management/accounts\", \"id\": \"analytics.management.accounts.list\"}}}", true));
        $this->management_goals = new Google_ManagementGoalsServiceResource($this, $this->serviceName, "goals", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"profileId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"webPropertyId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"analytics.management.goals.list\", \"httpMethod\": \"GET\", \"path\": \"management/accounts/{accountId}/webproperties/{webPropertyId}/profiles/{profileId}/goals\", \"response\": {\"\$ref\": \"Goals\"}}}}", true));
        $this->management_profiles = new Google_ManagementProfilesServiceResource($this, $this->serviceName, "profiles", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"webPropertyId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"analytics.management.profiles.list\", \"httpMethod\": \"GET\", \"path\": \"management/accounts/{accountId}/webproperties/{webPropertyId}/profiles\", \"response\": {\"\$ref\": \"Profiles\"}}}}", true));
        $this->data_mcf = new Google_DataMcfServiceResource($this, $this->serviceName, "mcf", json_decode("{\"methods\": {\"get\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"dimensions\": {\"type\": \"string\", \"location\": \"query\"}, \"start-date\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"ids\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"metrics\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"filters\": {\"type\": \"string\", \"location\": \"query\"}, \"end-date\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"analytics.data.mcf.get\", \"httpMethod\": \"GET\", \"path\": \"data/mcf\", \"response\": {\"\$ref\": \"McfData\"}}}}", true));
        $this->data_ga = new Google_DataGaServiceResource($this, $this->serviceName, "ga", json_decode("{\"methods\": {\"get\": {\"scopes\": [\"https://www.googleapis.com/auth/analytics.readonly\"], \"parameters\": {\"max-results\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"dimensions\": {\"type\": \"string\", \"location\": \"query\"}, \"start-date\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"start-index\": {\"minimum\": \"1\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"int32\"}, \"segment\": {\"type\": \"string\", \"location\": \"query\"}, \"ids\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"metrics\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"filters\": {\"type\": \"string\", \"location\": \"query\"}, \"end-date\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"analytics.data.ga.get\", \"httpMethod\": \"GET\", \"path\": \"data/ga\", \"response\": {\"\$ref\": \"GaData\"}}}}", true));
    }
}
class Google_Account extends Google_Model
{
    public $kind = NULL;
    public $name = NULL;
    public $created = NULL;
    public $updated = NULL;
    protected $__childLinkType = "Google_AccountChildLink";
    protected $__childLinkDataType = "";
    public $childLink = NULL;
    public $id = NULL;
    public $selfLink = NULL;
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
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setChildLink(Google_AccountChildLink $childLink)
    {
        $this->childLink = $childLink;
    }
    public function getChildLink()
    {
        return $this->childLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
}
class Google_AccountChildLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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
class Google_Accounts extends Google_Model
{
    public $username = NULL;
    public $kind = NULL;
    protected $__itemsType = "Google_Account";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $itemsPerPage = NULL;
    public $previousLink = NULL;
    public $startIndex = NULL;
    public $nextLink = NULL;
    public $totalResults = NULL;
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Account", "Google_Accounts::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
class Google_GaData extends Google_Model
{
    public $kind = NULL;
    public $rows = NULL;
    public $containsSampledData = NULL;
    public $totalResults = NULL;
    public $itemsPerPage = NULL;
    public $totalsForAllResults = NULL;
    public $nextLink = NULL;
    public $id = NULL;
    protected $__queryType = "Google_GaDataQuery";
    protected $__queryDataType = "";
    public $query = NULL;
    public $previousLink = NULL;
    protected $__profileInfoType = "Google_GaDataProfileInfo";
    protected $__profileInfoDataType = "";
    public $profileInfo = NULL;
    protected $__columnHeadersType = "Google_GaDataColumnHeaders";
    protected $__columnHeadersDataType = "array";
    public $columnHeaders = NULL;
    public $selfLink = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setRows($rows)
    {
        $this->assertIsArray($rows, "Google_string", "Google_GaData::setRows");
        $this->rows = $rows;
    }
    public function getRows()
    {
        return $this->rows;
    }
    public function setContainsSampledData($containsSampledData)
    {
        $this->containsSampledData = $containsSampledData;
    }
    public function getContainsSampledData()
    {
        return $this->containsSampledData;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setTotalsForAllResults($totalsForAllResults)
    {
        $this->totalsForAllResults = $totalsForAllResults;
    }
    public function getTotalsForAllResults()
    {
        return $this->totalsForAllResults;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setQuery(Google_GaDataQuery $query)
    {
        $this->query = $query;
    }
    public function getQuery()
    {
        return $this->query;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setProfileInfo(Google_GaDataProfileInfo $profileInfo)
    {
        $this->profileInfo = $profileInfo;
    }
    public function getProfileInfo()
    {
        return $this->profileInfo;
    }
    public function setColumnHeaders($columnHeaders)
    {
        $this->assertIsArray($columnHeaders, "Google_GaDataColumnHeaders", "Google_GaData::setColumnHeaders");
        $this->columnHeaders = $columnHeaders;
    }
    public function getColumnHeaders()
    {
        return $this->columnHeaders;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
}
class Google_GaDataColumnHeaders extends Google_Model
{
    public $dataType = NULL;
    public $columnType = NULL;
    public $name = NULL;
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }
    public function getDataType()
    {
        return $this->dataType;
    }
    public function setColumnType($columnType)
    {
        $this->columnType = $columnType;
    }
    public function getColumnType()
    {
        return $this->columnType;
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
class Google_GaDataProfileInfo extends Google_Model
{
    public $webPropertyId = NULL;
    public $internalWebPropertyId = NULL;
    public $tableId = NULL;
    public $profileId = NULL;
    public $profileName = NULL;
    public $accountId = NULL;
    public function setWebPropertyId($webPropertyId)
    {
        $this->webPropertyId = $webPropertyId;
    }
    public function getWebPropertyId()
    {
        return $this->webPropertyId;
    }
    public function setInternalWebPropertyId($internalWebPropertyId)
    {
        $this->internalWebPropertyId = $internalWebPropertyId;
    }
    public function getInternalWebPropertyId()
    {
        return $this->internalWebPropertyId;
    }
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    public function getTableId()
    {
        return $this->tableId;
    }
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }
    public function getProfileId()
    {
        return $this->profileId;
    }
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;
    }
    public function getProfileName()
    {
        return $this->profileName;
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
class Google_GaDataQuery extends Google_Model
{
    public $max_results = NULL;
    public $sort = NULL;
    public $dimensions = NULL;
    public $start_date = NULL;
    public $start_index = NULL;
    public $segment = NULL;
    public $ids = NULL;
    public $metrics = NULL;
    public $filters = NULL;
    public $end_date = NULL;
    public function setMax_results($max_results)
    {
        $this->max_results = $max_results;
    }
    public function getMax_results()
    {
        return $this->max_results;
    }
    public function setSort($sort)
    {
        $this->assertIsArray($sort, "Google_string", "Google_GaDataQuery::setSort");
        $this->sort = $sort;
    }
    public function getSort()
    {
        return $this->sort;
    }
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }
    public function getDimensions()
    {
        return $this->dimensions;
    }
    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;
    }
    public function getStart_date()
    {
        return $this->start_date;
    }
    public function setStart_index($start_index)
    {
        $this->start_index = $start_index;
    }
    public function getStart_index()
    {
        return $this->start_index;
    }
    public function setSegment($segment)
    {
        $this->segment = $segment;
    }
    public function getSegment()
    {
        return $this->segment;
    }
    public function setIds($ids)
    {
        $this->ids = $ids;
    }
    public function getIds()
    {
        return $this->ids;
    }
    public function setMetrics($metrics)
    {
        $this->assertIsArray($metrics, "Google_string", "Google_GaDataQuery::setMetrics");
        $this->metrics = $metrics;
    }
    public function getMetrics()
    {
        return $this->metrics;
    }
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }
    public function getFilters()
    {
        return $this->filters;
    }
    public function setEnd_date($end_date)
    {
        $this->end_date = $end_date;
    }
    public function getEnd_date()
    {
        return $this->end_date;
    }
}
class Google_Goal extends Google_Model
{
    public $kind = NULL;
    protected $__visitTimeOnSiteDetailsType = "Google_GoalVisitTimeOnSiteDetails";
    protected $__visitTimeOnSiteDetailsDataType = "";
    public $visitTimeOnSiteDetails = NULL;
    public $name = NULL;
    public $created = NULL;
    protected $__urlDestinationDetailsType = "Google_GoalUrlDestinationDetails";
    protected $__urlDestinationDetailsDataType = "";
    public $urlDestinationDetails = NULL;
    public $updated = NULL;
    public $value = NULL;
    protected $__visitNumPagesDetailsType = "Google_GoalVisitNumPagesDetails";
    protected $__visitNumPagesDetailsDataType = "";
    public $visitNumPagesDetails = NULL;
    public $internalWebPropertyId = NULL;
    protected $__eventDetailsType = "Google_GoalEventDetails";
    protected $__eventDetailsDataType = "";
    public $eventDetails = NULL;
    public $webPropertyId = NULL;
    public $active = NULL;
    public $profileId = NULL;
    protected $__parentLinkType = "Google_GoalParentLink";
    protected $__parentLinkDataType = "";
    public $parentLink = NULL;
    public $type = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public $accountId = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setVisitTimeOnSiteDetails(Google_GoalVisitTimeOnSiteDetails $visitTimeOnSiteDetails)
    {
        $this->visitTimeOnSiteDetails = $visitTimeOnSiteDetails;
    }
    public function getVisitTimeOnSiteDetails()
    {
        return $this->visitTimeOnSiteDetails;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setUrlDestinationDetails(Google_GoalUrlDestinationDetails $urlDestinationDetails)
    {
        $this->urlDestinationDetails = $urlDestinationDetails;
    }
    public function getUrlDestinationDetails()
    {
        return $this->urlDestinationDetails;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function setVisitNumPagesDetails(Google_GoalVisitNumPagesDetails $visitNumPagesDetails)
    {
        $this->visitNumPagesDetails = $visitNumPagesDetails;
    }
    public function getVisitNumPagesDetails()
    {
        return $this->visitNumPagesDetails;
    }
    public function setInternalWebPropertyId($internalWebPropertyId)
    {
        $this->internalWebPropertyId = $internalWebPropertyId;
    }
    public function getInternalWebPropertyId()
    {
        return $this->internalWebPropertyId;
    }
    public function setEventDetails(Google_GoalEventDetails $eventDetails)
    {
        $this->eventDetails = $eventDetails;
    }
    public function getEventDetails()
    {
        return $this->eventDetails;
    }
    public function setWebPropertyId($webPropertyId)
    {
        $this->webPropertyId = $webPropertyId;
    }
    public function getWebPropertyId()
    {
        return $this->webPropertyId;
    }
    public function setActive($active)
    {
        $this->active = $active;
    }
    public function getActive()
    {
        return $this->active;
    }
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }
    public function getProfileId()
    {
        return $this->profileId;
    }
    public function setParentLink(Google_GoalParentLink $parentLink)
    {
        $this->parentLink = $parentLink;
    }
    public function getParentLink()
    {
        return $this->parentLink;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
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
class Google_GoalEventDetails extends Google_Model
{
    protected $__eventConditionsType = "Google_GoalEventDetailsEventConditions";
    protected $__eventConditionsDataType = "array";
    public $eventConditions = NULL;
    public $useEventValue = NULL;
    public function setEventConditions($eventConditions)
    {
        $this->assertIsArray($eventConditions, "Google_GoalEventDetailsEventConditions", "Google_GoalEventDetails::setEventConditions");
        $this->eventConditions = $eventConditions;
    }
    public function getEventConditions()
    {
        return $this->eventConditions;
    }
    public function setUseEventValue($useEventValue)
    {
        $this->useEventValue = $useEventValue;
    }
    public function getUseEventValue()
    {
        return $this->useEventValue;
    }
}
class Google_GoalEventDetailsEventConditions extends Google_Model
{
    public $type = NULL;
    public $matchType = NULL;
    public $expression = NULL;
    public $comparisonType = NULL;
    public $comparisonValue = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setMatchType($matchType)
    {
        $this->matchType = $matchType;
    }
    public function getMatchType()
    {
        return $this->matchType;
    }
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }
    public function getExpression()
    {
        return $this->expression;
    }
    public function setComparisonType($comparisonType)
    {
        $this->comparisonType = $comparisonType;
    }
    public function getComparisonType()
    {
        return $this->comparisonType;
    }
    public function setComparisonValue($comparisonValue)
    {
        $this->comparisonValue = $comparisonValue;
    }
    public function getComparisonValue()
    {
        return $this->comparisonValue;
    }
}
class Google_GoalParentLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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
class Google_GoalUrlDestinationDetails extends Google_Model
{
    public $url = NULL;
    public $caseSensitive = NULL;
    public $matchType = NULL;
    protected $__stepsType = "Google_GoalUrlDestinationDetailsSteps";
    protected $__stepsDataType = "array";
    public $steps = NULL;
    public $firstStepRequired = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setCaseSensitive($caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
    }
    public function getCaseSensitive()
    {
        return $this->caseSensitive;
    }
    public function setMatchType($matchType)
    {
        $this->matchType = $matchType;
    }
    public function getMatchType()
    {
        return $this->matchType;
    }
    public function setSteps($steps)
    {
        $this->assertIsArray($steps, "Google_GoalUrlDestinationDetailsSteps", "Google_GoalUrlDestinationDetails::setSteps");
        $this->steps = $steps;
    }
    public function getSteps()
    {
        return $this->steps;
    }
    public function setFirstStepRequired($firstStepRequired)
    {
        $this->firstStepRequired = $firstStepRequired;
    }
    public function getFirstStepRequired()
    {
        return $this->firstStepRequired;
    }
}
class Google_GoalUrlDestinationDetailsSteps extends Google_Model
{
    public $url = NULL;
    public $name = NULL;
    public $number = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setNumber($number)
    {
        $this->number = $number;
    }
    public function getNumber()
    {
        return $this->number;
    }
}
class Google_GoalVisitNumPagesDetails extends Google_Model
{
    public $comparisonType = NULL;
    public $comparisonValue = NULL;
    public function setComparisonType($comparisonType)
    {
        $this->comparisonType = $comparisonType;
    }
    public function getComparisonType()
    {
        return $this->comparisonType;
    }
    public function setComparisonValue($comparisonValue)
    {
        $this->comparisonValue = $comparisonValue;
    }
    public function getComparisonValue()
    {
        return $this->comparisonValue;
    }
}
class Google_GoalVisitTimeOnSiteDetails extends Google_Model
{
    public $comparisonType = NULL;
    public $comparisonValue = NULL;
    public function setComparisonType($comparisonType)
    {
        $this->comparisonType = $comparisonType;
    }
    public function getComparisonType()
    {
        return $this->comparisonType;
    }
    public function setComparisonValue($comparisonValue)
    {
        $this->comparisonValue = $comparisonValue;
    }
    public function getComparisonValue()
    {
        return $this->comparisonValue;
    }
}
class Google_Goals extends Google_Model
{
    public $username = NULL;
    public $kind = NULL;
    protected $__itemsType = "Google_Goal";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $itemsPerPage = NULL;
    public $previousLink = NULL;
    public $startIndex = NULL;
    public $nextLink = NULL;
    public $totalResults = NULL;
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Goal", "Google_Goals::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
class Google_McfData extends Google_Model
{
    public $kind = NULL;
    protected $__rowsType = "Google_McfDataRows";
    protected $__rowsDataType = "array";
    public $rows = NULL;
    public $containsSampledData = NULL;
    public $totalResults = NULL;
    public $itemsPerPage = NULL;
    public $totalsForAllResults = NULL;
    public $nextLink = NULL;
    public $id = NULL;
    protected $__queryType = "Google_McfDataQuery";
    protected $__queryDataType = "";
    public $query = NULL;
    public $previousLink = NULL;
    protected $__profileInfoType = "Google_McfDataProfileInfo";
    protected $__profileInfoDataType = "";
    public $profileInfo = NULL;
    protected $__columnHeadersType = "Google_McfDataColumnHeaders";
    protected $__columnHeadersDataType = "array";
    public $columnHeaders = NULL;
    public $selfLink = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setRows($rows)
    {
        $this->assertIsArray($rows, "Google_McfDataRows", "Google_McfData::setRows");
        $this->rows = $rows;
    }
    public function getRows()
    {
        return $this->rows;
    }
    public function setContainsSampledData($containsSampledData)
    {
        $this->containsSampledData = $containsSampledData;
    }
    public function getContainsSampledData()
    {
        return $this->containsSampledData;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setTotalsForAllResults($totalsForAllResults)
    {
        $this->totalsForAllResults = $totalsForAllResults;
    }
    public function getTotalsForAllResults()
    {
        return $this->totalsForAllResults;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setQuery(Google_McfDataQuery $query)
    {
        $this->query = $query;
    }
    public function getQuery()
    {
        return $this->query;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setProfileInfo(Google_McfDataProfileInfo $profileInfo)
    {
        $this->profileInfo = $profileInfo;
    }
    public function getProfileInfo()
    {
        return $this->profileInfo;
    }
    public function setColumnHeaders($columnHeaders)
    {
        $this->assertIsArray($columnHeaders, "Google_McfDataColumnHeaders", "Google_McfData::setColumnHeaders");
        $this->columnHeaders = $columnHeaders;
    }
    public function getColumnHeaders()
    {
        return $this->columnHeaders;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
}
class Google_McfDataColumnHeaders extends Google_Model
{
    public $dataType = NULL;
    public $columnType = NULL;
    public $name = NULL;
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }
    public function getDataType()
    {
        return $this->dataType;
    }
    public function setColumnType($columnType)
    {
        $this->columnType = $columnType;
    }
    public function getColumnType()
    {
        return $this->columnType;
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
class Google_McfDataProfileInfo extends Google_Model
{
    public $webPropertyId = NULL;
    public $internalWebPropertyId = NULL;
    public $tableId = NULL;
    public $profileId = NULL;
    public $profileName = NULL;
    public $accountId = NULL;
    public function setWebPropertyId($webPropertyId)
    {
        $this->webPropertyId = $webPropertyId;
    }
    public function getWebPropertyId()
    {
        return $this->webPropertyId;
    }
    public function setInternalWebPropertyId($internalWebPropertyId)
    {
        $this->internalWebPropertyId = $internalWebPropertyId;
    }
    public function getInternalWebPropertyId()
    {
        return $this->internalWebPropertyId;
    }
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
    }
    public function getTableId()
    {
        return $this->tableId;
    }
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }
    public function getProfileId()
    {
        return $this->profileId;
    }
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;
    }
    public function getProfileName()
    {
        return $this->profileName;
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
class Google_McfDataQuery extends Google_Model
{
    public $max_results = NULL;
    public $sort = NULL;
    public $dimensions = NULL;
    public $start_date = NULL;
    public $start_index = NULL;
    public $segment = NULL;
    public $ids = NULL;
    public $metrics = NULL;
    public $filters = NULL;
    public $end_date = NULL;
    public function setMax_results($max_results)
    {
        $this->max_results = $max_results;
    }
    public function getMax_results()
    {
        return $this->max_results;
    }
    public function setSort($sort)
    {
        $this->assertIsArray($sort, "Google_string", "Google_McfDataQuery::setSort");
        $this->sort = $sort;
    }
    public function getSort()
    {
        return $this->sort;
    }
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }
    public function getDimensions()
    {
        return $this->dimensions;
    }
    public function setStart_date($start_date)
    {
        $this->start_date = $start_date;
    }
    public function getStart_date()
    {
        return $this->start_date;
    }
    public function setStart_index($start_index)
    {
        $this->start_index = $start_index;
    }
    public function getStart_index()
    {
        return $this->start_index;
    }
    public function setSegment($segment)
    {
        $this->segment = $segment;
    }
    public function getSegment()
    {
        return $this->segment;
    }
    public function setIds($ids)
    {
        $this->ids = $ids;
    }
    public function getIds()
    {
        return $this->ids;
    }
    public function setMetrics($metrics)
    {
        $this->assertIsArray($metrics, "Google_string", "Google_McfDataQuery::setMetrics");
        $this->metrics = $metrics;
    }
    public function getMetrics()
    {
        return $this->metrics;
    }
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }
    public function getFilters()
    {
        return $this->filters;
    }
    public function setEnd_date($end_date)
    {
        $this->end_date = $end_date;
    }
    public function getEnd_date()
    {
        return $this->end_date;
    }
}
class Google_McfDataRows extends Google_Model
{
    public $primitiveValue = NULL;
    protected $__conversionPathValueType = "Google_McfDataRowsConversionPathValue";
    protected $__conversionPathValueDataType = "array";
    public $conversionPathValue = NULL;
    public function setPrimitiveValue($primitiveValue)
    {
        $this->primitiveValue = $primitiveValue;
    }
    public function getPrimitiveValue()
    {
        return $this->primitiveValue;
    }
    public function setConversionPathValue($conversionPathValue)
    {
        $this->assertIsArray($conversionPathValue, "Google_McfDataRowsConversionPathValue", "Google_McfDataRows::setConversionPathValue");
        $this->conversionPathValue = $conversionPathValue;
    }
    public function getConversionPathValue()
    {
        return $this->conversionPathValue;
    }
}
class Google_McfDataRowsConversionPathValue extends Google_Model
{
    public $nodeValue = NULL;
    public $interactionType = NULL;
    public function setNodeValue($nodeValue)
    {
        $this->nodeValue = $nodeValue;
    }
    public function getNodeValue()
    {
        return $this->nodeValue;
    }
    public function setInteractionType($interactionType)
    {
        $this->interactionType = $interactionType;
    }
    public function getInteractionType()
    {
        return $this->interactionType;
    }
}
class Google_Profile extends Google_Model
{
    public $defaultPage = NULL;
    public $kind = NULL;
    public $excludeQueryParameters = NULL;
    public $name = NULL;
    public $created = NULL;
    public $webPropertyId = NULL;
    public $updated = NULL;
    public $siteSearchQueryParameters = NULL;
    public $currency = NULL;
    public $internalWebPropertyId = NULL;
    protected $__childLinkType = "Google_ProfileChildLink";
    protected $__childLinkDataType = "";
    public $childLink = NULL;
    public $timezone = NULL;
    public $siteSearchCategoryParameters = NULL;
    protected $__parentLinkType = "Google_ProfileParentLink";
    protected $__parentLinkDataType = "";
    public $parentLink = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public $accountId = NULL;
    public function setDefaultPage($defaultPage)
    {
        $this->defaultPage = $defaultPage;
    }
    public function getDefaultPage()
    {
        return $this->defaultPage;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setExcludeQueryParameters($excludeQueryParameters)
    {
        $this->excludeQueryParameters = $excludeQueryParameters;
    }
    public function getExcludeQueryParameters()
    {
        return $this->excludeQueryParameters;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setWebPropertyId($webPropertyId)
    {
        $this->webPropertyId = $webPropertyId;
    }
    public function getWebPropertyId()
    {
        return $this->webPropertyId;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setSiteSearchQueryParameters($siteSearchQueryParameters)
    {
        $this->siteSearchQueryParameters = $siteSearchQueryParameters;
    }
    public function getSiteSearchQueryParameters()
    {
        return $this->siteSearchQueryParameters;
    }
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    public function getCurrency()
    {
        return $this->currency;
    }
    public function setInternalWebPropertyId($internalWebPropertyId)
    {
        $this->internalWebPropertyId = $internalWebPropertyId;
    }
    public function getInternalWebPropertyId()
    {
        return $this->internalWebPropertyId;
    }
    public function setChildLink(Google_ProfileChildLink $childLink)
    {
        $this->childLink = $childLink;
    }
    public function getChildLink()
    {
        return $this->childLink;
    }
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }
    public function getTimezone()
    {
        return $this->timezone;
    }
    public function setSiteSearchCategoryParameters($siteSearchCategoryParameters)
    {
        $this->siteSearchCategoryParameters = $siteSearchCategoryParameters;
    }
    public function getSiteSearchCategoryParameters()
    {
        return $this->siteSearchCategoryParameters;
    }
    public function setParentLink(Google_ProfileParentLink $parentLink)
    {
        $this->parentLink = $parentLink;
    }
    public function getParentLink()
    {
        return $this->parentLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
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
class Google_ProfileChildLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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
class Google_ProfileParentLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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
class Google_Profiles extends Google_Model
{
    public $username = NULL;
    public $kind = NULL;
    protected $__itemsType = "Google_Profile";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $itemsPerPage = NULL;
    public $previousLink = NULL;
    public $startIndex = NULL;
    public $nextLink = NULL;
    public $totalResults = NULL;
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Profile", "Google_Profiles::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
class Google_Segment extends Google_Model
{
    public $definition = NULL;
    public $kind = NULL;
    public $segmentId = NULL;
    public $created = NULL;
    public $updated = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public $name = NULL;
    public function setDefinition($definition)
    {
        $this->definition = $definition;
    }
    public function getDefinition()
    {
        return $this->definition;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setSegmentId($segmentId)
    {
        $this->segmentId = $segmentId;
    }
    public function getSegmentId()
    {
        return $this->segmentId;
    }
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
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
class Google_Segments extends Google_Model
{
    public $username = NULL;
    public $kind = NULL;
    protected $__itemsType = "Google_Segment";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $itemsPerPage = NULL;
    public $previousLink = NULL;
    public $startIndex = NULL;
    public $nextLink = NULL;
    public $totalResults = NULL;
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Segment", "Google_Segments::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
class Google_Webproperties extends Google_Model
{
    public $username = NULL;
    public $kind = NULL;
    protected $__itemsType = "Google_Webproperty";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $itemsPerPage = NULL;
    public $previousLink = NULL;
    public $startIndex = NULL;
    public $nextLink = NULL;
    public $totalResults = NULL;
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Webproperty", "Google_Webproperties::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
    public function setPreviousLink($previousLink)
    {
        $this->previousLink = $previousLink;
    }
    public function getPreviousLink()
    {
        return $this->previousLink;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
}
class Google_Webproperty extends Google_Model
{
    public $kind = NULL;
    public $name = NULL;
    public $created = NULL;
    public $updated = NULL;
    public $websiteUrl = NULL;
    public $internalWebPropertyId = NULL;
    protected $__childLinkType = "Google_WebpropertyChildLink";
    protected $__childLinkDataType = "";
    public $childLink = NULL;
    protected $__parentLinkType = "Google_WebpropertyParentLink";
    protected $__parentLinkDataType = "";
    public $parentLink = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public $accountId = NULL;
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
    public function setCreated($created)
    {
        $this->created = $created;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }
    public function setInternalWebPropertyId($internalWebPropertyId)
    {
        $this->internalWebPropertyId = $internalWebPropertyId;
    }
    public function getInternalWebPropertyId()
    {
        return $this->internalWebPropertyId;
    }
    public function setChildLink(Google_WebpropertyChildLink $childLink)
    {
        $this->childLink = $childLink;
    }
    public function getChildLink()
    {
        return $this->childLink;
    }
    public function setParentLink(Google_WebpropertyParentLink $parentLink)
    {
        $this->parentLink = $parentLink;
    }
    public function getParentLink()
    {
        return $this->parentLink;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
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
class Google_WebpropertyChildLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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
class Google_WebpropertyParentLink extends Google_Model
{
    public $href = NULL;
    public $type = NULL;
    public function setHref($href)
    {
        $this->href = $href;
    }
    public function getHref()
    {
        return $this->href;
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

?>