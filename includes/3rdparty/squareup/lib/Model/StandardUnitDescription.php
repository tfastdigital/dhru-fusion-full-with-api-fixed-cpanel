<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * StandardUnitDescription Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class StandardUnitDescription implements \ArrayAccess
{
    /**
     * $unit Identifies the measurement unit being described.
     * @var \SquareConnect\Model\MeasurementUnit
     */
    protected $unit = NULL;
    /**
     * $name Display name of the measurement unit. For example, 'Pound'.
     * @var string
     */
    protected $name = NULL;
    /**
     * $abbreviation Abbreviation for the measurement unit. For example, 'lb'.
     * @var string
     */
    protected $abbreviation = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["unit" => "\\SquareConnect\\Model\\MeasurementUnit", "name" => "string", "abbreviation" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["unit" => "unit", "name" => "name", "abbreviation" => "abbreviation"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["unit" => "setUnit", "name" => "setName", "abbreviation" => "setAbbreviation"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["unit" => "getUnit", "name" => "getName", "abbreviation" => "getAbbreviation"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["unit"])) {
                $this->unit = $data["unit"];
            } else {
                $this->unit = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["abbreviation"])) {
                $this->abbreviation = $data["abbreviation"];
            } else {
                $this->abbreviation = NULL;
            }
        }
    }
    public function getUnit()
    {
        return $this->unit;
    }
    public function setUnit($unit)
    {
        $this->unit = $unit;
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
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
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