<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "pagespeedapi" collection of methods.
 * Typical usage is:
 *  <code>
 *   $pagespeedonlineService = new Google_PagespeedonlineService(...);
 *   $pagespeedapi = $pagespeedonlineService->pagespeedapi;
 *  </code>
 */
class Google_PagespeedapiServiceResource extends Google_ServiceResource
{
    public function runpagespeed($url, $optParams = [])
    {
        $params = ["url" => $url];
        $params = array_merge($params, $optParams);
        $data = $this->__call("runpagespeed", [$params]);
        if ($this->useObjects()) {
            return new Google_Result($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Pagespeedonline (v1).
 *
 * <p>
 * Lets you analyze the performance of a web page and get tailored suggestions to make that page faster.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://code.google.com/apis/pagespeedonline/v1/getting_started.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_PagespeedonlineService extends Google_Service
{
    public $pagespeedapi = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "pagespeedonline/v1/";
        $this->version = "v1";
        $this->serviceName = "pagespeedonline";
        $client->addService($this->serviceName, $this->version);
        $this->pagespeedapi = new Google_PagespeedapiServiceResource($this, $this->serviceName, "pagespeedapi", json_decode("{\"methods\": {\"runpagespeed\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"Result\"}, \"id\": \"pagespeedonline.pagespeedapi.runpagespeed\", \"parameters\": {\"locale\": {\"type\": \"string\", \"location\": \"query\"}, \"url\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"rule\": {\"repeated\": true, \"type\": \"string\", \"location\": \"query\"}, \"strategy\": {\"enum\": [\"desktop\", \"mobile\"], \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"runPagespeed\"}}}", true));
    }
}
class Google_Result extends Google_Model
{
    public $kind = NULL;
    protected $__formattedResultsType = "Google_ResultFormattedResults";
    protected $__formattedResultsDataType = "";
    public $formattedResults = NULL;
    public $title = NULL;
    protected $__versionType = "Google_ResultVersion";
    protected $__versionDataType = "";
    public $version = NULL;
    public $score = NULL;
    public $responseCode = NULL;
    public $invalidRules = NULL;
    protected $__pageStatsType = "Google_ResultPageStats";
    protected $__pageStatsDataType = "";
    public $pageStats = NULL;
    public $id = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setFormattedResults(Google_ResultFormattedResults $formattedResults)
    {
        $this->formattedResults = $formattedResults;
    }
    public function getFormattedResults()
    {
        return $this->formattedResults;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setVersion(Google_ResultVersion $version)
    {
        $this->version = $version;
    }
    public function getVersion()
    {
        return $this->version;
    }
    public function setScore($score)
    {
        $this->score = $score;
    }
    public function getScore()
    {
        return $this->score;
    }
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    public function setInvalidRules($invalidRules)
    {
        $this->assertIsArray($invalidRules, "Google_string", "Google_Result::setInvalidRules");
        $this->invalidRules = $invalidRules;
    }
    public function getInvalidRules()
    {
        return $this->invalidRules;
    }
    public function setPageStats(Google_ResultPageStats $pageStats)
    {
        $this->pageStats = $pageStats;
    }
    public function getPageStats()
    {
        return $this->pageStats;
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
class Google_ResultFormattedResults extends Google_Model
{
    public $locale = NULL;
    protected $__ruleResultsType = "Google_ResultFormattedResultsRuleResults";
    protected $__ruleResultsDataType = "map";
    public $ruleResults = NULL;
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
    public function getLocale()
    {
        return $this->locale;
    }
    public function setRuleResults(Google_ResultFormattedResultsRuleResults $ruleResults)
    {
        $this->ruleResults = $ruleResults;
    }
    public function getRuleResults()
    {
        return $this->ruleResults;
    }
}
class Google_ResultFormattedResultsRuleResults extends Google_Model
{
    public $localizedRuleName = NULL;
    protected $__urlBlocksType = "Google_ResultFormattedResultsRuleResultsUrlBlocks";
    protected $__urlBlocksDataType = "array";
    public $urlBlocks = NULL;
    public $ruleScore = NULL;
    public $ruleImpact = NULL;
    public function setLocalizedRuleName($localizedRuleName)
    {
        $this->localizedRuleName = $localizedRuleName;
    }
    public function getLocalizedRuleName()
    {
        return $this->localizedRuleName;
    }
    public function setUrlBlocks($urlBlocks)
    {
        $this->assertIsArray($urlBlocks, "Google_ResultFormattedResultsRuleResultsUrlBlocks", "Google_ResultFormattedResultsRuleResults::setUrlBlocks");
        $this->urlBlocks = $urlBlocks;
    }
    public function getUrlBlocks()
    {
        return $this->urlBlocks;
    }
    public function setRuleScore($ruleScore)
    {
        $this->ruleScore = $ruleScore;
    }
    public function getRuleScore()
    {
        return $this->ruleScore;
    }
    public function setRuleImpact($ruleImpact)
    {
        $this->ruleImpact = $ruleImpact;
    }
    public function getRuleImpact()
    {
        return $this->ruleImpact;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocks extends Google_Model
{
    protected $__headerType = "Google_ResultFormattedResultsRuleResultsUrlBlocksHeader";
    protected $__headerDataType = "";
    public $header = NULL;
    protected $__urlsType = "Google_ResultFormattedResultsRuleResultsUrlBlocksUrls";
    protected $__urlsDataType = "array";
    public $urls = NULL;
    public function setHeader(Google_ResultFormattedResultsRuleResultsUrlBlocksHeader $header)
    {
        $this->header = $header;
    }
    public function getHeader()
    {
        return $this->header;
    }
    public function setUrls($urls)
    {
        $this->assertIsArray($urls, "Google_ResultFormattedResultsRuleResultsUrlBlocksUrls", "Google_ResultFormattedResultsRuleResultsUrlBlocks::setUrls");
        $this->urls = $urls;
    }
    public function getUrls()
    {
        return $this->urls;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksHeader extends Google_Model
{
    protected $__argsType = "Google_ResultFormattedResultsRuleResultsUrlBlocksHeaderArgs";
    protected $__argsDataType = "array";
    public $args = NULL;
    public $format = NULL;
    public function setArgs($args)
    {
        $this->assertIsArray($args, "Google_ResultFormattedResultsRuleResultsUrlBlocksHeaderArgs", "Google_ResultFormattedResultsRuleResultsUrlBlocksHeader::setArgs");
        $this->args = $args;
    }
    public function getArgs()
    {
        return $this->args;
    }
    public function setFormat($format)
    {
        $this->format = $format;
    }
    public function getFormat()
    {
        return $this->format;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksHeaderArgs extends Google_Model
{
    public $type = NULL;
    public $value = NULL;
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
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksUrls extends Google_Model
{
    protected $__detailsType = "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetails";
    protected $__detailsDataType = "array";
    public $details = NULL;
    protected $__resultType = "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResult";
    protected $__resultDataType = "";
    public $result = NULL;
    public function setDetails($details)
    {
        $this->assertIsArray($details, "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetails", "Google_ResultFormattedResultsRuleResultsUrlBlocksUrls::setDetails");
        $this->details = $details;
    }
    public function getDetails()
    {
        return $this->details;
    }
    public function setResult(Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResult $result)
    {
        $this->result = $result;
    }
    public function getResult()
    {
        return $this->result;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetails extends Google_Model
{
    protected $__argsType = "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetailsArgs";
    protected $__argsDataType = "array";
    public $args = NULL;
    public $format = NULL;
    public function setArgs($args)
    {
        $this->assertIsArray($args, "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetailsArgs", "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetails::setArgs");
        $this->args = $args;
    }
    public function getArgs()
    {
        return $this->args;
    }
    public function setFormat($format)
    {
        $this->format = $format;
    }
    public function getFormat()
    {
        return $this->format;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsDetailsArgs extends Google_Model
{
    public $type = NULL;
    public $value = NULL;
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
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResult extends Google_Model
{
    protected $__argsType = "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResultArgs";
    protected $__argsDataType = "array";
    public $args = NULL;
    public $format = NULL;
    public function setArgs($args)
    {
        $this->assertIsArray($args, "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResultArgs", "Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResult::setArgs");
        $this->args = $args;
    }
    public function getArgs()
    {
        return $this->args;
    }
    public function setFormat($format)
    {
        $this->format = $format;
    }
    public function getFormat()
    {
        return $this->format;
    }
}
class Google_ResultFormattedResultsRuleResultsUrlBlocksUrlsResultArgs extends Google_Model
{
    public $type = NULL;
    public $value = NULL;
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
}
class Google_ResultPageStats extends Google_Model
{
    public $otherResponseBytes = NULL;
    public $flashResponseBytes = NULL;
    public $totalRequestBytes = NULL;
    public $numberCssResources = NULL;
    public $numberResources = NULL;
    public $cssResponseBytes = NULL;
    public $javascriptResponseBytes = NULL;
    public $imageResponseBytes = NULL;
    public $numberHosts = NULL;
    public $numberStaticResources = NULL;
    public $htmlResponseBytes = NULL;
    public $numberJsResources = NULL;
    public $textResponseBytes = NULL;
    public function setOtherResponseBytes($otherResponseBytes)
    {
        $this->otherResponseBytes = $otherResponseBytes;
    }
    public function getOtherResponseBytes()
    {
        return $this->otherResponseBytes;
    }
    public function setFlashResponseBytes($flashResponseBytes)
    {
        $this->flashResponseBytes = $flashResponseBytes;
    }
    public function getFlashResponseBytes()
    {
        return $this->flashResponseBytes;
    }
    public function setTotalRequestBytes($totalRequestBytes)
    {
        $this->totalRequestBytes = $totalRequestBytes;
    }
    public function getTotalRequestBytes()
    {
        return $this->totalRequestBytes;
    }
    public function setNumberCssResources($numberCssResources)
    {
        $this->numberCssResources = $numberCssResources;
    }
    public function getNumberCssResources()
    {
        return $this->numberCssResources;
    }
    public function setNumberResources($numberResources)
    {
        $this->numberResources = $numberResources;
    }
    public function getNumberResources()
    {
        return $this->numberResources;
    }
    public function setCssResponseBytes($cssResponseBytes)
    {
        $this->cssResponseBytes = $cssResponseBytes;
    }
    public function getCssResponseBytes()
    {
        return $this->cssResponseBytes;
    }
    public function setJavascriptResponseBytes($javascriptResponseBytes)
    {
        $this->javascriptResponseBytes = $javascriptResponseBytes;
    }
    public function getJavascriptResponseBytes()
    {
        return $this->javascriptResponseBytes;
    }
    public function setImageResponseBytes($imageResponseBytes)
    {
        $this->imageResponseBytes = $imageResponseBytes;
    }
    public function getImageResponseBytes()
    {
        return $this->imageResponseBytes;
    }
    public function setNumberHosts($numberHosts)
    {
        $this->numberHosts = $numberHosts;
    }
    public function getNumberHosts()
    {
        return $this->numberHosts;
    }
    public function setNumberStaticResources($numberStaticResources)
    {
        $this->numberStaticResources = $numberStaticResources;
    }
    public function getNumberStaticResources()
    {
        return $this->numberStaticResources;
    }
    public function setHtmlResponseBytes($htmlResponseBytes)
    {
        $this->htmlResponseBytes = $htmlResponseBytes;
    }
    public function getHtmlResponseBytes()
    {
        return $this->htmlResponseBytes;
    }
    public function setNumberJsResources($numberJsResources)
    {
        $this->numberJsResources = $numberJsResources;
    }
    public function getNumberJsResources()
    {
        return $this->numberJsResources;
    }
    public function setTextResponseBytes($textResponseBytes)
    {
        $this->textResponseBytes = $textResponseBytes;
    }
    public function getTextResponseBytes()
    {
        return $this->textResponseBytes;
    }
}
class Google_ResultVersion extends Google_Model
{
    public $major = NULL;
    public $minor = NULL;
    public function setMajor($major)
    {
        $this->major = $major;
    }
    public function getMajor()
    {
        return $this->major;
    }
    public function setMinor($minor)
    {
        $this->minor = $minor;
    }
    public function getMinor()
    {
        return $this->minor;
    }
}

?>