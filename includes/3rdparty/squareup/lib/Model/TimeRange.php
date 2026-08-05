<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * TimeRange Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class TimeRange implements \ArrayAccess
{
    /**
     * $start_at A datetime value in RFC-3339 format indicating when the time range starts.
     * @var string
     */
    protected $start_at = NULL;
    /**
     * $end_at A datetime value in RFC-3339 format indicating when the time range ends.
     * @var string
     */
    protected $end_at = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["start_at" => "string", "end_at" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["start_at" => "start_at", "end_at" => "end_at"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["start_at" => "setStartAt", "end_at" => "setEndAt"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["start_at" => "getStartAt", "end_at" => "getEndAt"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["start_at"])) {
                $this->start_at = $data["start_at"];
            } else {
                $this->start_at = NULL;
            }
            if (isset($data["end_at"])) {
                $this->end_at = $data["end_at"];
            } else {
                $this->end_at = NULL;
            }
        }
    }
    public function getStartAt()
    {
        return $this->start_at;
    }
    public function setStartAt($start_at)
    {
        $this->start_at = $start_at;
        return $this;
    }
    public function getEndAt()
    {
        return $this->end_at;
    }
    public function setEndAt($end_at)
    {
        $this->end_at = $end_at;
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