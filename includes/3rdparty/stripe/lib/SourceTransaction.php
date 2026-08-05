<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class SourceTransaction
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $created
 * @property string $customer_data
 * @property string $currency
 * @property string $type
 * @property mixed $ach_credit_transfer
 *
 * @package Stripe
 */
class SourceTransaction extends ApiResource
{
    const OBJECT_NAME = "source_transaction";
}

?>