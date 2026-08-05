<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * Address Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Address implements \ArrayAccess
{
    /**
     * $address_line_1 The first line of the address.  Fields that start with `address_line` provide the address's most specific details, like street number, street name, and building name. They do *not* provide less specific details like city, state/province, or country (these details are provided in other fields).
     * @var string
     */
    protected $address_line_1 = NULL;
    /**
     * $address_line_2 The second line of the address, if any.
     * @var string
     */
    protected $address_line_2 = NULL;
    /**
     * $address_line_3 The third line of the address, if any.
     * @var string
     */
    protected $address_line_3 = NULL;
    /**
     * $locality The city or town of the address.
     * @var string
     */
    protected $locality = NULL;
    /**
     * $sublocality A civil region within the address's `locality`, if any.
     * @var string
     */
    protected $sublocality = NULL;
    /**
     * $sublocality_2 A civil region within the address's `sublocality`, if any.
     * @var string
     */
    protected $sublocality_2 = NULL;
    /**
     * $sublocality_3 A civil region within the address's `sublocality_2`, if any.
     * @var string
     */
    protected $sublocality_3 = NULL;
    /**
     * $administrative_district_level_1 A civil entity within the address's country. In the US, this is the state.
     * @var string
     */
    protected $administrative_district_level_1 = NULL;
    /**
     * $administrative_district_level_2 A civil entity within the address's `administrative_district_level_1`. In the US, this is the county.
     * @var string
     */
    protected $administrative_district_level_2 = NULL;
    /**
     * $administrative_district_level_3 A civil entity within the address's `administrative_district_level_2`, if any.
     * @var string
     */
    protected $administrative_district_level_3 = NULL;
    /**
     * $postal_code The address's postal code.
     * @var string
     */
    protected $postal_code = NULL;
    /**
     * $country The address's country, in ISO 3166-1-alpha-2 format. See [Country](#type-country) for possible values
     * @var string
     */
    protected $country = NULL;
    /**
     * $first_name Optional first name when it's representing recipient.
     * @var string
     */
    protected $first_name = NULL;
    /**
     * $last_name Optional last name when it's representing recipient.
     * @var string
     */
    protected $last_name = NULL;
    /**
     * $organization Optional organization name when it's representing recipient.
     * @var string
     */
    protected $organization = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["address_line_1" => "string", "address_line_2" => "string", "address_line_3" => "string", "locality" => "string", "sublocality" => "string", "sublocality_2" => "string", "sublocality_3" => "string", "administrative_district_level_1" => "string", "administrative_district_level_2" => "string", "administrative_district_level_3" => "string", "postal_code" => "string", "country" => "string", "first_name" => "string", "last_name" => "string", "organization" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["address_line_1" => "address_line_1", "address_line_2" => "address_line_2", "address_line_3" => "address_line_3", "locality" => "locality", "sublocality" => "sublocality", "sublocality_2" => "sublocality_2", "sublocality_3" => "sublocality_3", "administrative_district_level_1" => "administrative_district_level_1", "administrative_district_level_2" => "administrative_district_level_2", "administrative_district_level_3" => "administrative_district_level_3", "postal_code" => "postal_code", "country" => "country", "first_name" => "first_name", "last_name" => "last_name", "organization" => "organization"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["address_line_1" => "setAddressLine1", "address_line_2" => "setAddressLine2", "address_line_3" => "setAddressLine3", "locality" => "setLocality", "sublocality" => "setSublocality", "sublocality_2" => "setSublocality2", "sublocality_3" => "setSublocality3", "administrative_district_level_1" => "setAdministrativeDistrictLevel1", "administrative_district_level_2" => "setAdministrativeDistrictLevel2", "administrative_district_level_3" => "setAdministrativeDistrictLevel3", "postal_code" => "setPostalCode", "country" => "setCountry", "first_name" => "setFirstName", "last_name" => "setLastName", "organization" => "setOrganization"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["address_line_1" => "getAddressLine1", "address_line_2" => "getAddressLine2", "address_line_3" => "getAddressLine3", "locality" => "getLocality", "sublocality" => "getSublocality", "sublocality_2" => "getSublocality2", "sublocality_3" => "getSublocality3", "administrative_district_level_1" => "getAdministrativeDistrictLevel1", "administrative_district_level_2" => "getAdministrativeDistrictLevel2", "administrative_district_level_3" => "getAdministrativeDistrictLevel3", "postal_code" => "getPostalCode", "country" => "getCountry", "first_name" => "getFirstName", "last_name" => "getLastName", "organization" => "getOrganization"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["address_line_1"])) {
                $this->address_line_1 = $data["address_line_1"];
            } else {
                $this->address_line_1 = NULL;
            }
            if (isset($data["address_line_2"])) {
                $this->address_line_2 = $data["address_line_2"];
            } else {
                $this->address_line_2 = NULL;
            }
            if (isset($data["address_line_3"])) {
                $this->address_line_3 = $data["address_line_3"];
            } else {
                $this->address_line_3 = NULL;
            }
            if (isset($data["locality"])) {
                $this->locality = $data["locality"];
            } else {
                $this->locality = NULL;
            }
            if (isset($data["sublocality"])) {
                $this->sublocality = $data["sublocality"];
            } else {
                $this->sublocality = NULL;
            }
            if (isset($data["sublocality_2"])) {
                $this->sublocality_2 = $data["sublocality_2"];
            } else {
                $this->sublocality_2 = NULL;
            }
            if (isset($data["sublocality_3"])) {
                $this->sublocality_3 = $data["sublocality_3"];
            } else {
                $this->sublocality_3 = NULL;
            }
            if (isset($data["administrative_district_level_1"])) {
                $this->administrative_district_level_1 = $data["administrative_district_level_1"];
            } else {
                $this->administrative_district_level_1 = NULL;
            }
            if (isset($data["administrative_district_level_2"])) {
                $this->administrative_district_level_2 = $data["administrative_district_level_2"];
            } else {
                $this->administrative_district_level_2 = NULL;
            }
            if (isset($data["administrative_district_level_3"])) {
                $this->administrative_district_level_3 = $data["administrative_district_level_3"];
            } else {
                $this->administrative_district_level_3 = NULL;
            }
            if (isset($data["postal_code"])) {
                $this->postal_code = $data["postal_code"];
            } else {
                $this->postal_code = NULL;
            }
            if (isset($data["country"])) {
                $this->country = $data["country"];
            } else {
                $this->country = NULL;
            }
            if (isset($data["first_name"])) {
                $this->first_name = $data["first_name"];
            } else {
                $this->first_name = NULL;
            }
            if (isset($data["last_name"])) {
                $this->last_name = $data["last_name"];
            } else {
                $this->last_name = NULL;
            }
            if (isset($data["organization"])) {
                $this->organization = $data["organization"];
            } else {
                $this->organization = NULL;
            }
        }
    }
    public function getAddressLine1()
    {
        return $this->address_line_1;
    }
    public function setAddressLine1($address_line_1)
    {
        $this->address_line_1 = $address_line_1;
        return $this;
    }
    public function getAddressLine2()
    {
        return $this->address_line_2;
    }
    public function setAddressLine2($address_line_2)
    {
        $this->address_line_2 = $address_line_2;
        return $this;
    }
    public function getAddressLine3()
    {
        return $this->address_line_3;
    }
    public function setAddressLine3($address_line_3)
    {
        $this->address_line_3 = $address_line_3;
        return $this;
    }
    public function getLocality()
    {
        return $this->locality;
    }
    public function setLocality($locality)
    {
        $this->locality = $locality;
        return $this;
    }
    public function getSublocality()
    {
        return $this->sublocality;
    }
    public function setSublocality($sublocality)
    {
        $this->sublocality = $sublocality;
        return $this;
    }
    public function getSublocality2()
    {
        return $this->sublocality_2;
    }
    public function setSublocality2($sublocality_2)
    {
        $this->sublocality_2 = $sublocality_2;
        return $this;
    }
    public function getSublocality3()
    {
        return $this->sublocality_3;
    }
    public function setSublocality3($sublocality_3)
    {
        $this->sublocality_3 = $sublocality_3;
        return $this;
    }
    public function getAdministrativeDistrictLevel1()
    {
        return $this->administrative_district_level_1;
    }
    public function setAdministrativeDistrictLevel1($administrative_district_level_1)
    {
        $this->administrative_district_level_1 = $administrative_district_level_1;
        return $this;
    }
    public function getAdministrativeDistrictLevel2()
    {
        return $this->administrative_district_level_2;
    }
    public function setAdministrativeDistrictLevel2($administrative_district_level_2)
    {
        $this->administrative_district_level_2 = $administrative_district_level_2;
        return $this;
    }
    public function getAdministrativeDistrictLevel3()
    {
        return $this->administrative_district_level_3;
    }
    public function setAdministrativeDistrictLevel3($administrative_district_level_3)
    {
        $this->administrative_district_level_3 = $administrative_district_level_3;
        return $this;
    }
    public function getPostalCode()
    {
        return $this->postal_code;
    }
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
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
    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }
    public function getOrganization()
    {
        return $this->organization;
    }
    public function setOrganization($organization)
    {
        $this->organization = $organization;
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