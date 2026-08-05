<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderMoneyAmounts Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderMoneyAmounts implements \ArrayAccess
{
    /**
     * $total_money Total money.
     * @var \SquareConnect\Model\Money
     */
    protected $total_money = NULL;
    /**
     * $tax_money Money associated with taxes.
     * @var \SquareConnect\Model\Money
     */
    protected $tax_money = NULL;
    /**
     * $discount_money Money associated with discounts.
     * @var \SquareConnect\Model\Money
     */
    protected $discount_money = NULL;
    /**
     * $tip_money Money associated with tips.
     * @var \SquareConnect\Model\Money
     */
    protected $tip_money = NULL;
    /**
     * $service_charge_money Money associated with service charges.
     * @var \SquareConnect\Model\Money
     */
    protected $service_charge_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["total_money" => "\\SquareConnect\\Model\\Money", "tax_money" => "\\SquareConnect\\Model\\Money", "discount_money" => "\\SquareConnect\\Model\\Money", "tip_money" => "\\SquareConnect\\Model\\Money", "service_charge_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["total_money" => "total_money", "tax_money" => "tax_money", "discount_money" => "discount_money", "tip_money" => "tip_money", "service_charge_money" => "service_charge_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["total_money" => "setTotalMoney", "tax_money" => "setTaxMoney", "discount_money" => "setDiscountMoney", "tip_money" => "setTipMoney", "service_charge_money" => "setServiceChargeMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["total_money" => "getTotalMoney", "tax_money" => "getTaxMoney", "discount_money" => "getDiscountMoney", "tip_money" => "getTipMoney", "service_charge_money" => "getServiceChargeMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["total_money"])) {
                $this->total_money = $data["total_money"];
            } else {
                $this->total_money = NULL;
            }
            if (isset($data["tax_money"])) {
                $this->tax_money = $data["tax_money"];
            } else {
                $this->tax_money = NULL;
            }
            if (isset($data["discount_money"])) {
                $this->discount_money = $data["discount_money"];
            } else {
                $this->discount_money = NULL;
            }
            if (isset($data["tip_money"])) {
                $this->tip_money = $data["tip_money"];
            } else {
                $this->tip_money = NULL;
            }
            if (isset($data["service_charge_money"])) {
                $this->service_charge_money = $data["service_charge_money"];
            } else {
                $this->service_charge_money = NULL;
            }
        }
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
    public function getTaxMoney()
    {
        return $this->tax_money;
    }
    public function setTaxMoney($tax_money)
    {
        $this->tax_money = $tax_money;
        return $this;
    }
    public function getDiscountMoney()
    {
        return $this->discount_money;
    }
    public function setDiscountMoney($discount_money)
    {
        $this->discount_money = $discount_money;
        return $this;
    }
    public function getTipMoney()
    {
        return $this->tip_money;
    }
    public function setTipMoney($tip_money)
    {
        $this->tip_money = $tip_money;
        return $this;
    }
    public function getServiceChargeMoney()
    {
        return $this->service_charge_money;
    }
    public function setServiceChargeMoney($service_charge_money)
    {
        $this->service_charge_money = $service_charge_money;
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