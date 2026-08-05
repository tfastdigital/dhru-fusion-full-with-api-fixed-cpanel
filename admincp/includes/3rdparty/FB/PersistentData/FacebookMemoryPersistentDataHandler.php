<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\PersistentData;

/**
 * Class FacebookMemoryPersistentDataHandler
 *
 * @package Facebook
 */
class FacebookMemoryPersistentDataHandler implements PersistentDataInterface
{
    /**
     * @var array The session data to keep in memory.
     */
    protected $sessionData = [];
    public function get($key)
    {
        return isset($this->sessionData[$key]) ? $this->sessionData[$key] : NULL;
    }
    public function set($key, $value)
    {
        $this->sessionData[$key] = $value;
    }
}

?>