<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderLineItem Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderLineItem implements \ArrayAccess
{
    /**
     * $uid Unique ID that identifies the line item only within this order.  This field is read-only.
     * @var string
     */
    protected $uid = NULL;
    /**
     * $name The name of the line item.
     * @var string
     */
    protected $name = NULL;
    /**
     * $quantity The quantity purchased, formatted as a decimal number. For example: `\"3\"`.  Line items with a `quantity_unit` can have non-integer quantities. For example: `\"1.70000\"`.  Orders Hub and older versions of Connect do not support non-integer quantities. See [Decimal quantities with Orders hub and older versions of Connect](/more-apis/orders/overview#decimal-quantities).
     * @var string
     */
    protected $quantity = NULL;
    /**
     * $quantity_unit The unit and precision that this line item's quantity is measured in.
     * @var \SquareConnect\Model\OrderQuantityUnit
     */
    protected $quantity_unit = NULL;
    /**
     * $note The note of the line item.
     * @var string
     */
    protected $note = NULL;
    /**
     * $catalog_object_id The [CatalogItemVariation](#type-catalogitemvariation) id applied to this line item.
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $variation_name The name of the variation applied to this line item.
     * @var string
     */
    protected $variation_name = NULL;
    /**
     * $modifiers The [CatalogModifier](#type-catalogmodifier)s applied to this line item.
     * @var \SquareConnect\Model\OrderLineItemModifier[]
     */
    protected $modifiers = NULL;
    /**
     * $taxes A list of taxes applied to this line item. On read or retrieve, this list includes both item-level taxes and any order-level taxes apportioned to this item. When creating an Order, set your item-level taxes in this list.
     * @var \SquareConnect\Model\OrderLineItemTax[]
     */
    protected $taxes = NULL;
    /**
     * $discounts A list of discounts applied to this line item. On read or retrieve, this list includes both item-level discounts and any order-level discounts apportioned to this item. When creating an Order, set your item-level discounts in this list.
     * @var \SquareConnect\Model\OrderLineItemDiscount[]
     */
    protected $discounts = NULL;
    /**
     * $base_price_money The base price for a single unit of the line item.
     * @var \SquareConnect\Model\Money
     */
    protected $base_price_money = NULL;
    /**
     * $variation_total_price_money The total price of all item variations sold in this line item. Calculated as `base_price_money` multiplied by `quantity`. Does not include modifiers.
     * @var \SquareConnect\Model\Money
     */
    protected $variation_total_price_money = NULL;
    /**
     * $gross_sales_money The amount of money made in gross sales for this line item. Calculated as the sum of the variation's total price and each modifier's total price.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $gross_sales_money = NULL;
    /**
     * $total_tax_money The total tax amount of money to collect for the line item.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_tax_money = NULL;
    /**
     * $total_discount_money The total discount amount of money to collect for the line item.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_discount_money = NULL;
    /**
     * $total_money The total amount of money to collect for this line item.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["uid" => "string", "name" => "string", "quantity" => "string", "quantity_unit" => "\\SquareConnect\\Model\\OrderQuantityUnit", "note" => "string", "catalog_object_id" => "string", "variation_name" => "string", "modifiers" => "\\SquareConnect\\Model\\OrderLineItemModifier[]", "taxes" => "\\SquareConnect\\Model\\OrderLineItemTax[]", "discounts" => "\\SquareConnect\\Model\\OrderLineItemDiscount[]", "base_price_money" => "\\SquareConnect\\Model\\Money", "variation_total_price_money" => "\\SquareConnect\\Model\\Money", "gross_sales_money" => "\\SquareConnect\\Model\\Money", "total_tax_money" => "\\SquareConnect\\Model\\Money", "total_discount_money" => "\\SquareConnect\\Model\\Money", "total_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["uid" => "uid", "name" => "name", "quantity" => "quantity", "quantity_unit" => "quantity_unit", "note" => "note", "catalog_object_id" => "catalog_object_id", "variation_name" => "variation_name", "modifiers" => "modifiers", "taxes" => "taxes", "discounts" => "discounts", "base_price_money" => "base_price_money", "variation_total_price_money" => "variation_total_price_money", "gross_sales_money" => "gross_sales_money", "total_tax_money" => "total_tax_money", "total_discount_money" => "total_discount_money", "total_money" => "total_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["uid" => "setUid", "name" => "setName", "quantity" => "setQuantity", "quantity_unit" => "setQuantityUnit", "note" => "setNote", "catalog_object_id" => "setCatalogObjectId", "variation_name" => "setVariationName", "modifiers" => "setModifiers", "taxes" => "setTaxes", "discounts" => "setDiscounts", "base_price_money" => "setBasePriceMoney", "variation_total_price_money" => "setVariationTotalPriceMoney", "gross_sales_money" => "setGrossSalesMoney", "total_tax_money" => "setTotalTaxMoney", "total_discount_money" => "setTotalDiscountMoney", "total_money" => "setTotalMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["uid" => "getUid", "name" => "getName", "quantity" => "getQuantity", "quantity_unit" => "getQuantityUnit", "note" => "getNote", "catalog_object_id" => "getCatalogObjectId", "variation_name" => "getVariationName", "modifiers" => "getModifiers", "taxes" => "getTaxes", "discounts" => "getDiscounts", "base_price_money" => "getBasePriceMoney", "variation_total_price_money" => "getVariationTotalPriceMoney", "gross_sales_money" => "getGrossSalesMoney", "total_tax_money" => "getTotalTaxMoney", "total_discount_money" => "getTotalDiscountMoney", "total_money" => "getTotalMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["uid"])) {
                $this->uid = $data["uid"];
            } else {
                $this->uid = NULL;
            }
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
            if (isset($data["quantity_unit"])) {
                $this->quantity_unit = $data["quantity_unit"];
            } else {
                $this->quantity_unit = NULL;
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
            if (isset($data["variation_name"])) {
                $this->variation_name = $data["variation_name"];
            } else {
                $this->variation_name = NULL;
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
            if (isset($data["base_price_money"])) {
                $this->base_price_money = $data["base_price_money"];
            } else {
                $this->base_price_money = NULL;
            }
            if (isset($data["variation_total_price_money"])) {
                $this->variation_total_price_money = $data["variation_total_price_money"];
            } else {
                $this->variation_total_price_money = NULL;
            }
            if (isset($data["gross_sales_money"])) {
                $this->gross_sales_money = $data["gross_sales_money"];
            } else {
                $this->gross_sales_money = NULL;
            }
            if (isset($data["total_tax_money"])) {
                $this->total_tax_money = $data["total_tax_money"];
            } else {
                $this->total_tax_money = NULL;
            }
            if (isset($data["total_discount_money"])) {
                $this->total_discount_money = $data["total_discount_money"];
            } else {
                $this->total_discount_money = NULL;
            }
            if (isset($data["total_money"])) {
                $this->total_money = $data["total_money"];
            } else {
                $this->total_money = NULL;
            }
        }
    }
    public function getUid()
    {
        return $this->uid;
    }
    public function setUid($uid)
    {
        $this->uid = $uid;
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
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
    public function getQuantityUnit()
    {
        return $this->quantity_unit;
    }
    public function setQuantityUnit($quantity_unit)
    {
        $this->quantity_unit = $quantity_unit;
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
    public function getVariationName()
    {
        return $this->variation_name;
    }
    public function setVariationName($variation_name)
    {
        $this->variation_name = $variation_name;
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
    public function getBasePriceMoney()
    {
        return $this->base_price_money;
    }
    public function setBasePriceMoney($base_price_money)
    {
        $this->base_price_money = $base_price_money;
        return $this;
    }
    public function getVariationTotalPriceMoney()
    {
        return $this->variation_total_price_money;
    }
    public function setVariationTotalPriceMoney($variation_total_price_money)
    {
        $this->variation_total_price_money = $variation_total_price_money;
        return $this;
    }
    public function getGrossSalesMoney()
    {
        return $this->gross_sales_money;
    }
    public function setGrossSalesMoney($gross_sales_money)
    {
        $this->gross_sales_money = $gross_sales_money;
        return $this;
    }
    public function getTotalTaxMoney()
    {
        return $this->total_tax_money;
    }
    public function setTotalTaxMoney($total_tax_money)
    {
        $this->total_tax_money = $total_tax_money;
        return $this;
    }
    public function getTotalDiscountMoney()
    {
        return $this->total_discount_money;
    }
    public function setTotalDiscountMoney($total_discount_money)
    {
        $this->total_discount_money = $total_discount_money;
        return $this;
    }
    public function getTotalMoney()
    {
        return $this->total_money;
    }
    public function setTotalMoney($total_money)
    {
        $this->total_money = $total_money;
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