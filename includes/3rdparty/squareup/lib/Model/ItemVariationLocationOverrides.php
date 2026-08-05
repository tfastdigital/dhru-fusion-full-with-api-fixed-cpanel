<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ItemVariationLocationOverrides Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ItemVariationLocationOverrides implements \ArrayAccess
{
    /**
     * $location_id The ID of the [location](#type-location).
     * @var string
     */
    protected $location_id = NULL;
    /**
     * $price_money The price of the [CatalogItemVariation](#type-catalogitemvariation) at the given [location](#type-location), or blank for variable pricing.
     * @var \SquareConnect\Model\Money
     */
    protected $price_money = NULL;
    /**
     * $pricing_type The pricing type (fixed or variable) for the [CatalogItemVariation](#type-catalogitemvariation) at the given [location](#type-location). See [CatalogPricingType](#type-catalogpricingtype) for possible values
     * @var string
     */
    protected $pricing_type = NULL;
    /**
     * $track_inventory If `true`, inventory tracking is active for the [CatalogItemVariation](#type-catalogitemvariation) at this [location](#type-location).
     * @var bool
     */
    protected $track_inventory = NULL;
    /**
     * $inventory_alert_type Indicates whether the [CatalogItemVariation](#type-catalogitemvariation) displays an alert when its inventory quantity is less than or equal to its `inventory_alert_threshold`. See [InventoryAlertType](#type-inventoryalerttype) for possible values
     * @var string
     */
    protected $inventory_alert_type = NULL;
    /**
     * $inventory_alert_threshold If the inventory quantity for the variation is less than or equal to this value and `inventory_alert_type` is `LOW_QUANTITY`, the variation displays an alert in the merchant dashboard.  This value is always an integer.
     * @var int
     */
    protected $inventory_alert_threshold = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["location_id" => "string", "price_money" => "\\SquareConnect\\Model\\Money", "pricing_type" => "string", "track_inventory" => "bool", "inventory_alert_type" => "string", "inventory_alert_threshold" => "int"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["location_id" => "location_id", "price_money" => "price_money", "pricing_type" => "pricing_type", "track_inventory" => "track_inventory", "inventory_alert_type" => "inventory_alert_type", "inventory_alert_threshold" => "inventory_alert_threshold"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["location_id" => "setLocationId", "price_money" => "setPriceMoney", "pricing_type" => "setPricingType", "track_inventory" => "setTrackInventory", "inventory_alert_type" => "setInventoryAlertType", "inventory_alert_threshold" => "setInventoryAlertThreshold"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["location_id" => "getLocationId", "price_money" => "getPriceMoney", "pricing_type" => "getPricingType", "track_inventory" => "getTrackInventory", "inventory_alert_type" => "getInventoryAlertType", "inventory_alert_threshold" => "getInventoryAlertThreshold"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["location_id"])) {
                $this->location_id = $data["location_id"];
            } else {
                $this->location_id = NULL;
            }
            if (isset($data["price_money"])) {
                $this->price_money = $data["price_money"];
            } else {
                $this->price_money = NULL;
            }
            if (isset($data["pricing_type"])) {
                $this->pricing_type = $data["pricing_type"];
            } else {
                $this->pricing_type = NULL;
            }
            if (isset($data["track_inventory"])) {
                $this->track_inventory = $data["track_inventory"];
            } else {
                $this->track_inventory = NULL;
            }
            if (isset($data["inventory_alert_type"])) {
                $this->inventory_alert_type = $data["inventory_alert_type"];
            } else {
                $this->inventory_alert_type = NULL;
            }
            if (isset($data["inventory_alert_threshold"])) {
                $this->inventory_alert_threshold = $data["inventory_alert_threshold"];
            } else {
                $this->inventory_alert_threshold = NULL;
            }
        }
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
    public function getPriceMoney()
    {
        return $this->price_money;
    }
    public function setPriceMoney($price_money)
    {
        $this->price_money = $price_money;
        return $this;
    }
    public function getPricingType()
    {
        return $this->pricing_type;
    }
    public function setPricingType($pricing_type)
    {
        $this->pricing_type = $pricing_type;
        return $this;
    }
    public function getTrackInventory()
    {
        return $this->track_inventory;
    }
    public function setTrackInventory($track_inventory)
    {
        $this->track_inventory = $track_inventory;
        return $this;
    }
    public function getInventoryAlertType()
    {
        return $this->inventory_alert_type;
    }
    public function setInventoryAlertType($inventory_alert_type)
    {
        $this->inventory_alert_type = $inventory_alert_type;
        return $this;
    }
    public function getInventoryAlertThreshold()
    {
        return $this->inventory_alert_threshold;
    }
    public function setInventoryAlertThreshold($inventory_alert_threshold)
    {
        $this->inventory_alert_threshold = $inventory_alert_threshold;
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