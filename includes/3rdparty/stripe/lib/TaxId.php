<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class TaxId
 *
 * @package Stripe
 *
 * @property string $id
 * @property string $object
 * @property string $country
 * @property int $created
 * @property string $customer
 * @property bool $deleted
 * @property bool $livemode
 * @property string $type
 * @property string $value
 * @property mixed $verification
 */
class TaxId extends ApiResource
{
    use ApiOperations\Delete;
    const OBJECT_NAME = "tax_id";
    const TYPE_AU_ABN = "au_abn";
    const TYPE_EU_VAT = "eu_vat";
    const TYPE_NZ_GST = "nz_gst";
    const TYPE_UNKNOWN = "unknown";
    const VERIFICATION_STATUS_PENDING = "pending";
    const VERIFICATION_STATUS_UNAVAILABLE = "unavailable";
    const VERIFICATION_STATUS_UNVERIFIED = "unverified";
    const VERIFICATION_STATUS_VERIFIED = "verified";
    public function instanceUrl()
    {
        $id = $this["id"];
        $customer = $this["customer"];
        if (!$id) {
            throw new Error\InvalidRequest("Could not determine which URL to request: class instance has invalid ID: " . $id, NULL);
        }
        $id = Util\Util::utf8($id);
        $customer = Util\Util::utf8($customer);
        $base = Customer::classUrl();
        $customerExtn = urlencode($customer);
        $extn = urlencode($id);
        return $base . "/" . $customerExtn . "/tax_ids/" . $extn;
    }
    public static function retrieve($_id, $_opts = NULL)
    {
        $msg = "Tax Ids cannot be accessed without a customer ID. Retrieve a Tax Id using Customer::retrieveTaxId('tax_id') instead.";
        throw new Error\InvalidRequest($msg, NULL);
    }
}

?>