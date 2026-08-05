<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * StandardUnitDescriptionGroup Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class StandardUnitDescriptionGroup implements \ArrayAccess
{
    /**
     * $standard_unit_descriptions List of measurement units in this description group.
     * @var \SquareConnect\Model\StandardUnitDescription[]
     */
    protected $standard_unit_descriptions = NULL;
    /**
     * $language_code IETF language tag.
     * @var string
     */
    protected $language_code = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["standard_unit_descriptions" => "\\SquareConnect\\Model\\StandardUnitDescription[]", "language_code" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["standard_unit_descriptions" => "standard_unit_descriptions", "language_code" => "language_code"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["standard_unit_descriptions" => "setStandardUnitDescriptions", "language_code" => "setLanguageCode"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["standard_unit_descriptions" => "getStandardUnitDescriptions", "language_code" => "getLanguageCode"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["standard_unit_descriptions"])) {
                $this->standard_unit_descriptions = $data["standard_unit_descriptions"];
            } else {
                $this->standard_unit_descriptions = NULL;
            }
            if (isset($data["language_code"])) {
                $this->language_code = $data["language_code"];
            } else {
                $this->language_code = NULL;
            }
        }
    }
    public function getStandardUnitDescriptions()
    {
        return $this->standard_unit_descriptions;
    }
    public function setStandardUnitDescriptions($standard_unit_descriptions)
    {
        $this->standard_unit_descriptions = $standard_unit_descriptions;
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