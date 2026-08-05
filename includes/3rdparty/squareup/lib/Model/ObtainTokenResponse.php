<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ObtainTokenResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ObtainTokenResponse implements \ArrayAccess
{
    /**
     * $access_token A valid OAuth access token. OAuth access tokens are 64 bytes long. Provide the access token in a header with every request to Connect API endpoints. See the [Build with OAuth](/authz/oauth/build-with-the-api) guide for more information.
     * @var string
     */
    protected $access_token = NULL;
    /**
     * $token_type This value is always _bearer_.
     * @var string
     */
    protected $token_type = NULL;
    /**
     * $expires_at The date when access_token expires, in [ISO 8601](http://www.iso.org/iso/home/standards/iso8601.htm) format.
     * @var string
     */
    protected $expires_at = NULL;
    /**
     * $merchant_id The ID of the authorizing merchant's business.
     * @var string
     */
    protected $merchant_id = NULL;
    /**
     * $subscription_id __LEGACY FIELD__. The ID of a subscription plan the merchant signed up for. Only present if the merchant signed up for a subscription during authorization.
     * @var string
     */
    protected $subscription_id = NULL;
    /**
     * $plan_id __LEGACY FIELD__. The ID of the subscription plan the merchant signed up for. Only present if the merchant signed up for a subscription during authorization.
     * @var string
     */
    protected $plan_id = NULL;
    /**
     * $id_token Then OpenID token belonging to this this person. Only present if the OPENID scope is included in the authorize request.
     * @var string
     */
    protected $id_token = NULL;
    /**
     * $refresh_token A refresh token. For more information, see [OAuth access token management](/authz/oauth/how-it-works#oauth-access-token-management).
     * @var string
     */
    protected $refresh_token = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["access_token" => "string", "token_type" => "string", "expires_at" => "string", "merchant_id" => "string", "subscription_id" => "string", "plan_id" => "string", "id_token" => "string", "refresh_token" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["access_token" => "access_token", "token_type" => "token_type", "expires_at" => "expires_at", "merchant_id" => "merchant_id", "subscription_id" => "subscription_id", "plan_id" => "plan_id", "id_token" => "id_token", "refresh_token" => "refresh_token"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["access_token" => "setAccessToken", "token_type" => "setTokenType", "expires_at" => "setExpiresAt", "merchant_id" => "setMerchantId", "subscription_id" => "setSubscriptionId", "plan_id" => "setPlanId", "id_token" => "setIdToken", "refresh_token" => "setRefreshToken"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["access_token" => "getAccessToken", "token_type" => "getTokenType", "expires_at" => "getExpiresAt", "merchant_id" => "getMerchantId", "subscription_id" => "getSubscriptionId", "plan_id" => "getPlanId", "id_token" => "getIdToken", "refresh_token" => "getRefreshToken"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["access_token"])) {
                $this->access_token = $data["access_token"];
            } else {
                $this->access_token = NULL;
            }
            if (isset($data["token_type"])) {
                $this->token_type = $data["token_type"];
            } else {
                $this->token_type = NULL;
            }
            if (isset($data["expires_at"])) {
                $this->expires_at = $data["expires_at"];
            } else {
                $this->expires_at = NULL;
            }
            if (isset($data["merchant_id"])) {
                $this->merchant_id = $data["merchant_id"];
            } else {
                $this->merchant_id = NULL;
            }
            if (isset($data["subscription_id"])) {
                $this->subscription_id = $data["subscription_id"];
            } else {
                $this->subscription_id = NULL;
            }
            if (isset($data["plan_id"])) {
                $this->plan_id = $data["plan_id"];
            } else {
                $this->plan_id = NULL;
            }
            if (isset($data["id_token"])) {
                $this->id_token = $data["id_token"];
            } else {
                $this->id_token = NULL;
            }
            if (isset($data["refresh_token"])) {
                $this->refresh_token = $data["refresh_token"];
            } else {
                $this->refresh_token = NULL;
            }
        }
    }
    public function getAccessToken()
    {
        return $this->access_token;
    }
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }
    public function getTokenType()
    {
        return $this->token_type;
    }
    public function setTokenType($token_type)
    {
        $this->token_type = $token_type;
        return $this;
    }
    public function getExpiresAt()
    {
        return $this->expires_at;
    }
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }
    public function getMerchantId()
    {
        return $this->merchant_id;
    }
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
        return $this;
    }
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }
    public function setSubscriptionId($subscription_id)
    {
        $this->subscription_id = $subscription_id;
        return $this;
    }
    public function getPlanId()
    {
        return $this->plan_id;
    }
    public function setPlanId($plan_id)
    {
        $this->plan_id = $plan_id;
        return $this;
    }
    public function getIdToken()
    {
        return $this->id_token;
    }
    public function setIdToken($id_token)
    {
        $this->id_token = $id_token;
        return $this;
    }
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
        return $this;
    }
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
    public function __toString()
    {
        if (defined("JSON_PRETTY_PRINT")) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }
        return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
    }
}

?>