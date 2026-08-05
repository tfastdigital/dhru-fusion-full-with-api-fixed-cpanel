<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateShiftRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateShiftRequest implements \ArrayAccess
{
    /**
     * $idempotency_key Unique string value to insure the idempotency of the operation.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $shift The `Shift` to be created
     * @var \SquareConnect\Model\Shift
     */
    protected $shift = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["idempotency_key" => "string", "shift" => "\\SquareConnect\\Model\\Shift"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["idempotency_key" => "idempotency_key", "shift" => "shift"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["idempotency_key" => "setIdempotencyKey", "shift" => "setShift"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["idempotency_key" => "getIdempotencyKey", "shift" => "getShift"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["shift"])) {
                $this->shift = $data["shift"];
            } else {
                $this->shift = NULL;
            }
        }
    }
    public function getIdempotencyKey()
    {
        return $this->idempotency_key;
    }
    public function setIdempotencyKey($idempotency_key)
    {
        $this->idempotency_key = $idempotency_key;
        return $this;
    }
    public function getShift()
    {
        return $this->shift;
    }
    public function setShift($shift)
    {
        $this->shift = $shift;
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