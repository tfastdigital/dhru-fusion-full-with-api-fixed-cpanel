<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "cse" collection of methods.
 * Typical usage is:
 *  <code>
 *   $customsearchService = new Google_CustomsearchService(...);
 *   $cse = $customsearchService->cse;
 *  </code>
 */
class Google_CseServiceResource extends Google_ServiceResource
{
    public function listCse($q, $optParams = [])
    {
        $params = ["q" => $q];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_Search($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Customsearch (v1).
 *
 * <p>
 * Lets you search over a website or collection of websites
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="http://code.google.com/apis/customsearch/v1/using_rest.html" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_CustomsearchService extends Google_Service
{
    public $cse = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "customsearch/";
        $this->version = "v1";
        $this->serviceName = "customsearch";
        $client->addService($this->serviceName, $this->version);
        $this->cse = new Google_CseServiceResource($this, $this->serviceName, "cse", json_decode("{\"methods\": {\"list\": {\"httpMethod\": \"GET\", \"response\": {\"\$ref\": \"Search\"}, \"id\": \"search.cse.list\", \"parameters\": {\"sort\": {\"type\": \"string\", \"location\": \"query\"}, \"orTerms\": {\"type\": \"string\", \"location\": \"query\"}, \"highRange\": {\"type\": \"string\", \"location\": \"query\"}, \"num\": {\"default\": \"10\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"cr\": {\"type\": \"string\", \"location\": \"query\"}, \"imgType\": {\"enum\": [\"clipart\", \"face\", \"lineart\", \"news\", \"photo\"], \"type\": \"string\", \"location\": \"query\"}, \"gl\": {\"type\": \"string\", \"location\": \"query\"}, \"q\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"relatedSite\": {\"type\": \"string\", \"location\": \"query\"}, \"searchType\": {\"enum\": [\"image\"], \"type\": \"string\", \"location\": \"query\"}, \"fileType\": {\"type\": \"string\", \"location\": \"query\"}, \"start\": {\"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"imgDominantColor\": {\"enum\": [\"black\", \"blue\", \"brown\", \"gray\", \"green\", \"pink\", \"purple\", \"teal\", \"white\", \"yellow\"], \"type\": \"string\", \"location\": \"query\"}, \"lr\": {\"enum\": [\"lang_ar\", \"lang_bg\", \"lang_ca\", \"lang_cs\", \"lang_da\", \"lang_de\", \"lang_el\", \"lang_en\", \"lang_es\", \"lang_et\", \"lang_fi\", \"lang_fr\", \"lang_hr\", \"lang_hu\", \"lang_id\", \"lang_is\", \"lang_it\", \"lang_iw\", \"lang_ja\", \"lang_ko\", \"lang_lt\", \"lang_lv\", \"lang_nl\", \"lang_no\", \"lang_pl\", \"lang_pt\", \"lang_ro\", \"lang_ru\", \"lang_sk\", \"lang_sl\", \"lang_sr\", \"lang_sv\", \"lang_tr\", \"lang_zh-CN\", \"lang_zh-TW\"], \"type\": \"string\", \"location\": \"query\"}, \"siteSearch\": {\"type\": \"string\", \"location\": \"query\"}, \"cref\": {\"type\": \"string\", \"location\": \"query\"}, \"dateRestrict\": {\"type\": \"string\", \"location\": \"query\"}, \"safe\": {\"default\": \"off\", \"enum\": [\"high\", \"medium\", \"off\"], \"type\": \"string\", \"location\": \"query\"}, \"c2coff\": {\"type\": \"string\", \"location\": \"query\"}, \"googlehost\": {\"type\": \"string\", \"location\": \"query\"}, \"hq\": {\"type\": \"string\", \"location\": \"query\"}, \"exactTerms\": {\"type\": \"string\", \"location\": \"query\"}, \"hl\": {\"type\": \"string\", \"location\": \"query\"}, \"lowRange\": {\"type\": \"string\", \"location\": \"query\"}, \"imgSize\": {\"enum\": [\"huge\", \"icon\", \"large\", \"medium\", \"small\", \"xlarge\", \"xxlarge\"], \"type\": \"string\", \"location\": \"query\"}, \"imgColorType\": {\"enum\": [\"color\", \"gray\", \"mono\"], \"type\": \"string\", \"location\": \"query\"}, \"rights\": {\"type\": \"string\", \"location\": \"query\"}, \"excludeTerms\": {\"type\": \"string\", \"location\": \"query\"}, \"filter\": {\"enum\": [\"0\", \"1\"], \"type\": \"string\", \"location\": \"query\"}, \"linkSite\": {\"type\": \"string\", \"location\": \"query\"}, \"cx\": {\"type\": \"string\", \"location\": \"query\"}, \"siteSearchFilter\": {\"enum\": [\"e\", \"i\"], \"type\": \"string\", \"location\": \"query\"}}, \"path\": \"v1\"}}}", true));
    }
}
class Google_Context extends Google_Model
{
    protected $__facetsType = "Google_ContextFacets";
    protected $__facetsDataType = "array";
    public $facets = NULL;
    public $title = NULL;
    public function setFacets($facets)
    {
        $this->assertIsArray($facets, "Google_ContextFacets", "Google_Context::setFacets");
        $this->facets = $facets;
    }
    public function getFacets()
    {
        return $this->facets;
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
class Google_ContextFacets extends Google_Model
{
    public $anchor = NULL;
    public $label = NULL;
    public function setAnchor($anchor)
    {
        $this->anchor = $anchor;
    }
    public function getAnchor()
    {
        return $this->anchor;
    }
    public function setLabel($label)
    {
        $this->label = $label;
    }
    public function getLabel()
    {
        return $this->label;
    }
}
class Google_Promotion extends Google_Model
{
    public $title = NULL;
    public $displayLink = NULL;
    public $htmlTitle = NULL;
    public $link = NULL;
    protected $__bodyLinesType = "Google_PromotionBodyLines";
    protected $__bodyLinesDataType = "array";
    public $bodyLines = NULL;
    protected $__imageType = "Google_PromotionImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setDisplayLink($displayLink)
    {
        $this->displayLink = $displayLink;
    }
    public function getDisplayLink()
    {
        return $this->displayLink;
    }
    public function setHtmlTitle($htmlTitle)
    {
        $this->htmlTitle = $htmlTitle;
    }
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setBodyLines($bodyLines)
    {
        $this->assertIsArray($bodyLines, "Google_PromotionBodyLines", "Google_Promotion::setBodyLines");
        $this->bodyLines = $bodyLines;
    }
    public function getBodyLines()
    {
        return $this->bodyLines;
    }
    public function setImage(Google_PromotionImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
}
class Google_PromotionBodyLines extends Google_Model
{
    public $url = NULL;
    public $htmlTitle = NULL;
    public $link = NULL;
    public $title = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setHtmlTitle($htmlTitle)
    {
        $this->htmlTitle = $htmlTitle;
    }
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
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
class Google_PromotionImage extends Google_Model
{
    public $source = NULL;
    public $width = NULL;
    public $height = NULL;
    public function setSource($source)
    {
        $this->source = $source;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
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
class Google_Query extends Google_Model
{
    public $sort = NULL;
    public $inputEncoding = NULL;
    public $orTerms = NULL;
    public $highRange = NULL;
    public $cx = NULL;
    public $startPage = NULL;
    public $disableCnTwTranslation = NULL;
    public $cr = NULL;
    public $imgType = NULL;
    public $gl = NULL;
    public $relatedSite = NULL;
    public $searchType = NULL;
    public $title = NULL;
    public $googleHost = NULL;
    public $fileType = NULL;
    public $imgDominantColor = NULL;
    public $siteSearch = NULL;
    public $cref = NULL;
    public $dateRestrict = NULL;
    public $safe = NULL;
    public $outputEncoding = NULL;
    public $hq = NULL;
    public $searchTerms = NULL;
    public $exactTerms = NULL;
    public $language = NULL;
    public $hl = NULL;
    public $totalResults = NULL;
    public $lowRange = NULL;
    public $count = NULL;
    public $imgSize = NULL;
    public $imgColorType = NULL;
    public $rights = NULL;
    public $startIndex = NULL;
    public $excludeTerms = NULL;
    public $filter = NULL;
    public $linkSite = NULL;
    public $siteSearchFilter = NULL;
    public function setSort($sort)
    {
        $this->sort = $sort;
    }
    public function getSort()
    {
        return $this->sort;
    }
    public function setInputEncoding($inputEncoding)
    {
        $this->inputEncoding = $inputEncoding;
    }
    public function getInputEncoding()
    {
        return $this->inputEncoding;
    }
    public function setOrTerms($orTerms)
    {
        $this->orTerms = $orTerms;
    }
    public function getOrTerms()
    {
        return $this->orTerms;
    }
    public function setHighRange($highRange)
    {
        $this->highRange = $highRange;
    }
    public function getHighRange()
    {
        return $this->highRange;
    }
    public function setCx($cx)
    {
        $this->cx = $cx;
    }
    public function getCx()
    {
        return $this->cx;
    }
    public function setStartPage($startPage)
    {
        $this->startPage = $startPage;
    }
    public function getStartPage()
    {
        return $this->startPage;
    }
    public function setDisableCnTwTranslation($disableCnTwTranslation)
    {
        $this->disableCnTwTranslation = $disableCnTwTranslation;
    }
    public function getDisableCnTwTranslation()
    {
        return $this->disableCnTwTranslation;
    }
    public function setCr($cr)
    {
        $this->cr = $cr;
    }
    public function getCr()
    {
        return $this->cr;
    }
    public function setImgType($imgType)
    {
        $this->imgType = $imgType;
    }
    public function getImgType()
    {
        return $this->imgType;
    }
    public function setGl($gl)
    {
        $this->gl = $gl;
    }
    public function getGl()
    {
        return $this->gl;
    }
    public function setRelatedSite($relatedSite)
    {
        $this->relatedSite = $relatedSite;
    }
    public function getRelatedSite()
    {
        return $this->relatedSite;
    }
    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
    }
    public function getSearchType()
    {
        return $this->searchType;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setGoogleHost($googleHost)
    {
        $this->googleHost = $googleHost;
    }
    public function getGoogleHost()
    {
        return $this->googleHost;
    }
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }
    public function getFileType()
    {
        return $this->fileType;
    }
    public function setImgDominantColor($imgDominantColor)
    {
        $this->imgDominantColor = $imgDominantColor;
    }
    public function getImgDominantColor()
    {
        return $this->imgDominantColor;
    }
    public function setSiteSearch($siteSearch)
    {
        $this->siteSearch = $siteSearch;
    }
    public function getSiteSearch()
    {
        return $this->siteSearch;
    }
    public function setCref($cref)
    {
        $this->cref = $cref;
    }
    public function getCref()
    {
        return $this->cref;
    }
    public function setDateRestrict($dateRestrict)
    {
        $this->dateRestrict = $dateRestrict;
    }
    public function getDateRestrict()
    {
        return $this->dateRestrict;
    }
    public function setSafe($safe)
    {
        $this->safe = $safe;
    }
    public function getSafe()
    {
        return $this->safe;
    }
    public function setOutputEncoding($outputEncoding)
    {
        $this->outputEncoding = $outputEncoding;
    }
    public function getOutputEncoding()
    {
        return $this->outputEncoding;
    }
    public function setHq($hq)
    {
        $this->hq = $hq;
    }
    public function getHq()
    {
        return $this->hq;
    }
    public function setSearchTerms($searchTerms)
    {
        $this->searchTerms = $searchTerms;
    }
    public function getSearchTerms()
    {
        return $this->searchTerms;
    }
    public function setExactTerms($exactTerms)
    {
        $this->exactTerms = $exactTerms;
    }
    public function getExactTerms()
    {
        return $this->exactTerms;
    }
    public function setLanguage($language)
    {
        $this->language = $language;
    }
    public function getLanguage()
    {
        return $this->language;
    }
    public function setHl($hl)
    {
        $this->hl = $hl;
    }
    public function getHl()
    {
        return $this->hl;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
    public function setLowRange($lowRange)
    {
        $this->lowRange = $lowRange;
    }
    public function getLowRange()
    {
        return $this->lowRange;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }
    public function getCount()
    {
        return $this->count;
    }
    public function setImgSize($imgSize)
    {
        $this->imgSize = $imgSize;
    }
    public function getImgSize()
    {
        return $this->imgSize;
    }
    public function setImgColorType($imgColorType)
    {
        $this->imgColorType = $imgColorType;
    }
    public function getImgColorType()
    {
        return $this->imgColorType;
    }
    public function setRights($rights)
    {
        $this->rights = $rights;
    }
    public function getRights()
    {
        return $this->rights;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setExcludeTerms($excludeTerms)
    {
        $this->excludeTerms = $excludeTerms;
    }
    public function getExcludeTerms()
    {
        return $this->excludeTerms;
    }
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }
    public function getFilter()
    {
        return $this->filter;
    }
    public function setLinkSite($linkSite)
    {
        $this->linkSite = $linkSite;
    }
    public function getLinkSite()
    {
        return $this->linkSite;
    }
    public function setSiteSearchFilter($siteSearchFilter)
    {
        $this->siteSearchFilter = $siteSearchFilter;
    }
    public function getSiteSearchFilter()
    {
        return $this->siteSearchFilter;
    }
}
class Google_Result extends Google_Model
{
    public $snippet = NULL;
    public $kind = NULL;
    protected $__labelsType = "Google_ResultLabels";
    protected $__labelsDataType = "array";
    public $labels = NULL;
    public $title = NULL;
    public $displayLink = NULL;
    public $cacheId = NULL;
    public $formattedUrl = NULL;
    public $htmlFormattedUrl = NULL;
    public $pagemap = NULL;
    public $htmlTitle = NULL;
    public $htmlSnippet = NULL;
    public $link = NULL;
    protected $__imageType = "Google_ResultImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $mime = NULL;
    public $fileFormat = NULL;
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;
    }
    public function getSnippet()
    {
        return $this->snippet;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setLabels($labels)
    {
        $this->assertIsArray($labels, "Google_ResultLabels", "Google_Result::setLabels");
        $this->labels = $labels;
    }
    public function getLabels()
    {
        return $this->labels;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setDisplayLink($displayLink)
    {
        $this->displayLink = $displayLink;
    }
    public function getDisplayLink()
    {
        return $this->displayLink;
    }
    public function setCacheId($cacheId)
    {
        $this->cacheId = $cacheId;
    }
    public function getCacheId()
    {
        return $this->cacheId;
    }
    public function setFormattedUrl($formattedUrl)
    {
        $this->formattedUrl = $formattedUrl;
    }
    public function getFormattedUrl()
    {
        return $this->formattedUrl;
    }
    public function setHtmlFormattedUrl($htmlFormattedUrl)
    {
        $this->htmlFormattedUrl = $htmlFormattedUrl;
    }
    public function getHtmlFormattedUrl()
    {
        return $this->htmlFormattedUrl;
    }
    public function setPagemap($pagemap)
    {
        $this->pagemap = $pagemap;
    }
    public function getPagemap()
    {
        return $this->pagemap;
    }
    public function setHtmlTitle($htmlTitle)
    {
        $this->htmlTitle = $htmlTitle;
    }
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }
    public function setHtmlSnippet($htmlSnippet)
    {
        $this->htmlSnippet = $htmlSnippet;
    }
    public function getHtmlSnippet()
    {
        return $this->htmlSnippet;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function getLink()
    {
        return $this->link;
    }
    public function setImage(Google_ResultImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setMime($mime)
    {
        $this->mime = $mime;
    }
    public function getMime()
    {
        return $this->mime;
    }
    public function setFileFormat($fileFormat)
    {
        $this->fileFormat = $fileFormat;
    }
    public function getFileFormat()
    {
        return $this->fileFormat;
    }
}
class Google_ResultImage extends Google_Model
{
    public $thumbnailWidth = NULL;
    public $byteSize = NULL;
    public $height = NULL;
    public $width = NULL;
    public $contextLink = NULL;
    public $thumbnailLink = NULL;
    public $thumbnailHeight = NULL;
    public function setThumbnailWidth($thumbnailWidth)
    {
        $this->thumbnailWidth = $thumbnailWidth;
    }
    public function getThumbnailWidth()
    {
        return $this->thumbnailWidth;
    }
    public function setByteSize($byteSize)
    {
        $this->byteSize = $byteSize;
    }
    public function getByteSize()
    {
        return $this->byteSize;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setContextLink($contextLink)
    {
        $this->contextLink = $contextLink;
    }
    public function getContextLink()
    {
        return $this->contextLink;
    }
    public function setThumbnailLink($thumbnailLink)
    {
        $this->thumbnailLink = $thumbnailLink;
    }
    public function getThumbnailLink()
    {
        return $this->thumbnailLink;
    }
    public function setThumbnailHeight($thumbnailHeight)
    {
        $this->thumbnailHeight = $thumbnailHeight;
    }
    public function getThumbnailHeight()
    {
        return $this->thumbnailHeight;
    }
}
class Google_ResultLabels extends Google_Model
{
    public $displayName = NULL;
    public $name = NULL;
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
}
class Google_Search extends Google_Model
{
    protected $__promotionsType = "Google_Promotion";
    protected $__promotionsDataType = "array";
    public $promotions = NULL;
    public $kind = NULL;
    protected $__urlType = "Google_SearchUrl";
    protected $__urlDataType = "";
    public $url = NULL;
    protected $__itemsType = "Google_Result";
    protected $__itemsDataType = "array";
    public $items = NULL;
    protected $__contextType = "Google_Context";
    protected $__contextDataType = "";
    public $context = NULL;
    protected $__queriesType = "Google_Query";
    protected $__queriesDataType = "map";
    public $queries = NULL;
    protected $__spellingType = "Google_SearchSpelling";
    protected $__spellingDataType = "";
    public $spelling = NULL;
    protected $__searchInformationType = "Google_SearchSearchInformation";
    protected $__searchInformationDataType = "";
    public $searchInformation = NULL;
    public function setPromotions($promotions)
    {
        $this->assertIsArray($promotions, "Google_Promotion", "Google_Search::setPromotions");
        $this->promotions = $promotions;
    }
    public function getPromotions()
    {
        return $this->promotions;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setUrl(Google_SearchUrl $url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Result", "Google_Search::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setContext(Google_Context $context)
    {
        $this->context = $context;
    }
    public function getContext()
    {
        return $this->context;
    }
    public function setQueries(Google_Query $queries)
    {
        $this->queries = $queries;
    }
    public function getQueries()
    {
        return $this->queries;
    }
    public function setSpelling(Google_SearchSpelling $spelling)
    {
        $this->spelling = $spelling;
    }
    public function getSpelling()
    {
        return $this->spelling;
    }
    public function setSearchInformation(Google_SearchSearchInformation $searchInformation)
    {
        $this->searchInformation = $searchInformation;
    }
    public function getSearchInformation()
    {
        return $this->searchInformation;
    }
}
class Google_SearchSearchInformation extends Google_Model
{
    public $formattedSearchTime = NULL;
    public $formattedTotalResults = NULL;
    public $totalResults = NULL;
    public $searchTime = NULL;
    public function setFormattedSearchTime($formattedSearchTime)
    {
        $this->formattedSearchTime = $formattedSearchTime;
    }
    public function getFormattedSearchTime()
    {
        return $this->formattedSearchTime;
    }
    public function setFormattedTotalResults($formattedTotalResults)
    {
        $this->formattedTotalResults = $formattedTotalResults;
    }
    public function getFormattedTotalResults()
    {
        return $this->formattedTotalResults;
    }
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
    public function setSearchTime($searchTime)
    {
        $this->searchTime = $searchTime;
    }
    public function getSearchTime()
    {
        return $this->searchTime;
    }
}
class Google_SearchSpelling extends Google_Model
{
    public $correctedQuery = NULL;
    public $htmlCorrectedQuery = NULL;
    public function setCorrectedQuery($correctedQuery)
    {
        $this->correctedQuery = $correctedQuery;
    }
    public function getCorrectedQuery()
    {
        return $this->correctedQuery;
    }
    public function setHtmlCorrectedQuery($htmlCorrectedQuery)
    {
        $this->htmlCorrectedQuery = $htmlCorrectedQuery;
    }
    public function getHtmlCorrectedQuery()
    {
        return $this->htmlCorrectedQuery;
    }
}
class Google_SearchUrl extends Google_Model
{
    public $type = NULL;
    public $template = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    public function getTemplate()
    {
        return $this->template;
    }
}

?>