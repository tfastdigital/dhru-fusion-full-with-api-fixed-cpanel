<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateOrderRequestLineItem Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateOrderRequestLineItem implements \ArrayAccess
{
    /**
     * $name Only used for ad hoc line items. The name of the line item. This value cannot exceed 500 characters.  Do not provide a value for this field if you provide a value for `catalog_object_id`.
     * @var string
     */
    protected $name = NULL;
    /**
     * $quantity The quantity to purchase, as a string representation of a number.  This string must have a positive integer value.
     * @var string
     */
    protected $quantity = NULL;
    /**
     * $base_price_money The base price for a single unit of the line item.  `base_price_money` is required for ad hoc line items and variable priced [CatalogItemVariation](#type-catalogitemvariation)s. If both `catalog_object_id` and `base_price_money` are set, `base_price_money` will override the CatalogItemVariation's price.
     * @var \SquareConnect\Model\Money
     */
    protected $base_price_money = NULL;
    /**
     * $variation_name Only used for ad hoc line items. The variation name of the line item. This value cannot exceed 255 characters.  If this value is not set for an ad hoc line item, the default value of `Regular` is used.  Do not provide a value for this field if you provide a value for the `catalog_object_id`.
     * @var string
     */
    protected $variation_name = NULL;
    /**
     * $note The note of the line item. This value cannot exceed 500 characters.
     * @var string
     */
    protected $note = NULL;
    /**
     * $catalog_object_id Only used for Catalog line items. The catalog object ID for an existing [CatalogItemVariation](#type-catalogitemvariation).  Do not provide a value for this field if you provide a value for `name` and `base_price_money`.
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $modifiers Only used for Catalog line items. The modifiers to include on the line item.
     * @var \SquareConnect\Model\CreateOrderRequestModifier[]
     */
    protected $modifiers = NULL;
    /**
     * $taxes The taxes to include on the line item.
     * @var \SquareConnect\Model\CreateOrderRequestTax[]
     */
    protected $taxes = NULL;
    /**
     * $discounts The discounts to include on the line item.
     * @var \SquareConnect\Model\CreateOrderRequestDiscount[]
     */
    protected $discounts = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["name" => "string", "quantity" => "string", "base_price_money" => "\\SquareConnect\\Model\\Money", "variation_name" => "string", "note" => "string", "catalog_object_id" => "string", "modifiers" => "\\SquareConnect\\Model\\CreateOrderRequestModifier[]", "taxes" => "\\SquareConnect\\Model\\CreateOrderRequestTax[]", "discounts" => "\\SquareConnect\\Model\\CreateOrderRequestDiscount[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["name" => "name", "quantity" => "quantity", "base_price_money" => "base_price_money", "variation_name" => "variation_name", "note" => "note", "catalog_object_id" => "catalog_object_id", "modifiers" => "modifiers", "taxes" => "taxes", "discounts" => "discounts"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["name" => "setName", "quantity" => "setQuantity", "base_price_money" => "setBasePriceMoney", "variation_name" => "setVariationName", "note" => "setNote", "catalog_object_id" => "setCatalogObjectId", "modifiers" => "setModifiers", "taxes" => "setTaxes", "discounts" => "setDiscounts"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["name" => "getName", "quantity" => "getQuantity", "base_price_money" => "getBasePriceMoney", "variation_name" => "getVariationName", "note" => "getNote", "catalog_object_id" => "getCatalogObjectId", "modifiers" => "getModifiers", "taxes" => "getTaxes", "discounts" => "getDiscounts"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["quantity"])) {
                $this->quantity = $data["quantity"];
            } else {
                $this->quantity = NULL;
            }
            if (isset($data["base_price_money"])) {
                $this->base_price_money = $data["base_price_money"];
            } else {
                $this->base_price_money = NULL;
            }
            if (isset($data["variation_name"])) {
                $this->variation_name = $data["variation_name"];
            } else {
                $this->variation_name = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
            }
            if (isset($data["catalog_object_id"])) {
                $this->catalog_object_id = $data["catalog_object_id"];
            } else {
                $this->catalog_object_id = NULL;
            }
            if (isset($data["modifiers"])) {
                $this->modifiers = $data["modifiers"];
            } else {
                $this->modifiers = NULL;
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
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
    public function getBasePriceMoney()
    {
        return $this->base_price_money;
    }
    public function setBasePriceMoney($base_price_money)
    {
        $this->base_price_money = $base_price_money;
        return $this;
    }
    public function getVariationName()
    {
        return $this->variation_name;
    }
    public function setVariationName($variation_name)
    {
        $this->variation_name = $variation_name;
        return $this;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
    public function getCatalogObjectId()
    {
        return $this->catalog_object_id;
    }
    public function setCatalogObjectId($catalog_object_id)
    {
        $this->catalog_object_id = $catalog_object_id;
        return $this;
    }
    public function getModifiers()
    {
        return $this->modifiers;
    }
    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;
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