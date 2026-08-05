<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderFulfillmentRecipient Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderFulfillmentRecipient implements \ArrayAccess
{
    /**
     * $customer_id The Customer ID of the customer associated with the fulfillment.  If customer_id is provided, the corresponding recipient information fields (`display_name`, `email_address`, and `phone_number`) are automatically populated from the relevant customer profile. If the targeted profile information does not contain the necessary required information, the request will result in an error.
     * @var string
     */
    protected $customer_id = NULL;
    /**
     * $display_name The display name of the fulfillment recipient.  If provided, overrides the value from customer profile indicated by customer_id.
     * @var string
     */
    protected $display_name = NULL;
    /**
     * $email_address The email address of the fulfillment recipient.  If provided, overrides the value from customer profile indicated by customer_id.
     * @var string
     */
    protected $email_address = NULL;
    /**
     * $phone_number The phone number of the fulfillment recipient.  If provided, overrides the value from customer profile indicated by customer_id.
     * @var string
     */
    protected $phone_number = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["customer_id" => "string", "display_name" => "string", "email_address" => "string", "phone_number" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["customer_id" => "customer_id", "display_name" => "display_name", "email_address" => "email_address", "phone_number" => "phone_number"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["customer_id" => "setCustomerId", "display_name" => "setDisplayName", "email_address" => "setEmailAddress", "phone_number" => "setPhoneNumber"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["customer_id" => "getCustomerId", "display_name" => "getDisplayName", "email_address" => "getEmailAddress", "phone_number" => "getPhoneNumber"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["customer_id"])) {
                $this->customer_id = $data["customer_id"];
            } else {
                $this->customer_id = NULL;
            }
            if (isset($data["display_name"])) {
                $this->display_name = $data["display_name"];
            } else {
                $this->display_name = NULL;
            }
            if (isset($data["email_address"])) {
                $this->email_address = $data["email_address"];
            } else {
                $this->email_address = NULL;
            }
            if (isset($data["phone_number"])) {
                $this->phone_number = $data["phone_number"];
            } else {
                $this->phone_number = NULL;
            }
        }
    }
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
        return $this;
    }
    public function getDisplayName()
    {
        return $this->display_name;
    }
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
        return $this;
    }
    public function getEmailAddress()
    {
        return $this->email_address;
    }
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
        return $this;
    }
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
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