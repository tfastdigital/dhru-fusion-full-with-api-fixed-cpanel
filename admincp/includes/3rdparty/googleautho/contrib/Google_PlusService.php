<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "activities" collection of methods.
 * Typical usage is:
 *  <code>
 *   $plusService = new Google_PlusService(...);
 *   $activities = $plusService->activities;
 *  </code>
 */
class Google_ActivitiesServiceResource extends Google_ServiceResource
{
    public function search($query, $optParams = [])
    {
        $params = ["query" => $query];
        $params = array_merge($params, $optParams);
        $data = $this->__call("search", [$params]);
        if ($this->useObjects()) {
            return new Google_ActivityFeed($data);
        }
        return $data;
    }
    public function listActivities($userId, $collection, $optParams = [])
    {
        $params = ["userId" => $userId, "collection" => $collection];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_ActivityFeed($data);
        }
        return $data;
    }
    public function get($activityId, $optParams = [])
    {
        $params = ["activityId" => $activityId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Activity($data);
        }
        return $data;
    }
}
/**
 * The "comments" collection of methods.
 * Typical usage is:
 *  <code>
 *   $plusService = new Google_PlusService(...);
 *   $comments = $plusService->comments;
 *  </code>
 */
class Google_CommentsServiceResource extends Google_ServiceResource
{
    public function listComments($activityId, $optParams = [])
    {
        $params = ["activityId" => $activityId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("list", [$params]);
        if ($this->useObjects()) {
            return new Google_CommentFeed($data);
        }
        return $data;
    }
    public function get($commentId, $optParams = [])
    {
        $params = ["commentId" => $commentId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Comment($data);
        }
        return $data;
    }
}
/**
 * The "people" collection of methods.
 * Typical usage is:
 *  <code>
 *   $plusService = new Google_PlusService(...);
 *   $people = $plusService->people;
 *  </code>
 */
class Google_PeopleServiceResource extends Google_ServiceResource
{
    public function listByActivity($activityId, $collection, $optParams = [])
    {
        $params = ["activityId" => $activityId, "collection" => $collection];
        $params = array_merge($params, $optParams);
        $data = $this->__call("listByActivity", [$params]);
        if ($this->useObjects()) {
            return new Google_PeopleFeed($data);
        }
        return $data;
    }
    public function search($query, $optParams = [])
    {
        $params = ["query" => $query];
        $params = array_merge($params, $optParams);
        $data = $this->__call("search", [$params]);
        if ($this->useObjects()) {
            return new Google_PeopleFeed($data);
        }
        return $data;
    }
    public function get($userId, $optParams = [])
    {
        $params = ["userId" => $userId];
        $params = array_merge($params, $optParams);
        $data = $this->__call("get", [$params]);
        if ($this->useObjects()) {
            return new Google_Person($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Plus (v1).
 *
 * <p>
 * The Google+ API enables developers to build on top of the Google+ platform.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/+/api/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_PlusService extends Google_Service
{
    public $activities = NULL;
    public $comments = NULL;
    public $people = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "plus/v1/";
        $this->version = "v1";
        $this->serviceName = "plus";
        $client->addService($this->serviceName, $this->version);
        $this->activities = new Google_ActivitiesServiceResource($this, $this->serviceName, "activities", json_decode("{\"methods\": {\"search\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"orderBy\": {\"default\": \"recent\", \"enum\": [\"best\", \"recent\"], \"type\": \"string\", \"location\": \"query\"}, \"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"10\", \"maximum\": \"20\", \"minimum\": \"1\", \"location\": \"query\", \"type\": \"integer\"}, \"language\": {\"default\": \"\", \"type\": \"string\", \"location\": \"query\"}, \"query\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"plus.activities.search\", \"httpMethod\": \"GET\", \"path\": \"activities\", \"response\": {\"\$ref\": \"ActivityFeed\"}}, \"list\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"alt\": {\"default\": \"json\", \"enum\": [\"json\"], \"type\": \"string\", \"location\": \"query\"}, \"userId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"20\", \"maximum\": \"100\", \"minimum\": \"1\", \"location\": \"query\", \"type\": \"integer\"}, \"collection\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"public\"]}}, \"id\": \"plus.activities.list\", \"httpMethod\": \"GET\", \"path\": \"people/{userId}/activities/{collection}\", \"response\": {\"\$ref\": \"ActivityFeed\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"activityId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"alt\": {\"default\": \"json\", \"enum\": [\"json\"], \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"plus.activities.get\", \"httpMethod\": \"GET\", \"path\": \"activities/{activityId}\", \"response\": {\"\$ref\": \"Activity\"}}}}", true));
        $this->comments = new Google_CommentsServiceResource($this, $this->serviceName, "comments", json_decode("{\"methods\": {\"list\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"activityId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"alt\": {\"default\": \"json\", \"enum\": [\"json\"], \"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"20\", \"maximum\": \"100\", \"minimum\": \"0\", \"location\": \"query\", \"type\": \"integer\"}, \"sortOrder\": {\"default\": \"ascending\", \"enum\": [\"ascending\", \"descending\"], \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"plus.comments.list\", \"httpMethod\": \"GET\", \"path\": \"activities/{activityId}/comments\", \"response\": {\"\$ref\": \"CommentFeed\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"commentId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"plus.comments.get\", \"httpMethod\": \"GET\", \"path\": \"comments/{commentId}\", \"response\": {\"\$ref\": \"Comment\"}}}}", true));
        $this->people = new Google_PeopleServiceResource($this, $this->serviceName, "people", json_decode("{\"methods\": {\"listByActivity\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"activityId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"20\", \"maximum\": \"100\", \"minimum\": \"1\", \"location\": \"query\", \"type\": \"integer\"}, \"collection\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"plusoners\", \"resharers\"]}}, \"id\": \"plus.people.listByActivity\", \"httpMethod\": \"GET\", \"path\": \"activities/{activityId}/people/{collection}\", \"response\": {\"\$ref\": \"PeopleFeed\"}}, \"search\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\"], \"parameters\": {\"pageToken\": {\"type\": \"string\", \"location\": \"query\"}, \"maxResults\": {\"format\": \"uint32\", \"default\": \"10\", \"maximum\": \"20\", \"minimum\": \"1\", \"location\": \"query\", \"type\": \"integer\"}, \"language\": {\"default\": \"\", \"type\": \"string\", \"location\": \"query\"}, \"query\": {\"required\": true, \"type\": \"string\", \"location\": \"query\"}}, \"id\": \"plus.people.search\", \"httpMethod\": \"GET\", \"path\": \"people\", \"response\": {\"\$ref\": \"PeopleFeed\"}}, \"get\": {\"scopes\": [\"https://www.googleapis.com/auth/plus.me\", \"https://www.googleapis.com/auth/userinfo.email\"], \"parameters\": {\"userId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}}, \"id\": \"plus.people.get\", \"httpMethod\": \"GET\", \"path\": \"people/{userId}\", \"response\": {\"\$ref\": \"Person\"}}}}", true));
    }
}
class Google_Acl extends Google_Model
{
    protected $__itemsType = "Google_PlusAclentryResource";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $kind = NULL;
    public $description = NULL;
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_PlusAclentryResource", "Google_Acl::setItems");
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
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
}
class Google_Activity extends Google_Model
{
    public $placeName = NULL;
    public $kind = NULL;
    public $updated = NULL;
    protected $__providerType = "Google_ActivityProvider";
    protected $__providerDataType = "";
    public $provider = NULL;
    public $title = NULL;
    public $url = NULL;
    public $geocode = NULL;
    protected $__objectType = "Google_ActivityObject";
    protected $__objectDataType = "";
    public $object = NULL;
    public $placeId = NULL;
    protected $__actorType = "Google_ActivityActor";
    protected $__actorDataType = "";
    public $actor = NULL;
    public $id = NULL;
    protected $__accessType = "Google_Acl";
    protected $__accessDataType = "";
    public $access = NULL;
    public $verb = NULL;
    public $etag = NULL;
    public $radius = NULL;
    public $address = NULL;
    public $crosspostSource = NULL;
    public $annotation = NULL;
    public $published = NULL;
    public function setPlaceName($placeName)
    {
        $this->placeName = $placeName;
    }
    public function getPlaceName()
    {
        return $this->placeName;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setProvider(Google_ActivityProvider $provider)
    {
        $this->provider = $provider;
    }
    public function getProvider()
    {
        return $this->provider;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setGeocode($geocode)
    {
        $this->geocode = $geocode;
    }
    public function getGeocode()
    {
        return $this->geocode;
    }
    public function setObject(Google_ActivityObject $object)
    {
        $this->object = $object;
    }
    public function getObject()
    {
        return $this->object;
    }
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;
    }
    public function getPlaceId()
    {
        return $this->placeId;
    }
    public function setActor(Google_ActivityActor $actor)
    {
        $this->actor = $actor;
    }
    public function getActor()
    {
        return $this->actor;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setAccess(Google_Acl $access)
    {
        $this->access = $access;
    }
    public function getAccess()
    {
        return $this->access;
    }
    public function setVerb($verb)
    {
        $this->verb = $verb;
    }
    public function getVerb()
    {
        return $this->verb;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setRadius($radius)
    {
        $this->radius = $radius;
    }
    public function getRadius()
    {
        return $this->radius;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setCrosspostSource($crosspostSource)
    {
        $this->crosspostSource = $crosspostSource;
    }
    public function getCrosspostSource()
    {
        return $this->crosspostSource;
    }
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }
    public function getAnnotation()
    {
        return $this->annotation;
    }
    public function setPublished($published)
    {
        $this->published = $published;
    }
    public function getPublished()
    {
        return $this->published;
    }
}
class Google_ActivityActor extends Google_Model
{
    public $url = NULL;
    protected $__imageType = "Google_ActivityActorImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $displayName = NULL;
    public $id = NULL;
    protected $__nameType = "Google_ActivityActorName";
    protected $__nameDataType = "";
    public $name = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setImage(Google_ActivityActorImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setName(Google_ActivityActorName $name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}
class Google_ActivityActorImage extends Google_Model
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
class Google_ActivityActorName extends Google_Model
{
    public $givenName = NULL;
    public $familyName = NULL;
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }
    public function getGivenName()
    {
        return $this->givenName;
    }
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }
    public function getFamilyName()
    {
        return $this->familyName;
    }
}
class Google_ActivityFeed extends Google_Model
{
    public $nextPageToken = NULL;
    public $kind = NULL;
    public $title = NULL;
    protected $__itemsType = "Google_Activity";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $updated = NULL;
    public $nextLink = NULL;
    public $etag = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Activity", "Google_ActivityFeed::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
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
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
    }
    public function getSelfLink()
    {
        return $this->selfLink;
    }
}
class Google_ActivityObject extends Google_Model
{
    protected $__resharersType = "Google_ActivityObjectResharers";
    protected $__resharersDataType = "";
    public $resharers = NULL;
    protected $__attachmentsType = "Google_ActivityObjectAttachments";
    protected $__attachmentsDataType = "array";
    public $attachments = NULL;
    public $originalContent = NULL;
    protected $__plusonersType = "Google_ActivityObjectPlusoners";
    protected $__plusonersDataType = "";
    public $plusoners = NULL;
    protected $__actorType = "Google_ActivityObjectActor";
    protected $__actorDataType = "";
    public $actor = NULL;
    public $content = NULL;
    public $url = NULL;
    protected $__repliesType = "Google_ActivityObjectReplies";
    protected $__repliesDataType = "";
    public $replies = NULL;
    public $id = NULL;
    public $objectType = NULL;
    public function setResharers(Google_ActivityObjectResharers $resharers)
    {
        $this->resharers = $resharers;
    }
    public function getResharers()
    {
        return $this->resharers;
    }
    public function setAttachments($attachments)
    {
        $this->assertIsArray($attachments, "Google_ActivityObjectAttachments", "Google_ActivityObject::setAttachments");
        $this->attachments = $attachments;
    }
    public function getAttachments()
    {
        return $this->attachments;
    }
    public function setOriginalContent($originalContent)
    {
        $this->originalContent = $originalContent;
    }
    public function getOriginalContent()
    {
        return $this->originalContent;
    }
    public function setPlusoners(Google_ActivityObjectPlusoners $plusoners)
    {
        $this->plusoners = $plusoners;
    }
    public function getPlusoners()
    {
        return $this->plusoners;
    }
    public function setActor(Google_ActivityObjectActor $actor)
    {
        $this->actor = $actor;
    }
    public function getActor()
    {
        return $this->actor;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setReplies(Google_ActivityObjectReplies $replies)
    {
        $this->replies = $replies;
    }
    public function getReplies()
    {
        return $this->replies;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }
    public function getObjectType()
    {
        return $this->objectType;
    }
}
class Google_ActivityObjectActor extends Google_Model
{
    public $url = NULL;
    protected $__imageType = "Google_ActivityObjectActorImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $displayName = NULL;
    public $id = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setImage(Google_ActivityObjectActorImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
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
class Google_ActivityObjectActorImage extends Google_Model
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
class Google_ActivityObjectAttachments extends Google_Model
{
    public $displayName = NULL;
    protected $__fullImageType = "Google_ActivityObjectAttachmentsFullImage";
    protected $__fullImageDataType = "";
    public $fullImage = NULL;
    public $url = NULL;
    protected $__imageType = "Google_ActivityObjectAttachmentsImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $content = NULL;
    protected $__embedType = "Google_ActivityObjectAttachmentsEmbed";
    protected $__embedDataType = "";
    public $embed = NULL;
    public $id = NULL;
    public $objectType = NULL;
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setFullImage(Google_ActivityObjectAttachmentsFullImage $fullImage)
    {
        $this->fullImage = $fullImage;
    }
    public function getFullImage()
    {
        return $this->fullImage;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setImage(Google_ActivityObjectAttachmentsImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setEmbed(Google_ActivityObjectAttachmentsEmbed $embed)
    {
        $this->embed = $embed;
    }
    public function getEmbed()
    {
        return $this->embed;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }
    public function getObjectType()
    {
        return $this->objectType;
    }
}
class Google_ActivityObjectAttachmentsEmbed extends Google_Model
{
    public $url = NULL;
    public $type = NULL;
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
class Google_ActivityObjectAttachmentsFullImage extends Google_Model
{
    public $url = NULL;
    public $width = NULL;
    public $type = NULL;
    public $height = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
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
class Google_ActivityObjectAttachmentsImage extends Google_Model
{
    public $url = NULL;
    public $width = NULL;
    public $type = NULL;
    public $height = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
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
class Google_ActivityObjectPlusoners extends Google_Model
{
    public $totalItems = NULL;
    public $selfLink = NULL;
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
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
class Google_ActivityObjectReplies extends Google_Model
{
    public $totalItems = NULL;
    public $selfLink = NULL;
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
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
class Google_ActivityObjectResharers extends Google_Model
{
    public $totalItems = NULL;
    public $selfLink = NULL;
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
    public function getTotalItems()
    {
        return $this->totalItems;
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
class Google_ActivityProvider extends Google_Model
{
    public $title = NULL;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
}
class Google_Comment extends Google_Model
{
    protected $__inReplyToType = "Google_CommentInReplyTo";
    protected $__inReplyToDataType = "array";
    public $inReplyTo = NULL;
    public $kind = NULL;
    protected $__objectType = "Google_CommentObject";
    protected $__objectDataType = "";
    public $object = NULL;
    public $updated = NULL;
    protected $__actorType = "Google_CommentActor";
    protected $__actorDataType = "";
    public $actor = NULL;
    public $verb = NULL;
    public $etag = NULL;
    public $published = NULL;
    public $id = NULL;
    public $selfLink = NULL;
    public function setInReplyTo($inReplyTo)
    {
        $this->assertIsArray($inReplyTo, "Google_CommentInReplyTo", "Google_Comment::setInReplyTo");
        $this->inReplyTo = $inReplyTo;
    }
    public function getInReplyTo()
    {
        return $this->inReplyTo;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setObject(Google_CommentObject $object)
    {
        $this->object = $object;
    }
    public function getObject()
    {
        return $this->object;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setActor(Google_CommentActor $actor)
    {
        $this->actor = $actor;
    }
    public function getActor()
    {
        return $this->actor;
    }
    public function setVerb($verb)
    {
        $this->verb = $verb;
    }
    public function getVerb()
    {
        return $this->verb;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setPublished($published)
    {
        $this->published = $published;
    }
    public function getPublished()
    {
        return $this->published;
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
class Google_CommentActor extends Google_Model
{
    public $url = NULL;
    protected $__imageType = "Google_CommentActorImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $displayName = NULL;
    public $id = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setImage(Google_CommentActorImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
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
class Google_CommentActorImage extends Google_Model
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
class Google_CommentFeed extends Google_Model
{
    public $nextPageToken = NULL;
    public $kind = NULL;
    public $title = NULL;
    protected $__itemsType = "Google_Comment";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $updated = NULL;
    public $nextLink = NULL;
    public $etag = NULL;
    public $id = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Comment", "Google_CommentFeed::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    public function getUpdated()
    {
        return $this->updated;
    }
    public function setNextLink($nextLink)
    {
        $this->nextLink = $nextLink;
    }
    public function getNextLink()
    {
        return $this->nextLink;
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
class Google_CommentInReplyTo extends Google_Model
{
    public $url = NULL;
    public $id = NULL;
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
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
class Google_CommentObject extends Google_Model
{
    public $content = NULL;
    public $objectType = NULL;
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }
    public function getObjectType()
    {
        return $this->objectType;
    }
}
class Google_PeopleFeed extends Google_Model
{
    public $nextPageToken = NULL;
    public $kind = NULL;
    public $title = NULL;
    protected $__itemsType = "Google_Person";
    protected $__itemsDataType = "array";
    public $items = NULL;
    public $etag = NULL;
    public $selfLink = NULL;
    public function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setItems($items)
    {
        $this->assertIsArray($items, "Google_Person", "Google_PeopleFeed::setItems");
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
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
class Google_Person extends Google_Model
{
    public $relationshipStatus = NULL;
    protected $__organizationsType = "Google_PersonOrganizations";
    protected $__organizationsDataType = "array";
    public $organizations = NULL;
    public $kind = NULL;
    public $displayName = NULL;
    protected $__nameType = "Google_PersonName";
    protected $__nameDataType = "";
    public $name = NULL;
    public $url = NULL;
    public $gender = NULL;
    public $aboutMe = NULL;
    public $tagline = NULL;
    protected $__urlsType = "Google_PersonUrls";
    protected $__urlsDataType = "array";
    public $urls = NULL;
    protected $__placesLivedType = "Google_PersonPlacesLived";
    protected $__placesLivedDataType = "array";
    public $placesLived = NULL;
    protected $__emailsType = "Google_PersonEmails";
    protected $__emailsDataType = "array";
    public $emails = NULL;
    public $nickname = NULL;
    public $birthday = NULL;
    public $etag = NULL;
    protected $__imageType = "Google_PersonImage";
    protected $__imageDataType = "";
    public $image = NULL;
    public $hasApp = NULL;
    public $id = NULL;
    public $languagesSpoken = NULL;
    public $currentLocation = NULL;
    public $objectType = NULL;
    public function setRelationshipStatus($relationshipStatus)
    {
        $this->relationshipStatus = $relationshipStatus;
    }
    public function getRelationshipStatus()
    {
        return $this->relationshipStatus;
    }
    public function setOrganizations($organizations)
    {
        $this->assertIsArray($organizations, "Google_PersonOrganizations", "Google_Person::setOrganizations");
        $this->organizations = $organizations;
    }
    public function getOrganizations()
    {
        return $this->organizations;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }
    public function getDisplayName()
    {
        return $this->displayName;
    }
    public function setName(Google_PersonName $name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setGender($gender)
    {
        $this->gender = $gender;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    }
    public function getAboutMe()
    {
        return $this->aboutMe;
    }
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;
    }
    public function getTagline()
    {
        return $this->tagline;
    }
    public function setUrls($urls)
    {
        $this->assertIsArray($urls, "Google_PersonUrls", "Google_Person::setUrls");
        $this->urls = $urls;
    }
    public function getUrls()
    {
        return $this->urls;
    }
    public function setPlacesLived($placesLived)
    {
        $this->assertIsArray($placesLived, "Google_PersonPlacesLived", "Google_Person::setPlacesLived");
        $this->placesLived = $placesLived;
    }
    public function getPlacesLived()
    {
        return $this->placesLived;
    }
    public function setEmails($emails)
    {
        $this->assertIsArray($emails, "Google_PersonEmails", "Google_Person::setEmails");
        $this->emails = $emails;
    }
    public function getEmails()
    {
        return $this->emails;
    }
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }
    public function getNickname()
    {
        return $this->nickname;
    }
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }
    public function getBirthday()
    {
        return $this->birthday;
    }
    public function setEtag($etag)
    {
        $this->etag = $etag;
    }
    public function getEtag()
    {
        return $this->etag;
    }
    public function setImage(Google_PersonImage $image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setHasApp($hasApp)
    {
        $this->hasApp = $hasApp;
    }
    public function getHasApp()
    {
        return $this->hasApp;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = $languagesSpoken;
    }
    public function getLanguagesSpoken()
    {
        return $this->languagesSpoken;
    }
    public function setCurrentLocation($currentLocation)
    {
        $this->currentLocation = $currentLocation;
    }
    public function getCurrentLocation()
    {
        return $this->currentLocation;
    }
    public function setObjectType($objectType)
    {
        $this->objectType = $objectType;
    }
    public function getObjectType()
    {
        return $this->objectType;
    }
}
class Google_PersonEmails extends Google_Model
{
    public $type = NULL;
    public $primary = NULL;
    public $value = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
    public function getPrimary()
    {
        return $this->primary;
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
class Google_PersonImage extends Google_Model
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
class Google_PersonName extends Google_Model
{
    public $honorificPrefix = NULL;
    public $middleName = NULL;
    public $familyName = NULL;
    public $formatted = NULL;
    public $givenName = NULL;
    public $honorificSuffix = NULL;
    public function setHonorificPrefix($honorificPrefix)
    {
        $this->honorificPrefix = $honorificPrefix;
    }
    public function getHonorificPrefix()
    {
        return $this->honorificPrefix;
    }
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }
    public function getMiddleName()
    {
        return $this->middleName;
    }
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }
    public function getFamilyName()
    {
        return $this->familyName;
    }
    public function setFormatted($formatted)
    {
        $this->formatted = $formatted;
    }
    public function getFormatted()
    {
        return $this->formatted;
    }
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }
    public function getGivenName()
    {
        return $this->givenName;
    }
    public function setHonorificSuffix($honorificSuffix)
    {
        $this->honorificSuffix = $honorificSuffix;
    }
    public function getHonorificSuffix()
    {
        return $this->honorificSuffix;
    }
}
class Google_PersonOrganizations extends Google_Model
{
    public $startDate = NULL;
    public $endDate = NULL;
    public $description = NULL;
    public $title = NULL;
    public $primary = NULL;
    public $location = NULL;
    public $department = NULL;
    public $type = NULL;
    public $name = NULL;
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    public function getStartDate()
    {
        return $this->startDate;
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
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
    public function getPrimary()
    {
        return $this->primary;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setDepartment($department)
    {
        $this->department = $department;
    }
    public function getDepartment()
    {
        return $this->department;
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
class Google_PersonPlacesLived extends Google_Model
{
    public $primary = NULL;
    public $value = NULL;
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
    public function getPrimary()
    {
        return $this->primary;
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
class Google_PersonUrls extends Google_Model
{
    public $type = NULL;
    public $primary = NULL;
    public $value = NULL;
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
    public function getPrimary()
    {
        return $this->primary;
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
class Google_PlusAclentryResource extends Google_Model
{
    public $type = NULL;
    public $id = NULL;
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
}

?>