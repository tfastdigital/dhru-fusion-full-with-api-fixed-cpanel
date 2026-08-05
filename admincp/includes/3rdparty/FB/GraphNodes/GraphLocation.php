<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\GraphNodes;

/**
 * Class GraphLocation
 *
 * @package Facebook
 */
class GraphLocation extends GraphNode
{
    public function getStreet()
    {
        return $this->getField("street");
    }
    public function getCity()
    {
        return $this->getField("city");
    }
    public function getState()
    {
        return $this->getField("state");
    }
    public function getCountry()
    {
        return $this->getField("country");
    }
    public function getZip()
    {
        return $this->getField("zip");
    }
    public function getLatitude()
    {
        return $this->getField("latitude");
    }
    public function getLongitude()
    {
        return $this->getField("longitude");
    }
}

?>