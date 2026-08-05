<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphPage
 *
 * @package Facebook
 */
class GraphPage extends GraphNode
{
    /**
     * @var array Maps object key names to Graph object types.
     */
    protected static $graphObjectMap = ["best_page" => "\\Facebook\\GraphNodes\\GraphPage", "global_brand_parent_page" => "\\Facebook\\GraphNodes\\GraphPage", "location" => "\\Facebook\\GraphNodes\\GraphLocation"];
    public function getId()
    {
        return $this->getField("id");
    }
    public function getCategory()
    {
        return $this->getField("category");
    }
    public function getName()
    {
        return $this->getField("name");
    }
    public function getBestPage()
    {
        return $this->getField("best_page");
    }
    public function getGlobalBrandParentPage()
    {
        return $this->getField("global_brand_parent_page");
    }
    public function getLocation()
    {
        return $this->getField("location");
    }
    public function getAccessToken()
    {
        return $this->getField("access_token");
    }
    public function getPerms()
    {
        return $this->getField("perms");
    }
}

?>