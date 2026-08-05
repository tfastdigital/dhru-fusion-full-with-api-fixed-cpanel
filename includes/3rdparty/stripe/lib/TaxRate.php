<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class TaxRate
 *
 * @property string $id
 * @property string $object
 * @property bool $active
 * @property int $created
 * @property string $description
 * @property string $display_name
 * @property bool $inclusive
 * @property string $jurisdiction
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property float $percentage
 *
 * @package Stripe
 */
class TaxRate extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "tax_rate";
}

?>