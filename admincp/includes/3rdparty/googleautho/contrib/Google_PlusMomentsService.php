<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * The "moments" collection of methods.
 * Typical usage is:
 *  <code>
 *   $plusService = new Google_PlusMomentsService(...);
 *   $moments = $plusService->moments;
 *  </code>
 */
class Google_MomentsServiceResource extends Google_ServiceResource
{
    public function insert($userId, $collection, Google_Moment $postBody, $optParams = [])
    {
        $params = ["userId" => $userId, "collection" => $collection, "postBody" => $postBody];
        $params = array_merge($params, $optParams);
        $data = $this->__call("insert", [$params]);
        if ($this->useObjects()) {
            return new Google_Moment($data);
        }
        return $data;
    }
}
/**
 * Service definition for Google_Plus (v1moments).
 *
 * <p>
 * The Google+ API enables developers to build on top of the Google+ platform.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/+/history/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_PlusMomentsService extends Google_Service
{
    public $moments = NULL;
    public function __construct(Google_Client $client)
    {
        $this->servicePath = "plus/v1moments/people/";
        $this->version = "v1moments";
        $this->serviceName = "plus";
        $client->addService($this->serviceName, $this->version);
        $this->moments = new Google_MomentsServiceResource($this, $this->serviceName, "moments", json_decode("{\"methods\": {\"insert\": {\"parameters\": {\"debug\": {\"type\": \"boolean\", \"location\": \"query\"}, \"userId\": {\"required\": true, \"type\": \"string\", \"location\": \"path\"}, \"collection\": {\"required\": true, \"type\": \"string\", \"location\": \"path\", \"enum\": [\"vault\"]}}, \"request\": {\"\$ref\": \"Moment\"}, \"response\": {\"\$ref\": \"Moment\"}, \"httpMethod\": \"POST\", \"path\": \"{userId}/moments/{collection}\", \"id\": \"plus.moments.insert\"}}}", true));
    }
}
class Google_ItemScope extends Google_Model
{
    public $startDate = NULL;
    public $endDate = NULL;
    public $text = NULL;
    public $image = NULL;
    protected $__addressType = "Google_ItemScope";
    protected $__addressDataType = "";
    public $address = NULL;
    public $birthDate = NULL;
    public $datePublished = NULL;
    public $addressLocality = NULL;
    public $duration = NULL;
    public $additionalName = NULL;
    public $worstRating = NULL;
    protected $__contributorType = "Google_ItemScope";
    protected $__contributorDataType = "array";
    public $contributor = NULL;
    public $thumbnailUrl = NULL;
    public $id = NULL;
    public $postOfficeBoxNumber = NULL;
    protected $__attendeesType = "Google_ItemScope";
    protected $__attendeesDataType = "array";
    public $attendees = NULL;
    protected $__authorType = "Google_ItemScope";
    protected $__authorDataType = "array";
    public $author = NULL;
    protected $__associated_mediaType = "Google_ItemScope";
    protected $__associated_mediaDataType = "array";
    public $associated_media = NULL;
    public $bestRating = NULL;
    public $addressCountry = NULL;
    public $width = NULL;
    public $streetAddress = NULL;
    protected $__locationType = "Google_ItemScope";
    protected $__locationDataType = "";
    public $location = NULL;
    public $latitude = NULL;
    protected $__byArtistType = "Google_ItemScope";
    protected $__byArtistDataType = "";
    public $byArtist = NULL;
    public $type = NULL;
    public $dateModified = NULL;
    public $contentSize = NULL;
    public $contentUrl = NULL;
    protected $__partOfTVSeriesType = "Google_ItemScope";
    protected $__partOfTVSeriesDataType = "";
    public $partOfTVSeries = NULL;
    public $description = NULL;
    public $familyName = NULL;
    public $kind = NULL;
    public $dateCreated = NULL;
    public $postalCode = NULL;
    public $attendeeCount = NULL;
    protected $__inAlbumType = "Google_ItemScope";
    protected $__inAlbumDataType = "";
    public $inAlbum = NULL;
    public $addressRegion = NULL;
    public $height = NULL;
    protected $__geoType = "Google_ItemScope";
    protected $__geoDataType = "";
    public $geo = NULL;
    public $embedUrl = NULL;
    public $tickerSymbol = NULL;
    public $playerType = NULL;
    protected $__aboutType = "Google_ItemScope";
    protected $__aboutDataType = "";
    public $about = NULL;
    public $givenName = NULL;
    public $name = NULL;
    protected $__performersType = "Google_ItemScope";
    protected $__performersDataType = "array";
    public $performers = NULL;
    public $url = NULL;
    public $gender = NULL;
    public $longitude = NULL;
    protected $__thumbnailType = "Google_ItemScope";
    protected $__thumbnailDataType = "";
    public $thumbnail = NULL;
    public $caption = NULL;
    public $ratingValue = NULL;
    protected $__reviewRatingType = "Google_ItemScope";
    protected $__reviewRatingDataType = "";
    public $reviewRating = NULL;
    protected $__audioType = "Google_ItemScope";
    protected $__audioDataType = "";
    public $audio = NULL;
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
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setAddress(Google_ItemScope $address)
    {
        $this->address = $address;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }
    public function getDatePublished()
    {
        return $this->datePublished;
    }
    public function setAddressLocality($addressLocality)
    {
        $this->addressLocality = $addressLocality;
    }
    public function getAddressLocality()
    {
        return $this->addressLocality;
    }
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setAdditionalName($additionalName)
    {
        $this->assertIsArray($additionalName, "Google_string", "Google_ItemScope::setAdditionalName");
        $this->additionalName = $additionalName;
    }
    public function getAdditionalName()
    {
        return $this->additionalName;
    }
    public function setWorstRating($worstRating)
    {
        $this->worstRating = $worstRating;
    }
    public function getWorstRating()
    {
        return $this->worstRating;
    }
    public function setContributor($contributor)
    {
        $this->assertIsArray($contributor, "Google_ItemScope", "Google_ItemScope::setContributor");
        $this->contributor = $contributor;
    }
    public function getContributor()
    {
        return $this->contributor;
    }
    public function setThumbnailUrl($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }
    public function getThumbnailUrl()
    {
        return $this->thumbnailUrl;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setPostOfficeBoxNumber($postOfficeBoxNumber)
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;
    }
    public function getPostOfficeBoxNumber()
    {
        return $this->postOfficeBoxNumber;
    }
    public function setAttendees($attendees)
    {
        $this->assertIsArray($attendees, "Google_ItemScope", "Google_ItemScope::setAttendees");
        $this->attendees = $attendees;
    }
    public function getAttendees()
    {
        return $this->attendees;
    }
    public function setAuthor($author)
    {
        $this->assertIsArray($author, "Google_ItemScope", "Google_ItemScope::setAuthor");
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setAssociated_media($associated_media)
    {
        $this->assertIsArray($associated_media, "Google_ItemScope", "Google_ItemScope::setAssociated_media");
        $this->associated_media = $associated_media;
    }
    public function getAssociated_media()
    {
        return $this->associated_media;
    }
    public function setBestRating($bestRating)
    {
        $this->bestRating = $bestRating;
    }
    public function getBestRating()
    {
        return $this->bestRating;
    }
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;
    }
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }
    public function setWidth($width)
    {
        $this->width = $width;
    }
    public function getWidth()
    {
        return $this->width;
    }
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;
    }
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }
    public function setLocation(Google_ItemScope $location)
    {
        $this->location = $location;
    }
    public function getLocation()
    {
        return $this->location;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setByArtist(Google_ItemScope $byArtist)
    {
        $this->byArtist = $byArtist;
    }
    public function getByArtist()
    {
        return $this->byArtist;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    }
    public function getDateModified()
    {
        return $this->dateModified;
    }
    public function setContentSize($contentSize)
    {
        $this->contentSize = $contentSize;
    }
    public function getContentSize()
    {
        return $this->contentSize;
    }
    public function setContentUrl($contentUrl)
    {
        $this->contentUrl = $contentUrl;
    }
    public function getContentUrl()
    {
        return $this->contentUrl;
    }
    public function setPartOfTVSeries(Google_ItemScope $partOfTVSeries)
    {
        $this->partOfTVSeries = $partOfTVSeries;
    }
    public function getPartOfTVSeries()
    {
        return $this->partOfTVSeries;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }
    public function getFamilyName()
    {
        return $this->familyName;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setAttendeeCount($attendeeCount)
    {
        $this->attendeeCount = $attendeeCount;
    }
    public function getAttendeeCount()
    {
        return $this->attendeeCount;
    }
    public function setInAlbum(Google_ItemScope $inAlbum)
    {
        $this->inAlbum = $inAlbum;
    }
    public function getInAlbum()
    {
        return $this->inAlbum;
    }
    public function setAddressRegion($addressRegion)
    {
        $this->addressRegion = $addressRegion;
    }
    public function getAddressRegion()
    {
        return $this->addressRegion;
    }
    public function setHeight($height)
    {
        $this->height = $height;
    }
    public function getHeight()
    {
        return $this->height;
    }
    public function setGeo(Google_ItemScope $geo)
    {
        $this->geo = $geo;
    }
    public function getGeo()
    {
        return $this->geo;
    }
    public function setEmbedUrl($embedUrl)
    {
        $this->embedUrl = $embedUrl;
    }
    public function getEmbedUrl()
    {
        return $this->embedUrl;
    }
    public function setTickerSymbol($tickerSymbol)
    {
        $this->tickerSymbol = $tickerSymbol;
    }
    public function getTickerSymbol()
    {
        return $this->tickerSymbol;
    }
    public function setPlayerType($playerType)
    {
        $this->playerType = $playerType;
    }
    public function getPlayerType()
    {
        return $this->playerType;
    }
    public function setAbout(Google_ItemScope $about)
    {
        $this->about = $about;
    }
    public function getAbout()
    {
        return $this->about;
    }
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }
    public function getGivenName()
    {
        return $this->givenName;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPerformers($performers)
    {
        $this->assertIsArray($performers, "Google_ItemScope", "Google_ItemScope::setPerformers");
        $this->performers = $performers;
    }
    public function getPerformers()
    {
        return $this->performers;
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
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setThumbnail(Google_ItemScope $thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }
    public function getCaption()
    {
        return $this->caption;
    }
    public function setRatingValue($ratingValue)
    {
        $this->ratingValue = $ratingValue;
    }
    public function getRatingValue()
    {
        return $this->ratingValue;
    }
    public function setReviewRating(Google_ItemScope $reviewRating)
    {
        $this->reviewRating = $reviewRating;
    }
    public function getReviewRating()
    {
        return $this->reviewRating;
    }
    public function setAudio(Google_ItemScope $audio)
    {
        $this->audio = $audio;
    }
    public function getAudio()
    {
        return $this->audio;
    }
}
class Google_Moment extends Google_Model
{
    public $startDate = NULL;
    public $kind = NULL;
    protected $__targetType = "Google_ItemScope";
    protected $__targetDataType = "";
    public $target = NULL;
    protected $__verbType = "Google_MomentVerb";
    protected $__verbDataType = "";
    public $verb = NULL;
    protected $__resultType = "Google_ItemScope";
    protected $__resultDataType = "";
    public $result = NULL;
    public $type = NULL;
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    public function getStartDate()
    {
        return $this->startDate;
    }
    public function setKind($kind)
    {
        $this->kind = $kind;
    }
    public function getKind()
    {
        return $this->kind;
    }
    public function setTarget(Google_ItemScope $target)
    {
        $this->target = $target;
    }
    public function getTarget()
    {
        return $this->target;
    }
    public function setVerb(Google_MomentVerb $verb)
    {
        $this->verb = $verb;
    }
    public function getVerb()
    {
        return $this->verb;
    }
    public function setResult(Google_ItemScope $result)
    {
        $this->result = $result;
    }
    public function getResult()
    {
        return $this->result;
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
class Google_MomentVerb extends Google_Model
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

?>