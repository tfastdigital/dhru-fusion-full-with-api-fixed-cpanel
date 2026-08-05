<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "channels" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google_YoutubeService(...);
 *   $channels = $youtubeService->channels;
 *  </code>
 */
class Google_ChannelsServiceResource extends Google_ServiceResource
{
    public function listChannels($part, $optParams = [])
    {
        $params = ["part" => $part];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_ChannelListResponse($data);
        }
        return $data;
    }
}
/**
 * The "search" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google_YoutubeService(...);
 *   $search = $youtubeService->search;
 *  </code>
 */
class Google_SearchServiceResource extends Google_ServiceResource
{
    public function listSearch($optParams = [])
    {
        $params = [];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_SearchListResponse($data);
        }
        return $data;
    }
}
/**
 * The "playlistitems" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google_YoutubeService(...);
 *   $playlistitems = $youtubeService->playlistitems;
 *  </code>
 */
class Google_PlaylistitemsServiceResource extends Google_ServiceResource
{
    public function listPlaylistitems($part, $optParams = [])
    {
        $params = ["part" => $part];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_PlaylistItemListResponse($data);
        }
        return $data;
    }
}
/**
 * The "playlists" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google_YoutubeService(...);
 *   $playlists = $youtubeService->playlists;
 *  </code>
 */
class Google_PlaylistsServiceResource extends Google_ServiceResource
{
    public function listPlaylists($id, $part, $optParams = [])
    {
        $params = ["id" => $id, "part" => $part];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_PlaylistListResponse($data);
        }
        return $data;
    }
}
/**
 * The "videos" collection of methods.
 * Typical usage is:
 *  <code>
 *   $youtubeService = new Google_YoutubeService(...);
 *   $videos = $youtubeService->videos;
 *  </code>
 */
class Google_VideosServiceResource extends Google_ServiceResource
{
    public function listVideos($id, $part, $optParams = [])
    {
        $params = ["id" => $id, "part" => $part];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_VideoListResponse($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Youtube (v3alpha).
 *
 * <p>
 * Programmatic access to YouTube features.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/youtube" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_YoutubeService extends Google_Service
{
    public $channels = NULL;
    public $search = NULL;
    public $playlistitems = NULL;
    public $playlists = NULL;
    public $videos = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "youtube/v3alpha/";
        $this->version = "v3alpha";
        $this->serviceName = "youtube";
        $client->addService($this->serviceName, $this->version);
        $this->channels = new Google_ChannelsServiceResource($this, $this->serviceName, "channels", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/youtube\"], \"parameters\": {\"part\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"id\": {\"type\": \"string\", \"location\": \"query\"}, \"mine\": {\"type\": \"string\", \"location\": \"query\"}}, \"id\": \"youtube.channels.list\", \"httpMethod\": \"GET\", \"path\": \"channels\", \"response\": {\"\$ref\": \"ChannelListResponse\"}}}}", true));
        $this->search = new Google_SearchServiceResource($this, $this->serviceName, "search", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/youtube\"], \"parameters\": {\"q\": {\"type\": \"string\", \"location\": \"query\"}, \"startIndex\": {\"format\": \"uint32\", \"default\": \"0\", \"maximum\": \"1000\", \"minimum\": \"0\", \"location\": \"query\", \"type\": \"integer\"}, \"type\": {\"repeated\": true, \"enum\": [\"channel\", \"playlist\", \"video\"], \"type\": \"string\", \"location\": \"query\"}, \"order\": {\"default\": \"SEARCH_SORT_RELEVANCE\", \"enum\": [\"date\", \"rating\", \"relevance\", \"view_count\"], \"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"25\", \"maximum\": \"50\", \"minimum\": \"0\", \"location\": \"query\", \"type\": \"integer\"}}, \"response\": {\"\$ref\": \"SearchListResponse\"}, \"httpMethod\": \"GET\", \"path\": \"search\", \"id\": \"youtube.search.list\"}}}", true));
        $this->playlistitems = new Google_PlaylistitemsServiceResource($this, $this->serviceName, "playlistitems", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/youtube\"], \"parameters\": {\"startIndex\": {\"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}, \"part\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"playlistId\": {\"type\": \"string\", \"location\": \"query\"}, \"id\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"default\": \"50\", \"minimum\": \"0\", \"type\": \"integer\", \"location\": \"query\", \"format\": \"uint32\"}}, \"id\": \"youtube.playlistitems.list\", \"httpMethod\": \"GET\", \"path\": \"playlistitems\", \"response\": {\"\$ref\": \"PlaylistItemListResponse\"}}}}", true));
        $this->playlists = new Google_PlaylistsServiceResource($this, $this->serviceName, "playlists", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/youtube\"], \"parameters\": {\"part\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"id\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"youtube.playlists.list\", \"httpMethod\": \"GET\", \"path\": \"playlists\", \"response\": {\"\$ref\": \"PlaylistListResponse\"}}}}", true));
        $this->videos = new Google_VideosServiceResource($this, $this->serviceName, "videos", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/youtube\"], \"parameters\": {\"part\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}, \"id\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"youtube.videos.list\", \"httpMethod\": \"GET\", \"path\": \"videos\", \"response\": {\"\$ref\": \"VideoListResponse\"}}}}", true));
    }
}
class Google_Channel extends Google_Model
{
    public $kind = NULL;
    protected $__statisticsType = "Google_ChannelStatistics";
    protected $__statisticsDataType = "";
    public $statistics = NULL;
    protected $__contentDetailsType = "Google_ChannelContentDetails";
    protected $__contentDetailsDataType = "";
    public $contentDetails = NULL;
    protected $__snippetType = "Google_ChannelSnippet";
    protected $__snippetDataType = "";
    public $snippet = NULL;
    public $etag = NULL;
    public $id = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setStatistics(Google_ChannelStatistics $statistics)
    {
        $this->statistics = $statistics;
    }
    public function getStatistics()
    {
        return $this->statistics;
    }
    public function setContentDetails(Google_ChannelContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    public function getContentDetails()
    {
        return $this->contentDetails;
    }
    public function setSnippet(Google_ChannelSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    public function getSnippet()
    {
        return $this->snippet;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
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
class Google_ChannelContentDetails extends Google_Model
{
    public $privacyStatus = NULL;
    public $uploads = NULL;
    public function setPrivacyStatus($privacyStatus)
    {
        $this->privacyStatus = $privacyStatus;
    }
    public function getPrivacyStatus()
    {
        return $this->privacyStatus;
    }
    public function setUploads($uploads)
    {
        $this->uploads = $uploads;
    }
    public function getUploads()
    {
        return $this->uploads;
    }
}
class Google_ChannelListResponse extends Google_Model
{
    protected $__channelsType = "Google_Channel";
    protected $__channelsDataType = "map";
    public $channels = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setChannels(Google_Channel $channels)
    {
        $this->channels = $channels;
    }
    public function getChannels()
    {
        return $this->channels;
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
class Google_ChannelSnippet extends Google_Model
{
    public $title = NULL;
    public $description = NULL;
    protected $__thumbnailsType = "Google_Thumbnail";
    protected $__thumbnailsDataType = "map";
    public $thumbnails = NULL;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setThumbnails(Google_Thumbnail $thumbnails)
    {
        $this->thumbnails = $thumbnails;
    }
    public function getThumbnails()
    {
        return $this->thumbnails;
    }
}
class Google_ChannelStatistics extends Google_Model
{
    public $commentCount = NULL;
    public $subscriberCount = NULL;
    public $videoCount = NULL;
    public $viewCount = NULL;
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }
    public function getCommentCount()
    {
        return $this->commentCount;
    }
    public function setSubscriberCount($subscriberCount)
    {
        $this->subscriberCount = $subscriberCount;
    }
    public function getSubscriberCount()
    {
        return $this->subscriberCount;
    }
    public function setVideoCount($videoCount)
    {
        $this->videoCount = $videoCount;
    }
    public function getVideoCount()
    {
        return $this->videoCount;
    }
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }
    public function getViewCount()
    {
        return $this->viewCount;
    }
}
class Google_PageInfo extends Google_Model
{
    public $totalResults = NULL;
    public $startIndex = NULL;
    public $resultPerPage = NULL;
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults()
    {
        return $this->totalResults;
    }
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
    }
    public function getStartIndex()
    {
        return $this->startIndex;
    }
    public function setResultPerPage($resultPerPage)
    {
        $this->resultPerPage = $resultPerPage;
    }
    public function getResultPerPage()
    {
        return $this->resultPerPage;
    }
}
class Google_Playlist extends Google_Model
{
    protected $__snippetType = "Google_PlaylistSnippet";
    protected $__snippetDataType = "";
    public $snippet = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public $id = NULL;
    public function setSnippet(Google_PlaylistSnippet $snippet)
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
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
class Google_PlaylistItem extends Google_Model
{
    protected $__snippetType = "Google_PlaylistItemSnippet";
    protected $__snippetDataType = "";
    public $snippet = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public $id = NULL;
    public function setSnippet(Google_PlaylistItemSnippet $snippet)
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
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
class Google_PlaylistItemListResponse extends Google_Model
{
    protected $__playlistItemsType = "Google_PlaylistItem";
    protected $__playlistItemsDataType = "map";
    public $playlistItems = NULL;
    public $kind = NULL;
    public $etag = NULL;
    public function setPlaylistItems(Google_PlaylistItem $playlistItems)
    {
        $this->playlistItems = $playlistItems;
    }
    public function getPlaylistItems()
    {
        return $this->playlistItems;
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
class Google_PlaylistItemSnippet extends Google_Model
{
    public $playlistId = NULL;
    public $description = NULL;
    public $title = NULL;
    protected $__resourceIdType = "Google_ResourceId";
    protected $__resourceIdDataType = "";
    public $resourceId = NULL;
    public $channelId = NULL;
    public $publishedAt = NULL;
    public $position = NULL;
    public function setPlaylistId($playlistId)
    {
        $this->playlistId = $playlistId;
    }
    public function getPlaylistId()
    {
        return $this->playlistId;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setResourceId(Google_ResourceId $resourceId)
    {
        $this->resourceId = $resourceId;
    }
    public function getResourceId()
    {
        return $this->resourceId;
    }
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    public function setPosition($position)
    {
        $this->position = $position;
    }
    public function getPosition()
    {
        return $this->position;
    }
}
class Google_PlaylistListResponse extends Google_Model
{
    public $kind = NULL;
    public $etag = NULL;
    protected $__playlistsType = "Google_Playlist";
    protected $__playlistsDataType = "map";
    public $playlists = NULL;
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
    public function setPlaylists(Google_Playlist $playlists)
    {
        $this->playlists = $playlists;
    }
    public function getPlaylists()
    {
        return $this->playlists;
    }
}
class Google_PlaylistSnippet extends Google_Model
{
    public $title = NULL;
    public $channelId = NULL;
    public $description = NULL;
    public $publishedAt = NULL;
    public $tags = NULL;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    public function setTags($tags)
    {
        $this->assertIsArray($tags, "Google_string", "Google_PlaylistSnippet::setTags");
        $this->tags = $tags;
    }
    public function getTags()
    {
        return $this->tags;
    }
}
class Google_ResourceId extends Google_Model
{
    public $kind = NULL;
    public $channelId = NULL;
    public $playlistId = NULL;
    public $videoId = NULL;
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setPlaylistId($playlistId)
    {
        $this->playlistId = $playlistId;
    }
    public function getPlaylistId()
    {
        return $this->playlistId;
    }
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }
    public function getVideoId()
    {
        return $this->videoId;
    }
}
class Google_SearchListResponse extends Google_Model
{
    protected $__searchResultsType = "Google_SearchResult";
    protected $__searchResultsDataType = "array";
    public $searchResults = NULL;
    public $kind = NULL;
    public $etag = NULL;
    protected $__pageInfoType = "Google_PageInfo";
    protected $__pageInfoDataType = "";
    public $pageInfo = NULL;
    public function setSearchResults($searchResults)
    {
        $this->assertIsArray($searchResults, "Google_SearchResult", "Google_SearchListResponse::setSearchResults");
        $this->searchResults = $searchResults;
    }
    public function getSearchResults()
    {
        return $this->searchResults;
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
    public function setPageInfo(Google_PageInfo $pageInfo)
    {
        $this->pageInfo = $pageInfo;
    }
    public function getPageInfo()
    {
        return $this->pageInfo;
    }
}
class Google_SearchResult extends Google_Model
{
    protected $__snippetType = "Google_SearchResultSnippet";
    protected $__snippetDataType = "";
    public $snippet = NULL;
    public $kind = NULL;
    public $etag = NULL;
    protected $__idType = "Google_ResourceId";
    protected $__idDataType = "";
    public $id = NULL;
    public function setSnippet(Google_SearchResultSnippet $snippet)
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
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setId(Google_ResourceId $id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
}
class Google_SearchResultSnippet extends Google_Model
{
    public $channelId = NULL;
    public $description = NULL;
    public $publishedAt = NULL;
    public $title = NULL;
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
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
class Google_Thumbnail extends Google_Model
{
    public $url = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
}
class Google_Video extends Google_Model
{
    protected $__statusType = "Google_VideoStatus";
    protected $__statusDataType = "";
    public $status = NULL;
    public $kind = NULL;
    protected $__statisticsType = "Google_VideoStatistics";
    protected $__statisticsDataType = "";
    public $statistics = NULL;
    protected $__contentDetailsType = "Google_VideoContentDetails";
    protected $__contentDetailsDataType = "";
    public $contentDetails = NULL;
    protected $__snippetType = "Google_VideoSnippet";
    protected $__snippetDataType = "";
    public $snippet = NULL;
    protected $__playerType = "Google_VideoPlayer";
    protected $__playerDataType = "";
    public $player = NULL;
    public $etag = NULL;
    public $id = NULL;
    public function setStatus(Google_VideoStatus $status)
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
    public function setStatistics(Google_VideoStatistics $statistics)
    {
        $this->statistics = $statistics;
    }
    public function getStatistics()
    {
        return $this->statistics;
    }
    public function setContentDetails(Google_VideoContentDetails $contentDetails)
    {
        $this->contentDetails = $contentDetails;
    }
    public function getContentDetails()
    {
        return $this->contentDetails;
    }
    public function setSnippet(Google_VideoSnippet $snippet)
    {
        $this->snippet = $snippet;
    }
    public function getSnippet()
    {
        return $this->snippet;
    }
    public function setPlayer(Google_VideoPlayer $player)
    {
        $this->player = $player;
    }
    public function getPlayer()
    {
        return $this->player;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
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
class Google_VideoContentDetails extends Google_Model
{
    public $duration = NULL;
    public $aspectRatio = NULL;
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setAspectRatio($aspectRatio)
    {
        $this->aspectRatio = $aspectRatio;
    }
    public function getAspectRatio()
    {
        return $this->aspectRatio;
    }
}
class Google_VideoListResponse extends Google_Model
{
    public $kind = NULL;
    public $etag = NULL;
    protected $__videosType = "Google_Video";
    protected $__videosDataType = "map";
    public $videos = NULL;
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
    public function setVideos(Google_Video $videos)
    {
        $this->videos = $videos;
    }
    public function getVideos()
    {
        return $this->videos;
    }
}
class Google_VideoPlayer extends Google_Model
{
    public $embedHtml = NULL;
    public function setEmbedHtml($embedHtml)
    {
        $this->embedHtml = $embedHtml;
    }
    public function getEmbedHtml()
    {
        return $this->embedHtml;
    }
}
class Google_VideoSnippet extends Google_Model
{
    protected $__thumbnailsType = "Google_Thumbnail";
    protected $__thumbnailsDataType = "map";
    public $thumbnails = NULL;
    public $tags = NULL;
    public $channelId = NULL;
    public $publishedAt = NULL;
    public $title = NULL;
    public $categoryId = NULL;
    public $description = NULL;
    public function setThumbnails(Google_Thumbnail $thumbnails)
    {
        $this->thumbnails = $thumbnails;
    }
    public function getThumbnails()
    {
        return $this->thumbnails;
    }
    public function setTags($tags)
    {
        $this->assertIsArray($tags, "Google_string", "Google_VideoSnippet::setTags");
        $this->tags = $tags;
    }
    public function getTags()
    {
        return $this->tags;
    }
    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
    }
    public function getChannelId()
    {
        return $this->channelId;
    }
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
}
class Google_VideoStatistics extends Google_Model
{
    public $commentCount = NULL;
    public $viewCount = NULL;
    public $favoriteCount = NULL;
    public $dislikeCount = NULL;
    public $likeCount = NULL;
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }
    public function getCommentCount()
    {
        return $this->commentCount;
    }
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }
    public function getViewCount()
    {
        return $this->viewCount;
    }
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;
    }
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }
    public function setDislikeCount($dislikeCount)
    {
        $this->dislikeCount = $dislikeCount;
    }
    public function getDislikeCount()
    {
        return $this->dislikeCount;
    }
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;
    }
    public function getLikeCount()
    {
        return $this->likeCount;
    }
}
class Google_VideoStatus extends Google_Model
{
    public $privacyStatus = NULL;
    public $uploadStatus = NULL;
    public $rejectionReason = NULL;
    public $failureReason = NULL;
    public function setPrivacyStatus($privacyStatus)
    {
        $this->privacyStatus = $privacyStatus;
    }
    public function getPrivacyStatus()
    {
        return $this->privacyStatus;
    }
    public function setUploadStatus($uploadStatus)
    {
        $this->uploadStatus = $uploadStatus;
    }
    public function getUploadStatus()
    {
        return $this->uploadStatus;
    }
    public function setRejectionReason($rejectionReason)
    {
        $this->rejectionReason = $rejectionReason;
    }
    public function getRejectionReason()
    {
        return $this->rejectionReason;
    }
    public function setFailureReason($failureReason)
    {
        $this->failureReason = $failureReason;
    }
    public function getFailureReason()
    {
        return $this->failureReason;
    }
}

?>