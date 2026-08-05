<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * DateRange Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class DateRange implements \ArrayAccess
{
    /**
     * $start_date String in `YYYY-MM-DD` format, e.g. `2017-10-31` per the ISO 8601 extended format for calendar dates. The beginning of a date range (inclusive)
     * @var string
     */
    protected $start_date = NULL;
    /**
     * $end_date String in `YYYY-MM-DD` format, e.g. `2017-10-31` per the ISO 8601 extended format for calendar dates. The end of a date range (inclusive)
     * @var string
     */
    protected $end_date = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["start_date" => "string", "end_date" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["start_date" => "start_date", "end_date" => "end_date"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["start_date" => "setStartDate", "end_date" => "setEndDate"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["start_date" => "getStartDate", "end_date" => "getEndDate"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["start_date"])) {
                $this->start_date = $data["start_date"];
            } else {
                $this->start_date = NULL;
            }
            if (isset($data["end_date"])) {
                $this->end_date = $data["end_date"];
            } else {
                $this->end_date = NULL;
            }
        }
    }
    public function getStartDate()
    {
        return $this->start_date;
    }
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
        return $this;
    }
    public function getEndDate()
    {
        return $this->end_date;
    }
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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