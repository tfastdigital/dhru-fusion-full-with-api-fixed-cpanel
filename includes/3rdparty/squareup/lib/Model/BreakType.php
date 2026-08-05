<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * BreakType Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class BreakType implements \ArrayAccess
{
    /**
     * $id UUID for this object.
     * @var string
     */
    protected $id = NULL;
    /**
     * $location_id The ID of the business location this type of break applies to.
     * @var string
     */
    protected $location_id = NULL;
    /**
     * $break_name A human-readable name for this type of break. Will be displayed to employees in Square products.
     * @var string
     */
    protected $break_name = NULL;
    /**
     * $expected_duration Format: RFC-3339 P[n]Y[n]M[n]DT[n]H[n]M[n]S. The expected length of this break. Precision below minutes is truncated.
     * @var string
     */
    protected $expected_duration = NULL;
    /**
     * $is_paid Whether this break counts towards time worked for compensation purposes.
     * @var bool
     */
    protected $is_paid = NULL;
    /**
     * $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If a value is not provided, Square's servers execute a \"blind\" write; potentially  overwriting another writer's data.
     * @var int
     */
    protected $version = NULL;
    /**
     * $created_at A read-only timestamp in RFC 3339 format.
     * @var string
     */
    protected $created_at = NULL;
    /**
     * $updated_at A read-only timestamp in RFC 3339 format.
     * @var string
     */
    protected $updated_at = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "location_id" => "string", "break_name" => "string", "expected_duration" => "string", "is_paid" => "bool", "version" => "int", "created_at" => "string", "updated_at" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "location_id" => "location_id", "break_name" => "break_name", "expected_duration" => "expected_duration", "is_paid" => "is_paid", "version" => "version", "created_at" => "created_at", "updated_at" => "updated_at"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "location_id" => "setLocationId", "break_name" => "setBreakName", "expected_duration" => "setExpectedDuration", "is_paid" => "setIsPaid", "version" => "setVersion", "created_at" => "setCreatedAt", "updated_at" => "setUpdatedAt"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "location_id" => "getLocationId", "break_name" => "getBreakName", "expected_duration" => "getExpectedDuration", "is_paid" => "getIsPaid", "version" => "getVersion", "created_at" => "getCreatedAt", "updated_at" => "getUpdatedAt"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            } else {
                $this->id = NULL;
            }
            if (isset($data["location_id"])) {
                $this->location_id = $data["location_id"];
            } else {
                $this->location_id = NULL;
            }
            if (isset($data["break_name"])) {
                $this->break_name = $data["break_name"];
            } else {
                $this->break_name = NULL;
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
    public function getLocationId()
    {
        return $this->location_id;
    }
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    public function getBreakName()
    {
        return $this->break_name;
    }
    public function setBreakName($break_name)
    {
        $this->break_name = $break_name;
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