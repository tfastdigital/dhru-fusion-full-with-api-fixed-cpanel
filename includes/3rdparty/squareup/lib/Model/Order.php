<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * Order Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Order implements \ArrayAccess
{
    /**
     * $id The order's unique ID.  This field is read-only.
     * @var string
     */
    protected $id = NULL;
    /**
     * $location_id The ID of the merchant location this order is associated with.
     * @var string
     */
    protected $location_id = NULL;
    /**
     * $reference_id A client specified identifier to associate an entity in another system with this order.
     * @var string
     */
    protected $reference_id = NULL;
    /**
     * $source The origination details of the order.
     * @var \SquareConnect\Model\OrderSource
     */
    protected $source = NULL;
    /**
     * $customer_id The [Customer](#type-customer) ID of the customer associated with the order.
     * @var string
     */
    protected $customer_id = NULL;
    /**
     * $line_items The line items included in the order.
     * @var \SquareConnect\Model\OrderLineItem[]
     */
    protected $line_items = NULL;
    /**
     * $taxes A list of taxes applied to this order. On read or retrieve, this list includes both order-level and item-level taxes. When creating an Order, set your order-level taxes in this list.
     * @var \SquareConnect\Model\OrderLineItemTax[]
     */
    protected $taxes = NULL;
    /**
     * $discounts A list of discounts applied to this order. On read or retrieve, this list includes both order-level and item-level discounts. When creating an Order, set your order-level discounts in this list.
     * @var \SquareConnect\Model\OrderLineItemDiscount[]
     */
    protected $discounts = NULL;
    /**
     * $service_charges A list of service charges applied to the order.
     * @var \SquareConnect\Model\OrderServiceCharge[]
     */
    protected $service_charges = NULL;
    /**
     * $fulfillments Details on order fulfillment.  Orders can only be created with at most one fulfillment. However, orders returned by the API may contain multiple fulfillments.
     * @var \SquareConnect\Model\OrderFulfillment[]
     */
    protected $fulfillments = NULL;
    /**
     * $returns Collection of items from sale Orders being returned in this one. Normally part of an Itemized Return or Exchange.  There will be exactly one `Return` object per sale Order being referenced.  This field is read-only.
     * @var \SquareConnect\Model\OrderReturn[]
     */
    protected $returns = NULL;
    /**
     * $return_amounts Rollup of returned money amounts.  This field is read-only.
     * @var \SquareConnect\Model\OrderMoneyAmounts
     */
    protected $return_amounts = NULL;
    /**
     * $net_amounts Net money amounts (sale money - return money).  This field is read-only.
     * @var \SquareConnect\Model\OrderMoneyAmounts
     */
    protected $net_amounts = NULL;
    /**
     * $rounding_adjustment A positive or negative rounding adjustment to the total of the order, commonly used to apply Cash Rounding when the minimum unit of account is smaller than the lowest physical denomination of currency.  This field is read-only.
     * @var \SquareConnect\Model\OrderRoundingAdjustment
     */
    protected $rounding_adjustment = NULL;
    /**
     * $tenders The Tenders which were used to pay for the Order. This field is read-only.
     * @var \SquareConnect\Model\Tender[]
     */
    protected $tenders = NULL;
    /**
     * $refunds The Refunds that are part of this Order. This field is read-only.
     * @var \SquareConnect\Model\Refund[]
     */
    protected $refunds = NULL;
    /**
     * $created_at Timestamp for when the order was created. In RFC 3339 format, e.g., \"2016-09-04T23:59:33.123Z\".  This field is read-only.
     * @var string
     */
    protected $created_at = NULL;
    /**
     * $updated_at Timestamp for when the order was last updated. In RFC 3339 format, e.g., \"2016-09-04T23:59:33.123Z\".  This field is read-only.
     * @var string
     */
    protected $updated_at = NULL;
    /**
     * $closed_at Timestamp for when the order was closed. In RFC 3339 format, e.g., \"2016-09-04T23:59:33.123Z\".  This field is read-only.
     * @var string
     */
    protected $closed_at = NULL;
    /**
     * $state The current state of the order. `OPEN`,`COMPLETED`,`CANCELED` See [OrderState](#type-orderstate) for possible values
     * @var string
     */
    protected $state = NULL;
    /**
     * $total_money The total amount of money to collect for the order.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_money = NULL;
    /**
     * $total_tax_money The total tax amount of money to collect for the order.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_tax_money = NULL;
    /**
     * $total_discount_money The total discount amount of money to collect for the order.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_discount_money = NULL;
    /**
     * $total_service_charge_money The total amount of money collected in service charges for the order.  Note: `total_service_charge_money` is the sum of `applied_money` fields for each individual service charge. Therefore, `total_service_charge_money` will only include inclusive tax amounts, not additive tax amounts.  This field is read-only.
     * @var \SquareConnect\Model\Money
     */
    protected $total_service_charge_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "location_id" => "string", "reference_id" => "string", "source" => "\\SquareConnect\\Model\\OrderSource", "customer_id" => "string", "line_items" => "\\SquareConnect\\Model\\OrderLineItem[]", "taxes" => "\\SquareConnect\\Model\\OrderLineItemTax[]", "discounts" => "\\SquareConnect\\Model\\OrderLineItemDiscount[]", "service_charges" => "\\SquareConnect\\Model\\OrderServiceCharge[]", "fulfillments" => "\\SquareConnect\\Model\\OrderFulfillment[]", "returns" => "\\SquareConnect\\Model\\OrderReturn[]", "return_amounts" => "\\SquareConnect\\Model\\OrderMoneyAmounts", "net_amounts" => "\\SquareConnect\\Model\\OrderMoneyAmounts", "rounding_adjustment" => "\\SquareConnect\\Model\\OrderRoundingAdjustment", "tenders" => "\\SquareConnect\\Model\\Tender[]", "refunds" => "\\SquareConnect\\Model\\Refund[]", "created_at" => "string", "updated_at" => "string", "closed_at" => "string", "state" => "string", "total_money" => "\\SquareConnect\\Model\\Money", "total_tax_money" => "\\SquareConnect\\Model\\Money", "total_discount_money" => "\\SquareConnect\\Model\\Money", "total_service_charge_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "location_id" => "location_id", "reference_id" => "reference_id", "source" => "source", "customer_id" => "customer_id", "line_items" => "line_items", "taxes" => "taxes", "discounts" => "discounts", "service_charges" => "service_charges", "fulfillments" => "fulfillments", "returns" => "returns", "return_amounts" => "return_amounts", "net_amounts" => "net_amounts", "rounding_adjustment" => "rounding_adjustment", "tenders" => "tenders", "refunds" => "refunds", "created_at" => "created_at", "updated_at" => "updated_at", "closed_at" => "closed_at", "state" => "state", "total_money" => "total_money", "total_tax_money" => "total_tax_money", "total_discount_money" => "total_discount_money", "total_service_charge_money" => "total_service_charge_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "location_id" => "setLocationId", "reference_id" => "setReferenceId", "source" => "setSource", "customer_id" => "setCustomerId", "line_items" => "setLineItems", "taxes" => "setTaxes", "discounts" => "setDiscounts", "service_charges" => "setServiceCharges", "fulfillments" => "setFulfillments", "returns" => "setReturns", "return_amounts" => "setReturnAmounts", "net_amounts" => "setNetAmounts", "rounding_adjustment" => "setRoundingAdjustment", "tenders" => "setTenders", "refunds" => "setRefunds", "created_at" => "setCreatedAt", "updated_at" => "setUpdatedAt", "closed_at" => "setClosedAt", "state" => "setState", "total_money" => "setTotalMoney", "total_tax_money" => "setTotalTaxMoney", "total_discount_money" => "setTotalDiscountMoney", "total_service_charge_money" => "setTotalServiceChargeMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "location_id" => "getLocationId", "reference_id" => "getReferenceId", "source" => "getSource", "customer_id" => "getCustomerId", "line_items" => "getLineItems", "taxes" => "getTaxes", "discounts" => "getDiscounts", "service_charges" => "getServiceCharges", "fulfillments" => "getFulfillments", "returns" => "getReturns", "return_amounts" => "getReturnAmounts", "net_amounts" => "getNetAmounts", "rounding_adjustment" => "getRoundingAdjustment", "tenders" => "getTenders", "refunds" => "getRefunds", "created_at" => "getCreatedAt", "updated_at" => "getUpdatedAt", "closed_at" => "getClosedAt", "state" => "getState", "total_money" => "getTotalMoney", "total_tax_money" => "getTotalTaxMoney", "total_discount_money" => "getTotalDiscountMoney", "total_service_charge_money" => "getTotalServiceChargeMoney"];
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
            if (isset($data["reference_id"])) {
                $this->reference_id = $data["reference_id"];
            } else {
                $this->reference_id = NULL;
            }
            if (isset($data["source"])) {
                $this->source = $data["source"];
            } else {
                $this->source = NULL;
            }
            if (isset($data["customer_id"])) {
                $this->customer_id = $data["customer_id"];
            } else {
                $this->customer_id = NULL;
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
            if (isset($data["service_charges"])) {
                $this->service_charges = $data["service_charges"];
            } else {
                $this->service_charges = NULL;
            }
            if (isset($data["fulfillments"])) {
                $this->fulfillments = $data["fulfillments"];
            } else {
                $this->fulfillments = NULL;
            }
            if (isset($data["returns"])) {
                $this->returns = $data["returns"];
            } else {
                $this->returns = NULL;
            }
            if (isset($data["return_amounts"])) {
                $this->return_amounts = $data["return_amounts"];
            } else {
                $this->return_amounts = NULL;
            }
            if (isset($data["net_amounts"])) {
                $this->net_amounts = $data["net_amounts"];
            } else {
                $this->net_amounts = NULL;
            }
            if (isset($data["rounding_adjustment"])) {
                $this->rounding_adjustment = $data["rounding_adjustment"];
            } else {
                $this->rounding_adjustment = NULL;
            }
            if (isset($data["tenders"])) {
                $this->tenders = $data["tenders"];
            } else {
                $this->tenders = NULL;
            }
            if (isset($data["refunds"])) {
                $this->refunds = $data["refunds"];
            } else {
                $this->refunds = NULL;
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
            if (isset($data["closed_at"])) {
                $this->closed_at = $data["closed_at"];
            } else {
                $this->closed_at = NULL;
            }
            if (isset($data["state"])) {
                $this->state = $data["state"];
            } else {
                $this->state = NULL;
            }
            if (isset($data["total_money"])) {
                $this->total_money = $data["total_money"];
            } else {
                $this->total_money = NULL;
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
            if (isset($data["total_service_charge_money"])) {
                $this->total_service_charge_money = $data["total_service_charge_money"];
            } else {
                $this->total_service_charge_money = NULL;
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
    public function getReferenceId()
    {
        return $this->reference_id;
    }
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
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
    public function getServiceCharges()
    {
        return $this->service_charges;
    }
    public function setServiceCharges($service_charges)
    {
        $this->service_charges = $service_charges;
        return $this;
    }
    public function getFulfillments()
    {
        return $this->fulfillments;
    }
    public function setFulfillments($fulfillments)
    {
        $this->fulfillments = $fulfillments;
        return $this;
    }
    public function getReturns()
    {
        return $this->returns;
    }
    public function setReturns($returns)
    {
        $this->returns = $returns;
        return $this;
    }
    public function getReturnAmounts()
    {
        return $this->return_amounts;
    }
    public function setReturnAmounts($return_amounts)
    {
        $this->return_amounts = $return_amounts;
        return $this;
    }
    public function getNetAmounts()
    {
        return $this->net_amounts;
    }
    public function setNetAmounts($net_amounts)
    {
        $this->net_amounts = $net_amounts;
        return $this;
    }
    public function getRoundingAdjustment()
    {
        return $this->rounding_adjustment;
    }
    public function setRoundingAdjustment($rounding_adjustment)
    {
        $this->rounding_adjustment = $rounding_adjustment;
        return $this;
    }
    public function getTenders()
    {
        return $this->tenders;
    }
    public function setTenders($tenders)
    {
        $this->tenders = $tenders;
        return $this;
    }
    public function getRefunds()
    {
        return $this->refunds;
    }
    public function setRefunds($refunds)
    {
        $this->refunds = $refunds;
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
    public function getClosedAt()
    {
        return $this->closed_at;
    }
    public function setClosedAt($closed_at)
    {
        $this->closed_at = $closed_at;
        return $this;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
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
    public function getTotalServiceChargeMoney()
    {
        return $this->total_service_charge_money;
    }
    public function setTotalServiceChargeMoney($total_service_charge_money)
    {
        $this->total_service_charge_money = $total_service_charge_money;
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