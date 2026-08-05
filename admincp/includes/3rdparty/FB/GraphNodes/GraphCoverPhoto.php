<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphCoverPhoto
 *
 * @package Facebook
 */
class GraphCoverPhoto extends GraphNode
{
    public function getId()
    {
        return $this->getField("id");
    }
    public function getSource()
    {
        return $this->getField("source");
    }
    public function getOffsetX()
    {
        return $this->getField("offset_x");
    }
    public function getOffsetY()
    {
        return $this->getField("offset_y");
    }
}

?>