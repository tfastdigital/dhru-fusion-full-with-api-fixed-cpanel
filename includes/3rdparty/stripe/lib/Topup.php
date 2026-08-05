<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Topup
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property string $balance_transaction
 * @property int $created
 * @property string $currency
 * @property string $description
 * @property int $expected_availability_date
 * @property string $failure_code
 * @property string $failure_message
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property mixed $source
 * @property string $statement_descriptor
 * @property string $status
 * @property string $transfer_group
 *
 * @package Stripe
 */
class Topup extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "topup";
    const STATUS_CANCELED = "canceled";
    const STATUS_FAILED = "failed";
    const STATUS_PENDING = "pending";
    const STATUS_REVERSED = "reversed";
    const STATUS_SUCCEEDED = "succeeded";
    public function cancel($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/cancel";
        list($response, $opts) = $this->_request("post", $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>