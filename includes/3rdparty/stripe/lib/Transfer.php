<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Transfer
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $amount_reversed
 * @property string $balance_transaction
 * @property int $created
 * @property string $currency
 * @property string $description
 * @property string $destination
 * @property string $destination_payment
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property Collection $reversals
 * @property bool $reversed
 * @property string $source_transaction
 * @property string $source_type
 * @property string $transfer_group
 *
 * @package Stripe
 */
class Transfer extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\NestedResource;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "transfer";
    const PATH_REVERSALS = "/reversals";
    const SOURCE_TYPE_ALIPAY_ACCOUNT = "alipay_account";
    const SOURCE_TYPE_BANK_ACCOUNT = "bank_account";
    const SOURCE_TYPE_CARD = "card";
    const SOURCE_TYPE_FINANCING = "financing";
    public function reverse($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/reversals";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function cancel()
    {
        $url = $this->instanceUrl() . "/cancel";
        list($response, $opts) = $this->_request("post", $url);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public static function createReversal($id, $params = NULL, $opts = NULL)
    {
        return self::_createNestedResource($id, static::PATH_REVERSALS, $params, $opts);
    }
    public static function retrieveReversal($id, $reversalId, $params = NULL, $opts = NULL)
    {
        return self::_retrieveNestedResource($id, static::PATH_REVERSALS, $reversalId, $params, $opts);
    }
    public static function updateReversal($id, $reversalId, $params = NULL, $opts = NULL)
    {
        return self::_updateNestedResource($id, static::PATH_REVERSALS, $reversalId, $params, $opts);
    }
    public static function allReversals($id, $params = NULL, $opts = NULL)
    {
        return self::_allNestedResources($id, static::PATH_REVERSALS, $params, $opts);
    }
}

?>