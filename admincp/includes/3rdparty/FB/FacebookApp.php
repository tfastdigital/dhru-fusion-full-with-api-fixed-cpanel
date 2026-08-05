<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

class FacebookApp implements \Serializable
{
    /**
     * @var string The app ID.
     */
    protected $id = NULL;
    /**
     * @var string The app secret.
     */
    protected $secret = NULL;
    public function __construct($id, $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getSecret()
    {
        return $this->secret;
    }
    public function getAccessToken()
    {
        return new Authentication\AccessToken($this->id . "|" . $this->secret);
    }
    public function serialize()
    {
        return serialize([$this->id, $this->secret]);
    }
    public function unserialize($serialized)
    {
        list($id, $secret) = unserialize($serialized);
        $this->__construct($id, $secret);
    }
}

?>