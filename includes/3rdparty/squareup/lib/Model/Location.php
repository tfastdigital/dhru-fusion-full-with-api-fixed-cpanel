<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * Location Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Location implements \ArrayAccess
{
    /**
     * $id The location's unique ID.
     * @var string
     */
    protected $id = NULL;
    /**
     * $name The location's name. Location names are set by the account owner and displayed in the dashboard as the location's nickname
     * @var string
     */
    protected $name = NULL;
    /**
     * $address The location's physical address.
     * @var \SquareConnect\Model\Address
     */
    protected $address = NULL;
    /**
     * $timezone The [IANA Timezone Database](https://www.iana.org/time-zones) identifier for the location's timezone.
     * @var string
     */
    protected $timezone = NULL;
    /**
     * $capabilities Indicates which Square features are enabled for the location. See [LocationCapability](#type-locationcapability) for possible values
     * @var string[]
     */
    protected $capabilities = NULL;
    /**
     * $status The location's status See [LocationStatus](#type-locationstatus) for possible values
     * @var string
     */
    protected $status = NULL;
    /**
     * $created_at The time when the location was created, in RFC 3339 format.
     * @var string
     */
    protected $created_at = NULL;
    /**
     * $merchant_id The identifier of the merchant that owns the location.
     * @var string
     */
    protected $merchant_id = NULL;
    /**
     * $country The location's country, in ISO 3166-1-alpha-2 format. See [Country](#type-country) for possible values
     * @var string
     */
    protected $country = NULL;
    /**
     * $language_code The language associated with the location in [BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A).
     * @var string
     */
    protected $language_code = NULL;
    /**
     * $currency The currency used for all transactions at this location, specified in __ISO 4217 format__. For example, the currency for a location processing transactions in the United States is 'USD'. See [Currency](#type-currency) for possible values
     * @var string
     */
    protected $currency = NULL;
    /**
     * $phone_number The location's phone_number.
     * @var string
     */
    protected $phone_number = NULL;
    /**
     * $business_name The location's business_name which is shown to its customers. For example, this is the name printed on its customer's receipts.
     * @var string
     */
    protected $business_name = NULL;
    /**
     * $type The location's type, as set by the account owner in the Square dashboard. Typically used to indicate whether or not the location object represents a physical space like a building or mall space. See [LocationType](#type-locationtype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $website_url The location's website, as set by the account owner in the Square dashboard.  Default: none; only exists if explicitly set.
     * @var string
     */
    protected $website_url = NULL;
    /**
     * $business_hours The hours of operation for a business location.  Default: none; only exists if explicitly set.
     * @var \SquareConnect\Model\BusinessHours
     */
    protected $business_hours = NULL;
    /**
     * $business_email The email of the location.
     * @var string
     */
    protected $business_email = NULL;
    /**
     * $description The business description of the location.
     * @var string
     */
    protected $description = NULL;
    /**
     * $twitter_username The Twitter username of the location without the '
     * @var string
     */
    protected $twitter_username = NULL;
    /**
     * $instagram_username The Instagram username of the location without the '
     * @var string
     */
    protected $instagram_username = NULL;
    /**
     * $facebook_url The Facebook profile URL of the location. The URL should begin with 'facebook.com/'.
     * @var string
     */
    protected $facebook_url = NULL;
    /**
     * $coordinates The physical coordinates (latitude and longitude) of the location.
     * @var \SquareConnect\Model\Coordinates
     */
    protected $coordinates = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "name" => "string", "address" => "\\SquareConnect\\Model\\Address", "timezone" => "string", "capabilities" => "string[]", "status" => "string", "created_at" => "string", "merchant_id" => "string", "country" => "string", "language_code" => "string", "currency" => "string", "phone_number" => "string", "business_name" => "string", "type" => "string", "website_url" => "string", "business_hours" => "\\SquareConnect\\Model\\BusinessHours", "business_email" => "string", "description" => "string", "twitter_username" => "string", "instagram_username" => "string", "facebook_url" => "string", "coordinates" => "\\SquareConnect\\Model\\Coordinates"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "name" => "name", "address" => "address", "timezone" => "timezone", "capabilities" => "capabilities", "status" => "status", "created_at" => "created_at", "merchant_id" => "merchant_id", "country" => "country", "language_code" => "language_code", "currency" => "currency", "phone_number" => "phone_number", "business_name" => "business_name", "type" => "type", "website_url" => "website_url", "business_hours" => "business_hours", "business_email" => "business_email", "description" => "description", "twitter_username" => "twitter_username", "instagram_username" => "instagram_username", "facebook_url" => "facebook_url", "coordinates" => "coordinates"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "name" => "setName", "address" => "setAddress", "timezone" => "setTimezone", "capabilities" => "setCapabilities", "status" => "setStatus", "created_at" => "setCreatedAt", "merchant_id" => "setMerchantId", "country" => "setCountry", "language_code" => "setLanguageCode", "currency" => "setCurrency", "phone_number" => "setPhoneNumber", "business_name" => "setBusinessName", "type" => "setType", "website_url" => "setWebsiteUrl", "business_hours" => "setBusinessHours", "business_email" => "setBusinessEmail", "description" => "setDescription", "twitter_username" => "setTwitterUsername", "instagram_username" => "setInstagramUsername", "facebook_url" => "setFacebookUrl", "coordinates" => "setCoordinates"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "name" => "getName", "address" => "getAddress", "timezone" => "getTimezone", "capabilities" => "getCapabilities", "status" => "getStatus", "created_at" => "getCreatedAt", "merchant_id" => "getMerchantId", "country" => "getCountry", "language_code" => "getLanguageCode", "currency" => "getCurrency", "phone_number" => "getPhoneNumber", "business_name" => "getBusinessName", "type" => "getType", "website_url" => "getWebsiteUrl", "business_hours" => "getBusinessHours", "business_email" => "getBusinessEmail", "description" => "getDescription", "twitter_username" => "getTwitterUsername", "instagram_username" => "getInstagramUsername", "facebook_url" => "getFacebookUrl", "coordinates" => "getCoordinates"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            } else {
                $this->id = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["address"])) {
                $this->address = $data["address"];
            } else {
                $this->address = NULL;
            }
            if (isset($data["timezone"])) {
                $this->timezone = $data["timezone"];
            } else {
                $this->timezone = NULL;
            }
            if (isset($data["capabilities"])) {
                $this->capabilities = $data["capabilities"];
            } else {
                $this->capabilities = NULL;
            }
            if (isset($data["status"])) {
                $this->status = $data["status"];
            } else {
                $this->status = NULL;
            }
            if (isset($data["created_at"])) {
                $this->created_at = $data["created_at"];
            } else {
                $this->created_at = NULL;
            }
            if (isset($data["merchant_id"])) {
                $this->merchant_id = $data["merchant_id"];
            } else {
                $this->merchant_id = NULL;
            }
            if (isset($data["country"])) {
                $this->country = $data["country"];
            } else {
                $this->country = NULL;
            }
            if (isset($data["language_code"])) {
                $this->language_code = $data["language_code"];
            } else {
                $this->language_code = NULL;
            }
            if (isset($data["currency"])) {
                $this->currency = $data["currency"];
            } else {
                $this->currency = NULL;
            }
            if (isset($data["phone_number"])) {
                $this->phone_number = $data["phone_number"];
            } else {
                $this->phone_number = NULL;
            }
            if (isset($data["business_name"])) {
                $this->business_name = $data["business_name"];
            } else {
                $this->business_name = NULL;
            }
            if (isset($data["type"])) {
                $this->type = $data["type"];
            } else {
                $this->type = NULL;
            }
            if (isset($data["website_url"])) {
                $this->website_url = $data["website_url"];
            } else {
                $this->website_url = NULL;
            }
            if (isset($data["business_hours"])) {
                $this->business_hours = $data["business_hours"];
            } else {
                $this->business_hours = NULL;
            }
            if (isset($data["business_email"])) {
                $this->business_email = $data["business_email"];
            } else {
                $this->business_email = NULL;
            }
            if (isset($data["description"])) {
                $this->description = $data["description"];
            } else {
                $this->description = NULL;
            }
            if (isset($data["twitter_username"])) {
                $this->twitter_username = $data["twitter_username"];
            } else {
                $this->twitter_username = NULL;
            }
            if (isset($data["instagram_username"])) {
                $this->instagram_username = $data["instagram_username"];
            } else {
                $this->instagram_username = NULL;
            }
            if (isset($data["facebook_url"])) {
                $this->facebook_url = $data["facebook_url"];
            } else {
                $this->facebook_url = NULL;
            }
            if (isset($data["coordinates"])) {
                $this->coordinates = $data["coordinates"];
            } else {
                $this->coordinates = NULL;
            }
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    public function getTimezone()
    {
        return $this->timezone;
    }
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }
    public function getCapabilities()
    {
        return $this->capabilities;
    }
    public function setCapabilities($capabilities)
    {
        $this->capabilities = $capabilities;
        return $this;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
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
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
    public function getLanguageCode()
    {
        return $this->language_code;
    }
    public function setLanguageCode($language_code)
    {
        $this->language_code = $language_code;
        return $this;
    }
    public function getCurrency()
    {
        return $this->currency;
    }
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }
    public function getBusinessName()
    {
        return $this->business_name;
    }
    public function setBusinessName($business_name)
    {
        $this->business_name = $business_name;
        return $this;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }
    public function setWebsiteUrl($website_url)
    {
        $this->website_url = $website_url;
        return $this;
    }
    public function getBusinessHours()
    {
        return $this->business_hours;
    }
    public function setBusinessHours($business_hours)
    {
        $this->business_hours = $business_hours;
        return $this;
    }
    public function getBusinessEmail()
    {
        return $this->business_email;
    }
    public function setBusinessEmail($business_email)
    {
        $this->business_email = $business_email;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getTwitterUsername()
    {
        return $this->twitter_username;
    }
    public function setTwitterUsername($twitter_username)
    {
        $this->twitter_username = $twitter_username;
        return $this;
    }
    public function getInstagramUsername()
    {
        return $this->instagram_username;
    }
    public function setInstagramUsername($instagram_username)
    {
        $this->instagram_username = $instagram_username;
        return $this;
    }
    public function getFacebookUrl()
    {
        return $this->facebook_url;
    }
    public function setFacebookUrl($facebook_url)
    {
        $this->facebook_url = $facebook_url;
        return $this;
    }
    public function getCoordinates()
    {
        return $this->coordinates;
    }
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
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