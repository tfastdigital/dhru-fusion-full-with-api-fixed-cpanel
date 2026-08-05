<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphAlbum
 *
 * @package Facebook
 */
class GraphAlbum extends GraphNode
{
    /**
     * @var array Maps object key names to Graph object types.
     */
    protected static $graphObjectMap = ["from" => "\\Facebook\\GraphNodes\\GraphUser", "place" => "\\Facebook\\GraphNodes\\GraphPage"];
    public function getId()
    {
        return $this->getField("id");
    }
    public function getCanUpload()
    {
        return $this->getField("can_upload");
    }
    public function getCount()
    {
        return $this->getField("count");
    }
    public function getCoverPhoto()
    {
        return $this->getField("cover_photo");
    }
    public function getCreatedTime()
    {
        return $this->getField("created_time");
    }
    public function getUpdatedTime()
    {
        return $this->getField("updated_time");
    }
    public function getDescription()
    {
        return $this->getField("description");
    }
    public function getFrom()
    {
        return $this->getField("from");
    }
    public function getPlace()
    {
        return $this->getField("place");
    }
    public function getLink()
    {
        return $this->getField("link");
    }
    public function getLocation()
    {
        return $this->getField("location");
    }
    public function getName()
    {
        return $this->getField("name");
    }
    public function getPrivacy()
    {
        return $this->getField("privacy");
    }
    public function getType()
    {
        return $this->getField("type");
    }
}

?>