<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Authentication;

/**
 * Class AccessTokenMetadata
 *
 * Represents metadata from an access token.
 *
 * @package Facebook
 * @see     https://developers.facebook.com/docs/graph-api/reference/debug_token
 */
class AccessTokenMetadata
{
    /**
     * The access token metadata.
     *
     * @var array
     */
    protected $metadata = [];
    /**
     * Properties that should be cast as DateTime objects.
     *
     * @var array
     */
    protected static $dateProperties = ["expires_at", "issued_at"];
    public function __construct($metadata)
    {
        if (!isset($metadata["data"])) {
            throw new \Facebook\Exceptions\FacebookSDKException("Unexpected debug token response data.", 401);
        }
        $this->metadata = $metadata["data"];
        $this->castTimestampsToDateTime();
    }
    public function getField($field, $default = NULL)
    {
        if (isset($this->metadata[$field])) {
            return $this->metadata[$field];
        }
        return $default;
    }
    public function getProperty($field, $default = NULL)
    {
        return $this->getField($field, $default);
    }
    public function getChildProperty($parentField, $field, $default = NULL)
    {
        if (!isset($this->metadata[$parentField])) {
            return $default;
        }
        if (!isset($this->metadata[$parentField][$field])) {
            return $default;
        }
        return $this->metadata[$parentField][$field];
    }
    public function getErrorProperty($field, $default = NULL)
    {
        return $this->getChildProperty("error", $field, $default);
    }
    public function getMetadataProperty($field, $default = NULL)
    {
        return $this->getChildProperty("metadata", $field, $default);
    }
    public function getAppId()
    {
        return $this->getField("app_id");
    }
    public function getApplication()
    {
        return $this->getField("application");
    }
    public function isError()
    {
        return $this->getField("error") !== NULL;
    }
    public function getErrorCode()
    {
        return $this->getErrorProperty("code");
    }
    public function getErrorMessage()
    {
        return $this->getErrorProperty("message");
    }
    public function getErrorSubcode()
    {
        return $this->getErrorProperty("subcode");
    }
    public function getExpiresAt()
    {
        return $this->getField("expires_at");
    }
    public function getIsValid()
    {
        return $this->getField("is_valid");
    }
    public function getIssuedAt()
    {
        return $this->getField("issued_at");
    }
    public function getMetadata()
    {
        return $this->getField("metadata");
    }
    public function getSso()
    {
        return $this->getMetadataProperty("sso");
    }
    public function getAuthType()
    {
        return $this->getMetadataProperty("auth_type");
    }
    public function getAuthNonce()
    {
        return $this->getMetadataProperty("auth_nonce");
    }
    public function getProfileId()
    {
        return $this->getField("profile_id");
    }
    public function getScopes()
    {
        return $this->getField("scopes");
    }
    public function getUserId()
    {
        return $this->getField("user_id");
    }
    public function validateAppId($appId)
    {
        if ($this->getAppId() !== $appId) {
            throw new \Facebook\Exceptions\FacebookSDKException("Access token metadata contains unexpected app ID.", 401);
        }
    }
    public function validateUserId($userId)
    {
        if ($this->getUserId() !== $userId) {
            throw new \Facebook\Exceptions\FacebookSDKException("Access token metadata contains unexpected user ID.", 401);
        }
    }
    public function validateExpiration()
    {
        if (!$this->getExpiresAt() instanceof \DateTime) {
            return NULL;
        }
        if ($this->getExpiresAt()->getTimestamp() < time()) {
            throw new \Facebook\Exceptions\FacebookSDKException("Inspection of access token metadata shows that the access token has expired.", 401);
        }
    }
    private function convertTimestampToDateTime($timestamp)
    {
        $dt = new \DateTime();
        $dt->setTimestamp($timestamp);
        return $dt;
    }
    private function castTimestampsToDateTime()
    {
        foreach (static::$dateProperties as $key) {
            if (isset($this->metadata[$key]) && $this->metadata[$key] !== 0) {
                $this->metadata[$key] = $this->convertTimestampToDateTime($this->metadata[$key]);
            }
        }
    }
}

?>