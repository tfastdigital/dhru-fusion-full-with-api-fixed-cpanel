<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

/**
 * Class FacebookCurl
 *
 * Abstraction for the procedural curl elements so that curl can be mocked and the implementation can be tested.
 *
 * @package Facebook
 */
class FacebookCurl
{
    /**
     * @var resource Curl resource instance
     */
    protected $curl = NULL;
    public function init()
    {
        $this->curl = curl_init();
    }
    public function setopt($key, $value)
    {
        curl_setopt($this->curl, $key, $value);
    }
    public function setoptArray($options)
    {
        curl_setopt_array($this->curl, $options);
    }
    public function exec()
    {
        return curl_exec($this->curl);
    }
    public function errno()
    {
        return curl_errno($this->curl);
    }
    public function error()
    {
        return curl_error($this->curl);
    }
    public function getinfo($type)
    {
        return curl_getinfo($this->curl, $type);
    }
    public function version()
    {
        return curl_version();
    }
    public function close()
    {
        curl_close($this->curl);
    }
}

?>