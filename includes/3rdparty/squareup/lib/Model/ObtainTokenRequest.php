<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ObtainTokenRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ObtainTokenRequest implements \ArrayAccess
{
    /**
     * $client_id The Square-issued ID of your application, available from the [application dashboard](https://connect.squareup.com/apps).
     * @var string
     */
    protected $client_id = NULL;
    /**
     * $client_secret The Square-issued application secret for your application, available from the [application dashboard](https://connect.squareup.com/apps).
     * @var string
     */
    protected $client_secret = NULL;
    /**
     * $code The authorization code to exchange. This is required if `grant_type` is set to `authorization_code`, to indicate that the application wants to exchange an authorization code for an OAuth access token.
     * @var string
     */
    protected $code = NULL;
    /**
     * $redirect_uri The redirect URL assigned in the [application dashboard](https://connect.squareup.com/apps).
     * @var string
     */
    protected $redirect_uri = NULL;
    /**
     * $grant_type Specifies the method to request an OAuth access token. Valid values are: `authorization_code`, `refresh_token`, and `migration_token`
     * @var string
     */
    protected $grant_type = NULL;
    /**
     * $refresh_token A valid refresh token for generating a new OAuth access token. A valid refresh token is required if `grant_type` is set to `refresh_token` , to indicate the application wants a replacement for an expired OAuth access token.
     * @var string
     */
    protected $refresh_token = NULL;
    /**
     * $migration_token Legacy OAuth access token obtained using a Connect API version prior to 2019-03-13. This parameter is required if `grant_type` is set to `migration_token` to indicate that the application wants to get a replacement OAuth access token. The response also returns a refresh token. For more information, see [Migrate to Using Refresh Tokens](/authz/oauth/migration).
     * @var string
     */
    protected $migration_token = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["client_id" => "string", "client_secret" => "string", "code" => "string", "redirect_uri" => "string", "grant_type" => "string", "refresh_token" => "string", "migration_token" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["client_id" => "client_id", "client_secret" => "client_secret", "code" => "code", "redirect_uri" => "redirect_uri", "grant_type" => "grant_type", "refresh_token" => "refresh_token", "migration_token" => "migration_token"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["client_id" => "setClientId", "client_secret" => "setClientSecret", "code" => "setCode", "redirect_uri" => "setRedirectUri", "grant_type" => "setGrantType", "refresh_token" => "setRefreshToken", "migration_token" => "setMigrationToken"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["client_id" => "getClientId", "client_secret" => "getClientSecret", "code" => "getCode", "redirect_uri" => "getRedirectUri", "grant_type" => "getGrantType", "refresh_token" => "getRefreshToken", "migration_token" => "getMigrationToken"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["client_id"])) {
                $this->client_id = $data["client_id"];
            } else {
                $this->client_id = NULL;
            }
            if (isset($data["client_secret"])) {
                $this->client_secret = $data["client_secret"];
            } else {
                $this->client_secret = NULL;
            }
            if (isset($data["code"])) {
                $this->code = $data["code"];
            } else {
                $this->code = NULL;
            }
            if (isset($data["redirect_uri"])) {
                $this->redirect_uri = $data["redirect_uri"];
            } else {
                $this->redirect_uri = NULL;
            }
            if (isset($data["grant_type"])) {
                $this->grant_type = $data["grant_type"];
            } else {
                $this->grant_type = NULL;
            }
            if (isset($data["refresh_token"])) {
                $this->refresh_token = $data["refresh_token"];
            } else {
                $this->refresh_token = NULL;
            }
            if (isset($data["migration_token"])) {
                $this->migration_token = $data["migration_token"];
            } else {
                $this->migration_token = NULL;
            }
        }
    }
    public function getClientId()
    {
        return $this->client_id;
    }
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }
    public function getClientSecret()
    {
        return $this->client_secret;
    }
    public function setClientSecret($client_secret)
    {
        $this->client_secret = $client_secret;
        return $this;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
        return $this;
    }
    public function getGrantType()
    {
        return $this->grant_type;
    }
    public function setGrantType($grant_type)
    {
        $this->grant_type = $grant_type;
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
    public function getMigrationToken()
    {
        return $this->migration_token;
    }
    public function setMigrationToken($migration_token)
    {
        $this->migration_token = $migration_token;
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