<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphGroup
 *
 * @package Facebook
 */
class GraphGroup extends GraphNode
{
    /**
     * @var array Maps object key names to GraphNode types.
     */
    protected static $graphObjectMap = ["cover" => "\\Facebook\\GraphNodes\\GraphCoverPhoto", "venue" => "\\Facebook\\GraphNodes\\GraphLocation"];
    public function getId()
    {
        return $this->getField("id");
    }
    public function getCover()
    {
        return $this->getField("cover");
    }
    public function getDescription()
    {
        return $this->getField("description");
    }
    public function getEmail()
    {
        return $this->getField("email");
    }
    public function getIcon()
    {
        return $this->getField("icon");
    }
    public function getLink()
    {
        return $this->getField("link");
    }
    public function getName()
    {
        return $this->getField("name");
    }
    public function getMemberRequestCount()
    {
        return $this->getField("member_request_count");
    }
    public function getOwner()
    {
        return $this->getField("owner");
    }
    public function getParent()
    {
        return $this->getField("parent");
    }
    public function getPrivacy()
    {
        return $this->getField("privacy");
    }
    public function getUpdatedTime()
    {
        return $this->getField("updated_time");
    }
    public function getVenue()
    {
        return $this->getField("venue");
    }
}

?>