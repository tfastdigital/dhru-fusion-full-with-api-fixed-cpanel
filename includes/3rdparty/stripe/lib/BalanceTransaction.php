<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class BalanceTransaction
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $available_on
 * @property int $created
 * @property string $currency
 * @property string $description
 * @property float $exchange_rate
 * @property int $fee
 * @property mixed $fee_details
 * @property int $net
 * @property string $source
 * @property string $status
 * @property string $type
 *
 * @package Stripe
 */
class BalanceTransaction extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "balance_transaction";
    public static function classUrl()
    {
        return "/v1/balance/history";
    }
}

?>