<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateCheckoutResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateCheckoutResponse implements \ArrayAccess
{
    /**
     * $checkout The newly created checkout. If the same request was made with the same idempotency_key, this will be the checkout created with the idempotency_key.
     * @var \SquareConnect\Model\Checkout
     */
    protected $checkout = NULL;
    /**
     * $errors Any errors that occurred during the request.
     * @var \SquareConnect\Model\Error[]
     */
    protected $errors = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["checkout" => "\\SquareConnect\\Model\\Checkout", "errors" => "\\SquareConnect\\Model\\Error[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["checkout" => "checkout", "errors" => "errors"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["checkout" => "setCheckout", "errors" => "setErrors"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["checkout" => "getCheckout", "errors" => "getErrors"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["checkout"])) {
                $this->checkout = $data["checkout"];
            } else {
                $this->checkout = NULL;
            }
            if (isset($data["errors"])) {
                $this->errors = $data["errors"];
            } else {
                $this->errors = NULL;
            }
        }
    }
    public function getCheckout()
    {
        return $this->checkout;
    }
    public function setCheckout($checkout)
    {
        $this->checkout = $checkout;
        return $this;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function setErrors($errors)
    {
        $this->errors = $errors;
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