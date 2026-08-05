<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphPicture
 *
 * @package Facebook
 */
class GraphPicture extends GraphNode
{
    public function isSilhouette()
    {
        return $this->getField("is_silhouette");
    }
    public function getUrl()
    {
        return $this->getField("url");
    }
    public function getWidth()
    {
        return $this->getField("width");
    }
    public function getHeight()
    {
        return $this->getField("height");
    }
}

?>