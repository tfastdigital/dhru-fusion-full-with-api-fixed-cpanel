<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Customer
 *
 * @property string $id
 * @property string $object
 * @property int $account_balance
 * @property mixed $address
 * @property string $created
 * @property string $currency
 * @property string $default_source
 * @property bool $delinquent
 * @property string $description
 * @property Discount $discount
 * @property string $email
 * @property string $invoice_prefix
 * @property mixed $invoice_settings
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property string $name
 * @property string $phone
 * @property string[] preferred_locales
 * @property mixed $shipping
 * @property Collection $sources
 * @property Collection $subscriptions
 * @property Collection $tax_ids
 *
 * @package Stripe
 */
class Customer extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\NestedResource;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "customer";
    const TAX_EXEMPT_NONE = "none";
    const TAX_EXEMPT_EXEMPT = "exempt";
    const TAX_EXEMPT_REVERSE = "reverse";
    const PATH_SOURCES = "/sources";
    const PATH_TAX_IDS = "/tax_ids";
    public static function getSavedNestedResources()
    {
        static $savedNestedResources = NULL;
        if ($savedNestedResources === NULL) {
            $savedNestedResources = new Util\Set(["source"]);
        }
        return $savedNestedResources;
    }
    public function addInvoiceItem($params = NULL)
    {
        $params = $params ?: [];
        $params["customer"] = $this->id;
        $ii = InvoiceItem::create($params, $this->_opts);
        return $ii;
    }
    public function invoices($params = NULL)
    {
        $params = $params ?: [];
        $params["customer"] = $this->id;
        $invoices = Invoice::all($params, $this->_opts);
        return $invoices;
    }
    public function invoiceItems($params = NULL)
    {
        $params = $params ?: [];
        $params["customer"] = $this->id;
        $iis = InvoiceItem::all($params, $this->_opts);
        return $iis;
    }
    public function charges($params = NULL)
    {
        $params = $params ?: [];
        $params["customer"] = $this->id;
        $charges = Charge::all($params, $this->_opts);
        return $charges;
    }
    public function updateSubscription($params = NULL)
    {
        $url = $this->instanceUrl() . "/subscription";
        list($response, $opts) = $this->_request("post", $url, $params);
        $this->refreshFrom(["subscription" => $response], $opts, true);
        return $this->subscription;
    }
    public function cancelSubscription($params = NULL)
    {
        $url = $this->instanceUrl() . "/subscription";
        list($response, $opts) = $this->_request("delete", $url, $params);
        $this->refreshFrom(["subscription" => $response], $opts, true);
        return $this->subscription;
    }
    public function deleteDiscount()
    {
        $url = $this->instanceUrl() . "/discount";
        list($response, $opts) = $this->_request("delete", $url);
        $this->refreshFrom(["discount" => NULL], $opts, true);
    }
    public static function createSource($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_SOURCES, $params, $opts);
    }
    public static function retrieveSource($id, $sourceId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_SOURCES, $sourceId, $params, $opts);
    }
    public static function updateSource($id, $sourceId, $params = NULL, $opts = NULL)
    {
        return self::_updateNestedResource($id, static::PATH_SOURCES, $sourceId, $params, $opts);
    }
    public static function deleteSource($id, $sourceId, $params = NULL, $opts = NULL)
    {
        return self::_deleteNestedResource($id, static::PATH_SOURCES, $sourceId, $params, $opts);
    }
    public static function allSources($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_SOURCES, $params, $opts);
    }
    public static function createTaxId($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_TAX_IDS, $params, $opts);
    }
    public static function retrieveTaxId($id, $taxIdId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_TAX_IDS, $taxIdId, $params, $opts);
    }
    public static function deleteTaxId($id, $taxIdId, $params = NULL, $opts = NULL)
    {
        return self::_deleteNestedResource($id, static::PATH_TAX_IDS, $taxIdId, $params, $opts);
    }
    public static function allTaxIds($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_TAX_IDS, $params, $opts);
    }
}

?>