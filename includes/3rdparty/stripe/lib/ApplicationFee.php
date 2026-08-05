<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class ApplicationFee
 *
 * @property string $id
 * @property string $object
 * @property string $account
 * @property int $amount
 * @property int $amount_refunded
 * @property string $application
 * @property string $balance_transaction
 * @property string $charge
 * @property int $created
 * @property string $currency
 * @property bool $livemode
 * @property string $originating_transaction
 * @property bool $refunded
 * @property Collection $refunds
 *
 * @package Stripe
 */
class ApplicationFee extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\NestedResource;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "application_fee";
    const PATH_REFUNDS = "/refunds";
    public function refund($params = NULL, $opts = NULL)
    {
        $this->refunds->create($params, $opts);
        $this->refresh();
        return $this;
    }
    public static function createRefund($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_REFUNDS, $params, $opts);
    }
    public static function retrieveRefund($id, $refundId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_REFUNDS, $refundId, $params, $opts);
    }
    public static function updateRefund($id, $refundId, $params = NULL, $opts = NULL)
    {
        return self::_updateNestedResource($id, static::PATH_REFUNDS, $refundId, $params, $opts);
    }
    public static function allRefunds($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_REFUNDS, $params, $opts);
    }
}

?>