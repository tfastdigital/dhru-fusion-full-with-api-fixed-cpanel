<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphAchievement
 *
 * @package Facebook
 */
class GraphAchievement extends GraphNode
{
    /**
     * @var array Maps object key names to Graph object types.
     */
    protected static $graphObjectMap = ["from" => "\\Facebook\\GraphNodes\\GraphUser", "application" => "\\Facebook\\GraphNodes\\GraphApplication"];
    public function getId()
    {
        return $this->getField("id");
    }
    public function getFrom()
    {
        return $this->getField("from");
    }
    public function getPublishTime()
    {
        return $this->getField("publish_time");
    }
    public function getApplication()
    {
        return $this->getField("application");
    }
    public function getData()
    {
        return $this->getField("data");
    }
    public function getType()
    {
        return "game.achievement";
    }
    public function isNoFeedStory()
    {
        return $this->getField("no_feed_story");
    }
}

?>