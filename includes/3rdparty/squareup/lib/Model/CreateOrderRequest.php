<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateOrderRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateOrderRequest implements \ArrayAccess
{
    /**
     * $order The order to create. If this field is set, then the only other top-level field that can be set is the idempotency_key.
     * @var \SquareConnect\Model\Order
     */
    protected $order = NULL;
    /**
     * $idempotency_key A value you specify that uniquely identifies this order among orders you've created.  If you're unsure whether a particular order was created successfully, you can reattempt it with the same idempotency key without worrying about creating duplicate orders.  See [Idempotency](/basics/api101/idempotency) for more information.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $reference_id __Deprecated__: Please set the reference_id on the nested [order](#type-order) field instead.  An optional ID you can associate with the order for your own purposes (such as to associate the order with an entity ID in your own database).  This value cannot exceed 40 characters.
     * @var string
     */
    protected $reference_id = NULL;
    /**
     * $line_items __Deprecated__: Please set the line_items on the nested [order](#type-order) field instead.  The line items to associate with this order.  Each line item represents a different product to include in a purchase.
     * @var \SquareConnect\Model\CreateOrderRequestLineItem[]
     */
    protected $line_items = NULL;
    /**
     * $taxes __Deprecated__: Please set the taxes on the nested [order](#type-order) field instead.  The taxes to include on the order.
     * @var \SquareConnect\Model\CreateOrderRequestTax[]
     */
    protected $taxes = NULL;
    /**
     * $discounts __Deprecated__: Please set the discounts on the nested [order](#type-order) field instead.  The discounts to include on the order.
     * @var \SquareConnect\Model\CreateOrderRequestDiscount[]
     */
    protected $discounts = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["order" => "\\SquareConnect\\Model\\Order", "idempotency_key" => "string", "reference_id" => "string", "line_items" => "\\SquareConnect\\Model\\CreateOrderRequestLineItem[]", "taxes" => "\\SquareConnect\\Model\\CreateOrderRequestTax[]", "discounts" => "\\SquareConnect\\Model\\CreateOrderRequestDiscount[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["order" => "order", "idempotency_key" => "idempotency_key", "reference_id" => "reference_id", "line_items" => "line_items", "taxes" => "taxes", "discounts" => "discounts"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["order" => "setOrder", "idempotency_key" => "setIdempotencyKey", "reference_id" => "setReferenceId", "line_items" => "setLineItems", "taxes" => "setTaxes", "discounts" => "setDiscounts"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["order" => "getOrder", "idempotency_key" => "getIdempotencyKey", "reference_id" => "getReferenceId", "line_items" => "getLineItems", "taxes" => "getTaxes", "discounts" => "getDiscounts"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["order"])) {
                $this->order = $data["order"];
            } else {
                $this->order = NULL;
            }
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["reference_id"])) {
                $this->reference_id = $data["reference_id"];
            } else {
                $this->reference_id = NULL;
            }
            if (isset($data["line_items"])) {
                $this->line_items = $data["line_items"];
            } else {
                $this->line_items = NULL;
            }
            if (isset($data["taxes"])) {
                $this->taxes = $data["taxes"];
            } else {
                $this->taxes = NULL;
            }
            if (isset($data["discounts"])) {
                $this->discounts = $data["discounts"];
            } else {
                $this->discounts = NULL;
            }
        }
    }
    public function getOrder()
    {
        return $this->order;
    }
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
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
    public function getReferenceId()
    {
        return $this->reference_id;
    }
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }
    public function getLineItems()
    {
        return $this->line_items;
    }
    public function setLineItems($line_items)
    {
        $this->line_items = $line_items;
        return $this;
    }
    public function getTaxes()
    {
        return $this->taxes;
    }
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;
        return $this;
    }
    public function getDiscounts()
    {
        return $this->discounts;
    }
    public function setDiscounts($discounts)
    {
        $this->discounts = $discounts;
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