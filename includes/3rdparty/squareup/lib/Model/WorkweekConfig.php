<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * WorkweekConfig Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class WorkweekConfig implements \ArrayAccess
{
    /**
     * $id UUID for this object
     * @var string
     */
    protected $id = NULL;
    /**
     * $start_of_week The day of the week on which a business week cuts over for compensation purposes. See [Weekday](#type-weekday) for possible values
     * @var string
     */
    protected $start_of_week = NULL;
    /**
     * $start_of_day_local_time The local time at which a business week cuts over. Represented as a string in `HH:MM` format (`HH:MM:SS` is also accepted, but seconds are truncated).
     * @var string
     */
    protected $start_of_day_local_time = NULL;
    /**
     * $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If not provided, Square executes a blind write; potentially overwriting data from another write.
     * @var int
     */
    protected $version = NULL;
    /**
     * $created_at A read-only timestamp in RFC 3339 format; presented in UTC
     * @var string
     */
    protected $created_at = NULL;
    /**
     * $updated_at A read-only timestamp in RFC 3339 format; presented in UTC
     * @var string
     */
    protected $updated_at = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "start_of_week" => "string", "start_of_day_local_time" => "string", "version" => "int", "created_at" => "string", "updated_at" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "start_of_week" => "start_of_week", "start_of_day_local_time" => "start_of_day_local_time", "version" => "version", "created_at" => "created_at", "updated_at" => "updated_at"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "start_of_week" => "setStartOfWeek", "start_of_day_local_time" => "setStartOfDayLocalTime", "version" => "setVersion", "created_at" => "setCreatedAt", "updated_at" => "setUpdatedAt"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "start_of_week" => "getStartOfWeek", "start_of_day_local_time" => "getStartOfDayLocalTime", "version" => "getVersion", "created_at" => "getCreatedAt", "updated_at" => "getUpdatedAt"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            } else {
                $this->id = NULL;
            }
            if (isset($data["start_of_week"])) {
                $this->start_of_week = $data["start_of_week"];
            } else {
                $this->start_of_week = NULL;
            }
            if (isset($data["start_of_day_local_time"])) {
                $this->start_of_day_local_time = $data["start_of_day_local_time"];
            } else {
                $this->start_of_day_local_time = NULL;
            }
            if (isset($data["version"])) {
                $this->version = $data["version"];
            } else {
                $this->version = NULL;
            }
            if (isset($data["created_at"])) {
                $this->created_at = $data["created_at"];
            } else {
                $this->created_at = NULL;
            }
            if (isset($data["updated_at"])) {
                $this->updated_at = $data["updated_at"];
            } else {
                $this->updated_at = NULL;
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
    public function getStartOfWeek()
    {
        return $this->start_of_week;
    }
    public function setStartOfWeek($start_of_week)
    {
        $this->start_of_week = $start_of_week;
        return $this;
    }
    public function getStartOfDayLocalTime()
    {
        return $this->start_of_day_local_time;
    }
    public function setStartOfDayLocalTime($start_of_day_local_time)
    {
        $this->start_of_day_local_time = $start_of_day_local_time;
        return $this;
    }
    public function getVersion()
    {
        return $this->version;
    }
    public function setVersion($version)
    {
        $this->version = $version;
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
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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