<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * BusinessHoursPeriod Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class BusinessHoursPeriod implements \ArrayAccess
{
    /**
     * $day_of_week The day of week for this time period. See [DayOfWeek](#type-dayofweek) for possible values
     * @var string
     */
    protected $day_of_week = NULL;
    /**
     * $start_local_time The start time of a business hours period, specified in local time using partial-time RFC3339 format.
     * @var string
     */
    protected $start_local_time = NULL;
    /**
     * $end_local_time The end time of a business hours period, specified in local time using partial-time RFC3339 format.
     * @var string
     */
    protected $end_local_time = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["day_of_week" => "string", "start_local_time" => "string", "end_local_time" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["day_of_week" => "day_of_week", "start_local_time" => "start_local_time", "end_local_time" => "end_local_time"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["day_of_week" => "setDayOfWeek", "start_local_time" => "setStartLocalTime", "end_local_time" => "setEndLocalTime"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["day_of_week" => "getDayOfWeek", "start_local_time" => "getStartLocalTime", "end_local_time" => "getEndLocalTime"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["day_of_week"])) {
                $this->day_of_week = $data["day_of_week"];
            } else {
                $this->day_of_week = NULL;
            }
            if (isset($data["start_local_time"])) {
                $this->start_local_time = $data["start_local_time"];
            } else {
                $this->start_local_time = NULL;
            }
            if (isset($data["end_local_time"])) {
                $this->end_local_time = $data["end_local_time"];
            } else {
                $this->end_local_time = NULL;
            }
        }
    }
    public function getDayOfWeek()
    {
        return $this->day_of_week;
    }
    public function setDayOfWeek($day_of_week)
    {
        $this->day_of_week = $day_of_week;
        return $this;
    }
    public function getStartLocalTime()
    {
        return $this->start_local_time;
    }
    public function setStartLocalTime($start_local_time)
    {
        $this->start_local_time = $start_local_time;
        return $this;
    }
    public function getEndLocalTime()
    {
        return $this->end_local_time;
    }
    public function setEndLocalTime($end_local_time)
    {
        $this->end_local_time = $end_local_time;
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