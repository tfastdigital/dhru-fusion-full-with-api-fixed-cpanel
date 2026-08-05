<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "urlchannels" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $urlchannels = $adsensehostService->urlchannels;
 *  </code>
 */
class Google_UrlchannelsServiceResource extends Google_ServiceResource
{
    public function insert($adClientId, Google_UrlChannel $postBody, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_UrlChannel($data);
        }
        return $data;
    }
    public function listUrlchannels($adClientId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_UrlChannels($data);
        }
        return $data;
    }
    public function delete($adClientId, $urlChannelId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "urlChannelId" => $urlChannelId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        if ($this->useObjects()) {
            return new Google_UrlChannel($data);
        }
        return $data;
    }
}
/**
 * The "adclients" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $adclients = $adsensehostService->adclients;
 *  </code>
 */
class Google_AdclientsServiceResource extends Google_ServiceResource
{
    public function listAdclients($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_AdClients($data);
        }
        return $data;
    }
    public function get($adClientId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_AdClient($data);
        }
        return $data;
    }
}
/**
 * The "associationsessions" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $associationsessions = $adsensehostService->associationsessions;
 *  </code>
 */
class Google_AssociationsessionsServiceResource extends Google_ServiceResource
{
    public function start($productCode, $websiteUrl, $optParams = [])
    {
        $params = ["productCode" => $productCode, "websiteUrl" => $websiteUrl];
        $params = array_merge($params, $optParams);
        $data = $this->__call("start", [$params]);
        if ($this->useObjects()) {
            return new Google_AssociationSession($data);
        }
        return $data;
    }
    public function verify($token, $optParams = [])
    {
        $params = ["token" => $token];
        $params = array_merge($params, $optParams);
        $data = $this->__call("verify", [$params]);
        if ($this->useObjects()) {
            return new Google_AssociationSession($data);
        }
        return $data;
    }
}
/**
 * The "reports" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $reports = $adsensehostService->reports;
 *  </code>
 */
class Google_ReportsServiceResource extends Google_ServiceResource
{
    public function generate($endDate, $startDate, $optParams = [])
    {
        $params = ["endDate" => $endDate, "startDate" => $startDate];
        $params = array_merge($params, $optParams);
        $data = $this->__call("generate", [$params]);
        if ($this->useObjects()) {
            return new Google_Report($data);
        }
        return $data;
    }
}
/**
 * The "accounts" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $accounts = $adsensehostService->accounts;
 *  </code>
 */
class Google_AccountsServiceResource extends Google_ServiceResource
{
    public function listAccounts($filterAdClientId, $optParams = [])
    {
        $params = ["filterAdClientId" => $filterAdClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Accounts($data);
        }
        return $data;
    }
    public function get($accountId, $optParams = [])
    {
        $params = ["accountId" => $accountId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Account($data);
        }
        return $data;
    }
}
/**
 * The "adunits" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $adunits = $adsensehostService->adunits;
 *  </code>
 */
class Google_AccountsAdunitsServiceResource extends Google_ServiceResource
{
    public function insert($accountId, $adClientId, Google_AdUnit $postBody, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnit($data);
        }
        return $data;
    }
    public function get($accountId, $adClientId, $adUnitId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "adUnitId" => $adUnitId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnit($data);
        }
        return $data;
    }
    public function getAdCode($accountId, $adClientId, $adUnitId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "adUnitId" => $adUnitId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("getAdCode", [$params]);
        if ($this->useObjects()) {
            return new Google_AdCode($data);
        }
        return $data;
    }
    public function listAccountsAdunits($accountId, $adClientId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnits($data);
        }
        return $data;
    }
    public function update($accountId, $adClientId, Google_AdUnit $postBody, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnit($data);
        }
        return $data;
    }
    public function patch($accountId, $adClientId, $adUnitId, Google_AdUnit $postBody, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "adUnitId" => $adUnitId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnit($data);
        }
        return $data;
    }
    public function delete($accountId, $adClientId, $adUnitId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId, "adUnitId" => $adUnitId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        if ($this->useObjects()) {
            return new Google_AdUnit($data);
        }
        return $data;
    }
}
/**
 * The "adclients" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $adclients = $adsensehostService->adclients;
 *  </code>
 */
class Google_AccountsAdclientsServiceResource extends Google_ServiceResource
{
    public function listAccountsAdclients($accountId, $optParams = [])
    {
        $params = ["accountId" => $accountId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_AdClients($data);
        }
        return $data;
    }
    public function get($accountId, $adClientId, $optParams = [])
    {
        $params = ["accountId" => $accountId, "adClientId" => $adClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_AdClient($data);
        }
        return $data;
    }
}
/**
 * The "reports" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $reports = $adsensehostService->reports;
 *  </code>
 */
class Google_AccountsReportsServiceResource extends Google_ServiceResource
{
    public function generate($accountId, $startDate, $endDate, $optParams = [])
    {
        $params = ["accountId" => $accountId, "startDate" => $startDate, "endDate" => $endDate];
        $params = array_merge($params, $optParams);
        $data = $this->__call("generate", [$params]);
        if ($this->useObjects()) {
            return new Google_Report($data);
        }
        return $data;
    }
}
/**
 * The "customchannels" collection of methods.
 * Typical usage is:
 *  <code>
 *   $adsensehostService = new Google_AdsensehostService(...);
 *   $customchannels = $adsensehostService->customchannels;
 *  </code>
 */
class Google_CustomchannelsServiceResource extends Google_ServiceResource
{
    public function insert($adClientId, Google_CustomChannel $postBody, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannel($data);
        }
        return $data;
    }
    public function get($adClientId, $customChannelId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "customChannelId" => $customChannelId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannel($data);
        }
        return $data;
    }
    public function listCustomchannels($adClientId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannels($data);
        }
        return $data;
    }
    public function update($adClientId, Google_CustomChannel $postBody, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("update", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannel($data);
        }
        return $data;
    }
    public function patch($adClientId, $customChannelId, Google_CustomChannel $postBody, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "customChannelId" => $customChannelId, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("patch", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannel($data);
        }
        return $data;
    }
    public function delete($adClientId, $customChannelId, $optParams = [])
    {
        $params = ["adClientId" => $adClientId, "customChannelId" => $customChannelId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("delete", [$params]);
        if ($this->useObjects()) {
            return new Google_CustomChannel($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Adsensehost (v4.1).
 *
 * <p>
 * Gives AdSense Hosts access to report generation, ad code generation, and publisher management capabilities.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/adsense/host/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_AdsensehostService extends Google_Service
{
    public $urlchannels = NULL;
    public $adclients = NULL;
    public $associationsessions = NULL;
    public $reports = NULL;
    public $accounts = NULL;
    public $accounts_adunits = NULL;
    public $accounts_adclients = NULL;
    public $accounts_reports = NULL;
    public $customchannels = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "adsensehost/v4.1/";
        $this->version = "v4.1";
        $this->serviceName = "adsensehost";
        $client->addService($this->serviceName, $this->version);
        $this->urlchannels = new Google_UrlchannelsServiceResource($this, $this->serviceName, "urlchannels", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"UrlChannel\"}, \"response\": {\"\$ref\": \"UrlChannel\"}, \"httpMethod\": \"POST\", \"path\": \"adclients/{adClientId}/urlchannels\", \"id\": \"adsensehost.urlchannels.insert\"}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"10000\", \"format\": \"uint32\"}}, \"id\": \"adsensehost.urlchannels.list\", \"httpMethod\": \"GET\", \"path\": \"adclients/{adClientId}/urlchannels\", \"response\": {\"\$ref\": \"UrlChannels\"}}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"urlChannelId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.urlchannels.delete\", \"httpMethod\": \"DELETE\", \"path\": \"adclients/{adClientId}/urlchannels/{urlChannelId}\", \"response\": {\"\$ref\": \"UrlChannel\"}}}}", true));
        $this->adclients = new Google_AdclientsServiceResource($this, $this->serviceName, "adclients", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"10000\", \"format\": \"uint32\"}}, \"response\": {\"\$ref\": \"AdClients\"}, \"httpMethod\": \"GET\", \"path\": \"adclients\", \"id\": \"adsensehost.adclients.list\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.adclients.get\", \"httpMethod\": \"GET\", \"path\": \"adclients/{adClientId}\", \"response\": {\"\$ref\": \"AdClient\"}}}}", true));
        $this->associationsessions = new Google_AssociationsessionsServiceResource($this, $this->serviceName, "associationsessions", json_decode("{\"methods\": {\"start\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"websiteLocale\": {\"type\": \"string\", \"location\": \"query\"}, \"productCode\": {\"repeated\": true, \"required\": true, \"type\": \"string\", \"location\": \"query\", \"enum\": [\"AFC\", \"AFF\", \"AFMC\", \"AFS\"]}, \"userLocale\": {\"type\": \"string\", \"location\": \"query\"}, \"websiteUrl\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"adsensehost.associationsessions.start\", \"httpMethod\": \"GET\", \"path\": \"associationsessions/start\", \"response\": {\"\$ref\": \"AssociationSession\"}}, \"verify\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"token\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"adsensehost.associationsessions.verify\", \"httpMethod\": \"GET\", \"path\": \"associationsessions/verify\", \"response\": {\"\$ref\": \"AssociationSession\"}}}}", true));
        $this->reports = new Google_ReportsServiceResource($this, $this->serviceName, "reports", json_decode("{\"methods\": {\"generate\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"sort\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"startDate\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"endDate\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"locale\": {\"type\": \"string\", \"location\": \"query\"}, \"metric\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"50000\", \"format\": \"uint32\"}, \"filter\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"startIndex\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"5000\", \"format\": \"uint32\"}, \"dimension\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"adsensehost.reports.generate\", \"httpMethod\": \"GET\", \"path\": \"reports\", \"response\": {\"\$ref\": \"Report\"}}}}", true));
        $this->accounts = new Google_AccountsServiceResource($this, $this->serviceName, "accounts", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"filterAdClientId\": {\"repeated\": true, \"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"adsensehost.accounts.list\", \"httpMethod\": \"GET\", \"path\": \"accounts\", \"response\": {\"\$ref\": \"Accounts\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.get\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}\", \"response\": {\"\$ref\": \"Account\"}}}}", true));
        $this->accounts_adunits = new Google_AccountsAdunitsServiceResource($this, $this->serviceName, "adunits", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AdUnit\"}, \"response\": {\"\$ref\": \"AdUnit\"}, \"httpMethod\": \"POST\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits\", \"id\": \"adsensehost.accounts.adunits.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"adUnitId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adunits.get\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits/{adUnitId}\", \"response\": {\"\$ref\": \"AdUnit\"}}, \"getAdCode\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"hostCustomChannelId\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"adUnitId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adunits.getAdCode\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits/{adUnitId}/adcode\", \"response\": {\"\$ref\": \"AdCode\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"includeInactive\": {\"type\": \"boolean\", \"location\": \"query\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"10000\", \"format\": \"uint32\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adunits.list\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits\", \"response\": {\"\$ref\": \"AdUnits\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AdUnit\"}, \"response\": {\"\$ref\": \"AdUnit\"}, \"httpMethod\": \"PUT\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits\", \"id\": \"adsensehost.accounts.adunits.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"adUnitId\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"AdUnit\"}, \"response\": {\"\$ref\": \"AdUnit\"}, \"httpMethod\": \"PATCH\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits\", \"id\": \"adsensehost.accounts.adunits.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"adUnitId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adunits.delete\", \"httpMethod\": \"DELETE\", \"path\": \"accounts/{accountId}/adclients/{adClientId}/adunits/{adUnitId}\", \"response\": {\"\$ref\": \"AdUnit\"}}}}", true));
        $this->accounts_adclients = new Google_AccountsAdclientsServiceResource($this, $this->serviceName, "adclients", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"10000\", \"format\": \"uint32\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adclients.list\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/adclients\", \"response\": {\"\$ref\": \"AdClients\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.adclients.get\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/adclients/{adClientId}\", \"response\": {\"\$ref\": \"AdClient\"}}}}", true));
        $this->accounts_reports = new Google_AccountsReportsServiceResource($this, $this->serviceName, "reports", json_decode("{\"methods\": {\"generate\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"sort\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"startDate\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"endDate\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"locale\": {\"type\": \"string\", \"location\": \"query\"}, \"metric\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"50000\", \"format\": \"uint32\"}, \"filter\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"startIndex\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"5000\", \"format\": \"uint32\"}, \"dimension\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"accountId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.accounts.reports.generate\", \"httpMethod\": \"GET\", \"path\": \"accounts/{accountId}/reports\", \"response\": {\"\$ref\": \"Report\"}}}}", true));
        $this->customchannels = new Google_CustomchannelsServiceResource($this, $this->serviceName, "customchannels", json_decode("{\"methods\": {\"insert\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"CustomChannel\"}, \"response\": {\"\$ref\": \"CustomChannel\"}, \"httpMethod\": \"POST\", \"path\": \"adclients/{adClientId}/customchannels\", \"id\": \"adsensehost.customchannels.insert\"}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"customChannelId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.customchannels.get\", \"httpMethod\": \"GET\", \"path\": \"adclients/{adClientId}/customchannels/{customChannelId}\", \"response\": {\"\$ref\": \"CustomChannel\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"location\": \"query\", \"minimum\": \"0\", \"type\": \"integer\", \"maximum\": \"10000\", \"format\": \"uint32\"}}, \"id\": \"adsensehost.customchannels.list\", \"httpMethod\": \"GET\", \"path\": \"adclients/{adClientId}/customchannels\", \"response\": {\"\$ref\": \"CustomChannels\"}}, \"update\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"CustomChannel\"}, \"response\": {\"\$ref\": \"CustomChannel\"}, \"httpMethod\": \"PUT\", \"path\": \"adclients/{adClientId}/customchannels\", \"id\": \"adsensehost.customchannels.update\"}, \"patch\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"customChannelId\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"request\": {\"\$ref\": \"CustomChannel\"}, \"response\": {\"\$ref\": \"CustomChannel\"}, \"httpMethod\": \"PATCH\", \"path\": \"adclients/{adClientId}/customchannels\", \"id\": \"adsensehost.customchannels.patch\"}, \"delete\": {\"scopes\": [\"https://www.googleapis.com/auth/adsensehost\"], \"parameters\": {\"customChannelId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"adClientId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"adsensehost.customchannels.delete\", \"httpMethod\": \"DELETE\", \"path\": \"adclients/{adClientId}/customchannels/{customChannelId}\", \"response\": {\"\$ref\": \"CustomChannel\"}}}}", true));
    }
}
class Google_Account extends Google_Model
{
    public $status = NULL;
    public $kind = NULL;
    public $id = NULL;
    public $name = NULL;
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
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
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
class Google_Accounts extends Google_Model
{
    protected $__itemsType = "Google_Account";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Account", "Google_Accounts::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_AdClient extends Google_Model
{
    public $productCode = NULL;
    public $kind = NULL;
    public $id = NULL;
    public $arcOptIn = NULL;
    public $supportsReporting = NULL;
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }
    public function getProductCode()
    {
        return $this->productCode;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setArcOptIn($arcOptIn)
    {
        $this->arcOptIn = $arcOptIn;
    }
    public function getArcOptIn()
    {
        return $this->arcOptIn;
    }
    public function setSupportsReporting($supportsReporting)
    {
        $this->supportsReporting = $supportsReporting;
    }
    public function getSupportsReporting()
    {
        return $this->supportsReporting;
    }
}
class Google_AdClients extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_AdClient";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
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
        $this->assertIsArray($items, "Google_AdClient", "Google_AdClients::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_AdCode extends Google_Model
{
    public $adCode = NULL;
    public $kind = NULL;
    public function setAdCode($adCode)
    {
        $this->adCode = $adCode;
    }
    public function getAdCode()
    {
        return $this->adCode;
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
class Google_AdStyle extends Google_Model
{
    public $corners = NULL;
    protected $__colorsType = "Google_AdStyleColors";
    protected $__colorsDataType = "";
    public $colors = NULL;
    protected $__fontType = "Google_AdStyleFont";
    protected $__fontDataType = "";
    public $font = NULL;
    public $kind = NULL;
    public function setCorners($corners)
    {
        $this->corners = $corners;
    }
    public function getCorners()
    {
        return $this->corners;
    }
    public function setColors(Google_AdStyleColors $colors)
    {
        $this->colors = $colors;
    }
    public function getColors()
    {
        return $this->colors;
    }
    public function setFont(Google_AdStyleFont $font)
    {
        $this->font = $font;
    }
    public function getFont()
    {
        return $this->font;
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
class Google_AdStyleColors extends Google_Model
{
    public $url = NULL;
    public $text = NULL;
    public $border = NULL;
    public $background = NULL;
    public $title = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setBorder($border)
    {
        $this->border = $border;
    }
    public function getBorder()
    {
        return $this->border;
    }
    public function setBackground($background)
    {
        $this->background = $background;
    }
    public function getBackground()
    {
        return $this->background;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
}
class Google_AdStyleFont extends Google_Model
{
    public $family = NULL;
    public $size = NULL;
    public function setFamily($family)
    {
        $this->family = $family;
    }
    public function getFamily()
    {
        return $this->family;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }
    public function getSize()
    {
        return $this->size;
    }
}
class Google_AdUnit extends Google_Model
{
    public $status = NULL;
    public $kind = NULL;
    public $code = NULL;
    public $name = NULL;
    protected $__contentAdsSettingsType = "Google_AdUnitContentAdsSettings";
    protected $__contentAdsSettingsDataType = "";
    public $contentAdsSettings = NULL;
    public $id = NULL;
    protected $__mobileContentAdsSettingsType = "Google_AdUnitMobileContentAdsSettings";
    protected $__mobileContentAdsSettingsDataType = "";
    public $mobileContentAdsSettings = NULL;
    protected $__customStyleType = "Google_AdStyle";
    protected $__customStyleDataType = "";
    public $customStyle = NULL;
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
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setContentAdsSettings(Google_AdUnitContentAdsSettings $contentAdsSettings)
    {
        $this->contentAdsSettings = $contentAdsSettings;
    }
    public function getContentAdsSettings()
    {
        return $this->contentAdsSettings;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setMobileContentAdsSettings(Google_AdUnitMobileContentAdsSettings $mobileContentAdsSettings)
    {
        $this->mobileContentAdsSettings = $mobileContentAdsSettings;
    }
    public function getMobileContentAdsSettings()
    {
        return $this->mobileContentAdsSettings;
    }
    public function setCustomStyle(Google_AdStyle $customStyle)
    {
        $this->customStyle = $customStyle;
    }
    public function getCustomStyle()
    {
        return $this->customStyle;
    }
}
class Google_AdUnitContentAdsSettings extends Google_Model
{
    public $type = NULL;
    protected $__backupOptionType = "Google_AdUnitContentAdsSettingsBackupOption";
    protected $__backupOptionDataType = "";
    public $backupOption = NULL;
    public $size = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setBackupOption(Google_AdUnitContentAdsSettingsBackupOption $backupOption)
    {
        $this->backupOption = $backupOption;
    }
    public function getBackupOption()
    {
        return $this->backupOption;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }
    public function getSize()
    {
        return $this->size;
    }
}
class Google_AdUnitContentAdsSettingsBackupOption extends Google_Model
{
    public $color = NULL;
    public $url = NULL;
    public $type = NULL;
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
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
class Google_AdUnitMobileContentAdsSettings extends Google_Model
{
    public $scriptingLanguage = NULL;
    public $type = NULL;
    public $markupLanguage = NULL;
    public $size = NULL;
    public function setScriptingLanguage($scriptingLanguage)
    {
        $this->scriptingLanguage = $scriptingLanguage;
    }
    public function getScriptingLanguage()
    {
        return $this->scriptingLanguage;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setMarkupLanguage($markupLanguage)
    {
        $this->markupLanguage = $markupLanguage;
    }
    public function getMarkupLanguage()
    {
        return $this->markupLanguage;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }
    public function getSize()
    {
        return $this->size;
    }
}
class Google_AdUnits extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_AdUnit";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
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
        $this->assertIsArray($items, "Google_AdUnit", "Google_AdUnits::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_AssociationSession extends Google_Model
{
    public $status = NULL;
    public $productCodes = NULL;
    public $kind = NULL;
    public $userLocale = NULL;
    public $websiteLocale = NULL;
    public $redirectUrl = NULL;
    public $websiteUrl = NULL;
    public $id = NULL;
    public $accountId = NULL;
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setProductCodes($productCodes)
    {
        $this->productCodes = $productCodes;
    }
    public function getProductCodes()
    {
        return $this->productCodes;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setUserLocale($userLocale)
    {
        $this->userLocale = $userLocale;
    }
    public function getUserLocale()
    {
        return $this->userLocale;
    }
    public function setWebsiteLocale($websiteLocale)
    {
        $this->websiteLocale = $websiteLocale;
    }
    public function getWebsiteLocale()
    {
        return $this->websiteLocale;
    }
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
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
class Google_CustomChannel extends Google_Model
{
    public $kind = NULL;
    public $code = NULL;
    public $id = NULL;
    public $name = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setCode($code)
    {
        $this->code = $code;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
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
class Google_CustomChannels extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_CustomChannel";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
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
        $this->assertIsArray($items, "Google_CustomChannel", "Google_CustomChannels::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}
class Google_Report extends Google_Model
{
    public $kind = NULL;
    public $rows = NULL;
    public $warnings = NULL;
    public $totals = NULL;
    protected $__headersType = "Google_ReportHeaders";
    protected $__headersDataType = "array";
    public $headers = NULL;
    public $totalMatchedRows = NULL;
    public $averages = NULL;
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
        $this->rows = $rows;
    }
    public function getRows()
    {
        return $this->rows;
    }
    public function setWarnings($warnings)
    {
        $this->warnings = $warnings;
    }
    public function getWarnings()
    {
        return $this->warnings;
    }
    public function setTotals($totals)
    {
        $this->totals = $totals;
    }
    public function getTotals()
    {
        return $this->totals;
    }
    public function setHeaders($headers)
    {
        $this->assertIsArray($headers, "Google_ReportHeaders", "Google_Report::setHeaders");
        $this->headers = $headers;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function setTotalMatchedRows($totalMatchedRows)
    {
        $this->totalMatchedRows = $totalMatchedRows;
    }
    public function getTotalMatchedRows()
    {
        return $this->totalMatchedRows;
    }
    public function setAverages($averages)
    {
        $this->averages = $averages;
    }
    public function getAverages()
    {
        return $this->averages;
    }
}
class Google_ReportHeaders extends Google_Model
{
    public $currency = NULL;
    public $type = NULL;
    public $name = NULL;
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    public function getCurrency()
    {
        return $this->currency;
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
class Google_UrlChannel extends Google_Model
{
    public $kind = NULL;
    public $id = NULL;
    public $urlPattern = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setUrlPattern($urlPattern)
    {
        $this->urlPattern = $urlPattern;
    }
    public function getUrlPattern()
    {
        return $this->urlPattern;
    }
}
class Google_UrlChannels extends Google_Model
{
    public $nextPageToken = NULL;
    protected $__itemsType = "Google_UrlChannel";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $etag = NULL;
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
        $this->assertIsArray($items, "Google_UrlChannel", "Google_UrlChannels::setItems");
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
}

?>