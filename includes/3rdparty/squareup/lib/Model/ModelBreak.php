<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ModelBreak Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ModelBreak implements \ArrayAccess
{
    /**
     * $id UUID for this object
     * @var string
     */
    protected $id = NULL;
    /**
     * $start_at RFC 3339; follows same timezone info as `Shift`. Precision up to the minute is respected; seconds are truncated.
     * @var string
     */
    protected $start_at = NULL;
    /**
     * $end_at RFC 3339; follows same timezone info as `Shift`. Precision up to the minute is respected; seconds are truncated. The `end_at` minute is not counted when the break length is calculated. For example, a break from `00:00` to `00:11`  is considered a 10 minute break (midnight to 10 minutes after midnight).
     * @var string
     */
    protected $end_at = NULL;
    /**
     * $break_type_id The `BreakType` this `Break` was templated on.
     * @var string
     */
    protected $break_type_id = NULL;
    /**
     * $name A human-readable name.
     * @var string
     */
    protected $name = NULL;
    /**
     * $expected_duration Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of the break.
     * @var string
     */
    protected $expected_duration = NULL;
    /**
     * $is_paid Whether this break counts towards time worked for compensation purposes.
     * @var bool
     */
    protected $is_paid = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "start_at" => "string", "end_at" => "string", "break_type_id" => "string", "name" => "string", "expected_duration" => "string", "is_paid" => "bool"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "start_at" => "start_at", "end_at" => "end_at", "break_type_id" => "break_type_id", "name" => "name", "expected_duration" => "expected_duration", "is_paid" => "is_paid"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "start_at" => "setStartAt", "end_at" => "setEndAt", "break_type_id" => "setBreakTypeId", "name" => "setName", "expected_duration" => "setExpectedDuration", "is_paid" => "setIsPaid"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "start_at" => "getStartAt", "end_at" => "getEndAt", "break_type_id" => "getBreakTypeId", "name" => "getName", "expected_duration" => "getExpectedDuration", "is_paid" => "getIsPaid"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            } else {
                $this->id = NULL;
            }
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
            if (isset($data["break_type_id"])) {
                $this->break_type_id = $data["break_type_id"];
            } else {
                $this->break_type_id = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["expected_duration"])) {
                $this->expected_duration = $data["expected_duration"];
            } else {
                $this->expected_duration = NULL;
            }
            if (isset($data["is_paid"])) {
                $this->is_paid = $data["is_paid"];
            } else {
                $this->is_paid = NULL;
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
    public function getBreakTypeId()
    {
        return $this->break_type_id;
    }
    public function setBreakTypeId($break_type_id)
    {
        $this->break_type_id = $break_type_id;
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
    public function getExpectedDuration()
    {
        return $this->expected_duration;
    }
    public function setExpectedDuration($expected_duration)
    {
        $this->expected_duration = $expected_duration;
        return $this;
    }
    public function getIsPaid()
    {
        return $this->is_paid;
    }
    public function setIsPaid($is_paid)
    {
        $this->is_paid = $is_paid;
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