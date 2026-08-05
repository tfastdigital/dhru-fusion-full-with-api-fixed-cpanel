<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Authentication;

/**
 * Class AccessToken
 *
 * @package Facebook
 */
class AccessToken
{
    /**
     * The access token value.
     *
     * @var string
     */
    protected $value = "";
    /**
     * Date when token expires.
     *
     * @var \DateTime|null
     */
    protected $expiresAt = NULL;
    public function __construct($accessToken, $expiresAt = 0)
    {
        $this->value = $accessToken;
        if ($expiresAt) {
            $this->setExpiresAtFromTimeStamp($expiresAt);
        }
    }
    public function getAppSecretProof($appSecret)
    {
        return hash_hmac("sha256", $this->value, $appSecret);
    }
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
    public function isAppAccessToken()
    {
        return strpos($this->value, "|") !== false;
    }
    public function isLongLived()
    {
        if ($this->expiresAt) {
            return time() + 7200 < $this->expiresAt->getTimestamp();
        }
        if ($this->isAppAccessToken()) {
            return true;
        }
        return false;
    }
    public function isExpired()
    {
        if ($this->getExpiresAt() instanceof \DateTime) {
            return $this->getExpiresAt()->getTimestamp() < time();
        }
        if ($this->isAppAccessToken()) {
            return false;
        }
        return NULL;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function __toString()
    {
        return $this->getValue();
    }
    protected function setExpiresAtFromTimeStamp($timeStamp)
    {
        $dt = new \DateTime();
        $dt->setTimestamp($timeStamp);
        $this->expiresAt = $dt;
    }
}

?>