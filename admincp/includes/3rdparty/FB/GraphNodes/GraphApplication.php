<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphApplication
 *
 * @package Facebook
 */
class GraphApplication extends GraphNode
{
    public function getId()
    {
        return $this->getField("id");
    }
}

?>