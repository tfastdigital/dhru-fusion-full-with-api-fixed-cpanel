<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphEvent
 *
 * @package Facebook
 */
class GraphEvent extends GraphNode
{
    /**
     * @var array Maps object key names to GraphNode types.
     */
    protected static $graphObjectMap = ["cover" => "\\Facebook\\GraphNodes\\GraphCoverPhoto", "place" => "\\Facebook\\GraphNodes\\GraphPage", "picture" => "\\Facebook\\GraphNodes\\GraphPicture", "parent_group" => "\\Facebook\\GraphNodes\\GraphGroup"];
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
    public function getEndTime()
    {
        return $this->getField("end_time");
    }
    public function getIsDateOnly()
    {
        return $this->getField("is_date_only");
    }
    public function getName()
    {
        return $this->getField("name");
    }
    public function getOwner()
    {
        return $this->getField("owner");
    }
    public function getParentGroup()
    {
        return $this->getField("parent_group");
    }
    public function getPlace()
    {
        return $this->getField("place");
    }
    public function getPrivacy()
    {
        return $this->getField("privacy");
    }
    public function getStartTime()
    {
        return $this->getField("start_time");
    }
    public function getTicketUri()
    {
        return $this->getField("ticket_uri");
    }
    public function getTimezone()
    {
        return $this->getField("timezone");
    }
    public function getUpdatedTime()
    {
        return $this->getField("updated_time");
    }
    public function getPicture()
    {
        return $this->getField("picture");
    }
    public function getAttendingCount()
    {
        return $this->getField("attending_count");
    }
    public function getDeclinedCount()
    {
        return $this->getField("declined_count");
    }
    public function getMaybeCount()
    {
        return $this->getField("maybe_count");
    }
    public function getNoreplyCount()
    {
        return $this->getField("noreply_count");
    }
    public function getInvitedCount()
    {
        return $this->getField("invited_count");
    }
}

?>